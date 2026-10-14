<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr" lang="tr">

<head>
    <meta charset="utf-8">
    @yield('meta')
    <title>Ev Hayaliniz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{env('APP_URL')}}/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="{{env('APP_URL')}}/favicon.ico">
    <link rel="apple-touch-icon" href="{{env('APP_URL')}}/favicon.ico">

    <link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/site/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/site/css/fancybox.css">
    <link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/site/css/swiper.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('site/css/main.css') }}?v={{ file_exists(public_path('site/css/main.css')) ? filemtime(public_path('site/css/main.css')) : '1.0.0' }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- ✨ Livewire CSS -->
    @livewireStyles
    <style>
        /* Sonradan css dosyasına eklenecekler */
        .select2-selection--multiple {
            min-height: 46px !important;
        }

        .dropzone.dz-clickable {
            background: transparent;
            border: none;
        }

        .profile-avatar-min {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .question-answer-box {
            background: rgba(255, 255, 255, 0.4);
            padding: 5px 10px;
            border-radius: 5px;
            margin-top: 15px;
        }

        .popular-services-cards .psc-img img {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #4068e2 !important;
            box-shadow: 0 0 0.25rem rgba(24, 145, 247, 0.5) !important;

        }

        input.error,
        select.error,
        textarea.error {
            border-color: red !important;
            box-shadow: 0 0 0 .25rem rgb(255 0 0 / 5%) !important;
        }

        input,
        select,
        textarea {
            border-color: #91a2be !important;
        }


        .profile-edit-avatar {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border: 6px solid #f1f7ff;
            border-radius: 50%;
        }

        .pdform-logo-area {
            width: 140px;
            height: 140px;
        }


        .popover {
            background-color: #000;
            /* Arkaplan siyah */
            color: #fff;
            /* Yazı beyaz */
            max-width: 300px;
            /* Kutuyu küçült */
            font-size: 0.875rem;
            /* Yazı biraz küçültüldü */
            border-radius: 0.5rem;
        }

        .popover-header {
            background-color: #000;
            color: #fff;
            border-bottom: 1px solid #333;
        }

        .popover-body {
            color: #fff;
            padding: 5px 10px;
        }

        .popover-arrow {
            display: none !important;
        }

        .sidebar {
            padding-right: 0 !important;
        }

        .tum-hizmetler-inputs-flex.scrolled {
            position: fixed;
            top: 0;
            z-index: 99999;
            background: #fff;
            margin-left: 0;
        }

        /* CAPTCHA'yı kayıt formlarından gizle */
        #exampleModalToggle .g-recaptcha,
        #exampleModalToggle form .g-recaptcha {
            display: none !important;
        }
    </style>

    @yield('css')
    @stack('styles')


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

    @include('site.inc.header')


    <div class="container-fluid pr-0 mobile-mobile-pl-0 mobile-pl-0-edit pl-0">
        <div class="row">
            @include('site.inc.sidebar')

            @yield('content')

        </div>
    </div>


    <div class="modal fade fikirhizmetmodal" id="fikirhizmetmodal" tabindex="-1"
        aria-labelledby="fikirhizmetmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="addservicesmodal">
                        @auth()
                        <div>
                            <a href="{{route('idea.create')}}">
                                Fikir Ekle
                            </a>
                        </div>
                        @if(auth()->user()->user_type == 'company')
                        <div>
                            <a href="{{route('company.services.create')}}">
                                Hizmet Ekle
                            </a>
                        </div>
                        @endif
                        @endauth

                        @guest
                        <div>
                            <a href="#exampleModalToggle" data-bs-toggle="modal">
                                Giriş Yap / Kayıt Ol
                            </a>
                        </div>
                        @endguest
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

                        <form action="{{route('login')}}" method="POST" data-auth-ajax="login" class="auth-ajax-form">
                            <input type="hidden" name="redirect" value="{{ url()->current() }}">
                            <div class="login-form">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="email" name="email" @error('email') class="error" @enderror
                                            required="">
                                        <label>E-Posta</label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-field">
                                        <input id="input_box2" type="password" name="password"
                                            @error('email') class="error" @enderror required="">
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
                                        <a href="/forgot-password">
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
                                                <img src="{{asset('site/images/google.svg')}}" alt="Google ile giriş yap">
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
        <div class="modal-dialog modal-dialog-centered">
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

                                <form action="{{route('register')}}" method="POST" data-auth-ajax="register" class="auth-ajax-form">
                                    <div class="login-form pt-3">
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input type="text" name="name" @error('name') class="error"
                                                    @enderror required="">
                                                <label>Ad - Soyad</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input type="email" name="email" @error('email') class="error"
                                                    @enderror required="">
                                                <label>E-Posta</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-9 col-7">
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="text" name="verification_code" id="user_verification_code" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" placeholder="6 haneli kod">
                                                        <label>Doğrulama Kodu</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-5">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary w-100 code-send-button" style="margin-top: 0; font-size: 0.75rem; padding: 0.5rem 0.25rem;height:45px;">
                                                        Kod Gönder
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box3" type="password" name="password"
                                                    @error('password') class="error" @enderror required="">
                                                <label>Şifre</label>

                                                <span toggle="#input_box3"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box4" type="password" name="password_confirmation"
                                                    @error('password') class="error" @enderror required="">
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
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#sozlesme">
                                                            <b>Kullanıcı Sözleşmesi'ni</b> okudum, kabul ediyorum
                                                        </a>

                                                        <a class="d-none" data-bs-toggle="modal" data-bs-target="#kvkkmodal"> Kvkk </a>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="user_type" value="user">

                                        @csrf
                                        <div class="login-button">
                                            <button type="submit" id="user_register_button" data-verified="false" style="opacity: 0.6; cursor: not-allowed;">Kayıt Ol</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                            aria-labelledby="nav-profile-tab">
                            <div class="login-modal-box">
                                <x-input-error-site />

                                <form action="{{route('register')}}" method="POST" data-auth-ajax="register" class="auth-ajax-form">
                                    <div class="login-form pt-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="text" name="name" @error('name') class="error"
                                                        @enderror required="">
                                                    <label>Firma Adı</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input type="email" name="email" @error('email') class="error"
                                                        @enderror required="">
                                                    <label>E-Posta</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-9 col-7">
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="text" name="verification_code" id="company_verification_code" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" placeholder="6 haneli kod">
                                                        <label>Doğrulama Kodu</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-5">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary w-100 code-send-button" style="margin-top: 0; font-size: 0.75rem; padding: 0.5rem 0.25rem;height:45px;">
                                                        Kod Gönder
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box5" type="password" name="password"
                                                    @error('password') class="error" @enderror required="">
                                                <label>Şifre</label>
                                                <span toggle="#input_box5"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field">
                                                <input id="input_box6" type="password" name="password_confirmation"
                                                    @error('password') class="error" @enderror required="">
                                                <label>Şifre Tekrar</label>

                                                <span id="inputbox4passtoggle" toggle="#input_box6"
                                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="login-select">
                                                <select name="category_id"
                                                    class="form-select @error('category_id') error @enderror"
                                                    onchange="getSubCategories()" required>
                                                    <option value="">Kategori</option>
                                                    @foreach(get_categories() as $category)
                                                    <option value="{{$category->id}}">{{$category?->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="login-select">
                                                <select name="sub_category_id"
                                                    class="form-select @error('sub_category_id') error @enderror"
                                                    id="sub-category-select" required>
                                                    <option value="">Alt Kategori</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="rememberme-forget-pass user-agreement">
                                            <div class="remember-me">
                                                <label class="remember-label">
                                                    <input type="checkbox" name="register_checkbox" required />
                                                    <div class="ua-box">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#kurumsalsozlesme">
                                                            <b>Kullanıcı Sözleşmesi'ni</b> okudum, kabul ediyorum
                                                        </a>

                                                    </div>
                                                </label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="user_type" value="company">

                                        @csrf
                                        <div class="login-button">
                                            <button type="submit" id="company_register_button" data-verified="false" style="opacity: 0.6; cursor: not-allowed;">Kayıt Ol</button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kvkkmodalLabel">Kişisel Verilerin Korunması Hakkında</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Kişisel Verilerin Korunması
                    </p>
                    <p>
                        Kişisel Verilerin Korunması ve İşlenmesi Hakkında Aydınlatma Metni
                    </p>
                    <p>
                        İşbu Kişisel Verilerin Korunması ve İşlenmesi Hakkında Bilgilendirme’nin (Bilgilendirme) amacı, Evhayaliniz Bilgi Teknoloji Ticaret Ve Limited Şirketi (Evhayaliniz) tarafından yönetilmekte olan https://www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/ adresinde yer alan internet sitesinin, (Portal) kullanımı sırasında elde edilen ve/veya üçüncü kişilerden alınan kişisel verilerin kullanımına ilişkin olarak 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun’un (Kişisel Verilerin Korunması Kanunu) 10. maddesi ile getirilen aydınlatma yükümlülüğünün yerine getirilmesidir. Ayrıca Kullanıcılar’ın Portal’ın kullanımı ile ilgili olarak Evhayaliniz tarafından toplanan veya Kullanıcıların pozitif hareketleri ile kendilerinin Portal’a girdikleri kişisel verilerin toplanma şekilleri, işlenme amaçları, hukuki nedenleri ve hakları konularında şeffaf bir şekilde Kullanıcıları bilgilendirmektir.
                    </p>
                    <p>

                        Çeşitli kategorilerdeki ürün ve hizmetleri sunanlar ile potansiyel alıcılar, Evhayaliniz’in sunduğu güvenli ortam üzerinden buluşarak alışverişlerini yapmaktadırlar. Bu faaliyet içerisinde işbu Bilgilendirme metninde belirtildiği şekilde kişisel veriler Evhayaliniz fonksiyonlarının kullanılabilmesinin gereği olarak işlenmektedir.

                    </p>
                    <p>
                        Evhayaliniz, teknolojiye yatırım yaparak yenilikçi ürün ve hizmet uygulamaları ile internet alanında Kullanıcılarına daha iyi hizmet vermek için sürekli kendisini yenilemekte ve en iyi hizmeti verebilmek için çalışmakta, kişisel verilerin hukuka uygun olarak toplanması, saklanması ve paylaşılmasını sağlamak ve gizliliğini korumak amacıyla mümkün olan en üst seviyede güvenlik tedbirlerini almaktadır. Bu amacını gerçekleştirebilmek için Kullanıcıların kişisel verileri aşağıda detayları açıklanan kapsam ve koşullarda işlenmektedir.
                    </p>
                    <p>

                        Evhayaliniz, işbu Bilgilendirme hükümlerini dilediği zaman Portal üzerinden yayımlamak suretiyle güncelleyebilir ve değiştirebilir. Evhayaliniz’in yaptığı güncelleme ve değişiklikler Portal’da yayınlandığı tarihten itibaren geçerli olacaktır.

                        a) Veri Sorumlusu

                        Kişisel Verilerin Korunması Kanunu uyarınca, kişisel verileriniz; veri sorumlusu olarak Evhayaliniz tarafından aşağıda açıklanan kapsamda toplanacak ve işlenebilecektir.

                        b) Toplanan Kişisel Veriler
                        Evhayaliniz, aşağıda belirtilen metodlarla Kullanıcılar’dan çeşitli statik (sabit) ve dinamik (değişken) veriler toplamaktadır. Evhayaliniz’in topladığı veriler, Kullanıcıların kullandığı hizmetlere ve özelliklere bağlıdır.

                        İşbu başlık altında, Evhayaliniz tarafından sunulan Hizmetler kapsamında işlenen ve Kişisel Verilerin Korunması Kanunu uyarınca kişisel veri sayılan verilerin hangileri olduğu aşağıda gruplar halinde sıralanmıştır. Aksi açıkça belirtilmedikçe, işbu Bilgilendirme’de arz edilen hüküm ve koşullar kapsamında “kişisel veri” ve “özel nitelikli kişisel veri” ifadeleri aşağıda yer alan bilgileri içermektedir:

                        Ad ve İletişim Bilgileri: Ad, soyadı, cep telefonu, ev telefonu, iş telefonu, adresi, e-posta adresi, fatura bilgileri, TC kimlik numarası (ulusal kimlik numarası), kimlik ön yüzü fotokopisi ve benzer diğer belgeler.

                        Kimlik Doğrulama Bilgileri: Kullanıcıların hesap bilgileri, kimliği doğrulamak için ve hesaba erişimi sağlamak için kullanılan parolaları, Kullanıcı Adı, kontak bilgileri, Kullanıcı numaraları, ilan numaraları, nüfus cüzdanı ön yüzü bilgileri, yeni kimlik ön yüzü bilgileri, yeni ehliyet ön yüzü bilgileri, kullanıcı selfie(özçekim) videosu, kimlik hologram videosu, fatura bilgileri.

                        Demografik Veriler: Doğum tarihi, cinsiyet, medeni hali, eğitim durumu, meslek, ilgi alanları, tercih edilen dil verileri.

                        Kullanım Verileri ve Sık Kullanılanlar: Çeşitli yazılım ve teknolojik araçlar vasıtasıyla cihazlarınızdan toplanan veriler Evhayaliniz’i veya Çağrı Merkezlerini arama nedenleriniz, ses kayıtları ürünün kullanıldığı tarih ve saat verileri, endeks sorgusu oluşturulan il, ilçe, mahalle, ödeme işleminin başarılı olması halinde Sigorta Birliği ve Gözetim Merkezi sistemi tarafından üretilen hasar sorgu raporunun alınması için şasi ve plaka numarası, Portal üzerinden bakılan ürünler, metrekare fiyatları, yurtiçi veya yurtdışı firmaların anket, banner yönlendirme gibi modülleri üzerinden kullanıcıların ilgili ürüne yönlenebilmeleri ve ürün tedarikçisi firmaların kullanıcı ile iletişime geçmesi için ilgili anket veya bannerda belirtilen veriler, bankadan emlak modülü üzerinden bankaların satışa çıkardıkları gayrimenkuller için almak istedikleri teklife dair banka tarafından istenen bilgiler, emlak projeleri için Portal üzerinden müteahhit firmaların projeleri ile ilgili bilgi almak için girilen veriler, hizmetlerin geliştirilmesi ve tarafınıza göre özelleştirilmesi adına kullanım alışkanlıkları (önceliklendirme seçenekleri, tercih edilen geri dönüş metodu ve tarihi, cevap verilen kanallar, Portal’a son giriş tarihi, kullanılan Doping ilan türü, gönderi türü, ziyaret edilen internet siteleri, görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı, servisleri kullanırken gerçekleştirilen kullanıcı hareketleri, girilen arama terimleri, ziyaret edilen ürün ve ilanların kategorileri,) hizmetlerin sorunsuz bir şekilde sağlanabilmesinin temini amacıyla hizmet kullanımı sırasında oluşan hatalar ve benzeri sorunlar.

                    </p>
                    <p>
                        Konum Verileri: Kullanıcıların hassas veya yaklaşık konumları ile ilgili verileri kapsar. GPS verisi ile IP ve port adreslerinden çıkarılan konum verisi, kullanıcı Evhayaliniz’in mobil uygulamalarını kullanırken, kendi bulunduğu konumun etrafındaki ilanları aramak ve ilan vermek istemesi durumunda ve kullanıcının izin vermesi halinde kullanılır.

                        Ödeme Verileri: Ajans ve müşteri fatura ve ödeme bilgileri (adı, soyadı, fatura adresi, TC kimlik numarası, vergi kimlik numarası), hesap sahibine gönderilen faturalar ve hesap sahiplerinden alınan ödemelere ait dekont örnekleri, ödeme numarası, fatura numarası, fatura tutarı, fatura kesim tarihi gibi veriler.

                        İçerik Verileri: Markanın sahte olmadığına dair talep edilen belgeler (fatura, garanti belgesi vs), ürünün kişiye ait olduğunu ya da ürün üzerindeki yetkisini gösteren belgeler (tapu, ruhsat, marka tescil belgesi, yetkilendirme sözleşmesinin ilgili kısımları gibi), ilan bilgileri, yetki belgesi, hesap bilgileri, bildirim açıklaması, çözüm açıklaması, memnuniyet, bildirim nedeni, müşteri notu, yenileme tarihi, ilan reddetme nedeni, geri bildirim, belge gönderim nedeni, Hizmet’in kullanımı sırasında belirtilen hata içeriği, ara bilgilendirme durumu, ara bilgilendirme, arama nedeni gibi benzer veriler.

                        Anket Cevapları: Evhayaliniz tarafından Portal dahilinde düzenlenen periyodik anketlere verilen cevaplar ile Evhayaliniz’in işbirliği yaptığı gerçek ve tüzel kişiler tarafından yapılan anketlere verilen cevaplar.

                        Filtrelere Takılmış veya Kullanım Koşullarına Aykırı İçerikteki Site İçi Mesajlar: Kullanıcılar arasında güvenli iletişim ve ticaret yapılabilmesi için kullanıcıların birbirlerine gönderdikleri site içi mesajlardan sadece filtrelere takılanlar veya gelen şikayet/bildirim üzerine kullanım koşullarına aykırı içerikte tespit edilen site içi mesajlardır.

                        Kişisel Veriler Nerede Depolanır ve İşlenir?

                        Elde ettiğimiz kişisel verileriniz yurtiçinde veya yurtdışında Evhayaliniz’in ya da bağlı kuruluşlarının, alt kuruluşlarının veya işbirliği içinde bulunduğu hizmet servis sağlayıcılarının tesisi bulunan başka bir ülkede depolanabilir ve işbu Bilgilendirme’deki amaçlar doğrultusunda ve bu amaçlarla orantılı olarak işlenebilir.

                        İşbu Bilgilendirme kapsamında toplanan kişisel verileriniz burada yer alan hükümlere ve verilerin depolandığı ve işlendiği ülkede yürürlükte olan mevzuat kapsamında ve öngörülen güvenlik önlemleri dâhilinde işlenecektir.

                        c) Kişisel Verilerin Hangi Amaçla İşleneceği

                    </p>

                    <p>
                        İşbu Bilgilendirme ile Hesap Sözleşmesi’nde yer alan amaçlar doğrultusunda kişisel verileriniz, 6698 Sayılı Kişisel Verilerin Korunması Kanunu ile düzenlenen İlkeler ve İşleme Şartları uyarınca ve aşağıda detayları belirtilen amaçlar dairesinde işlenecektir:

                        Ad ve İletişim Bilgileri: Şirket içi değerlendirme, iletişim, Kullanıcı kayıt, potansiyel müşteri bilgisi elde etmek, satış sonrası süreçlerin geliştirilmesi, iş geliştirme, tahsilat, müşteri portföy yönetimi, promosyon, analiz, şikayet yönetimi, müşteri memnuniyeti süreçlerini yönetmek, pazarlama, reklam, araştırma, faturalandırma, etkinlik bilgilendirmesi, operasyonel faaliyetlerin yürütülmesi, hizmet kalitesinin ölçülmesi, geliştirilmesi, denetim, kontrol, optimizasyon, müşteri doğrulama, satış, satış sonrası hizmetleri, dolandırıcılığın tespiti ve önlenmesi, çevrimiçi eğitim toplantılarına katılım sağlamak;

                        Kimlik Doğrulama Bilgileri: Kullanıcı kayıt, sorun/hata bildirimi, kontrol, operasyonel faaliyetlerin geliştirilmesi, yürütülmesi, satış sonrası süreçlerin geliştirilmesi, iş geliştirme, tahsilat, şirket içi değerlendirme, müşteri portföy yönetimi, hizmet kalitesinin ölçülmesi, iletişim, optimizasyon, moderasyon, denetim, risk yönetimi, dijital kimlik doğrulama, müşteri doğrulama, dolandırıcılığın tespiti ve önlenmesi;

                        Demografik Veriler: Promosyon, şirket içi değerlendirme, analiz, iletişim, satış sonrası süreçlerin geliştirilmesi, iş geliştirme, tahsilat, kullanım verileri ve ilgi alanları, sık kullanılanlar, pazarlama, satış, reklam, denetim ve kontrol, risk yönetimi, şirket içi değerlendirme, müşteri portföy yönetimi, satış sonrası hizmetler, hizmet kalitesinin ölçülmesi, geliştirilmesi, şikayet yönetimi süreçlerini yürütmek, operasyonel faaliyetlerin yürütülmesi ve geliştirilmesi, kayıt, sorun/hata bildirimi;

                        Kullanım Verileri ve Sık Kullanılanlar: Kullanıcı kayıt, sorun/hata bildirimi, kontrol, sorgulama, operasyonel faaliyetlerin yürütülmesi ve geliştirilmesi, satış sonrası hizmetler ve satış sonrası süreçlerin geliştirilmesi, iş geliştirme, tahsilat, şirket içi değerlendirme, çevrimiçi davranışsal reklamcılık ve pazarlama, müşteri portföy yönetimi, hizmet kalitesinin ölçülmesi ve geliştirilmesi, iletişim, optimizasyon, denetim, risk yönetimi ve kontrol, promosyon, analiz, ilgi alanları belirleme, skorlama, profilleme, pazarlama, satış, reklam, şikayet yönetimi süreçlerini yürütmek, kayıt, sorun/hata bildirimi;

                        Konum verileri: Konuma bağlı veya konumla ilişkili Portal fonksiyonlarının kullandırılması, denetim ve kontrol, risk yönetimi;

                        Ödeme Verileri: Faturalandırma sürecini yönetmek, muhasebe, satış sonrası süreçlerin geliştirilmesi, iş geliştirme, tahsilat, şirket içi değerlendirme, skorlama, profilleme, müşteri portföy yönetimi, satış sonrası hizmetler, iletişim, pazarlama, denetim, kontrol, ödeme hizmet sağlayıcıları ile yürütülen süreçler;

                        İçerik: İş geliştirme, optimizasyon, müşteri portföy yönetimi, denetim, kontrol, operasyonel faaliyetlerin yürütülmesi ve geliştirilmesi, ilan verme süreçlerinin kolaylaştırılması, ilan verme sırasında yaşanabilecek dolandırıcılık ve suistimallerin önlenmesi ve bu doğrultuda veri toplanması, ilan operasyonlarının yürütülmesi, promosyon, şirket içi değerlendirme, müşteri yönetimi, analiz, skorlama, profilleme, satış sonrası süreçlerin geliştirilmesi, tahsilat, satış sonrası hizmetler, iletişim, hizmet kalitesi ölçülmesi ve geliştirilmesi, mevzuata uyum gerekliliklerinin yerine getirilmesi, şikayet yönetimi süreçlerinin yürütülmesi;

                        Anket ve Test Cevapları: Evhayaliniz tarafından Portal dahilinde düzenlenen periyodik anketlere veya testlere cevap veren kullanıcılardan talep edilen bilgiler, Evhayaliniz ile Portal fonksiyonlarının kullandırılması ve bu fonksiyonların Evhayaliniz tarafından yerine getirilebilmesi için işbirliği yaptığı gerçek ve/veya tüzel kişiler ile Portal’ın kullanım amaçlarına uygun olarak yukarıda belirtilen tüm işleme faaliyetleri kapsamında işbirliği yaptığı üçüncü gerçek ve tüzel kişiler tarafından bu kullanıcılara doğrudan pazarlama yapma, istatistikî analiz yapma, süreçlerini iyileştirme ve veri tabanı oluşturma;

                        Evhayaliniz ile iş ilişkisi içerisinde olan üçüncü gerçek veya tüzel kişiler ile yapılan sözleşmeler veya yürütülen faaliyetler ile yasal düzenlemelerden doğan yükümlülükler çerçevesinde hukuki ve ticari yükümlülüklerin gerçekleştirilmesi için Evhayaliniz tarafından iş ortağı/müşteri/tedarikçiler ile yapılan sözleşmelerden kaynaklanan yükümlülükleri ifa etme, hak tesis etme, hakları koruma, ticari ve hukuki değerlendirme süreçlerini yürütme, hukuki ve ticari risk analizleri yapma, hukuki uyum sürecini yürütme, ilgili yasal mevzuatlarda belirtilen belgeleri kullanıcının alıp alamayacağına yönelik yapılan testleri sonuçlandırma, mali işleri yürütme, yasal gereklilikleri yerine getirme, yetkili kurum, kuruluş ve mercilerin kararlarını yerine getirme, taleplerini cevaplama amaçlarıyla 6698 sayılı Kanun’un 5. ve 6. maddelerinde belirtilen kişisel veri işleme şartları ve amaçları dahilinde işlenecektir.

                        Filtrelere Takılmış veya Kullanım Koşullarına Aykırı İçerikteki Site İçi Mesajlar: Mesajlaşma hizmetimiz, kullanıcılarımızın alım, satım işlemlerinde karşı taraf ile iletişim kurmalarını kolaylaştırmak amacı ile sunulmaktadır. Bu kapsamdaki mesajlarda; Kanun’un 5. Maddesindeki meşru menfaate dayalı olarak, hakaret içeren, genel ahlaka aykırı, dolandırıcılık maksatlı ilan verildiği konusunda şüphe uyandıran, haksız rekabete neden olabilecek, kişilik haklarını, fikri ve sınai mülkiyet haklarını ihlal eden ve sair surette hukuka aykırılık içeren mesajlar filtrelenerek moderasyona tabi tutulmakta, kullanım koşullarına aykırı içerikteki site içi mesajlar incelenerek engellenebilmektedir.

                        Kişisel Verileri Saklama Süresi

                        Evhayaliniz, elde ettiği kişisel verileri, Kullanıcılar’a Hizmet’ten en iyi şekilde faydalanabilmeleri için işbu Bilgilendirme ile Hesap Sözleşmesi’nde belirtilen şartlar çerçevesinde ve Hesap Sözleşmesi’nin mahiyetinden kaynaklanan yükümlülükleri yerine getirebilmesi adına işlendikleri amaç için gerekli olan süre kadar muhafaza edecektir.

                        Buna ek olarak, Evhayaliniz, Hesap Sözleşmesi’nden doğabilecek herhangi bir uyuşmazlık durumunda, uyuşmazlık kapsamında idari veya yargı süreçlerinin yürütülebilmesi amacıyla sınırlı olmak üzere ve ilgili mevzuat uyarınca belirlenen zamanaşımı süreleri boyunca kişisel verileri saklayacaktır.

                        ç) İşlenen Kişisel Verilerin Kimlere ve Hangi Amaçla Aktarılabileceği

                        Evhayaliniz, Kullanıcıya ait kişisel verileri ve bu kişisel verileri kullanılarak elde ettiği yeni verileri veya Kullanıcıların kendilerinin pozitif hareketleriyle Portal’a girdikleri kişisel bilgileri başta Hesap Sözleşmesi gereklerini ve Hizmetler’i ifa etmek, Kullanıcı deneyimini geliştirmek (iyileştirme ve kişiselleştirme dahil), Kullanıcıların güvenliğini sağlamak, dolandırıcılığı tespit etmek ve önlemek, Hizmet’leri geliştirmek, Hizmet’ler için önem arz edebilecek nitelikteki sorgulama faaliyetlerini gerçekleştirmek, operasyonel değerlendirme araştırması yapmak, hataları gidermek, Kullanıcı kimliklerini doğrulamak, sistem performansını geliştirmek, çevrimiçi eğitim faaliyetlerinin sağlanması olmak üzere yukarıda işleme amaçları kısmında belirtilen amaçlardan herhangi birini gerçekleştirebilmek için dış kaynak hizmet sağlayıcılar, iş ortakları, tedarikçiler ve gayrimenkul danışmanlığı firmaları; Hizmetler’i ifa ederken aktarımın gerektirdiği ölçüde kurumsal hesap sahipleri, kargo şirketleri, hukuk büroları, araştırma şirketleri, çağrı merkezleri, Evhayaliniz Akademi ve benzeri çevrimiçi eğitim platformları, şikayet yönetimi ve güvenliğin sağlanmasına ilişkin yazılım şirketleri, ajanslar, danışmanlık şirketleri, basım sektöründe yer alan şirketler, bankaların emlak satışları için bankalar, emlak projeleri ile ilgili olarak müteahhitlik firmaları, sosyal medya mecraları, belgelendirme kuruluşları dahil üçüncü gerçek ve/veya tüzel kişiler ile ve yasal zorunluluklar kapsamında yetkili kurum, kuruluş, merci, idari, yargı organları ve bağımsız denetim şirketleri ile paylaşmaktadır.

                        Ayrıca, Kullanıcının Ad ve İletişim Bilgileri, ödeme aşamasında onaylayacağı ödeme kuruluşu çerçeve sözleşmesi uyarınca ve 9 Ocak 2008 tarihli ve 26751 sayılı Resmi Gazete’de yayımlanan Suç Gelirlerinin Aklanmasının ve Terörün Finansmanının Önlenmesine Dair Tedbirler Hakkında Yönetmelik uyarınca kimlik doğrulaması gerçekleştirilmesi amacıyla ödeme kuruluşlarıyla paylaşılacaktır.

                        Cihazınıza yerleştirilen çerezler aracılığıyla elde edilen kişisel verileriniz üçüncü kişiler ile işbu Bilgilendirme’de belirtilen kapsam ve amaçlarla paylaşılabilecektir.

                        Evhayaliniz kişisel verileri yukarıda belirtilen kategoriler ve amaçlar dahilinde bu amaçlarla sınırlı ve orantılı olmak üzere yurt içinde üçüncü kişilere aktarabileceği gibi yurt dışına da aktarabilecektir.

                        d) Kişisel Veri Toplamanın Yöntemi ve Hukuki Sebebi

                        Evhayaliniz, daha etkin bir şekilde çalışmak ve size en iyi deneyimi sunmak için kişisel verilerinizi toplamaktadır. Evhayaliniz, kişisel verilerinizi, doğrudan sizden (veri sahibi), sizin adınıza hareket eden vekil ve/veya hareket etmeye yetkili kişiler tarafından verileriniz aşağıdaki yöntemler kullanılarak toplanmaktadır:

                        Doğrudan Evhayaliniz’e Vermiş Olduğunuz Veriler: Hizmet’in ifası için ve Portal’ın kullanımı öncesinde veya sırasında, Evhayaliniz’e Kullanıcıların kendi inisiyatifleri doğrultusunda verdikleri kişisel verileri ifade eder. Bu kişisel veriler, doğrudan Kullanıcılar tarafından Evhayaliniz’e pozitif hareketleri neticesinde verilen tüm kişisel verileri kapsar. Örneğin, ad-soyad, iletişim bilgileri, kimlik bilgileri, anketlere verilen cevaplar, demografik veriler ve içerik bilgileri bu tür verilere girmektedir.

                        Platformumuzu Kullandığınız Zaman Elde Ettiğimiz Veriler: Evhayaliniz’in sunduğu hizmet sırasında, belirli yazılım ya da teknolojik araçlar vasıtasıyla alınan Kullanıcıların kullanım alışkanlıklarına ilişkin kişisel verileri kapsamaktadır. Örneğin, konum verileri ve sık kullanılanlar ile birlikte ilgi alanları ve kullanım verileri bu tür verilere girmektedir.

                        Evhayaliniz, çevrimiçi davranışsal reklamcılık ve pazarlama yapılabilmesi amacıyla siteye gelen kullanıcının hesabı olmasalar dahi sitedeki davranışlarını tarayıcıda bulunan bir cookie (çerez) ile ilişkilendirme ve görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı gibi kullanım verilerini toplamaktadır. Çerezlerin nasıl yönetileceği ayrıca Çerez Politikamızda belirtilmiştir.

                        Bu yöntemlerle toplanan kişisel verileriniz 6698 sayılı Kanun’un 5. ve 6. maddelerinde belirtilmiş olan;

                        Kanunlarda açıkça öngörülmüş olması,
                        Hukuki yükümlülüğünü yerine getirebilmek için zorunlu olması (Elektronik ticaret faaliyetlerini, maliyeye ve vergiye ait hususları, tüketicinin korunmasını ve sair konuları düzenleyen yasal düzenlemeler),
                        Sözleşmenin kurulması veya ifasıyla doğrudan doğruya ilgili olup işlemenin gerekli olması (Hesap Sözleşmesi, Kullanım Koşulları ve bunlara dayalı olarak sözleşmenin ifası, hakkın tesisi ve korunması),
                        Meşru menfaati için işlemenin zorunlu olması (Evhayaliniz’in Portal ile ilgili faaliyetlerinde özellikle dolandırıcılığı engellemek başta olmak üzere hizmetleri yürütebilmesi için gerekli olan verileri toplaması),
                        Tarafınızca alenileştirilmiş olması,
                        Bir hakkın tesisi, kullanılması veya korunması için işlemenin zorunlu olması,
                        Açık rızanızın bulunması
                        şeklindeki hukuki sebeplere dayanmaktadır.

                        Bu yöntemlerle toplanan kişisel verileriniz 6698 sayılı Kanun’un 5. ve 6. maddelerinde belirtilen kişisel veri işleme şartları ve amaçları kapsamında bu Bilgilendirme’de belirtilen amaçlarla işlenebilmekte ve aktarılabilmektedir.

                        Kişisel verileri toplamanın hukuki dayanakları;

                        Hesap Sözleşmesi, Kullanım Koşulları ve bunlara dayalı olarak sözleşmenin ifası, hakkın tesisi ve korunması
                        Elektronik ticaret faaliyetlerini, maliyeye ve vergiye ait hususları, tüketicinin korunmasını ve sair konuları düzenleyen yasal düzenlemeler
                        Evhayaliniz’in Portal ile ilgili faaliyetlerinde özellikle dolandırıcılığı engellemek başta olmak üzere hizmetleri yürütebilmesi için gerekli olan verileri toplamasındaki meşru menfaatine dayanmaktadır.
                        e) Veri Güvenliğine İlişkin Önlemlerimiz ve Taahhütlerimiz

                        Evhayaliniz, kişisel verileri güvenli bir şekilde korumayı taahhüt eder. Kişisel verilerin hukuka aykırı olarak işlenmesini ve erişilmesini engellemek ve kişisel verilerin muhafazasını sağlamak amacıyla uygun güvenlik düzeyini temin etmeye yönelik teknik ve idari tedbirleri çeşitli yöntemler ve güvenlik teknolojileri kullanarak gerçekleştirmektedir.

                        Evhayaliniz, elde ettiği kişisel verileri bu işbu Bilgilendirme ve 6698 Sayılı Kişisel Verilerin Korunması Kanunu hükümlerine aykırı olarak başkasına açıklamayacaktır ve işleme amacı dışında kullanmayacaktır. Evhayaliniz, işbu Bilgilendirme uyarınca dış kaynak hizmet sağlayıcılarla Kullanıcılar’a ait kişisel verilerin paylaşılması durumunda, söz konusu dış kaynak tedarikçilerinin de işbu madde altında yer alan taahhütlere riayet etmeleri için gerekli uyarı ve denetim faaliyetlerini icra edeceğini beyan eder.

                        Portal üzerinden başka uygulamalara link verilmesi halinde Evhayaliniz, link verilen uygulamaların gizlilik politikaları ve içeriklerine yönelik herhangi bir sorumluluk taşımamaktadır.

                        Kullanıcı, işbu Bilgilendirmeye konu bilgilerinin tam, doğru ve güncel olduğunu, bu bilgilerde herhangi bir değişiklik olması halinde bunları derhal bilgi@{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/ adresinden güncelleyeceğini taahhüt eder. Kullanıcı’nın güncel bilgileri sağlamamış olması halinde Evhayaliniz’in herhangi bir sorumluluğu olmayacaktır.

                        f) Kişisel Veri Sahibi’nin 6698 sayılı Kanun’un 11. maddesinde Sayılan Hakları

                        Kişisel veri sahipleri olarak, haklarınıza ilişkin taleplerinizi aşağıda düzenlenen yöntemlerle Evhayaliniz’e iletmeniz durumunda Evhayaliniz talebin niteliğine göre talebi en kısa sürede ve en geç otuz gün içinde sonuçlandıracaktır. Verilecek cevapta on sayfaya kadar ücret alınmayacaktır. On sayfanın üzerindeki her sayfa için 1 Türk Lirası işlem ücreti alınacaktır. Başvuruya cevabın CD, flash bellek gibi bir kayıt ortamında verilmesi halinde Evhayaliniz tarafından talep edilebilecek ücret kayıt ortamının maliyetini geçmeyecektir.

                        Bu kapsamda kişisel veri sahipleri;

                        Kişisel verilerinin işlenip işlenmediğini öğrenme,
                        Kişisel verileri işlenmişse buna ilişkin bilgi talep etme,
                        Kişisel verilerin işlenme amacını ve bunların amacına uygun kullanılıp kullanılmadığını öğrenme,
                        Yurt içinde veya yurt dışında kişisel verilerin aktarıldığı üçüncü kişileri bilme,
                        Kişisel verilerin eksik veya yanlış işlenmiş olması hâlinde bunların düzeltilmesini isteme ve bu kapsamda yapılan işlemin kişisel verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme,
                        6698 sayılı Kanun ve ilgili diğer kanun hükümlerine uygun olarak işlenmiş olmasına rağmen, işlenmesini gerektiren sebeplerin ortadan kalkması halinde kişisel verilerin silinmesini veya yok edilmesini isteme ve bu kapsamda yapılan işlemin kişisel verilerin aktarıldığı üçüncü kişilere bildirilmesini isteme,
                        İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle kişinin kendisi aleyhine bir sonucun ortaya çıkmasına itiraz etme,
                        Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğraması halinde zararın giderilmesini talep etme haklarına sahiptir.
                        Yukarıda belirtilen haklarınızı kullanmak ile ilgili talebinizi, Veri Sorumlusuna Başvuru Usul ve Esasları Hakkında Tebliğ'in 5. maddesi uyarınca, Türkçe olarak; veri sorumlusu sıfatıyla Evhayaliniz 'in Kılıçaslan Mah. 1303 SK. No:28 Nora City İş Merkezi A Blok Kat:4 Daire:2 Merkez/Aksaray/Türkiye adresine kimliğinizi tevsik edici bilgi ve belgeler ile yazılı olarak, evha@hs01.kep.tr adresine kayıtlı elektronik posta (KEP) ile, kvk@{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} adresine güvenli elektronik imza, mobil imza ile veya ilgili kişi tarafından Evhayaliniz sisteminde kayıtlı bulunan elektronik posta adresini kullanmak suretiyle iletebilirsiniz.

                        Evhayaliniz 'in kişisel verilerinizin hukuka aykırı paylaşımının önlenmesi amacıyla kimliğinizi doğrulama hakkı saklıdır.

                        Başvurunuzda;

                        Adınızın, soyadınızın ve başvuru yazılı ise imzanızın,
                        Türkiye Cumhuriyeti vatandaşları için T.C. kimlik numaranızın, yabancı iseniz uyruğunuzun, pasaport numaranızın veya varsa kimlik numaranızın,
                        Tebligata esas yerleşim yeri veya iş yeri adresinizin,
                        Varsa bildirime esas elektronik posta adresi, telefon ve faks numaranızın,
                        Talep konunuzun,
                        bulunması zorunlu olup varsa konuya ilişkin bilgi ve belgelerin de başvuruya eklenmesi gerekmektedir.



                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="cerezpolitikasi" tabindex="-1" aria-labelledby="cerezpolitikasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cerezpolitikasiLabel">ÇEREZ POLİTİKASI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Son güncelleme tarihi: 29.11.2025</strong></p>
                    <p>Bu Çerez Politikası, evhayaliniz.com alan adlı internet sitesi ve ilgili mobil/web uygulamaları (&quot;Site&quot;) üzerinden kullanılan çerezler ve benzeri teknolojiler hakkında kullanıcıları bilgilendirmek amacıyla hazırlanmıştır.</p>
                    <p>Site&apos;yi ziyaret ederek veya kullanmaya devam ederek, işbu Çerez Politikası kapsamında çerez kullanımını kabul etmiş sayılırsınız.</p>

                    <h6 class="mt-4">1. ÇEREZ NEDİR?</h6>
                    <p>Çerezler (&quot;cookies&quot;), ziyaret ettiğiniz internet siteleri tarafından tarayıcınıza veya cihazınıza kaydedilen küçük metin dosyalarıdır.</p>
                    <p>Çerezler sayesinde:</p>
                    <ul>
                        <li>Site&apos;nin düzgün ve güvenli şekilde çalışması,</li>
                        <li>Tercihlerinizin (dil, oturum bilgisi vb.) hatırlanması,</li>
                        <li>Site&apos;nin kullanımının analiz edilmesi ve geliştirilmesi</li>
                    </ul>
                    <p>mümkün hale gelir.</p>

                    <h6 class="mt-4">2. HANGİ TÜR ÇEREZLER KULLANILIYOR?</h6>
                    <p>Site&apos;de, kullanım amaçlarına göre farklı türlerde çerezler kullanılabilir:</p>
                    
                    <h6 class="mt-3">2.1. Zorunlu (Gerekli) Çerezler</h6>
                    <p>Bu çerezler, Site&apos;nin temel işlevlerini sağlayan ve mutlaka gerekli olan çerezlerdir. Örneğin:</p>
                    <ul>
                        <li>Oturum açmanızın sağlanması,</li>
                        <li>Güvenlik kontrolleri,</li>
                        <li>Formların ve sayfaların düzgün çalışması.</li>
                    </ul>
                    <p>Bu çerezler olmadan Site&apos;nin düzgün çalışması mümkün olmayabilir.</p>
                    
                    <h6 class="mt-3">2.2. Performans ve Analiz Çerezleri</h6>
                    <p>Bu çerezler; Site&apos;nin nasıl kullanıldığını anlamamıza, ziyaretçi sayısını, gezilen sayfaları, tıklama ve kullanım istatistiklerini görmemize yardımcı olur.</p>
                    <p>Bu sayede:</p>
                    <ul>
                        <li>Site&apos;yi geliştirebilir,</li>
                        <li>Hangi içeriklerin daha çok ilgi gördüğünü analiz edebiliriz.</li>
                    </ul>
                    <p>Bu çerezler genellikle anonim istatistiksel veriler üretir.</p>
                    
                    <h6 class="mt-3">2.3. İşlevsel Çerezler</h6>
                    <p>Bu çerezler, Site deneyiminizi kişiselleştirmek için kullanılır. Örneğin:</p>
                    <ul>
                        <li>Dil tercihinizin hatırlanması,</li>
                        <li>Geçmiş ziyaretlerinize göre bazı ayarların korunması.</li>
                    </ul>
                    <p>İşlevsel çerezler sayesinde Site&apos;yi her ziyaret ettiğinizde bazı tercihleri yeniden girmeniz gerekmez.</p>
                    
                    <h6 class="mt-3">2.4. Reklam ve Pazarlama Çerezleri (Kullanılıyorsa)</h6>
                    <p>Site&apos;de tarafımızca veya üçüncü taraf iş ortaklarımız tarafından reklam ve pazarlama amaçlı çerezler kullanılabilir. Bu çerezler:</p>
                    <ul>
                        <li>İlgi alanlarınıza daha uygun içerik ve reklam gösterilmesi,</li>
                        <li>Kampanyalarımızın etkinliğinin ölçülmesi</li>
                    </ul>
                    <p>amacıyla kullanılabilir.</p>

                    <h6 class="mt-4">3. ÇEREZLERİN SÜRELERİ</h6>
                    <p>Çerezler, saklandıkları süreye göre de ikiye ayrılır:</p>
                    <ul>
                        <li><strong>Oturum çerezleri:</strong> Sadece ziyaretiniz süresince geçerli olan, tarayıcıyı kapattığınızda silinen çerezlerdir.</li>
                        <li><strong>Kalıcı çerezler:</strong> Tarayıcı veya cihazınızda belirli bir süre boyunca saklanan çerezlerdir. Bu süre sona erdiğinde otomatik olarak silinir veya siz tarayıcı ayarlarından manuel olarak silebilirsiniz.</li>
                    </ul>

                    <h6 class="mt-4">4. BİRİNCİ TARAF VE ÜÇÜNCÜ TARAF ÇEREZLER</h6>
                    <ul>
                        <li><strong>Birinci taraf çerezler:</strong> Doğrudan evhayaliniz.com tarafından yerleştirilen çerezlerdir.</li>
                        <li><strong>Üçüncü taraf çerezler:</strong> Analiz, istatistik veya reklam hizmeti aldığımız üçüncü taraf sağlayıcılar tarafından yerleştirilen çerezlerdir.</li>
                    </ul>

                    <h6 class="mt-4">5. ÇEREZLERİ HANGİ AMAÇLARLA KULLANIYORUZ?</h6>
                    <p>Site&apos;de kullanılan çerezler başlıca şu amaçlarla kullanılmaktadır:</p>
                    <ul>
                        <li>Site&apos;nin güvenli ve düzgün çalışmasını sağlamak,</li>
                        <li>Üyelik işlemlerini ve oturum açma süreçlerini yönetmek,</li>
                        <li>Kullanıcı tercihlerinin (örneğin dil veya görüntüleme seçenekleri) hatırlanması,</li>
                        <li>Site trafiğini ve kullanım istatistiklerini analiz ederek Site performansını iyileştirmek,</li>
                        <li>İlgi alanlarına göre içerik ve hizmet önerebilmek.</li>
                    </ul>

                    <h6 class="mt-4">6. ÇEREZLERİ NASIL KONTROL EDİP YÖNETEBİLİRSİNİZ?</h6>
                    <p>Tarayıcı ayarları üzerinden çerezleri kontrol edebilir, silebilir veya kullanımını kısıtlayabilirsiniz. Çoğu tarayıcı:</p>
                    <ul>
                        <li>Tüm çerezleri kabul etme,</li>
                        <li>Tüm çerezleri reddetme,</li>
                        <li>Belirli siteler için çerez ayarları belirleme,</li>
                        <li>Tarayıcı kapandığında çerezleri silme</li>
                    </ul>
                    <p>gibi seçenekler sunar.</p>
                    <p>Tarayıcınızın &quot;ayarlar&quot; veya &quot;gizlilik&quot; bölümünden çerez tercihlerinizi değiştirebilirsiniz. Ayrıntılı bilgi için kullandığınız tarayıcının yardım menüsüne göz atabilirsiniz.</p>
                    <p><strong>Önemli Not:</strong> Çerezleri tamamen devre dışı bırakmanız hâlinde, Site&apos;nin bazı bölümleri düzgün çalışmayabilir veya beklediğiniz kadar hızlı, güvenli ve kişiselleştirilmiş bir deneyim sunamayabilir.</p>

                    <h6 class="mt-4">7. ÇEREZLERİN HUKUKİ DAYANAĞI</h6>
                    <p>Çerezler aracılığıyla işlenen kişisel verileriniz, KVKK kapsamında;</p>
                    <ul>
                        <li>&quot;Bir sözleşmenin kurulması veya ifası için gerekli olması&quot;,</li>
                        <li>&quot;Veri sorumlusunun meşru menfaati&quot;,</li>
                        <li>Zorunlu olmayan çerezler için açık rızanızın bulunması</li>
                    </ul>
                    <p>hukuki sebeplerine dayanılarak işlenebilmektedir.</p>
                    <p>Ayrıntılı bilgi için Gizlilik Politikamız ve KVKK Aydınlatma Metinlerimizi inceleyebilirsiniz.</p>

                    <h6 class="mt-4">8. ÇEREZ POLİTİKASINDA DEĞİŞİKLİKLER</h6>
                    <p>EvHayaliniz, işbu Çerez Politikası&apos;nı, yasal düzenlemeler ve Site&apos;de sunulan hizmetlerdeki değişiklikler doğrultusunda güncelleyebilir.</p>
                    <p>Güncel Çerez Politikası her zaman Site&apos;de yayımlanacaktır. Önemli bir değişiklik olması hâlinde, Site üzerinden veya gerekli gördüğümüz diğer iletişim kanalları aracılığıyla kullanıcılarımız bilgilendirilebilir.</p>

                    <h6 class="mt-4">9. İLETİŞİM</h6>
                    <p>Çerez Politikamız ve kişisel verilerinizin işlenmesine ilişkin sorularınız için bizimle aşağıdaki iletişim kanalları üzerinden irtibata geçebilirsiniz:</p>
                    <p><strong>Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi</strong><br>
                    <strong>Adres:</strong> İstiklal Mah Özkılıç Sok. No 2A Ortaköy/Aksaray<br>
                    <strong>E-posta:</strong> evhayaliniz@gmail.com<br>
                    <strong>Telefon:</strong> +90 542 655 67 40</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="aydinlatmametni" tabindex="-1" aria-labelledby="aydinlatmametniLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
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
                        {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} &apos;da satışı yasak olan "Yasaklı Ürünler Listesi"ni de görebilirsiniz.


                    </p>
                    <p>
                        Güven Damgası, sadece ilgili Tebliğ uyarınca GDS tarafından incelemesi, takibi ve kontrolü sağlanan mevzuata uygunluk kriterlerinin varlığına delalet eder. Bunun haricinde Güven Damgası Sağlayıcısı, hiçbir suretle taraflar arasındaki sözleşmenin garantörü ya da taahhüt edeni olarak anlaşılamayacağı gibi, E-ticaret sitesinde bulunan mal ya da hizmetlerin ayıptan ari vasıflarının ve eksiksiz temin ve tesliminin kefili de değildir. Ayrıca Güven Damgası Sağlayıcısı malın teslim edilmemesi, geç teslim edilmesi ya da taahhüt edilen niteliklere uygun olarak teslim edilmemesi hallerinden hukuken hiçbir surette sorumlu tutulamaz.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kullanimkosullari" tabindex="-1" aria-labelledby="kullanimkosullariLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kullanimkosullariLabel">Aydınlatma Metni</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Kullanım Koşulları

                        1. KULLANIM KOŞULLARI

                    </p>
                    <p>

                        www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} alan adlı internet sitesini kullanmak için lütfen aşağıda yazılı koşulları okuyunuz. www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} internet sitesini ziyaret ederek ve/veya mobil uygulamalarını kullanarak (internet sitesi ve/veya mobil uygulamalar bundan böyle “Portal” olarak anılacaktır) ve/veya “Hesap Sahibi” olarak, işbu “Kullanım Koşulları”nı okuduğunuzu, içeriğini tamamen anladığınızı, “Kullanım Koşulları”nda belirtilen ve “Portal”da bulunan ve zaman içinde yer alacak tüm hususları kayıtsız ve şartsız olarak kabul ettiğinizi, “Portal”da belirtilen tüm hususlarla ilgili olarak herhangi bir itiraz ve defi ileri sürmeyeceğinizi kabul, beyan ve taahhüt ediyorsunuz. Bu koşulları kabul etmediğiniz takdirde, lütfen "Portal"ı kullanmaktan vazgeçiniz.

                    </p>
                    <p>

                        1.1. İşbu “Portal”ın sahibi “Kılıçaslan Mah. 1303 SK. No:28 Nora City İş Merkezi A Blok Kat:4 Daire:2 Merkez/Aksaray/Türkiye” adresinde mukim Evhayaliniz Bilgi Teknoloji Ticaret Ve Limited Şirketi (bundan böyle kısaca "EVHAYALİNİZ" olarak anılacaktır)’dir. “Portal”da sunulan ve işbu “Kullanım Koşulları”nın 3. maddesinde belirtilen hizmetler, “EVHAYALİNİZ” tarafından sağlanmaktadır.

                    </p>
                    <p>

                        1.2. " EVHAYALİNİZ " işbu “Kullanım Koşulları”nı, “Portal”da yer alan her tür bilgi ve “İçerik”i, "KULLANICI"ya herhangi bir ihbarda veya bildirimde bulunmadan dilediği zaman değiştirebilir. Bu değişiklikler periyodik olarak “www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}”da yayımlanacak ve yayımlandığı tarihte geçerli olacaktır. “Portal” hizmetlerinden belirli bir bedel ödeyerek ya da bedelsiz olarak yararlanan veya herhangi bir şekilde “Portal”a erişim sağlayan her gerçek veya tüzel kişi “Kullanım Koşulları”nı ve " EVHAYALİNİZ " tarafından işbu “Kullanım Koşulları”nda yapılan her değişikliği kabul etmiş sayılmaktadır. İşbu " Kullanım Koşulları" www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} internet sitesi üzerinden yayınlanarak; “Portal”ı kullanan her gerçek veya tüzel kişi tarafından erişimi mümkün kılınmıştır.

                    </p>

                    <p>

                        2. TANIMLAR

                    </p>
                    <p>

                        “Portal”: www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} isimli alan adından ve bu alan adına bağlı alt alan adlarından oluşan “EVHAYALİNİZ”in “Hizmet”lerini sunduğu internet sitesi.

                        “Kullanıcı”: “Portal”a erişen her gerçek veya tüzel kişi.

                        “Hesap Sahibi”: “Portal”da hesabı olan ve "Portal" dahilinde sunulan hizmetlerden işbu sözleşmede belirtilen koşullar dahilinde yararlanan “Kullanıcı”.

                    </p>
                    <p>
                        “EVHAYALİNİZ Hizmetleri” ("Hizmet"): "Portal" içerisinde " Hesap Sahibi"nin işbu sözleşme içerisinde tanımlı olan iş ve işlemlerini gerçekleştirmelerini sağlamak amacıyla “EVHAYALİNİZ” tarafından sunulan uygulamalardır. " EVHAYALİNİZ ", "Portal" içerisinde sunulan "Hizmet"lerinde dilediği zaman değişiklikler ve/veya uyarlamalar yapabilir. Yapılan değişiklikler ve/veya uyarlamalarla ilgili " Hesap Sahibi "nin uymakla yükümlü olduğu kural ve koşullar “Portal”dan " Hesap Sahibi "ne duyurulur, açıklanan şartlar ve koşullar “Portal”da yayımlandığı tarihte yürürlüğe girer.

                        “İçerik”: “Portal”da yayınlanan ve erişimi mümkün olan her türlü bilgi, yazı, dosya, resim, video, rakam vb. görsel, yazımsal ve işitsel imgeler.

                        "EVHAYALİNİZ Arayüzü" : EVHAYALİNİZ ve "Hesap Sahibi” tarafından oluşturulan içeriğin "Kullanıcı”lar tarafından görüntülenebilmesi ve " EVHAYALİNİZ Veritabanı"ından sorgulanabilmesi amacıyla "Kullanıcı”lar tarafından kullanılan; 5846 Sayılı Fikir ve Sanat Eserleri Kanunu kapsamında korunan ve tüm fikri hakları “EVHAYALİNİZ”e ait olan tasarımlar içerisinde “Portal” üzerinden yapılabilecek her türlü işlemin gerçekleştirilmesi için bilgisayar programına komut veren internet sayfaları.

                        “EVHAYALİNİZ Veri Tabanı” : “Portal” dahilinde erişilen içeriklerin depolandığı, tasnif edildiği, sorgulanabildiği ve erişilebildiği “EVHAYALİNİZ”e ait olan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu gereğince korunan veri tabanıdır

                    </p>
                    <p>

                        3. SAHİBİNDEN HİZMETLERİ

                    </p>
                    <p>
                        3.1. " EVHAYALİNİZ ", " “Hesap Sahibi” tarafından " EVHAYALİNİZ Veri Tabanı"na yüklenen içeriklerin, arayüzler kullanılmak suretiyle " EVHAYALİNİZ Veri Tabanı" üzerinden "Kullanıcı”lar tarafından görüntülenebilmesini temin etmektedir.

                        3.2. " EVHAYALİNİZ ", “Portal” içerisinde "Kullanıcı”ların, " Hesap Sahibi " ilanlarına daha kolay ulaşabilmelerini sağlamak üzere ilanların görüntülenmesini önceliklendiren çeşitli tiplerde listeleme hizmetleri vermektedir.

                        3.3. " EVHAYALİNİZ ", “Portal” dahilinde gerçekleştirilen işlemlere, görüntüleme sayılarına yönelik çeşitli kategoriler altında raporlama hizmetlerini sunmaktadır.

                        3.4. " EVHAYALİNİZ ", “Portal” dahilinde verdiği hizmetlere yenilerini ekleme, mevcut hizmetlerin kapsam ve sunulma koşulları ile “Portal” dahilinde erişilen "İçerik"leri her zaman değiştirme, üçüncü kişilerin erişimine kapatabilme ve silme hakkını saklı tutmaktadır. " EVHAYALİNİZ ", bu hakkını hiçbir bildirimde bulunmadan ve önel vermeden dilediği biçimde kullanabilir.


                    </p>
                    <p>
                        4. EVHAYALİNİZ PORTALI KULLANIMINA İLİŞKİN KOŞULLAR VE YÜKÜMLÜLÜKLER
                    </p>
                    <p>
                        4.1. "Kullanıcı”lar hukuka uygun amaçlarla “Portal” üzerinde işlem yapabilirler. "Kullanıcı”ların “Portal” dahilinde yaptığı her işlem ve eylemdeki hukuki ve cezai sorumluluk kendilerine ait olacak olup, söz konusu hukuki ve cezai yükümlülüklerle ilgili “EVHAYALİNİZ”in herhangi bir sorumluluğu bulunmadığını “Kullanıcı” kabul, beyan ve taahhüt etmektedir.

                        4.2. “Portal”, "Hesap Sahibi” tarafından " EVHAYALİNİZ Veri Tabanı"na yüklenen "İçerik"lerin görüntülenmesi esasıyla çalışmaktadır. " EVHAYALİNİZ ", "Kullanıcı"lar tarafından görüntülenen ilan ve "İçerik"lerin hiçbir koşulda doğruluğunu, gerçekliği, güvenliğini ve hukuka uygunluğunu garanti etmemektedir. Söz konusu ilan ve "İçerik"ler dolayısıyla “EVHAYALİNİZ”in herhangi bir sorumluluğu bulunmadığını, ortaya çıkabilecek zararlardan ötürü “EVHAYALİNİZ”in hiçbir tazmin yükümlülüğü olmayacağını “Kullanıcı”lar kabul ve beyan etmektedir.

                        4.3. "KULLANICI" “PORTAL” dahilinde bulunan her türlü resimleri, metinleri, görsel ve işitsel imgeleri, video klipleri, dosyaları, veri tabanları, katalogları ve listeleri çoğaltmayacağı, kopyalamayacağı, dağıtmayacağı, işlemeyeceğini, bu tür eylemler gerçekleştirerek herhangi bir ticari faaliyette bulunmayacağını; doğrudan ve/veya dolaylı olarak haksız rekabet teşkil eden davranış ve işlemler gerçekleştirmeyeceğini kabul ve taahhüt etmektedir.

                        4.4. "Kullanıcı"lar “Portal” dâhilinde Türk Ticaret Kanunu hükümleri uyarınca haksız rekabete yol açacak faaliyetlerde bulunmayacağını, " EVHAYALİNİZ "in ve üçüncü kişilerin şahsi ve ticari itibarı sarsacak, kişilik haklarına tecavüz veya taarruz edecek fiilleri gerçekleştirmeyeceğini, mevzuata, kamu düzenine ve genel ahlak kurallarına uygun hareket edeceğini, mevzuatın gerektirdiği önlemleri alacağını ve prosedürleri yerine getireceğini, yasadışı, suç teşkil edecek, rahatsız edici, kişilik haklarına zarar verici, fikri haklara, telif haklarına, marka haklarına ve mülkiyet haklarına tecavüz edici tutum ve davranışlarda bulunmayacağını kabul ve taahhüt etmektedir.

                        4.5. "Kullanıcı"lar, “Portal” dahilinde eriştikleri bilgileri yalnızca bu bilgileri ifşa eden "Hesap Sahibi" veya " EVHAYALİNİZ "in amacına uygun olarak kullanmakla, ticari olmayan amaçla görüntülemekle yükümlüdür. İlan veren Hesap sahibi tarafından girilmiş bulunan ilanlardaki iletişim bilgileri ilan hakkında bilgi almak için iletişim kurulması amacıyla kullanılabilir. İlanda yer alabilecek 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun kapsamında koruma altında olan ilan verene ait veya üçüncü kişilere ait kişisel veriler ve/veya özel nitelikli kişisel veriler, başkaca bir amaçla kullanılamaz, kopyalanamaz, başka mecralarda doğrudan veya dolaylı olarak yayınlanamaz, işlenemez, dağıtılamaz, başkaca veri tabanlarına aktarılarak üçüncü kişilerin erişimine ve kullanımına açılamaz.

                        4.6. " EVHAYALİNİZ ", 5651 Sayılı Yasa uyarınca "Yer Sağlayıcılığı Faaliyet Belgesi"ne sahiptir. 5651 Sayılı Yasa ve ilgili mevzuat uyarınca "Yer Sağlayıcı"lara getirilen yükümlülüklere uymak amacıyla "Kullanıcı"ların “Portal” üzerinde gerçekleştirdikleri işlemlere ilişkin ilgili mevzuatta belirtilen nitelikteki kayıtları yasal süresi içinde kayıt altına almakta ve saklamaktadır.

                        4.7. " EVHAYALİNİZ ", "Kullanıcı" bilgilerini kullanabilir, işleyebilir, paylaşabilir, ifşa edebilir, bir veri tabanı üzerinde tasnif edip muhafaza edebilir, tanıtım ve bilgilendirme amaçlı iletişim faaliyetlerinde, pazarlama faaliyetlerinde ve istatistikî analizler yapmak amacıyla kullanabilir. " EVHAYALİNİZ " aynı zamanda; kullanıcının IP adresi, “Portal”ın hangi bölümlerini ziyaret ettiği, domain tipi, tarayıcı (browser) tipi, tarih ve saat gibi bilgileri de istatistiki değerlendirme ve kişiye yönelik hizmetler ve teklifler sunma gibi amaçlarla kullanabilir. ” EVHAYALİNİZ” süreçlerini iyileştirme amaçlı araştırmalar yapmak, veri tabanı oluşturmak ve pazar araştırmaları yapmak için işbirliği içinde olduğu firmalara Kullanıcı bilgilerini aktarabilir ve bu firmalar tarafından yukarıda sayılan amaçlarla sınırlı olarak Kullanıcı bilgileri işlenebilir.

                        4.8. EVHAYALİNİZ, çevrimiçi davranışsal reklamcılık ve pazarlama yapılabilmesi amacıyla siteye gelen kullanıcının sitedeki davranışlarını tarayıcıda bulunan bir cookie (çerez) ile ilişkilendirme ve görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı gibi metrikleri temel alan yeniden pazarlama listeleri tanımlama, pazarlama otomasyon araçlarını kullanma ve kullanıcıya özel mesaj/teklif ve öneriler iletme hakkını haizdir. Daha sonra bu kullanıcıya sitede ya da Görüntülü Reklam Ağındaki diğer sitelerde, kullanıcıların ilgi alanlarına göre hedefe yönelik reklam içeriği gösterebilir. Ayrıca Google, AFS reklamlarının EVHAYALİNİZ’e yönlendirilmesi esnasında Google KULLANICILARIN tarayıcısına çerez yerleştirebilir veya bunlarda yer alan çerezleri okuyabilir veya bilgi toplamak amacı ile web işaretleri kullanabilir.

                        4.9. “Portal” üzerinden erişilen ve/veya görüntülenen içeriğin depolandığı veri tabanına yalnızca ilgili içeriklerin görüntülenmesi amacıyla ve/veya " EVHAYALİNİZ "in “Kullanım Koşulları” çerçevesinde üçüncü kişilerce erişilmesi hukuka uygundur. Bunun dışındaki yapılan erişimler hukuka aykırı olup; " EVHAYALİNİZ’in her tür talep, dava ve takip hakları saklıdır.

                        4.10. “EVHAYALİNİZ”, “ilanların içeriklerini öğrenme amacıyla görüntülemeye ve “EVHAYALİNİZ Arayüzü”nü kullanmaya izin vermekte olup, bunun dışında bir amaçla veri tabanı üzerinden belirli bir sayıda veya bütününe yönelik olarak ilanlara ulaşılmaya çalışılması, ilanların, müşteri bilgilerinin, tasarımlarının, kod ve yazılımlarının, veri tabanında yer alan bilgilerinin kısmen veya tamamen kopyalanması, bunların başka mecralarda doğrudan veya dolaylı olarak yayınlanması, derlenmesi, işlenmesi, değiştirilmesi, başka veri tabanlarına aktarılması, bu veri tabanından üçüncü kişilerin erişimine ve kullanımına açılması, “EVHAYALİNİZ” üzerindeki ilanlara link verilmesi de dâhil olmak üzere benzer fiillerin işlenmesine “EVHAYALİNİZ” tarafından izin verilmemekte ve rıza gösterilmemektedir. Bu tür fiiller hukuka aykırı olup; " EVHAYALİNİZ’in talep, dava ve takip hakları saklıdır.

                        4.11. "Portal"ın bütününün veya herhangi bir bölümünün bozma, değiştirme, tersine mühendislik yapma amacıyla kullanılması, tersine mühendislik (reverse engineering) metoduyla veya farklı herhangi bir metodla API protokollerinin kırılmaya çalışılması ve API anahtarı, API gizli anahtarı, istek başlıkları, istemci doğrulama algoritması gibi parametrelere izinsiz olarak ulaşılması veya bu parametrelerin izinsiz olarak üçüncü kişilerle paylaşılması, "Portal"ın iletişim veya teknik sistemleri engelleyen, bozan ya da sistemlere müdahale eder bir şekilde "Site"ye erişim sağlanmaya çalışılması, Site üzerinde otomatik program, robot, örümcek, web crawler, örümcek, veri madenciliği (data mining) veri taraması (data crawling) vb. "screen scraping" yazılımları veya sistemleri, otomatik aletler ya da manuel süreçler kullanılması, diğer kullanıcılarının verilerine veya yazılımlarına izinsiz olarak ulaşılması, çeşitli kriterlere göre yapılacak tespitler neticesinde bot çalıştırma, DDOS atakları ve sair her türlü sistemlerin bütününü veya bir kısmını bozmaya, değiştirmeye, mevcut performansını azaltmaya veya yok etmeye ve sair her türlü sisteme yönelik saldırıların ve sair hukuka aykırı kullanımların yapılması durumunda bu tür kullanımlar EVHAYALİNİZ’in takdirine bağlı olarak engellenecektir. Bu tür kullanımlar olmasa dahi EVHAYALİNİZ, gerekli gördüğü hallerde ancak “Hesap Sahibi”nin kullanıcı adı ve parolası ile giriş yapmasından sonra Portal’in kullanımına izin verilebilir. "Site"nin ve "Portal"deki içeriğin “Kullanım Koşulları” ile belirlenen kullanım sınırları dışında kullanılması hukuka aykırı olup; " EVHAYALİNİZ "in her tür talep, dava ve takip hakları saklıdır. İşbu şartlara ve yasalara aykırı kullanımın tespiti halinde; “EVHAYALİNİZ”, “Kullanıcıyı yetkili makamlara bildirme hakkına sahiptir. “Kullanıcı” bu tür kullanımlar sonucu oluşan zarar ve taleplerden “bizzat sorumlu olduğunu kabul etmektedir.

                        4.12. “Portal”da verilen hizmetin kesintiye uğraması, bilgi iletiminde aksaklıklar, gecikmeler, başarısızlar yaşanması, veri kaybı halinde oluşabilecek her türlü doğrudan ve dolaylı zararlardan “EVHAYALİNİZ”in sorumlu tutulamayacağını “Kullanıcı” kabul ve taahhüt etmektedir.

                        4.13. Güven Damgası, sadece ilgili Tebliğ uyarınca GDS tarafından incelemesi, takibi ve kontrolü sağlanan mevzuata uygunluk kriterlerinin varlığına delalet eder. Bunun haricinde Güven Damgası Sağlayıcısı, hiçbir suretle taraflar arasındaki sözleşmenin garantörü ya da taahhüt edeni olarak anlaşılamayacağı gibi, E-ticaret sitesinde bulunan mal ya da hizmetlerin ayıptan ari vasıflarının ve eksiksiz temin ve tesliminin kefili de değildir. Ayrıca Güven Damgası Sağlayıcısı malın teslim edilmemesi, geç teslim edilmesi ya da taahhüt edilen niteliklere uygun olarak teslim edilmemesi hallerinden hukuken hiçbir surette sorumlu tutulamaz.

                    </p>
                    <p>
                        5. FİKRİ MÜLKİYET HAKLARI
                    </p>
                    <p>

                        Bu “Portal” dahilinde erişilen veya hukuka uygun olarak kullanıcılar tarafından sağlanan bilgiler ve bu “Portal”ın (sınırlı olmamak kaydıyla " EVHAYALİNİZ Veri Tabanı", " EVHAYALİNİZ Arayüzü", tasarım, metin, imge, html kodu ve diğer kodlar) tüm elemanları (hepsi birlikte " EVHAYALİNİZ "in telif haklarına tabi çalışmaları” olarak anılacaktır) " EVHAYALİNİZ "e ait ve/veya " EVHAYALİNİZ " tarafından üçüncü bir kişiden lisans altında alınmıştır. "Kullanıcı"lar, " EVHAYALİNİZ " hizmetlerini, " EVHAYALİNİZ " bilgilerini ve " EVHAYALİNİZ "in telif haklarına tabi çalışmalarını yeniden satmak, işlemek, kopyalamak, paylaşmak, dağıtmak, sergilemek veya başkasının " EVHAYALİNİZ "in hizmetlerine erişmesi veya kullanmasına izin vermek hakkına sahip değildirler. İşbu "Site Kullanım Koşulları" dahilinde " EVHAYALİNİZ " tarafından sarahaten izin verilen durumlar haricinde " EVHAYALİNİZ "in telif haklarına tabi çalışmalarını çoğaltamaz, işleyemez, dağıtamaz veya bunlardan türemiş çalışmalar yapamaz.

                        İşbu "Kullanım Koşulları" dahilinde " EVHAYALİNİZ " tarafından sarahaten yetki verilmediği hallerde " EVHAYALİNİZ "; " EVHAYALİNİZ " hizmetleri, " EVHAYALİNİZ " bilgileri, " EVHAYALİNİZ " telif haklarına tabi çalışmaları, " EVHAYALİNİZ " ticari markaları, " EVHAYALİNİZ " ticari görünümü veya bu site vasıtasıyla sağladığı başkaca varlık ve bilgilere yönelik tüm haklarını saklı tutmaktadır.

                    </p>
                    <p>
                        6. KULLANIM KOŞULLARINDA DEĞİŞİKLİKLER
                    </p>
                    <p>
                        "EVHAYALİNİZ", dilediğinde, tek taraflı olarak işbu "Kullanım Koşulları"nı herhangi bir zamanda “Portal”da ilan ederek değiştirebilir. İşbu "Kullanım Koşulları"nın değişen hükümleri, ilan edildikleri tarihte geçerlilik kazanarak, yürürlüğe girecektir. İşbu "Kullanım Koşulları" “Kullanıcı”nın tek taraflı beyanları ile değiştirilemez.
                    </p>
                    <p>

                        7. MÜCBİR SEBEPLER

                        Hukuken mücbir sebep sayılan tüm durumlarda, geç ifa etme, eksik ifa etme veya ifa etmeme hallerinde " EVHAYALİNİZ"in herhangi bir tazminat yükümlülüğü doğmayacaktır. "Mücbir sebep", ilgili tarafın makul kontrolü haricinde ve " EVHAYALİNİZ "in gerekli özeni göstermesine rağmen önleyemediği olaylar olarak yorumlanacak olup, sayılanlarla sınırlı olmamak şartıyla doğal afet, savaş, yangın, grev, ayaklanma, isyan, kötü hava koşulları, altyapı ve internet arızaları, sisteme ilişkin iyileştirme veya yenileştirme çalışmaları ve bu sebeple meydana gelebilecek her türlü arıza, elektrik kesintisi mücbir sebep hallerindendir.

                        8. UYGULANACAK HUKUK VE YETKİ

                        İşbu "Kullanım Koşulları" uygulanmasında, yorumlanmasında ve bu "Kullanım Koşulları" dahilinde doğan hukuki ilişkilerin yönetiminde yabancılık unsuru bulunması durumunda Türk kanunlar ihtilafı kuralları hariç olmak üzere Türk Hukuku uygulanacaktır. İşbu “Kullanım Koşulları”ndan dolayı doğan veya doğabilecek her türlü ihtilafın hallinde Aksaray Merkez Mahkemeleri ve İcra Daireleri yetkilidir.

                        9. YÜRÜRLÜK ve KABUL

                        İşbu "Kullanım Koşulları" "EVHAYALİNİZ" tarafından “Portal”de yayınlandığı tarihte yürürlüğe girer. "Kullanıcı"lar işbu ”Kullanım Koşulları”nı ve zaman içinde yapılan değişiklikleri “Portal”ı kullanmakla kabul etmiş olmaktadırlar.



                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="overlay" onclick="off()"></div>
    <div class="modal fade" id="sozlesme" tabindex="-1" aria-labelledby="sozlesmeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sozlesmeLabel">Kullanıcı Sözleşmesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Bireysel Hesap* Sözleşmesi </p>

                    <p>
                        1. Taraflar

                        İşbu Bireysel Hesap Kullanıcı Sözleşmesi (bundan böyle “Kullanıcı Sözleşmesi” olarak anılacaktır); “İstiklal, Özkılıç Sokak no 2A, 68400 Ortaköy/Aksaray, Aksaray, TÜRKİYE” adresinde mukim Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi (bundan böyle kısaca "EVHAYALİNİZ" olarak anılacaktır) ile www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} Portalda hesap açmak için işbu Kullanıcı Sözleşmesi ile ayrılmaz parçası olan eklerine ve {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} Portalında yer alan şartlar ile kurallara onay veren "Hesap Sahibi" arasında elektronik ortamda akdedilerek yürürlüğe girmiştir.


                    </p>

                    <p>

                        2. Tanımlar

                        “Portal”: www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} isimli alan adından ve bu alan adına bağlı alt alan adlarından oluşan “EVHAYALİNİZ”’in hizmetlerini sunduğu internet sitesi ve/veya mobil uygulamalar.

                        “Kullanıcı”: “Portal”a erişen her gerçek veya tüzel kişi.

                        “Hesap Sahibi”: “Portal”da hesap açan ve "Portal" dahilinde sunulan hizmetlerden belirlenen koşullar dahilinde yararlanan “Kullanıcı”.

                        “Bireysel Hesap Sahibi”: “Portal”da hesap oluşturan, mesleki veya ticari amaç gütmeksizin "Portal" dahilinde sunulan hizmetlerden belirlenen koşullar dahilinde yararlanan “Kullanıcı”.

                        “Bireysel Hesap” (“Hesap”): “Bireysel Hesap” oluşturmak isteyen “Kullanıcı”nın, “Portal”daki Bireysel Hesap Formu’nu doğru ve gerçek bilgilerle eksiksiz olarak doldurması üzerine “EVHAYALİNİZ” tarafından yapılan bildirim ile kazanılan statüdür. Hesap işlemleri tamamlanmadan “Bireysel Hesap Sahibi” olma hak ve yetkisine sahip olunamaz. “Bireysel Hesap Sahibi”nin hak ve yükümlülükleri, başvuruda bulunana ait olan, kısmen veya tamamen herhangi bir üçüncü şahsa devredilemeyen hak ve yükümlülüklerdir. Hesap Oluşturma başvurusu herhangi bir sebep gösterilmeksizin “EVHAYALİNİZ” tarafından reddedilebilir veya ek şart ve koşullar talep edilebilir. “EVHAYALİNİZ” gerekli görmesi halinde “Bireysel Hesap Sahibi”nin hesabını kapatabilir, hesabı herhangi bir sebeple kapatılanın yapacağı hesap açma talebini kabul etmeyebilir.

                        "Kullanıcı Sözleşmesi": “Portal”da yer alan şartlar ve koşullar ile eklerden oluşan, kullanıcının “Kullanıcı Sözleşmesi”ni anladığına ve kabul ettiğine ilişkin elektronik olarak verdiği onay neticesinde elektronik ortamda akdedilen, ayrılmaz parçası olan ekler ile “Portal”da yer alan şart ve kurallarla birlikte bir bütün olan elektronik sözleşme.

                        "EVHAYALİNİZ Hesabı": “Hesap Sahibi”nin "Portal" içerisinde sunulan hizmetlerden yararlanmak için gerekli olan iş ve işlemleri gerçekleştirdiği, "Hesap” ile ilgili konularda "EVHAYALİNİZ"e talepte bulunduğu, "Hesap bilgilerini güncelleyip, sunulan hizmetlerle ilgili raporlamaları görüntüleyebildiği, kendisinin belirlediği ve münhasıran kendisi tarafından kullanılacağını taahhüt ettiği "kullanıcı adı" ve "şifre" ile "Portal" üzerinden eriştiği "Hesap Sahibi"ne özel internet sayfaları bütünü.

                        “EVHAYALİNİZ Hizmetleri” ("Hizmetler"): "Portal" içerisinde "Hesap Sahibi"nin işbu “Kullanıcı Sözleşmesi” içerisinde tanımlı olan iş ve işlemlerini gerçekleştirmelerini sağlamak amacıyla “EVHAYALİNİZ” tarafından sunulan uygulamalardır. "EVHAYALİNİZ", "Portal" içerisinde sunulan "Hizmetler"inde dilediği zaman değişiklikler ve/veya uyarlamalar yapabilir. Yapılan değişiklikler ve/veya uyarlamalarla ilgili "Hesap Sahibi"nin uymakla yükümlü olduğu kural ve koşullar “Portal”dan "Hesap Sahibi"ne duyurulur, açıklanan şartlar ve koşullar “Portal”da yayımlandığı tarihte yürürlüğe girer.

                        “İçerik”: “Portal”da yayınlanan ve erişimi mümkün olan her türlü bilgi, yazı, dosya, resim, video, rakam vb. görsel, yazımsal ve işitsel imgeler.

                        "EVHAYALİNİZ Arayüzü" : EVHAYALİNİZ ve "Hesap Sahibi” tarafından oluşturulan içeriğin "Kullanıcı”lar tarafından görüntülenebilmesi ve "EVHAYALİNİZ Veri tabanı"ından sorgulanabilmesi amacıyla "Kullanıcı”lar tarafından kullanılan; 5846 Sayılı Fikir ve Sanat Eserleri Kanunu kapsamında korunan ve tüm fikri hakları “EVHAYALİNİZ”e ait olan tasarımlar içerisinde “Portal” üzerinden yapılabilecek her türlü işlemin gerçekleştirilmesi için bilgisayar programına komut veren internet sayfaları ve mobil uygulama ekranları/sayfalarıdır.

                        “EVHAYALİNİZ Veri Tabanı” : “Portal” dahilinde erişilen içeriklerin depolandığı, tasnif edildiği, sorgulanabildiği ve erişilebildiği “EVHAYALİNİZ”e ait olan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu gereğince korunan veri tabanıdır.

                        “Profilim” sayfası: "Hesap Sahibi"nin "Portal"da yer alan çeşitli uygulamalardan ve "Hizmetler”den yararlanabilmesi için gerekli işlemleri gerçekleştirebildiği, kişisel bilgilerini, tercihlerini, uygulama bazında kendisinden talep eden bilgileri girdiği, sadece "Hesap Sahibi" tarafından belirlenen kullanıcı adı ve şifre ile erişilebilen "Hesap Sahibi"ne özel sayfa.

                        “Kişisel Veri”: 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun’un (KVKK) 3/d maddesi uyarınca, kimliği belirli veya belirlenebilir gerçek kişiye ilişkin her türlü bilgi ile KVKK m.6/1’de sayılan özel nitelikli kişisel verilerdir.

                        “Özel nitelikli kişisel veri”: Kişilerin ırkı, etnik kökeni, siyasi düşüncesi, felsefi inancı, dini, mezhebi veya diğer inançları, kılık ve kıyafeti, dernek, vakıf ya da sendika üyeliği, sağlığı, cinsel hayatı, ceza mahkûmiyeti ve güvenlik tedbirleriyle ilgili verileri ile biyometrik ve genetik verileri özel nitelikli kişisel veridir.


                    </p>

                    <p>

                        3. “Kullanıcı Sözleşmesi”nin Konusu ve Kapsamı

                        İşbu “Kullanıcı Sözleşmesi”nin konusu, "Portal"da sunulan “Hizmetler ve İçerikler”in, bu “Hizmetler ve İçerikler”den yararlanma şartları ile tarafların hak ve yükümlülüklerinin tespitidir. “Kullanıcı Sözleşmesi” ve ekleri ile "Portal" içerisinde yer alan kullanıma, hesaba ve “Hizmetler ve İçerikler”e ilişkin “EVHAYALİNİZ” tarafından yapılan tüm uyarı, bildirim, uygulama ve açıklama gibi beyanlar kapsam dâhilindedir. "Kullanıcı", işbu “Kullanıcı Sözleşmesi” hükümlerini kabul etmekle, "Portal" içinde yer alan kullanıma, hesap sahibi olmaya ve hizmetler ve içeriklere ilişkin “EVHAYLİNİZ” tarafından açıklanan her türlü beyana uygun davranacağını kabul ve taahhüt etmektedir.

                    </p>

                    <p>

                        4. Hesap Şartları

                        4.1 "Portal"da “Hesap Sahibi” olabilmek için reşit olmak ve “EVHAYALİNİZ” tarafından işbu “Kullanıcı Sözleşmesi” kapsamında hesabın geçici olarak durdurulmamış veya hesabın kapatılmamış olması gerekmektedir.

                        4.2 “EVHAYALİNİZ” herhangi bir zamanda gerekçe göstermeden, bildirimde bulunmadan, tazminat, ceza vb. sair yükümlülüğü bulunmaksızın derhal yürürlüğe girecek şekilde işbu “Kullanıcı Sözleşmesi”ni tek taraflı olarak feshedebilir, "Hesap Sahibi"nin hesabını kapatabilir veya geçici olarak durdurabilir. "Portal"da belirtilen kurallara aykırılık halleri, “Hesap Sahibi”nin "EVHAYALİNİZ" bilgi güvenliği sistemine risk oluşturması halleri hesabının kapatılması veya hesabın geçici olarak durdurulma hallerindendir.

                        5. Tarafların Hak ve Yükümlülükleri

                        5.1 "Hesap Sahibi"nin Hak ve Yükümlülükleri

                        5.1.1 “Hesap Sahibi", “Portal"da belirtilen kurallara, beyanlara, yürürlükteki tüm mevzuata ve ahlak kurallarına uygun hareket edeceğini, “Kullanıcı Sözleşmesi” hükümleri ile “Portal”daki tüm şart ve kuralları anladığını ve onayladığını kabul ve taahhüt etmektedir.

                        5.1.2 "Hesap Sahibi”, “EVHAYALİNİZ”in yürürlükteki mevzuat hükümleri gereğince resmi makamlara açıklama yapmakla yükümlü olduğu durumlarda; “Hesap Sahibi”ne ait gizli/özel/kişisel veri-özel nitelikli kişisel veri/ticari bilgileri resmi makamlara açıklamaya yetkili olduğunu, bu sebeple “EVHAYALİNİZ”den her ne nam altında olursa olsun tazminat talep etmeyeceğini kabul ve taahhüt etmektedir. Bunun haricinde “Hesap Sahibi”nin “Portal” üzerinde verdiği hizmet ve içeriklerle ilgili olarak herhangi bir kişi ya da kurumun haklarının ihlal edildiği iddiası ile “EVHAYALİNİZ”e bildirimde bulunması, yargı yoluna başvuracağını bildirmesi halinde; “Hesap Sahibi”nin kendisine bildirdiği ad-soyad bilgisini “EVHAYALİNİZ” ilgili tarafa verebilir.

                        5.1.3. "Hesap Sahibi”nin, “EVHAYALİNİZ Hesabı”na girişte kullandığı "kullanıcı adı" ve "şifre"nin güvenliğini sağlamak kendi sorumluluğunda olup, "kullanıcı adı" ve "şifre"sini münhasıran ve münferiden kendisi kullanması, üçüncü kişilerden saklaması gerekmektedir. Bu konuda ihmal veya kusurlarından dolayı diğer “Hesap Sahibi”nin ve/veya “EVHAYALİNİZ”in ve/veya üçüncü kişilerin uğradığı veya uğrayabileceği maddi ve/veya manevi her tür zararlardan “Hesap Sahibi” sorumludur.

                        5.1.4. "Hesap Sahibi", "Portal" dahilinde kendisi tarafından sağlanan bilgilerin ve içeriklerin doğru ve hukuka uygun olduğunu, söz konusu bilgi ve içeriklerin "Portal" üzerinde yayınlanmasının veya bu içeriklerle bağlantılı ürünlerin satışının ve teşhirinin, yürürlükteki mevzuat karşısında herhangi bir hukuka aykırılık yaratmadığını kabul ve taahhüt etmektedir. "EVHAYALİNİZ", "Hesap Sahibi" tarafından "EVHAYALİNİZ"e iletilen veya "Portal" üzerinden “Hesap Sahibi” tarafından yüklenen bilgilerin ve içeriklerin doğruluğunu araştırmakla yükümlü ve sorumlu olmadığı gibi, söz konusu bilgi ve içeriklerin yanlış veya hatalı olmasından veya yayınlanmasından dolayı ortaya çıkacak hiçbir zarardan sorumlu tutulamaz.

                        5.1.5. "Hesap Sahibi", " EVHAYALİNİZ "in yazılı onayı olmadan işbu “Hesap Sözleşmesi”ni veya bu “Hesap Sözleşmesi”nin kapsamındaki hak ve yükümlülüklerini kısmen veya tamamen herhangi bir üçüncü kişiye devredemez.

                        5.1.6. “Hesap Sahibi” hukuka uygun amaçlarla "Portal" üzerinde işlem yapabilir. "Hesap Sahibi"nin, "Portal" dahilinde yaptığı her işlem ve eylemdeki hukuki ve cezai sorumluluk kendisine aittir. "Hesap Sahibi", " EVHAYALİNİZ "in ve/veya başka bir üçüncü şahsın ayni veya şahsi haklarına, malvarlığına, kişisel verilerine tecavüz teşkil edecek nitelikteki "Portal" dâhilinde bulunan resimleri, metinleri, görsel ve işitsel imgeleri, video klipleri, dosyaları, veri tabanları, katalogları ve listeleri çoğaltmayacağını, kopyalamayacağını, dağıtmayacağını, işlemeyeceğini, başka veri tabanına aktarmayacağını veya bu nitelikte sonuçlar doğurabilecek şekilde "Portal"a yüklemeyeceğini; bu tür eylemler gerçekleştirerek herhangi bir ticari faaliyette bulunmayacağını; gerek bu eylemleri ile gerekse de başka yollarla doğrudan ve/veya dolaylı olarak haksız rekabet teşkil eden davranış ve işlemler gerçekleştirmeyeceğini kabul ve taahhüt etmektedir. "Hesap Sahibi"nin işbu “Hesap Sözleşmesi” hükümlerine ve hukuka aykırı olarak gerçekleştirdikleri "Portal" üzerindeki faaliyetler nedeniyle üçüncü kişilerin uğradıkları veya uğrayabilecekleri zararlardan dolayı " EVHAYALİNİZ " doğrudan ve/veya dolaylı olarak hiçbir şekilde sorumlu tutulamaz.

                        5.1.7. “EVHAYALİNİZ”, “Hesap Sahibi”nin sadece ilgili hizmetlerin ve içeriklerini öğrenme amacıyla hizmetleri görüntülemesine ve “EVHAYALİNİZ Arayüzü”nü kullanmasına izin vermekte olup, bunun dışında bir amaçla veri tabanı üzerinden belirli bir sayıda veya bütününe yönelik olarak hizmetlere/içeriklere ulaşılmaya çalışılması, hizmetler/içeriklerin kısmen veya tamamen kopyalanması, bunların başka mecralarda doğrudan veya dolaylı olarak yayınlanması, derlenmesi, işlenmesi, başka veri tabanlarına aktarılması, bu veri tabanından üçüncü kişilerin erişimine ve kullanımına açılması, “EVHAYALİNİZ” üzerindeki ilanlara link verilmesi de dahil olmak üzere benzer fiillerin işlenmesine “EVHAYALİNİZ” tarafından izin verilmemekte ve rıza gösterilmemektedir. Bu tür fiiller hukuka aykırı olup; " EVHAYALİNİZ’in gerekli talep, dava ve takip hakları saklıdır.

                        5.1.8. “Hesap Sahibi”, üçüncü şahıslardan aldığı mal ve hizmetlerdeki ayıplarla ilgili “EVHAYALİNİZ”in herhangi bir sorumluluğu bulunmadığını, Tüketicinin Korunması Hakkındaki Kanun ve ilgili sair mevzuat kapsamındaki her türlü talep ve sorumluluğun muhatabının ilgili mal ve hizmetin satıcısına ait olduğunu ve bunlara ilişkin olarak her tür sorumluluk ve yükümlülükten “EVHAYALİNİZ”i ibra ettiğini kabul ve taahhüt etmektedir.

                        5.1.9. “Hesap Sahibi”, Hesap oluşturma aşamasında sunduğu bilgilerin değişmesi halinde; yeni ve güncel bilgileri “EVHAYALİNİZ”e gecikmeksizin bildirmekle yükümlüdür. Bildirmemesi halinde “EVHAYALİNİZ”in uğrayacağı tüm doğrudan ve dolaylı tüm zarar için “Hesap Sahibi”ne rücu etme hakkı saklıdır.

                        5.1.10. “Hesap Sahibi”nin “Portal” veya “EVHAYALİNİZ” sistemlerinin güvenliğini tehdit edebilecek ve/veya diğer kullanıcılara zarar verebilecek eylemlerde bulunması, “Portal”ın ve “Portal”a ait diğer yazılımların çalışmasını veya diğer kullanıcıların “Portal”dan faydalanmasını engelleyebilecek herhangi bir girişimde bulunması, bu sonuçları verecek şekilde sisteme veya “Portal”’a orantısız yük bindirmesi; “Portal”’ın kaynak kodlarına veya “EVHAYALİNİZ” sistemlerine yetkisiz bir şekilde erişmesi, bu bilgileri kopyalaması, silmesi, değiştirmesi ya da bu yönde denemeler yapması, “Portal”’ın çalışmasını engelleyecek yazılımlar kullanması, kullanmaya çalışması veya her türlü yazılım, donanım ve sunucuların çalışmasını aksatması, bozulmasına yol açması, tersine mühendislik yapması, saldırılar düzenlemesi, meşgul etmesi veya bunlara sair surette müdahale etmesi, “EVHAYALİNİZ” sunucularına erişim sağlamaya çalışılması kesinlikle yasaktır.

                        5.2. " EVHAYALİNİZ "in Hak ve Yükümlülükleri

                        5.2.1. " EVHAYALİNİZ ", işbu “Hesap Sözleşmesi”nde bahsi geçen hizmetler/içerlerle; ilgili hizmetlerin sunumuyla ilgili " EVHAYALİNİZ Hesabı" içerisinde belirtilen açıklamalar ve işbu “Kullanıcı Sözleşmesi”nde belirtilen koşullar dâhilinde yerine getirmeyi, işbu “Kullanıcı Sözleşmesi” kapsamında belirtilen hizmetlerin sunulabilmesi için gerekli olan teknolojik altyapıyı tesis etmeyi ve işletmeyi kabul, beyan ve taahhüt eder. İşbu madde içerisinde belirtilen teknolojik altyapı tesis etme yükümlülüğü, sınırsız ve eksiksiz bir hizmet taahhüdü anlamına gelmemektedir; “EVHAYALİNİZ” her zaman herhangi bir bildirimde bulunmadan işbu “Kullanıcı Sözleşmesi” ile belirlenen hizmetlerini ve teknolojik altyapısını durdurabilir veya son verebilir.

                        5.2.2. " EVHAYALİNİZ ", "Portal"da sunulan hizmetleri ve içerikleri her zaman değiştirebilme; "Hesap Sahibi”nin sisteme yüklediği bilgileri ve içerikleri "Portal" kullanıcıları da dâhil olmak üzere üçüncü kişilerin erişimine kapatabilme ve silme hakkını saklı tutmaktadır. " EVHAYALİNİZ ", bu hakkını hiçbir bildirimde bulunmadan ve önel vermeden kullanabilir. "Hesap Sahibi”, " EVHAYALİNİZ "in talep ettiği değişiklik ve/veya düzeltmeleri ivedi olarak yerine getirmek zorundadırlar. Değişiklik ve/veya düzeltmeleri gerekli görüldüğü takdirde " EVHAYALİNİZ " yapabilir. " EVHAYALİNİZ " tarafından talep edilen değişiklik ve/veya düzeltme taleplerinin, kullanıcılar tarafından zamanında yerine getirilmemesi sebebiyle doğan veya doğabilecek zararlar, hukuki ve cezai sorumluluklar tamamen kullanıcılara aittir.

                        5.2.3. "Portal" üzerinden, "Hizmet/İçerik üretici"ler, sağlayıcılar ve başkaca üçüncü kişilerin sahip olduğu ve işlettiği başka internet sitelerine ve/veya portallara, dosyalara veya içeriklere link verilebilir. Bu linkler "Hesap Sahibi” tarafından veya sadece referans kolaylığı açısından " EVHAYALİNİZ " tarafından sağlanmış olabilir. Ancak linkin yöneldiği internet sitesini veya işleten kişisini veya içerdiği bilgileri desteklemek veya herhangi bir açıdan doğrulama veya garanti etme amacı taşımamaktadır. "Portal" üzerindeki linkler vasıtasıyla erişilen portallar, internet siteleri, dosyalar ve içerikler, bu linkler vasıtasıyla erişilen portallar veya internet sitelerinden sunulan hizmetler veya ürünler veya bunların içeriği hakkında " EVHAYALİNİZ "in herhangi bir sorumluluğu yoktur.

                        5.2.4. " EVHAYALİNİZ ", "Portal"ın işleyişine, hukuka, mevzuata, başkalarının haklarına, “Kullanıcı Sözleşmesi” koşullarına, kişisel verilerin korunmasına, genel ahlak kurallarına aykırı olan mesajları, içerikleri istediği zaman ve şekilde erişimden kaldırabilir; " EVHAYALİNİZ " bu mesaj ve içeriği giren "Hesap Sahibi"nin hesabına herhangi bir bildirim yapmadan son verebilir. “EVHAYALİNİZ”, mevzuatta meydana gelen değişikliklere bağlı olarak “Hesap Sahibi”ne ek yükümlülükler getirebilir, söz konusu yükümlülükler “Portal”da yayımlandığı tarihte yürürlüğe girer.

                        5.2.5. "S EVHAYALİNİZ "in, " EVHAYALİNİZ " çalışanlarının ve yöneticilerinin, “Portal”da “Hesap Sahibi” ve “Kullanıcı”lar tarafından sağlanan içeriklerin hukuka uygun olup olmadığını, gerçekliğini, doğruluğunu araştırmak ve kontrol etmek yükümlülüğü bulunmamaktadır.

                        5.2.6. " EVHAYALİNİZ ", 5651 sayılı "İnternet Ortamında Yapılan Yayınların Düzenlenmesi ve Bu Yayınlar Yoluyla İşlenen Suçlarla Mücadele Edilmesi Hakkında Kanun" kapsamında "Yer Sağlayıcı" olarak faaliyet göstermektedir. EVHAYALİNİZ”i Sözleşme’nin ifası sonucunda kendisi tarafından belirli sonuçların üretileceğini garanti etmemektedir. “EVHAYALİNİZ”, fikri mülkiyet haklarının ihlali, ilan içeriklerinin doğruluğu dâhil ancak bunlarla sınırlı olmamak üzere; “Portal”ın kullanılması ile bağlantılı herhangi bir beyan ve taahhütte bulunmamaktadır. EVHAYALİNİZ ayrıca bakım, onarım çalışmaları, teknik aksaklıklar dahil ancak bunlarla sınırlı olmaksızın herhangi bir sebepten ötürü Sözleşme kapsamındaki hizmetlerin geç verilmesi, kesintiye uğraması veya hizmetin verilmesi ile ilgili “EVHAYALİNİZ” herhangi bir sorumluluk üstlenmemektedir.

                        5.2.7. ” EVHAYALİNİZ” Portal’ı ve “Hizmetler/İçerikler”i; “Olduğu Gibi” sağlamakta olup, “Portal” ve “Hizmetler”in hatasız, kusursuz, kesintisiz, mükemmel olduğu veya “Hesap Sahibi”nin kendine özel ihtiyaçlarını karşılayacağı şeklinde bir iddia veya taahhütte bulunmamaktadır. “EVHAYALİNİZ” “Portal” üzerinde her türlü değişiklik, güncelleme ve benzeri çalışmalar yapabilir ve “Hesap Sahibi” Portal’ı ve “Hizmetler/içerikler”i kullanmaya devam ettiği sürece, “Portal”i ve “Hizmetler/içerikler”i kullandığı haliyle (“Olduğu Gibi”) kabul etmiş sayılır. “EVHAYALİNİZ”:

                        (i) “Hesap Sahibi”’nin “Portal” ve “Hizmetler/İçeriklier”i kullanması, kullanmaması, yanlış kullanması veya “Hesap Sahibi”nin “Kullanıcı Sözleşmesi”nde belirtilen taahhüt ve yükümlülüklerini yerine getirmemesinden;

                        (ii) tüm donanım, sistem yazılımı/diğer yazılımlar ve ağ ilişkili işlevden ve bu nedenle ortaya çıkacak arızalardan;

                        (iii) iletişim ağı (network), internet bağlantısı, bağlantı hatalarından;

                        (iv) “Portal” üzerinde gerçekleştirilecek her türlü değişiklik, güncelleme ve benzeri çalışmalar sonucunda oluşabilecek hata ve arızalardan;

                        (v) voltaj dalgalanmalarından, batarya ve elektrik kesilmelerinden, virüs bulaşmasından ve benzeri faktörlerden;

                        (vi) işletim sistemi uyumsuzluklarından;

                        (vii) yukarıda sayılanlarla sınırlı olmaksızın “Hesap Sahibi”nin “Portal”ı kullanmasını engelleyen uyumsuzlukların veya hataların ortaya çıkmasından

                        kaynaklanan doğrudan veya dolaylı zararlardan, her türlü kar kaybı, veri kaybı, iş kaybı, itibar kaybı, beklenen tasarrufun kaybı, işin kesintiye uğraması gibi her türlü maddi, manevi ve mali zararlardan, bu kapsamda “Hesap Sahibi” veya üçüncü bir tarafça yapılabilecek tazminat taleplerinden sorumlu değildir.

                        5.2.8 “Hesap Sahibi”nin başvurusu sırasında verilen bilgilerin yeterli, doğru veya güncel olmadığının yahut yanıltıcı ve kötü maksatlı olduğunun tespit edilmesi, hesap başvurusunda bulunan kişinin başvurusunun önceden reddedilmiş olması, hesabının devam ettiği süreçte “Hesap Sahibi” hakkında şikâyetler veya olumsuz yorumlar alınması ve benzeri sebeplerle; “EVHAYALİNİZ” herhangi bir bildirimde bulunmadan, herhangi bir tazminat yükümlülüğü altında bulunmaksızın işbu sözleşmeyi feshederek “Hesap Sahibi”nin hesabını kapatabilir. Hesabı kapatmadan önce “EVHAYALİNİZ” yetkilileri tarafından gerekli incelemelerin yapılabilmesi için “EVHAYALİNİZ” uygun gördüğü tedbirleri uygulayabilir. Hesabın kapatılması, geçici olarak durdurulması yahut Sözleşme’nin herhangi bir sebeple feshedilmesinin ardından “EVHAYALİNİZ”, kendi takdirine bağlı olarak, “Hesap Sahibi”nin Portal üzerinden paylaşmış olduğu içerikler veya diğer paylaşımların akıbeti konusunda münhasıran karar verme yetkisine sahiptir.

                        6. Gizlilik Politikası

                        6.1 “EVHAYALİNİZ”, "Portal"da "Hesap Sahibi” ile ilgili bilgileri; işbu “Kullanıcı Sözleşmesi” ve işbu “Hesap Sözleşmesi”nin eklerinin biri ve ayrılmaz parçası olan EK-2’deki Gizlilik Politikası kapsamında kullanabilir. EVHAYALİNİZ, "Hesap Sahibi”ne ait gizli bilgileri ancak Gizlilik Politikası’nda belirtilen koşullar dâhilinde üçüncü kişilere açıklayabilir veya kullanabilir. “Hesap Sahibi”, ilanla ilgili olarak Satıcı ile Alıcı arasında mesajlaşmanın yapılabilmesi için Alıcı sıfatıyla hareket ettiği durumlarda hesap girişi yapmayı ve Alıcı sıfatıyla kendisinin telefon numarasının Satıcı ile paylaşılmasını beyan, kabul ve taahhüt etmektedir.

                        6.2. “EVHAYALİNİZ”, “Hesap Sözleşmesi” ile belirlenen amaç ve kapsam dışında da “Hesap Sahibi” olma aşamasında talep edilen ad-soyad, telefon numarası, e-posta adresi gibi bilgileri; yürürlükte bulunan mevzuatta öngörülen koşullara tabi şekilde ve gerektiğinde ek onayları ve açık rızaları almak suretiyle sms, e-posta, site içi bilgilendirmeler ve benzeri yöntemlerle, tanıtım ve bilgilendirme amaçlı iletişim faaliyetleri, araştırma, pazarlama faaliyetleri ve istatistikî analizler yapmak amacıyla veya gerektiğinde “Hesap Sahibi” ile temas kurmak için kullanabilir. Yine yürürlükte bulunan mevzuatta öngörülen koşullara tabi şekilde ve gerektiğinde ek onayları ve açık rızaları almak suretiyle kişisel veriler aynı zamanda {{str_replace(['http://', 'https://'], '', env('APP_URL'))}}’un süreçlerini iyileştirme amaçlı araştırmalar yapmak, veri tabanı oluşturmak ve pazar araştırmaları yapmak için “EVHAYALİNİZ”in işbirliği içinde olduğu firmalara aktarılabilir, bu firmalar tarafından işlenebilir ve kullanılabilir.

                        6.3."Hesap Sahibi”nin kişisel veri teşkil edebilecek ve kendisi tarafından Portal’a girilen verileri “EVHAYALİNİZ” tarafından “Kullanıcı Sözleşmesi” kapsamında; “Portal”ın fonksiyonlarının kullandırılması, hizmetlerin ve içeriklerin sağlanması ve yukarıda sayılan amaçlarla toplanmakta ve işlenmektedir. Kişisel Verilerin Korunması Hakkında detaylı bilgi için https://www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/kvkk sayfası ziyaret edilmelidir. “EVHAYALİNİZ” Kişisel Verilerin Korunması Politikası’nda ve sair kişisel veriler ile ilgili politika, prosedür, sözleşme maddeleri ve kullanım koşullarında istediği zaman değişiklik yapabilir. Değişiklikler “Portal”da yayınlandığı anda yürürlüğe girer. “Hesap Sahibi” bu değişiklikleri takip etmekle yükümlü olup, bu değişikliklerle ilgili “EVHAYALİNİZ”den herhangi bir talepte veya zarar ziyan iddiasında bulunamaz.

                        6.4. ”Hesap Sahibi”, “Portal” dahilinde eriştiği bilgileri; bu bilgileri ifşa eden “Hesap Sahibi”nin veya " EVHAYALİNİZ "in ifşa ettiği amaçlara uygun olarak kullanmakla yükümlü olup, elde ettiği Kullanıcılara veya üçüncü kişilere ait Kişisel Verilerin korunmasından, işlenmesinden, aktarılmasından ve KVKK kapsamındaki tüm yükümlülüklerden kendisinin sorumlu olduğunu, EVHAYALİNİZ’in kendi sistemlerinde internet sitesinin kullanımı için zorunlu olarak topladığı kişisel veriler dışındaki hiçbir kişisel veri için KVKK kapsamında herhangi bir yükümlülüğünün ve sorumluluğunun olmadığını kabul, beyan ve taahhüt eder. “Hesap Sahibi”; kişisel verilerin korunması yükümlülüğüne aykırı hareket etmesi veya kişisel verileri işlemesi, aktarması veya sair surette bir işleme konu etmesi ve bu kullanımın bir ihlal meydana getirmesi durumunda, Kişisel Verileri Koruma Kurulu’nun veya idari makamların veya mahkemelerin kişisel verilerle ilgili olarak verdikleri kararlar neticesinde EVHAYALİNİZ’in bir zarara uğraması durumunda bu zararı ilk talepte nakden ve defaten tazmin edeceğini kabul, beyan ve taahhüt eder.

                        6.5. “Hesap Sahibi”, bir Avrupa Birliği mukimi gerçek kişi olması durumunda kendi kişisel verileri ile ilgili olarak 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun ve ikincil düzenlemeleri ile Kişisel Verileri Koruma Kurulu kararlarının ve düzenlemelerinin uygulanacağını, çıkabilecek tüm hukuki sorunlarda kanunlar ihtilafı kurallarına bakılmadan Türk iç hukukunun uygulanacağını, 95/46/EC sayılı Avrupa Birliği Direktifi’nin ve Mayıs 2018 tarihinde Avrupa Birliği’nde yürürlüğe giren Genel Veri Koruma Regülasyonu’nun (GDPR) uygulanmayacağını, Türk Milletlerarası Özel Hukuk ve Usul Hukuku Hakkında Kanun’un kanunlar ihtilafı kaidelerinin uygulanmasını talep etmekten feragat ettiğini kabul, beyan ve taahhüt eder.

                        6.6. “Hesap Sahibi”, “EVHAYALİNİZ” hesabı ve/veya yayınladığı ilanlar nedeniyle alenileşmiş olan kişisel verilerinin Google veya diğer arama motorları veya benzer verileri indeksleyen sistemler tarafından kaydedilmesi, işlenmesi, arama sonuçlarında çıkarılması gibi durumlar için “EVHAYALİNİZ”in herhangi bir dahlinin, katkısının olmadığını ve kişisel verilerinin indesklenmek veya sair yöntemlerle aramaya mahsus yapılandırılmış sistemlerde herhangi bir şekil ve surette işlenmesi veya aktarılmasından dolayı “EVHAYALİNİZ”in herhangi bir sorumluluğunun olmadığını, veri sahibi olarak yapacağı başvuru taleplerini başta indekslemeyle ilgili süreçlerde veri sorumlusu sıfatını haiz olan Google olmak üzere diğer arama motorları veya arama sistemleri, indeskleme sistemleri işleten veri sorumlusu gerçek ve/veya tüzel kişilere yöneltmeyi kabul, beyan ve taahhüt eder.

                        6.7. “Hesap Sahibi” ilan verirken veya “EVHAYALİNİZ” Portal’ı kullandığı esnada özel nitelikli kişisel verilerini ifşa etmeyeceğini, ifşa etmesi durumunda ise bu verilerin işlenmesiyle ilgili olarak “EVHAYALİNİZ”’in herhangi bir sorumluluğunun bulunmadığını bildiğini kabul, beyan ve taahhüt eder.

                        7. Fikri Mülkiyet Hakları

                        “Portal” dahilinde erişilen veya hukuka uygun olarak kullanıcılar tarafından sağlanan bilgiler ve bu “Portal”ın (sınırlı olmamak kaydıyla " EVHAYALİNİZ Veri Tabanı", " EVHAYALİNİZ Arayüzü", tasarım, metin, imge, html kodu ve diğer kodlar) tüm elemanları (hepsi birlikte " EVHAYALİNİZ "in telif haklarına tabi çalışmaları” olarak anılacaktır) " EVHAYALİNİZ "e aittir ve/veya " EVHAYALİNİZ " tarafından üçüncü bir kişiden lisans altında alınmıştır "Hesap Sahibi”, " EVHAYALİNİZ " hizmetlerini, " EVHAYALİNİZ " bilgilerini ve " EVHAYALİNİZ "in fikri haklarına ve telif haklarına tabi çalışmalarını satmak, işlemek, paylaşmak, dağıtmak, sergilemek veya başkasının " EVHAYALİNİZ "in hizmetlerine erişmesi veya kullanmasına izin vermek hakkına sahip değildirler. İşbu "Portal Kullanım Koşulları" dâhilinde " EVHAYALİNİZ " tarafından açıkça izin verilen durumlar haricinde " EVHAYALİNİZ "in telif haklarına tabi çalışmalarını çoğaltamaz, işleyemez, dağıtamaz veya bunlardan türemiş çalışmalar yapamaz. İşbu “Kullanıcı Sözleşmesi”nin akdi ile “EVHAYALİNİZ”, “Portal”ın “Kullanıcı Sözleşmesi” koşulları çerçevesinde ve “Hizmetler/İçerikler”den faydalanılması amacıyla sınırlı olarak kullanılmasına ilişkin “Hesap Sahibi”ne münhasır olmayan ve devredilemez bir kullanım hakkı (basit ruhsat) tesis etmektedir.

                        8. “Kullanıcı Sözleşmesi” Değişiklikleri

                        " EVHAYALİNİZ ", tamamen kendi takdirine bağlı ve tek taraflı olarak işbu “Kullanıcı Sözleşmesi”ni uygun göreceği herhangi bir zamanda "Portal"da yayınlayarak değiştirebilir. İşbu “Kullanıcı Sözleşmesi”nin değişen hükümleri, “Portal”da yayınlandığı tarihte geçerlilik kazanarak yürürlüğe girecek, geri kalan hükümler aynen yürürlükte kalarak hüküm ve sonuçlarını doğurmaya devam edecektir. İşbu “Kullanıcı Sözleşmesi”, "Hesap Sahibi"nin tek taraflı beyanları ile değiştirilemez.

                        9. Mücbir Sebepler

                        Hukuken mücbir sebep sayılan tüm durumlarda, " EVHAYALİNİZ " işbu “Kullanıcı Sözleşmesi” ile belirlenen edimlerinden herhangi birini geç veya eksik ifa etme veya ifa etmeme nedeniyle yükümlü değildir. Bu ve bunun gibi durumlar, " EVHAYALİNİZ " için, gecikme, eksik ifa etme veya ifa etmeme veya temerrüt addedilmeyecek veya bu durumlar için " EVHAYALİNİZ "den herhangi bir ad altında tazminat talep edilemeyecektir. Mücbir sebep terimi; doğal afet, isyan, savaş, grev, iletişim sorunları, altyapı ve internet arızaları, sisteme ilişkin iyileştirme veya yenileştirme çalışmaları ve bu sebeple meydana gelebilecek arızalar, elektrik kesintisi ve kötü hava koşulları da dâhil ve fakat bunlarla sınırlı olmamak kaydıyla ilgili tarafın makul kontrolü haricinde ve " EVHAYALİNİZ "in gerekli özeni göstermesine rağmen önleyemediği kaçınılamayacak olaylar olarak yorumlanacaktır.

                        10. Uygulanacak Hukuk ve Yetki

                        İşbu “Kullanıcı Sözleşmesi”nin uygulanmasında, yorumlanmasında ve işbu “Kullanıcı Sözleşmesi” dâhilinde doğan hukuki ilişkilerin yönetiminde yabancılık unsuru bulunması durumunda Türk kanunlar ihtilafı kuralları hariç olmak üzere doğrudan Türk İç Hukuku uygulanacaktır. İşbu “Kullanıcı Sözleşmesi”nden dolayı doğan veya doğabilecek her türlü ihtilafın hallinde İstanbul Merkez (Çağlayan) Mahkemeleri ve İcra Daireleri yetkilidir.

                        11. Yürürlük

                        İşbu “Kullanıcı Sözleşmesi” ve “Kullanıcı Sözleşmesi”yle atıfta bulunulan ve “Kullanıcı Sözleşmesi”nin ayrılmaz bir parçası olan ekler ile “Portal”da yer alan kurallar ve şartlar, "Hesap Sahibi"nin elektronik olarak onay vermesi ile elektronik ortamda akdedilerek yürürlüğe girmiştir. “Kullanıcı Sözleşmesi”nin herhangi bir hükmünün geçersizliği, mevzuata aykırılığı veya uygulanabilir olmaması sözleşmenin geri kalan hükümlerinin yürürlüğünü etkilemeyecektir.

                        12. “Kullanıcı Sözleşmesi”nin Ekleri

                        12.1 “Hesap Sahibi”, “Ek-1 Kullanım Koşulları, Ek-2 Gizlilik Politikası, Ek-3 EVHAYALİNİZ Hizmetleri , Ek-4 Hizmet/İçerik Verilmesi, Satışa Arzı, Listelenmesi Yasaklı Ürün ve Hizmetler, Ek-5 Kullanıcı Profilinde Değişiklik ile “Portal”da yayınlanan şartlar ve kuralların, işbu “Kullanıcı Sözleşmesi”nin eki ve ayrılmaz olduğunu, içeriklerini okuyup anladığını, “Hesap Sahibi” olarak “Kullanıcı Sözleşmesi” ile eklerine” ve “Portal”da yayınlanan şartlarla kurallara uygun davranacağını kayıtsız ve şartsız olarak kabul ettiğini beyan ve taahhüt etmektedir.

                        EKLER:

                        Ek-1 Kullanım Koşulları
                        Ek-2 Gizlilik Politikası
                        Ek-3 EVHAYALİNİZ Hizmetleri
                        Ek-4 Hizmet/İçerik Verme Kuralları ve İlan Verilmesi Yasaklı Ürünler
                        Ek-5 Kullanıcı Profilinde Değişiklik



                        * 08/02/2022 tarihi itibariyle “Üye” kavramı “Hesap Sahibi”, “Üyelik” kavramı ise “Hesap” olarak anılacaktır.



                        Ek-1 Kullanım Koşulları

                        1. KULLANIM KOŞULLARI
                        www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} alan adlı internet sitesini kullanmak için lütfen aşağıda yazılı koşulları okuyunuz. www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} internet sitesini ziyaret ederek ve/veya mobil uygulamalarını kullanarak (internet sitesi ve/veya mobil uygulamalar bundan böyle “Portal” olarak anılacaktır) ve/veya “Hesap Sahibi” olarak, işbu “Kullanım Koşulları”nı okuduğunuzu, içeriğini tamamen anladığınızı, “Kullanım Koşulları”nda belirtilen ve “Portal”da bulunan ve zaman içinde yer alacak tüm hususları kayıtsız ve şartsız olarak kabul ettiğinizi, “Portal”da belirtilen tüm hususlarla ilgili olarak herhangi bir itiraz ve defi ileri sürmeyeceğinizi kabul, beyan ve taahhüt ediyorsunuz. Bu koşulları kabul etmediğiniz takdirde, lütfen "Portal"ı kullanmaktan vazgeçiniz.

                        1.1. İşbu “Portal”ın sahibi “İstiklal, Özkılıç Sokak no 2A, 68400 Ortaköy/Aksaray” adresinde mukim Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi (bundan böyle kısaca "EVHAYALİNİZ" olarak anılacaktır)’dir. “Portal”da sunulan ve işbu “Kullanım Koşulları”nın 3. maddesinde belirtilen hizmetler, “EVHAYALİNİZ” tarafından sağlanmaktadır.

                        1.2. " EVHAYALİNİZ " işbu “Kullanım Koşulları”nı, “Portal”da yer alan her tür bilgi ve “Hizmet/İçerik”i, "KULLANICI"ya herhangi bir ihbarda veya bildirimde bulunmadan dilediği zaman değiştirebilir. Bu değişiklikler periyodik olarak “www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}”da yayımlanacak ve yayımlandığı tarihte geçerli olacaktır. “Portal” hizmetlerinden belirli bir bedel ödeyerek ya da bedelsiz olarak yararlanan veya herhangi bir şekilde “Portal”a erişim sağlayan her gerçek veya tüzel kişi “Kullanım Koşulları”nı ve " EVHAYALİNİZ " tarafından işbu “Kullanım Koşulları”nda yapılan her değişikliği kabul etmiş sayılmaktadır. İşbu " Kullanım Koşulları" www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} internet sitesi üzerinden yayınlanarak; “Portal”ı kullanan her gerçek veya tüzel kişi tarafından erişimi mümkün kılınmıştır.

                        2. TANIMLAR

                        “Portal”: www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} isimli alan adından ve bu alan adına bağlı alt alan adlarından oluşan “EVHAYALİNİZ”in “Hizmet/İçerik”lerini sunduğu internet sitesi ve/veya mobil uygulamalar.

                        “Kullanıcı”: “Portal”a erişen her gerçek veya tüzel kişi.

                        “Hesap Sahibi”: “Portal”da hesabı olan ve "Portal" dahilinde sunulan hizmetlerden işbu sözleşmede belirtilen koşullar dahilinde yararlanan “Kullanıcı”.

                        “EVHAYALİNİZ Hizmetleri” ("Hizmet"): "Portal" içerisinde " Hesap Sahibi"nin işbu sözleşme içerisinde tanımlı olan iş ve işlemlerini gerçekleştirmelerini sağlamak amacıyla “EVHAYALİNİZ” tarafından sunulan uygulamalardır. " EVHAYALİNİZ ", "Portal" içerisinde sunulan "Hizmet/İçerik"lerinde dilediği zaman değişiklikler ve/veya uyarlamalar yapabilir. Yapılan değişiklikler ve/veya uyarlamalarla ilgili " Hesap Sahibi "nin uymakla yükümlü olduğu kural ve koşullar “Portal”dan " Hesap Sahibi "ne duyurulur, açıklanan şartlar ve koşullar “Portal”da yayımlandığı tarihte yürürlüğe girer.

                        “İçerik”: “Portal”da yayınlanan ve erişimi mümkün olan her türlü bilgi, yazı, dosya, resim, video, rakam vb. görsel, yazımsal ve işitsel imgeler.

                        " EVHAYALİNİZ Arayüzü" : EVHAYALİNİZ ve "Hesap Sahibi” tarafından oluşturulan içeriğin "Kullanıcı”lar tarafından görüntülenebilmesi ve "EVHAYALİNİZ Veritabanı"ından sorgulanabilmesi amacıyla "Kullanıcı”lar tarafından kullanılan; 5846 Sayılı Fikir ve Sanat Eserleri Kanunu kapsamında korunan ve tüm fikri hakları “EVHAYALİNİZ”e ait olan tasarımlar içerisinde “Portal” üzerinden yapılabilecek her türlü işlemin gerçekleştirilmesi için bilgisayar programına komut veren internet sayfaları.

                        “EVHAYALİNİZ Veri Tabanı” : “Portal” dahilinde erişilen içeriklerin depolandığı, tasnif edildiği, sorgulanabildiği ve erişilebildiği “EVHAYALİNİZ”e ait olan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu gereğince korunan veri tabanıdır

                    </p>
                    <p>

                        3. EVHAYALİNİZ HİZMETLERİ

                        3.1. " EVHAYALİNİZ ", " “Hesap Sahibi” tarafından " EVHAYALİNİZ Veri Tabanı"na yüklenen içeriklerin, arayüzler kullanılmak suretiyle " EVHAYALİNİZ Veri Tabanı" üzerinden "Kullanıcı”lar tarafından görüntülenebilmesini temin etmektedir.

                        3.2. " EVHAYALİNİZ ", “Portal” içerisinde "Kullanıcı”ların, " Hesap Sahibi " hizmet/içeriklerine daha kolay ulaşabilmelerini sağlamak üzere hizmet/içeriklerin görüntülenmesini önceliklendiren çeşitli tiplerde listeleme hizmetleri vermektedir.

                        3.3. " EVHAYALİNİZ ", “Portal” dahilinde gerçekleştirilen işlemlere, görüntüleme sayılarına yönelik çeşitli kategoriler altında raporlama hizmetlerini sunmaktadır.

                        3.4. " EVHAYALİNİZ ", “Portal” dahilinde verdiği hizmetlere yenilerini ekleme, mevcut hizmetlerin kapsam ve sunulma koşulları ile “Portal” dahilinde erişilen "İçerik"leri her zaman değiştirme, üçüncü kişilerin erişimine kapatabilme ve silme hakkını saklı tutmaktadır. " EVHAYALİNİZ ", bu hakkını hiçbir bildirimde bulunmadan ve önel vermeden dilediği biçimde kullanabilir.

                        4. EVHAYALİNİZ PORTALI KULLANIMINA İLİŞKİN KOŞULLAR VE YÜKÜMLÜLÜKLER

                        4.1. "Kullanıcı”lar hukuka uygun amaçlarla “Portal” üzerinde işlem yapabilirler. "Kullanıcı”ların “Portal” dahilinde yaptığı her işlem ve eylemdeki hukuki ve cezai sorumluluk kendilerine ait olacak olup, söz konusu hukuki ve cezai yükümlülüklerle ilgili “EVHAYALİNİZ”in herhangi bir sorumluluğu bulunmadığını “Kullanıcı” kabul, beyan ve taahhüt etmektedir.

                        4.2. “Portal”, "Hesap Sahibi” tarafından " EVHAYALİNİZ Veri Tabanı"na yüklenen "İçerik"lerin görüntülenmesi esasıyla çalışmaktadır. " EVHAYALİNİZ ", "Kullanıcı"lar tarafından görüntülenen hizmet ve "İçerik"lerin hiçbir koşulda doğruluğunu, gerçekliği, güvenliğini ve hukuka uygunluğunu garanti etmemektedir. Söz konusu ilan ve "İçerik"ler dolayısıyla “EVHAYALİNİZ”in herhangi bir sorumluluğu bulunmadığını, ortaya çıkabilecek zararlardan ötürü “EVHAYALİNİZ”in hiçbir tazmin yükümlülüğü olmayacağını “Kullanıcı”lar kabul ve beyan etmektedir.

                        4.3. "KULLANICI" “PORTAL” dahilinde bulunan her türlü resimleri, metinleri, görsel ve işitsel imgeleri, video klipleri, dosyaları, veri tabanları, katalogları ve listeleri çoğaltmayacağı, kopyalamayacağı, dağıtmayacağı, işlemeyeceğini, bu tür eylemler yoluyla doğrudan ve/veya dolaylı olarak haksız rekabet teşkil eden davranış ve işlemler gerçekleştirmeyeceğini kabul ve taahhüt etmektedir.

                        İşbu Kullanım Koşullarının hiçbir hükmü, Kullanıcı’nın EVHAYALİNİZ harici mecralarda hizmet/içerik yayınlamasını, EVHAYALİNİZ’e girmiş olduğu ilanları bu mecralarda da yayınlamasını engellemez.

                        Kullanıcı, Portal üzerinden, Portal’a kendi yüklemiş olduğu resim, metin, görsel, işitsel, imge, video klip ve dosyalara saklandığı hali ile Sahibinden tarafından sağlanan teknik imkanlar dairesinde erişebilir ve bu verileri Sahibinden tarafından sağlanan veri indirme veya API yöntemi çerçevesinde taşıyabilir.

                        Ancak, Kullanıcı EVHAYALİNİZ’e girmiş veya yüklemiş olduğu resim, metin, görsel, işitsel, imge, video klip ve dosyalar üzerinde EVHAYALİNİZ’in teknik veya görsel iyileştirmeler yaptığı halleri üzerinde hak sahibi değildir. Bu iyileştirmelerin gerçekleştirildiği resim, metin, görsel, işitsel, imge, video klip ve dosyaların iyileştirilmiş versiyonlarını çoğaltamaz, kopyalayamaz, dağıtamaz veya işleyemez.

                        4.4. "Kullanıcı"lar “Portal” dâhilinde Türk Ticaret Kanunu hükümleri uyarınca haksız rekabete yol açacak faaliyetlerde bulunmayacağını, " EVHAYALİNİZ "in ve üçüncü kişilerin şahsi ve ticari itibarı sarsacak, kişilik haklarına tecavüz veya taarruz edecek fiilleri gerçekleştirmeyeceğini, mevzuata, kamu düzenine ve genel ahlak kurallarına uygun hareket edeceğini, mevzuatın gerektirdiği önlemleri alacağını ve prosedürleri yerine getireceğini, yasadışı, suç teşkil edecek, rahatsız edici, kişilik haklarına zarar verici, fikri haklara, telif haklarına, marka haklarına ve mülkiyet haklarına tecavüz edici tutum ve davranışlarda bulunmayacağını, Türkiye İnsan Hakları ve Eşitlik Kurumu Kanunu’nun eşitlik ilkesi ve ayrımcılık yasağına ilişkin düzenlemeleri uyarınca cinsiyet, ırk, renk, dil, din, inanç, mezhep, felsefi ve siyasi görüş, etnik köken, servet, doğum, medeni hâl, sağlık durumu, engellilik ve yaş temellerine dayalı ayrımcılık oluşturacak içerikte ilan vermeyeceğini, buna yönelik tutum ve davranışlarda bulunmayacağını kabul ve taahhüt etmektedir.

                        4.5. "Kullanıcı"lar, “Portal” dahilinde eriştikleri bilgileri yalnızca bu bilgileri ifşa eden "Hesap Sahibi" veya " EVHAYALİNİZ "in amacına uygun olarak kullanmakla, ticari olmayan amaçla görüntülemekle yükümlüdür. Hizmet/İçerik veren Hesap sahibi tarafından girilmiş bulunan ilanlardaki iletişim bilgileri ilan hakkında bilgi almak için iletişim kurulması amacıyla kullanılabilir. İlanda yer alabilecek 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun kapsamında koruma altında olan ilan verene ait veya üçüncü kişilere ait kişisel veriler ve/veya özel nitelikli kişisel veriler, başkaca bir amaçla kullanılamaz, kopyalanamaz, başka mecralarda doğrudan veya dolaylı olarak yayınlanamaz, işlenemez, dağıtılamaz, başkaca veri tabanlarına aktarılarak üçüncü kişilerin erişimine ve kullanımına açılamaz.

                        4.6. " EVHAYALİNİZ ", 5651 Sayılı Yasa uyarınca "Yer Sağlayıcılığı Faaliyet Belgesi"ne sahiptir. 5651 Sayılı Yasa ve ilgili mevzuat uyarınca "Yer Sağlayıcı"lara getirilen yükümlülüklere uymak amacıyla "Kullanıcı"ların “Portal” üzerinde gerçekleştirdikleri işlemlere ilişkin ilgili mevzuatta belirtilen nitelikteki kayıtları yasal süresi içinde kayıt altına almakta ve saklamaktadır.

                        4.7. " EVHAYALİNİZ ", "Kullanıcı" bilgilerini kullanabilir, işleyebilir, paylaşabilir, ifşa edebilir, bir veri tabanı üzerinde tasnif edip muhafaza edebilir, tanıtım ve bilgilendirme amaçlı iletişim faaliyetlerinde, pazarlama faaliyetlerinde ve istatistikî analizler yapmak amacıyla kullanabilir. " EVHAYALİNİZ " aynı zamanda; kullanıcının IP adresi, “Portal”ın hangi bölümlerini ziyaret ettiği, domain tipi, tarayıcı (browser) tipi, tarih ve saat gibi bilgileri de istatistiki değerlendirme ve kişiye yönelik hizmetler ve teklifler sunma gibi amaçlarla kullanabilir. ” EVHAYALİNİZ” süreçlerini iyileştirme amaçlı araştırmalar yapmak, veri tabanı oluşturmak ve pazar araştırmaları yapmak için işbirliği içinde olduğu firmalara Kullanıcı bilgilerini aktarabilir ve bu firmalar tarafından yukarıda sayılan amaçlarla sınırlı olarak Kullanıcı bilgileri işlenebilir.

                        4.8. Kullanıcı Sözleşmesi’nin 6.1. maddesinde belirtilen taahhütleri saklı kalmak kaydıyla, EVHAYALİNİZ, çevrimiçi davranışsal reklamcılık ve pazarlama yapılabilmesi amacıyla siteye gelen kullanıcının sitedeki davranışlarını tarayıcıda bulunan bir cookie (çerez) ile ilişkilendirme ve görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı gibi metrikleri temel alan yeniden pazarlama listeleri tanımlama, pazarlama otomasyon araçlarını kullanma ve kullanıcıya özel mesaj/teklif ve öneriler iletme hakkını haizdir. Daha sonra bu kullanıcıya sitede ya da Görüntülü Reklam Ağındaki diğer sitelerde, kullanıcıların ilgi alanlarına göre hedefe yönelik reklam içeriği gösterebilir. Ayrıca Google, AFS reklamlarının EVHAYALİNİZ’e yönlendirilmesi esnasında Google KULLANICILARIN tarayıcısına çerez yerleştirebilir veya bunlarda yer alan çerezleri okuyabilir veya bilgi toplamak amacı ile web işaretleri kullanabilir.

                        4.9. İşbu EK-1’in 4.3. maddesi saklı kalmak kaydıyla, “Portal” üzerinden erişilen ve/veya görüntülenen içeriğin depolandığı veri tabanına yalnızca ilgili içeriklerin görüntülenmesi amacıyla ve/veya " EVHAYALİNİZ "in “Kullanım Koşulları” çerçevesinde üçüncü kişilerce erişilmesi hukuka uygundur. Bunun dışındaki yapılan erişimler hukuka aykırı olup; " EVHAYALİNİZ’in her tür talep, dava ve takip hakları saklıdır.

                        4.10. İşbu EK-1’in (verilere erişim ve veri taşıma hususlarını da düzenleyen) 4.3. maddesi hükümleri saklı kalmak kaydıyla “EVHAYALİNİZ”, “ilanların içeriklerini öğrenme amacıyla görüntülemeye ve “EVHAYALİNİZ Arayüzü”nü kullanmaya izin vermekte olup, bunun dışında bir amaçla veri tabanı üzerinden belirli bir sayıda veya bütününe yönelik olarak ilanlara ulaşılmaya çalışılması, ilanların, müşteri bilgilerinin, tasarımlarının, kod ve yazılımlarının, veri tabanında yer alan bilgilerinin kısmen veya tamamen kopyalanması, bunların başka mecralarda doğrudan veya dolaylı olarak yayınlanması, derlenmesi, işlenmesi, değiştirilmesi, başka veri tabanlarına aktarılması, bu veri tabanından üçüncü kişilerin erişimine ve kullanımına açılması, “EVHAYALİNİZ” üzerindeki ilanlara link verilmesi de dâhil olmak üzere benzer fiillerin işlenmesine “EVHAYALİNİZ” tarafından izin verilmemekte ve rıza gösterilmemektedir. Bu tür fiiller hukuka aykırı olup; " EVHAYALİNİZ’in talep, dava ve takip hakları saklıdır.

                        4.11. İşbu EK-1’in (verilere erişim ve veri taşıma hususlarını da düzenleyen) 4.3. maddesi hükümleri saklı kalmak kaydıyla "Portal"ın bütününün veya herhangi bir bölümünün bozma, değiştirme, tersine mühendislik yapma amacıyla kullanılması, tersine mühendislik (reverse engineering) metoduyla veya farklı herhangi bir metodla API protokollerinin kırılmaya çalışılması ve API anahtarı, API gizli anahtarı, istek başlıkları, istemci doğrulama algoritması gibi parametrelere izinsiz olarak ulaşılması veya bu parametrelerin izinsiz olarak üçüncü kişilerle paylaşılması, "Portal"ın iletişim veya teknik sistemleri engelleyen, bozan ya da sistemlere müdahale eder bir şekilde "Site"ye erişim sağlanmaya çalışılması, Site üzerinde otomatik program, robot, örümcek, web crawler, örümcek, veri madenciliği (data mining) veri taraması (data crawling) vb. "screen scraping" yazılımları veya sistemleri, otomatik aletler ya da manuel süreçler kullanılması, diğer kullanıcılarının verilerine veya yazılımlarına izinsiz olarak ulaşılması, çeşitli kriterlere göre yapılacak tespitler neticesinde bot çalıştırma, DDOS atakları ve sair her türlü sistemlerin bütününü veya bir kısmını bozmaya, değiştirmeye, mevcut performansını azaltmaya veya yok etmeye ve sair her türlü sisteme yönelik saldırıların ve sair hukuka aykırı kullanımların yapılması durumunda bu tür kullanımlar EVHAYALİNİZ’in takdirine bağlı olarak engellenecektir. Bu tür kullanımlar olmasa dahi EVHAYALİNİZ, gerekli gördüğü hallerde ancak “Hesap Sahibi”nin kullanıcı adı ve parolası ile giriş yapmasından sonra Portal’in kullanımına izin verilebilir. "Site"nin ve "Portal"deki içeriğin “Kullanım Koşulları” ile belirlenen kullanım sınırları dışında kullanılması hukuka aykırı olup; " EVHAYALİNİZ "in her tür talep, dava ve takip hakları saklıdır. İşbu şartlara ve yasalara aykırı kullanımın tespiti halinde; “EVHAYALİNİZ”, “Kullanıcıyı yetkili makamlara bildirme hakkına sahiptir. “Kullanıcı” bu tür kullanımlar sonucu oluşan zarar ve taleplerden “bizzat sorumlu olduğunu kabul etmektedir.

                        4.12. “Portal”da verilen hizmetin kesintiye uğraması, bilgi iletiminde aksaklıklar, gecikmeler, başarısızlar yaşanması, veri kaybı halinde oluşabilecek her türlü doğrudan ve dolaylı zararlardan “EVHAYALİNİZ”in sorumlu tutulamayacağını “Kullanıcı” kabul ve taahhüt etmektedir.

                        4.13. Güven Damgası, sadece ilgili Tebliğ uyarınca GDS tarafından incelemesi, takibi ve kontrolü sağlanan mevzuata uygunluk kriterlerinin varlığına delalet eder. Bunun haricinde Güven Damgası Sağlayıcısı, hiçbir suretle taraflar arasındaki sözleşmenin garantörü ya da taahhüt edeni olarak anlaşılamayacağı gibi, E-ticaret sitesinde bulunan mal ya da hizmetlerin ayıptan ari vasıflarının ve eksiksiz temin ve tesliminin kefili de değildir. Ayrıca Güven Damgası Sağlayıcısı malın teslim edilmemesi, geç teslim edilmesi ya da taahhüt edilen niteliklere uygun olarak teslim edilmemesi hallerinden hukuken hiçbir surette sorumlu tutulamaz.

                        4.14. TOGG aracınızdan kullandığınız {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} uygulamamız iOS / Android uygulamamıza göre daha dar kapsamlı bir uygulamadır.

                        5. FİKRİ MÜLKİYET HAKLARI

                        Bu “Portal” dahilinde erişilen veya hukuka uygun olarak kullanıcılar tarafından sağlanan bilgiler ve bu “Portal”ın (sınırlı olmamak kaydıyla " EVHAYALİNİZ Veri Tabanı", " EVHAYALİNİZ Arayüzü", tasarım, metin, imge, html kodu ve diğer kodlar) tüm elemanları (hepsi birlikte " EVHAYALİNİZ "in telif haklarına tabi çalışmaları” olarak anılacaktır) " EVHAYALİNİZ "e ait ve/veya " EVHAYALİNİZ " tarafından üçüncü bir kişiden lisans altında alınmıştır. "Kullanıcı"lar, "EVHAYALİNİZ" hizmetlerini, " EVHAYALİNİZ " bilgilerini ve " EVHAYALİNİZ "in telif haklarına tabi çalışmalarını yeniden satmak, işlemek, kopyalamak, paylaşmak, dağıtmak, sergilemek veya başkasının " EVHAYALİNİZ "in hizmetlerine erişmesi veya kullanmasına izin vermek hakkına sahip değildirler. İşbu "Site Kullanım Koşulları" dahilinde " EVHAYALİNİZ " tarafından sarahaten izin verilen durumlar haricinde " EVHAYALİNİZ "in telif haklarına tabi çalışmalarını çoğaltamaz, işleyemez, dağıtamaz veya bunlardan türemiş çalışmalar yapamaz.

                        İşbu "Kullanım Koşulları" dahilinde " EVHAYALİNİZ " tarafından sarahaten yetki verilmediği hallerde " EVHAYALİNİZ "; " EVHAYALİNİZ " hizmetleri, " EVHAYALİNİZ " bilgileri, " EVHAYALİNİZ " telif haklarına tabi çalışmaları, " EVHAYALİNİZ " ticari markaları, " EVHAYALİNİZ " ticari görünümü veya bu site vasıtasıyla sağladığı başkaca varlık ve bilgilere yönelik tüm haklarını saklı tutmaktadır.

                        6. KULLANIM KOŞULLARINDA DEĞİŞİKLİKLER

                        " EVHAYALİNİZ ", dilediğinde, tek taraflı olarak işbu "Kullanım Koşulları"nı herhangi bir zamanda “Portal”da ilan ederek değiştirebilir. İşbu "Kullanım Koşulları"nın değişen hükümleri, ilan edildikleri tarihte geçerlilik kazanarak, yürürlüğe girecektir. İşbu "Kullanım Koşulları" “Kullanıcı”nın tek taraflı beyanları ile değiştirilemez.

                        7. MÜCBİR SEBEPLER

                        Hukuken mücbir sebep sayılan tüm durumlarda, geç ifa etme, eksik ifa etme veya ifa etmeme hallerinde " EVHAYALİNİZ "in herhangi bir tazminat yükümlülüğü doğmayacaktır. "Mücbir sebep", ilgili tarafın makul kontrolü haricinde ve " EVHAYALİNİZ "in gerekli özeni göstermesine rağmen önleyemediği olaylar olarak yorumlanacak olup, sayılanlarla sınırlı olmamak şartıyla doğal afet, savaş, yangın, grev, ayaklanma, isyan, kötü hava koşulları, altyapı ve internet arızaları, sisteme ilişkin iyileştirme veya yenileştirme çalışmaları ve bu sebeple meydana gelebilecek her türlü arıza, elektrik kesintisi mücbir sebep hallerindendir.

                        8. UYGULANACAK HUKUK VE YETKİ

                        İşbu "Kullanım Koşulları" uygulanmasında, yorumlanmasında ve bu "Kullanım Koşulları" dahilinde doğan hukuki ilişkilerin yönetiminde yabancılık unsuru bulunması durumunda Türk kanunlar ihtilafı kuralları hariç olmak üzere Türk Hukuku uygulanacaktır. İşbu “Kullanım Koşulları”ndan dolayı doğan veya doğabilecek her türlü ihtilafın hallinde İstanbul Merkez (Çağlayan) Mahkemeleri ve İcra Daireleri yetkilidir.

                        9. YÜRÜRLÜK ve KABUL

                        İşbu "Kullanım Koşulları" " EVHAYALİNİZ " tarafından “Portal”de yayınlandığı tarihte yürürlüğe girer. "Kullanıcı"lar işbu ”Kullanım Koşulları”nı ve zaman içinde yapılan değişiklikleri “Portal”ı kullanmakla kabul etmiş olmaktadırlar.

                        EK-2 Gizlilik Politikası

                        İşbu Gizlilik Politikası’nın amacı, Sahibinden Bilgi Teknolojileri Pazarlama ve Ticaret Anonim Şirketi (“EVHAYALİNİZ” veya “Şirket”) tarafından yönetilmekte olan https://www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/ adresinde yer alan web sitesinin, (“Portal”) kullanımına ilişkin koşul ve şartları tespit etmektir. İşbu Gizlilik Politikası’nda tanımlanmayan ifadelerin yorumlanmasında Kullanım Koşulları ve Hesap Sözleşmesi’ndeki tanımlar dikkate alınacaktır. Kullanıcılar, Hesap Sözleşmesi’ni kabul etmeleri üzerine işbu Gizlilik Politikası’nı da kabul etmiş sayılacaktır.

                        “Kurumsal Hesap Sahibi”, davet edeceği Alt Kullanıcı’ların işbu Gizlilik Politikası hükümlerini bizzat onaylamaları gerektiğini kabul etmektedir. Bu doğrultuda Kurumsal Hesap sahibi belirleyeceği her Alt Kullanıcı’dan:

                        · Onay alınacağını,

                        · Onay alınmazsa, Alt Kullanıcı’nın Portal’i kullanamayacağını,

                        · Her bir Alt Kullanıcı için ayrı ayrı onay alınacağını taahhüt eder.

                        EVHAYALİNİZ, teknolojiye yatırım yaparak yenilikçi ürün ve hizmet uygulamaları ile internet alanında Kullanıcılarına daha iyi hizmet vermek için sürekli kendisini yenilemekte ve en iyi hizmeti verebilmek için çalışmaktadır.

                        EVHAYALİNİZ, Kullanıcı Sözleşmesi’nin 6.1. maddesinde belirtilen taahhütleri saklı kalmak kaydıyla, online davranışsal reklamcılık ve pazarlama yapılabilmesi amacıyla siteye gelen Kullanıcı’nın ”Hesap sahibi” olmasalar dahi sitedeki davranışlarını tarayıcıda bulunan bir cookie (çerez) ile ilişkilendirme ve görüntülenen sayfa sayısı, ziyaret süresi ve hedef tamamlama sayısı gibi metrikleri temel alan yeniden pazarlama listeleri tanımlama hakkını haizdir. Daha sonra bu Kullanıcı’ya sitede ya da Görüntülü Reklam Ağı’ndaki diğer sitelerde, Kullanıcılar’ın ilgi alanlarına göre hedefe yönelik reklam içeriği gösterilebilir.

                        Google AFS reklamlarının EVHAYALİNİZ’e yönlendirilmesi esnasında Google kullanıcıların tarayıcısına çerez yerleştirebilir veya bunlarda yer alan çerezleri okuyabilir veya bilgi toplamak amacı ile web işaretleri kullanabilir.

                        Gizlilik Politikası Üzerinde Gerçekleşecek Olan Değişiklikler

                        EVHAYALİNİZ, işbu Gizlilik Politikası hükümlerini dilediği zaman Portal üzerinden yayımlamak suretiyle güncelleyebilir ve değiştirebilir. EVHAYALİNİZ’in Gizlilik Politikası’nda yaptığı güncelleme ve değişiklikler Portal’da yayınlandığı tarihten itibaren geçerli olacaktır.

                        Kullanıcı, işbu Gizlilik Politikası'na konu bilgilerinin tam, doğru ve güncel olduğunu, bu bilgilerde herhangi bir değişiklik olması halinde bunları derhal https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/user/profile / adresinden güncelleyeceğini taahhüt eder. Kullanıcı'nın güncel bilgileri sağlamamış olması halinde EVHAYALİNİZ'in herhangi bir sorumluluğu olmayacaktır.



                    </p>


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kurumsalsozlesme" tabindex="-1" aria-labelledby="sozlesmeLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sozlesmeLabel">Kullanıcı Sözleşmesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        Kurumsal Hesap* Sözleşmesi </p>

                    <p>
                        1. Taraflar

                        İşbu Kurumsal Hesap Sözleşmesi (bundan böyle “Hesap Sözleşmesi” olarak anılacaktır); “İstiklal, Özkılıç Sokak no 2A, 68400 Ortaköy/Aksaray” adresinde mukim EVHAYALİNİZ Bilgi Teknoloji Ticaret ve Limited Şirketi (bundan böyle kısaca "EVHAYALİNİZ" olarak anılacaktır) ile www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} portalında hesap açmak için işbu “Hesap Sözleşmesi” ile ayrılmaz parçası olan eklerine ve “Portal”da yer alan şartlar ile kurallara onay veren "Kurumsal Hesap Sahibi" arasında elektronik ortamda akdedilerek yürürlüğe girmiştir.

                    </p>

                    <p>
                        2. Tanımlar

                        “Portal”: www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} isimli alan adından ve bu alan adına bağlı alt alan adlarından oluşan “EVHAYALİNİZ”in hizmetlerini sunduğu internet sitesi ve/veya mobil uygulamalar.

                    </p>
                    <p>

                        “Kullanıcı”: “Portal”a erişen her gerçek veya tüzel kişiyi ifade eder.

                        “Hesap Sahibi”: “Portal”da hesap açan ve “Portal” dahilinde sunulan hizmetlerden faydalanan “Kullanıcı”dır.

                        “Kurumsal Hesap Sahibi”: “Portal”da hesap açan ve "Portal" dahilinde sunulan hizmetlerden işbu “Hesap Sözleşme”de belirtilen koşullar dahilinde yararlanan, ticari faaliyet gösteren “Kullanıcı“dır.

                        “Kurumsal Hesap” (“Hesap”): “Kurumsal Hesap Sahibi” olmak isteyen “Kullanıcı”nın, “Portal”daki “Kurumsal Hesap” formunu doğru ve gerçek bilgilerle eksiksiz olarak doldurması üzerine, “EVHAYALİNİZ” tarafından yapılan değerlendirme sonucunda ve “EVHAYALİNİZ” tarafından yapılan bildirim ile kazanılan statüdür. “Hesap” hak ve yükümlülükleri, başvuruda bulunana ait olan, kısmen veya tamamen herhangi bir üçüncü şahsa devredilemeyen hak ve yükümlülüklerdir, hesap açma süreci tamamlanmadan “Kurumsal Hesap Sahibi” olunamaz. “Hesap” başvurusu herhangi bir sebep gösterilmeksizin “EVHAYALİNİZ” tarafından reddedilebilir veya ek şart ve koşullar talep edilebilir. “EVHAYALİNİZ” gerekli görmesi ve/veya mevzuattaki düzenlemeler nedeniyle zorunlu durumların meydana gelmesi halinde; “Kurumsal Hesap Sahibi”nin hesabını kapatabilir, herhangi bir sebeple hesabı kapatılanın yapacağı hesap açma talebini kabul etmeyebilir.


                    </p>

                    <p>

                        “Mağaza”: “Kurumsal Hesap Sahibi”nin “Portal” üzerindeki ticari faaliyetlerini yürütebilmesi için satın alması zorunlu olan, ilanlarını girebildiği yönetebildiği ve sergileyebildiği “EVHAYALİNİZ” ürünüdür. “Mağaza”ya sahip olmadan “Portal”ın “Kurumsal Hesap Sahibi”ne sunmuş olduğu hizmetlerden faydalanılamaz.

                    </p>

                    <p>


                        “Mağaza Sahibi”: “Portal”a bilgilerini girerek “Mağaza” satın alım işlemini tamamlamış olan “Kurumsal Hesap Sahibi”dir.

                        “Mağaza Kullanıcısı”: “Mağaza Sahibi”nin vermiş olduğu yetki çerçevesinde “Mağaza”yı kullanabilen ve “Kurumsal Hesap Sahibi”nin tabi olduğu tüm kurallara uymakla yükümlü olan gerçek kişidir. “Mağaza Kullanıcısı” sayısının üst sınırı “EVHAYALİNİZ” tarafından belirlenecek olup, “Mağaza Kullanıcısı” sayısına ilişkin üst sınırda “EVHAYALİNİZ” dilediği zamanda önceden haber vermeksizin değişiklik yapabilir. Belli bir süre “Portal”a giriş yapmayan veya “Portal”ı kullanmayan “Mağaza Kullanıcıları”nın hesapları EVHAYALİNİZ tarafından kapatılabilir.

                        “EVHAYALİNİZ Hizmetleri” ("Hizmetler"): "Portal" içerisinde "Hesap Sahibi"nin işbu “Hesap Sözleşmesi” içerisinde tanımlı olan iş ve işlemlerini gerçekleştirmelerini sağlamak amacıyla “EVHAYALİNİZ” tarafından sunulan uygulamalardır. "EVHAYALİNİZ", "Hizmetler"de dilediği zamanda önceden haber vermeksizin değişiklikler ve/veya uyarlamalar yapabilir. Yapılan değişiklikler ve/veya uyarlamalarla ilgili "Hesap Sahibi"nin uymakla yükümlü olduğu kural ve koşullar “Portal”da yayımlandığı tarihte yürürlüğe girer.

                        “İçerik”: “Portal”da yayınlanan ve erişimi mümkün olan her türlü bilgi, yazı, dosya, resim, video, rakam vb. görsel, yazımsal ve işitsel imgeleri ifade eder.

                        "EVHAYALİNİZ Arayüzü": “EVHAYALİNİZ” ve "Hesap Sahibi" tarafından oluşturulan içeriğin "Kullanıcı”lar tarafından görüntülenebilmesi ve "EVHAYALİNİZ Veri Tabanı"ından sorgulanabilmesi amacıyla "Kullanıcı”lar tarafından kullanılan; 5846 Sayılı Fikir ve Sanat Eserleri Kanunu kapsamında korunan ve tüm fikri hakları “EVHAYALİNİZ”e ait olan tasarımlar içerisinde “Portal” üzerinden yapılabilecek her türlü işlemin gerçekleştirilmesi için bilgisayar programına komut veren internet sayfaları ve mobil uygulama ekranları/sayfalarıdır.


                    </p>
                    <p>

                        “EVHAYALİNİZ Veri Tabanı”: “Portal” dahilinde erişilen içeriklerin depolandığı, tasnif edildiği, sorgulanabildiği ve erişilebildiği “EVHAYALİNİZ”e ait olan 5846 Sayılı Fikir ve Sanat Eserleri Kanunu gereğince korunan veritabanıdır.

                        “Profilim” sayfası: “Standart Mağaza” kullanan "Kurumsal Hesap Sahibi"nin "Portal"da yer alan çeşitli uygulamalardan ve "Hizmet”lerden yararlanabilmesi için gerekli işlemleri gerçekleştirebildiği, ticari bilgilerini, tercihlerini, uygulama bazında kendisinden talep edilen bilgileri girdiği, sadece "Kurumsal Hesap Sahibi" tarafından belirlenen kullanıcı adı ve şifre ile erişilebilen "Kurumsal Hesap Sahibi"ne özel sayfadır.
                        “Kişisel Veri”: 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun’un (KVKK) 3/d maddesi uyarınca, kimliği belirli veya belirlenebilir gerçek kişiye ilişkin her türlü bilgi ile KVKK m.6/1’de sayılan özel nitelikli kişisel verilerdir.


                    </p>

                    <p>
                        “Özel nitelikli kişisel veri”: Kişilerin ırkı, etnik kökeni, siyasi düşüncesi, felsefi inancı, dini, mezhebi veya diğer inançları, kılık ve kıyafeti, dernek, vakıf ya da sendika üyeliği, sağlığı, cinsel hayatı, ceza mahkûmiyeti ve güvenlik tedbirleriyle ilgili verileri ile biyometrik ve genetik verileri özel nitelikli kişisel veridir.

                        “Kamuya açık veri”: Rakiplerin ve/veya 3. Kişilerin, evhayaliniz’in www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} adlı kamuya açık internet sitesinden erişilebildikleri veya anlayabildikleri (tespit edebildikleri) tüm veriler.


                    </p>
                    <p>
                        3. “Hesap Sözleşmesi”nin Konusu ve Kapsamı.

                        İşbu “Hesap Sözleşmesi”nin konusu, "Portal"da sunulan hizmetlerin, bu hizmetlerden yararlanma şartları ile tarafların hak ve yükümlülüklerinin tespitidir. “Hesap Sözleşmesi” ve ekleri ile "Portal" içerisinde yer alan kullanıma, hesaba ve hizmetlere ilişkin “EVHAYALİNİZ” tarafından yapılan tüm uyarı, bildirim, uygulama ve açıklama gibi beyanlar kapsam dâhilindedir. "Kullanıcı", işbu “Hesap Sözleşmesi” hükümlerini kabul etmekle, "Portal" içeriklerine, hesaba ve “Hizmetler”e ilişkin “EVHAYALİNİZ” tarafından açıklanan her türlü beyana uygun davranacağını kabul ve taahhüt etmektedir.


                    </p>

                    <p>
                        4. Kurumsal Hesap Sahibi Olma

                        4.1 “Mağaza Sahibi” için:

                        4.1.1 “Kurumsal Hesap Sahibi” olabilmek için ticari faaliyet göstermek ve temsile yetkili kişi tarafından “Hesap” başvurusunda bulunmuş olmak ve “EVHAYALİNİZ” tarafından işbu “Hesap Sözleşmesi” kapsamında hesabı geçici olarak durdurulmamış veya hesabı kapatılmamış olmak, “İlan Verme Kuralları”na aykırı davranmamış olmak gerekmektedir. “EVHAYALİNİZ”, hesabı aktif hale getirmeden önce, tamamen kendi takdirine tabi olmak üzere “Kurumsal Hesap Sözleşmesi”ni akdetmek adına işlem yapan kişinin usulüne uygun olarak yetkilendirildiğine ve “Kurumsal Hesap Sahibi” nezdindeki iç onay mekanizmasının usulüne uygun olarak tamamlandığına ilişkin ek bilgi ve belge talep etme hakkına sahiptir. Sisteme yeni bir Mağaza Kullanıcısı tanımlanması sırasında da “EVHAYALİNİZ aynı şekilde, ilgili Mağaza Kullanıcısı’nın ve/veya “Mağaza Sahibi” adına işlem yapan kişilerin yetkilendirildiğine ve “Kurumsal Hesap Sahibi” nezdindeki iç onay mekanizmasının usulüne uygun olarak tamamlandığına ilişkin ek bilgi ve belge talep etme hakkına sahiptir.

                    </p>

                    <p>

                        4.1.2 “EVHAYALİNİZ” herhangi bir zamanda gerekçe göstermeden, bildirimde bulunmadan, tazminat, ceza vb. sair yükümlülüğü bulunmaksızın derhal yürürlüğe girecek şekilde işbu “Hesap Sözleşmesi”ni tek taraflı olarak feshedebilir, "Kurumsal Hesap Sahibi"nin hesabını kapatabilir veya geçici olarak durdurabilir. "Portal"da belirtilen kurallara aykırılık halleri, “Kurumsal Hesap Sahibi”nin "EVHAYALİNİZ" bilgi güvenliği sistemine risk oluşturması halleri, hesabı kapatma veya geçici olarak durdurma hallerindendir.

                    </p>

                    <p>

                        4.1.3 “Kurumsal Hesap Sahibi”, “Portal”da ilan vermek ve “EVHAYALİNİZ”in sunduğu hizmetlerden yararlanabilmek için “Mağaza” açmalıdır.

                        4.2 “Mağaza Kullanıcısı” için:

                        4.2.1 “Mağaza Kullanıcısı” daveti, “Mağaza Sahibi”nin davet etmek istediği gerçek kişilere e-posta ile davet göndermesi ile gerçekleşir. Davet gönderilen e-posta adresinin “EVHAYALİNİZ” üzerinde herhangi bir hesapta tanımlı olmaması gereklidir. “Mağaza Kullanıcısı” olma davetini kabul etmek isteyen kişiler, davette yer alan linkteki “Kurumsal Hesap” formunu doldurup, “Kurumsal Hesap Sözleşmesi”ni onaylayarak “Mağaza Kullanıcısı” olabilir.

                    </p>

                    <p>
                        4.2.2 “Mağaza Kullanıcısı”nın tüm davranışlarından ve yaptığı işlemlerden “Mağaza Sahibi” de müştereken ve müteselsilen sorumludur. Bu nedenle “Mağaza Sahibi”, “Mağaza Kullanıcısı” ile ilişkisini herhangi bir sebeple kesmek istediğinde, derhal bu işlemi “Profilim”deki veya “Ofisim”deki veya “Oto Galerim”deki “Kullanıcılar” sayfasından gerçekleştirmelidir. Aksi takdirde “Mağaza Kullanıcısı”nın işlemlerinden ötürü sorumlu olmaya devam edecektir. “Mağaza” Sahibi”, “Mağaza Kullanıcısı”nı “Mağaza”dan çıkartması durumunda, “Mağaza Kullanıcısı”nın “Kurumsal Hesap”ı pasif duruma düşecektir.
                    </p>

                    <p>

                        4.2.3 “Mağaza Kullanıcısı”, sadece bir “Mağaza”nın kullanıcısı olabileceğinden, farklı bir “Mağaza” altında “Mağaza Kullanıcısı” olamaz.

                        4.2.4 “Mağaza Sahibi”nin “Mağaza”sını kullanıma kapatması durumunda, “Mağaza Kullanıcısı” “Portal”da herhangi bir işlem yapamaz. “Mağaza Kullanıcısı”nın hesabı da pasif hale gelecektir. “Mağaza” sahibinin tekrar mağazasını açması durumunda, “Mağaza Kullanıcısı”nın hesabı herhangi bir ek talep gerekmeksizin aktif hale gelir.

                        4.2.5 “Mağaza Kullanıcısı” olan bir hesap sahibi “Mağaza” açamaz. “Mağaza”sı olan bir “Kurumsal Hesap Sahibi”, farklı bir “Mağaza”ya “Mağaza Kullanıcısı” olarak eklenemez.


                    </p>

                    <p>
                        4.2.6 EVHAYALİNİZ tarafından belirlenen süre boyunca ilan vermeyen veya “Portal”a giriş yapmayan “Kurumsal Hesap Sahibi”, EVHAYALİNİZ tarafından “Mağaza Kullanıcısı” olmaktan çıkarılabilir.

                        4.2.7 Profesyonel Emlak Mağazası’nın kullanıcı sayısı ilan paketi büyüklüğüne göre belirlenecektir. Şöyle ki; “Mağaza”ların kullanıcı sayısı, paketindeki ilan sayısının 10’a bölünmesi ve elde edilen sayıya 2 eklenmesi ile yani (ilan paketi büyüklüğü/10)+2 formülü ile hesaplanacaktır. Proje Satış Ofisi Mağazası’nın kullanıcı sayısı ise ilan paketi büyüklüğünden bağımsız 5 kullanıcı olacaktır. Bu hesaplamada “Mağaza Kullanıcısı” sayısına “Mağaza Sahibi” dahil olacaktır.

                        4.2.8 “Mağaza” kullanımlarının güvenliğini arttırmak amacıyla Hizmetler kategorisindeki “Kurumsal Hesap Sahibi”nin “Mağaza Kullanıcısı” olanlardan son 6 aydır kurumsal kullanıcı adı ve şifresi ile Portal’a giriş yapmayanlar “pasif kullanıcı” olarak kabul edilecek ve “pasif kullanıcı”lar “Mağaza Kullanıcısı” olanlar arasından başkaca herhangi bir bildirime gerek bulunmaksızın silinecektir.

                        5. Tarafların Hak ve Yükümlülükleri

                    </p>

                    <p>

                        5.1 "Kurumsal Hesap Sahibi"nin Hak ve Yükümlülükleri

                        5.1.1 “Kurumsal Hesap Sahibi", “Portal"da belirtilen kurallara, beyanlara, yürürlükteki tüm mevzuata ve ahlak kurallarına uygun hareket edeceğini, “Hesap Sözleşmesi” hükümleri ile “Portal”daki tüm şart ve kuralları okuyup, anladığını ve onayladığını kabul ve taahhüt etmektedir. “Kurumsal Hesap Sahibi”, faaliyet göstermiş olduğu alanlardaki mevzuata göre, “Yetki Belgesi”, ”Sertifika” vb. belgeler almasının gerekli olduğu alanlarda, ilgili belgelere sahip olmadan ilan yayınlaması nedeniyle EVHAYALİNİZ’in zarara uğraması halinde; EVHAYALİNİZ’in, uğradığı veya uğrayabileceği maddi ve manevi, doğrudan ve dolaylı her tür zararlar için “Kurumsal Hesap Sahibi”ne rücu hakkı saklıdır.

                        5.1.2 "Kurumsal Hesap Sahibi”, EVHAYALİNİZ’in yürürlükteki mevzuat hükümleri gereğince resmi makamlara açıklama yapmakla yükümlü olduğu durumlarda; “Kurumsal Hesap Sahip”ine ait gizli/özel/ticari bilgileri resmi makamlara açıklamaya yetkili olduğunu, bu sebeple EVHAYALİNİZ’den herhangi bir talepte bulunmayacağını, her ne nam altında olursa olsun tazminat talep etmeyeceğini kabul ve taahhüt etmektedir. Bunun haricinde “Kurumsal Hesap Sahibi”nin “Portal” üzerinde verdiği ilanlarla ilgili olarak herhangi bir kişi ya da kurumun haklarının ihlal edildiği iddiası ile “EVHAYALİNİZ”e bildirimde bulunulması halinde; “Kurumsal Hesap Sahibi”nin bildirdiği ad-soyad/ticari unvan, mağaza bilgileri ile “Mağaza Kullanıcısı” bilgileri, ilan bilgileri ve varsa istenen diğer bilgileri “EVHAYALİNİZ” ilgili kişi ya da kuruma verebilir.

                        5.1.3 "Kurumsal Hesap Sahibi"nin, hesabına girişte kullandığı "kullanıcı adı" ve "şifre"nin güvenliğini münhasıran ve münferiden kendisi tarafından sağlaması, bizzat kendisinin kullanması gerekir. “Kurumsal Hesap Sahibi” aynı “kullanıcı adı” ve “şifre” bilgileri başkaca internet sitelerinin hesaplarına tanımlamamalı, başkaca internet sitelerinin hesabında kayıtlı bulunan “kullanıcı adı” ve “şifre” bilgilerini EVHAYALİNİZ “Hesap”ına tanımlamamalıdır. “Kurumsal Hesap Sahibi” herhangi bir amaçla “kullanıcı adı” ve “şifre” bilgilerini, başka bir kullanıcı, şirket, üçüncü kişi ile yazılımsal arayüz vb. ile paylaşamaz. Bu konuda ihmal veya kusurlarından dolayı diğer kullanıcıların ve/veya “EVHAYALİNİZ”in ve/veya üçüncü kişilerin ve/veya kendisinin uğradığı veya uğrayabileceği maddi ve manevi, doğrudan ve dolaylı her tür zararlardan “Kurumsal Hesap Sahibi” sorumlu olacaktır. EVHAYALİNİZ’in böyle bir durumda uğrayacağı zarar için Kurumsal Hesap Sahibi’ne rücu etme hakkı saklıdır. Mağaza Sahibi ve Mağaza Kullanıcısı’na ait hesap, kullanıcı adı ve şifre ile gerçekleştirilen her işlem bizzat “Kurumsal Hesap Sahibi”, tarafından gerçekleştirilmiş addedilecek ve bu bilgilerinin “Kurumsal Hesap Sahibi”, tarafından yetkilendirilmiş kişiler dışındaki bir kişi tarafından kullanılması, kaybolması veya el değiştirmesi nedeniyle “Kurumsal Hesap Sahibi” ve/veya üçüncü kişilerin uğradığı zararlardan münhasıran “Kurumsal Hesap Sahibi” sorumlu olacaktır. “Kurumsal Hesap Sahibi”, “Mağaza Kullanıcısı” veya “Mağaza Sahibi” gibi belirli bir kullanıcı adı ve şifre ile Portal’a giriş yapan kişilere ait hesap bilgilerinin bir üçüncü kişi tarafından öğrenildiğine dair herhangi birinin şüphesinin bulunması halinde; “Kurumsal Hesap Sahibi” derhal durumu Portal yetkililerine bildirecektir.

                    </p>

                    <p>

                        5.1.4 "Kurumsal Hesap Sahibi", "Portal" dahilinde kendisi veya Mağaza Kullanıcısı/Kullanıcıları tarafından sağlanan bilgilerin ve içeriklerin doğru ve hukuka uygun olduğunu, tüketici aldatıcı nitelikte olmadığını, söz konusu bilgi ve içeriklerin "Portal"da yayınlanmasının veya bu içeriklerle bağlantılı ürünlerin satışının ve teşhirinin, yürürlükteki mevzuata aykırılık yaratmadığını kabul ve taahhüt etmektedir. EVHAYALİNİZ, " Kurumsal Hesap Sahibi" tarafından EVHAYALİNİZ’e iletilen veya "Portal" üzerinden “Kurumsal Hesap Sahibi” tarafından yüklenen bilgilerin ve içeriklerin doğruluğunu araştırmakla yükümlü ve sorumlu olmadığı gibi, söz konusu bilgi ve içeriklerin yanlış veya hatalı olmasından veya yayınlanmasından dolayı ortaya çıkacak herhangi bir zarardan da sorumlu tutulamaz. “Kurumsal Hesap Sahibi”, “Hesap” açma aşamasında sunulan bilgilerin değişmesi halinde; yeni ve güncel bilgileri “EVHAYALİNİZ”e gecikmeksizin bildirmekle yükümlüdür. Bildirmemesi halinde “EVHAYALİNİZ”in uğrayacağı tüm doğrudan ve dolaylı tüm zarar için “Kurumsal Hesap Sahibi”ne rücu etme hakkı saklıdır.

                        5.1.5 "Kurumsal Hesap Sahibi", EVHAYALİNİZ’in yazılı onayı olmadan işbu “Hesap Sözleşmesi”ni veya bu “Hesap Sözleşmesi”nin kapsamındaki hak ve yükümlülüklerini kısmen veya tamamen herhangi bir üçüncü kişiye devredemez.

                        5.1.6. (a) “Kurumsal Hesap Sahibi” hukuka uygun yöntem ve amaçlarla "Portal" üzerinde ilan yayınlayabilir, işlem yapabilir. "Kurumsal Hesap Sahibi"nin, "Portal" dahilinde yaptığı her işlem ve eylemdeki hukuki ve cezai sorumluluk kendisine aittir. " Kurumsal Hesap Sahibi", "EVHAYALİNİZ"in ve/veya başka bir üçüncü şahsın ayni veya şahsi haklarına, kişisel verilerine, malvarlığına tecavüz teşkil edecek nitelikteki "Portal" dâhilinde bulunan resimleri, metinleri, görsel ve işitsel imgeleri, video klipleri, dosyaları, veritabanları, katalogları ve listeleri çoğaltmayacağını, kopyalamayacağını, dağıtmayacağını, işlemeyeceğini, başka veritabanına aktarmayacağını veya bu nitelikte sonuçlar doğurabilecek şekilde "Portal"a yüklemeyeceğini kabul ve taahhüt etmektedir. "Kurumsal Hesap Sahibi"nin işbu “Hesap Sözleşmesi” hükümlerine ve hukuka aykırı olarak gerçekleştirdikleri "Portal" üzerindeki faaliyetler nedeniyle üçüncü kişilerin uğradıkları veya uğrayabilecekleri zararlardan dolayı "EVHAYALİNİZ" doğrudan ve/veya dolaylı olarak hiçbir şekilde sorumlu tutulamaz. EVHAYALİNİZ’in böyle bir durumda uğrayacağı zarar için “Kurumsal Hesap Sahibi”ne rücu etme hakkı saklıdır.

                        (b) İşbu Sözleşme’nin veya eklerinin hiçbir hükmü, Kullanıcı’nın evhayaliniz harici mecralarda ilan yayınlamasını, evhayaliniz’e girmiş olduğu ilanları bu mecralarda da yayınlamasını engellemez.

                        Kullanıcı, Portal üzerinden, Portal’a kendi yüklemiş olduğu resim, metin, görsel, işitsel, imge, video klip ve dosyalara saklandığı hali ile evhayaliniz tarafından sağlanan teknik imkanlar dairesinde erişebilir ve bu verileri evhayaliniz tarafından sağlanan veri indirme veya API yöntemi çerçevesinde taşıyabilir.

                        Ancak, Kullanıcı evhayaliniz’e girmiş veya yüklemiş olduğu resim, metin, görsel, işitsel, imge, video klip ve dosyalar üzerinde evhayaliniz’in teknik veya görsel iyileştirmeler yaptığı halleri üzerinde hak sahibi değildir. Bu iyileştirmelerin gerçekleştirildiği resim, metin, görsel, işitsel, imge, video klip ve dosyaların iyileştirilmiş versiyonlarını çoğaltamaz, kopyalayamaz, dağıtamaz veya işleyemez.


                    </p>

                    <p>
                        5.1.7 İşbu Sözleşme’nin 5.1.6 (b) maddesi saklı kalmak kaydıyla “EVHAYALİNİZ”, “Kurumsal Hesap Sahibi”nin sadece ilgili ilanların içeriklerini öğrenme amacıyla ilanları görüntülemesine ve “EVHAYALİNİZ Arayüzü”nü kullanmasına izin vermekte olup, bunun dışında bir amaçla veri tabanı üzerinden belirli bir sayıda veya bütününe yönelik olarak ilanlara ulaşılmaya çalışılması, ilanların kısmen veya tamamen kopyalanması, bunların başka mecralarda doğrudan veya dolaylı olarak yayınlanması, derlenmesi, işlenmesi, başka veritabanlarına aktarılması, bu veritabanından üçüncü kişilerin erişimine ve kullanımına açılması, “EVHAYALİNİZ” üzerindeki ilanlara link verilmesi de dahil olmak üzere benzer fiillerin işlenmesine “EVHAYALİNİZ” tarafından izin verilmemekte ve rıza gösterilmemektedir. Bu tür fiiller hukuka aykırı olup, "EVHAYALİNİZ”in her türlü talep, dava ve takip hakları saklıdır.

                        5.1.8 “EVHAYALİNİZ” tarafından “Kurumsal Hesap Sahibi” için hazırlanan raporları ve benzeri içerikleri, müşterileri dışında kimseyle paylaşamaz, rapor içeriğinde herhangi bir değişiklik yapamaz, satamaz, rapordan kısmen alıntı yapamaz, rapordan türetilmiş çalışmalar yapamaz. “EVHAYALİNİZ”in yapay zeka teknolojisi ile oluşturulmuş S-İlan Klibi {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} kullanıcılarının görüntülemesi için oluşturulmuş olup, sadece www.{{str_replace(['http://', 'https://'], '', env('APP_URL'))}} internet sitesi ile mobil uygulamaları üzerinden ilana ayrılan alanda yayınlanabilir, kopyalanamaz, başkaca platformda ya da mecrada kullanılamaz, başka veritabanlarına aktarılamaz, üçüncü kişilerle paylaşılamaz. Raporlar, ilan klipleri veya benzeri içerikler hakkında işbu madde hükümlerine aykırı hareket ettiğinin tespit edilmesi halinde; “EVHAYALİNİZ” tarafından hesabı geçici olarak durdurulabilir ya da hesabı kapatılabilir ya da başkaca yaptırım uygulanabilir. “Kurumsal Hesap Sahibi” rapor veya ilan klibi içeriği konusunda “EVHAYALİNİZ”in herhangi bir sorumluluğu bulunmadığını peşinen kabul ve taahhüt etmektedir.

                        5.1.9 “Kurumsal Hesap Sahibi”nin “Portal” veya “EVHAYALİNİZ” sistemlerinin güvenliğini tehdit edebilecek ve/veya “Portal”, “EVHAYALİNİZ” ve diğer kullanıcılara zarar verebilecek eylemlerde bulunması, “Portal”ın ve “Portal”a ait diğer yazılımların çalışmasını veya diğer kullanıcıların “Portal”dan faydalanmasını engelleyebilecek herhangi bir girişimde bulunması, bu sonuçları verecek şekilde sisteme veya “Portal”’a orantısız yük bindirmesi; “Portal”’ın kaynak kodlarına veya “EVHAYALİNİZ”’ın sistemlerine yetkisiz bir şekilde erişmesi, bu bilgileri kopyalaması, silmesi, değiştirmesi ya da bu yönde denemeler yapması, “Portal”’ın çalışmasını engelleyecek yazılımlar kullanması, kullanmaya çalışması veya her türlü yazılım, donanım ve sunucuların çalışmasını aksatması, bozulmasına yol açması, tersine mühendislik yapması, saldırılar düzenlemesi, meşgul etmesi veya bunlara sair surette müdahale etmesi, “EVHAYALİNİZ” sunucularına erişim sağlamaya çalışılması kesinlikle yasaktır.


                    </p>

                    <p>
                        5.2. "EVHAYALİNİZ"in Hak ve Yükümlülükleri

                        5.2.1 "EVHAYALİNİZ", işbu “Hesap Sözleşmesi”nde bahsi geçen hizmetleri; ilgili hizmetlerin sunumuyla ilgili “Portal”da belirtilen açıklamalar ve işbu “Hesap Sözleşmesi”nde belirtilen koşullar dâhilinde yerine getirmeyi, işbu “Hesap Sözleşmesi” kapsamında belirtilen hizmetlerin sunulabilmesi için gerekli olan teknolojik altyapıyı tesis etmeyi ve işletmeyi kabul, beyan ve taahhüt eder. İşbu madde içerisinde belirtilen teknolojik altyapı tesis etme yükümlülüğü, sınırsız ve eksiksiz bir hizmet taahhüdü anlamına gelmemektedir; “EVHAYALİNİZ” her zaman herhangi bir bildirimde bulunmadan işbu “Hesap Sözleşmesi” ile belirlenen hizmetlerini ve teknolojik altyapısını durdurabilir veya son verebilir.

                        5.2.2 ”EVHAYALİNİZ” Portal’ı ve “Hizmetler”i; “Olduğu Gibi” sağlamakta olup, “Portal” ve “Hizmetler”in hatasız, kusursuz, kesintisiz, mükemmel olduğu veya “Kurumsal Hesap Sahibi”nin kendine özel ihtiyaçlarını karşılayacağı şeklinde bir iddia veya taahhütte bulunmamaktadır. “EVHAYALİNİZ” “Portal” üzerinde her türlü değişiklik, güncelleme ve benzeri çalışmalar yapabilir ve “Kurumsal Hesap Sahibi” Portal’ı ve “Hizmetler”i kullanmaya devam ettiği sürece, “Portal”i ve “Hizmetler”i kullandığı haliyle (“Olduğu Gibi”) kabul etmiş sayılır. “EVHAYALİNİZ”:

                        (i) “Kurumsal Hesap Sahibi”’nin “Portal” ve “Hizmetler”i kullanması, kullanmaması, yanlış kullanması veya “Kurumsal Hesap Sahibi”nin “Hesap Sözleşmesi”nde belirtilen taahhüt ve yükümlülüklerini yerine getirmemesinden;

                        (ii) tüm donanım, sistem yazılımı/diğer yazılımlar ve ağ ilişkili işlevden ve bu nedenle ortaya çıkacak arızalardan;

                        (iii) iletişim ağı (network), internet bağlantısı, bağlantı hatalarından;

                        (iv) “Portal” üzerinde gerçekleştirilecek her türlü değişiklik, güncelleme ve benzeri çalışmalar sonucunda oluşabilecek hata ve arızalardan;

                        (v) voltaj dalgalanmalarından, batarya ve elektrik kesilmelerinden, virüs bulaşmasından ve benzeri faktörlerden;

                        (vi) işletim sistemi uyumsuzluklarından;

                        (vii) yukarıda sayılanlarla sınırlı olmaksızın “Kurumsal Hesap Sahibi”nin “Mağaza”sını ve/veya “Portal”ı kullanmasını engelleyen uyumsuzlukların veya hataların ortaya çıkmasından

                        kaynaklanan doğrudan veya dolaylı zararlardan, her türlü kar kaybı, veri kaybı, iş kaybı, itibar kaybı, beklenen tasarrufun kaybı, işin kesintiye uğraması gibi her türlü maddi, manevi ve mali zararlardan, bu kapsamda “Kurumsal Hesap Sahibi” veya üçüncü bir tarafça yapılabilecek tazminat taleplerinden sorumlu değildir.

                        5.2.3 “EVHAYALİNİZ”, “Hesap Sözleşmesi” ile belirlenen amaç ve kapsam dışında da “Kurumsal Hesap” açma aşamasında talep edilen ad-soyad/ticari unvan, telefon numarası, e-posta adresi, adres, işletme türü gibi bilgileri; yürürlükte bulunan mevzuatta öngörülen koşullara tabi şekilde ve gerektiğinde ek onayları ve açık rızaları almak suretiyle, sms, e-posta, site içi bilgilendirmeler ve benzeri yöntemlerle, tanıtım ve bilgilendirme amaçlı iletişim faaliyetleri, araştırma, pazarlama faaliyetleri ve istatistikî analizler yapmak amacıyla veya gerektiğinde “Kurumsal Hesap Sahibi” ile temas kurmak, süreçlerini iyileştirme amaçlı araştırmalar yapmak, veri tabanı oluşturmak ve pazar araştırmaları yapmak için kullanabilir, “EVHAYALİNİZ”in işbirliği içinde olduğu firmalara aktarabilir, bu firmalar tarafından işlenebilir ve kullanılabilir.

                        5.2.4 "EVHAYALİNİZ"in üçüncü kişilerin sahip olduğu ve işlettiği başka internet sitelerine ve/veya portallara, dosyalara veya içeriklere link verebilir. Bu linkler "Kurumsal Hesap Sahibi" tarafından veya sadece referans kolaylığı nedeniyle "EVHAYALİNİZ" tarafından sağlanmış olabilir ve linkin yöneldiği internet sitesini veya işleten kişisini desteklemek amacıyla veya internet sitesi veya içerdiği bilgilere yönelik herhangi bir türde doğrulama beyanı veya garanti niteliği taşımamaktadır. "Portal" üzerindeki linkler vasıtasıyla erişilen portallar, internet siteleri, dosyalar ve içerikler, bu linkler vasıtasıyla erişilen portallar veya internet sitelerinden sunulan hizmetler veya ürünler veya bunların içeriği hakkında "EVHAYALİNİZ"in herhangi bir sorumluluğu yoktur.

                        5.2.5 "EVHAYALİNİZ", "Portal"ın işleyişine, hukuka, mevzuata, başkalarının haklarına, “Hesap Sözleşmesi” koşullarına, kişisel verilerin korunmasına, genel ahlak kurallarına aykırı olan mesajları, istediği zaman ve şekilde erişimden kaldırabilir; "EVHAYALİNİZ" bu mesajı giren "Kurumsal Hesap Sahibi"nin hesabını herhangi bir bildirim yapmadan kapatabilir. EVHAYALİNİZ, mevzuatta meydana gelen değişikliklere bağlı olarak “Kurumsal Hesap Sahibi”ne ek yükümlülükler getirebilir, söz konusu yükümlülükler “Portal”da yayımlandığı tarihte yürürlüğe girer.

                        5.2.6 "EVHAYALİNİZ", ilan sayfaları da dahil olmak üzere “Portal”da reklam alanı olarak belirleyeceği tüm alanlarda kendisinin ya da müşterilerinin reklamını yayınlayabilir.

                        5.2.7 "EVHAYALİNİZ"in, "EVHAYALİNİZ" çalışanlarının ve yöneticilerinin, “Portal”da “Hesap Sahibi” ve “Kullanıcı”lar tarafından sağlanan içeriklerin hukuka uygun olup olmadığını, gerçekliğini, doğruluğunu araştırmak ve kontrol etmek yükümlülüğü bulunmamaktadır.

                        5.2.8 “Kurumsal Hesap Sahibi”nin başvurusu sırasında verilen bilgilerin yeterli, doğru veya güncel olmadığının yahut yanıltıcı ve kötü maksatlı olduğunun tespit edilmesi, hesap başvurusunda bulunan kişinin başvurusunun önceden reddedilmiş olması, hesabının devam ettiği süreçte “Kurumsal Hesap Sahibi” hakkında şikâyetler veya olumsuz yorumlar alınması ve benzeri sebeplerle; “EVHAYALİNİZ” herhangi bir bildirimde bulunmadan, herhangi bir tazminat yükümlülüğü altında bulunmaksızın işbu sözleşmeyi feshederek “Kurumsal Hesap Sahibi”nin hesabını kapatabilir. Hesap kapatma işleminden önce “EVHAYALİNİZ” yetkilileri tarafından gerekli incelemelerin yapılabilmesi için “EVHAYALİNİZ” mağazanın kapatılması da dahil uygun gördüğü tedbirleri uygulayabilir. Hesabın kapatılması veya geçici olarak durdurulması yahut Sözleşme’nin herhangi bir sebeple feshedilmesinin ardından “EVHAYALİNİZ”, kendi takdirine bağlı olarak, “Kurumsal Hesap Sahibi”nin Portal üzerinden paylaşmış olduğu içerikler veya diğer paylaşımların akıbeti konusunda münhasıran karar verme yetkisine sahiptir.

                        5.2.9 "EVHAYALİNİZ", 5651 sayılı "İnternet Ortamında Yapılan Yayınların Düzenlenmesi ve Bu Yayınlar Yoluyla İşlenen Suçlarla Mücadele Edilmesi Hakkında Kanun" kapsamında ve bu Kanun doğrultusunda "Yer Sağlayıcı" olarak faaliyet göstermektedir. EVHAYALİNİZ”i Sözleşme’nin ifası sonucunda kendisi tarafından belirli sonuçların üretileceğini garanti etmemektedir. “EVHAYALİNİZ”, fikri mülkiyet haklarının ihlali, ilan içeriklerinin doğruluğu dâhil ancak bunlarla sınırlı olmamak üzere; “Portal”ın kullanılması ile bağlantılı herhangi bir beyan ve taahhütte bulunmamaktadır. EVHAYALİNİZ ayrıca bakım, onarım çalışmaları, teknik aksaklıklar dahil ancak bunlarla sınırlı olmaksızın herhangi bir sebepten ötürü Sözleşme kapsamındaki hizmetlerin geç verilmesi, kesintiye uğraması veya hizmetin verilmesi ile ilgili “EVHAYALİNİZ” herhangi bir sorumluluk üstlenmemektedir.

                        6. Gizlilik Politikası

                        6.1 “EVHAYALİNİZ”, "Portal"da "Kurumsal Hesap Sahibi"yle ilgili bilgileri işbu “Hesap Sözleşmesi” ve işbu “Hesap Sözleşmesi”nin eklerinden biri ve ayrılmaz parçası olan EK-2’teki Gizlilik Politikası kapsamında kullanabilir. EVHAYALİNİZ”, “Portal”da yer alan “vasıta” ilan kategorisinde oluşturulan kamuya açık olmayan herhangi bir veriyi, ikinci el araç alım satım hizmetleri ve ayrıca ekspertiz hizmetleri faaliyetleri kapsamında oluşturulan veriler ile birleştirmeyeceğini ve ikinci el araç alım satım hizmetleri ve ayrıca ekspertiz hizmetleri ile ilişkili kullanmayacağını kabul ve taahhüt etmektedir. “EVHAYALİNİZ” "Kurumsal Hesap Sahibi"ne ait gizli bilgileri ancak Gizlilik Politikası’nda belirtilen koşullar dâhilinde üçüncü kişilere açıklayabilir veya kullanabilir. “Kurumsal Hesap Sahibi”, ilanla ilgili olarak Satıcı ile Alıcı arasında mesajlaşmanın yapılabilmesi için Alıcı sıfatıyla hareket ettiği durumlarda giriş yapmayı ve Alıcı sıfatıyla kendisinin telefon numarasının Satıcı ile paylaşılmasını kabul, beyan ve taahhüt eder.

                        6.2 "Hesap Sahibi”nin kişisel veri teşkil edebilecek ve kendisi tarafından Portal’a girilen verileri “EVHAYALİNİZ” tarafından 6.1. madde de belirtilen taahhütleri saklı kalmak kaydıyla, “Hesap Sözleşmesi” kapsamında; “Portal”ın fonksiyonlarının kullandırılması, hizmetlerin ve içeriklerin sağlanması ve yukarıda sayılan amaçlarla toplanmakta ve işlenmektedir. Kişisel Verilerin Korunması Hakkında detaylı bilgi için Kişisel Verilerin Korunması sayfası ziyaret edilmelidir. “EVHAYALİNİZ” Kişisel Verilerin Korunması Politikası’nda ve sair kişisel veriler ile ilgili politika, prosedür, sözleşme maddeleri ve kullanım koşullarında istediği zaman değişiklik yapabilir. Değişiklikler Portal’da yayınlandığı anda yürürlüğe girer ve “Hesap Sahibi” için bağlayıcı olur. “Hesap Sahibi” bu değişiklikleri takip etmekle yükümlü olup, EVHAYALİNİZ’den bu değişikliklerle ilgili herhangi bir talepte veya zarar ziyan iddiasında bulunamaz.

                        6.3 "Hesap Sahibi”, “Portal” dahilinde eriştiği bilgileri yalnızca bu bilgileri ifşa eden “Hesap Sahibi"nin veya “EVHAYALİNİZ”in ifşa ettiği amaçlara uygun olarak kullanmakla yükümlü olup, elde ettiği Kullanıcılar’a veya üçüncü kişilere ait Kişisel Verilerin korunmasından, işlenmesinden, aktarılmasından ve KVKK kapsamındaki tüm yükümlülüklerden kendisinin sorumlu olduğunu, “EVHAYALİNİZ”in kendi sistemlerinde internet sitesinin kullanımı için zorunlu olarak topladığı kişisel veriler dışındaki hiçbir kişisel veri için KVKK kapsamında herhangi bir yükümlülüğünün ve sorumluluğunun olmadığını kabul, beyan ve taahhüt eder. “Hesap Sahibi”, kişisel verilerin korunması yükümlülüğüne aykırı hareket etmesi veya kişisel verileri işlemesi, aktarması veya sair surette bir işleme konu etmesi ve bu kullanımın bir ihlal meydana getirmesi durumunda; Kişisel Verileri Koruma Kurulu’nun veya idari makamların veya mahkemelerin kişisel verilerle ilgili olarak verdikleri kararlar neticesinde “EVHAYALİNİZ”in bir zarara uğraması durumunda; bu zararı ilk talepte nakden ve defaten tazmin edeceğini kabul, beyan ve taahhüt eder.

                        6.4 “Hesap Sahibi”, bir Avrupa Birliği mukimi gerçek kişi olması durumunda kendi kişisel verileri ile ilgili olarak 6698 sayılı Kişisel Verilerin Korunması Hakkında Kanun ve ikincil düzenlemeleri ile Kişisel Verileri Koruma Kurulu kararlarının ve düzenlemelerinin uygulanacağını, çıkabilecek tüm hukuki sorunlarda kanunlar ihtilafı kurallarına bakılmadan Türk iç hukukunun uygulanacağını, 95/46/EC sayılı Avrupa Birliği Direktifi’nin ve Mayıs 2018 tarihinde Avrupa Birliği’nde yürürlüğe giren Genel Veri Koruma Regülasyonu’nun (GDPR) uygulanmayacağını, Türk Milletlerarası Özel Hukuk ve Usul Hukuku Hakkında Kanun’un kanunlar ihtilafı kaidelerinin uygulanmasını talep etmekten feragat ettiğini kabul, beyan ve taahhüt eder.

                    </p>

                </div>
            </div>
        </div>
    </div>

    <!-- Login Popup for Like/Comment Actions -->
    <div id="login-popup" class="fiyat-gecmisi-area" style="display: none; position: fixed; z-index: 1040;">
        <div class="fiyat-gecmisi-giris">
            <div class="fiyat-gecmisi-close" onclick="closeLoginPopup()" style="position: relative; top: 0; right: 0; padding: 5px;">
                <i class="fa-solid fa-circle-xmark" style="font-size: 16px; color: #666;"></i>
            </div>
            <p class="mb-0" id="login-popup-message">
                Beğenmek için giriş yapmalısınız
            </p>
            <a data-bs-toggle="modal" href="#exampleModalToggle" onclick="closeLoginPopup()">
                Giriş Yap
            </a>
            <div class="bottomarrow"></div>
        </div>
    </div>

    <style>
        /* Login popup z-index düzenlemeleri - Modal'dan düşük tutuyoruz */
        #login-popup.fiyat-gecmisi-area {
            z-index: 1040 !important;
        }

        /* Mobile için popup düzenlemeleri */
        @media (max-width: 768px) {
            #login-popup.fiyat-gecmisi-area {
                width: 250px !important;
                left: 10px !important;
                z-index: 1040 !important;
            }

            #login-popup .fiyat-gecmisi-close {
                position: absolute !important;
                top: 8px !important;
                right: 8px !important;
                padding: 5px !important;
                z-index: 1041 !important;
            }

            #login-popup .fiyat-gecmisi-giris {
                padding: 25px 15px 15px 15px !important;
                position: relative !important;
            }
        }

        /* Bootstrap modal z-index'leri */
        .modal-backdrop {
            z-index: 1050 !important;
        }

        .modal {
            z-index: 1055 !important;
        }

        #login-popup {
            z-index: 1040 !important;
        }
    </style>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('site/js/fancybox.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/swiper.js') }}"></script>
<script type="text/javascript" src="{{ asset('site/js/main.js') }}?v={{ time() }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        document.querySelector('input[name=avatar]').showPicker();
    }

    function showAvatar() {
        let file = event.target.files[0]; // Seçilen dosyayı al
        if (file) {
            let reader = new FileReader(); // Dosya okuyucu oluştur
            reader.onload = function(e) {
                document.querySelector('.pdform-logo-area').innerHTML = `<img src="${e.target.result}"
                style="width: 140px; height: 140px; object-fit: cover; border-radius: 50%" class="profile-edit-avatar">`;
            }
            reader.readAsDataURL(file); // Dosyayı base64 formatında oku
        }
    }

    function removeAvatar() {
        document.querySelector('.pdform-logo-area img').src = `/site/images/default_avatar.jpg`;
        document.querySelector('#avatar').value = 2;
    }

    function getSubCategories() {
        const subCategorySelect = document.querySelector('#sub-category-select');

        subCategorySelect.innerHTML = "";

        let opt = document.createElement('option');
        opt.value = "";
        opt.textContent = "Alt Kategori";
        subCategorySelect.appendChild(opt);

        fetch("/sub-categories/" + event.target.value, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
            })
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML = "";

                opt = document.createElement('option');
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


    function removeFileFromInput(inputId, path) {
        let input = document.querySelector('#' + inputId);

        // Seçilen dosyayı input içerisinden kaldırıyoruz
        let newInput = input.value.split(',').filter(e => {
            return e !== path;
        })

        input.value = newInput.join(',');

        event.currentTarget.closest('.file-container').remove();
    }
</script>


<script>
    $(function() {
        const showMessage = (type, message) => {
            if (!message) {
                return;
            }

            if (window.toastr && typeof window.toastr[type] === 'function') {
                window.toastr[type](message);
            } else {
                alert(message);
            }
        };

        const clearErrors = ($form) => {
            $form.find('.ajax-error').remove();
            $form.find('.is-invalid').removeClass('is-invalid');
        };

        const renderErrors = ($form, errors) => {
            Object.entries(errors).forEach(([field, messages]) => {
                if (!messages || !messages.length) {
                    return;
                }

                const message = messages[0];
                const $input = $form.find(`[name="${field}"]`);

                if ($input.length) {
                    $input.addClass('is-invalid');

                    const $wrapper = $input.closest('.input-field').length ?
                        $input.closest('.input-field') :
                        $input.parent();

                    $wrapper.find('.ajax-error').remove();
                    $('<div class="ajax-error text-danger small mt-1"></div>')
                        .text(message)
                        .appendTo($wrapper);
                }
            });
        };

        $('[data-auth-ajax]').each(function() {
            const $form = $(this);

            $form.on('submit', function(event) {
                event.preventDefault();

                if ($form.data('submitting')) {
                    return;
                }

                clearErrors($form);

                if ($form.data('auth-ajax') === 'register') {
                    const password = $form.find('input[name="password"]').val();
                    const confirmation = $form.find('input[name="password_confirmation"]').val();

                    if (typeof confirmation !== 'undefined' && password !== confirmation) {
                        renderErrors($form, {
                            password_confirmation: ['Şifreler eşleşmiyor.']
                        });
                        showMessage('error', 'Şifreler eşleşmiyor.');
                        return;
                    }
                }

                const $submit = $form.find('[type="submit"]');
                const originalHtml = $submit.data('original-html') ?? $submit.html();
                let redirecting = false;

                $submit.data('original-html', originalHtml);
                $submit.prop('disabled', true).addClass('disabled');
                $form.data('submitting', true);

                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method') || 'POST',
                    data: $form.serialize(),
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        redirecting = true;
                        showMessage('success', response.message || 'İşlem başarılı.');

                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            window.location.reload();
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON || {};

                        if (xhr.status === 422 && response.errors) {
                            renderErrors($form, response.errors);

                            const firstError = Object.values(response.errors)[0];
                            if (Array.isArray(firstError) && firstError.length) {
                                showMessage('error', firstError[0]);
                            }
                        } else if (xhr.status === 419) {
                            showMessage('error', 'Oturum süreniz doldu, sayfa yenileniyor.');
                            window.location.reload();
                        } else {
                            const errorMessage = response.message || 'Bir hata oluştu. Lütfen tekrar deneyin.';
                            showMessage('error', errorMessage);
                        }
                    },
                    complete: function() {
                        if (redirecting) {
                            return;
                        }

                        $submit.prop('disabled', false).removeClass('disabled').html($submit.data('original-html'));
                        $form.data('submitting', false);
                    }
                });
            });
        });
    });
</script>


<script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
</script>


<script>
    document.addEventListener('DOMContentLoaded', _ => {
        if (window.innerWidth < 992) {
            document.querySelector('.web-menu-col.menuminshow.hide').classList.remove('hide')
        }
    });
</script>

<script>
    const btns = document.querySelectorAll('.share-btn');
    if (btns.length > 0) {
        btns.forEach(e => {
            e.addEventListener('click', function() {
                const url = !e.dataset.url ? window.location.href : e.dataset.url;
                const btn = this;

                // URL'i panoya kopyala
                navigator.clipboard.writeText(url).then(() => {
                    // Buton içeriğini değiştir
                    btn.innerHTML = '<i class="fa-solid fa-check"></i>';

                    // 5 saniye sonra eski haline getir
                    setTimeout(() => {
                        btn.innerHTML = `<i class="fa-solid fa-share-nodes"></i>`;
                    }, 5000);

                }).catch(err => {
                    console.error('Kopyalama başarısız:', err);
                });
            });
        });
    }
</script>


<script>
    function copyToClipboard(btn) {
        on();

        const url = !btn.dataset.url ? window.location.href : btn.dataset.url;

        navigator.clipboard.writeText(url).then(() => {
            // Buton içeriğini değiştir
            btn.innerHTML = '<i class="fa-solid fa-check me-2 pt-1"></i> Kopyalandı';

            // 5 saniye sonra eski haline getir
            setTimeout(() => {
                btn.innerHTML = `<i class="fa-solid fa-share-nodes me-2 pt-1"></i> Kopyala`;
            }, 5000);

        }).catch(err => {
            console.error('Kopyalama başarısız:', err);
        });
    }
</script>


<script>
    function priceEdit() {
        const visibleInput = event.currentTarget;
        const hiddenInput = event.currentTarget.closest('form').querySelector('input.price-area');

        if (visibleInput && hiddenInput) {
            visibleInput.addEventListener('input', function(e) {
                // Sadece rakam ve virgül alınsın
                let input = visibleInput.value.replace(/[^\d,]/g, '');

                // Fazladan virgül varsa sadece ilkini koru
                const parts = input.split(',');
                const intPart = parts[0] || '0';
                const decimalPart = parts[1] ? parts[1].slice(0, 2) : '';

                // Arka planda kullanılacak gerçek sayı
                const rawNumber = decimalPart ? `${intPart}.${decimalPart}` : intPart;
                hiddenInput.value = rawNumber;

                // Görünüm için 3'lü gruplama
                const groupedInt = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                visibleInput.value = decimalPart ? `${groupedInt},${decimalPart}` : groupedInt;
            });
        }
    }
</script>


<script>
    function scrollFilterAreaFixed() {
        const filterArea = document.querySelector('.tum-hizmetler-inputs-flex');
        if (window.scrollY > 50) {
            filterArea.classList.add('scrolled');

        } else {
            filterArea.classList.remove('scrolled');
        }
    }
</script>




<script>
    function ideaLike(slug) {
        @guest()
        showLoginPopup('Beğenmek için giriş yapmalısınız!', event.currentTarget);
        return false;
        @else
        const item = event.currentTarget;
        const countArea = item.querySelector('span');
        const count = parseInt(countArea.textContent);

        fetch("/idea/like/" + slug, {
                method: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.isDeleted) {
                    item.style.color = '#94a0b8';
                    countArea.textContent = count - 1;

                    // Desktop stats'taki beğeni sayısını da güncelle
                    const desktopLikeCount = document.getElementById('desktop-like-count');
                    if (desktopLikeCount && desktopLikeCount !== countArea) {
                        desktopLikeCount.textContent = Math.max(0, parseInt(desktopLikeCount.textContent) - 1);
                    }
                } else {
                    item.style.color = '#3b63d2';
                    countArea.textContent = count + 1;

                    // Desktop stats'taki beğeni sayısını da güncelle
                    const desktopLikeCount = document.getElementById('desktop-like-count');
                    if (desktopLikeCount && desktopLikeCount !== countArea) {
                        desktopLikeCount.textContent = parseInt(desktopLikeCount.textContent) + 1;
                    }

                    setTimeout(_ => {
                        item.style.color = '#94a0b8';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        @endguest
    }

    // Login popup functions
    function showLoginPopup(message, triggerElement) {
        const popup = document.getElementById('login-popup');
        const messageElement = document.getElementById('login-popup-message');

        if (popup && messageElement && triggerElement) {
            messageElement.textContent = message;

            // Trigger elementin pozisyonunu al
            const rect = triggerElement.getBoundingClientRect();
            const isMobile = window.innerWidth <= 768;

            // Popup'ı göster (orijinal CSS ile uyumlu)
            popup.style.display = 'block';
            popup.style.position = 'fixed';

            if (isMobile) {
                // Mobile'da sola yasla ve kapatma ikonunu görünür yap
                popup.style.left = '10px';
                popup.style.right = 'auto';
                popup.style.top = (rect.top - 120) + 'px';
                popup.style.width = '250px';
            } else {
                // Desktop'ta ortalanmış
                popup.style.left = (rect.left + rect.width / 2 - 118) + 'px'; // 236px genişliğin yarısı
                popup.style.top = (rect.top - 120) + 'px'; // Orijinal top: -102px + padding
                popup.style.width = '236px';
            }

            popup.style.transform = 'none';
            popup.style.zIndex = '1040';
            popup.classList.add('show');

            // 5 saniye sonra otomatik kapat
            setTimeout(() => {
                closeLoginPopup();
            }, 5000);
        }
    }

    function closeLoginPopup() {
        const popup = document.getElementById('login-popup');
        if (popup) {
            popup.style.display = 'none';
            popup.classList.remove('show');
        }
    }

    // Modal açıldığında popup'ı kapat
    document.addEventListener('DOMContentLoaded', function() {
        const loginModal = document.getElementById('exampleModalToggle');
        if (loginModal) {
            loginModal.addEventListener('shown.bs.modal', function() {
                closeLoginPopup();
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popoverTrigger = document.getElementById('user-notif-trigger2');
        const popover = new bootstrap.Popover(popoverTrigger, {
            trigger: 'manual', // elle kontrol ediyoruz
            html: true
        });

        let isOpen = false;

        popoverTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            if (isOpen) {
                popover.hide();
                isOpen = false;
            } else {
                popover.show();
                isOpen = true;
            }
        });

        // Sayfada bir yere tıklanınca popover kapanır
        document.addEventListener('click', function(event) {
            if (!popoverTrigger.contains(event.target)) {
                popover.hide();
                isOpen = false;
            }
        });
    });
</script>

<script>
    // Mail doğrulama sistemi
    document.addEventListener('DOMContentLoaded', function() {
        // CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Bireysel "Kod Gönder" butonu
        const userSendCodeButtons = document.querySelectorAll('form[data-auth-ajax="register"] input[name="user_type"][value="user"]');
        if (userSendCodeButtons.length > 0) {
            const userForm = userSendCodeButtons[0].closest('form');
            const sendCodeBtn = userForm.querySelector('.code-send-button');
            const userRegisterBtn = document.getElementById('user_register_button');

            if (sendCodeBtn) {
                sendCodeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const emailInput = userForm.querySelector('input[name="email"]');

                    if (!emailInput || !emailInput.value.trim()) {
                        toastr.warning('Lütfen e-posta adresinizi girin!', 'Uyarı');
                        return;
                    }

                    // Buton disable
                    sendCodeBtn.disabled = true;
                    sendCodeBtn.textContent = 'Gönderiliyor...';

                    // AJAX isteği
                    fetch('/auth/send-verification-code', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                email: emailInput.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                toastr.success(data.message, 'Başarılı');
                                sendCodeBtn.textContent = 'Kod Gönderildi';

                                // Kayıt Ol butonunu aktif et
                                if (userRegisterBtn) {
                                    userRegisterBtn.setAttribute('data-verified', 'true');
                                    userRegisterBtn.style.opacity = '1';
                                    userRegisterBtn.style.cursor = 'pointer';
                                }

                                // 60 saniye sonra tekrar kod gönderebilsin
                                setTimeout(() => {
                                    sendCodeBtn.disabled = false;
                                    sendCodeBtn.textContent = 'Kod Gönder';
                                }, 60000);
                            } else {
                                toastr.error(data.message, 'Hata');
                                sendCodeBtn.disabled = false;
                                sendCodeBtn.textContent = 'Kod Gönder';
                            }
                        })
                        .catch(error => {
                            toastr.error('Bir hata oluştu!', 'Hata');
                            sendCodeBtn.disabled = false;
                            sendCodeBtn.textContent = 'Kod Gönder';
                        });
                });
            }
        }

        // Kurumsal "Kod Gönder" butonu
        const companySendCodeButtons = document.querySelectorAll('form[data-auth-ajax="register"] input[name="user_type"][value="company"]');
        if (companySendCodeButtons.length > 0) {
            const companyForm = companySendCodeButtons[0].closest('form');
            const sendCodeBtn = companyForm.querySelector('.code-send-button');
            const companyRegisterBtn = document.getElementById('company_register_button');

            if (sendCodeBtn) {
                sendCodeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const emailInput = companyForm.querySelector('input[name="email"]');

                    if (!emailInput || !emailInput.value.trim()) {
                        toastr.warning('Lütfen e-posta adresinizi girin!', 'Uyarı');
                        return;
                    }

                    // Buton disable
                    sendCodeBtn.disabled = true;
                    sendCodeBtn.textContent = 'Gönderiliyor...';

                    // AJAX isteği
                    fetch('/auth/send-verification-code', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                email: emailInput.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                toastr.success(data.message, 'Başarılı');
                                sendCodeBtn.textContent = 'Kod Gönderildi';

                                // Kayıt Ol butonunu aktif et
                                if (companyRegisterBtn) {
                                    companyRegisterBtn.setAttribute('data-verified', 'true');
                                    companyRegisterBtn.style.opacity = '1';
                                    companyRegisterBtn.style.cursor = 'pointer';
                                }

                                // 60 saniye sonra tekrar kod gönderebilsin
                                setTimeout(() => {
                                    sendCodeBtn.disabled = false;
                                    sendCodeBtn.textContent = 'Kod Gönder';
                                }, 60000);
                            } else {
                                toastr.error(data.message, 'Hata');
                                sendCodeBtn.disabled = false;
                                sendCodeBtn.textContent = 'Kod Gönder';
                            }
                        })
                        .catch(error => {
                            toastr.error('Bir hata oluştu!', 'Hata');
                            sendCodeBtn.disabled = false;
                            sendCodeBtn.textContent = 'Kod Gönder';
                        });
                });
            }
        }

        // Bireysel "Kayıt Ol" butonu kontrolü
        const userButton = document.getElementById('user_register_button');
        if (userButton) {
            userButton.addEventListener('click', function(e) {
                const verificationCode = document.getElementById('user_verification_code');
                const isVerified = userButton.getAttribute('data-verified') === 'true';

                // Kod boş mu kontrol et
                if (!verificationCode || !verificationCode.value.trim()) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    toastr.warning('Lütfen doğrulama kodunu girin!', 'Uyarı');
                    return false;
                }

                // Kod 6 hane mi kontrol et
                if (verificationCode.value.trim().length !== 6) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    toastr.warning('Doğrulama kodu 6 haneli olmalıdır!', 'Uyarı');
                    return false;
                }

                // Mail gönderildi mi kontrol et
                if (!isVerified) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    toastr.warning('Lütfen önce e-posta adresinize gönderilen kodu alın!', 'Uyarı');
                    return false;
                }
            });
        }

        // Kurumsal "Kayıt Ol" butonu kontrolü
        const companyButton = document.getElementById('company_register_button');
        if (companyButton) {
            companyButton.addEventListener('click', function(e) {
                const verificationCode = document.getElementById('company_verification_code');
                const isVerified = companyButton.getAttribute('data-verified') === 'true';

                // Kod boş mu kontrol et
                if (!verificationCode || !verificationCode.value.trim()) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    toastr.warning('Lütfen doğrulama kodunu girin!', 'Uyarı');
                    return false;
                }

                // Kod 6 hane mi kontrol et
                if (verificationCode.value.trim().length !== 6) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    toastr.warning('Doğrulama kodu 6 haneli olmalıdır!', 'Uyarı');
                    return false;
                }

                // Mail gönderildi mi kontrol et
                if (!isVerified) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    toastr.warning('Lütfen önce e-posta adresinize gönderilen kodu alın!', 'Uyarı');
                    return false;
                }
            });
        }
    });
</script>


<!-- Çerez Politikası Modal -->
<div class="modal fade" id="cerezpolitikasi" tabindex="-1" aria-labelledby="cerezpolitikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cerezpolitikasiLabel">ÇEREZ POLİTİKASI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Son güncelleme tarihi: 29.11.2025</strong></p>
                <p>Bu Çerez Politikası, evhayaliniz.com alan adlı internet sitesi ve ilgili mobil/web uygulamaları (&quot;Site&quot;) üzerinden kullanılan çerezler ve benzeri teknolojiler hakkında kullanıcıları bilgilendirmek amacıyla hazırlanmıştır.</p>
                <p>Site&apos;yi ziyaret ederek veya kullanmaya devam ederek, işbu Çerez Politikası kapsamında çerez kullanımını kabul etmiş sayılırsınız.</p>

                <h6>1. ÇEREZ NEDİR?</h6>
                <p>Çerezler (&quot;cookies&quot;), ziyaret ettiğiniz internet siteleri tarafından tarayıcınıza veya cihazınıza kaydedilen küçük metin dosyalarıdır.</p>
                <p>Çerezler sayesinde:</p>
                <ul>
                    <li>Site&apos;nin düzgün ve güvenli şekilde çalışması,</li>
                    <li>Tercihlerinizin (dil, oturum bilgisi vb.) hatırlanması,</li>
                    <li>Site&apos;nin kullanımının analiz edilmesi ve geliştirilmesi</li>
                </ul>
                <p>mümkün hale gelir.</p>

                <h6>2. HANGİ TÜR ÇEREZLER KULLANILIYOR?</h6>
                <p>Site&apos;de, kullanım amaçlarına göre farklı türlerde çerezler kullanılabilir:</p>
                
                <h6 class="mt-3">2.1. Zorunlu (Gerekli) Çerezler</h6>
                <p>Bu çerezler, Site&apos;nin temel işlevlerini sağlayan ve mutlaka gerekli olan çerezlerdir. Örneğin:</p>
                <ul>
                    <li>Oturum açmanızın sağlanması,</li>
                    <li>Güvenlik kontrolleri,</li>
                    <li>Formların ve sayfaların düzgün çalışması.</li>
                </ul>
                <p>Bu çerezler olmadan Site&apos;nin düzgün çalışması mümkün olmayabilir.</p>
                
                <h6 class="mt-3">2.2. Performans ve Analiz Çerezleri</h6>
                <p>Bu çerezler; Site&apos;nin nasıl kullanıldığını anlamamıza, ziyaretçi sayısını, gezilen sayfaları, tıklama ve kullanım istatistiklerini görmemize yardımcı olur.</p>
                <p>Bu sayede:</p>
                <ul>
                    <li>Site&apos;yi geliştirebilir,</li>
                    <li>Hangi içeriklerin daha çok ilgi gördüğünü analiz edebiliriz.</li>
                </ul>
                <p>Bu çerezler genellikle anonim istatistiksel veriler üretir.</p>
                
                <h6 class="mt-3">2.3. İşlevsel Çerezler</h6>
                <p>Bu çerezler, Site deneyiminizi kişiselleştirmek için kullanılır. Örneğin:</p>
                <ul>
                    <li>Dil tercihinizin hatırlanması,</li>
                    <li>Geçmiş ziyaretlerinize göre bazı ayarların korunması.</li>
                </ul>
                <p>İşlevsel çerezler sayesinde Site&apos;yi her ziyaret ettiğinizde bazı tercihleri yeniden girmeniz gerekmez.</p>
                
                <h6 class="mt-3">2.4. Reklam ve Pazarlama Çerezleri (Kullanılıyorsa)</h6>
                <p>Site&apos;de tarafımızca veya üçüncü taraf iş ortaklarımız tarafından reklam ve pazarlama amaçlı çerezler kullanılabilir. Bu çerezler:</p>
                <ul>
                    <li>İlgi alanlarınıza daha uygun içerik ve reklam gösterilmesi,</li>
                    <li>Kampanyalarımızın etkinliğinin ölçülmesi</li>
                </ul>
                <p>amacıyla kullanılabilir.</p>

                <h6 class="mt-4">3. ÇEREZLERİN SÜRELERİ</h6>
                <p>Çerezler, saklandıkları süreye göre de ikiye ayrılır:</p>
                <ul>
                    <li><strong>Oturum çerezleri:</strong> Sadece ziyaretiniz süresince geçerli olan, tarayıcıyı kapattığınızda silinen çerezlerdir.</li>
                    <li><strong>Kalıcı çerezler:</strong> Tarayıcı veya cihazınızda belirli bir süre boyunca saklanan çerezlerdir. Bu süre sona erdiğinde otomatik olarak silinir veya siz tarayıcı ayarlarından manuel olarak silebilirsiniz.</li>
                </ul>

                <h6 class="mt-4">4. BİRİNCİ TARAF VE ÜÇÜNCÜ TARAF ÇEREZLER</h6>
                <ul>
                    <li><strong>Birinci taraf çerezler:</strong> Doğrudan evhayaliniz.com tarafından yerleştirilen çerezlerdir.</li>
                    <li><strong>Üçüncü taraf çerezler:</strong> Analiz, istatistik veya reklam hizmeti aldığımız üçüncü taraf sağlayıcılar tarafından yerleştirilen çerezlerdir.</li>
                </ul>

                <h6 class="mt-4">5. ÇEREZLERİ HANGİ AMAÇLARLA KULLANIYORUZ?</h6>
                <p>Site&apos;de kullanılan çerezler başlıca şu amaçlarla kullanılmaktadır:</p>
                <ul>
                    <li>Site&apos;nin güvenli ve düzgün çalışmasını sağlamak,</li>
                    <li>Üyelik işlemlerini ve oturum açma süreçlerini yönetmek,</li>
                    <li>Kullanıcı tercihlerinin (örneğin dil veya görüntüleme seçenekleri) hatırlanması,</li>
                    <li>Site trafiğini ve kullanım istatistiklerini analiz ederek Site performansını iyileştirmek,</li>
                    <li>İlgi alanlarına göre içerik ve hizmet önerebilmek.</li>
                </ul>

                <h6 class="mt-4">6. ÇEREZLERİ NASIL KONTROL EDİP YÖNETEBİLİRSİNİZ?</h6>
                <p>Tarayıcı ayarları üzerinden çerezleri kontrol edebilir, silebilir veya kullanımını kısıtlayabilirsiniz. Çoğu tarayıcı:</p>
                <ul>
                    <li>Tüm çerezleri kabul etme,</li>
                    <li>Tüm çerezleri reddetme,</li>
                    <li>Belirli siteler için çerez ayarları belirleme,</li>
                    <li>Tarayıcı kapandığında çerezleri silme</li>
                </ul>
                <p>gibi seçenekler sunar.</p>
                <p>Tarayıcınızın &quot;ayarlar&quot; veya &quot;gizlilik&quot; bölümünden çerez tercihlerinizi değiştirebilirsiniz. Ayrıntılı bilgi için kullandığınız tarayıcının yardım menüsüne göz atabilirsiniz.</p>
                <p><strong>Önemli Not:</strong> Çerezleri tamamen devre dışı bırakmanız hâlinde, Site&apos;nin bazı bölümleri düzgün çalışmayabilir veya beklediğiniz kadar hızlı, güvenli ve kişiselleştirilmiş bir deneyim sunamayabilir.</p>

                <h6 class="mt-4">7. ÇEREZLERİN HUKUKİ DAYANAĞI</h6>
                <p>Çerezler aracılığıyla işlenen kişisel verileriniz, KVKK kapsamında;</p>
                <ul>
                    <li>&quot;Bir sözleşmenin kurulması veya ifası için gerekli olması&quot;,</li>
                    <li>&quot;Veri sorumlusunun meşru menfaati&quot;,</li>
                    <li>Zorunlu olmayan çerezler için açık rızanızın bulunması</li>
                </ul>
                <p>hukuki sebeplerine dayanılarak işlenebilmektedir.</p>
                <p>Ayrıntılı bilgi için Gizlilik Politikamız ve KVKK Aydınlatma Metinlerimizi inceleyebilirsiniz.</p>

                <h6 class="mt-4">8. ÇEREZ POLİTİKASINDA DEĞİŞİKLİKLER</h6>
                <p>EvHayaliniz, işbu Çerez Politikası&apos;nı, yasal düzenlemeler ve Site&apos;de sunulan hizmetlerdeki değişiklikler doğrultusunda güncelleyebilir.</p>
                <p>Güncel Çerez Politikası her zaman Site&apos;de yayımlanacaktır. Önemli bir değişiklik olması hâlinde, Site üzerinden veya gerekli gördüğümüz diğer iletişim kanalları aracılığıyla kullanıcılarımız bilgilendirilebilir.</p>

                <h6 class="mt-4">9. İLETİŞİM</h6>
                <p>Çerez Politikamız ve kişisel verilerinizin işlenmesine ilişkin sorularınız için bizimle aşağıdaki iletişim kanalları üzerinden irtibata geçebilirsiniz:</p>
                <p><strong>Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi</strong><br>
                <strong>Adres:</strong> İstiklal Mah Özkılıç Sok. No 2A Ortaköy/Aksaray<br>
                <strong>E-posta:</strong> evhayaliniz@gmail.com<br>
                <strong>Telefon:</strong> +90 542 655 67 40</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<!-- Gizlilik Politikası Modal -->
<div class="modal fade" id="gizlilikpolitikasi" tabindex="-1" aria-labelledby="gizlilikpolitikasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gizlilikpolitikasiLabel">GİZLİLİK POLİTİKASI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Son güncelleme tarihi: 29.11.2025</strong></p>
                <p>Bu Gizlilik Politikası, evhayaliniz.com alan adlı internet sitesi ve ilgili mobil/web uygulamaları (&quot;Site&quot;) üzerinden sunulan hizmetler kapsamında, Site&apos;yi kullanan bireysel ve kurumsal kullanıcıların (&quot;Kullanıcı&quot;) kişisel verilerinin işlenmesine ilişkin esasları açıklamaktadır.</p>
                <p>Site&apos;yi ziyaret eden veya kullanan herkes, işbu Gizlilik Politikası&apos;nı okumuş ve içeriğini anlamış sayılır.</p>

                <h6 class="mt-4">1. VERİ SORUMLUSU</h6>
                <p>6698 sayılı Kişisel Verilerin Korunması Kanunu (&quot;KVKK&quot;) uyarınca, Site üzerinden işlenen kişisel veriler bakımından veri sorumlusu:</p>
                <p><strong>Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi</strong><br>
                <strong>Adres:</strong> İstiklal Mah Özkılıç Sok. No 2A Ortaköy/Aksaray<br>
                <strong>Vergi Dairesi / No:</strong> Aksaray VD. / 3820436873<br>
                <strong>İletişim E-posta:</strong> evhayaliniz@gmail.com<br>
                <strong>Telefon:</strong> +90 542 655 67 40</p>
                <p>olarak hareket etmektedir.</p>

                <h6 class="mt-4">2. HANGİ KİŞİSEL VERİLER TOPLANIR?</h6>
                <p>Site üzerinden aşağıdaki kategorilerde kişisel veriler toplanabilir (tamamı değil, durumuna göre):</p>
                
                <h6 class="mt-3">2.1. Kimlik ve İletişim Bilgileri</h6>
                <ul>
                    <li>Ad, soyad</li>
                    <li>E-posta adresi</li>
                    <li>Cep telefonu numarası</li>
                    <li>Firma unvanı, yetkili kişi adı (kurumsal kullanıcılar için)</li>
                    <li>Vergi dairesi/numarası (kurumsal kullanıcılar için)</li>
                </ul>
                
                <h6 class="mt-3">2.2. Kullanıcı İşlem ve Hesap Bilgileri</h6>
                <ul>
                    <li>Üyelik bilgileri (kullanıcı adı, şifre – şifreler gizli ve şifreli olarak saklanır)</li>
                    <li>Hesap türü (bireysel / kurumsal)</li>
                    <li>Site üzerindeki işlem geçmişiniz (profil düzenleme, görüntülenen sayfalar, favoriler vb.)</li>
                </ul>
                
                <h6 class="mt-3">2.3. Hizmet ve Muhasebe Bilgileri</h6>
                <ul>
                    <li>Satın alınan üyelik paketleri, ödeme bilgileri (tutar, tarih, fatura bilgileri)</li>
                    <li>Fatura düzenleme için kullanılan ticari/kimlik bilgileri</li>
                </ul>
                
                <h6 class="mt-3">2.4. Teknik ve Çerez Verileri</h6>
                <ul>
                    <li>IP adresi</li>
                    <li>Cihaz bilgileri, tarayıcı türü</li>
                    <li>Çerezler (cookie) ve benzeri teknolojiler aracılığıyla toplanan kullanım verileri</li>
                    <li>Oturum açma, sayfa görüntüleme, gezinme istatistikleri</li>
                </ul>
                
                <h6 class="mt-3">2.5. İçerik ve Mesaj Verileri</h6>
                <ul>
                    <li>Site üzerinde paylaştığınız yorumlar, mesajlar, fikirler, görseller</li>
                    <li>Profilinizde yer verdiğiniz açıklamalar ve proje bilgileri</li>
                    <li>Bize ilettiğiniz talep, şikâyet ve geri bildirimler</li>
                </ul>

                <h6 class="mt-4">3. KİŞİSEL VERİLER HANGİ AMAÇLARLA İŞLENİR?</h6>
                <p>Toplanan kişisel veriler, KVKK&apos;nın 5. ve 6. maddelerinde belirtilen işleme şartları çerçevesinde aşağıdaki amaçlarla işlenmektedir:</p>
                
                <h6 class="mt-3">3.1. Üyelik İşlemleri ve Hesap Yönetimi</h6>
                <ul>
                    <li>Üyelik kaydınızın oluşturulması, giriş yapmanızın sağlanması</li>
                    <li>Profil bilgilerinizin yönetilmesi</li>
                    <li>Şifre sıfırlama, bildirim gönderimi vb. hesap işlemleri</li>
                </ul>
                
                <h6 class="mt-3">3.2. Hizmet Sunumu ve Geliştirilmesi</h6>
                <ul>
                    <li>Site&apos;nin çalışması, size sunulan hizmetlerden yararlanmanız</li>
                    <li>Kurumsal kullanıcıların hizmetlerini listeleyebilmesi, profil oluşturması</li>
                    <li>Bireysel kullanıcıların içerik ve fikirleri görüntüleyebilmesi</li>
                    <li>Site deneyiminin analiz edilmesi ve iyileştirilmesi</li>
                </ul>
                
                <h6 class="mt-3">3.3. İletişim ve Destek</h6>
                <ul>
                    <li>Talep ve şikâyetlerinizin alınması ve yanıtlanması</li>
                    <li>Üyeliğiniz, paketleriniz veya hesabınızla ilgili bilgilendirme yapılması</li>
                    <li>Sözleşme şartları, politika değişiklikleri, teknik duyurular hakkında bilgilendirme</li>
                </ul>
                
                <h6 class="mt-3">3.4. Finans ve Faturalama</h6>
                <ul>
                    <li>Ücretli paket, hizmetlerden veya reklamlardan faydalanmanız halinde fatura düzenlenmesi</li>
                    <li>Ödeme kayıtlarının ve muhasebe süreçlerinin yürütülmesi</li>
                </ul>
                
                <h6 class="mt-3">3.5. Pazarlama ve Kişiselleştirme</h6>
                <ul>
                    <li>İzniniz olması halinde; kampanyalar, duyurular ve hizmetlerimizle ilgili bilgilendirme yapılması</li>
                    <li>Site içeriklerinin ilgi alanlarınıza göre kişiselleştirilmesi</li>
                </ul>
                
                <h6 class="mt-3">3.6. Hukuki Yükümlülükler ve Uyuşmazlıkların Çözümü</h6>
                <ul>
                    <li>Yasal yükümlülüklerimizin yerine getirilmesi</li>
                    <li>Yetkili kurum ve kuruluşların taleplerine cevap verilmesi</li>
                    <li>Olası uyuşmazlıklarda delil olarak kullanılması</li>
                </ul>

                <h6 class="mt-4">4. KİŞİSEL VERİLERİN AKTARILMASI</h6>
                <p>Kişisel verileriniz, KVKK&apos;nın 8. ve 9. maddeleri uyarınca, amaçla bağlantılı, sınırlı ve ölçülü olmak kaydıyla:</p>
                <ul>
                    <li>Hizmet alınan tedarikçilerimize (barındırma/hosting firması, e-posta ve SMS sağlayıcıları, ödeme altyapısı sağlayıcıları, teknik destek aldığımız firmalar vb.),</li>
                    <li>Muhasebe ve mali danışmanlık hizmeti aldığımız kişi/kurumlara,</li>
                    <li>Gerekli hâllerde avukatlarımıza ve hukuki danışmanlarımıza,</li>
                    <li>Yasal zorunluluk durumunda yetkili kamu kurum ve kuruluşlarına,</li>
                    <li>Mevzuatın izin verdiği ölçüde yurt içi veya (gerekirse) yurt dışındaki hizmet sağlayıcılarımıza</li>
                </ul>
                <p>aktarılabilmektedir.</p>
                <p>EvHayaliniz, kişisel verilerin güvenliğine ilişkin gerekli teknik ve idari tedbirleri almak için azami özeni gösterir.</p>

                <h6 class="mt-4">5. ÇEREZLER (COOKIES) VE BENZER TEKNOLOJİLER</h6>
                <p><strong>5.1.</strong> Site&apos;de tarama deneyiminizi iyileştirmek, Site&apos;nin güvenliğini sağlamak ve istatistiksel kullanım verilerini analiz etmek için çerezler kullanılmaktadır.</p>
                <p><strong>5.2.</strong> Çerezler aracılığıyla;</p>
                <ul>
                    <li>Hangi sayfaların ziyaret edildiği,</li>
                    <li>Oturum süresi, tıklama sayıları,</li>
                    <li>Tarayıcı ve cihaz bilgileri</li>
                </ul>
                <p>gibi veriler toplanabilir. Bu veriler çoğunlukla istatistiksel amaçlı olup, kimliğinizi doğrudan belirlemeye yönelik değildir.</p>
                <p><strong>5.3.</strong> Tarayıcınızın ayarlarını kullanarak çerezleri kabul veya reddetme, belirli çerez türlerini engelleme imkânına sahipsiniz. Ancak çerezleri tamamen kapatmanız halinde Site&apos;nin bazı özellikleri düzgün çalışmayabilir.</p>

                <h6 class="mt-4">6. KİŞİSEL VERİ TOPLAMA YÖNTEMLERİ VE HUKUKİ SEBEPLER</h6>
                <p><strong>6.1.</strong> Kişisel verileriniz;</p>
                <ul>
                    <li>Site üzerinden doldurduğunuz üyelik formları,</li>
                    <li>Profil ve firma bilgisi alanları,</li>
                    <li>Bize gönderdiğiniz e-postalar ve iletişim formları,</li>
                    <li>Site kullanımınıza ilişkin log kayıtları, çerezler ve benzeri teknolojiler</li>
                </ul>
                <p>aracılığıyla elektronik ortamda toplanmaktadır.</p>
                <p><strong>6.2.</strong> Kişisel verileriniz, KVKK&apos;nın 5. ve 6. maddelerinde belirtilen şu hukuki sebeplerden bir veya birkaçına dayanılarak işlenmektedir:</p>
                <ul>
                    <li>Kanunlarda açıkça öngörülmesi,</li>
                    <li>Bir sözleşmenin kurulması veya ifasıyla doğrudan doğruya ilgili olması,</li>
                    <li>Veri sorumlusunun hukuki yükümlülüğünü yerine getirmesi için zorunlu olması,</li>
                    <li>Bir hakkın tesisi, kullanılması veya korunması için zorunlu olması,</li>
                    <li>Temel hak ve özgürlüklerinize zarar vermemek kaydıyla, veri sorumlusunun meşru menfaatleri için zorunlu olması,</li>
                    <li>Açık rızanızın bulunması.</li>
                </ul>

                <h6 class="mt-4">7. KİŞİSEL VERİLERİN SAKLANMA SÜRESİ</h6>
                <p><strong>7.1.</strong> Kişisel verileriniz, ilgili mevzuatta öngörülen veya işleme amaçları için gerekli olan süreler boyunca saklanır.</p>
                <p><strong>7.2.</strong> Üyelik süreniz boyunca hesabınız aktif kaldığı müddetçe, üyelik ve işlem verileriniz saklanmaya devam eder. Hesabınızı kapatmanız ve yasal saklama sürelerinin dolmasının ardından, kişisel verileriniz silinir, yok edilir veya anonim hâle getirilir.</p>
                <p><strong>7.3.</strong> Mali kayıtlar, fatura bilgileri ve muhasebe kayıtları, ilgili kanunlar uyarınca daha uzun süre (5–10 yıl) saklanabilir.</p>

                <h6 class="mt-4">8. KİŞİSEL VERİ GÜVENLİĞİ</h6>
                <p><strong>8.1.</strong> EvHayaliniz, kişisel verilerinizi yetkisiz erişim, kayıp, kötüye kullanım, değiştirilme veya ifşa edilme risklerine karşı korumak için gerekli teknik ve idari tedbirleri almaktadır.</p>
                <p><strong>8.2.</strong> Ancak internet ve dijital ortamların doğası gereği, hiçbir sistemin %100 güvenli olduğu garanti edilemez. Kullanıcı, Site&apos;yi kullanırken bu riski bildiğini kabul eder.</p>

                <h6 class="mt-4">9. KVKK KAPSAMINDA HAKLARINIZ</h6>
                <p>KVKK&apos;nın 11. maddesi uyarınca, veri sorumlusu olarak bize başvurarak;</p>
                <ul>
                    <li>Kişisel verinizin işlenip işlenmediğini öğrenme,</li>
                    <li>İşlenmişse buna ilişkin bilgi talep etme,</li>
                    <li>İşlenme amacını ve amaca uygun kullanılıp kullanılmadığını öğrenme,</li>
                    <li>Yurt içinde veya yurt dışında kişisel verilerin aktarıldığı üçüncü kişileri bilme,</li>
                    <li>Eksik veya yanlış işlenmişse düzeltilmesini isteme,</li>
                    <li>KVKK&apos;nın 7. maddesinde öngörülen şartlar çerçevesinde silinmesini veya yok edilmesini isteme,</li>
                    <li>Bu işlemlerin, aktarıldığı üçüncü kişilere bildirilmesini isteme,</li>
                    <li>İşlenen verilerin münhasıran otomatik sistemler vasıtasıyla analiz edilmesi suretiyle aleyhinize bir sonucun ortaya çıkmasına itiraz etme,</li>
                    <li>Kişisel verilerin kanuna aykırı olarak işlenmesi sebebiyle zarara uğramanız hâlinde zararın giderilmesini talep etme</li>
                </ul>
                <p>haklarına sahipsiniz.</p>

                <h6 class="mt-4">10. BAŞVURU YÖNTEMİ</h6>
                <p>KVKK kapsamındaki haklarınıza ilişkin taleplerinizi;</p>
                <ul>
                    <li>Yazılı olarak evhayaliniz@gmail.com posta yoluyla,</li>
                    <li>veya evha@hes01.kep.tr uzantılı kayıtlı elektronik posta (KEP) adresimiz üzerinden,</li>
                    <li>veya Site&apos;de yer alan iletişim formu/başvuru kanallarını kullanarak</li>
                </ul>
                <p>EvHayaliniz&apos;e iletebilirsiniz.</p>
                <p>Başvurularınız, KVKK ve ilgili mevzuat hükümleri çerçevesinde en kısa sürede ve en geç 30 gün içinde sonuçlandırılacaktır.</p>

                <h6 class="mt-4">11. GİZLİLİK POLİTİKASINDA DEĞİŞİKLİKLER</h6>
                <p>EvHayaliniz, işbu Gizlilik Politikası&apos;nı yasal değişiklikler ve hizmetlerindeki yenilikler doğrultusunda zaman zaman güncelleyebilir. Güncel politika her zaman Site üzerinde yayınlanacaktır.</p>
                <p>Gizlilik Politikası&apos;nda önemli bir değişiklik yapılması hâlinde, bu durum Site üzerinden duyurulabilir veya kayıtlı iletişim bilgileriniz üzerinden size bildirilebilir.</p>

                <h6 class="mt-4">12. İLETİŞİM</h6>
                <p>Bu Gizlilik Politikası ve kişisel verilerinizin işlenmesine ilişkin sorularınız için bizimle aşağıdaki iletişim kanalları üzerinden irtibata geçebilirsiniz:</p>
                <p><strong>Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi</strong><br>
                <strong>Adres:</strong> İstiklal Mah Özkılıç Sok. No 2A Ortaköy/Aksaray<br>
                <strong>E-posta:</strong> evhayaliniz@gmail.com<br>
                <strong>Telefon:</strong> +90 542 655 67 40</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>


@yield('js')

@stack('scripts')

@livewireScripts