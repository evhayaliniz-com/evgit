@php
    $isHome = Route::is('site.home');
    $isExcludedRoute = Route::is('company.profile.edit') 
        || Route::is('user.profile.edit') 
        || Route::is('company.services.create')
        || Route::is('company.services.edit') 
        || Route::is('idea.create') 
        || Route::is('idea.edit')
        || Route::is('services.show') 
        || Route::is('password.request') 
        || Route::is('password.reset')
        || Route::is('idea.show') 
        || Route::is('payment.index');
@endphp

{{-- =========================================================================
     MOBİL KARARTMA KATMANI (BACKDROP OVERLAY)
     ========================================================================= --}}
<div class="sidebar-backdrop" id="sidebar-backdrop" aria-hidden="true"></div>

{{-- =========================================================================
     1. MİNİ SİDEBAR (DESKTOP COLLAPSED / DARALTILMIŞ MENÜ - 76px)
     ========================================================================= --}}
<aside class="menu-min-web modern-mini-sidebar @if(!$isHome) menumin-mobil-hide show @endif @if($isExcludedRoute || Route::is('services.index')) d-none @endif" id="menu-min-web" aria-label="Kompakt Menü">
    <div class="mini-sidebar-inner">
        {{-- Üst Navigasyon İkonları --}}
        <div class="menu-min-top">
            <ul class="mini-nav-list">
                <li @class(['active' => $isHome])>
                    <a href="/" class="mini-nav-link" data-sidebar-tooltip="Anasayfa" aria-label="Anasayfa">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </li>
                <li @class(['active' => Route::is('services.index')])>
                    <a href="{{route('services.index')}}" class="mini-nav-link" data-sidebar-tooltip="Hizmetler" aria-label="Hizmetler">
                        <i class="fa-solid fa-layer-group"></i>
                    </a>
                </li>
                <li @class(['active' => Route::is('idea.index')])>
                    <a href="{{route('idea.index')}}" class="mini-nav-link" data-sidebar-tooltip="Fikir Köşesi" aria-label="Fikir Köşesi">
                        <i class="fa-solid fa-lightbulb"></i>
                    </a>
                </li>
                <li @class(['active' => Route::is('companies.index')])>
                    <a href="{{route('companies.index')}}" class="mini-nav-link" data-sidebar-tooltip="Firma Bul" aria-label="Firma Bul">
                        <i class="fa-solid fa-city"></i>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Alt Araçlar (Tema & Sosyal Medya) --}}
        <div class="menu-min-bottom">
            {{-- Mini Tema Değiştirici --}}
            <div class="mini-theme-wrapper">
                <button type="button" class="mini-theme-toggle-btn" id="mini-theme-toggle" data-sidebar-tooltip="Tema Değiştir" aria-label="Tema Değiştir">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>

            {{-- Mini Sosyal İkonlar --}}
            @if(!empty($siteSettings?->instagram) || !empty($siteSettings?->youtube) || !empty($siteSettings?->facebook) || !empty($siteSettings?->twitter))
                <div class="mini-socials-list">
                    @if(!empty($siteSettings->instagram))
                        <a href="{{ $siteSettings->instagram }}" target="_blank" rel="noopener" class="mini-social-link" data-sidebar-tooltip="Instagram" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                    @if(!empty($siteSettings->youtube))
                        <a href="{{ $siteSettings->youtube }}" target="_blank" rel="noopener" class="mini-social-link" data-sidebar-tooltip="YouTube" aria-label="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    @endif
                    @if(!empty($siteSettings->facebook))
                        <a href="{{ $siteSettings->facebook }}" target="_blank" rel="noopener" class="mini-social-link" data-sidebar-tooltip="Facebook" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @endif
                    @if(!empty($siteSettings->twitter))
                        <a href="{{ $siteSettings->twitter }}" target="_blank" rel="noopener" class="mini-social-link" data-sidebar-tooltip="X (Twitter)" aria-label="X (Twitter)">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</aside>

{{-- =========================================================================
     2. GENİŞLETİLMİŞ SİDEBAR & MOBİL OFFCANVAS DRAWER (250px)
     ========================================================================= --}}
<div class="web-menu-col modern-sidebar-col @if(!$isHome) menuminshow hide @endif @if($isExcludedRoute) d-none @endif" id="menu-trigger-web">
    <aside class="index-menu-fixed modern-sidebar-panel" id="modern-sidebar-panel" aria-label="Ana Menü">
        
        {{-- Mobil Başlık Alanı (Sadece < 992px ekranlarda görünür) --}}
        <div class="sidebar-mobile-header d-lg-none">
            <a href="/" class="sidebar-brand-link">
                @if(!empty($siteSettings?->mobile_logo))
                    <img src="{{ asset($siteSettings->mobile_logo) }}" alt="Ev Hayaliniz" class="sidebar-brand-img">
                @elseif(!empty($siteSettings?->logo))
                    <img src="{{ asset($siteSettings->logo) }}" alt="Ev Hayaliniz" class="sidebar-brand-img">
                @else
                    <span class="sidebar-brand-text">Ev<span>Hayaliniz</span></span>
                @endif
            </a>
            <button type="button" class="sidebar-close-btn" id="sidebar-close-btn" aria-label="Menüyü Kapat">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Kaydırılabilir Gövde Alanı --}}
        <div class="sidebar-scroll-wrapper">

            {{-- 1. Bölüm: Ana Navigasyon --}}
            <nav class="sidebar-nav-section" aria-label="Site Gezintisi">
                <ul class="sidebar-nav-list">
                    <li @class(['active' => $isHome])>
                        <a href="/" class="sidebar-nav-link">
                            <span class="sidebar-icon-box">
                                <i class="fa-solid fa-house"></i>
                            </span>
                            <span class="sidebar-link-text">Anasayfa</span>
                            @if($isHome)
                                <span class="sidebar-active-indicator" aria-hidden="true"></span>
                            @endif
                        </a>
                    </li>
                    <li @class(['active' => Route::is('services.index')])>
                        <a href="{{route('services.index')}}" class="sidebar-nav-link">
                            <span class="sidebar-icon-box">
                                <i class="fa-solid fa-layer-group"></i>
                            </span>
                            <span class="sidebar-link-text">Hizmetler</span>
                            @if(Route::is('services.index'))
                                <span class="sidebar-active-indicator" aria-hidden="true"></span>
                            @endif
                        </a>
                    </li>
                    <li @class(['active' => Route::is('idea.index')])>
                        <a href="{{route('idea.index')}}" class="sidebar-nav-link">
                            <span class="sidebar-icon-box">
                                <i class="fa-solid fa-lightbulb"></i>
                            </span>
                            <span class="sidebar-link-text">Fikir Köşesi</span>
                            @if(Route::is('idea.index'))
                                <span class="sidebar-active-indicator" aria-hidden="true"></span>
                            @endif
                        </a>
                    </li>
                    <li @class(['active' => Route::is('companies.index')])>
                        <a href="{{route('companies.index')}}" class="sidebar-nav-link">
                            <span class="sidebar-icon-box">
                                <i class="fa-solid fa-city"></i>
                            </span>
                            <span class="sidebar-link-text">Firma Bul</span>
                            @if(Route::is('companies.index'))
                                <span class="sidebar-active-indicator" aria-hidden="true"></span>
                            @endif
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Alt Kısım: Tercihler, Sosyal Medya ve Kurumsal Linkler (Aşağı Kaydırılmış) --}}
            <div class="sidebar-bottom-wrapper">
                {{-- 2. Bölüm: Tercihler (Yeni Profesyonel Tema Switcher & Dil) --}}
                <div class="sidebar-preferences-section">
                    {{-- Ultra-Modern Interactive Theme Toggle Card --}}
                    <div class="modern-theme-card" id="theme-toggle-row" role="button" tabindex="0" aria-label="Karanlık Modu Değiştir">
                        <div class="theme-card-left">
                            <span class="theme-card-icon-bubble" id="theme-card-icon">
                                <i class="fa-solid fa-moon"></i>
                            </span>
                            <div class="theme-card-texts">
                                <span class="theme-card-title">Karanlık Mod</span>
                                <span class="theme-card-status" id="theme-status-text">Açık</span>
                            </div>
                        </div>
                        <div class="theme-toggle-switch" id="theme-toggle-switch" role="switch" aria-checked="false">
                            <span class="theme-switch-thumb">
                                <i class="fa-solid fa-moon" id="theme-switch-thumb-icon"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Dil Göstergesi / Seçici --}}
                    <div class="sidebar-lang-box">
                        <div class="lang-box-left">
                            <span class="lang-flag-pill">TR</span>
                            <span class="lang-name">Türkçe</span>
                        </div>
                        <span class="lang-active-check">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                </div>

                {{-- 3. Bölüm: Sosyal Medya Bağlantıları --}}
                @if(!empty($siteSettings?->instagram) || !empty($siteSettings?->youtube) || !empty($siteSettings?->facebook) || !empty($siteSettings?->twitter))
                    <div class="sidebar-social-section">
                        <div class="sidebar-group-badge">BİZİ TAKİP EDİN</div>
                        <div class="sidebar-social-grid">
                            @if(!empty($siteSettings->instagram))
                                <a href="{{ $siteSettings->instagram }}" target="_blank" rel="noopener" class="sidebar-social-btn instagram" aria-label="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings->youtube))
                                <a href="{{ $siteSettings->youtube }}" target="_blank" rel="noopener" class="sidebar-social-btn youtube" aria-label="YouTube">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings->facebook))
                                <a href="{{ $siteSettings->facebook }}" target="_blank" rel="noopener" class="sidebar-social-btn facebook" aria-label="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            @endif
                            @if(!empty($siteSettings->twitter))
                                <a href="{{ $siteSettings->twitter }}" target="_blank" rel="noopener" class="sidebar-social-btn twitter" aria-label="X (Twitter)">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- 4. Bölüm: Kurumsal & Yasal Linkler (Footer) --}}
                <div class="sidebar-footer-section">
                    <div class="sidebar-footer-links">
                        <a href="{{route('about.index')}}" class="sidebar-footer-link">Hakkımızda</a>
                        <a href="{{route('contact.index')}}" class="sidebar-footer-link">İletişim</a>
                        <a href="{{route('about.index')}}#reklam" class="sidebar-footer-link">Reklam</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#kvkkmodal" class="sidebar-footer-link">KVKK</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#kullanimkosullari" class="sidebar-footer-link">Kullanım Koşulları</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#aydinlatmametni" class="sidebar-footer-link">Aydınlatma Metni</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#cerezpolitikasi" class="sidebar-footer-link">Çerez Politikası</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#gizlilikpolitikasi" class="sidebar-footer-link">Gizlilik Politikası</a>
                    </div>
                    
                    {{-- Telif & Versiyon --}}
                    <div class="sidebar-copyright">
                        <span>&copy; {{ date('Y') }} Ev Hayaliniz</span>
                        <span class="copyright-sub">Tüm hakları saklıdır.</span>
                    </div>
                </div>
            </div>

        </div>
    </aside>
</div>
