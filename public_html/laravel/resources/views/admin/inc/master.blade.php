<!DOCTYPE html>


<html lang="tr" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{request()->getSchemeAndHttpHost()}}/admin/assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>Yönetim Paneli</title>

    <meta name="description" content=""/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/img/favicon/favicon2.ico"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/fonts/boxicons.css"/>
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/fonts/fontawesome.css"/>
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/fonts/flag-icons.css"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/css/rtl/core.css"
          class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/css/rtl/theme-default.css"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/css/demo.css"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet"
          href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/typeahead-js/typeahead.css"/>
    <link rel="stylesheet" href="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/apex-charts/apex-charts.css"/>


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/js/config.js"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>



    @yield('css')
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        <!-- Navbar -->

        @include('admin.inc.navbar');

        <!-- / Navbar -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Menu -->
                @include('admin.inc.aside');
                <!-- / Menu -->

                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')
                </div>
                <!--/ Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div
                        class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by
                            <a href="#" target="_blank" class="footer-link fw-medium">Adapazarı</a>
                        </div>
                        <div class="d-none d-lg-inline-block">
                            <a href="#" class="footer-link me-4" target="_blank">License</a>


                            <a href="#" target="_blank" class="footer-link me-4">Documentation</a>

                            <a href="#" target="_blank"
                               class="footer-link d-none d-sm-inline-block">Support</a>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!--/ Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/jquery/jquery.js"></script>

<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/popper/popper.js"></script>
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/js/bootstrap.js"></script>
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/hammer/hammer.js"></script>
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/i18n/i18n.js"></script>
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/js/menu.js"></script>


<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{request()->getSchemeAndHttpHost()}}/admin/assets/js/dashboards-analytics.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('js')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.querySelector('[data-notification-list]');
        const toggle = document.getElementById('admin-notification-toggle');

        if (!dropdown || !toggle) {
            return;
        }

        let markedIds = new Set();

        const sendRequest = () => {
            if (markedIds.size === 0) {
                return;
            }

            const ids = Array.from(markedIds);
            markedIds = new Set();

            $.ajax({
                url: '{{ route('admin.notifications.read') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids,
                },
                success: function () {
                    ids.forEach(function (id) {
                        const item = dropdown.querySelector('[data-notification-id="' + id + '"]');
                        if (item) {
                            item.classList.remove('bg-light');
                            item.setAttribute('data-notification-id', '');
                        }
                    });

                    const badge = toggle.querySelector('.badge-notifications');
                    if (badge) {
                        const remaining = dropdown.querySelectorAll('[data-notification-id]:not([data-notification-id=""])').length;
                        if (remaining > 0) {
                            badge.textContent = remaining;
                        } else {
                            badge.remove();
                        }
                    }
                }
            });
        };

        toggle.addEventListener('click', function () {
            const unreadItems = dropdown.querySelectorAll('[data-notification-id]');
            unreadItems.forEach(function (item) {
                const id = item.getAttribute('data-notification-id');
                if (id) {
                    markedIds.add(id);
                }
            });

            setTimeout(sendRequest, 200);
        });
    });
</script>
</body>

</html>
<script>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
        toastr.error(" {{ $error }} ")
    @endforeach
    @endif


    @if(session()->has('success'))
        toastr.success(" {{ session()->get('success') }} ")
    @endif

    @if(session()->has('error'))
        toastr.error(" {{ session()->get('error') }} ")
    @endif
</script>

<!-- CKEditor CDN -->
<script src="{{request()->getSchemeAndHttpHost()}}/ckeditor/ckeditor.js"></script>
<script>
    // Sadece editor elementi varsa CKEditor'ı başlat
    if (document.getElementById('editor')) {
        CKEDITOR.replace('editor');
    }
</script>


<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function addRow() {
        let container = event.currentTarget.closest('.multi-container').querySelector(".input-container");
        let firstRow = container.querySelector(".input-group");

        // Yeni elemanı kopyala ve içindeki input değerlerini sıfırla
        let newRow = firstRow.cloneNode(true);
        let inputs = newRow.querySelectorAll("input");
        inputs.forEach(input => input.value = "");

        container.appendChild(newRow);
    }

    function removeRow(button) {
        let container = event.currentTarget.closest('.multi-container').querySelector(".input-container");
        let rows = container.querySelectorAll(".input-group");

        if (rows.length > 1) {
            button.parentElement.remove();
        }
    }


    function getSubCategories() {
        const subCategorySelect = document.querySelector('#sub-category-select');

        subCategorySelect.innerHTML = "";
        

        fetch("/sub-categories/" + event.target.value, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
        })
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML = "";

                let opt = document.createElement('option');
                opt.value = "";
                opt.textContent = "Alt Kategori";
                subCategorySelect.appendChild(opt);

                if (data.length > 0) {
                    data.forEach(e => {
                        opt = document.createElement('option');
                        opt.value = e.id;
                        opt.textContent = e.name;
                        subCategorySelect.appendChild(opt);
                    })
                }
            })
    }


    function getDistricts() {
        const districtSelect = document.querySelector('#district-select');

        fetch("/districts/" + event.target.value, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
        })
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = "";

                let opt = document.createElement('option');
                opt.value = "";
                opt.textContent = "İlçe";
                districtSelect.appendChild(opt);

                if (data.length > 0) {
                    data.forEach(e => {
                        opt = document.createElement('option');
                        opt.value = e.id;
                        opt.textContent = e.name;
                        districtSelect.appendChild(opt);
                    })
                }
            })
    }

    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
