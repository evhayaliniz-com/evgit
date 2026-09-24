@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Yeni Yapı Türü Ekle</h5>
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

            <form action="{{ route('admin.structure-types.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Yapı Türü Adı</label>
                    <input type="text" name="name" class="form-control" id="name"
                           placeholder="Örnek: Daire, Villa, Apartman"
                           value="{{ old('name') }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.structure-types.index') }}" class="btn btn-secondary me-2">Geri Dön</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
