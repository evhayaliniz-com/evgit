@extends('admin.inc.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $category->name }} - Parametre Düzenle</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.parameters.update', [$category->id, $parameter->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Başlık <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $parameter->title) }}" required>
                        <small class="form-text text-muted">Örn: Metrekare, Oda Sayısı, Bina Yaşı</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tip <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" id="parameterType" required onchange="toggleOptions()">
                            <option value="">Seçiniz</option>
                            <option value="input" {{ old('type', $parameter->type) === 'input' ? 'selected' : '' }}>Veri Girişi (Input)</option>
                            <option value="select" {{ old('type', $parameter->type) === 'select' ? 'selected' : '' }}>Selectbox (Veri Seçme)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sıra</label>
                        <input type="number" class="form-control" name="order" value="{{ old('order', $parameter->order) }}" min="0">
                        <small class="form-text text-muted">Parametrelerin görüntülenme sırası</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_required" name="is_required" value="1" {{ old('is_required', $parameter->is_required) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">Zorunlu mu?</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="optionsContainer" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Seçenekler</label>
                    <div id="optionsList">
                        @php
                            $options = old('options', $parameter->options ?? []);
                        @endphp
                        @if($options && count($options) > 0)
                            @foreach($options as $option)
                                <div class="input-group mb-2 option-row">
                                    <input type="text" class="form-control" name="options[]" value="{{ $option }}" placeholder="Seçenek girin">
                                    <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="input-group mb-2 option-row">
                                <input type="text" class="form-control" name="options[]" placeholder="Seçenek girin">
                                <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addOption()">
                        <i class="bx bx-plus"></i> Seçenek Ekle
                    </button>
                    <small class="form-text text-muted d-block mt-1">Selectbox için seçenekleri ekleyin</small>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $parameter->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Aktif</label>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Güncelle</button>
                <a href="{{ route('admin.categories.parameters.index', $category->id) }}" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
function toggleOptions() {
    const type = document.getElementById('parameterType').value;
    const container = document.getElementById('optionsContainer');
    
    if (type === 'select') {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
}

function addOption() {
    const optionsList = document.getElementById('optionsList');
    const newOption = document.createElement('div');
    newOption.className = 'input-group mb-2 option-row';
    newOption.innerHTML = `
        <input type="text" class="form-control" name="options[]" placeholder="Seçenek girin">
        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
            <i class="bx bx-trash"></i>
        </button>
    `;
    optionsList.appendChild(newOption);
}

function removeOption(button) {
    const optionsList = document.getElementById('optionsList');
    if (optionsList.children.length > 1) {
        button.closest('.option-row').remove();
    }
}

// Sayfa yüklendiğinde tip kontrolü yap
document.addEventListener('DOMContentLoaded', function() {
    toggleOptions();
});
</script>
@endsection
