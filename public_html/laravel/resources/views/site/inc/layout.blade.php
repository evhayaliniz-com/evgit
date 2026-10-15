<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">

<head>

    <meta charset="utf-8">
    @yield('meta')
    <title>Ev Hayaliniz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" type="text/css" href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/css/fancybox.css">
    <link rel="stylesheet" type="text/css" href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/css/swiper.css">
    <link rel="stylesheet" type="text/css" href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/css/main.css?v={{ file_exists(public_path('site/css/main.css')) ? filemtime(public_path('site/css/main.css')) : time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    @yield('css')
</head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LB9ZQ4XC83"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-LB9ZQ4XC83');
</script>

<body>

    @yield('content')

    <div class="modal fade fikirhizmetmodal" id="fikirhizmetmodal" tabindex="-1"
        aria-labelledby="fikirhizmetmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="addservicesmodal">
                        <div>
                            <a href="fikir-olustur.html">
                                Fikir Ekle
                            </a>
                        </div>
                        <div>
                            <a href="hizmet-ekle.html">
                                Hizmet Ekle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade login-modal" id="exampleModalToggle" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Giriş Yap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="login-modal-box">
                        <x-input-error-site />

                        <form action="{{route('login')}}" method="POST">
                            <div class="login-form">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="email" name="email" required="">
                                        <label>E-Posta</label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-field">
                                        <input id="input_box2" type="password" name="password" required="">
                                        <label>Şifre</label>
                                        <span toggle="#input_box2"
                                            class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <div class="rememberme-forget-pass">
                                    <div class="remember-me">
                                        <label class="remember-label">
                                            <input type="checkbox" name="checkbox" />
                                            Oturumum Açık Kalsın
                                        </label>
                                    </div>
                                    <div class="forget-pass">
                                        <a href="sifremi-unuttum.html">
                                            Şifremi Unuttum!
                                        </a>
                                    </div>
                                </div>

                                @csrf
                                <div class="login-button">
                                    <button type="submit">
                                        Giriş Yap
                                    </button>
                                </div>
                                <div class="or">
                                    <span>Veya</span>
                                </div>
                                <div class="other-logins">
                                    <div class="other-logins-buttons">
                                        <a href="{{url('auth/google')}}">
                                            <button type="button">
                                                <img src="images/google.svg" alt="">
                                                <span>
                                                    Google ile giriş yap
                                                </span>
                                            </button>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mf-flex">
                        <span>
                            Henüz hesabın yok mu?
                        </span>

                        <button class="login-toggle-button" data-bs-target="#exampleModalToggle2"
                            data-bs-toggle="modal" data-bs-dismiss="modal">Hesap Aç
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade login-modal register-modal" id="exampleModalToggle2" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Hesap Aç</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav>
                        <div class="nav nav-tabs register-nav" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab"
                                aria-controls="nav-home" aria-selected="true">Bireysel
                            </button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab"
                                aria-controls="nav-profile" aria-selected="false">Kurumsal
                            </button>
                        </div>
                    </nav>
                    <div class="tab-content register-tab" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="login-modal-box">
                                <x-input-error-site />

                                <form action="{{route('register')}}" method="POST">
                                    <div class="login-form">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input type="text" name="name" required="">
                                                <label>Ad - Soyad</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input type="email" name="email" required="">
                                                <label>E-Posta</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="text" name="verification_code" id="user_verification_code" placeholder="6 haneli kod">
                                                        <label>Doğrulama Kodu</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary w-100" style="margin-top: 0; font-size: 0.75rem; padding: 0.5rem 0.25rem;">
                                                        Kod Gönder
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box3" type="password" name="password"
                                                    required="">
                                                <label>Şifre</label>

                                                <span toggle="#input_box3"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box4" type="password" name="password_confirmation"
                                                    required="">
                                                <label>Şifre Tekrar</label>

                                                <span id="inputbox4passtoggle" toggle="#input_box4"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                        <div class="rememberme-forget-pass user-agreement">
                                            <div class="remember-me">
                                                <label class="remember-label">
                                                    <input type="checkbox" name="register_checkbox" required />
                                                    <div class="ua-box">
                                                        <a target="_blank" href="kullanici-sozlesmesi.html">
                                                            <b>Kullanıcı Sözleşmesi'ni</b>
                                                            okudum kabul ediyorum.
                                                        </a>

                                                    </div>

                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin: 20px 0 30px 0; text-align: center;">
                                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" style="display: inline-block;"></div>
                                        </div>

                                        <input type="hidden" name="user_type" value="user">

                                        @csrf
                                        <div class="login-button">
                                            <button type="submit" id="user_register_button" disabled>Kayıt Ol</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                            aria-labelledby="nav-profile-tab">
                            <div class="login-modal-box">
                                <x-input-error-site />

                                <form action="{{route('register')}}" method="POST">
                                    <div class="login-form">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="name" required="">
                                                    <label>Firma Adı</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="autorized" required="">
                                                    <label>Yetkili Adı</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="email" name="email" required="">
                                                    <label>E-Posta</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="text" name="verification_code" id="company_verification_code" placeholder="6 haneli kod">
                                                        <label>Doğrulama Kodu</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary w-100" style="margin-top: 0; font-size: 0.75rem; padding: 0.5rem 0.25rem;">
                                                        Kod Gönder
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box5" type="password" name="password"
                                                    required="">
                                                <label>Şifre</label>
                                                <span toggle="#input_box5"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box6" type="password" name="password_confirmation"
                                                    required="">
                                                <label>Şifre Tekrar</label>

                                                <span id="inputbox4passtoggle" toggle="#input_box6"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="fixed_phone">
                                                    <label>Sabit Telefon</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="mobile_phone">
                                                    <label>Telefon Numarası</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="tax_number">
                                                    <label>Vergi Numarası</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="login-select">
                                            <select name="province" class="form-select" required>
                                                <option selected>İl</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>

                                        <div class="login-select">
                                            <select name="district" class="form-select" required>
                                                <option selected>İlçe</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="address" required>
                                                    <label>Adres</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <div class="input-field">
                                                            <input type="text" name="lat">
                                                            <label>Harita Enlem</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-3 mt-md-0">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <div class="input-field">
                                                            <input type="text" name="lng">
                                                            <label>Harita Boylam</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="login-select">
                                            <select name="category_id" class="form-select" required>
                                                <option selected>Kategori</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>

                                        <div class="login-select">
                                            <select name="sub_category_id" class="form-select" required>
                                                <option selected>Alt Kategori</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                        </div>

                                        <div class="rememberme-forget-pass user-agreement">
                                            <div class="remember-me">
                                                <label class="remember-label">
                                                    <input type="checkbox" name="register_checkbox" required />
                                                    <div class="ua-box">
                                                        <a target="_blank" href="kullanici-sozlesmesi.html">
                                                            <b>Kullanıcı Sözleşmesi'ni</b> okudum kabul ediyorum.
                                                        </a>
                                                    </div>

                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin: 20px 0 30px 0; text-align: center;">
                                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" style="display: inline-block;"></div>
                                        </div>

                                        <input type="hidden" name="user_type" value="company">

                                        @csrf
                                        <div class="login-button">
                                            <button type="submit" id="company_register_button" disabled>Kayıt Ol</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mf-flex">
                        <span>
                            Zaten hesabın var mı?
                        </span>

                        <button class="login-toggle-button" data-bs-target="#exampleModalToggle"
                            data-bs-toggle="modal" data-bs-dismiss="modal">Giriş yap
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kvkkmodal" tabindex="-1" aria-labelledby="kvkkmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kvkkmodalLabel">Kişisel Verilerin Korunması Hakkında</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    .....
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="aydinlatmametni" tabindex="-1" aria-labelledby="aydinlatmametniLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aydinlatmametniLabel">Aydınlatma Metni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} alıcı ve satıcıların elektronik ortamda ticaret yapabildikleri bir platformdur. Bu platformda yürürlükte olan tüm ticari kural ve kanunlar geçerlidir.
                    </p>
                    <p>

                        {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} üzerinden yapılan faaliyetler ve alım satım işlemleri sözleşmeler ve kurallarla belirlenmiştir.

                    </p>
                    <p>
                        Bu bölümde;
                    </p>
                    <p>Kullanıcılar ve {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} arasındaki ilişkileri düzenleyen "Hesap Sözleşmesi" ni okuyabilir,
                        {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} kuralları ve politikalarını inceleyebilir,
                        {{str_replace(['http://', 'https://'], '', env('APP_URL'))}}' da satışı yasak olan "Yasaklı Ürünler Listesi"ni de görebilirsiniz.


                    </p>
                    <p>
                        Güven Damgası, sadece ilgili Tebliğ uyarınca GDS tarafından incelemesi, takibi ve kontrolü sağlanan mevzuata uygunluk kriterlerinin varlığına delalet eder. Bunun haricinde Güven Damgası Sağlayıcısı, hiçbir suretle taraflar arasındaki sözleşmenin garantörü ya da taahhüt edeni olarak anlaşılamayacağı gibi, E-ticaret sitesinde bulunan mal ya da hizmetlerin ayıptan ari vasıflarının ve eksiksiz temin ve tesliminin kefili de değildir. Ayrıca Güven Damgası Sağlayıcısı malın teslim edilmemesi, geç teslim edilmesi ya da taahhüt edilen niteliklere uygun olarak teslim edilmemesi hallerinden hukuken hiçbir surette sorumlu tutulamaz.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="overlay" onclick="off()"></div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('site/js/fancybox.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/swiper.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/main.js') }}?v={{ file_exists(public_path('site/js/main.js')) ? filemtime(public_path('site/js/main.js')) : time() }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
    };
</script>

@if ($errors->any())
<script>
    @foreach($errors->all() as $error)
    toastr.error("{{ $error }}", "Hata");
    @endforeach
</script>
@endif

@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", "Başarılı");
</script>
@endif

@if (session('error'))
<script>
    toastr.error("{{ session('error') }}", "Hata");
</script>
@endif

{{-- Not: Buradaki kodlar sonradan özel bir javascript dosyasına taşınacak --}}
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function logoSelector() {
        document.querySelector('#avatar').showPicker();
    }

    function showAvatar() {
        let file = event.target.files[0]; // Seçilen dosyayı al
        if (file) {
            let reader = new FileReader(); // Dosya okuyucu oluştur
            reader.onload = function(e) {
                document.querySelector('.pdform-logo-area').innerHTML = `<img src="${e.target.result}" style="width: 80px;
                height: 80px; object-fit: cover; border-radius: 50%">`;
            }
            reader.readAsDataURL(file); // Dosyayı base64 formatında oku
        }
    }

    function removeAvatar() {
        document.querySelector('.pdform-logo-area').innerHTML = `<i class="fa-solid fa-user"></i>`;
        document.querySelector('#avatar').value = "";
    }

    function getSubCategories() {
        const subCategorySelect = document.querySelector('#sub-category-select');

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
</script>



@yield('js')