<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .upload-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            max-width: 550px;
        }

        .upload-card .card-header {
            background: linear-gradient(120deg, #0f2027, #203a43, #2c5364);
            padding: 22px;
        }

        .btn-back {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
        }

        .student-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
        }

        .drop-zone {
            border: 2px dashed #ccc;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            color: #888;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            border-color: #4e54c8;
            color: #4e54c8;
            background: #f4f4ff;
        }

        .file-list {
            margin-top: 16px;
        }

        .file-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
        }

        .file-item i.bi-file-earmark-text {
            font-size: 20px;
            color: #4e54c8;
        }

        .file-item .file-name {
            flex: 1;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .file-remove {
            cursor: pointer;
            color: #dc3545;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card upload-card shadow-lg mx-auto">

            <div class="card-header text-white text-center">
                <h4 class="mb-0"><i class="bi bi-file-earmark-arrow-up me-2"></i>Upload Files</h4>
            </div>

            <div class="card-body p-4">

                <div class="student-info d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle fs-4 text-secondary"></i>
                    <div>
                        <div class="fw-semibold">{{ $student->name }}</div>
                        <div class="text-muted small">{{ $student->email }}</div>
                    </div>
                </div>

                <form action="{{ route('upload-file', $student->id) }}" method="POST"
                    enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div id="dropZone" class="drop-zone d-block mb-3">
                        <i class="bi bi-file-earmark-plus fs-1 d-block mb-2"></i>
                        <span id="dropLabel">Drag & drop files here, or click to select</span>
                        <div class="small text-muted mt-1">PDF, DOC, DOCX allowed</div>
                        <input type="file" id="fileInput" name="documents[]"
                            accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            class="d-none" multiple required>
                    </div>

                    <div id="fileList" class="file-list"></div>

                    @error('documents')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                    @error('documents.*')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('student-data') }}" class="btn btn-outline-dark btn-back flex-fill">
                            <i class="bi bi-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-back flex-fill">
                            <i class="bi bi-check2 me-1"></i>Submit
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const dropLabel = document.getElementById('dropLabel');
        const fileList = document.getElementById('fileList');

        let selectedFiles = [];

        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        fileInput.addEventListener('change', () => {
            handleFiles(fileInput.files);
        });

        function handleFiles(fileArr) {
            const allowedExt = ['pdf', 'doc', 'docx'];
            for (const file of fileArr) {
                const ext = file.name.split('.').pop().toLowerCase();
                if (allowedExt.includes(ext)) {
                    selectedFiles.push(file);
                }
            }
            renderList();
            syncInputFiles();
        }

        function renderList() {
            fileList.innerHTML = '';
            dropLabel.textContent = selectedFiles.length > 0
                ? selectedFiles.length + ' file(s) selected — click to add more'
                : 'Drag & drop files here, or click to select';

            selectedFiles.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'file-item';
                item.innerHTML = `
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="file-name">${file.name}</span>
                    <i class="bi bi-x-circle-fill file-remove" data-index="${index}"></i>
                `;
                item.querySelector('.file-remove').addEventListener('click', () => {
                    selectedFiles.splice(index, 1);
                    renderList();
                    syncInputFiles();
                });
                fileList.appendChild(item);
            });
        }

        function syncInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }
    </script>

</body>

</html>