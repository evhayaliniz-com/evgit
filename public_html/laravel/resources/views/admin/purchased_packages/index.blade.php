@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Satın Alınan Paketler</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Firma Adı</th>
                        <th>Alınan Paket</th>
                        <th>Paket Kategorisi</th>
                        <th>Ücret</th>
                        <th>Satın Alma Tarihi</th>
                        <th>Süre Tipi</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Kullanılan / Kalan Hak</th>
                        <th>Durum</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($purchasedPackages as $package)
                        <tr>
                            <td>{{ $package?->company ? $package?->company_id . ' - ' .$package?->company?->name
                                    : 'Silinmiş Hesap' }}</td>
                            <td>{{ $package?->package?->title }}</td>
                            <td>{{ $package?->category?->name }}</td>
                            <td>{{ $package?->price }} TL</td>
                            <td>
                                {{ \Carbon\Carbon::parse($package->created_at)->tz('Europe/Istanbul')->format('d.m.Y') }}
                            </td>
                            <td>{{ $package->type == 'monthly' ? 'Aylık' : 'Yıllık' }}</td>
                            <td>{{ \Carbon\Carbon::parse($package->start_date)->tz('Europe/Istanbul')->format('d.m.Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($package->end_date)->tz('Europe/Istanbul')->format('d.m.Y') }}</td>
                            <td>{{ $package->used_rights .'/'. $package->total_rights}}</td>
                            <td>
                                @if($package->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Henüz paket eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>


            {{$purchasedPackages->links()}}
        </div>
    </div>
@endsection
