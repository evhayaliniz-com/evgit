@extends('admin.inc.master')

@section('css')
    <!-- Ek CSS gerekirse buraya ekleyin -->
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Kısa Yollar Kartları --}}
        <div class="row g-3 mb-4">
            @php
                $shortcuts = [
                  ['label'=>'Ayarlar','icon'=>'bx-cog','route'=>'admin.settings.edit','class'=>'bg-info'],
                  ['label'=>'Kategoriler','icon'=>'bx-menu','route'=>'admin.categories.index','class'=>'bg-primary'],
                  ['label'=>'Sayfalar','icon'=>'bx-square-rounded','route'=>'admin.pages.index','class'=>'bg-secondary'],
                  ['label'=>'Slider','icon'=>'bx-image','route'=>'admin.sliders.index','class'=>'bg-warning'],
                  ['label'=>'Hakkımızda','icon'=>'bx-user-badge','route'=>'admin.about.index','class'=>'bg-success'],
                  ['label'=>'Firmalar','icon'=>'bx-building','route'=>'admin.companies.index','class'=>'bg-dark'],
                  ['label'=>'Hizmetler','icon'=>'bx-briefcase','route'=>'admin.services.index','class'=>'bg-primary'],
                  ['label'=>'Fikirler','icon'=>'bx-lightbulb','route'=>'admin.ideas.index','class'=>'bg-warning'],
                  ['label'=>'Paketler','icon'=>'bx-box','route'=>'admin.packages.index','class'=>'bg-info'],
                  ['label'=>'Ödemeler','icon'=>'bx-credit-card','route'=>'admin.payments.index','class'=>'bg-danger'],
                  ['label'=>'İletişim','icon'=>'bx-envelope','route'=>'admin.contacts.index','class'=>'bg-success'],
                ];
            @endphp
            @foreach($shortcuts as $item)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route($item['route']) }}" class="text-decoration-none">
                        <div class="card text-white {{ $item['class'] }} h-100">
                            <div class="card-body text-center">
                                <i class="bx {{ $item['icon'] }} fs-2 mb-2"></i>
                                <h6 class="card-title mb-0">{{ $item['label'] }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Özet Kartları --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="bx bx-building fs-1 text-primary me-3"></i>
                        <div>
                            <small>Toplam Firmalar</small>
                            <h3 class="mb-0">{{ $companiesCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="bx bx-briefcase fs-1 text-success me-3"></i>
                        <div>
                            <small>Toplam Hizmetler</small>
                            <h3 class="mb-0">{{ $servicesCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="bx bx-lightbulb fs-1 text-warning me-3"></i>
                        <div>
                            <small>Toplam Fikirler</small>
                            <h3 class="mb-0">{{ $ideasCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafikler --}}
        <div class="row mb-4">
            <div class="col-lg-8 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white">Aylık Firma Kayıt Trendleri</div>
                    <div class="card-body">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white">İçerik Dağılımı</div>
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Son Kayıtlar Tabloları --}}
        <div class="row">
            <div class="col-lg-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span>Son Firmalar</span>
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-sm btn-outline-primary">Tümü</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>#</th><th>Firma</th><th>Tarih</th><th>İşlem</th></tr></thead>
                            <tbody>
                            @foreach($recentCompanies as $company)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->created_at->format('d.m.Y') }}</td>
                                    <td><a href="{{ route('admin.companies.index') }}?id={{ $company->id }}" class="btn btn-sm btn-primary">Detay</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span>Son Hizmetler</span>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-primary">Tümü</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>#</th><th>Başlık</th><th>Tarih</th><th>İşlem</th></tr></thead>
                            <tbody>
                            @foreach($recentServices as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->title }}</td>
                                    <td>{{ $service->created_at->format('d.m.Y') }}</td>
                                    <td><a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-primary">Detay</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span>Son Fikirler</span>
                        <a href="{{ route('admin.ideas.index') }}" class="btn btn-sm btn-outline-primary">Tümü</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>#</th><th>Özet</th><th>Tarih</th><th>İşlem</th></tr></thead>
                            <tbody>
                            @foreach($recentIdeas as $idea)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($idea->content, 30) }}</td>
                                    <td>{{ $idea->created_at->format('d.m.Y') }}</td>
                                    <td><a href="{{ route('admin.ideas.comments', $idea->id) }}" class="btn btn-sm btn-primary">Detay</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Trend Chart
        new Chart(document.getElementById('trendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [{ label: 'Firma Kayıtları', data: {!! json_encode($trendData) !!}, borderColor: '#0d6efd', tension: 0.4, fill: false }]
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Firmalar','Hizmetler','Fikirler'],
                datasets: [{ data: [{{ $companiesCount }},{{ $servicesCount }},{{ $ideasCount }}], backgroundColor: ['#0d6efd','#198754','#ffc107'] }]
            }
        });
    </script>
@endsection
