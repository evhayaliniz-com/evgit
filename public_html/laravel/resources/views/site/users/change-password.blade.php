@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="hakkimizda index-right fikir-olustur">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hakkimizda-box fikir-olustur-box mx-auto">
                                <h1>
                                    Şifre Değiştir
                                </h1>

                                <form action="{{route('user.password.update')}}" method="POST">
                                    @method('PUT')

                                    <x-input-error-site />

                                    <div class="vision-mission-box fikir-olustur-box">
                                        <div class="fikir-olustur-top p-3">
                                            <div class="form-group mb-3">
                                                <div class="input-field">
                                                    <input id="input_box1" type="password" name="current_password"
                                                           minlength="8" required="">
                                                    <label>Eski Şifre</label>
                                                    <span toggle="#input_box1"
                                                          class="fa fa-fw field-icon toggle-password fa-eye"></span>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="input-field">
                                                    <input id="input_box2" type="password" name="new_password"
                                                           minlength="8" required="">
                                                    <label>Yeni Şifre</label>
                                                    <span toggle="#input_box2"
                                                          class="fa fa-fw field-icon toggle-password fa-eye"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-field">
                                                    <input id="input_box3" type="password"
                                                           name="new_password_confirmation"
                                                           minlength="8" required="">
                                                    <label>Yeni Şifre Tekrar</label>
                                                    <span toggle="#input_box3"
                                                          class="fa fa-fw field-icon toggle-password fa-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @csrf
                                    <div class="fikir-olustur-bottom">
                                        <button type="submit">Güncelle</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
