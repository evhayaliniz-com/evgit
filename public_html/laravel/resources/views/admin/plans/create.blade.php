@extends('admin.inc.master')

@push('styles')
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
    
    <style>
        .current-file {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .file-details {
            display: flex;
            align-items: center;
        }
        
        .file-icon {
            width: 40px;
            height: 40px;
            background: #007bff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 10px;
        }

        /* Dropzone Custom Styling - Override all default styles */
        .dropzone#my-dropzone,
        #my-dropzone,
        div[id="my-dropzone"] {
            border: 2px dashed #d4d8dd !important;
            border-radius: 0.5rem !important;
            background: #f8f9fa !important;
            min-height: 120px !important;
            padding: 1.5rem !important;
            text-align: center !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            width: 100% !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        #my-dropzone:hover,
        .dropzone#my-dropzone:hover {
            border-color: #007bff !important;
            background: #f0f7ff !important;
        }

        #my-dropzone.dz-drag-hover,
        .dropzone#my-dropzone.dz-drag-hover {
            border-color: #007bff !important;
            border-style: solid !important;
            background: #e3f2fd !important;
        }

        #my-dropzone .dz-message,
        .dropzone#my-dropzone .dz-message,
        div[id="my-dropzone"] .dz-message {
            margin: 1rem 0 !important;
            font-weight: 500 !important;
            text-align: center !important;
            color: #516377 !important;
            font-size: 1rem !important;
            display: block !important;
            position: relative !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        #my-dropzone .dz-message .note,
        .dropzone#my-dropzone .dz-message .note {
            font-weight: 400 !important;
            display: block !important;
            margin-top: 0.625rem !important;
            color: #677788 !important;
            font-size: 0.875rem !important;
            opacity: 1 !important;
        }

        /* Dropzone Preview Styling */
        #my-dropzone .dz-preview {
            position: relative !important;
            vertical-align: top !important;
            margin: 0.5rem !important;
            background: #fff !important;
            font-size: 0.8125rem !important;
            box-sizing: content-box !important;
            cursor: default !important;
            border: 1px solid #d4d8dd !important;
            border-radius: 0.25rem !important;
            box-shadow: 0 2px 14px rgba(38, 60, 85, 0.16) !important;
        }

        #my-dropzone .dz-preview .dz-details {
            padding: 0.625rem !important;
            background: #fff !important;
        }

        #my-dropzone .dz-preview .dz-filename {
            position: relative !important;
            width: 100% !important;
            overflow: hidden !important;
            padding: 0.625rem 0.625rem 0 0.625rem !important;
            background: #fff !important;
            white-space: nowrap !important;
            text-overflow: ellipsis !important;
            color: #516377 !important;
        }

        #my-dropzone .dz-preview .dz-size {
            padding: 1.875rem 0.625rem 0.625rem 0.625rem !important;
            font-size: 0.6875rem !important;
            font-style: italic !important;
            color: #a8b1bb !important;
        }

        #my-dropzone .dz-preview .dz-remove {
            color: #677788 !important;
            border-top: 1px solid #d4d8dd !important;
            padding: 0.5rem !important;
            text-align: center !important;
            display: block !important;
            text-decoration: none !important;
            border-bottom-right-radius: calc(0.25rem - 1px) !important;
            border-bottom-left-radius: calc(0.25rem - 1px) !important;
        }

        #my-dropzone .dz-preview .dz-remove:hover {
            color: #677788 !important;
            background: rgba(38, 60, 85, 0.1) !important;
        }

        /* Progress Bar */
        #my-dropzone .dz-preview .progress {
            position: absolute !important;
            left: 1.25rem !important;
            right: 1.25rem !important;
            top: 50% !important;
            margin-top: -0.25rem !important;
            z-index: 30 !important;
            height: 0.5rem !important;
        }

        /* Success/Error Marks */
        #my-dropzone .dz-preview .dz-success-mark,
        #my-dropzone .dz-preview .dz-error-mark {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 20 !important;
            display: none !important;
        }

        #my-dropzone .dz-preview.dz-success .dz-success-mark {
            display: block !important;
        }

        #my-dropzone .dz-preview.dz-error .dz-error-mark {
            display: block !important;
        }

        /* Error Message */
        #my-dropzone .dz-preview .dz-error-message {
            background: rgba(255, 91, 92, 0.8) !important;
            color: white !important;
            padding: 0.5rem !important;
            border-radius: 0.25rem !important;
            margin-top: 0.5rem !important;
            font-size: 0.75rem !important;
        }

        /* Responsive */
        @media (min-width: 576px) {
            #my-dropzone .dz-preview {
                display: inline-block !important;
                width: 11.25rem !important;
            }
        }

        /* Additional fixes for dropzone */
        #my-dropzone.dz-started .dz-message,
        .dropzone#my-dropzone.dz-started .dz-message,
        div[id="my-dropzone"].dz-started .dz-message {
            display: none !important;
        }

        /* Ensure dropzone remains interactive after file upload */
        #my-dropzone.dz-started,
        .dropzone#my-dropzone.dz-started {
            min-height: 120px !important;
            padding: 1.5rem !important;
            cursor: pointer !important;
        }

        /* Make sure preview elements are properly styled */
        #my-dropzone .dz-preview {
            margin: 0.5rem 0 !important;
            display: block !important;
        }

        /* Ensure remove link is clickable */
        #my-dropzone .dz-preview .dz-remove {
            cursor: pointer !important;
            color: #dc3545 !important;
            text-decoration: none !important;
            padding: 0.5rem !important;
            display: block !important;
            text-align: center !important;
            border-top: 1px solid #dee2e6 !important;
            background: #f8f9fa !important;
            border-radius: 0 0 0.25rem 0.25rem !important;
        }

        #my-dropzone .dz-preview .dz-remove:hover {
            background: #dc3545 !important;
            color: white !important;
        }

        /* Prevent dropzone from being hidden initially */
        .dropzone.dz-clickable {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .dropzone.dz-clickable .dz-message {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Ensure dropzone is always visible initially */
        #my-dropzone,
        .dropzone#my-dropzone,
        div[id="my-dropzone"] {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Force override any conflicting styles */
        .dropzone {
            border: 2px dashed #d4d8dd !important;
            border-radius: 0.5rem !important;
            background: #f8f9fa !important;
            min-height: 120px !important;
            padding: 1.5rem !important;
            text-align: center !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            width: 100% !important;
            margin: 0 !important;
            box-sizing: border-box !important;
        }

        .dropzone .dz-message {
            margin: 1rem 0 !important;
            font-weight: 500 !important;
            text-align: center !important;
            color: #516377 !important;
            font-size: 1rem !important;
            display: block !important;
            position: relative !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        #my-dropzone .dz-preview .dz-image {
            width: 100% !important;
            height: 80px !important;
            background: #f8f9fa !important;
            border-radius: 0.25rem 0.25rem 0 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        #my-dropzone .dz-preview .dz-image img {
            max-width: 100% !important;
            max-height: 100% !important;
        }

        #my-dropzone .dz-preview .dz-nopreview {
            color: #a8b1bb !important;
            font-size: 2rem !important;
        }

        /* Ensure dropzone is clickable */
        #my-dropzone.dz-clickable,
        #my-dropzone.dz-started {
            cursor: pointer !important;
        }

        #my-dropzone.dz-clickable *,
        #my-dropzone.dz-started * {
            cursor: pointer !important;
        }

        /* Make sure dropzone remains interactive after file upload */
        #my-dropzone.dz-started {
            position: relative !important;
            min-height: 120px !important;
            padding: 1.5rem !important;
        }

        /* Ensure preview elements don't block interactions */
        #my-dropzone .dz-preview {
            pointer-events: auto !important;
            z-index: 10 !important;
        }

        /* Make dropzone more responsive to clicks */
        #my-dropzone {
            pointer-events: auto !important;
        }

        #my-dropzone * {
            pointer-events: auto !important;
        }

        /* Ensure file input is accessible */
        #my-dropzone input[type="file"] {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            opacity: 0 !important;
            cursor: pointer !important;
            z-index: 1 !important;
        }

        /* Additional visual improvements */
        #my-dropzone .dz-message i {
            transition: all 0.3s ease !important;
        }

        #my-dropzone:hover .dz-message i {
            transform: scale(1.1) !important;
            color: #007bff !important;
        }

        /* Loading state */
        #my-dropzone.dz-drag-hover .dz-message {
            opacity: 0.7 !important;
        }

        /* Success state */
        #my-dropzone .dz-preview.dz-success .dz-success-mark {
            background: rgba(40, 167, 69, 0.9) !important;
            color: white !important;
            border-radius: 50% !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Error state */
        #my-dropzone .dz-preview.dz-error .dz-error-mark {
            background: rgba(220, 53, 69, 0.9) !important;
            color: white !important;
            border-radius: 50% !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Yeni Plan Ekle</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Hata!</strong> Lütfen aşağıdaki hataları düzeltin:<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.plans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Yapı Türü --}}
                    <div class="mb-3 col-md-4">
                        <label for="structure_type_id" class="form-label">Yapı Türü</label>
                        <select name="structure_type_id" id="structure_type_id" class="form-select" required>
                            <option value="">Seçiniz</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('structure_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Yapı Sınıfı --}}
                    <div class="mb-3 col-md-4">
                        <label for="structure_class_id" class="form-label">Yapı Sınıfı</label>
                        <select name="structure_class_id" id="structure_class_id" class="form-select" required>
                            <option value="">Seçiniz</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('structure_class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Oda Sayısı --}}
                    <div class="mb-3 col-md-4">
                        <label for="room_count_id" class="form-label">Oda Sayısı</label>
                        <select name="room_count_id" id="room_count_id" class="form-select" required>
                            <option value="">Seçiniz</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_count_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Başlık --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                {{-- Açıklama --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama / Detay</label>
                    <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    {{-- Metrekare --}}
                    <div class="mb-3 col-md-6">
                        <label for="net_area" class="form-label">Metrekare (Net)</label>
                        <input type="text" name="net_area" class="form-control" value="{{ old('net_area') }}" required>
                    </div>

                    {{-- Brüt --}}
                    <div class="mb-3 col-md-6">
                        <label for="gross_area" class="form-label">Brüt</label>
                        <input type="text" name="gross_area" class="form-control" value="{{ old('gross_area') }}" required>
                    </div>
                </div>

                                 {{-- Plan Dosyası --}}
                 <div class="mb-3">
                     <label class="form-label">Plan Dosyası (RAR / ZIP / PDF)</label>
                     
                     {{-- Dropzone Alanı --}}
                     <div class="dropzone" id="my-dropzone" style="border: 2px dashed #d4d8dd; border-radius: 0.5rem; background: #f8f9fa; min-height: 120px; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                         <div class="dz-message" style="margin: 1rem 0; font-weight: 500; text-align: center; color: #516377; font-size: 1rem; display: block; position: relative;">
                             <i class="bx bx-cloud-upload" style="font-size: 3rem; color: #007bff; display: block; margin-bottom: 1rem;"></i>
                             <strong style="font-size: 1.1rem; color: #516377; display: block; margin-bottom: 0.5rem;">
                                 Dosyayı buraya sürükleyin veya tıklayarak seçin
                             </strong>
                             <small style="color: #677788; font-size: 0.875rem;">
                                 RAR, ZIP veya PDF (Maks. 20MB)
                             </small>
                         </div>
                     </div>
                     
                     {{-- Hidden input for uploaded file --}}
                     <input type="hidden" name="uploaded_file" id="uploaded_file" value="">  
                 </div>

                 {{-- Metraj Dosyası --}}
                 <div class="mb-3">
                     <label class="form-label">Metraj Dosyası (RAR / ZIP / PDF)</label>
                     
                     {{-- Metraj Dropzone Alanı --}}
                     <div class="dropzone" id="measurement-dropzone" style="border: 2px dashed #d4d8dd; border-radius: 0.5rem; background: #f8f9fa; min-height: 120px; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                         <div class="dz-message" style="margin: 1rem 0; font-weight: 500; text-align: center; color: #516377; font-size: 1rem; display: block; position: relative;">
                             <i class="bx bx-calculator" style="font-size: 3rem; color: #28a745; display: block; margin-bottom: 1rem;"></i>
                             <strong style="font-size: 1.1rem; color: #516377; display: block; margin-bottom: 0.5rem;">
                                 Metraj dosyasını buraya sürükleyin veya tıklayarak seçin
                             </strong>
                             <small style="color: #677788; font-size: 0.875rem;">
                                 RAR, ZIP veya PDF (Maks. 20MB)
                             </small>
                         </div>
                     </div>
                     
                     {{-- Hidden input for measurement uploaded file --}}
                     <input type="hidden" name="measurement_uploaded_file" id="measurement_uploaded_file" value="">  
                 </div>

                                 {{-- Dropzone Preview Template --}}
                 <div id="preview-template" style="display: none;">
                     <div class="dz-preview dz-file-preview">
                         <div class="dz-details">
                             <div class="dz-filename"><span data-dz-name></span></div>
                             <div class="dz-size" data-dz-size></div>
                         </div>
                         <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                         <div class="dz-success-mark"><i class="bx bx-check"></i></div>
                         <div class="dz-error-mark"><i class="bx bx-x"></i></div>
                         <div class="dz-error-message"><span data-dz-errormessage></span></div>
                     </div>
                 </div>

                 {{-- Fallback File Input (Hidden by default) --}}
                 <div id="fallback-upload" style="display: none;">
                     <div class="alert alert-info">
                         <strong>Dropzone yüklenemedi!</strong> Lütfen dosya yüklemek için aşağıdaki butonu kullanın.
                     </div>
                     <input type="file" name="fallback_file" class="form-control" accept=".zip,.rar,.pdf">
                 </div>

                 {{-- Fotoğraflar (çoklu) --}}
                 <div class="mb-3">
                     <label for="photos" class="form-label">Plan Fotoğrafları (En Fazla 10 Adet)</label>
                     <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
                     <small class="text-muted">Birden fazla fotoğraf seçebilirsiniz (maks: 10MB/foto). Görseller otomatik olarak optimize edilir.</small>
                 </div>

                {{-- Gönder --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary me-2">Geri Dön</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <!-- Dropzone Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;
        
                 let uploadedFileName = '';
         let measurementUploadedFileName = '';

         document.addEventListener('DOMContentLoaded', function() {
            console.log('=== DROPZONE DEBUG START ===');
            console.log('DOM loaded, initializing dropzone...');
            
            // Check if dropzone element exists
            const dropzoneElement = document.getElementById('my-dropzone');
            if (!dropzoneElement) {
                console.error('Dropzone element not found!');
                return;
            }
            console.log('Dropzone element found:', dropzoneElement);
            
            // Check if Dropzone is available
            if (typeof Dropzone === 'undefined') {
                console.error('Dropzone library not loaded!');
                document.getElementById('fallback-upload').style.display = 'block';
                document.getElementById('my-dropzone').style.display = 'none';
                return;
            }
            console.log('Dropzone library loaded');
            
            // Dropzone oluştur
            let myDropzone;
            try {
                myDropzone = new Dropzone("#my-dropzone", {
                url: "{{ route('admin.plans.file-upload') }}",
                maxFilesize: 20,
                maxFiles: 1,
                acceptedFiles: ".zip,.rar,.pdf",
                addRemoveLinks: true,
                clickable: true,
                createImageThumbnails: false,
                dictRemoveFile: "Sil",
                dictFileTooBig: "Dosya çok büyük (maks. 20MB)",
                dictInvalidFileType: "Sadece RAR, ZIP ve PDF dosyaları kabul edilir",
                dictMaxFilesExceeded: "Sadece bir dosya yükleyebilirsiniz",
                dictDefaultMessage: "Dosyayı buraya sürükleyin veya tıklayarak seçin",
                dictFallbackMessage: "Tarayıcınız drag & drop dosya yüklemeyi desteklemiyor.",
                dictResponseError: "Dosya yüklenirken hata oluştu.",
                dictCancelUpload: "İptal",
                dictUploadCanceled: "Yükleme iptal edildi.",
                dictCancelUploadConfirmation: "Bu yüklemeyi iptal etmek istediğinize emin misiniz?",
                dictMaxFilesExceeded: "Bu dosyayı yükleyemezsiniz.",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                previewTemplate: document.querySelector('#preview-template').innerHTML,
                init: function () {
                    this.on("addedfile", function (file) {
                        console.log('Dosya eklendi:', file.name);
                        
                        // Eğer başka dosya varsa onu kaldır (otomatik olarak)
                        if (this.files.length > 1) {
                            console.log('Mevcut dosya otomatik olarak kaldırılıyor');
                            this.removeFile(this.files[0]);
                        }
                        
                        // Dropzone'u aktif hale getir
                        this.element.classList.add('dz-started');
                        this.element.style.cursor = 'pointer';
                    });

                    this.on("success", function (file, response) {
                        console.log('Upload response:', response);
                        if (response.success) {
                            uploadedFileName = response.fileName;
                            // Dosya nesnesine server dosya adını ekle
                            file.serverFileName = response.fileName;
                            document.getElementById('uploaded_file').value = uploadedFileName;
                            
                            // Mevcut dosyayı gizle
                            const currentFile = document.getElementById('current-file');
                            if (currentFile) {
                                currentFile.style.display = 'none';
                            }
                            
                            // Dropzone'u yeniden aktif hale getir
                            this.element.classList.add('dz-started');
                            this.element.style.cursor = 'pointer';
                            
                            console.log('Dosya başarıyla yüklendi:', uploadedFileName);
                            console.log('File object updated:', file);
                        } else {
                            alert('Yükleme hatası: ' + (response.message || 'Bilinmeyen hata'));
                            this.removeFile(file);
                        }
                    });

                    this.on("error", function (file, errorMessage) {
                        console.error('Dropzone hatası:', errorMessage);
                        let errorMsg = 'Dosya yüklenemedi';
                        if (typeof errorMessage === 'string') {
                            errorMsg = errorMessage;
                        } else if (errorMessage && errorMessage.message) {
                            errorMsg = errorMessage.message;
                        }
                        alert('Yükleme hatası: ' + errorMsg);
                        this.removeFile(file);
                    });

                    this.on("removedfile", function (file) {
                        console.log('Dosya kaldırıldı:', file.name);
                        
                        // Uploaded file name'i temizle
                        uploadedFileName = '';
                        document.getElementById('uploaded_file').value = '';
                        
                        // File object'ten server dosya adını da temizle
                        if (file.serverFileName) {
                            delete file.serverFileName;
                        }
                        
                        // Mevcut dosyayı tekrar göster
                        const currentFile = document.getElementById('current-file');
                        if (currentFile) {
                            currentFile.style.display = 'block';
                        }
                        
                        // Dropzone'u temizle ve yeniden aktif hale getir
                        this.element.classList.remove('dz-started');
                        this.element.style.cursor = 'pointer';
                        
                        // Mesajı tekrar göster
                        const message = this.element.querySelector('.dz-message');
                        if (message) {
                            message.style.display = 'block';
                        }
                        
                        console.log('Dropzone temizlendi, mevcut dosya gösteriliyor');
                    });

                    this.on("maxfilesexceeded", function(file) {
                        alert("Sadece bir dosya yükleyebilirsiniz");
                        this.removeFile(file);
                    });

                    this.on("dragenter", function() {
                        console.log('Drag enter');
                    });

                    this.on("dragleave", function() {
                        console.log('Drag leave');
                    });

                    this.on("drop", function() {
                        console.log('File dropped');
                    });
                }
            });
            } catch (error) {
                console.error('Dropzone initialization failed:', error);
                document.getElementById('fallback-upload').style.display = 'block';
                document.getElementById('my-dropzone').style.display = 'none';
                return;
            }

            // Test dropzone functionality
            console.log('Dropzone initialized:', myDropzone);
            
            // Add a simple click test
            dropzoneElement.addEventListener('click', function(e) {
                console.log('Dropzone clicked');
                
                // Eğer dosya yüklendiyse ve kullanıcı dropzone'a tıklarsa, yeni dosya seçmeye izin ver
                if (myDropzone.files.length > 0) {
                    // Kullanıcıya bilgi ver ama engelleme
                    console.log('Yeni dosya seçiliyor, mevcut dosya otomatik olarak değiştirilecek');
                }
            });

            // Test if dropzone is properly configured
            console.log('Dropzone options:', {
                url: myDropzone.options.url,
                maxFiles: myDropzone.options.maxFiles,
                maxFilesize: myDropzone.options.maxFilesize,
                acceptedFiles: myDropzone.options.acceptedFiles
            });
            
                         console.log('=== DROPZONE DEBUG END ===');
             console.log('Dropzone should now be working! Try dragging a file or clicking the dropzone.');

             // Metraj Dropzone oluştur
             let measurementDropzone;
             try {
                 measurementDropzone = new Dropzone("#measurement-dropzone", {
                 url: "{{ route('admin.plans.measurement-file-upload') }}",
                 maxFilesize: 20,
                 maxFiles: 1,
                 acceptedFiles: ".zip,.rar,.pdf",
                 addRemoveLinks: true,
                 clickable: true,
                 createImageThumbnails: false,
                 dictRemoveFile: "Sil",
                 dictFileTooBig: "Dosya çok büyük (maks. 20MB)",
                 dictInvalidFileType: "Sadece RAR, ZIP ve PDF dosyaları kabul edilir",
                 dictMaxFilesExceeded: "Sadece bir dosya yükleyebilirsiniz",
                 dictDefaultMessage: "Metraj dosyasını buraya sürükleyin veya tıklayarak seçin",
                 dictFallbackMessage: "Tarayıcınız drag & drop dosya yüklemeyi desteklemiyor.",
                 dictResponseError: "Dosya yüklenirken hata oluştu.",
                 dictCancelUpload: "İptal",
                 dictUploadCanceled: "Yükleme iptal edildi.",
                 dictCancelUploadConfirmation: "Bu yüklemeyi iptal etmek istediğinize emin misiniz?",
                 dictMaxFilesExceeded: "Bu dosyayı yükleyemezsiniz.",
                 headers: {
                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                 },
                 previewTemplate: document.querySelector('#preview-template').innerHTML,
                 init: function () {
                     this.on("addedfile", function (file) {
                         console.log('Metraj dosyası eklendi:', file.name);
                         
                         // Eğer başka dosya varsa onu kaldır (otomatik olarak)
                         if (this.files.length > 1) {
                             console.log('Mevcut metraj dosyası otomatik olarak kaldırılıyor');
                             this.removeFile(this.files[0]);
                         }
                         
                         // Dropzone'u aktif hale getir
                         this.element.classList.add('dz-started');
                         this.element.style.cursor = 'pointer';
                     });

                     this.on("success", function (file, response) {
                         console.log('Metraj upload response:', response);
                         if (response.success) {
                             measurementUploadedFileName = response.fileName;
                             // Dosya nesnesine server dosya adını ekle
                             file.serverFileName = response.fileName;
                             document.getElementById('measurement_uploaded_file').value = measurementUploadedFileName;
                             
                             // Mevcut metraj dosyasını gizle
                             const currentMeasurementFile = document.getElementById('current-measurement-file');
                             if (currentMeasurementFile) {
                                 currentMeasurementFile.style.display = 'none';
                             }
                             
                             // Dropzone'u yeniden aktif hale getir
                             this.element.classList.add('dz-started');
                             this.element.style.cursor = 'pointer';
                             
                             console.log('Metraj dosyası başarıyla yüklendi:', measurementUploadedFileName);
                             console.log('File object updated:', file);
                         } else {
                             alert('Yükleme hatası: ' + (response.message || 'Bilinmeyen hata'));
                             this.removeFile(file);
                         }
                     });

                     this.on("error", function (file, errorMessage) {
                         console.error('Metraj dropzone hatası:', errorMessage);
                         let errorMsg = 'Metraj dosyası yüklenemedi';
                         if (typeof errorMessage === 'string') {
                             errorMsg = errorMessage;
                         } else if (errorMessage && errorMessage.message) {
                             errorMsg = errorMessage.message;
                         }
                         alert('Yükleme hatası: ' + errorMsg);
                         this.removeFile(file);
                     });

                     this.on("removedfile", function (file) {
                         console.log('Metraj dosyası kaldırıldı:', file.name);
                         
                         // Uploaded file name'i temizle
                         measurementUploadedFileName = '';
                         document.getElementById('measurement_uploaded_file').value = '';
                         
                         // File object'ten server dosya adını da temizle
                         if (file.serverFileName) {
                             delete file.serverFileName;
                         }
                         
                         // Mevcut metraj dosyasını tekrar göster
                         const currentMeasurementFile = document.getElementById('current-measurement-file');
                         if (currentMeasurementFile) {
                             currentMeasurementFile.style.display = 'block';
                         }
                         
                         // Dropzone'u temizle ve yeniden aktif hale getir
                         this.element.classList.remove('dz-started');
                         this.element.style.cursor = 'pointer';
                         
                         // Mesajı tekrar göster
                         const message = this.element.querySelector('.dz-message');
                         if (message) {
                             message.style.display = 'block';
                         }
                         
                         console.log('Metraj dropzone temizlendi, mevcut dosya gösteriliyor');
                     });

                     this.on("maxfilesexceeded", function(file) {
                         alert("Sadece bir metraj dosyası yükleyebilirsiniz");
                         this.removeFile(file);
                     });
                 }
             });
             } catch (error) {
                 console.error('Metraj dropzone initialization failed:', error);
             }

             console.log('Metraj dropzone initialized:', measurementDropzone);

                         // Form submit event listener
             document.querySelector('form').addEventListener('submit', function(e) {
                                 console.log('Form gönderiliyor...');
                 console.log('Uploaded file name:', uploadedFileName);
                 console.log('Measurement uploaded file name:', measurementUploadedFileName);
                 
                 // Dropzone dosyasını kontrol et ve hidden input'a ekle
                 if (myDropzone && myDropzone.files.length > 0) {
                     const uploadedFile = myDropzone.files[0];
                     if (uploadedFile && uploadedFile.serverFileName) {
                         document.getElementById('uploaded_file').value = uploadedFile.serverFileName;
                         console.log('Dropzone dosyası form submit sırasında eklendi:', uploadedFile.serverFileName);
                     }
                 } else if (uploadedFileName) {
                     document.getElementById('uploaded_file').value = uploadedFileName;
                     console.log('Hidden input güncellendi:', uploadedFileName);
                 }

                 // Metraj dropzone dosyasını kontrol et ve hidden input'a ekle
                 if (measurementDropzone && measurementDropzone.files.length > 0) {
                     const measurementUploadedFile = measurementDropzone.files[0];
                     if (measurementUploadedFile && measurementUploadedFile.serverFileName) {
                         document.getElementById('measurement_uploaded_file').value = measurementUploadedFile.serverFileName;
                         console.log('Metraj dropzone dosyası form submit sırasında eklendi:', measurementUploadedFile.serverFileName);
                     }
                 } else if (measurementUploadedFileName) {
                     document.getElementById('measurement_uploaded_file').value = measurementUploadedFileName;
                     console.log('Measurement hidden input güncellendi:', measurementUploadedFileName);
                 }
                 
                 // Form verilerini logla
                 const formData = new FormData(this);
                 console.log('Form verileri:');
                 for (let [key, value] of formData.entries()) {
                     console.log(key + ': ' + value);
                 }
                 
                 // Form submit'e izin ver - e.preventDefault() yok!
                 console.log('Form submit devam ediyor...');
             });
        });

                 // Dosya silme fonksiyonu
         function deleteCurrentFile(planId) {
             if (confirm('Bu dosyayı silmek istediğinize emin misiniz?')) {
                 fetch(`/admin/plans/${planId}/file-delete`, {
                     method: 'DELETE',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         document.getElementById('current-file').remove();
                         alert('Dosya başarıyla silindi');
                     } else {
                         alert('Silme hatası: ' + (data.message || 'Bilinmeyen hata'));
                     }
                 })
                 .catch(error => {
                     console.error('Silme hatası:', error);
                     alert('Dosya silinirken hata oluştu');
                 });
             }
         }

         // Metraj dosyası silme fonksiyonu
         function deleteCurrentMeasurementFile(planId) {
             if (confirm('Bu metraj dosyasını silmek istediğinize emin misiniz?')) {
                 fetch(`/admin/plans/${planId}/measurement-file-delete`, {
                     method: 'DELETE',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         document.getElementById('current-measurement-file').remove();
                         alert('Metraj dosyası başarıyla silindi');
                     } else {
                         alert('Silme hatası: ' + (data.message || 'Bilinmeyen hata'));
                     }
                 })
                 .catch(error => {
                     console.error('Metraj silme hatası:', error);
                     alert('Metraj dosyası silinirken hata oluştu');
                 });
             }
         }
    </script>
@endsection
