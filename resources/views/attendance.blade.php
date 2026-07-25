<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .attendance-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            max-width: 750px;
        }

        .attendance-card .card-header {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            padding: 22px;
        }

        .date-picker-bar {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .attendance-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            background: #fafafa;
            transition: background 0.2s ease;
        }

        .attendance-row:hover {
            background: #f0f0ff;
        }

        .avatar-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(120deg, #4e54c8, #8f94fb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .status-toggle {
            display: flex;
            gap: 6px;
        }

        .status-toggle input[type="radio"] {
            display: none;
        }

        .status-toggle label {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid #ddd;
            color: #888;
            transition: all 0.15s ease;
        }

        .status-toggle input[value="present"]:checked + label {
            background: #d1f7dc;
            border-color: #28a745;
            color: #1e7e34;
        }

        .status-toggle input[value="absent"]:checked + label {
            background: #ffe0e3;
            border-color: #dc3545;
            color: #c82333;
        }

        .btn-back {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card attendance-card shadow-lg mx-auto">

            <div class="card-header text-white text-center">
                <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Mark Attendance</h4>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('mark-attendance') }}" method="POST">
                    @csrf

                    <div class="date-picker-bar d-flex align-items-center gap-2">
                        <label for="attendance_date" class="fw-semibold mb-0">Date:</label>
                        <input type="date" id="attendance_date" name="attendance_date"
                            value="{{ $date }}" class="form-control form-control-sm w-auto"
                            onchange="window.location.href = '{{ route('attendance-form') }}?date=' + this.value">
                    </div>

                    @if ($students->isEmpty())
                        <p class="text-muted text-center py-4">No students found</p>
                    @else
                        @foreach ($students as $student)
                            @php
                                $currentStatus = $existingAttendance[$student->id] ?? 'present';
                            @endphp
                            <div class="attendance-row">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-icon">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $student->name }}</span>
                                </div>

                                <div class="status-toggle">
                                    <input type="radio" id="present-{{ $student->id }}"
                                        name="status[{{ $student->id }}]" value="present"
                                        {{ $currentStatus == 'present' ? 'checked' : '' }}>
                                    <label for="present-{{ $student->id }}">
                                        <i class="bi bi-check-circle me-1"></i>Present
                                    </label>

                                    <input type="radio" id="absent-{{ $student->id }}"
                                        name="status[{{ $student->id }}]" value="absent"
                                        {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                                    <label for="absent-{{ $student->id }}">
                                        <i class="bi bi-x-circle me-1"></i>Absent
                                    </label>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('student-data') }}" class="btn btn-outline-dark btn-back flex-fill">
                                <i class="bi bi-arrow-left me-1"></i>Back
                            </a>
                            <button type="submit" class="btn btn-success btn-back flex-fill">
                                <i class="bi bi-check2 me-1"></i>Save Attendance
                            </button>
                        </div>
                    @endif
                </form>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Saved!',
                text: "{{ session('success') }}",
                iconHtml: '<span style="font-size: 60px;">😄</span>',
                confirmButtonText: 'Great!',
                confirmButtonColor: '#203a43',
                timer: 2000,
                timerProgressBar: true,
                customClass: {
                    icon: 'no-border-icon'
                }
            });
        @endif
    </script>

</body>

</html>