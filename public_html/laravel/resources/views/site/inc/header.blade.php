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
                    <div class="header-logo m-0 mt-md-2">
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
                        <div class="header-search-icon-left">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input id="header-search-input" type="text" class="searchInput"
                            placeholder="Hizmet veya firma ara..." autocomplete="off">
                        <div class="header-search-badge" title="Arama">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </div>
                    <style>
                        #resultsArea .h6 {
                            font-size: 15px;
                            font-weight: 500;

                        }

                        #resultsArea .search-scroll {
                            font-size: 14px;

                        }
                    </style>
                    <div class="header-search-area" id="resultsArea">
                        <h6 class="text-primary  fw-normal mt-3">Hizmetler</h6>
                        <div id="services" class="search-scroll">Yeni</div>
                        <h6 class="text-primary fw-normal mt-3">Fikirler</h6>
                        <div id="ideas" class="search-scroll">Fikir Bulunamadı </div>
                        <h6 class="text-primary fw-normal mt-3">Firmalar</h6>
                        <div id="companies" class="search-scroll">Firma Bulunamadı </div>

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
                        @if(auth()->user()->user_type != 'admin')
                        <div class="header-mobil-message">
                            <div id="user-messages" class="hr-box hr-msg m-0 p-0">
                                <a id="user-messages-trigger2" href="#" class="navbar-icon-btn navbar-btn-message" role="button" aria-label="Mesajlar">
                                    <i class="fa-regular fa-comment-dots"></i>
                                    @php
                                        $mobileUnreadMsgCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                                    @endphp
                                    <div class="hr-count" @if($mobileUnreadMsgCount == 0) style="display:none;" @endif>
                                        <span class="unread-msg-count">{{ $mobileUnreadMsgCount }}</span>
                                    </div>
                                </a>
                                <div id="user-messages-dropdown2" class="user-messages-dropdown ums-mobil">
                                    <div class="um-dropdown-head d-flex">
                                        <h4>
                                            <a href="{{route('chat.show')}}">Mesajlar <span
                                                    class="unread-msg-count">
                                                    {{ '(' . \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count() . ')' }}
                                            </a>
                                        </h4>
                                        <div class="usm-mobil-close">
                                            x
                                        </div>
                                    </div>
                                    <div class="ums-box msg-ums-box">
                                        @php
                                        $allMessages = \App\Models\Message::with(['sender.informations', 'sender.company'])
                                        ->where('receiver_id', Auth::id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

                                        // Mesajları gönderenlere göre grupla
                                        $groupedMessages = $allMessages->groupBy('sender_id')->map(function ($messages) {
                                        return [
                                        'latest_message' => $messages->first(),
                                        'unread_count' => $messages->where('is_read', false)->count(),
                                        ];
                                        });
                                        @endphp

                                        @foreach($groupedMessages as $senderId => $data)
                                        @php
                                        $message = $data['latest_message'];
                                        $unreadCount = $data['unread_count'];
                                        @endphp
                                        <div class="ums-area d-flex actived">
                                            <a href="{{ route('chat.show', $message->sender_id) }}" style="width: 100%; position: relative;">
                                                <div class="ums-img">
                                                    <img src="{{ asset($message->sender->user_type === 'user' ?
                                                                                            $message?->sender?->informations?->avatar :
                                                                                            $message?->sender?->company?->avatar) }}"
                                                        alt="Avatar" style="width: 40px; height: 40px">
                                                </div>
                                                <div class="ums-text d-flex" style="flex: 1;">
                                                    <h5>
                                                        {{ $message->sender->user_type === 'user' ?
                                                                        $message->sender->informations?->name :
                                                                        $message->sender->company?->name }}
                                                    </h5>
                                                    <div class="ums-dates d-flex">
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($message->created_at)
                                                                                                    ->setTimezone('Europe/Istanbul')
                                                                                                    ->format('H:i') }}
                                                        </span>
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($message->created_at)
                                                                                                    ->setTimezone('Europe/Istanbul')
                                                                                                    ->format('d-m-Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                @if($unreadCount > 0)
                                                <span style="position: absolute; right: 10px; top: 10px; background-color: #4068e2; color: white; border-radius: 50%; min-width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; padding: 0 5px;">
                                                    {{ $unreadCount }}
                                                </span>
                                                @endif
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="header-mobil-notif">
                            <div id="user-notif" class="hr-box hr-msg m-0 p-0">
                                <a id="user-notif-trigger2" href="#" class="navbar-icon-btn navbar-btn-notif"
                                    data-bs-container="body"
                                    data-bs-trigger="click"
                                    data-bs-toggle="popover"
                                    data-bs-placement="bottom"
                                    data-bs-content="Bildirimler"
                                    role="button"
                                    aria-label="Bildirimler">
                                    <i class="fa-regular fa-bell"></i>
                                    @php
                                        $mobileUnreadNotifCount = user_notifications()['unread_count'] ?? 0;
                                    @endphp
                                    <div class="hr-count" @if($mobileUnreadNotifCount == 0) style="display:none;" @endif>
                                        <span class="notification-count">{{ $mobileUnreadNotifCount }}</span>
                                    </div>
                                </a>
                                <div id="user-natif-dropdown2" class="user-messages-dropdown ums-mobil">
                                    <div class="um-dropdown-head d-flex">
                                        <h4>
                                            Bildirimler (<span class="notification-count">
                                                {{user_notifications()['unread_count']}}
                                            </span>)
                                        </h4>
                                        <div class="usm-mobil-close">
                                            x
                                        </div>
                                    </div>
                                    <div class="ums-box">
                                        @forelse(user_notifications()['values'] as $notification)
                                        <div @class(["ums-area d-flex", "actived"=> !$notification->is_read])>
                                            <a href="{{$notification->link ?? 'javascript:void(0)'}}"
                                                class="notification-link"
                                                data-notification-id="{{$notification->id}}">
                                                <div class="ums-img">
                                                    @php
                                                    $user = auth_info($notification->user_id);
                                                    @endphp

                                                    @if($user)
                                                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                                                    @else
                                                    <img src="{{ asset('default-avatar.png') }}" alt="Kullanıcı bulunamadı">
                                                    @endif

                                                </div>
                                                <div class="ums-text d-flex">
                                                    <h5>
                                                        @php
                                                        $user = auth_info($notification->user_id);
                                                        @endphp

                                                        {{ $user?->name ?? 'Bilinmeyen Kullanıcı' }}

                                                    </h5>
                                                    <p>
                                                        {{$notification->message}}
                                                    </p>
                                                </div>
                                                <div class="ums-dates d-flex">
                                                    <span>
                                                        {{\Carbon\Carbon::parse($notification->created_at)
                                                                    ->setTimezone('Europe/Istanbul')->format('H:i')}}
                                                    </span>
                                                    <span>
                                                        {{\Carbon\Carbon::parse($notification->created_at)
                                                                    ->setTimezone('Europe/Istanbul')->format('d-m-Y')}}
                                                    </span>
                                                </div>
                                            </a>
                                        </div>

                                        @empty
                                        <div class="ums-area d-flex actived">
                                            <a href="javascript:void(0)">
                                                <div class="ums-text d-flex">
                                                    <p>Bildirim bulunmamaktadır.</p>
                                                </div>
                                            </a>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif
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
                            @php
                                $desktopUnreadMsgCount = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                            @endphp
                            <div class="hr-count" @if($desktopUnreadMsgCount == 0) style="display:none;" @endif>
                                <span class="unread-msg-count">{{ $desktopUnreadMsgCount }}</span>
                            </div>
                        </a>
                        <div id="user-messages-dropdown" class="user-messages-dropdown">
                            <div class="um-dropdown-head d-flex">
                                <h4>
                                    Mesajlar <span class="unread-msg-count">
                                        {{ '(' . \App\Models\Message::where('receiver_id', Auth::id())
                                                    ->where('is_read', false)->count() . ')' }}
                                    </span>
                                </h4>

                                <a href="{{route('chat.show')}}">Tüm Mesajlar</a>
                            </div>
                            <div class="ums-box msg-ums-box">
                                @php
                                $allMessages = \App\Models\Message::with(['sender.informations', 'sender.company'])
                                ->where('receiver_id', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->get();

                                // Mesajları gönderenlere göre grupla
                                $groupedMessages = $allMessages->groupBy('sender_id')->map(function ($messages) {
                                return [
                                'latest_message' => $messages->first(),
                                'unread_count' => $messages->where('is_read', false)->count(),
                                ];
                                });
                                @endphp

                                @foreach($groupedMessages as $senderId => $data)
                                @php
                                $message = $data['latest_message'];
                                $unreadCount = $data['unread_count'];
                                @endphp
                                <div class="ums-area d-flex actived">
                                    <a href="{{ route('chat.show', $message->sender_id) }}" style="width: 100%; position: relative;">
                                        <div class="ums-img">
                                            <img src="{{ asset($message->sender->user_type === 'user'
                                                            ? $message?->sender?->informations?->avatar
                                                            : $message?->sender?->company?->avatar) }}"
                                                alt="Avatar" style="width: 40px; height: 40px">
                                        </div>
                                        <div class="ums-text d-flex" style="flex: 1;">
                                            <h5>
                                                {{ $message->sender->user_type === 'user'
                                                                ? $message->sender?->informations?->name
                                                                : $message->sender?->company?->name }}
                                            </h5>
                                            <div class="ums-dates d-flex">
                                                <span>
                                                    {{ \Carbon\Carbon::parse($message->created_at)
                                                                    ->setTimezone('Europe/Istanbul')
                                                                    ->format('H:i') }}
                                                </span>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($message->created_at)
                                                                    ->setTimezone('Europe/Istanbul')
                                                                    ->format('d-m-Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        @if($unreadCount > 0)
                                        <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background-color: #4068e2; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600;">
                                            {{ $unreadCount }}
                                        </span>
                                        @endif
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div id="user-notif" class="hr-box hr-msg d-none d-lg-block">
                        <a id="user-notif-trigger" href="#"
                            class="navbar-icon-btn navbar-btn-notif position-relative"
                            onclick="notificationToggle(event)"
                            role="button"
                            aria-label="Bildirimler">
                            <i class="fa-regular fa-bell"></i>
                            @php
                                $desktopUnreadNotifCount = user_notifications()['unread_count'] ?? 0;
                            @endphp
                            <div class="hr-count" @if($desktopUnreadNotifCount == 0) style="display:none;" @endif>
                                <span class="notification-count">{{ $desktopUnreadNotifCount }}</span>
                            </div>
                        </a>
                        <div id="user-natif-dropdown" class="user-messages-dropdown">
                            <div class="um-dropdown-head d-flex">
                                <h4>
                                    Bildirimler (<span class="notification-count">
                                        {{user_notifications()['unread_count']}}
                                    </span>)
                                </h4>
                            </div>
                            <div class="ums-box">
                                @forelse(user_notifications()['values'] as $notification)
                                <div @class(["ums-area d-flex", "actived"=> !$notification->is_read])>
                                    <a href="{{$notification->link ?? 'javascript:void(0)'}}"
                                        class="notification-link"
                                        data-notification-id="{{$notification->id}}">
                                        <div class="ums-img">
                                            @php
                                            $user = auth_info($notification->user_id);
                                            @endphp
                                            <img src="{{ asset($user?->avatar ?? 'assets/img/default-avatar.png') }}"
                                                alt="{{ $user?->name ?? 'Bilinmeyen Kullanıcı' }}">

                                        </div>
                                        <div class="ums-text d-flex">
                                            <h5>
                                                {{ auth_info($notification->user_id)?->name ?? 'Bilinmeyen Kullanıcı' }}
                                            </h5>

                                            <p>
                                                {{$notification->message}}
                                            </p>
                                        </div>
                                        <div class="ums-dates d-flex">
                                            <span  style="margin-top:15px !important;">
                                                {{\Carbon\Carbon::parse($notification->created_at)
                                                            ->setTimezone('Europe/Istanbul')->format('H:i')}}
                                            </span>
                                            <span style="margin-top:15px !important;">
                                                {{\Carbon\Carbon::parse($notification->created_at)
                                                            ->setTimezone('Europe/Istanbul')->format('d-m-Y')}}
                                            </span>
                                        </div>
                                    </a>
                                </div>

                                @empty
                                <div class="ums-area d-flex actived">
                                    <a href="javascript:void(0)">
                                        <div class="ums-text d-flex">
                                            <p>Bildirim bulunmamaktadır.</p>
                                        </div>
                                    </a>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="hr-box mobile-header-avatar">
                        <a class="hr-logo navbar-avatar-btn" data-bs-container="body" data-bs-trigger="hover focus"
                            data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Profilim" role="button" aria-label="Profilim">
                            @php
                            $user = auth()->user();
                            $avatarPath = 'site/images/default_avatar.jpg';

                            if ($user->user_type == 'user' && $user->informations?->avatar) {
                            $avatarPath = $user->informations->avatar;
                            } elseif ($user->user_type == 'company' && $user->company?->avatar) {
                            $avatarPath = $user->company->avatar;
                            }
                            @endphp
                            <img src="{{asset($avatarPath)}}" alt="Avatar">
                            <span class="navbar-avatar-status" title="Çevrimiçi"></span>
                        </a>

                        <!-- login-right-dropdown classı login sonrası -->

                        <div id="login-right-dropdown" class="login-right-dropdown">
                            <ul>
                                <li>
                                    <a href="{{route(auth()->user()->user_type == 'user' ? 'user.dashboard' : 'company.dashboard')}}">
                                        <i class="fa-solid fa-user"></i>
                                        Profilim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('chat.show')}}">
                                        <i class="fa-solid fa-message"></i>
                                        Mesajlarım
                                    </a>
                                </li>
                                @if(auth()->user()->user_type == 'company')
                                <li>
                                    <a href="{{route('company.services.index')}}">
                                        <i class="fa-solid fa-business-time"></i>
                                        Hizmetlerim
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('company.subscriptions.index')}}">
                                        <i class="fa-solid fa-box"></i>
                                        Aboneliğim
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{route('idea.profile.index')}}">
                                        <i class="fa-solid fa-comment"></i>
                                        Fikirlerim
                                    </a>
                                </li>
                                {{-- <li>--}}
                                {{-- <a href="#">--}}
                                {{-- Analizler--}}
                                {{-- </a>--}}
                                {{-- </li>--}}
                                <li>
                                    <a href="{{ auth()->user()->user_type == 'user' ? route('user.saved-services')
                                                : route('company.saved-services') }}">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Kaydedilenler
                                    </a>
                                </li>
                                <li>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="redirect" value="{{ url()->current() }}">
                                        <a href="#" style="color: red" onclick="this.closest('form').submit()">
                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                            Çıkış Yap
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- // -->
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
        // Bildirim dropdown açıldığında tüm bildirimleri okundu yap
        const notificationTriggers = document.querySelectorAll('#user-notif-trigger, #user-notif-trigger2');

        notificationTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                // Tüm okunmamış bildirimlerin ID'lerini topla
                const notificationLinks = document.querySelectorAll('.notification-link');
                const notificationIds = [];

                notificationLinks.forEach(link => {
                    const notificationId = link.getAttribute('data-notification-id');
                    if (notificationId) {
                        notificationIds.push(parseInt(notificationId));
                    }
                });

                // Eğer okunmamış bildirim varsa, hepsini okundu yap
                if (notificationIds.length > 0) {
                    fetch('/notifications/read', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                ids: notificationIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Badge sayısını sıfırla ve gizle
                            const badges = document.querySelectorAll('.hr-count span, .notification-count');
                            badges.forEach(badge => {
                                badge.textContent = '0';
                            });
                            const notifCounts = document.querySelectorAll('#user-notif .hr-count, #user-notif-trigger .hr-count, #user-notif-trigger2 .hr-count');
                            notifCounts.forEach(el => {
                                el.style.display = 'none';
                            });

                            // Actived class'larını kaldır
                            const activedNotifications = document.querySelectorAll('.ums-area.actived');
                            activedNotifications.forEach(notif => {
                                notif.classList.remove('actived');
                            });
                        })
                        .catch(error => {
                            console.error('Bildirimler okundu işaretlenemedi:', error);
                        });
                }
            });
        });
    });
</script>
@endauth