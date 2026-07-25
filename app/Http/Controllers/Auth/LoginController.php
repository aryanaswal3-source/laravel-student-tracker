<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class LoginController extends Controller
{
   public function showLoginForm()
{
    if (Auth::check()) {
        return redirect()->route('welcome-dashboard');
    }

    return view('auth.login');
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            ]);
            // dd($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd('success ');

            // $student = Auth();
            // dd($student);

            return redirect()->intended(route('welcome-dashboard'));
        }
            // dd('fail ');


        return back()->withErrors(['email' => 'Email ya password galat hai.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}