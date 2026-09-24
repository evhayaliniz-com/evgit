@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Yeni Sayfa Ekle</h5>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">
                <i class="bx bx-list-ul"></i> Sayfa Listesi
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Sayfa Başlığı</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">İçerik</label>
                    <textarea name="content" id="editor" class="form-control" rows="6"></textarea>
                </div>

                {{--            <div class="row">--}}
                {{--                <div class="col-md-6 mb-3">--}}
                {{--                    <label class="form-label">Sıra</label>--}}
                {{--                    <input type="number" name="order" class="form-control" value="0" min="0">--}}
                {{--                </div>--}}

                {{--                <div class="col-md-6 mb-3">--}}
                <label class="form-label">Durum</label>
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" value="1" class="form-check-input" id="status" checked>
                    <label for="status" class="form-check-label">Aktif</label>
                </div>
                {{--                </div>--}}
                {{--            </div>--}}

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')

@endsection
