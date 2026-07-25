<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .data-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            max-width: 1200px;
        }

        .data-card .card-header {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            padding: 22px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        table thead {
            background: linear-gradient(90deg, #ff6a00, #ee0979) !important;
        }

        table thead tr th {
            color: #0e0d0d !important;
            font-weight: 600;
            letter-spacing: 0.3px;
            padding: 16px 14px;
            border: none !important;
        }

        tbody tr {
            transition: all 0.25s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
            animation: fadeInRow 0.4s ease-in;

        }

        tbody td {
            padding: 14px;
            color: #333;
            border-color: #f0f0f0 !important;
            transition: all 0.25s ease;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }


        .table-hover tbody tr:hover {
            background-color: #fff4f0;
            transform: scale(1.01) translateX(2px);
            box-shadow: 0 4px 15px rgba(238, 9, 121, 0.15);
            position: relative;
            z-index: 1;
            border-left: 3px solid #ee0979;
        }

        .table-hover tbody tr:hover td {
            color: #000;
        }

        .table-hover tbody tr:hover td:first-child {
            color: #ee0979;
            font-weight: 600;
        }


        .name-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .name-cell .avatar-icon {
            width: 32px;
            height: 32px;
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

        .email-cell,
        .phone-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #666;
            font-size: 14px;
        }

        .email-cell i,
        .phone-cell i {
            color: #ee0979;
        }

        .photo-thumb {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #eee;
            cursor: zoom-in;
            transition: transform 0.15s ease;
        }

        .photo-thumb:hover {
            transform: scale(1.08);
            border-color: #ee0979;
        }

        .no-photo,
        .no-file,
        .no-attendance {
            color: #bbb;
            font-size: 13px;
        }

        .photo-wrap {
            position: relative;
            display: inline-block;
        }

        .delete-photo-btn,
        .delete-file-btn {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #fff;
            border-radius: 50%;
            font-size: 15px;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .file-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f0f1ff;
            border-radius: 8px;
            padding: 4px 8px;
            margin-bottom: 4px;
            font-size: 12px;
            max-width: 160px;
            position: relative;
        }

        .file-chip i.bi-file-earmark-text {
            color: #4e54c8;
        }

        .file-chip a.file-link {
            color: #333;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .file-chip a.file-link:hover {
            text-decoration: underline;
            color: #4e54c8;
        }

        .file-chip .delete-file-btn {
            position: static;
            box-shadow: none;
            background: transparent;
        }

        .attendance-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .attendance-good {
            background: #d1f7dc;
            color: #1e7e34;
        }

        .attendance-medium {
            background: #fff3cd;
            color: #856404;
        }

        .attendance-low {
            background: #ffe0e3;
            color: #c82333;
        }


        .btn-sm {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 8px;
        }

        .btn-sm:hover {
            transform: scale(1.15);
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-back {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
        }

        .pagination .page-link {
            color: #4e54c8;
            border-radius: 8px;
            margin: 0 3px;
            border: 1px solid #dcdcf5;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(90deg, #ff6a00, #ee0979);
            border-color: transparent;
        }

        .pagination .page-link:hover {
            background-color: #f4f2ff;
            color: #4e54c8;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card data-card shadow-lg mx-auto">

            <div class="card-header text-white">
                <h4 class="text-center mb-0"><i class="bi bi-table me-2"></i>Student Data</h4>
            </div>

            <div class="card-body p-4">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Attendance</th>
                                <th>Photos</th>
                                <th>Files</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($personalData as $personalData1)
                                <tr>
                                    <td>
                                        <div class="name-cell">
                                            <div class="avatar-icon">
                                                {{ strtoupper(substr($personalData1->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $personalData1->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="email-cell">
                                            <i class="bi bi-envelope-fill"></i>
                                            {{ $personalData1->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="phone-cell">
                                            <i class="bi bi-telephone-fill"></i>
                                            {{ $personalData1->number }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($personalData1->total_days)
                                            @php
                                                $percent = round(($personalData1->present_days / $personalData1->total_days) * 100);
                                                $badgeClass = $percent >= 75 ? 'attendance-good' : ($percent >= 50 ? 'attendance-medium' : 'attendance-low');
                                            @endphp
                                            <span class="attendance-badge {{ $badgeClass }}">
                                                <i class="bi bi-calendar-check"></i>
                                                {{ $percent }}%
                                            </span>
                                            <div class="text-muted" style="font-size: 11px;">
                                                {{ $personalData1->present_days }}/{{ $personalData1->total_days }} days
                                            </div>
                                        @else
                                            <span class="no-attendance">Not marked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($personalData1->image_paths)
                                            @php
                                                $imgIds = explode(',', $personalData1->image_ids);
                                                $imgPaths = explode(',', $personalData1->image_paths);
                                            @endphp
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                @foreach ($imgPaths as $index => $path)
                                                    <div class="photo-wrap">
                                                        <img src="{{ asset('storage/' . $path) }}"
                                                            class="photo-thumb" alt="{{ $personalData1->name }}"
                                                            onclick="openImagePreview('{{ asset('storage/' . $path) }}')">
                                                        <a href="{{ route('delete-image', $imgIds[$index]) }}"
                                                            class="btn-delete-image delete-photo-btn text-danger"
                                                            title="Delete Photo"
                                                            data-name="{{ $personalData1->name }}">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="no-photo">No photo</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($personalData1->file_paths)
                                            @php
                                                $fileIds = explode(',', $personalData1->file_ids);
                                                $fileNames = explode(',', $personalData1->file_names);
                                                $filePaths = explode(',', $personalData1->file_paths);
                                            @endphp
                                            <div>
                                                @foreach ($filePaths as $index => $fpath)
                                                    <div class="file-chip">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                        <a href="{{ asset('storage/' . $fpath) }}"
                                                            target="_blank" class="file-link"
                                                            title="{{ $fileNames[$index] }}">
                                                            {{ $fileNames[$index] }}
                                                        </a>
                                                        <a href="{{ route('delete-file', $fileIds[$index]) }}"
                                                            class="btn-delete-file delete-file-btn text-danger"
                                                            title="Delete File"
                                                            data-name="{{ $personalData1->name }}">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="no-file">No file</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('edit', $personalData1->id) }}"
                                            class="btn btn-sm btn-warning me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('delete', $personalData1->id) }}"
                                            class="btn btn-sm btn-danger btn-delete me-1" title="Delete"
                                            data-name="{{ $personalData1->name }}">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <a href="{{ route('upload-image-form', $personalData1->id) }}"
                                            class="btn btn-sm btn-success me-1" title="Upload Photo">
                                            <i class="bi bi-cloud-upload"></i>
                                        </a>
                                        <a href="{{ route('upload-file-form', $personalData1->id) }}"
                                            class="btn btn-sm btn-primary" title="Upload File">
                                            <i class="bi bi-file-earmark-arrow-up"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-muted text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 30px;"></i>
                                        <p class="mb-0 mt-2">No records found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $personalData->links('pagination::bootstrap-5') }}
                </div>

                <div class="mt-3 d-flex gap-2">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-back">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                    <a href="{{ route('students-dashboard') }}" class="btn btn-outline-primary btn-back">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                    <a href="{{ route('attendance-form') }}" class="btn btn-outline-success btn-back">
                        <i class="bi bi-calendar-check me-1"></i>Mark Attendance
                    </a>
                </div>

            </div>

        </div>

    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <button type="button" class="btn-close btn-close-white ms-auto me-2 mt-2"
                    data-bs-dismiss="modal" style="width: 12px; height: 12px;"></button>
                <img id="previewImage" src="" class="img-fluid rounded" alt="Preview">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteUrl = this.getAttribute('href');
                const studentName = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Kya aap pakka delete karna chahte hain?',
                    text: studentName + " ka record hamesha ke liye delete ho jayega!",
                    iconHtml: '⚠️',
                    showCancelButton: true,
                    confirmButtonColor: '#ee0979',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Haan, Delete karo',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });

        document.querySelectorAll('.btn-delete-image').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteUrl = this.getAttribute('href');
                const studentName = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Photo delete karni hai?',
                    text: studentName + " ki photo hamesha ke liye delete ho jayegi!",
                    iconHtml: '⚠️',
                    showCancelButton: true,
                    confirmButtonColor: '#ee0979',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Haan, Delete karo',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });

        document.querySelectorAll('.btn-delete-file').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteUrl = this.getAttribute('href');
                const studentName = this.getAttribute('data-name');

                Swal.fire({
                    title: 'File delete karni hai?',
                    text: studentName + " ki file hamesha ke liye delete ho jayegi!",
                    iconHtml: '⚠️',
                    showCancelButton: true,
                    confirmButtonColor: '#ee0979',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Haan, Delete karo',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            });
        });

        function openImagePreview(src) {
            document.getElementById('previewImage').src = src;
            const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            modal.show();
        }

        @if (session('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                iconHtml: '<span style="font-size: 60px;">😄</span>',
                confirmButtonText: 'Great!',
                confirmButtonColor: '#203a43',
                timer: 2500,
                timerProgressBar: true,
                customClass: {
                    icon: 'no-border-icon'
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Oops!',
                text: "{{ session('error') }}",
                iconHtml: '<span style="font-size: 60px;">😢</span>',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#dc3545',
                customClass: {
                    icon: 'no-border-icon'
                }
            });
        @endif
    </script>

</body>

</html>