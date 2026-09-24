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

        /* Dropzone silme butonunu görünür yapalım */
        .dz-remove {
            display: inline-block !important;
            margin-top: 10px;
            font-size: 14px;
            color: #e3342f;
            font-weight: bold;
            cursor: pointer;
            text-decoration: underline;
        }

    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="hakkimizda index-right fikir-olustur">
                <div class="container">
                    <form action="{{route('idea.store')}}" method="POST" enctype="multipart/form-data"
                          onsubmit="return checkFileUpload(event)">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hakkimizda-box fikir-olustur-box mx-auto">
                                    <h1>
                                        Fikir Oluştur
                                    </h1>
                                    <div class="vision-mission-box fikir-olustur-box bg-white">
                                        <x-input-error-site/>

                                        <div class="fikir-olustur-top d-flex">
                                            <div class="fikir-olustur-left">
                                                <div class="form-group">
                                                    <select name="category_id" class="form-select" onchange="getSubCategories()">
                                                        <option value="">Kategori</option>
                                                        @foreach(get_categories() as $category)
                                                            <option
                                                                value="{{$category->id}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="fikir-olustur-right">
                                                <div class="form-group">
                                                    <select name="sub_category_id" class="form-select" id="sub-category-select">
                                                        <option value="">Alt Kategori</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fikir-olustur-bottom bg-white">
                                        <textarea name="content" class="form-control mb-3" placeholder="İçerik"
                                                  required>{{old('content')}}</textarea>

                                        <div class="form-group">
                                            <select name="status" class="form-select" required>
                                                <option value="1">Herkese Açık</option>
                                                <option value="0">Sadece Ben</option>
                                            </select>
                                        </div>

                                        <div class="fikir-olustur-file-upload khfe-file-input bg-white">
                                            <div class="dropzone"></div>
                                            <input type="hidden" id="uploadedFiles" name="uploaded_files">


{{--                                            <div class="image-upload">--}}
{{--                                                <label for="file-input">--}}
{{--                                                    <b id="file-info-area">Resim &amp; Video Ekle <i class="fa-solid fa-image"></i><br>--}}
{{--                                                        (En fazla 4 dosya yüklenebilir. Dosya boyutu 5mb'den az--}}
{{--                                                        olmalıdır.)--}}
{{--                                                    </b>--}}
{{--                                                </label>--}}
{{--                                                <input name="path[]" id="file-input" type="file" multiple--}}
{{--                                                       accept="image/jpeg,image/png,video/mp4">--}}
{{--                                            </div>--}}
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
    {{--    <script type="text/javascript" src="{{asset('assets/site/js/dropzone.min.js')}}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"
            integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>



    <script>
        Dropzone.autoDiscover = false;

        let uploadedFileNames = [];

        let myDropzone = new Dropzone(".dropzone", {
            url: "{{ route('idea.image-upload') }}",
            maxFilesize: 10,
            maxFiles: 4,
            acceptedFiles: "image/jpeg,image/jpg,image/png,image/webp",
            addRemoveLinks: false, // ÖNEMLİ: kendi butonumuzu kullanacağız
            dictDefaultMessage: "Bilgisayardan Seç veya Sürükle Bırak <br/> (En fazla 4 adet)",
            params: {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            init: function () {
                this.on("maxfilesexceeded", function (file) {
                    this.removeFile(file);
                    alert("En fazla 4 dosya yükleyebilirsiniz.");
                });

                this.on("addedfile", function (file) {
                    if (this.files.length > 4) {
                        this.removeFile(file);
                        alert("Sadece 4 dosya seçebilirsiniz.");
                    }
                });
                this.on("success", function (file, response) {
                    file.uploadedFileName = response.fileName;
                    uploadedFileNames.push(response.fileName);
                    updateHiddenInput();

                    // Silme ve sürükleme ikonlarını ekle
                    let iconContainer = document.createElement("div");
                    iconContainer.className = "custom-icons";

                    let dragIcon = document.createElement("i");
                    dragIcon.className = "fas fa-arrows-alt drag-icon";

                    let deleteIcon = document.createElement("i");
                    deleteIcon.className = "fas fa-trash-alt";
                    deleteIcon.style.cursor = 'pointer';
                    deleteIcon.style.marginLeft = '10px';

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

        // 2) checkFileUpload fonksiyonu: Dropzone üzerinden kontrol yapıyor
        function checkFileUpload(e) {
            const dz = window.myDropzone;
            if (!dz) return true; // Dropzone yoksa normal gönder

            // Kabul edilmiş dosya sayısı
            const acceptedCount = dz.getAcceptedFiles().length;
            // Hâlâ yüklenmekte olan dosya sayısı
            const uploadingCount = dz.getUploadingFiles().length;

            if (acceptedCount === 0) {
                alert('En az 1 adet dosya yüklemelisiniz.');
                e.preventDefault();
                return false;
            }

            if (uploadingCount > 0) {
                alert('Dosyalar hâlen yükleniyor, lütfen yükleme bitene kadar bekleyin.');
                e.preventDefault();
                return false;
            }

            return true; // en az 1 dosya var ve hepsi yüklendi → form gitsin
        }
    </script>
@endsection
