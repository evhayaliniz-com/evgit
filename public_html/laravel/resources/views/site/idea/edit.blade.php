@extends('site.inc.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
          integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>


    <style>
        .main.sidebar {
            padding-left: 0;
        }

        .dropzone.dz-clickable {
            background-color: #fff !important;
        }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="hakkimizda fikir-olustur" style="background-color: #f0f7ff;">
                <div class="container">
                    <form action="{{route('idea.update', $idea->id)}}" method="POST" enctype="multipart/form-data"
                          onsubmit="checkFileUpload()">
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hakkimizda-box fikir-olustur-box mx-auto">
                                    <h1>Fikir Oluştur</h1>
                                    <div class="vision-mission-box fikir-olustur-box bg-white">
                                        <x-input-error-site/>

                                        <div class="fikir-olustur-top d-flex">
                                            <div class="fikir-olustur-left">
                                                <div class="form-group">
                                                    <select name="category_id" class="form-select" onchange="getSubCategories()">
                                                        <option value="">Kategori</option>
                                                        @foreach(get_categories() as $category)
                                                            <option value="{{$category->id}}"
                                                                @selected($category->id == $idea->category_id)>
                                                                {{$category->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="fikir-olustur-right">
                                                <div class="form-group">
                                                    <select name="sub_category_id" class="form-select" id="sub-category-select">
                                                        <option value="">Alt Kategori</option>
                                                        @if($idea->category_id)
                                                            @foreach(get_sub_categories($idea->category_id) as $subCategory)
                                                                <option value="{{$subCategory->id}}"
                                                                    @selected($subCategory->id == $idea->sub_category_id)>
                                                                    {{$subCategory->name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fikir-olustur-bottom bg-white">
                                        <!--<div class="form-group">-->
                                        <!--    <input type="text" name="title" value="{{old('title', $idea->title)}}"-->
                                        <!--           class="bg-white" placeholder="Başlık" required="">-->
                                        <!--</div>-->

                                        <textarea name="content" class="form-control mb-3" placeholder="İçerik"
                                                  required>{{old('content', $idea->content)}}</textarea>

                                        <div class="form-group">
                                            <select name="status" class="form-select" required>
                                                <option value="1" @selected($idea->status == 1)>Herkese Açık</option>
                                                <option value="0" @selected($idea->status == 0)>Sadece Ben</option>
                                            </select>
                                        </div>


                                        @if($idea->path)
{{--                                        <div id="sortable-files" class="d-flex flex-wrap">--}}
{{--                                                @foreach(json_decode($idea->path, true) as $path)--}}
{{--                                                    <div class="kfhe-photo-add-box me-5 file-container" data-path="{{$path}}">--}}
{{--                                                        <button type="button"--}}
{{--                                                                onclick="removeFileFromInput('oldUploadedFiles', '{{$path}}')">--}}
{{--                                                            <i class="fa-solid fa-trash"></i>--}}
{{--                                                        </button>--}}

{{--                                                        <button type="button" style="top: 10px; right: 50px; background-color: #4068e2;">--}}
{{--                                                            <i class="fas fa-arrows-alt drag-icon"></i>--}}
{{--                                                        </button>--}}
{{--                                            --}}
{{--                                                        @if(get_file_extension($path) != 'mp4')--}}
{{--                                                            <img src="{{asset($path)}}" width="250" height="150">--}}
{{--                                                        @else--}}
{{--                                                            <video controls width="250">--}}
{{--                                                                <source src="{{asset($path)}}" type="video/mp4"/>--}}
{{--                                                            </video>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}
{{--                                                @endforeach--}}
{{--                                            </div>--}}

                                            <div id="old-files-container" class="d-flex flex-wrap">
                                                @foreach(json_decode($idea->path, true) as $path)
                                                    <div class="kfhe-photo-add-box me-5 file-container" data-img="{{$path}}">
                                                        <button type="button"
                                                                onclick="removeFileFromInput('oldUploadedFiles', '{{$path}}')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>

                                                        <button type="button" style="top: 10px; right: 50px; background-color: #4068e2;">
                                                            <i class="fas fa-arrows-alt drag-icon"></i>
                                                        </button>

                                                        <img src="{{ asset($path) }}" width="250" height="150">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="fikir-olustur-file-upload khfe-file-input bg-white">
{{--                                            <div class="image-upload">--}}
{{--                                                <label for="file-input">--}}
{{--                                                    <b id="file-info-area">Resim &amp; Video Ekle--}}
{{--                                                        <i class="fa-solid fa-image"></i>--}}
{{--                                                        <br>--}}
{{--                                                        (En fazla 4 dosya yüklenebilir. Dosya boyutu 5mb'den az--}}
{{--                                                        olmalıdır.)--}}
{{--                                                    </b>--}}
{{--                                                </label>--}}
{{--                                                <input name="path[]" id="file-input" type="file" multiple--}}
{{--                                                       accept="image/jpeg,image/png,video/mp4">--}}
{{--                                            </div>--}}

                                            <div class="dropzone"></div>

                                            <input type="hidden" id="uploadedFiles" name="uploaded_files">
                                            <input type="hidden" id="oldUploadedFiles" name="old_uploaded_files"
                                                   value="{{implode(',', json_decode($idea->path))}}">
                                        </div>

                                        @csrf
                                        <button type="submit">Yayınla</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

{{--    <script>--}}
{{--        document.getElementById("file-input").addEventListener("change", function () {--}}
{{--            let count = this.files.length;--}}
{{--            let fileCountText = document.getElementById("file-info-area");--}}

{{--            if (count > 0) {--}}
{{--                fileCountText.textContent = `${count} dosya seçildi`;--}}
{{--            } else {--}}
{{--                fileCountText.innerHTML = `Resim &amp; Video Ekle <i class='fa-solid fa-image'></i><br>--}}
{{--                (En fazla 4 dosya yüklenebilir. Dosya boyutu 5mb'den az--}}
{{--                olmalıdır.)`;--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}


    <script>
        function countNewlyUploadedFiles() {
            const uploaded = document.getElementById('uploadedFiles').value;
            const oldUploaded = document.getElementById('oldUploadedFiles').value;

            const uploadedArray = uploaded ? uploaded.split(',') : [];
            const oldUploadedArray = oldUploaded ? oldUploaded.split(',') : [];

            const newCount = 4 - (oldUploadedArray.length + uploadedArray.length);
            return newCount;
        }
    </script>


    <script>
        let uploadedFileNames = [];

        let myDropzone = new Dropzone(".dropzone", {
            url: "{{ route('company.services.image-upload') }}",
            maxFilesize: 10,
            maxFiles: countNewlyUploadedFiles(),
            acceptedFiles: "image/jpeg,image/jpg,image/png,image/webp",
            addRemoveLinks: false, // <-- Varsayılan butonları kapattık
            dictDefaultMessage: "Bilgisayardan Seç veya Sürükle Bırak <br/> (En fazla 4 adet)",
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



{{--    <script>--}}
{{--        const sortable = new Sortable(document.getElementById('sortable-files'), {--}}
{{--        handle: '.drag-icon', // sadece ikon üzerinden sürükleme--}}
{{--        animation: 150,--}}
{{--        onEnd: function () {--}}
{{--            updateOldHiddenInput();--}}
{{--        }--}}
{{--    });--}}

{{--    function updateOldHiddenInput() {--}}
{{--        const containers = document.querySelectorAll('#sortable-files .file-container');--}}
{{--        const paths = Array.from(containers).map(container => container.dataset.path);--}}
{{--        document.getElementById('oldUploadedFiles').value = paths.join(',');--}}
{{--    }--}}

{{--    function removeFileFromInput(inputId, filePath) {--}}
{{--        let input = document.getElementById(inputId);--}}
{{--        let paths = input.value.split(',');--}}
{{--        paths = paths.filter(path => path !== filePath);--}}
{{--        input.value = paths.join(',');--}}

{{--        // DOM'dan kaldır--}}
{{--        const target = document.querySelector(`[data-path="${filePath}"]`);--}}
{{--        if (target) target.remove();--}}

{{--        // yeniden sırala--}}
{{--        updateOldHiddenInput();--}}
{{--    }--}}
{{--    </script>--}}
@endsection
