@php
    $userType = Auth::user()->user_type;
    // Profil URL’si
    if ($userType === 'user') {
      $profileUrl = route('user.profile.edit');
      $passwordUrl = route('user.password.edit');
    } elseif ($userType === 'company') {
      $profileUrl = route('company.profile.edit');
      $passwordUrl = route('company.password.edit');
    } else {
      // admin için profil yerine genel ayarlar sayfası
      $profileUrl = route('admin.settings.edit');
      $passwordUrl = null;
    }

    // Quick links için yönetim modülleri
    $adminModules = collect([
      ['name'=>'Kategoriler',    'route'=>'admin.categories.index',         'icon'=>'bx-menu'],
      ['name'=>'Firmalar',       'route'=>'admin.companies.index',          'icon'=>'bx-vertical-center'],
      ['name'=>'Genel Ayarlar',  'route'=>'admin.settings.edit',            'icon'=>'bx-fullscreen'],
      ['name'=>'Slider',         'route'=>'admin.sliders.index',            'icon'=>'bx-exit-fullscreen'],
      ['name'=>'Sayfalar',       'route'=>'admin.pages.index',              'icon'=>'bx-square-rounded'],
      ['name'=>'Hakkımızda',     'route'=>'admin.about.index',              'icon'=>'bxs-user-badge'],
    ])->chunk(3);
@endphp

@php
    $notificationsData = ['unread_count' => 0, 'values' => collect()];
    if (Auth::check() && function_exists('user_notifications')) {
        $notificationsData = user_notifications();
    }
    $unreadCount = $notificationsData['unread_count'] ?? 0;
    $notificationItems = $notificationsData['values'] ?? collect();
@endphp

<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-xxl">
        {{-- Brand --}}
        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
            <a href="{{ route('admin.dashboard.index') }}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">
          {{-- SVG logo --}}
        </span>
                <span class="app-brand-text demo menu-text fw-bold">Yönetim Paneli</span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="bx bx-x bx-sm align-middle"></i>
            </a>
        </div>

        {{-- Mobile toggle --}}
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="#"><i class="bx bx-menu bx-sm"></i></a>
        </div>

        {{-- Right side --}}
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">

                {{-- Language --}}
                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                        <i class="bx bx-globe bx-sm"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" data-language="tr"><span class="align-middle">Türkçe</span></a></li>
                        <li><a class="dropdown-item" href="#" data-language="en"><span class="align-middle">English</span></a></li>
                    </ul>
                </li>

                {{-- Search --}}
                <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
                    <a class="nav-link search-toggler" href="#"><i class="bx bx-search-alt bx-sm"></i></a>
                </li>

                {{-- Theme switch --}}
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown"><i class="bx bx-moon bx-sm"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                        <li><a class="dropdown-item" href="#" data-theme="light"><i class="bx bx-sun me-2"></i>Light</a></li>
                        <li><a class="dropdown-item" href="#" data-theme="dark"><i class="bx bx-moon me-2"></i>Dark</a></li>
                    </ul>
                </li>

                {{-- Quick links --}}
                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="bx bx-grid-alt bx-sm"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0">
                        <div class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto">Kısayollar</h5>
                            </div>
                        </div>
                        <div class="dropdown-shortcuts-list scrollable-container px-3">
                            @foreach($adminModules as $row)
                                <div class="row row-bordered overflow-visible g-0 mb-2">
                                    @foreach($row as $mod)
                                        <div class="dropdown-shortcuts-item col text-center">
                      <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                        <i class="bx fs-4 {{ $mod['icon'] }}"></i>
                      </span>
                                            <a href="{{ route($mod['route']) }}" class="stretched-link d-block">{{ $mod['name'] }}</a>
                                            <small class="text-muted">{{ $mod['name'] }} Yönetimi</small>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>

                {{-- Notifications --}}
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown" id="admin-notification-toggle">
                        <i class="bx bx-bell bx-sm"></i>
                        @if($unreadCount > 0)
                            <span class="badge bg-danger rounded-pill badge-notifications">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0" data-notification-list>
                        <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto">
                                    Bildirimler
                                    <small class="text-muted ms-1">({{ $unreadCount }})</small>
                                </h5>
                            </div>
                        </li>
                        <li class="dropdown-notifications-list scrollable-container">
                            <ul class="list-group list-group-flush">
                                @forelse($notificationItems as $notification)
                                    @php
                                        $actor = auth_info($notification->user_id);
                                        $actorName = $actor->name ?? 'Sistem';
                                        $avatarPath = $actor->avatar ?? 'assets/img/default-avatar.png';
                                        $avatarUrl = \Illuminate\Support\Str::startsWith($avatarPath, ['http://', 'https://'])
                                            ? $avatarPath
                                            : asset($avatarPath);
                                        $createdAt = change_timezone($notification->created_at, 'd.m.Y H:i');
                                    @endphp
                                    <li @class([
                                        'list-group-item',
                                        'dropdown-notifications-item',
                                        'bg-light' => true,
                                    ]) data-notification-id="{{ $notification->id }}">
                                        <div class="d-flex">
                                            <div class="avatar me-3">
                                                <img src="{{ $avatarUrl }}" alt="{{ $actorName }}" class="w-px-40 h-px-40 rounded-circle">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 text-body">
                                                    {{ $actorName }}
                                                </h6>
                                                <p class="mb-1 text-muted">
                                                    {{ $notification->message }}
                                                </p>
                                                <small class="text-muted">{{ $createdAt }}</small>
                                            </div>
                                            @if(!empty($notification->link))
                                                <div class="ms-2">
                                                    <a href="{{ $notification->link }}" class="btn btn-sm btn-outline-primary">
                                                        Gör
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item dropdown-notifications-item text-center text-muted">
                                        Kaydedilmiş bildirim bulunmuyor.
                                    </li>
                                @endforelse
                            </ul>
                        </li>
                        <li class="dropdown-menu-footer border-top text-center p-2">
                            <a href="{{ route('admin.dashboard.index') }}">Tümünü Görüntüle</a>
                        </li>
                    </ul>
                </li>

                {{-- User dropdown --}}
                <li class="nav-item dropdown-user navbar-dropdown dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" class="rounded-circle" alt />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        {{-- Kullanıcı bilgisi --}}
                        <li>
                            <a class="dropdown-item" href="{{ $profileUrl }}">
                                <div class="d-flex">
                                    <div class="avatar avatar-online me-3">
                                        <img src="{{ Auth::user()->avatar_url ?? asset('images/default-avatar.png') }}" class="rounded-circle" alt />
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium">{{ Auth::user()->name }}</span><br>
                                        <small class="text-muted">{{ ucfirst($userType) }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>

                        {{-- Profil & Şifre (admin için sadece Ayarlar linki) --}}
                        <li>
                            <a class="dropdown-item" href="{{ $profileUrl }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">{{ $userType === 'admin' ? 'Ayarlar' : 'Profil' }}</span>
                            </a>
                        </li>
                        @if($passwordUrl)
                            <li>
                                <a class="dropdown-item" href="{{ $passwordUrl }}">
                                    <i class="bx bx-key me-2"></i>
                                    <span class="align-middle">Şifre Değiştir</span>
                                </a>
                            </li>
                        @endif

                        <li><hr class="dropdown-divider"></li>
                        {{-- Çıkış --}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <a class="dropdown-item" href="#" onclick="this.closest('form').submit()">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Çıkış Yap</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

        {{-- Mobil arama --}}
        <div class="navbar-search-wrapper search-input-wrapper container-xxl d-none">
            <input type="text" class="form-control search-input border-0" placeholder="Ara..." />
            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>
