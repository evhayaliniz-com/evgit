@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Slider Düzenle</h5>
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary">
                <i class="bx bx-list-ul"></i> Slider Listesi
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Slider Başlığı</label>
                    <input type="text" name="title" class="form-control" value="{{ $slider->title }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Açıklama</label>
                    <textarea name="description" class="form-control" rows="3">{{ $slider->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mevcut Görsel</label><br>
                    <img src="{{ asset($slider->image) }}" alt="Slider Görseli" width="200"
                         class="rounded shadow-sm mb-2">
                </div>

                <div class="mb-3">
                    <label class="form-label">Yeni Görsel (değiştirmek için)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Slider Linki</label>
                    <input type="text" name="button_link" class="form-control" value="{{ $slider->button_link }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sıra</label>
                        <input type="number" name="order" class="form-control" value="{{ $slider->order }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Durum</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status" value="1" class="form-check-input"
                                   id="status" {{ $slider->status ? 'checked' : '' }}>
                            <label for="status" class="form-check-label">Aktif</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save"></i> Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
