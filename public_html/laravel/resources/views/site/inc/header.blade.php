<header>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6 col-6">
                <div class="header-left">
                    <div id="header-left-menu" class="header-left-menu sidebar-toggle-btn" role="button" tabindex="0" aria-label="Menü">
                        <div class="hamburger">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </div>
                    </div>
                    <div class="header-logo m-0">
                        <a class="web-logo" href="/">
                            <img src="{{asset(\App\Models\Setting::first()?->logo)}}" alt="Site Logo">
                        </a>
                        <a class="mobil-logo" href="/">
                            <img src="{{asset(\App\Models\Setting::first()?->mobile_logo)}}" alt="Site Logo">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 md-mobile-none">
                <div class="header-mid">
                    <div class="header-search modern-header-search">
                        <input id="header-search-input" type="text" class="searchInput"
                            placeholder="Hizmet veya firma ara..." autocomplete="off">
                        <i class="fa-solid fa-magnifying-glass search-icon-btn"></i>
                    </div>
                    <div class="header-search-area" id="resultsArea">
                        <div id="search-initial-hint" class="search-empty-hint">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            <span>Aramak istediğiniz hizmet, firma veya fikri yazın...</span>
                        </div>
                        <div id="search-results-groups" style="display: none;">
                            <div class="search-group" id="services-group">
                                <h6 class="search-group-title text-primary"><i class="fa-solid fa-briefcase me-1"></i> Hizmetler</h6>
                                <div id="services" class="search-scroll"></div>
                            </div>
                            <div class="search-group" id="ideas-group">
                                <h6 class="search-group-title text-primary"><i class="fa-regular fa-lightbulb me-1"></i> Fikirler</h6>
                                <div id="ideas" class="search-scroll"></div>
                            </div>
                            <div class="search-group" id="companies-group">
                                <h6 class="search-group-title text-primary"><i class="fa-regular fa-building me-1"></i> Firmalar</h6>
                                <div id="companies" class="search-scroll"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-lg-3 col-md-6 col-6">
                <div class="header-right ">
                    {{-- header-web md-mobile-none--}}

                    <div class="header-right-mobile">
                        <div class="header-mobil-search">
                            <div class="header-m-search-trigger navbar-icon-btn" role="button" tabindex="0" aria-label="Arama">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <div class="header-mobil-search-area">
                                <div class="hmsa-title d-flex align-items-center">
                                    <div class="hmsa-close navbar-icon-btn" role="button" aria-label="Geri">
                                        <i class="fa-solid fa-arrow-left"></i>
                                    </div>
                                    <div class="hmsa-search">
                                        <input type="text" class="searchInput" placeholder="Hizmet veya Firma ara...">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                </div>

                                <div class="hmsa-dropdown text-start p-3">
                                    <h6 class="text-secondary fw-normal">Firmalar</h6>
                                    <div id="companies-mobile" class="search-scroll"></div>

                                    <h6 class="text-secondary fw-normal mt-3">Hizmetler</h6>
                                    <div id="services-mobile" class="search-scroll"></div>

                                    <h6 class="text-secondary fw-normal mt-3">Fikirler</h6>
                                    <div id="ideas-mobile" class="search-scroll"></div>
                                </div>


                                {{-- <div class="hmsa-dropdown text-start p-3">--}}
                                {{-- <ul>--}}
                                {{-- <li>--}}
                                {{-- <h6 class="text-secondary fw-normal">Firmalar</h6>--}}
                                {{-- <div id="companies-mobile" class="search-scroll"></div>--}}
                                {{-- </li>--}}
                                {{-- <li>--}}
                                {{-- <h6 class="text-secondary fw-normal mt-3">Hizmetler</h6>--}}
                                {{-- <div id="services-mobile" class="search-scroll"></div>--}}
                                {{-- </li>--}}
                                {{-- <li>--}}
                                {{-- <h6 class="text-secondary fw-normal mt-3">Fikirler</h6>--}}
                                {{-- <div id="ideas-mobile" class="search-scroll"></div>--}}
                                {{-- </li>--}}
                                {{-- </ul>--}}
                                {{-- </div>--}}


                                {{-- <div class="hmsa-dropdown">--}}
                                {{-- <ul>--}}
                                {{-- <li>--}}
                                {{-- <a href="#">--}}
                                {{-- 3+1 Daire--}}
                                {{-- </a>--}}
                                {{-- </li>--}}
                                {{-- <li>--}}
                                {{-- <a href="#">--}}
                                {{-- 3+1 Müstakil Ev--}}
                                {{-- </a>--}}
                                {{-- </li>--}}
                                {{-- </ul>--}}
                                {{-- </div>--}}
                            </div>
                        </div>

                        @auth()
                        @php
                            $currentAuthId = Auth::id();
                            $allMessages = \App\Models\Message::with(['sender.informations', 'sender.company'])
                                ->where('receiver_id', $currentAuthId)
                                ->orderBy('created_at', 'desc')
                                ->get();

                            $groupedMessages = $allMessages->groupBy('sender_id')->map(function ($messages) {
                                return [
                                    'latest_message' => $messages->first(),
                                    'unread_count' => $messages->where('is_read', false)->count(),
                                ];
                            });

                            $sharedUnreadMsgCount = $allMessages->where('is_read', false)->count();
                            $sharedUnreadNotifCount = user_notifications()['unread_count'] ?? 0;

                            $user = auth()->user();
                            $avatarPath = 'site/images/default_avatar.jpg';

                            if ($user->user_type == 'user' && $user->informations?->avatar) {
                                $avatarPath = $user->informations->avatar;
                            } elseif ($user->user_type == 'company' && $user->company?->avatar) {
                                $avatarPath = $user->company->avatar;
                            }

                            $isCompany = $user->user_type == 'company';
                            $profileName = $isCompany
                                ? ($user->company?->name ?: $user->name)
                                : ($user->informations?->name ?: $user->name);
                            $profileEmail = $user->email;
                            $profileRoleBadge = $isCompany ? 'Kurumsal Firma' : 'Bireysel Kullanıcı';
                            $dashboardRoute = route($isCompany ? 'company.dashboard' : 'user.dashboard');
                        @endphp

                        @if(auth()->user()->user_type != 'admin')
                        <div class="header-mobil-message">
                            <div id="user-messages-m" class="hr-box hr-msg m-0 p-0">
                                <a id="user-messages-trigger2" href="#" class="navbar-icon-btn navbar-btn-message" role="button" aria-label="Mesajlar">
                                    <i class="fa-regular fa-comment-dots"></i>
                                    <div class="hr-count" @if($sharedUnreadMsgCount == 0) style="display:none;" @endif>
                                        <span class="unread-msg-count">{{ $sharedUnreadMsgCount }}</span>
                                    </div>
                                </a>
                                <div id="user-messages-dropdown2" class="user-messages-dropdown ums-mobil modern-dropdown-mobile">
                                    <div class="mobile-dropdown-sheet">
                                        <div class="mobile-dropdown-header">
                                            <div class="mobile-header-text-group">
                                                <h5 class="mobile-header-title m-0 p-0">Mesajlar</h5>
                                                <span class="mobile-header-subtitle m-0 p-0">{{ $sharedUnreadMsgCount > 0 ? $sharedUnreadMsgCount . ' yeni mesaj' : 'Gelen kutusu' }}</span>
                                            </div>
                                            <button type="button" class="mobile-dropdown-close usm-mobil-close" aria-label="Kapat">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>

                                        <div class="mobile-dropdown-body">
                                            @forelse($groupedMessages as $senderId => $data)
                                                @php
                                                    $message = $data['latest_message'];
                                                    $unreadCount = $data['unread_count'];
                                                    $senderName = $message->sender->user_type === 'user'
                                                        ? ($message->sender?->informations?->name ?: $message->sender?->name)
                                                        : ($message->sender?->company?->name ?: $message->sender?->name);
                                                    $senderAvatar = $message->sender->user_type === 'user'
                                                        ? ($message?->sender?->informations?->avatar ?: 'site/images/default_avatar.jpg')
                                                        : ($message?->sender?->company?->avatar ?: 'site/images/default_avatar.jpg');
                                                @endphp
                                                <a href="{{ route('chat.show', $message->sender_id) }}" class="modern-dropdown-item {{ $unreadCount > 0 ? 'unread' : '' }}">
                                                    <div class="dropdown-item-avatar">
                                                        <img src="{{ asset($senderAvatar) }}" alt="{{ $senderName }}">
                                                        @if($unreadCount > 0)
                                                            <span class="avatar-unread-badge">{{ $unreadCount }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="dropdown-item-content">
                                                        <div class="dropdown-item-top">
                                                            <span class="dropdown-item-name text-truncate">{{ $senderName }}</span>
                                                            <span class="dropdown-item-time">
                                                                {{ \Carbon\Carbon::parse($message->created_at)->setTimezone('Europe/Istanbul')->format('H:i') }}
                                                            </span>
                                                        </div>
                                                        <div class="dropdown-item-preview text-truncate">
                                                            {{ $message->message ?: 'Dosya eki gönderildi' }}
                                                        </div>
                                                    </div>
                                                    @if($unreadCount > 0)
                                                        <span class="unread-dot"></span>
                                                    @endif
                                                </a>
                                            @empty
                                                <div class="modern-dropdown-empty">
                                                    <div class="empty-icon">
                                                        <i class="fa-regular fa-comment-dots"></i>
                                                    </div>
                                                    <h6>Henüz Mesajınız Yok</h6>
                                                    <p>Yeni bir mesaj aldığınızda burada listelenecektir.</p>
                                                </div>
                                            @endforelse
                                        </div>

                                        <div class="mobile-dropdown-footer">
                                            <a href="{{route('chat.show')}}" class="dropdown-footer-btn">
                                                <span>Tüm Mesajları Görüntüle</span>
                                                <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="header-mobil-notif">
                            <div id="user-notif-m" class="hr-box hr-msg m-0 p-0">
                                <a id="user-notif-trigger2" href="#" class="navbar-icon-btn navbar-btn-notif"
                                    role="button"
                                    aria-label="Bildirimler">
                                    <i class="fa-regular fa-bell"></i>
                                    <div class="hr-count" @if($sharedUnreadNotifCount == 0) style="display:none;" @endif>
                                        <span class="notification-count">{{ $sharedUnreadNotifCount }}</span>
                                    </div>
                                </a>
                                <div id="user-natif-dropdown2" class="user-messages-dropdown ums-mobil modern-dropdown-mobile">
                                    <div class="mobile-dropdown-sheet">
                                        <div class="mobile-dropdown-header">
                                            <div class="mobile-header-text-group">
                                                <h5 class="mobile-header-title m-0 p-0">Bildirimler</h5>
                                                <span class="mobile-header-subtitle m-0 p-0">{{ $sharedUnreadNotifCount > 0 ? $sharedUnreadNotifCount . ' yeni bildirim' : 'Tümü okundu' }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="dropdown-mark-read-btn mark-all-notifications-btn" title="Tümünü Okundu Yap" @if($sharedUnreadNotifCount == 0) disabled @endif>
                                                    <span>Tümünü Okundu Yap</span>
                                                </button>
                                                <button type="button" class="mobile-dropdown-close usm-mobil-close" aria-label="Kapat">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mobile-dropdown-body">
                                            @forelse(user_notifications()['values'] as $notification)
                                                @php
                                                    $notifUser = auth_info($notification->user_id);
                                                    $notifUserName = $notifUser?->name ?? 'Sistem Bildirimi';
                                                    $notifAvatar = $notifUser?->avatar ?? 'site/images/default_avatar.jpg';
                                                @endphp
                                                <a href="{{$notification->link ?? 'javascript:void(0)'}}"
                                                    class="modern-dropdown-item notification-link {{ !$notification->is_read ? 'unread' : '' }}"
                                                    data-notification-id="{{$notification->id}}">
                                                    <div class="dropdown-item-avatar">
                                                        <img src="{{ asset($notifAvatar) }}" alt="{{ $notifUserName }}">
                                                        <span class="avatar-sub-icon notif"><i class="fa-solid fa-bell"></i></span>
                                                    </div>
                                                    <div class="dropdown-item-content">
                                                        <div class="dropdown-item-top">
                                                            <span class="dropdown-item-name text-truncate">{{ $notifUserName }}</span>
                                                            <div class="dropdown-item-meta">
                                                                <span class="dropdown-item-time">
                                                                    {{\Carbon\Carbon::parse($notification->created_at)->setTimezone('Europe/Istanbul')->format('H:i')}}
                                                                </span>
                                                                <span class="dropdown-item-date">
                                                                    {{\Carbon\Carbon::parse($notification->created_at)->setTimezone('Europe/Istanbul')->format('d.m.Y')}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-item-message">
                                                            {{$notification->message}}
                                                        </div>
                                                    </div>
                                                    @if(!$notification->is_read)
                                                        <span class="unread-dot"></span>
                                                    @endif
                                                </a>
                                            @empty
                                                <div class="modern-dropdown-empty">
                                                    <div class="empty-icon">
                                                        <i class="fa-regular fa-bell-slash"></i>
                                                    </div>
                                                    <h6>Bildiriminiz Yok</h6>
                                                    <p>Yeni bir bildirim aldığınızda burada görüntülenecektir.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif

                        <div class="header-mobil-profile">
                            <a id="mobile-profile-trigger" class="hr-logo navbar-avatar-btn" role="button" aria-label="Profilim">
                                <img src="{{asset($avatarPath)}}" alt="Avatar">
                                <span class="navbar-avatar-status" title="Çevrimiçi"></span>
                            </a>
                        </div>
                        @endauth

                        @guest()
                        <div class="header-mobil-login">
                            <div class="header-right-trigger navbar-icon-btn navbar-btn-login" data-bs-toggle="modal"
                                href="#exampleModalToggle" role="button" tabindex="0" aria-label="Giriş Yap">
                                <i class="fa-regular fa-user"></i>
                            </div>
                        </div>
                        @endguest

                    </div>


                    @auth()
                    @if(auth()->user()->user_type != 'admin')
                    <div id="user-messages" class="hr-box hr-msg d-none d-lg-block">
                        <a id="user-messages-trigger" href="#"
                            class="navbar-icon-btn navbar-btn-message position-relative"
                            role="button"
                            aria-label="Mesajlar">
                            <i class="fa-regular fa-comment-dots"></i>
                            <div class="hr-count" @if($sharedUnreadMsgCount == 0) style="display:none;" @endif>
                                <span class="unread-msg-count">{{ $sharedUnreadMsgCount }}</span>
                            </div>
                        </a>
                        <div id="user-messages-dropdown" class="user-messages-dropdown modern-dropdown">
                            <div class="modern-dropdown-header">
                                <div>
                                    <h6 class="dropdown-header-title">Mesajlar</h6>
                                    <span class="dropdown-header-subtitle">
                                        {{ $sharedUnreadMsgCount > 0 ? $sharedUnreadMsgCount . ' yeni mesaj' : 'Gelen kutusu' }}
                                    </span>
                                </div>
                                <a href="{{route('chat.show')}}" class="dropdown-header-action" title="Tüm Mesajları Aç">
                                    <span>Tümü</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="modern-dropdown-body">
                                @forelse($groupedMessages as $senderId => $data)
                                    @php
                                        $message = $data['latest_message'];
                                        $unreadCount = $data['unread_count'];
                                        $senderName = $message->sender->user_type === 'user'
                                            ? ($message->sender?->informations?->name ?: $message->sender?->name)
                                            : ($message->sender?->company?->name ?: $message->sender?->name);
                                        $senderAvatar = $message->sender->user_type === 'user'
                                            ? ($message?->sender?->informations?->avatar ?: 'site/images/default_avatar.jpg')
                                            : ($message?->sender?->company?->avatar ?: 'site/images/default_avatar.jpg');
                                    @endphp
                                    <a href="{{ route('chat.show', $message->sender_id) }}" class="modern-dropdown-item {{ $unreadCount > 0 ? 'unread' : '' }}">
                                        <div class="dropdown-item-avatar">
                                            <img src="{{ asset($senderAvatar) }}" alt="{{ $senderName }}">
                                            @if($unreadCount > 0)
                                                <span class="avatar-unread-badge">{{ $unreadCount }}</span>
                                            @endif
                                        </div>
                                        <div class="dropdown-item-content">
                                            <div class="dropdown-item-top">
                                                <span class="dropdown-item-name text-truncate">{{ $senderName }}</span>
                                                <span class="dropdown-item-time">
                                                    {{ \Carbon\Carbon::parse($message->created_at)->setTimezone('Europe/Istanbul')->format('H:i') }}
                                                </span>
                                            </div>
                                            <div class="dropdown-item-preview text-truncate">
                                                {{ $message->message ?: 'Dosya eki gönderildi' }}
                                            </div>
                                        </div>
                                        @if($unreadCount > 0)
                                            <span class="unread-dot"></span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="modern-dropdown-empty">
                                        <div class="empty-icon">
                                            <i class="fa-regular fa-comment-dots"></i>
                                        </div>
                                        <h6>Henüz Mesajınız Yok</h6>
                                        <p>Yeni bir mesaj aldığınızda burada listelenecektir.</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="modern-dropdown-footer">
                                <a href="{{route('chat.show')}}" class="dropdown-footer-btn">
                                    <span>Tüm Mesajları Görüntüle</span>
                                    <i class="fa-solid fa-arrow-right-long ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div id="user-notif" class="hr-box hr-msg d-none d-lg-block">
                        <a id="user-notif-trigger" href="#"
                            class="navbar-icon-btn navbar-btn-notif position-relative"
                            role="button"
                            aria-label="Bildirimler">
                            <i class="fa-regular fa-bell"></i>
                            <div class="hr-count" @if($sharedUnreadNotifCount == 0) style="display:none;" @endif>
                                <span class="notification-count">{{ $sharedUnreadNotifCount }}</span>
                            </div>
                        </a>
                        <div id="user-natif-dropdown" class="user-messages-dropdown modern-dropdown">
                            <div class="modern-dropdown-header">
                                <div>
                                    <h6 class="dropdown-header-title">Bildirimler</h6>
                                    <span class="dropdown-header-subtitle">
                                        {{ $sharedUnreadNotifCount > 0 ? $sharedUnreadNotifCount . ' yeni bildirim' : 'Tümü okundu' }}
                                    </span>
                                </div>
                                <button type="button" class="dropdown-mark-read-btn mark-all-notifications-btn" title="Tümünü Okundu Yap" @if($sharedUnreadNotifCount == 0) disabled @endif>
                                    <span>Tümünü Okundu Yap</span>
                                </button>
                            </div>

                            <div class="modern-dropdown-body">
                                @forelse(user_notifications()['values'] as $notification)
                                    @php
                                        $notifUser = auth_info($notification->user_id);
                                        $notifUserName = $notifUser?->name ?? 'Sistem Bildirimi';
                                        $notifAvatar = $notifUser?->avatar ?? 'site/images/default_avatar.jpg';
                                    @endphp
                                    <a href="{{$notification->link ?? 'javascript:void(0)'}}"
                                        class="modern-dropdown-item notification-link {{ !$notification->is_read ? 'unread' : '' }}"
                                        data-notification-id="{{$notification->id}}">
                                        <div class="dropdown-item-avatar">
                                            <img src="{{ asset($notifAvatar) }}" alt="{{ $notifUserName }}">
                                            <span class="avatar-sub-icon notif"><i class="fa-solid fa-bell"></i></span>
                                        </div>
                                            <div class="dropdown-item-content">
                                                <div class="dropdown-item-top">
                                                    <span class="dropdown-item-name text-truncate">{{ $notifUserName }}</span>
                                                    <div class="dropdown-item-meta">
                                                        <span class="dropdown-item-time">
                                                            {{\Carbon\Carbon::parse($notification->created_at)->setTimezone('Europe/Istanbul')->format('H:i')}}
                                                        </span>
                                                        <span class="dropdown-item-date">
                                                            {{\Carbon\Carbon::parse($notification->created_at)->setTimezone('Europe/Istanbul')->format('d.m.Y')}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="dropdown-item-message">
                                                    {{$notification->message}}
                                                </div>
                                            </div>
                                        @if(!$notification->is_read)
                                            <span class="unread-dot"></span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="modern-dropdown-empty">
                                        <div class="empty-icon">
                                            <i class="fa-regular fa-bell-slash"></i>
                                        </div>
                                        <h6>Bildiriminiz Yok</h6>
                                        <p>Yeni bir bildirim aldığınızda burada görüntülenecektir.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="hr-box mobile-header-avatar">
                        <a id="desktop-profile-trigger" class="hr-logo navbar-avatar-btn d-none d-lg-inline-flex" role="button" aria-label="Profilim">
                            @php
                            $user = auth()->user();
                            $avatarPath = 'site/images/default_avatar.jpg';

                            if ($user->user_type == 'user' && $user->informations?->avatar) {
                                $avatarPath = $user->informations->avatar;
                            } elseif ($user->user_type == 'company' && $user->company?->avatar) {
                                $avatarPath = $user->company->avatar;
                            }

                            $isCompany = $user->user_type == 'company';
                            $profileName = $isCompany
                                ? ($user->company?->name ?: $user->name)
                                : ($user->informations?->name ?: $user->name);
                            $profileEmail = $user->email;
                            $profileRoleBadge = $isCompany ? 'Kurumsal Firma' : 'Bireysel Kullanıcı';
                            $dashboardRoute = route($isCompany ? 'company.dashboard' : 'user.dashboard');
                            @endphp
                            <img src="{{asset($avatarPath)}}" alt="Avatar">
                            <span class="navbar-avatar-status" title="Çevrimiçi"></span>
                        </a>

                        <div id="login-right-dropdown" class="login-right-dropdown modern-profile-dropdown">
                            <div class="profile-dropdown-sheet">
                                <div class="profile-mobile-header d-flex d-lg-none align-items-center justify-content-end">
                                    <button type="button" class="mobile-dropdown-close profile-mobile-close" aria-label="Kapat">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>

                                <div class="profile-dropdown-user-card">
                                    <div class="profile-user-avatar">
                                        <img src="{{ asset($avatarPath) }}" alt="{{ $profileName }}">
                                    </div>
                                    <div class="profile-user-info">
                                        <div class="profile-user-name text-truncate" title="{{ $profileName }}">{{ $profileName }}</div>
                                        <div class="profile-user-email text-truncate">{{ $profileEmail }}</div>
                                        <div class="profile-user-badge {{ $isCompany ? 'company' : 'individual' }}">
                                            <i class="fa-solid {{ $isCompany ? 'fa-building' : 'fa-circle-check' }} me-1"></i>
                                            {{ $profileRoleBadge }}
                                        </div>
                                    </div>
                                </div>

                                <div class="profile-dropdown-divider"></div>

                                <ul class="profile-dropdown-menu">
                                    <li>
                                        <a href="{{ $dashboardRoute }}" class="profile-menu-link">
                                            <span class="profile-menu-icon"><i class="fa-regular fa-user"></i></span>
                                            <span class="profile-menu-label">Profilim ve Panel</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('chat.show')}}" class="profile-menu-link">
                                            <span class="profile-menu-icon"><i class="fa-regular fa-comment-dots"></i></span>
                                            <span class="profile-menu-label">Mesajlarım</span>
                                            @if($sharedUnreadMsgCount > 0)
                                                <span class="profile-badge-pill">{{ $sharedUnreadMsgCount }}</span>
                                            @endif
                                        </a>
                                    </li>

                                    @if($isCompany)
                                    <li>
                                        <a href="{{route('company.services.index')}}" class="profile-menu-link">
                                            <span class="profile-menu-icon"><i class="fa-solid fa-briefcase"></i></span>
                                            <span class="profile-menu-label">Hizmetlerim</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('company.subscriptions.index')}}" class="profile-menu-link">
                                            <span class="profile-menu-icon"><i class="fa-solid fa-gem"></i></span>
                                            <span class="profile-menu-label">Aboneliğim</span>
                                        </a>
                                    </li>
                                    @endif

                                    <li>
                                        <a href="{{route('idea.profile.index')}}" class="profile-menu-link">
                                            <span class="profile-menu-icon"><i class="fa-regular fa-lightbulb"></i></span>
                                            <span class="profile-menu-label">Fikirlerim</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ $isCompany ? route('company.saved-services') : route('user.saved-services') }}" class="profile-menu-link">
                                            <span class="profile-menu-icon"><i class="fa-regular fa-bookmark"></i></span>
                                            <span class="profile-menu-label">Kaydedilenler</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="profile-dropdown-divider"></div>

                                <div class="profile-dropdown-footer">
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="redirect" value="{{ url()->current() }}">
                                        <button type="submit" class="profile-logout-btn">
                                            <span class="profile-menu-icon logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
                                            <span>Çıkış Yap</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->user_type == 'company')
                    <div class="hr-box service-link d-none d-lg-block">
                        <a href="{{route('company.services.create')}}">
                            <i class="fa-solid fa-plus me-1"></i> Hizmet Ekle
                        </a>
                    </div>

                    @elseif(auth()->user()->user_type == 'user')
                    <div class="hr-box service-link d-none d-lg-block">
                        <a href="{{route('idea.create')}}">
                            <i class="fa-solid fa-plus me-1"></i> Fikir Ekle
                        </a>
                    </div>
                    @endif
                    @endif
                    @endauth

                    @guest()
                    <div class="hr-box d-none d-lg-block ms-2">
                        <a href="#exampleModalToggle" data-bs-toggle="modal" class="navbar-guest-btn" role="button">
                            <i class="fa-regular fa-user"></i>
                            <span>Giriş Yap / Kayıt Ol</span>
                        </a>
                    </div>
                    @endguest
                </div>
                {{-- <div class="header-right-mobile">--}}
                {{-- <div class="header-mobil-search" @guest() style="position:relative; top: 11px;" @endguest>--}}
                {{-- <div class="header-m-search-trigger">--}}
                {{-- <i class="fa-solid fa-magnifying-glass"></i>--}}
                {{-- </div>--}}
                {{-- <div class="header-mobil-search-area">--}}
                {{-- <div class="hmsa-title d-flex">--}}
                {{-- <div class="hmsa-close">--}}
                {{-- <i class="fa-solid fa-angle-left"></i>--}}
                {{-- </div>--}}
                {{-- <div class="hmsa-search">--}}
                {{-- <input type="text" placeholder="Hizmet veya Firma ara...">--}}
                {{-- <i class="fa-solid fa-magnifying-glass"></i>--}}
                {{-- </div>--}}
                {{-- </div>--}}
                {{-- <div class="hmsa-dropdown">--}}
                {{-- <ul>--}}
                {{-- <li>--}}
                {{-- <a href="#">--}}
                {{-- 3+1 Daire--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- <li>--}}
                {{-- <a href="#">--}}
                {{-- 3+1 Müstakil Ev--}}
                {{-- </a>--}}
                {{-- </li>--}}
                {{-- </ul>--}}
                {{-- </div>--}}
                {{-- </div>--}}
                {{-- </div>--}}

                {{-- @auth()--}}
                {{-- @if(auth()->user()->user_type != 'admin')--}}
                {{-- <div class="header-mobil-notif d-none">--}}
                {{-- <div id="user-notif" class="hr-box hr-msg">--}}
                {{-- <a id="user-notif-trigger2" href="#" data-bs-container="body"--}}
                {{-- data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Bildirimler">--}}
                {{-- <i class="fa-solid fa-bell"></i>--}}
                {{-- <div class="hr-count">--}}
                {{-- <span> 3 </span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- <div id="user-natif-dropdown2" class="user-messages-dropdown ums-mobil">--}}
                {{-- <div class="um-dropdown-head d-flex">--}}
                {{-- <h4>--}}
                {{-- Bildirimler (3)--}}
                {{-- </h4>--}}
                {{-- <div class="usm-mobil-close">--}}
                {{-- x--}}
                {{-- </div>--}}
                {{-- </div>--}}
                {{-- <div class="ums-box">--}}
                {{-- <div class="ums-area d-flex actived">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- sizi takip etmeye başladı--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- <div class="ums-dates d-flex">--}}
                {{-- <span>--}}
                {{-- 18.30--}}
                {{-- </span>--}}
                {{-- <span>--}}
                {{-- Dün--}}
                {{-- </span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- <div class="ums-area d-flex">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- Hİzmetinizi beğendi.--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- <div class="ums-dates d-flex">--}}
                {{-- <span>--}}
                {{-- 18.30--}}
                {{-- </span>--}}
                {{-- <span>--}}
                {{-- Dün--}}
                {{-- </span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- <div class="ums-area d-flex">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- Hİzmetinizi beğendi.--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- <div class="ums-dates d-flex">--}}
                {{-- <span>--}}
                {{-- 18.30--}}
                {{-- </span>--}}
                {{-- <span>--}}
                {{-- Dün--}}
                {{-- </span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- <div class="ums-area d-flex">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- sizi takip etmeye başladı--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- <div class="ums-area d-flex">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- Hİzmetinizi beğendi.--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- <div class="ums-dates d-flex">--}}
                {{-- <span>--}}
                {{-- 18.30--}}
                {{-- </span>--}}
                {{-- <span>--}}
                {{-- Dün--}}
                {{-- </span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- <div class="ums-area d-flex">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- Hİzmetinizi beğendi.--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- <div class="ums-dates d-flex">--}}
                {{-- <span>--}}
                {{-- 18.30--}}
                {{-- </span>--}}
                {{-- <span>--}}
                {{-- Dün--}}
                {{-- </span>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- <div class="ums-area d-flex">--}}
                {{-- <a href="#">--}}
                {{-- <div class="ums-img">--}}
                {{-- <img src="https://fakeimg.pl/40x40" alt="">--}}
                {{-- </div>--}}
                {{-- <div class="ums-text d-flex">--}}
                {{-- <h5>--}}
                {{-- Ahmet AK--}}
                {{-- </h5>--}}
                {{-- <p>--}}
                {{-- sizi takip etmeye başladı--}}
                {{-- </p>--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- </div>--}}
                {{-- </div>--}}

                {{-- </div>--}}
                {{-- </div>--}}
                {{-- </div>--}}

                {{-- <div class="header-mobil-message d-none ">--}}
                {{-- <div id="user-messages" class="hr-box hr-msg">--}}
                {{-- <a id="user-messages-trigger2" href="#" data-bs-container="body"--}}
                {{-- data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Bottom popover">--}}
                {{-- <i class="fa-solid fa-envelope"></i>--}}
                {{-- <div class="hr-count">--}}
                {{-- <span class="unread-msg-count">--}}
                {{-- {{ \App\Models\Message::where('receiver_id', Auth::id())--}}
                {{-- ->where('is_read', false)->count() }}--}}
                {{-- </div>--}}
                {{-- </a>--}}
                {{-- <div id="user-messages-dropdown2" class="user-messages-dropdown ums-mobil">--}}
                {{-- <div class="um-dropdown-head d-flex">--}}
                {{-- <h4>--}}
                {{-- <a href="{{route('chat.show')}}">Mesajlar <span--}}
                    {{--                                                            class="unread-msg-count">--}}
                    {{--                                                    {{ '(' . \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count() . ')' }}--}}
                    {{--                                                </a>--}}
                    {{--                                            </h4>--}}
                    {{--                                            <div class="usm-mobil-close">--}}
                    {{--                                                x--}}
                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                        <div class="ums-box msg-ums-box">--}}
                    {{--                                            @php--}}
                    {{--                                                $unreadMessages = \App\Models\Message::with(['sender.informations', 'sender.company'])--}}
                    {{--                                                    ->where('receiver_id', Auth::id())--}}
                    {{--                                                    ->where('is_read', false)  // Sadece okunmamış mesajlar--}}
                    {{--                                                    ->orderBy('created_at', 'desc')--}}
                    {{--                                                    ->get();--}}
                    {{--                                            @endphp--}}

                    {{--                                            @foreach($unreadMessages as $message)--}}
                    {{--                                                <div class="ums-area d-flex actived">--}}
                    {{--                                                    <a href="{{ route('chat.show', $message->sender_id) }}">--}}
                    {{-- <div class="ums-img">--}}
                    {{-- <img src="{{ asset($message->sender->user_type === 'user' ?--}}
                    {{-- $message?->sender?->informations?->avatar :--}}
                    {{-- $message?->sender?->company?->avatar) }}"--}}
                    {{-- alt="Avatar" style="width: 40px; height: 40px">--}}
                    {{-- </div>--}}
                    {{-- <div class="ums-text d-flex">--}}
                    {{-- <h5>--}}
                    {{-- {{ $message->sender->user_type === 'user' ?--}}
                    {{-- $message->sender->informations?->name :--}}
                    {{-- $message->sender->company?->name }}--}}
                    {{-- </h5>--}}
                    {{-- <p>--}}
                    {{-- {{ $message->message }}--}}
                    {{-- </p>--}}
                    {{-- <div class="ums-dates d-flex">--}}
                    {{-- <span>--}}
                    {{-- {{ \Carbon\Carbon::parse($message->created_at)--}}
                    {{-- ->setTimezone('Europe/Istanbul')--}}
                    {{-- ->format('H:i') }}--}}
                    {{-- </span>--}}
                    {{-- <span>--}}
                    {{-- {{ \Carbon\Carbon::parse($message->created_at)--}}
                    {{-- ->setTimezone('Europe/Istanbul')--}}
                    {{-- ->format('d-m-Y') }}--}}
                    {{-- </span>--}}
                    {{-- </div>--}}
                    {{-- </div>--}}
                    {{-- </a>--}}
                    {{-- </div>--}}
                    {{-- @endforeach--}}
                    {{-- </div>--}}
                    {{-- </div>--}}
                    {{-- </div>--}}
                    {{-- </div>--}}
                    {{-- <!-- header-mobil-login login öncesi -->--}}

                    {{-- <div class="header-mobil-login d-none">--}}
                    {{-- <div class="header-right-trigger">--}}
                    {{-- <i class="fa-solid fa-user"></i>--}}
                    {{-- </div>--}}

                    {{-- <!-- login-right-dropdown login sonrası -->--}}
                    {{-- --}}{{-- <div id="login-right-dropdown" class="login-right-dropdown" style="display: none;">--}}
                    {{-- --}}{{-- <ul>--}}
                    {{-- --}}{{-- <li>--}}
                    {{-- --}}{{-- <a href="{{route(auth()->user()->user_type == 'user' ? 'user.dashboard' : 'company.dashboard')}}">--}}
                    {{-- --}}{{-- Profilim--}}
                    {{-- --}}{{-- </a>--}}
                    {{-- --}}{{-- </li>--}}
                    {{-- --}}{{-- <li>--}}
                    {{-- --}}{{-- <a href="{{route('chat.show')}}">--}}
                    {{-- --}}{{-- Mesajlarım--}}
                    {{-- --}}{{-- </a>--}}
                    {{-- --}}{{-- </li>--}}
                    {{-- --}}{{-- <li>--}}
                    {{-- --}}{{-- <a href="#">--}}
                    {{-- --}}{{-- Analizler--}}
                    {{-- --}}{{-- </a>--}}
                    {{-- --}}{{-- </li>--}}
                    {{-- --}}{{-- <li>--}}
                    {{-- --}}{{-- <a href="#">--}}
                    {{-- --}}{{-- Kaydedilenler--}}
                    {{-- --}}{{-- </a>--}}
                    {{-- --}}{{-- </li>--}}
                    {{-- --}}{{-- <li>--}}
                    {{-- --}}{{-- <form action="{{route('logout')}}" method="POST">--}}

                    {{-- --}}{{-- @csrf--}}
                    {{-- --}}{{-- <a href="#" style="color: red" onclick="this.closest('form').submit()">--}}
                    {{-- --}}{{-- Çıkış Yap--}}
                    {{-- --}}{{-- </a>--}}
                    {{-- --}}{{-- </form>--}}
                    {{-- --}}{{-- </li>--}}
                    {{-- --}}{{-- </ul>--}}
                    {{-- --}}{{-- </div>--}}
                    {{-- <!-- // -->--}}
                    {{-- @endif--}}
                    {{-- @endauth--}}

                    {{-- @guest()--}}
                    {{-- <div class="header-right-trigger" data-bs-toggle="modal" href="#exampleModalToggle">--}}
                    {{-- <i class="fa-solid fa-user"></i>--}}
                    {{-- </div>--}}
                    {{-- @endguest--}}

                    {{-- </div>--}}

                    {{-- </div>--}}
            </div>
        </div>
    </div>
</header>

<div class="mobile-fixed-menu">
    <ul>
        <li @class(['actived'=> Route::is('site.home')])>
            <a href="/">
                <i class="fa-solid fa-house"></i>
                <span>
                    Anasayfa
                </span>
            </a>
        </li>
        <li @class(['actived'=> Route::is('services.index')])>
            <a href="{{route('services.index')}}">
                <i class="fa-solid fa-business-time"></i>
                <span>
                    Hizmetler
                </span>
            </a>
        </li>
        <li class="center-plus">

        </li>
        <li @class(['actived'=> Route::is('idea.index')])>
            <a href="{{route('idea.index')}}">
                <i class="fa-solid fa-comment"></i>
                <span>
                    Fikir Köşesi
                </span>
            </a>
        </li>
        <li @class(['actived'=> Route::is('companies.index')])>
            <a href="{{route('companies.index')}}">
                <i class="fa-solid fa-building"></i>
                <span>
                    Firma Bul
                </span>
            </a>
        </li>
    </ul>


    <div class="plus" data-bs-toggle="modal" data-bs-target="#fikirhizmetmodal">
        <i class="fa-solid fa-plus"></i>
    </div>

</div>

@auth

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const markAllBtns = document.querySelectorAll('.mark-all-notifications-btn');

        markAllBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (btn.disabled) return;

                btn.disabled = true;
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>İşleniyor...</span>';

                fetch('{{ route("notifications.read") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ all: true })
                })
                .then(response => response.json())
                .then(data => {
                    // Tüm okunmamış kartları okundu olarak güncelle
                    document.querySelectorAll('.notification-link').forEach(link => {
                        link.classList.remove('unread');
                    });
                    document.querySelectorAll('.unread-dot').forEach(dot => {
                        dot.remove();
                    });

                    // Badge sayılarını sıfırla ve gizle
                    document.querySelectorAll('.notification-count').forEach(badge => {
                        badge.textContent = '0';
                    });
                    document.querySelectorAll('#user-notif .hr-count, #user-notif-trigger .hr-count, #user-notif-trigger2 .hr-count').forEach(el => {
                        el.style.display = 'none';
                    });

                    // Başlık altındaki yazıyı güncelle
                    document.querySelectorAll('#user-natif-dropdown .dropdown-header-subtitle, #user-natif-dropdown2 .mobile-header-subtitle').forEach(sub => {
                        sub.textContent = 'Tümü okundu';
                    });

                    // Butonları güncelle
                    markAllBtns.forEach(b => {
                        b.disabled = true;
                        b.classList.add('is-read');
                        b.innerHTML = '<span>Tümü Okundu</span>';
                    });
                })
                .catch(error => {
                    console.error('Bildirimler okundu işaretlenemedi:', error);
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
            });
        });

        // Tekil bildirime tıklandığında okundu yap
        document.querySelectorAll('.notification-link').forEach(link => {
            link.addEventListener('click', function() {
                const notificationId = this.getAttribute('data-notification-id');
                if (notificationId && this.classList.contains('unread')) {
                    this.classList.remove('unread');
                    const dot = this.querySelector('.unread-dot');
                    if (dot) dot.remove();

                    // Sayacı azalt
                    const badge = document.querySelector('.notification-count');
                    if (badge) {
                        let count = parseInt(badge.textContent) || 0;
                        count = Math.max(0, count - 1);
                        document.querySelectorAll('.notification-count').forEach(b => b.textContent = count);
                        if (count === 0) {
                            document.querySelectorAll('#user-notif .hr-count, #user-notif-trigger .hr-count, #user-notif-trigger2 .hr-count').forEach(el => {
                                el.style.display = 'none';
                            });
                            document.querySelectorAll('#user-natif-dropdown .dropdown-header-subtitle, #user-natif-dropdown2 .mobile-header-subtitle').forEach(sub => {
                                sub.textContent = 'Tümü okundu';
                            });
                            markAllBtns.forEach(b => {
                                b.disabled = true;
                                b.classList.add('is-read');
                                b.innerHTML = '<span>Tümü Okundu</span>';
                            });
                        }
                    }

                    fetch('{{ route("notifications.read") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ids: [parseInt(notificationId)] })
                    }).catch(err => console.error(err));
                }
            });
        });
    });
</script>
@endauth