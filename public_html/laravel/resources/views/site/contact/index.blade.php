@extends('site.inc.master')

@section('css')
    <style>
        .contact-page-right li:after {
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="hakkimizda index-right iletisim">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hakkimizda-box">
                                <h1>Bizimle iletişime geçin!</h1>
                                <h2>
                                    Aklınızdaki tüm sorulara cevap bulmak ve tüm merak ettikleriniz için bizimle
                                    iletişime geçin.
                                </h2>
                                <div class="contact-page-form">
                                    <div class="contact-page-left">
                                        <form action="{{route('contact.store')}}" method="POST">
                                            <div class="contact-page-form-area">
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="text" name="name" required=""
                                                               value="{{old('name')}}">
                                                        <label>İsim Soyisim</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="email" name="email" required=""
                                                               value="{{old('email')}}">
                                                        <label>E-Posta</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <input type="number" name="phone_number" required=""
                                                               value="{{old('phone_number')}}">
                                                        <label>Telefon</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-field">
                                                        <textarea name="message" id="" placeholder="Mesaj"
                                                        >{{old('message')}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="margin: 30px 0 30px 0; text-align: center;">
                                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" style="display: inline-block;"></div>
                                                </div>

                                                @csrf
                                                <div class="form-group">
                                                    <button type="submit">Mesaj Gönder</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="contact-page-right">
                                        <ul>
                                            <li>
                                                <span>İşletme Adı:</span>
                                                <p class="mb-0">
                                                    {{$settings->site_name}}
                                                </p>
                                            </li>
                                            <li>
                                                <span>Ticaret Ünvanı:</span>
                                                <p class="mb-0">
                                                    {{$settings->site_title}}
                                                </p>
                                            </li>
                                            <li>
                                                <span>Ticaret Sicil No:</span>
                                                <p class="mb-0">
                                                    {{$settings->ticaret_sicil_no}}
                                                </p>
                                            </li>
                                            <li>
                                                <span>Kep Adresi:</span>
                                                <p class="mb-0">
                                                    {{$settings->kep_adres}}
                                                </p>
                                            </li>
                                            <li>
                                                <span>Mersis Numarası:</span>
                                                <p class="mb-0">
                                                    {{$settings->mersis_no}}
                                                </p>
                                            </li>
                                            <li>
                                                <span>Email:</span>
                                                <p class="mb-0">
                                                   info@evhayaliniz.com.tr
                                                </p>
                                            </li>

                                            <li>
                                                <span>Bize Ulaşın:</span>
                                                <p class="mb-0">{{$settings->whatsapp}}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection
