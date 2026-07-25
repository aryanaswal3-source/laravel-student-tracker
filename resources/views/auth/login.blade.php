<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .login-card .card-header {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            padding: 30px 25px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #dcdcf5;
        }

        .form-control:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: #4e4e4e;
        }

        .btn-login {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            color: white;
            font-weight: 500;
            width: 100%;
        }

        .btn-login:hover {
            opacity: 0.9;
            color: white;
        }

        .login-icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card login-card shadow-lg mx-auto" style="max-width: 420px;">

            <div class="card-header text-white text-center">
                <div class="login-icon-circle">
                    <i class="bi bi-shield-lock" style="font-size: 30px;"></i>
                </div>
                <h4 class="mb-0">Admin Login</h4>
                <p class="mb-0 small opacity-75">Apne dashboard mein login karein</p>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email" autofocus>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Enter your password">
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Login
                    </button>
                </form>

                <div class="text-center mt-3">
    <a href="{{ route('form') }}" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left me-1"></i>Back to Form
    </a>
</div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>