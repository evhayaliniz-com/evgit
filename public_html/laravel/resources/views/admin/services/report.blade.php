@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Hizmet Şikayetleri</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Hizmet ID - Başlık</th>
                        <th>Kullanıcı ID - Adı</th>
                        <th>Mesaj</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        @php
                            $user = auth_info($report?->user_id);
                            $serviceTitle = $report?->service?->title ?? 'Silinmiş Hizmet';
                            $userName = $user?->name ?? 'Silinmiş Kullanıcı';
                        @endphp
                        <tr>
                            <td>{{ $report->to_id . ' - ' . $serviceTitle }}</td>
                            <td>{{ $report->user_id . ' - ' . $userName }}</td>
                            <td>{{ $report->message }}</td>
                            <td>
                                @if(!$report->status)
                                    <span class="badge bg-label-danger">Aktif</span>
                                @else
                                    <span class="badge bg-label-info">Çözümlendi</span>
                                @endif
                            </td>
                            <td>
                                @if(!$report->status)
                                    <a href="{{ route('admin.services.reports.solved', $report->id) }}"
                                       class="btn btn-info"
                                       onclick="return confirm('Bu şikayeti çözüldü olarak işaretlemek istiyor musunuz?');">
                                        Çözüldü olarak güncelle
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Henüz şikayet oluşturulmamış.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {!! $reports->links() !!}
            </div>
        </div>
    </div>
@endsection
