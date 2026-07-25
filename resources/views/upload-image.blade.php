<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>

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
            border-color: #ee0979;
            color: #ee0979;
            background: #fff4f8;
        }

        .preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .preview-item {
            position: relative;
            width: 70px;
            height: 70px;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #eee;
        }

        .preview-remove {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #fff;
            border-radius: 50%;
            font-size: 16px;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            color: #dc3545;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="card upload-card shadow-lg mx-auto">

            <div class="card-header text-white text-center">
                <h4 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Upload Images</h4>
            </div>

            <div class="card-body p-4">

                <div class="student-info d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle fs-4 text-secondary"></i>
                    <div>
                        <div class="fw-semibold">{{ $student->name }}</div>
                        <div class="text-muted small">{{ $student->email }}</div>
                    </div>
                </div>

                <form action="{{ route('upload-image', $student->id) }}" method="POST"
                    enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div id="dropZone" class="drop-zone d-block mb-3">
                        <i class="bi bi-images fs-1 d-block mb-2"></i>
                        <span id="dropLabel">Drag & drop images here, or click to select</span>
                        <input type="file" id="imageInput" name="images[]" accept="image/*"
                            class="d-none" multiple required>
                    </div>

                    <div id="previewGrid" class="preview-grid"></div>

                    @error('images')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('student-data') }}" class="btn btn-outline-dark btn-back flex-fill">
                            <i class="bi bi-arrow-left me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success btn-back flex-fill">
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
        const imageInput = document.getElementById('imageInput');
        const dropLabel = document.getElementById('dropLabel');
        const previewGrid = document.getElementById('previewGrid');

        let selectedFiles = [];

        // Click drop zone -> open file picker
        dropZone.addEventListener('click', () => imageInput.click());

        // Drag over styling
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        // Drop files
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        // File picker selection
        imageInput.addEventListener('change', () => {
            handleFiles(imageInput.files);
        });

        function handleFiles(fileList) {
            for (const file of fileList) {
                if (file.type.startsWith('image/')) {
                    selectedFiles.push(file);
                }
            }
            renderPreviews();
            syncInputFiles();
        }

        function renderPreviews() {
            previewGrid.innerHTML = '';
            dropLabel.textContent = selectedFiles.length > 0
                ? selectedFiles.length + ' image(s) selected — click to add more'
                : 'Drag & drop images here, or click to select';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    item.innerHTML = `
                        <img src="${e.target.result}" alt="preview">
                        <span class="preview-remove" data-index="${index}">
                            <i class="bi bi-x-circle-fill"></i>
                        </span>
                    `;
                    item.querySelector('.preview-remove').addEventListener('click', (ev) => {
                        ev.stopPropagation();
                        selectedFiles.splice(index, 1);
                        renderPreviews();
                        syncInputFiles();
                    });
                    previewGrid.appendChild(item);
                };
                reader.readAsDataURL(file);
            });
        }

        
        function syncInputFiles() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
        }
    </script>

</body>

</html>