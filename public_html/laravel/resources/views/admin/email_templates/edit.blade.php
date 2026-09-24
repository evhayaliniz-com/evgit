@extends('admin.inc.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Email Şablonunu Güncelle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.email-templates.update', $template->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="key" class="form-label">Kod (key)</label>
                    <input type="text" name="key" id="key" class="form-control" value="{{ old('key', $template->key) }}" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Başlık</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', $template->subject) }}" required>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Hedef Roller</label>
                    <select name="roles[]" id="roles" class="form-select select2" multiple required>
                        <option value="user" {{ in_array('user', json_decode($template->roles ?? '[]')) ? 'selected' : '' }}>User</option>
                        <option value="company" {{ in_array('company', json_decode($template->roles ?? '[]')) ? 'selected' : '' }}>Company</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ $template->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $template->status == 0 ? 'selected' : '' }}>Pasif</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea name="content" id="content" rows="6" class="form-control" required>{{ old('content', $template->content) }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">Geri Dön</a>
                    <button type="submit" class="btn btn-success">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Hedef rolleri seçin",
                allowClear: true
            });
        });
    </script>
@endsection
