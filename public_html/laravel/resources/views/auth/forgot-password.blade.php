@extends('site.inc.master')

@section('css')
    <style>
        .main.sidebar {
            padding-left: 0;
        }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right d-flex align-items-center justify-content-center" style="height: 90vh">
                <form action="/forgot-password" method="POST" class="col-12 col-md-8 col-lg-5">
                    <x-input-error-site/>

                    @if (session('status'))
                        <x-input-success-site :msg="session('status')"/>
                    @endif

                    <div class="h-100">
                        <div class="bg-white p-3 rounded forgot-password-card">
                            <b class="mb-4 d-block" style="color: #575e66">Sisteme kayıtlı olan e-posta adresiniz.</b>
                            <div class="pdf-form-inputs d-flex login-modal-box full-width">
                                <div class="form-group required full-width">
                                    <div class="input-field">
                                        <input type="email" name="email" value="{{old('email')}}" required>
                                        <label>E-posta Adresi</label>
                                    </div>
                                </div>
                            </div>

                            @csrf
                            <div class="profili-duzenle-save">
                                <button type="submit">Gönder</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection