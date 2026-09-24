<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">

            {{-- 1. Dashboard --}}
            <li class="menu-item {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Panel">Panel</div>
                </a>
            </li>

            {{-- 2. İçerik Yönetimi --}}
            @php
                $isContent = request()->routeIs('admin.categories.*')
                          || request()->routeIs('admin.pages.*')
                          || request()->routeIs('admin.sliders.*')
                          || request()->routeIs('admin.settings.*')
                          || request()->routeIs('admin.about.*')
                          || request()->routeIs('admin.emails.*')
                          || request()->routeIs('admin.analytics.*');
            @endphp
            <li class="menu-item {{ $isContent ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div data-i18n="İçerik">İçerik</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.categories.index') }}" class="menu-link">
                            <div data-i18n="Kategoriler">Kategoriler</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.pages.index') }}" class="menu-link">
                            <div data-i18n="Sayfalar">Sayfalar</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.sliders.index') }}" class="menu-link">
                            <div data-i18n="Slider">Slider</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.email-templates.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.email-templates.index') }}" class="menu-link">
                            <div data-i18n="Email">Email Şablonları</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.emails.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.emails.index') }}" class="menu-link">
                            <div data-i18n="Bildirim E-postaları">Bildirim E-postaları</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.analytics.index') }}" class="menu-link">
                            <div data-i18n="Analizler">Analizler</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.edit') }}" class="menu-link">
                            <div data-i18n="Ayarlar">Ayarlar</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.about.index') }}" class="menu-link">
                            <div data-i18n="Hakkımızda">Hakkımızda</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                        <a href="{{ route('clear.cache') }}" class="menu-link">
                            <div data-i18n="Cache Temizle">Cache Temizle</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.backup.index') }}" class="menu-link">
                            <div data-i18n="Yedek Alma">Yedek Alma</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- 3. Firma Yönetimi --}}
            @php
                $isCompanies = request()->routeIs('admin.companies.*');
            @endphp
            <li class="menu-item {{ $isCompanies ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-building"></i>
                    <div data-i18n="Firmalar">Firmalar</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.companies.index') && request()->route()->parameter('status') === null ? 'active' : '' }}">
                        <a href="{{ route('admin.companies.index') }}" class="menu-link">
                            <div data-i18n="Tümü">Tümü</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.companies.index','active') ? 'active' : '' }}">
                        <a href="{{ route('admin.companies.index','active') }}" class="menu-link">
                            <div data-i18n="Aktif">Aktif</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.companies.index','passive') ? 'active' : '' }}">
                        <a href="{{ route('admin.companies.index','passive') }}" class="menu-link">
                            <div data-i18n="Pasif">Pasif</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- 4. Hizmet Yönetimi --}}
            @php
                $isServices = request()->routeIs('admin.services.*');
            @endphp
            <li class="menu-item {{ $isServices ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="Hizmetler">Hizmetler</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.services.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.services.index') }}" class="menu-link">
                            <div data-i18n="Liste">Liste</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.services.reports') ? 'active' : '' }}">
                        <a href="{{ route('admin.services.reports') }}" class="menu-link">
                            <div data-i18n="Şikayetler">Şikayetler</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- 5. Paket Yönetimi --}}
            @php
                $isPackages = request()->routeIs('admin.packages.*') || request()->routeIs('admin.purchased-packages.*');
            @endphp
            <li class="menu-item {{ $isPackages ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-box"></i>
                    <div data-i18n="Paketler">Paketler</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('admin.packages.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.packages.index') }}" class="menu-link">
                            <div data-i18n="Listele">Listele</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.packages.create') ? 'active' : '' }}">
                        <a href="{{ route('admin.packages.create') }}" class="menu-link">
                            <div data-i18n="Oluştur">Oluştur</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.purchased-packages.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.purchased-packages.index') }}" class="menu-link">
                            <div data-i18n="Satın Alınan">Satın Alınan</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item {{ $isServices ? 'active open' : '' }}">
                <a href="javascript:void(0)" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="E-Planlar">E-Planlar</div>
                </a>
                <ul class="menu-sub">

                    <li class="menu-item {{ request()->routeIs('admin.plans') ? 'active' : '' }}">
                        <a href="{{ route('admin.plans.index') }}" class="menu-link">
                            <div data-i18n="Planlar">Planlar</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('admin.services.reports') ? 'active' : '' }}">
                        <a href="{{ route('admin.structure-types.index') }}" class="menu-link">
                            <div data-i18n="Yapı Türü">Yapı Türü</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->routeIs('admin.structure-classes') ? 'active' : '' }}">
                        <a href="{{ route('admin.structure-classes.index') }}" class="menu-link">
                            <div data-i18n="Yapı Sınıfı">Yapı Sınıfı</div>
                        </a>
                    </li>

                    <li class="menu-item {{ request()->routeIs('admin.room-counts') ? 'active' : '' }}">
                        <a href="{{ route('admin.room-counts.index') }}" class="menu-link">
                            <div data-i18n="Oda Sayısı">Oda Sayısı</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- 6. Diğer Yönetim --}}
            <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Kullanıcılar">Kullanıcılar</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.ideas.*') ? 'active' : '' }}">
                <a href="{{ route('admin.ideas.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-lightbulb"></i>
                    <div data-i18n="Fikirler">Fikirler</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <a href="{{ route('admin.payments.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-credit-card"></i>
                    <div data-i18n="Ödemeler">Ödemeler</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <a href="{{ route('admin.contacts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-envelope"></i>
                    <div data-i18n="İletişim">İletişim</div>
                </a>
            </li>

        </ul>
    </div>
</aside>
