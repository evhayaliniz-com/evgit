@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Yeni Oda Sayısı Ekle</h5>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Hata!</strong> Lütfen aşağıdaki alanları kontrol ediniz:<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.room-counts.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="label" class="form-label">Oda Sayısı</label>
                    <input type="text" name="label" class="form-control" id="label"
                           placeholder="Örnek: 1+1, 2+1, 4+2"
                           value="{{ old('label') }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.room-counts.index') }}" class="btn btn-secondary me-2">Geri Dön</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
