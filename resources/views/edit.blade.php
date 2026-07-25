<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .form-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .form-card .card-header {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            padding: 25px;
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

        .btn-update {
            background: linear-gradient(90deg, #4e54c8, #8f94fb);
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            color: white;
            font-weight: 500;
        }

        .btn-update:hover {
            opacity: 0.9;
            color: white;
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

        <div class="card form-card shadow-lg mx-auto" style="max-width: 800px;">
            <div class="card-header text-white text-center">
                <h3><i class="bi bi-pencil-square me-2"></i>Edit Student</h3>
            </div>

            <div class="card-body p-4">

                <form action="{{ route('update', $personalData->id) }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-person me-1"></i>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $personalData->name) }}">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email', $personalData->email) }}">
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="bi bi-telephone me-1"></i>Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone', $personalData->number) }}">
                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-update">
                            <i class="bi bi-check-circle me-1"></i>Update
                        </button>
                        <a href="{{ route('student-data') }}" class="btn btn-outline-dark btn-back">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>