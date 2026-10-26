@extends('site.inc.master')

@section('css')
    {{--    <link rel="stylesheet" href="{{asset('assets/site/css/dropzone.min.css')}}">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        .main.sidebar {
            padding-left: 0;
        }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="profili-duzenle kurumsal-firma-hizmet-ekleme">
                {{--            <div class="hizmet-ekleme-pro">--}}
                {{--                <h1>--}}
                {{--                    Hizmet eklemek için <b>Pro Üye</b> olmalısınız--}}
                {{--                </h1>--}}
                {{--                <div>--}}
                {{--                    <a href="pro-paketler.html">--}}
                {{--                        Paketleri İncele--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                <div class="profili-duzenle-box bg-white">
                    <div class="profili-duzene-title d-flex">
                        <div class="pdt-left">
                            <a href="{{route('company.services.index')}}">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                            <span>Hizmet Düzenleme
                                <span id="remaining-right" class="ms-5">{{$remainingRightMsg}}</span>
                            </span>

                        </div>
                    </div>
                    <div class="profili-duzenle-form">
                        <div class="pdf-form-right w-100">
                            <form action="{{route('company.services.update', $service->id)}}" method="POST"
                                  enctype="multipart/form-data">
                                @method('PUT')
                                <x-input-error-site/>

                                <div class="pdf-form-inputs d-flex login-modal-box">
                                    <div class="form-group">
                                        <select name="category_id" class="form-select" onchange="getSubCategories(); loadCategoryParameters();"
                                                required>
                                            <option value="">Kategori</option>
                                            @foreach(get_categories(true) as $category)
                                                <option
                                                        value="{{$category->id}}" @selected($service->category_id == $category->id)>
                                                    {{$category->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select name="sub_category_id" class="form-select"
                                                id="sub-category-select" required>
                                            @foreach(get_sub_categories($service->category_id) as $subCategory)
                                                <option value="{{$subCategory->id}}" @selected($service->sub_category_id == $subCategory->id)>
                                                    {{$subCategory->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <!-- Dinamik Parametreler -->
                                <div id="dynamic-parameters" style="display: block;">
                                    <!-- Parametreler buraya AJAX ile yüklenecek -->
                                </div>

                                <div class="pdf-form-inputs d-flex login-modal-box full-width ps-0 ps-md-2">
                                    <div class="form-group required full-width width-edit ms-0 ms-md-2">
                                        <div class="input-field">
                                            <input type="text" name="title" value="{{$service->title}}" required="">
                                            <label>Başlık</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="pdf-form-inputs d-flex login-modal-box quarter-witdh-flex" style="align-items: flex-start;">
                                    <div class="form-group select-width required">
                                        <textarea name="description" placeholder="Açıklama" required class="form-control" rows="4"
                                        >{{$service->description}}</textarea>
                                    </div>
                                    <div class="form-group select-width">
                                        <div class="input-field">
                                            <input type="text" value="{{format_decimal_input($service->price)['visible']}}"
                                                   required oninput="priceEdit(event)">
                                            <input type="hidden" name="price"
                                                   value="{{format_decimal_input($service->price)['raw']}}"
                                                   class="price-area">
                                            <label>Fiyat</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="pdf-form-inputs d-flex login-modal-box quarter-witdh-flex">
                                    <div class="form-group select-width">
                                        <select name="status" class="form-select" required>
                                            <option value="">Durum</option>
                                            <option value="1" @selected($service->status == 1)>Aktif</option>
                                            <option value="0" @selected($service->status == 0)>Pasif</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-field">
                                            <input type="text" name="video_link" value="{{$service->video_link}}">
                                            <label>Video Linki</label>
                                        </div>
                                    </div>
                                </div>


                                <h3 class="profil-konum kfhe-konum">
                                    Konum
                                </h3>
                                <div class="pdf-form-inputs d-flex login-modal-box quarter-witdh-flex">
                                    <div class="form-group select-width">
                                        <select name="province_id" class="form-select" onchange="getDistricts()"
                                                required>
                                            <option value="">İl</option>
                                            @foreach(get_provinces() as $province)
                                                <option
                                                        value="{{$province->id}}" @selected($service->province_id == $province->id)>
                                                    {{$province->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group select-width">
                                        <select name="district_id" class="form-select" id="district-select" required>
                                            <option value="">İlçe</option>

                                            @foreach(get_districts($service->province_id) as $district)
                                                <option value="{{$district->id}}"
                                                        @selected($service->district_id == $district->id)>
                                                    {{$district->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <h3 class="profil-konum kfhe-konum">Fotoğraf Ekle</h3>

                                <div id="old-files-container" class="d-flex flex-wrap">
                                    @foreach($service->photos as $photo)
                                        <div class="kfhe-photo-add-box me-5 file-container" data-img="{{$photo->path}}">
                                            <button type="button"
                                                    onclick="removeFileFromInput('oldUploadedFiles', '{{$photo->path}}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                            <button type="button" style="top: 10px; right: 50px; background-color: #4068e2;">
                                                <i class="fas fa-arrows-alt drag-icon"></i>
                                            </button>

                                            <img src="{{ asset($photo->path) }}" width="250" height="150">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="dropzone"></div>

                                <input type="hidden" id="uploadedFiles" name="uploaded_files">
                                <input type="hidden" id="oldUploadedFiles" name="old_uploaded_files"
                                       value="{{implode(',', collect($service->photos)->pluck('path')->toArray())}}">

                                @csrf
                                <div class="profili-duzenle-save">
                                    <button type="submit">Yayınla</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    {{--    <script type="text/javascript" src="{{asset('assets/site/js/dropzone.min.js')}}"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        document.querySelector('select[name="category_id"]').addEventListener('change', e => {
            const remainingRight = document.querySelector('#remaining-right');

            if (e.target.value) {
                fetch("/company/services/rights/" + event.target.value, {
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.category_name) {
                            remainingRight.textContent = `${data.category_name} kategorisinde
                            (${data.remaining_right}/${data.total_right}) hakkınız bulunmaktadır.`;
                        }
                    })

            } else {
                remainingRight.textContent = "";
            }
        });
    </script>

    <script>
        let uploadedFileNames = [];

        let myDropzone = new Dropzone(".dropzone", {
            url: "{{ route('company.services.image-upload') }}",
            maxFilesize: 10,
            maxFiles: 10,
            acceptedFiles: "image/jpeg,image/jpg,image/png,image/webp",
            addRemoveLinks: false, // <-- Varsayılan butonları kapattık
            dictDefaultMessage: "Bilgisayardan Seç veya Sürükle Bırak <br/> (En fazla 10 adet)",
            params: {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            init: function () {
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
                            handle: '.drag-icon', // sadece bu ikonla sürüklenebilir
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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('old-files-container');
            const hiddenInput = document.getElementById('oldUploadedFiles');

            new Sortable(container, {
                animation: 150,
                handle: '.drag-icon',
                onUpdate: function () {
                    updateHiddenInputFromOrder();
                }
            });

            function updateHiddenInputFromOrder() {
                const allBoxes = container.querySelectorAll('.file-container');
                const newOrder = Array.from(allBoxes).map(box => box.getAttribute('data-img'));
                hiddenInput.value = newOrder.join(',');
            }

            window.removeFileFromInput = function (inputId, pathToRemove) {
                const input = document.getElementById(inputId);
                let values = input.value.split(',');
                values = values.filter(p => p !== pathToRemove);
                input.value = values.join(',');

                // DOM'dan da kaldır
                const boxToRemove = document.querySelector(`.file-container[data-img="${pathToRemove}"]`);
                if (boxToRemove) boxToRemove.remove();

                updateHiddenInputFromOrder();
            }
        });
    </script>

    <script>
        // Girilen fiyatın en başta güncellenmesi için fonksiyonu çağırıyoruz.
        // priceEdit() - Bu satır kaldırıldı çünkü event objesi gerekiyor

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
            
            console.log('Loading parameters for category:', categoryId);
            
            if (!categoryId) {
                console.log('No category selected');
                parametersContainer.style.display = 'none';
                parametersContainer.innerHTML = '';
                return;
            }

            fetch(`/company/services/category-parameters/${categoryId}`)
                .then(response => response.json())
                .then(parameters => {
                    console.log('Loaded parameters:', parameters);
                    if (parameters.length === 0) {
                        console.log('No parameters found for this category');
                        parametersContainer.style.display = 'none';
                        parametersContainer.innerHTML = '';
                        return;
                    }

                    // Mevcut parametre değerlerini al
                    const existingValues = @json($service->parameterValues->pluck('value', 'category_parameter_id'));

                    let html = '';
                    for (let i = 0; i < parameters.length; i += 2) {
                        html += '<div class="pdf-form-inputs d-flex login-modal-box">';
                        
                        // İlk parametre (sol)
                        const parameter1 = parameters[i];
                        const isRequired1 = parameter1.is_required == 1 || parameter1.is_required === true;
                        const value1 = existingValues[parameter1.id] || '';
                        html += '<div class="form-group">';
                        if (parameter1.type === 'input') {
                            html += `
                                <div class="input-field">
                                    <input type="text" name="parameters[${parameter1.id}]" value="${value1}" ${isRequired1 ? 'required' : ''}>
                                    <label>${parameter1.title}${isRequired1 ? ' *' : ''}</label>
                                </div>
                            `;
                        } else if (parameter1.type === 'select' && parameter1.options) {
                            html += `
                                <select name="parameters[${parameter1.id}]" class="form-select" ${isRequired1 ? 'required' : ''}>
                                    <option value="">${parameter1.title}${isRequired1 ? ' *' : ''}</option>
                            `;
                            parameter1.options.forEach(option => {
                                const selected = option === value1 ? 'selected' : '';
                                html += `<option value="${option}" ${selected}>${option}</option>`;
                            });
                            html += '</select>';
                        }
                        html += '</div>';
                        
                        // İkinci parametre (sağ) - eğer varsa
                        if (i + 1 < parameters.length) {
                            const parameter2 = parameters[i + 1];
                            const isRequired2 = parameter2.is_required == 1 || parameter2.is_required === true;
                            const value2 = existingValues[parameter2.id] || '';
                            html += '<div class="form-group">';
                            if (parameter2.type === 'input') {
                                html += `
                                    <div class="input-field">
                                        <input type="text" name="parameters[${parameter2.id}]" value="${value2}" ${isRequired2 ? 'required' : ''}>
                                        <label>${parameter2.title}${isRequired2 ? ' *' : ''}</label>
                                    </div>
                                `;
                            } else if (parameter2.type === 'select' && parameter2.options) {
                                html += `
                                    <select name="parameters[${parameter2.id}]" class="form-select" ${isRequired2 ? 'required' : ''}>
                                        <option value="">${parameter2.title}${isRequired2 ? ' *' : ''}</option>
                                `;
                                parameter2.options.forEach(option => {
                                    const selected = option === value2 ? 'selected' : '';
                                    html += `<option value="${option}" ${selected}>${option}</option>`;
                                });
                                html += '</select>';
                            }
                            html += '</div>';
                        } else {
                            // Tek parametre varsa boş div ekle
                            html += '<div class="form-group"></div>';
                        }
                        
                        html += '</div>';
                    }

                    parametersContainer.innerHTML = html;
                    parametersContainer.style.display = 'block';
                })
                .catch(error => {
                    console.error('Parametreler yüklenirken hata:', error);
                    parametersContainer.style.display = 'none';
                });
        }

        // Sayfa yüklendiğinde parametreleri yükle
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, current category:', document.querySelector('select[name="category_id"]').value);
            loadCategoryParameters();
        });

        // Pencere tamamen yüklendiğinde de çalıştır (emin olmak için)
        window.addEventListener('load', function() {
            console.log('Window fully loaded, loading parameters again');
            loadCategoryParameters();
        });
    </script>
@endsection
