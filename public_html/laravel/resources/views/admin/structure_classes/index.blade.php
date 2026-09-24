@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Yapı Sınıfları</h5>
            <a href="{{ route('admin.structure-classes.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Yapı Sınıfı Ekle
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
                        <th>Yapı Sınıfı</th>
                        <th>Oluşturulma</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td>{{ $class->name }}</td>
                            <td>{{ $class->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.structure-classes.edit', $class->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Düzenle
                                </a>

                                <form action="{{ route('admin.structure-classes.destroy', $class->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu yapı sınıfını silmek istediğinize emin misiniz?');">
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
                            <td colspan="4" class="text-center text-muted">Henüz yapı sınıfı eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
