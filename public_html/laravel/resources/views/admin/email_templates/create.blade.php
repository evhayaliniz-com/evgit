@extends('admin.inc.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Yeni Email Şablonu Ekle</h5>
            <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Geri Dön
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Hata!</strong> Lütfen aşağıdaki alanları kontrol edin:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.email-templates.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="key" class="form-label">Şablon Kodu</label>
                    <input type="text" name="key" id="key" class="form-control" value="{{ old('key') }}" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Email Konusu</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Hedef Roller</label>
                    <select name="roles[]" id="roles" class="form-select select2" multiple required>
                        <option value="user" {{ in_array('user', old('roles', [])) ? 'selected' : '' }}>Bireysel Kullanıcı</option>
                        <option value="company" {{ in_array('company', old('roles', [])) ? 'selected' : '' }}>Firma Kullanıcısı</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Email İçeriği</label>
                    <textarea name="content" id="content" rows="8" class="form-control" required>{{ old('content') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Pasif</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                placeholder: "Rolleri Seçin"
            });
        });
    </script>
@endsection
