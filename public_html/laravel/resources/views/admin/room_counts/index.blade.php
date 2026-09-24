@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Oda Sayıları</h5>
            <a href="{{ route('admin.room-counts.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Oda Sayısı Ekle
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
                        <th>Oda Sayısı</th>
                        <th>Oluşturulma</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->id }}</td>
                            <td>{{ $room->label }}</td>
                            <td>{{ $room->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.room-counts.edit', $room->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Düzenle
                                </a>

                                <form action="{{ route('admin.room-counts.destroy', $room->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Bu oda sayısını silmek istediğinize emin misiniz?');">
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
                            <td colspan="4" class="text-center text-muted">Henüz oda sayısı eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
