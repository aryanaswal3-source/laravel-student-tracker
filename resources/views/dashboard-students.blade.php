<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .dashboard-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .dashboard-header {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            padding: 22px;
        }

        .stat-box {
            border-radius: 16px;
            padding: 25px;
            color: white;
            background: linear-gradient(90deg, #ff6a00, #ee0979);
            text-align: center;
        }

        .stat-box h2 {
            font-size: 48px;
            font-weight: 700;
            margin: 0;
        }

        .stat-box p {
            margin: 0;
            opacity: 0.9;
        }

        .chart-card {
            border-radius: 16px;
            border: 1px solid #eee;
            padding: 20px;
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

        <div class="card dashboard-card shadow-lg mx-auto" style="max-width: 900px;">

            <div class="dashboard-header text-white">
                <h4 class="text-center mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
            </div>

            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="bi bi-people-fill" style="font-size: 30px;"></i>
                            <h2>{{ $totalStudents }}</h2>
                            <p>Total Students</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="chart-card h-100">
                            <h6 class="mb-3"><i class="bi bi-graph-up me-1"></i>Last 7 Days Registrations</h6>
                            <canvas id="studentChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('student-data') }}" class="btn btn-outline-dark btn-back">
                        <i class="bi bi-table me-1"></i>View Student Data
                    </a>
                    <a href="{{ route('form') }}" class="btn btn-outline-dark btn-back">
                        <i class="bi bi-arrow-left me-1"></i>Back to Form
                    </a>
                </div>

            </div>

        </div>

    </div>

    <script>
        const ctx = document.getElementById('studentChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'New Students',
                    data: @json($chartValues),
                    borderColor: '#ee0979',
                    backgroundColor: 'rgba(238, 9, 121, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#ff6a00',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>

</body>

</html>5/
