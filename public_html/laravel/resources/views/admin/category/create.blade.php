@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Yeni Kategori Ekle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Kategori Adı</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Üst Kategori</label>
                    <select name="parent_id" class="form-control" onchange="imageArea()">
                        <option value="">Üst Kategorisiz</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori Sırası</label>
                    <input type="number" class="form-control" name="order" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Durum</label>
                    <select name="status" class="form-control">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                </div>
                <div class="mb-3 image-area">
                    <label class="form-label">Kategori Görseli</label>
                    <input type="file" class="form-control" name="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script>
        function imageArea() {
            let imageArea = document.querySelector('.image-area');
            let imageInput = imageArea.querySelector('input');

            if(event.target.value) {
                imageArea.classList.add('d-none');
                imageInput.removeAttribute('required');

            } else {
                imageArea.classList.remove('d-none');
                imageInput.setAttribute('required', '');
            }
        }
    </script>
@endsection
