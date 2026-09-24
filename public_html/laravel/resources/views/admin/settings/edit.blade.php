@extends('admin.inc.master')

@section('css')
<style>
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .card {
        border: 1px solid #e3e6f0;
        box-shadow: 0 0 15px rgba(0,0,0,0.03);
    }
    .form-control {
        border-radius: 0.375rem;
        transition: border-color 0.2s ease-in-out;
    }
    .form-control:focus {
        border-color: #5a8dee;
        box-shadow: 0 0 0 0.15rem rgba(90, 141, 238, 0.25);
    }
    .btn-success {
        background-color: #28c76f;
        border-color: #28c76f;
        font-weight: 600;
        padding: 10px 25px;
    }
    .btn-success:hover {
        background-color: #20b463;
        border-color: #20b463;
    }
    .section-divider {
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed #dee2e6;
        font-weight: 600;
        color: #343a40;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bx bx-cog"></i> Site Ayarları</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="section-divider">Genel Bilgiler</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Site Adı</label>
                                <input type="text" class="form-control" name="site_name" value="{{ $setting->site_name }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Başlık</label>
                                <input type="text" class="form-control" name="site_title" value="{{ $setting->site_title }}">
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Ticaret Sicil No</label>
                                <input type="text" class="form-control" name="ticaret_sicil_no" value="{{ $setting->ticaret_sicil_no }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Kep Adres</label>
                                <input type="text" class="form-control" name="kep_adres" value="{{ $setting->kep_adres }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Mersis No</label>
                                <input type="text" class="form-control" name="mersis_no" value="{{ $setting->mersis_no }}">
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Açıklama</label>
                                <textarea class="form-control" name="site_description" rows="2">{{ $setting->site_description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Anahtar Kelimeler</label>
                                <input type="text" class="form-control" name="site_keywords" value="{{ $setting->site_keywords }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">Sosyal Medya</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="text" class="form-control" name="facebook" value="{{ $setting->facebook }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="text" class="form-control" name="instagram" value="{{ $setting->instagram }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">YouTube</label>
                                <input type="text" class="form-control" name="youtube" value="{{ $setting->youtube }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Twitter</label>
                                <input type="text" class="form-control" name="twitter" value="{{ $setting->twitter }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">LinkedIn</label>
                                <input type="text" class="form-control" name="linkedin" value="{{ $setting->linkedin }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">TikTok</label>
                                <input type="text" class="form-control" name="tiktok" value="{{ $setting->tiktok }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" name="whatsapp" value="{{ $setting->whatsapp }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefon</label>
                                <input type="text" class="form-control" name="phone" value="{{ $setting->phone }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-divider">Görseller & Bakım</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Logo</label><br>
                                @if($setting->logo)
                                    <img src="{{ asset($setting->logo) }}" alt="Logo" width="80" class="mb-2 rounded border">
                                @endif
                                <input type="file" class="form-control" name="logo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Mobil Logo</label><br>
                                @if($setting->mobile_logo)
                                    <img src="{{ asset($setting->mobile_logo) }}" alt="Mobil Logo" width="40" class="mb-2 rounded border">
                                @endif
                                <input type="file" class="form-control" name="mobile_logo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Favicon</label><br>
                                @if($setting->favicon)
                                    <img src="{{ asset($setting->favicon) }}" alt="Favicon" width="40" class="mb-2 rounded border">
                                @endif
                                <input type="file" class="form-control" name="favicon">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bakım Modu</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" {{ $setting->maintenance_mode ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">Aktif</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="bx bx-save"></i> Kaydet</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
