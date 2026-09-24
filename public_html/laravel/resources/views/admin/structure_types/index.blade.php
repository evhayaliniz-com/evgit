@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Yapı Türleri</h5>
            <a href="{{ route('admin.structure-types.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Yapı Türü Ekle
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Yapı Türü</th>
                        <th>Oluşturulma</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($types as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.structure-types.edit', $type->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Düzenle
                                </a>

                                <form action="{{ route('admin.structure-types.destroy', $type->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu yapı türünü silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i> Sil
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Henüz yapı türü eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
