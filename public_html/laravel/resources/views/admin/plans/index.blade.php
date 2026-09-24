@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">E-Planlar</h5>
            <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Plan Ekle
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
                        <th>Başlık</th>
                        <th>Yapı Türü</th>
                        <th>Yapı Sınıfı</th>
                        <th>Oda Sayısı</th>
                        <th>Net/Brüt</th>
                        <th>Durum</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($plans as $plan)
                        <tr>
                            <td>{{ $plan->title }}</td>
                            <td>{{ $plan->structureType->name ?? '-' }}</td>
                            <td>{{ $plan->structureClass->name ?? '-' }}</td>
                            <td>{{ $plan->roomCount->label ?? '-' }}</td>
                            <td>{{ $plan->net_area }} / {{ $plan->gross_area }}</td>
                            <td>
                                @if($plan->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Düzenle
                                </a>
                                <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu planı silmek istediğinize emin misiniz?');">
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
                            <td colspan="7" class="text-center text-muted">Henüz plan eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
