@extends('site.inc.master')

@section('css')
<style>
    .subscriptions-page {
        padding: 20px 0;
        min-height: calc(100vh - 200px);
    }

    .subscriptions-header {
        margin-bottom: 30px;
    }

    .back-link {
        color: #4068e2;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .back-link:hover {
        color: #2d4fa8;
    }

    .subscriptions-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .subscriptions-description {
        color: #666;
        font-size: 16px;
        line-height: 1.6;
    }

    .package-section {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    /* Otomatik Yenileme Card Animasyonu */
    .auto-renew-card {
        transition: all 0.3s ease;
    }

    .auto-renew-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    /* Switch Animasyonu */
    #autoRenewSwitch {
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    #autoRenewSwitch:hover {
        transform: scale(1.05);
    }

    /* Gradient Animasyonu */
    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .gradient-animated {
        background-size: 200% 200%;
        animation: gradientShift 8s ease infinite;
    }

    /* Icon Pulse Animasyonu */
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    .icon-pulse {
        animation: pulse 2s ease-in-out infinite;
    }

    .package-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
    }

    .package-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .package-title {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .package-status {
        background: #10b981;
        color: #fff;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .package-details {
        margin-bottom: 20px;
    }

    .package-detail-item {
        margin-bottom: 10px;
        color: #666;
        font-size: 15px;
    }

    .package-detail-item strong {
        color: #1a1a1a;
        margin-right: 5px;
    }

    .package-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .package-btn {
        background: #4068e2;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .package-btn:hover {
        background: #2d4fa8;
        color: #fff;
    }

    .package-btn-cancel {
        background: #dc2626;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .package-btn-cancel:hover {
        background: #b91c1c;
        color: #fff;
    }

    .cancel-subscription-btn {
        background: #dc2626;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        margin-top: 15px;
    }

    .cancel-subscription-btn:hover {
        background: #b91c1c;
        color: #fff;
    }

    .expired-package-item {
        padding: 15px;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 10px;
        color: #666;
        border-left: 3px solid #e5e7eb;
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        padding: 20px 25px;
    }

    .modal-title {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #666;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .current-package-box {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .current-package-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    .current-package-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .current-package-detail {
        color: #666;
        font-size: 14px;
    }

    .current-package-detail strong {
        color: #1a1a1a;
        display: block;
        margin-bottom: 5px;
    }

    .current-package-note {
        color: #666;
        font-size: 14px;
        font-style: italic;
        margin-top: 10px;
    }

    .upgrade-packages-tabs {
        margin-bottom: 20px;
    }

    .upgrade-packages-tabs .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
    }

    .upgrade-packages-tabs .nav-link {
        color: #666;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 12px 20px;
        font-weight: 600;
    }

    .upgrade-packages-tabs .nav-link.active {
        color: #4068e2;
        border-bottom-color: #4068e2;
        background: transparent;
    }

    .upgrade-package-option {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .upgrade-package-option:hover {
        border-color: #4068e2;
        background: #f0f4ff;
    }

    .upgrade-package-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .upgrade-package-option input[type="radio"]:checked~.package-option-content {
        border-color: #4068e2;
    }

    .upgrade-package-option:has(input[type="radio"]:checked) {
        border-color: #4068e2;
        background: #f0f4ff;
    }

    .package-option-content {
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .package-option-radio {
        margin-top: 5px;
        width: 20px;
        height: 20px;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        position: relative;
        flex-shrink: 0;
    }

    .upgrade-package-option input[type="radio"]:checked~.package-option-content .package-option-radio {
        border-color: #4068e2;
    }

    .upgrade-package-option input[type="radio"]:checked~.package-option-content .package-option-radio::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        background: #4068e2;
        border-radius: 50%;
    }

    .package-option-info {
        flex: 1;
    }

    .package-option-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .package-option-description {
        color: #666;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .package-option-features {
        list-style: none;
        padding: 0;
        margin: 10px 0 0 0;
    }

    .package-option-features li {
        padding: 5px 0;
        color: #666;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .package-option-features li i {
        color: #10b981;
        font-size: 12px;
    }

    .upgrade-logic-box {
        background: #f9fafb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .upgrade-logic-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    .upgrade-logic-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .upgrade-logic-list li {
        padding: 8px 0;
        color: #666;
        font-size: 14px;
        position: relative;
        padding-left: 20px;
    }

    .upgrade-logic-list li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #4068e2;
        font-weight: bold;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .subscriptions-title {
            font-size: 24px;
        }

        .package-card {
            padding: 20px;
        }

        .package-header {
            flex-direction: column;
            gap: 15px;
        }

        .package-actions {
            flex-direction: column;
        }

        .package-btn {
            width: 100%;
            text-align: center;
        }

        .package-btn-cancel {
            width: 100%;
            text-align: center;
        }

        .upgrade-package-option {
            padding: 15px;
        }

        .package-option-content {
            flex-direction: row;
            gap: 12px;
        }

        .current-package-details {
            grid-template-columns: 1fr;
        }

        .modal-dialog {
            margin: 10px;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-body {
            padding: 20px 15px;
        }

        .upgrade-packages-tabs .nav-link {
            padding: 10px 15px;
            font-size: 14px;
        }

        .current-package-box {
            padding: 15px;
        }

        .upgrade-logic-box {
            padding: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="main sidebar">
    <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
        <div class="index-right">
            <div class="subscriptions-page">
                <div class="subscriptions-header">
                    <a href="{{ route('company.dashboard') }}" class="back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        Profile Dön
                    </a>
                    <h1 class="subscriptions-title">Paketlerim</h1>
                    <p class="subscriptions-description">
                        Burada satın aldığınız paket ve ek paketleri görebilir, kullanım sürenizi takip edebilir ve ihtiyaç halinde paketlerinizi yükseltebilirsiniz.
                    </p>
                </div>

                <!-- Aktif Ana Paketler -->
                @if($activeMainPackages->count() > 0)
                <div class="package-section">
                    <h2 class="section-title">Paketlerim</h2>
                    @foreach($activeMainPackages as $package)
                    <div class="package-card">
                        <div class="package-header">
                            <h3 class="package-title">{{ $package->package->title ?? 'Paket' }}</h3>
                            <span class="package-status">Aktif</span>
                        </div>
                        <div class="package-details">
                            <div class="package-detail-item">
                                <strong>Başlangıç Tarihi:</strong> {{ \Carbon\Carbon::parse($package->start_date)->format('d.m.Y') }}
                            </div>
                            <div class="package-detail-item">
                                <strong>Bitiş Tarihi:</strong> {{ \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') }}
                            </div>
                            @if($package->end_date > now())
                            <div class="package-detail-item">
                                <strong>Kalan Süre:</strong> {{ ceil(now()->floatDiffInDays($package->end_date)) }} Gün
                            </div>
                            @endif
                        </div>
                        <div class="package-actions">
                            <button type="button" class="package-btn" data-bs-toggle="modal" data-bs-target="#packageDetailsModal{{ $package->id }}">
                                Paket Detayları
                            </button>
                            <button type="button" class="package-btn" data-bs-toggle="modal" data-bs-target="#packageRenewModal{{ $package->id }}">
                                Paket Yenile
                            </button>
                            <button type="button" class="package-btn" data-bs-toggle="modal" data-bs-target="#packageUpgradeModal{{ $package->id }}">
                                Paket Yükselt
                            </button>
                            <button type="button" class="package-btn-cancel" data-bs-toggle="modal" data-bs-target="#packageCancelModal{{ $package->id }}">
                                Paketi İptal Et
                            </button>
                        </div>
                    </div>

                    <!-- Paket Detayları Modal -->
                    <div class="modal fade" id="packageDetailsModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Paket Detayları</h5>
                                    <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $package->package->title ?? 'Paket' }}</strong> - {{ $package->category->name ?? 'Kategori' }} - {{ $package->total_rights }} Hizmet - {{ $package->type == 'yearly' ? '1 Yıl' : '1 Ay' }}</p>
                                    <p><strong>Kalan {{ $package->remaining_rights }} Hizmet</strong></p>
                                    <p><strong>Başlangıç Tarihi:</strong> {{ \Carbon\Carbon::parse($package->start_date)->format('d.m.Y') }}</p>
                                    <p><strong>Bitiş Tarihi:</strong> {{ \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paket Yenile Modal -->
                    <div class="modal fade" id="packageRenewModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Paket Yenile</h5>
                                    <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>{{ $package->package->title ?? 'Paket' }}</strong> - {{ $package->category->name ?? 'Kategori' }} - {{ $package->total_rights }} Hizmet</p>
                                    <p><strong>{{ $package->package->title ?? 'Paket' }}</strong> - {{ $package->category->name ?? 'Kategori' }} - {{ $package->total_rights }} Hizmet - {{ $package->type == 'yearly' ? '1 Yıl' : '1 Ay' }}</p>
                                    <form action="{{ route('company.packages.add') }}" method="POST" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="package_id" value="{{ $package->pro_package_id }}">
                                        <input type="hidden" name="package_type" value="{{ $package->type == 'yearly' ? '1' : '2' }}">
                                        <input type="hidden" name="categories[]" value="{{ $package->category_id }}">
                                        <button type="submit" class="package-btn w-100">
                                            Ek {{ $package->type == 'yearly' ? '1 Yıl (365 Gün)' : '1 Ay (30 Gün)' }} Uzat
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paket Yükselt Modal -->
                    <div class="modal fade" id="packageUpgradeModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Paket Yükselt</h5>
                                    <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Mevcut Paketiniz -->
                                    <div class="current-package-box">
                                        <div class="current-package-title">Mevcut Paketiniz</div>
                                        <div class="current-package-details">
                                            <div class="current-package-detail">
                                                <strong>{{ $package->package->title ?? 'Paket' }}</strong>
                                            </div>
                                            <div class="current-package-detail">
                                                <strong>Başlangıç Tarihi</strong>
                                                {{ \Carbon\Carbon::parse($package->start_date)->format('d.m.Y') }}
                                            </div>
                                            <div class="current-package-detail">
                                                <strong>Bitiş Tarihi</strong>
                                                {{ \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') }}
                                            </div>
                                            <div class="current-package-detail">
                                                <strong>Kalan Süre</strong>
                                                {{ ceil(now()->floatDiffInDays($package->end_date)) }} Gün
                                            </div>
                                        </div>
                                        <p class="current-package-note">
                                            Yükseltme yaptığınızda kalan süreniz yeni pakete otomatik olarak aktarılır.
                                        </p>
                                    </div>

                                    <!-- Yükseltilebilecek Paketler -->
                                    <div class="mb-4">
                                        <h6 class="mb-3" style="font-size: 18px; font-weight: 700; color: #1a1a1a;">Yükseltilebilecek Paketler</h6>
                                        <div class="upgrade-packages-tabs">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="monthly-tab-{{ $package->id }}" data-bs-toggle="tab" data-bs-target="#monthly-{{ $package->id }}" type="button" role="tab">Aylık</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="yearly-tab-{{ $package->id }}" data-bs-toggle="tab" data-bs-target="#yearly-{{ $package->id }}" type="button" role="tab">Yıllık</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="monthly-{{ $package->id }}" role="tabpanel">
                                                @foreach($availablePackages as $availablePackage)
                                                @if($availablePackage->id > $package->pro_package_id)
                                                @php
                                                $prices = $packagePrices[$availablePackage->id] ?? null;
                                                @endphp
                                                <label class="upgrade-package-option">
                                                    <input type="radio" name="upgrade_package_{{ $package->id }}" value="{{ $availablePackage->id }}" data-type="monthly" data-package-name="{{ $availablePackage->title }}">
                                                    <div class="package-option-content">
                                                        <div class="package-option-radio"></div>
                                                        <div class="package-option-info">
                                                            <div class="package-option-title">{{ $availablePackage->title }}</div>
                                                            @if($availablePackage->description)
                                                            <div class="package-option-description">{{ $availablePackage->description }}</div>
                                                            @endif
                                                            @if($availablePackage->informations)
                                                            <ul class="package-option-features">
                                                                @foreach(json_decode($availablePackage->informations) as $info)
                                                                <li><i class="fa-solid fa-check"></i> {{ $info }}</li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                                @endif
                                                @endforeach
                                            </div>
                                            <div class="tab-pane fade" id="yearly-{{ $package->id }}" role="tabpanel">
                                                @foreach($availablePackages as $availablePackage)
                                                @if($availablePackage->id > $package->pro_package_id)
                                                @php
                                                $prices = $packagePrices[$availablePackage->id] ?? null;
                                                @endphp
                                                <label class="upgrade-package-option">
                                                    <input type="radio" name="upgrade_package_{{ $package->id }}" value="{{ $availablePackage->id }}" data-type="yearly" data-package-name="{{ $availablePackage->title }}">
                                                    <div class="package-option-content">
                                                        <div class="package-option-radio"></div>
                                                        <div class="package-option-info">
                                                            <div class="package-option-title">{{ $availablePackage->title }}</div>
                                                            @if($availablePackage->description)
                                                            <div class="package-option-description">{{ $availablePackage->description }}</div>
                                                            @endif
                                                            @if($availablePackage->informations)
                                                            <ul class="package-option-features">
                                                                @foreach(json_decode($availablePackage->informations) as $info)
                                                                <li><i class="fa-solid fa-check"></i> {{ $info }}</li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Yükseltme Mantığı -->
                                    <div class="upgrade-logic-box">
                                        <div class="upgrade-logic-title">Yükseltme Mantığı</div>
                                        <ul class="upgrade-logic-list">
                                            <li>Yükseltme sonrasında kalan süre yeni pakete aktarılır.</li>
                                            <li>Ödeme farkı, mevcut paketiniz ile seçtiğiniz paket arasındaki ücret farkına göre hesaplanır.</li>
                                            <li>Hemen ödeme yaptıktan sonra yeni paketiniz anında aktif olur.</li>
                                        </ul>
                                    </div>

                                    <form action="{{ route('company.packages.add') }}" method="POST" id="upgradeForm{{ $package->id }}">
                                        @csrf
                                        <input type="hidden" name="package_id" id="upgrade_package_id{{ $package->id }}">
                                        <input type="hidden" name="package_type" id="upgrade_package_type{{ $package->id }}">
                                        <input type="hidden" name="categories[]" value="{{ $package->category_id }}">
                                        <button type="submit" class="package-btn w-100" id="upgradeBtn{{ $package->id }}" disabled>
                                            Pakete Yükselt
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paket İptali Modal -->
                    <div class="modal fade" id="packageCancelModal{{ $package->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Paket İptali</h5>
                                    <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p style="color: #666; font-size: 15px; line-height: 1.6;">
                                        Aboneliğiniz kapsamında tanımlı haklarınız <strong>{{ \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') }}</strong> tarihine kadar aktif kalacaktır.
                                    </p>
                                    <p style="color: #666; font-size: 14px; margin-top: 15px;">
                                        Otomatik yenileme durdurulacak ve paket süreniz dolduğunda yenilenmeyecektir.
                                    </p>
                                    <form action="{{ route('company.packages.cancel', $package->id) }}" method="POST" id="cancelForm{{ $package->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cancel-subscription-btn">
                                            Aboneliğimi Sonlandır
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const modal = document.getElementById('packageUpgradeModal{{ $package->id }}');
                            if (!modal) return;

                            const form = document.getElementById('upgradeForm{{ $package->id }}');
                            const packageIdInput = document.getElementById('upgrade_package_id{{ $package->id }}');
                            const packageTypeInput = document.getElementById('upgrade_package_type{{ $package->id }}');
                            const upgradeBtn = document.getElementById('upgradeBtn{{ $package->id }}');
                            const radioButtons = modal.querySelectorAll('input[name="upgrade_package_{{ $package->id }}"]');

                            radioButtons.forEach(radio => {
                                radio.addEventListener('change', function() {
                                    if (this.checked) {
                                        packageIdInput.value = this.value;
                                        packageTypeInput.value = this.dataset.type === 'yearly' ? '1' : '2';
                                        upgradeBtn.disabled = false;

                                        // Get package name from the selected option
                                        const packageName = this.dataset.packageName || 'Paket';
                                        upgradeBtn.textContent = packageName + 'e Yükselt';
                                    }
                                });
                            });

                            // Tab değiştiğinde seçili paketi sıfırla
                            const monthlyTab = document.getElementById('monthly-tab-{{ $package->id }}');
                            const yearlyTab = document.getElementById('yearly-tab-{{ $package->id }}');

                            if (monthlyTab) {
                                monthlyTab.addEventListener('shown.bs.tab', function() {
                                    radioButtons.forEach(radio => radio.checked = false);
                                    upgradeBtn.disabled = true;
                                    upgradeBtn.textContent = 'Pakete Yükselt';
                                });
                            }

                            if (yearlyTab) {
                                yearlyTab.addEventListener('shown.bs.tab', function() {
                                    radioButtons.forEach(radio => radio.checked = false);
                                    upgradeBtn.disabled = true;
                                    upgradeBtn.textContent = 'Pakete Yükselt';
                                });
                            }

                            // İptal formu onay
                            const cancelForm = document.getElementById('cancelForm{{ $package->id }}');
                            if (cancelForm) {
                                cancelForm.addEventListener('submit', function(e) {
                                    if (!confirm('Aboneliğinizi sonlandırmak istediğinize emin misiniz? Paket süreniz dolana kadar aktif kalacaktır.')) {
                                        e.preventDefault();
                                    }
                                });
                            }
                        });
                    </script>
                    @endforeach
                </div>
                @endif

                <!-- Aktif Ek Paketler -->
                @if($activeAdditionalPackages->count() > 0)
                <div class="package-section">
                    <h2 class="section-title">Ek Paketlerim</h2>
                    @foreach($activeAdditionalPackages as $package)
                    <div class="package-card">
                        <div class="package-header">
                            <h3 class="package-title">{{ $package->category->name ?? 'Ek Paket' }} @if($package->total_rights)({{ $package->total_rights }} Adet)@endif</h3>
                            <span class="package-status">Aktif</span>
                        </div>
                        <div class="package-details">
                            @if($package->remaining_rights > 0)
                            <div class="package-detail-item">
                                <strong>Kalan:</strong> {{ $package->remaining_rights }} İlan
                            </div>
                            @endif
                            <div class="package-detail-item">
                                <strong>Bitiş Tarihi:</strong> {{ \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Geçmiş Paketler -->
                @if($expiredPackages->count() > 0)
                <div class="package-section">
                    <h2 class="section-title">Geçmiş Paketlerim</h2>
                    @foreach($expiredPackages as $package)
                    <div class="expired-package-item">
                        {{ $package->package->title ?? 'Paket' }} @if($package->category)({{ $package->category->name }})@endif (Süresi Doldu - {{ \Carbon\Carbon::parse($package->end_date)->format('d.m.Y') }})
                    </div>
                    @endforeach
                </div>
                @endif

                @if($activeMainPackages->count() == 0 && $activeAdditionalPackages->count() == 0 && $expiredPackages->count() == 0)
                <div class="package-section">
                    <div class="package-card text-center">
                        <p class="text-muted">Henüz paket satın almadınız.</p>
                        <a href="{{ route('company.packages.index') }}" class="package-btn">
                            Paket Satın Al
                        </a>
                    </div>
                </div>
                @endif

                {{-- Otomatik Yenileme Ayarı - Modern Tasarım --}}
                <div class="card border-0 shadow-sm mb-4 auto-renew-card" style="overflow: hidden; border-radius: 16px;">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center gradient-animated" style="background: linear-gradient(135deg, {{ auth()->user()->company->auto_renew ? '#667eea 0%, #764ba2 100%' : '#f093fb 0%, #f5576c 100%' }}); padding: 1.5rem;">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center icon-pulse" style="width: 56px; height: 56px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                                    <i class="fa-solid fa-rotate fa-2x text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3 text-white">
                                <h5 class="mb-1 fw-bold">Otomatik Paket Yenileme</h5>
                                <p class="mb-0 opacity-90" style="font-size: 0.9rem;">
                                    Kesintisiz hizmet için otomatik yenileme
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <form action="{{route('company.auto-renew.toggle')}}" method="POST" id="auto-renew-form">
                                    @csrf
                                    <input type="hidden" name="contract_accepted" id="contract_accepted" value="0">
                                    <div class="form-check form-switch" style="transform: scale(1.5);">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="autoRenewSwitch"
                                            name="auto_renew"
                                            style="cursor: pointer; background-color: {{ auth()->user()->company->auto_renew ? '#10b981' : '#6b7280' }}; border: none;"
                                            {{auth()->user()->company->auto_renew ? 'checked' : ''}}
                                            onchange="handleAutoRenewToggle(this)">
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="d-flex align-items-start mb-3">
                                <i class="fa-solid fa-circle-info text-primary me-2 mt-1"></i>
                                <div>
                                    <p class="mb-2 text-muted" style="font-size: 0.95rem;">
                                        Paket süreniz dolduğunda kartınızdan otomatik olarak ödeme alınır ve paketiniz yenilenir.
                                    </p>
                                </div>
                            </div>

                            @if(auth()->user()->company->auto_renew)
                            <div class="alert alert-info mb-3 d-flex align-items-center" style="background: #dbeafe; border: none; border-radius: 12px;">
                                <i class="fa-solid fa-file-contract me-2" style="font-size: 1.2rem; color: #3b82f6;"></i>
                                <div class="flex-grow-1">
                                    <strong style="color: #1e40af;">Sözleşme Kabul Edildi</strong>
                                    <p class="mb-0 mt-1" style="font-size: 0.85rem; color: #1e3a8a;">
                                        Kart Saklama ve Otomatik Yenileme/Tahsilat Sözleşmesini kabul ettiniz.
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#autoRenewContractModal" class="text-decoration-underline fw-bold" style="color: #1e40af;">
                                            Sözleşmeyi Görüntüle
                                        </a>
                                    </p>
                                </div>
                            </div>
                            @endif

                            @if(auth()->user()->company->utoken)
                            <div class="alert alert-success mb-0 d-flex align-items-center" style="background: #d1fae5; border: none; border-radius: 12px;">
                                <i class="fa-solid fa-circle-check me-2" style="font-size: 1.2rem;"></i>
                                <div>
                                    <strong>Kartınız Kayıtlı</strong>
                                    <p class="mb-0 mt-1" style="font-size: 0.85rem; opacity: 0.8;">
                                        Otomatik yenileme hazır. Paketiniz kesintisiz devam edecektir.
                                    </p>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-warning mb-0 d-flex align-items-center" style="background: #fef3c7; border: none; border-radius: 12px;">
                                <i class="fa-solid fa-exclamation-triangle me-2" style="font-size: 1.2rem; color: #f59e0b;"></i>
                                <div>
                                    <strong style="color: #92400e;">Kart Bilgisi Gerekli</strong>
                                    <p class="mb-0 mt-1" style="font-size: 0.85rem; color: #78350f;">
                                        İlk paket alımınızda kartınız güvenli şekilde kaydedilecektir.
                                        <a href="{{route('company.packages.index')}}" class="text-decoration-underline fw-bold" style="color: #92400e;">
                                            Paket Satın Al →
                                        </a>
                                    </p>
                                </div>
                            </div>
                            @endif

                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fa-solid fa-shield-halved me-2 text-success"></i>
                                    Ödeme bilgileriniz PayTR güvencesiyle 256-bit SSL ile şifrelenir
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Otomatik Yenileme Sözleşmesi Modal -->
<div class="modal fade" id="autoRenewContractModal" tabindex="-1" aria-labelledby="autoRenewContractLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autoRenewContractLabel">KART SAKLAMA VE OTOMATİK YENİLEME / TAHSİLAT SÖZLEŞMESİ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center mb-4"><strong>(Firmalara Yönelik Pro Paket Ödemeleri İçin)</strong></p>

                <h6 class="mt-4">Taraflar</h6>
                <p><strong>1) HİZMET SAĞLAYICI / SATICI</strong><br>
                <strong>Unvan:</strong> Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi<br>
                <strong>Marka / Site:</strong> EvHayaliniz – evhayaliniz.com<br>
                <strong>Adres:</strong> İstiklal Mah. Özkılıç Sok. No: 2A Ortaköy / Aksaray<br>
                <strong>Vergi Dairesi / No:</strong> Aksaray VD – 3820436873<br>
                <strong>Telefon:</strong> 0542 655 67 40<br>
                <strong>E-posta:</strong> evhayaliniz@gmail.com</p>
                <p class="fst-italic">(Bundan sonra &quot;EvHayaliniz&quot; veya &quot;Hizmet Sağlayıcı&quot; olarak anılacaktır.)</p>

                <p><strong>2) MÜŞTERİ / FİRMA</strong><br>
                Ticari Unvanı: <strong>{{ auth()->user()->company->name ?? '[Firma Adı]' }}</strong><br>
                @if(auth()->user()->company->tax_office && auth()->user()->company->tax_number)
                Vergi Dairesi / No: <strong>{{ auth()->user()->company->tax_office }} / {{ auth()->user()->company->tax_number }}</strong><br>
                @endif
                @if(auth()->user()->company->address)
                Adres: <strong>{{ auth()->user()->company->address }}</strong><br>
                @endif
                Yetkili Kişi: <strong>{{ auth()->user()->name }}</strong><br>
                Telefon / E-posta: <strong>{{ auth()->user()->phone ?? '' }} / {{ auth()->user()->email }}</strong></p>
                <p class="fst-italic">(Bundan sonra &quot;Müşteri&quot; olarak anılacaktır.)</p>
                <p class="fst-italic">EvHayaliniz ve Müşteri birlikte &quot;Taraflar&quot;, ayrı ayrı &quot;Taraf&quot; olarak anılacaktır.</p>

                <h6 class="mt-4">MADDE 1 – SÖZLEŞMENİN KONUSU</h6>
                <p><strong>1.1.</strong> İşbu Kart Saklama ve Otomatik Yenileme / Tahsilat Sözleşmesi (&quot;Sözleşme&quot;); Müşteri&apos;nin, evhayaliniz.com üzerinden satın aldığı Pro Standart, Pro Business, Pro Plus ve/veya EvHayaliniz&apos;in sunduğu benzeri abonelik/belirli süreli dijital hizmet paketlerine ilişkin olarak:</p>
                <ul>
                    <li>Müşteri&apos;nin ödeme aracı bilgilerinin, EvHayaliniz&apos;in anlaşmalı olduğu ödeme hizmet sağlayıcısı (sanalyazarkasa/ödeme kuruluşu/banka vb.) altyapısında güvenli şekilde saklanmasına,</li>
                    <li>Paket süresi sonunda ilgili Pro Paket&apos;in otomatik olarak yenilenmesine ve</li>
                    <li>Bu yenilemelere ilişkin bedellerin, Müşteri&apos;nin kartından otomatik tahsiline</li>
                </ul>
                <p>dair esas ve koşulları düzenler.</p>
                <p><strong>1.2.</strong> İşbu Sözleşme, Pro Paketler Hizmet Sözleşmesi, Mesafeli Hizmet Sözleşmesi Ön Bilgilendirme Formu, Paket İptal, Otomatik Yenileme ve İade Koşulları ile birlikte uygulanır ve onların eki niteliğindedir.</p>

                <h6 class="mt-4">MADDE 2 – TANIMLAR</h6>
                <p>Bu Sözleşme&apos;de geçen;</p>
                <ul>
                    <li><strong>Site:</strong> evhayaliniz.com alan adlı internet sitesini ve mobil/web uygulamalarını,</li>
                    <li><strong>Pro Paketler:</strong> EvHayaliniz tarafından firmalara sunulan Pro Standart, Pro Business, Pro Plus ve benzeri dijital tanıtım paketlerini,</li>
                    <li><strong>Ödeme Hizmet Sağlayıcısı:</strong> EvHayaliniz&apos;in, ödeme altyapısı için sözleşme yaptığı lisanslı ödeme kuruluşu/banka/sağlayıcıyı,</li>
                    <li><strong>Kart:</strong> Müşteri&apos;nin Pro Paket ödemelerinde kullandığı, kredi kartı/banka kartı veya ödeme kuruluşunca tanımlanmış diğer ödeme araçlarını,</li>
                    <li><strong>Kart Saklama:</strong> Kart bilgilerinin, EvHayaliniz değil, Ödeme Hizmet Sağlayıcısı sistemlerinde token vb. yöntemlerle güvenli biçimde tutulmasını,</li>
                    <li><strong>Otomatik Yenileme:</strong> Pro Paket&apos;in her Paket Dönemi sonunda, Müşteri ayrıca işlem yapmasa da aynı paket için yeni dönem bedelinin otomatik olarak tahsil edilerek hizmetin kesintisiz devam ettirilmesini ifade eder.</li>
                </ul>

                <h6 class="mt-4">MADDE 3 – KART SAKLAMA ONAYI VE KAPSAMI</h6>
                <p><strong>3.1.</strong> Müşteri; Pro Paket satın alırken veya sonrasında hesap paneli üzerinden yapacağı onay ile, ödeme işlemlerinde kullanacağı Kart bilgilerini;</p>
                <ul>
                    <li>EvHayaliniz&apos;in doğrudan saklamadığını,</li>
                    <li>EvHayaliniz&apos;in anlaşmalı olduğu Ödeme Hizmet Sağlayıcısı altyapısında saklanmasına izin verdiğini,</li>
                    <li>Kart bilgisinin çoğunlukla &quot;token&quot; vb. yöntemlerle maskeleme/şifreleme tekniğiyle saklandığını</li>
                </ul>
                <p>bildiğini ve buna açık rızasıyla onay verdiğini beyan eder.</p>
                <p><strong>3.2.</strong> Kart Saklama; Müşteri&apos;nin her seferinde kart bilgilerini yeniden girmeden, Pro Paket yenileme ve yeni paket alımlarında hızlı ve güvenli ödeme yapılmasına imkân verir.</p>
                <p><strong>3.3.</strong> Müşteri; Kart bilgilerinin Ödeme Hizmet Sağlayıcısı tarafından saklanmasına ilişkin detayların, ilgili sağlayıcının gizlilik ve KVKK politikalarında açıklanmış olabileceğini; EvHayaliniz&apos;in bu saklama süreçlerinden teknik olarak sorumlu olmadığını kabul eder.</p>

                <h6 class="mt-4">MADDE 4 – OTOMATİK YENİLEME VE OTOMATİK TAHSİLAT YETKİSİ</h6>
                <p><strong>4.1.</strong> Müşteri, işbu Sözleşme ile;</p>
                <ul>
                    <li>Satın aldığı Pro Paket&apos;in her Paket Dönemi sonunda otomatik olarak yenilenmesine,</li>
                    <li>Yenilenen dönem bedelinin, saklanan Kart üzerinden otomatik olarak tahsil edilmesine,</li>
                </ul>
                <p>EvHayaliniz ve Ödeme Hizmet Sağlayıcısı&apos;na açıkça izin ve yetki verdiğini kabul eder.</p>
                <p><strong>4.2.</strong> Otomatik yenileme kapsamında, her yeni Paket Dönemi başında tahsil edilecek tutar;</p>
                <ul>
                    <li>Yenilenen Pro Paket&apos;in o tarihte Site&apos;de ilan edilen güncel paket fiyatı üzerinden,</li>
                    <li>KDV ve yürürlükteki diğer yasal yükümlülükler dâhil edilerek</li>
                </ul>
                <p>hesaplanır. Fiyat değişiklikleri, EvHayaliniz tarafından Site&apos;de ilan edilir ve/veya Müşteri&apos;ye makul yollarla (e-posta, bildirim vb.) duyurulacaktır.</p>
                <p><strong>4.3.</strong> Müşteri, kartın ait olduğu banka/kurum nezdinde kart hamili veya yetkili kullanıcı olduğunu; kart üzerinden yapılan tahsilatlardan doğan tüm mali ve hukuki sorumluluğun kendisine ait olduğunu kabul eder.</p>
                <p><strong>4.4.</strong> Müşteri, yetkili olmadığı bir kartı kullanması veya kart sahibinin sonradan itirazı hâlinde doğabilecek her türlü ihtilaf ve zarardan münhasıran sorumlu olduğunu, EvHayaliniz&apos;in bu konuda hiçbir sorumluluğu olmayacağını kabul eder.</p>

                <h6 class="mt-4">MADDE 5 – OTOMATİK YENİLEMEYİ İPTAL HAKKI</h6>
                <p><strong>5.1.</strong> Müşteri, dilediği zaman;</p>
                <ul>
                    <li>Site üzerinde yer alan hesap/paket ayarları üzerinden,</li>
                    <li>veya EvHayaliniz&apos;e yazılı/e-posta yoluyla başvurarak</li>
                </ul>
                <p>otomatik yenileme yetkisini iptal edebilir.</p>
                <p><strong>5.2.</strong> Otomatik yenileme iptali:</p>
                <ul>
                    <li>İptal tarihinden sonra başlayacak Paket Dönemlerini etkiler;</li>
                    <li>İçinde bulunulan ve bedeli ödenmiş mevcut Paket Dönemi için geçerli değildir.</li>
                </ul>
                <p><strong>5.3.</strong> Müşteri, otomatik yenilemeyi iptal etse dahi; Ödemesini yapmış olduğu mevcut Paket Dönemi boyunca Pro Paket haklarını (paket kapsamında belirlenen hizmet sayısı, görünürlük, istatistik vb.) kullanmaya devam edebilir. Paket süresi sonunda, otomatik yenileme devre dışı olduğu için paket kendiliğinden sona erer ve yeni tahsilat yapılmaz.</p>
                <p><strong>5.4.</strong> Müşteri, otomatik yenilemeyi Paket Dönemi bitiş tarihinden makul bir süre önce iptal etmelidir. İptal talebi, teknik/pazarlama süreçleri nedeniyle bir sonraki dönemden itibaren uygulanabilir; tam tarih ve işleyiş Site&apos;de ayrıca gösterilebilir.</p>

                <h6 class="mt-4">MADDE 6 – KARTIN GÜNCELLENMESİ, DEĞİŞMESİ VE KULLANILAMAMASI</h6>
                <p><strong>6.1.</strong> Kartın süresinin dolması, kartın iptal edilmesi, kayıp/çalıntı bildiriminde bulunulması veya banka tarafından bloke edilmesi gibi durumlarda;</p>
                <ul>
                    <li>Otomatik yenileme tahsilatı gerçekleştirilemeyebilir,</li>
                    <li>EvHayaliniz, Müşteri&apos;ye yeni kart tanımlaması için bildirim gönderebilir.</li>
                </ul>
                <p><strong>6.2.</strong> Müşteri, otomatik yenilemenin sorunsuz devam etmesini istiyorsa, hesap paneli üzerinden yeni kart bilgisi tanımlayarak bu yeni kartın saklanmasına ve otomatik tahsilata da onay vermesi gerekir.</p>
                <p><strong>6.3.</strong> Tahsilatın yapılamaması halinde EvHayaliniz;</p>
                <ul>
                    <li>Müşteri&apos;nin Pro Paket hizmetini durdurma veya askıya alma,</li>
                    <li>Belirli bir süre içinde ödeme yapılmaması hâlinde paketi sona erdirme</li>
                </ul>
                <p>hakkını saklı tutar.</p>

                <h6 class="mt-4">MADDE 7 – İADE VE İHTİLAFLAR</h6>
                <p><strong>7.1.</strong> Otomatik yenileme kapsamında tahsil edilen bedeller; Pro Paketler Hizmet Sözleşmesi ve Paket İptal / İade Koşulları çerçevesinde değerlendirilir. Paket dönemi başlamış ve hizmet ifasına fiilen imkân sağlanmış ise, kural olarak iade yapılmaz.</p>
                <p><strong>7.2.</strong> Karttan yapılan tahsilatlara Müşteri&apos;nin itirazı olması halinde;</p>
                <ul>
                    <li>Müşteri öncelikle EvHayaliniz ile iletişime geçerek durumu yazılı olarak bildirecek,</li>
                    <li>Gerekirse ilgili banka/ödeme kuruluşu nezdinde de itiraz süreçlerini yürütecektir.</li>
                </ul>
                <p><strong>7.3.</strong> EvHayaliniz; mükerrer tahsilat, açık bariz hata veya teknik sistem sorunu gibi durumlar dışında, kart itirazlarından doğacak bankacılık masraflarından sorumlu tutulamaz.</p>

                <h6 class="mt-4">MADDE 8 – KİŞİSEL VERİLERİN VE KART BİLGİLERİNİN KORUNMASI</h6>
                <p><strong>8.1.</strong> Müşteri&apos;nin kimlik, iletişim ve fatura bilgileri EvHayaliniz tarafından; 6698 sayılı KVKK ve ilgili mevzuata uygun olarak işlenir. Ayrıntılar, EvHayaliniz&apos;in Gizlilik Politikası ve KVKK Aydınlatma Metninde açıklanmıştır.</p>
                <p><strong>8.2.</strong> Kart numarası, son kullanma tarihi, CVC/CVV vb. hassas kart verileri EvHayaliniz tarafından doğrudan saklanmaz; bu veriler, lisanslı Ödeme Hizmet Sağlayıcısı sistemlerinde saklanır ve işlenir.</p>
                <p><strong>8.3.</strong> EvHayaliniz, sadece ödeme işlemini gerçekleştirmek için gereken, tokenize/maskelemiş kart verilerine veya işlem referanslarına erişebilir. Müşteri, bu işleyişe muvafakat ettiğini kabul eder.</p>

                <h6 class="mt-4">MADDE 9 – YÜRÜRLÜK, SÜRE VE FESİH</h6>
                <p><strong>9.1.</strong> İşbu Sözleşme, Müşteri&apos;nin:</p>
                <ul>
                    <li>Pro Paket satın alırken &quot;kartımı kaydet ve otomatik yenileme ile öde&quot; benzeri seçeneği işaretlemesi,</li>
                    <li>veya hesap paneli üzerinden kart saklama ve otomatik yenileme onayı vermesi</li>
                </ul>
                <p>ile elektronik ortamda kurulmuş olur ve yürürlüğe girer.</p>
                <p><strong>9.2.</strong> Sözleşme; Müşteri&apos;nin kart saklama ve/veya otomatik yenileme onayını geri çekmesine, Pro Paket aboneliğini kalıcı olarak sonlandırmasına veya EvHayaliniz&apos;in ilgili hizmeti sonlandırmasına kadar yürürlükte kalır.</p>
                <p><strong>9.3.</strong> Müşteri, kart saklama ve otomatik yenileme onayını geri çekse dahi, daha önce gerçekleşmiş Paket Dönemlerine ait borçları, tahakkuk etmiş üçüncü kişi masrafları veya doğmuş malî yükümlülükleri ortadan kalkmaz.</p>

                <h6 class="mt-4">MADDE 10 – UYGULANACAK HUKUK VE YETKİ</h6>
                <p><strong>10.1.</strong> İşbu Sözleşme&apos;nin uygulanmasında ve yorumlanmasında Türkiye Cumhuriyeti hukuku uygulanacaktır.</p>
                <p><strong>10.2.</strong> İşbu Sözleşme&apos;den doğabilecek her türlü uyuşmazlığın çözümünde Aksaray Merkez Mahkemeleri ve İcra Daireleri yetkilidir.</p>

                <h6 class="mt-4">MADDE 11 – KABUL BEYANI</h6>
                <p>Müşteri; Bu Sözleşme hükümlerini, Pro Paketler Hizmet Sözleşmesi&apos;ni, Ön Bilgilendirme Formu&apos;nu ve Paket İptal/İade Koşullarını okuyup anladığını,</p>
                <ul>
                    <li>Kart bilgilerinin Ödeme Hizmet Sağlayıcısı nezdinde saklanmasına,</li>
                    <li>Pro Paket bedellerinin, paket süresi sonunda otomatik yenileme yoluyla kartından tahsil edilmesine,</li>
                    <li>Otomatik yenilemeyi iptal etmesi hâlinde mevcut Paket Dönemi sonuna kadar haklarını kullanmaya devam edeceğine ve sonraki döneme ilişkin tahsilat yapılmayacağına</li>
                </ul>
                <p>elektronik ortamda açıkça onay verdiğini beyan ve taahhüt eder.</p>
                <p class="text-end mt-4"><strong>Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi (&quot;EvHayaliniz&quot;)</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" id="acceptContractBtn" style="display: none;">Kabul Ediyorum</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
let pendingToggleState = null;

function handleAutoRenewToggle(checkbox) {
    const isCurrentlyOn = {{ auth()->user()->company->auto_renew ? 'true' : 'false' }};
    
    // Eğer kapalıyken açmaya çalışıyorsa, sözleşme modalını göster
    if (!isCurrentlyOn && checkbox.checked) {
        pendingToggleState = true;
        checkbox.checked = false; // Önce checkbox'ı geri kapat
        
        // Modal'ı aç ve kabul butonunu göster
        const modal = new bootstrap.Modal(document.getElementById('autoRenewContractModal'));
        document.getElementById('acceptContractBtn').style.display = 'inline-block';
        modal.show();
        
        // Kabul butonuna event listener ekle
        document.getElementById('acceptContractBtn').onclick = function() {
            document.getElementById('contract_accepted').value = '1';
            document.getElementById('autoRenewSwitch').checked = true;
            modal.hide();
            document.getElementById('auto-renew-form').submit();
        };
    } else {
        // Açıkken kapatıyorsa direkt form gönder
        document.getElementById('auto-renew-form').submit();
    }
}

// Modal kapandığında kabul butonunu gizle
document.getElementById('autoRenewContractModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('acceptContractBtn').style.display = 'none';
    if (pendingToggleState === true) {
        document.getElementById('autoRenewSwitch').checked = false;
        pendingToggleState = null;
    }
});
</script>
@endsection