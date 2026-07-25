<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\StudentImage;
use App\Models\StudentFile;
use App\Models\StudentAttendance;

class PersonalController extends Controller
{
    public function form(Request $request)
    {
        return view('form');
    }

    public function welcomeDashboard()
    {
        return view('welcome-dashboard');
    }

    public function studentData(Request $request)
    {
        // Har student ka total attendance days aur present days nikaalne wali subquery
        $attendanceStats = DB::table('tbl_student_attendance')
            ->select(
                'student_id',
                DB::raw('COUNT(*) as total_days'),
                DB::raw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_days")
            )
            ->groupBy('student_id');

        $personalData = Student::leftJoin('tbl_student_images', 'tbl_personal_details.id', '=', 'tbl_student_images.student_id')
            ->leftJoin('tbl_student_files', 'tbl_personal_details.id', '=', 'tbl_student_files.student_id')
            ->leftJoinSub($attendanceStats, 'attendance_stats', function ($join) {
                $join->on('tbl_personal_details.id', '=', 'attendance_stats.student_id');
            })
            ->select(
                'tbl_personal_details.id',
                'tbl_personal_details.name',
                'tbl_personal_details.email',
                'tbl_personal_details.number',
                DB::raw('GROUP_CONCAT(DISTINCT tbl_student_images.id) as image_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT tbl_student_images.image_path) as image_paths'),
                DB::raw('GROUP_CONCAT(DISTINCT tbl_student_files.id) as file_ids'),
                DB::raw('GROUP_CONCAT(DISTINCT tbl_student_files.file_name) as file_names'),
                DB::raw('GROUP_CONCAT(DISTINCT tbl_student_files.file_path) as file_paths'),
                'attendance_stats.total_days',
                'attendance_stats.present_days'
            )
            ->groupBy(
                'tbl_personal_details.id',
                'tbl_personal_details.name',
                'tbl_personal_details.email',
                'tbl_personal_details.number',
                'attendance_stats.total_days',
                'attendance_stats.present_days'
            )
            ->orderBy('tbl_personal_details.id', 'desc')
            ->paginate(5);

        return view('student-data', compact('personalData'));
    }

    public function dashboard(Request $request)
    {
        $totalStudents = Student::count();

        $chartData = Student::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = [];
        $chartValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');

            $found = $chartData->firstWhere('date', $date);
            $chartValues[] = $found ? $found->count : 0;
        }

        $todayCount = Student::whereDate('created_at', today())->count();

        $thisMonthCount = Student::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthCount = Student::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonthCount > 0) {
            $growthPercent = round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100, 1);
        } elseif ($thisMonthCount > 0) {
            $growthPercent = 100;
        } else {
            $growthPercent = 0;
        }

        $last30DaysCount = Student::where('created_at', '>=', now()->subDays(30))->count();
        $averagePerDay = round($last30DaysCount / 30, 1);

        $latestStudents = Student::orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard-students', compact(
            'totalStudents',
            'chartLabels',
            'chartValues',
            'todayCount',
            'thisMonthCount',
            'lastMonthCount',
            'growthPercent',
            'averagePerDay',
            'latestStudents'
        ));
    }

    public function formSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_personal_details,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
            'phone' => 'required|numeric|digits:10',
        ], [
            'name.required' => 'Naam field zaroori hai.',
            'name.max' => 'Naam 255 characters se zyada nahi ho sakta.',

            'email.required' => 'Email field zaroori hai.',
            'email.email' => 'Sahi email address dalen.',
            'email.unique' => 'Ye email pehle se registered hai.',

            'password.required' => 'Password field zaroori hai.',
            'password.min' => 'Password kam se kam 8 characters ka hona chahiye.',
            'password.regex' => 'Password mein kam se kam 1 uppercase, 1 lowercase, 1 number aur 1 special character (@$!%*?&) hona chahiye.',

            'phone.required' => 'Phone number zaroori hai.',
            'phone.numeric' => 'Phone number sirf digits mein hona chahiye.',
            'phone.digits' => 'Phone number 10 digit ka hona chahiye.',
        ]);

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'number' => $request->phone,
        ]);

        // Agar koi purana session already logged-in hai, use forcefully khatam kar do
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function edit($id)
    {
        $personalData = Student::find($id);

        if (!$personalData) {
            return redirect()->route('student-data')->with('error', 'Record not found');
        }

        return view('edit', compact('personalData'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('student-data')->with('error', 'Record not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_personal_details,email,' . $id,
            'phone' => 'required|numeric|digits:10',
        ], [
            'name.required' => 'Naam field zaroori hai.',
            'email.required' => 'Email field zaroori hai.',
            'email.email' => 'Sahi email address dalen.',
            'email.unique' => 'Ye email pehle se registered hai.',
            'phone.required' => 'Phone number zaroori hai.',
            'phone.numeric' => 'Phone number sirf digits mein hona chahiye.',
            'phone.digits' => 'Phone number 10 digit ka hona chahiye.',
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->phone,
        ]);

        return redirect()->route('student-data')->with('success', 'Record updated successfully');
    }

    public function delete($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return redirect()->route('student-data')->with('error', 'Record not found');
        }

        $student->delete();

        return redirect()->route('student-data')->with('success', 'Record deleted successfully');
    }

    public function uploadImageForm($id)
    {
        $student = Student::findOrFail($id);
        return view('upload-image', compact('student'));
    }

    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:2048',
        ], [
            'images.required' => 'Kam se kam ek image select karein.',
            'images.*.image' => 'Har file ek valid image honi chahiye.',
            'images.*.max' => 'Har image 2MB se zyada nahi honi chahiye.',
        ]);

        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store('student_images', 'public');

            StudentImage::create([
                'student_id' => $id,
                'image_path' => $path,
            ]);
        }

        $count = count($request->file('images'));

        return redirect()->route('student-data')->with('success', $count . ' image(s) uploaded successfully!');
    }

    public function deleteImage($id)
    {
        $image = StudentImage::find($id);

        if (!$image) {
            return redirect()->route('student-data')->with('error', 'Image not found');
        }

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->route('student-data')->with('success', 'Image deleted successfully!');
    }

    public function uploadFileForm($id)
    {
        $student = Student::findOrFail($id);
        return view('upload-file', compact('student'));
    }

    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'documents' => 'required|array|min:1',
            'documents.*' => 'mimes:pdf,doc,docx|max:5120',
        ], [
            'documents.required' => 'Kam se kam ek file select karein.',
            'documents.*.mimes' => 'Sirf PDF, DOC, DOCX files allowed hain.',
            'documents.*.max' => 'Har file 5MB se zyada nahi honi chahiye.',
        ]);

        foreach ($request->file('documents') as $docFile) {
            $originalName = $docFile->getClientOriginalName();
            $path = $docFile->store('student_files', 'public');

            StudentFile::create([
                'student_id' => $id,
                'file_name' => $originalName,
                'file_path' => $path,
            ]);
        }

        $count = count($request->file('documents'));

        return redirect()->route('student-data')->with('success', $count . ' file(s) uploaded successfully!');
    }

    public function deleteFile($id)
    {
        $file = StudentFile::find($id);

        if (!$file) {
            return redirect()->route('student-data')->with('error', 'File not found');
        }

        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return redirect()->route('student-data')->with('success', 'File deleted successfully!');
    }

    public function attendanceForm(Request $request)
    {
        $date = $request->input('date', now()->format('Y-m-d'));

        $students = Student::orderBy('name', 'asc')->get();

        $existingAttendance = StudentAttendance::where('attendance_date', $date)
            ->pluck('status', 'student_id');

        return view('attendance', compact('students', 'date', 'existingAttendance'));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'status' => 'required|array',
        ]);

        $date = $request->attendance_date;

        foreach ($request->status as $studentId => $status) {
            StudentAttendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $date,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('attendance-form', ['date' => $date])
            ->with('success', 'Attendance saved for ' . $date);
    }
}