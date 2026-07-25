<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .welcome-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            max-width: 600px;
        }

        .welcome-card .card-header {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            padding: 40px 25px;
            text-align: center;
        }

        .welcome-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .action-btn {
            border-radius: 14px;
            padding: 22px;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
            display: block;
        }

        .action-btn:hover {
            transform: translateY(-4px);
        }

        .btn-show-data {
            background: linear-gradient(120deg, #ff6a00, #ee0979);
            color: white;
        }

        .btn-chart-dashboard {
            background: linear-gradient(120deg, #4e54c8, #8f94fb);
            color: white;
        }

        .btn-attendance {
            background: linear-gradient(120deg, #11998e, #38ef7d);
            color: white;
        }

        .action-btn i {
            font-size: 32px;
            display: block;
            margin-bottom: 8px;
        }

        .btn-logout {
            background: #fff5f5;
            border: 1px solid #ffd6d6;
            color: #dc3545;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card welcome-card shadow-lg mx-auto">

            <div class="card-header text-white">
                <div class="welcome-icon-circle">
                    <i class="bi bi-person-check" style="font-size: 34px;"></i>
                </div>
                <h3 class="mb-1">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="mb-0 small opacity-75">{{ Auth::user()->email }}</p>
            </div>

            <div class="card-body p-4">

                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('student-data') }}" class="action-btn btn-show-data">
                            <i class="bi bi-table"></i>
                            Show Data
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('students-dashboard') }}" class="action-btn btn-chart-dashboard">
                            <i class="bi bi-speedometer2"></i>
                            Chart Dashboard
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('attendance-form') }}" class="action-btn btn-attendance">
                            <i class="bi bi-calendar-check"></i>
                            Mark Attendance
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>