<tr class="category-row" data-target="children-{{ $category->id }}" data-level="{{ $level }}">
    <td>
        <div class="d-flex align-items-center">
            @if($category->image)
                <img src="{{ asset($category->image) }}"
                     alt="Kategori Görseli"
                     class="rounded shadow-sm me-2"
                     style="width: 40px; height: 40px; object-fit: cover;">
            @else
                <div class="bg-light border rounded me-2" style="width: 40px; height: 40px;"></div>
            @endif

            @if($category->children->count())
                <span class="toggle-category me-2"><i class="bx bx-chevron-down"></i></span>
            @else
                <span class="toggle-category me-2" style="visibility: hidden;">&nbsp;</span>
            @endif

            {{ $category->name }}
        </div>
    </td>
    <td>{{ $category->order }}</td>
    <td>
        @if($category->status)
            <span class="badge bg-label-success">Aktif</span>
        @else
            <span class="badge bg-label-danger">Pasif</span>
        @endif
    </td>
    <td>
        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
            <i class="bx bx-edit"></i> Düzenle
        </a>
        
        @if(!$category->parent_id)
            <a href="{{ route('admin.categories.parameters.index', $category->id) }}" class="btn btn-sm btn-info">
                <i class="bx bx-cog"></i> Parametreler
            </a>
        @endif
    
        <form action="{{ route('admin.categories.destroy', $category->id) }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bx bx-trash"></i> Sil
            </button>
        </form>
    </td>
    
</tr>

@if($category->children->count())
    <tbody id="children-{{ $category->id }}" class="category-children" style="display: none;">
        @foreach($category->children as $child)
            @include('admin.category.partials.category_row', ['category' => $child, 'level' => $level + 1])
        @endforeach
    </tbody>
@endif
