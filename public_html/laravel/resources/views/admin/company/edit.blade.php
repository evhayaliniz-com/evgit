@extends('admin.inc.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Kategori Düzenle</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Kategori Adı</label>
                <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Üst Kategori</label>
                <select name="parent_id" class="form-control">
                    <option value="">Üst Kategorisiz</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @if($category->parent_id == $cat->id) selected @endif>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori Sırası</label>
                <input type="number" class="form-control" name="order" value="{{ $category->order }}" required>
            </div>
            <!-- Status (Aktif / Pasif) -->
            <div class="mb-3">
                <label class="form-label">Durum</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ $category->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Aktif</label>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Güncelle</button>
        </form>
    </div>
</div>
@endsection
