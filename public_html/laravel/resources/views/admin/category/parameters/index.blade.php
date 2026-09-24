@extends('admin.inc.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">{{ $category->name }} - Parametreler</h5>
            <small class="text-muted">Bu kategoriye ait parametreleri yönetebilirsiniz</small>
        </div>
        <div>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">
                <i class="bx bx-arrow-back"></i> Kategorilere Dön
            </a>
            <a href="{{ route('admin.categories.parameters.create', $category->id) }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Parametre Ekle
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($parameters->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sıra</th>
                            <th>Başlık</th>
                            <th>Tip</th>
                            <th>Zorunlu</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parameters as $parameter)
                            <tr>
                                <td>{{ $parameter->order }}</td>
                                <td>{{ $parameter->title }}</td>
                                <td>
                                    @if($parameter->type === 'input')
                                        <span class="badge bg-label-primary">Veri Girişi</span>
                                    @else
                                        <span class="badge bg-label-info">Selectbox</span>
                                    @endif
                                </td>
                                <td>
                                    @if($parameter->is_required)
                                        <span class="badge bg-label-success">Evet</span>
                                    @else
                                        <span class="badge bg-label-secondary">Hayır</span>
                                    @endif
                                </td>
                                <td>
                                    @if($parameter->status)
                                        <span class="badge bg-label-success">Aktif</span>
                                    @else
                                        <span class="badge bg-label-danger">Pasif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.categories.parameters.edit', [$category->id, $parameter->id]) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i> Düzenle
                                    </a>
                                    
                                    <form action="{{ route('admin.categories.parameters.destroy', [$category->id, $parameter->id]) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bu parametreyi silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i> Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                <h5 class="mt-2">Henüz parametre eklenmemiş</h5>
                <p class="text-muted">Bu kategoriye ait parametreler burada görünecek.</p>
                <a href="{{ route('admin.categories.parameters.create', $category->id) }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> İlk Parametreyi Ekle
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
