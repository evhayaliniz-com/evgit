@extends('admin.inc.master')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        .dropzone.dz-clickable {
            background: transparent;
            border: none;
        }
        
        .custom-icons {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
        }
        
        .custom-icons i {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px;
            margin-left: 5px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .custom-icons .fa-trash-alt {
            background: rgba(220, 53, 69, 0.8);
        }
        
        .custom-icons .fa-trash-alt:hover {
            background: rgba(220, 53, 69, 1);
        }
        
        .custom-icons .drag-icon {
            cursor: move;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Servis Düzenle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.services.update', $service->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Üst Kategori</label>
                            <select name="category_id" class="form-control" onchange="getSubCategories(); loadCategoryParameters();" required>
                                <option value="">Kategori</option>
                                @foreach(get_categories() as $category)
                                    <option value="{{$category->id}}" @selected($service->category_id == $category->id)>
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Alt Kategori</label>
                            <div class="form-group">
                                <select name="sub_category_id" class="form-select" id="sub-category-select"
                                required>
                                    @foreach(get_sub_categories($service->category_id) as $subCategory)
                                        <option value="{{$subCategory->id}}" @selected($service->sub_category_id == $subCategory->id)>
                                            {{$subCategory->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dinamik Parametreler -->
                <div id="dynamic-parameters" style="display: block;">
                    <!-- Parametreler buraya AJAX ile yüklenecek -->
                </div>


                <div class="mb-3">
                    <label class="form-label">Başlık</label>
                    <input type="text" class="form-control" name="title" value="{{ $service->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Açıklama</label>
                    <textarea name="description" class="form-control" rows="5" required
                    >{{ $service->description }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Ücret</label>
                            <input type="text" class="form-control" name="price" value="{{ $service->price }}" required>
                        </div>
                    </div>


                </div>

                <div class="mb-3">
                    <label class="form-label">Video Linki</label>
                    <input type="text" class="form-control" name="video_link" value="{{ $service->video_link }}">
                </div>

                <!-- Fotoğraf Düzenleme -->
                <div class="mb-3">
                    <label class="form-label">Fotoğraflar</label>
                    
                    <!-- Mevcut Fotoğraflar -->
                    @if($service->photos->count() > 0)
                        <div class="row mb-3">
                            @foreach($service->photos as $photo)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ asset($photo->path) }}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Dropzone Alanı -->
                    <div class="dropzone border border-dashed p-4 text-center" style="min-height: 150px;">
                        <div class="dz-message">
                            <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i><br>
                            Bilgisayardan Seç veya Sürükle Bırak<br>
                            <small class="text-muted">(En fazla 10 adet)</small>
                        </div>
                    </div>
                    
                    <input type="hidden" id="uploadedFiles" name="uploaded_files">
                    <input type="hidden" id="oldUploadedFiles" name="old_uploaded_files"
                           value="{{implode(',', collect($service->photos)->pluck('path')->toArray())}}">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">İl</label>
                            <select name="province_id" class="form-select" onchange="getDistricts()" required>
                                <option value="">İl</option>
                                @foreach(get_provinces() as $province)
                                    <option value="{{$province->id}}" @selected($service->province_id == $province->id)>
                                        {{$province->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">İlçe</label>
                            <div class="form-group">
                                <select name="district_id" class="form-select" id="district-select" required>
                                    <option value="">İlçe</option>

                                    @foreach(get_districts($service->province_id) as $district)
                                        <option
                                            value="{{$district->id}}" @selected($service->district_id == $district->id)>
                                            {{$district->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label">Durum</label>
                    <select name="status" class="form-select" required>
                        <option value="">Durum</option>
                        <option value="1" @selected($service->status == 1)>Aktif</option>
                        <option value="0" @selected($service->status == 0)>Pasif</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-success"><i class="bx bx-save"></i> Güncelle</button>
            </form>
        </div>
    </div>

    <script>
        // Sayfa yüklendiğinde parametreleri yükle
        document.addEventListener('DOMContentLoaded', function() {
            loadCategoryParameters();
        });

        // Pencere tamamen yüklendiğinde de çalıştır (emin olmak için)
        window.addEventListener('load', function() {
            loadCategoryParameters();
        });

        // Alt kategorileri getir
        function getSubCategories() {
            const categoryId = document.querySelector('select[name="category_id"]').value;
            const subCategorySelect = document.getElementById('sub-category-select');

            if (!categoryId) {
                subCategorySelect.innerHTML = '<option value="">Alt Kategori</option>';
                return;
            }

            fetch(`/get-sub-categories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Alt Kategori</option>';
                    data.forEach(subCategory => {
                        const selected = subCategory.id == {{ $service->sub_category_id }} ? 'selected' : '';
                        options += `<option value="${subCategory.id}" ${selected}>${subCategory.name}</option>`;
                    });
                    subCategorySelect.innerHTML = options;
                })
                .catch(error => {
                    console.error('Alt kategoriler yüklenirken hata:', error);
                });
        }

        // Kategori parametrelerini yükle
        function loadCategoryParameters() {
            const categoryId = document.querySelector('select[name="category_id"]').value;
            const parametersContainer = document.getElementById('dynamic-parameters');
            
            if (!categoryId) {
                parametersContainer.style.display = 'none';
                parametersContainer.innerHTML = '';
                return;
            }

            fetch(`/admin/services/category-parameters/${categoryId}`)
                .then(response => response.json())
                .then(parameters => {
                    if (parameters.length === 0) {
                        parametersContainer.style.display = 'none';
                        parametersContainer.innerHTML = '';
                        return;
                    }

                    // Mevcut parametre değerlerini al
                    const existingValues = @json($service->parameterValues->pluck('value', 'category_parameter_id'));

                    let html = '';
                    for (let i = 0; i < parameters.length; i += 2) {
                        html += '<div class="row">';
                        
                        // İlk parametre (sol)
                        const parameter1 = parameters[i];
                        const isRequired1 = parameter1.is_required == 1 || parameter1.is_required === true;
                        const value1 = existingValues[parameter1.id] || '';
                        html += '<div class="col-md-6"><div class="mb-3">';
                        if (parameter1.type === 'input') {
                            html += `
                                <label class="form-label">${parameter1.title}${isRequired1 ? ' *' : ''}</label>
                                <input type="text" name="parameters[${parameter1.id}]" value="${value1}" class="form-control" ${isRequired1 ? 'required' : ''}>
                            `;
                        } else if (parameter1.type === 'select' && parameter1.options) {
                            html += `
                                <label class="form-label">${parameter1.title}${isRequired1 ? ' *' : ''}</label>
                                <select name="parameters[${parameter1.id}]" class="form-control" ${isRequired1 ? 'required' : ''}>
                                    <option value="">${parameter1.title}${isRequired1 ? ' *' : ''}</option>
                            `;
                            parameter1.options.forEach(option => {
                                const selected = option === value1 ? 'selected' : '';
                                html += `<option value="${option}" ${selected}>${option}</option>`;
                            });
                            html += '</select>';
                        }
                        html += '</div></div>';
                        
                        // İkinci parametre (sağ) - eğer varsa
                        if (i + 1 < parameters.length) {
                            const parameter2 = parameters[i + 1];
                            const isRequired2 = parameter2.is_required == 1 || parameter2.is_required === true;
                            const value2 = existingValues[parameter2.id] || '';
                            html += '<div class="col-md-6"><div class="mb-3">';
                            if (parameter2.type === 'input') {
                                html += `
                                    <label class="form-label">${parameter2.title}${isRequired2 ? ' *' : ''}</label>
                                    <input type="text" name="parameters[${parameter2.id}]" value="${value2}" class="form-control" ${isRequired2 ? 'required' : ''}>
                                `;
                            } else if (parameter2.type === 'select' && parameter2.options) {
                                html += `
                                    <label class="form-label">${parameter2.title}${isRequired2 ? ' *' : ''}</label>
                                    <select name="parameters[${parameter2.id}]" class="form-control" ${isRequired2 ? 'required' : ''}>
                                        <option value="">${parameter2.title}${isRequired2 ? ' *' : ''}</option>
                                `;
                                parameter2.options.forEach(option => {
                                    const selected = option === value2 ? 'selected' : '';
                                    html += `<option value="${option}" ${selected}>${option}</option>`;
                                });
                                html += '</select>';
                            }
                            html += '</div></div>';
                        } else {
                            // Tek parametre varsa boş div ekle
                            html += '<div class="col-md-6"></div>';
                        }
                        
                        html += '</div>';
                    }

                    parametersContainer.innerHTML = html;
                    parametersContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('Admin: Parametreler yüklenirken hata:', error);
                    parametersContainer.style.display = 'none';
                });
        }
    </script>

    <!-- Dropzone Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        // Dropzone autoDiscover'ı hemen devre dışı bırak
        Dropzone.autoDiscover = false;
        
        document.addEventListener('DOMContentLoaded', function() {
            let uploadedFileNames = [];

            let myDropzone = new Dropzone(".dropzone", {
                url: "{{ route('admin.services.image-upload') }}",
                maxFilesize: 10,
                maxFiles: 10,
                acceptedFiles: "image/jpeg,image/jpg,image/png,image/webp",
                addRemoveLinks: true,
                dictDefaultMessage: "Bilgisayardan Seç veya Sürükle Bırak <br/> (En fazla 10 adet)",
                params: {
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                init: function () {
                    // Mevcut fotoğrafları Dropzone'a ekle
                    let existingPhotos = @json($service->photos);
                    
                    if (existingPhotos && existingPhotos.length > 0) {
                        existingPhotos.forEach(photo => {
                            let mockFile = { 
                                name: photo.path, 
                                size: 12345,
                                uploadedFileName: photo.path
                            };
                            
                            this.options.addedfile.call(this, mockFile);
                            this.options.thumbnail.call(this, mockFile, "{{ asset('') }}" + photo.path);
                            mockFile.previewElement.classList.add('dz-success', 'dz-complete');
                            
                            uploadedFileNames.push(photo.path);
                        });
                    }
                    
                    this.on("success", function (file, response) {
                        file.uploadedFileName = response.fileName;
                        uploadedFileNames.push(response.fileName);
                        updateHiddenInput();

                        // İkonları ekle
                        let iconContainer = document.createElement("div");
                        iconContainer.className = "custom-icons";

                        let dragIcon = document.createElement("i");
                        dragIcon.className = "fas fa-arrows-alt drag-icon";

                        let deleteIcon = document.createElement("i");
                        deleteIcon.className = "fas fa-trash-alt";

                        deleteIcon.addEventListener("click", function () {
                            myDropzone.removeFile(file);
                        });

                        iconContainer.appendChild(dragIcon);
                        iconContainer.appendChild(deleteIcon);

                        file.previewElement.appendChild(iconContainer);
                    });

                    this.on("removedfile", function (file) {
                        if (file.uploadedFileName) {
                            uploadedFileNames = uploadedFileNames.filter(e => e !== file.uploadedFileName);
                            updateHiddenInput();
                        }
                    });

                    this.on("addedfile", function () {
                        setTimeout(() => {
                            const previewsContainer = this.previewsContainer;

                            new Sortable(previewsContainer, {
                                animation: 150,
                                handle: '.drag-icon',
                                onUpdate: function () {
                                    let newOrder = [];
                                    previewsContainer.querySelectorAll('.dz-preview').forEach(previewEl => {
                                        const dropzoneFile = Dropzone.forElement(".dropzone").getAcceptedFiles().find(f => f.previewElement === previewEl);
                                        if (dropzoneFile && dropzoneFile.uploadedFileName) {
                                            newOrder.push(dropzoneFile.uploadedFileName);
                                        }
                                    });
                                    uploadedFileNames = newOrder;
                                    updateHiddenInput();
                                }
                            });
                        }, 100);
                    });
                }
            });

            function updateHiddenInput() {
                document.getElementById("uploadedFiles").value = uploadedFileNames.join(",");
            }
        });
    </script>
@endsection
