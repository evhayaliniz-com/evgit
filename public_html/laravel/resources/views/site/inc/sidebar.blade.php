<div class="menu-min-web @if(!Route::is('site.home')) menumin-mobil-hide show @endif
    @if(Route::is('company.profile.edit') || Route::is('user.profile.edit') || Route::is('company.services.create')
        || Route::is('company.services.edit') || Route::is('idea.create') || Route::is('idea.edit')
        || Route::is('services.show') || Route::is('password.request') || Route::is('password.reset')
        || Route::is('idea.show') || Route::is('payment.index')) d-none @endif">
    <div class="menu-min-top">
        <ul>
            <li @class(['active' => Route::is('site.home')])>
                <a href="/">
                    <i class="fa-solid fa-house"></i>
                    <span> Anasayfa </span>
                </a>
            </li>
            <li @class(['active' => Route::is('services.index')])>
                <a href="{{route('services.index')}}">
                    <i class="fa-solid fa-business-time"></i>
                    <span> Hizmetler </span>
                </a>
            </li>
            <li @class(['active' => Route::is('idea.index')])>
                <a href="{{route('idea.index')}}">
                    <i class="fa-solid fa-comment"></i>
                    <span> Fikir</span>
                </a>
            </li>
            <li @class(['active' => Route::is('companies.index')])>
                <a href="{{route('companies.index')}}">
                    <i class="fa-solid fa-building"></i>
                    <span> Firma Bul </span>
                </a>
            </li>
        </ul>
    </div>
    <div class="menu-min-bottom">
        <div class="isw-box mmb-box">
            <a href="#">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div>
        <div class="isw-box mmb-box">
            <a href="#">
                <i class="fa-brands fa-youtube"></i>
            </a>
        </div>
        <div class="isw-box mmb-box">
            <a href="#">
                <i class="fa-brands fa-facebook"></i>
            </a>
        </div>
        <div class="isw-box mmb-box">
            <a href="#">
                <i class="fa-brands fa-twitter"></i>
            </a>
        </div>
    </div>
</div>
<div class="web-menu-col @if(!Route::is('site.home')) menuminshow hide @endif" id="menu-trigger-web">
    <div class="index-menu-fixed">
        <div class="index-menu-list-web">
            <ul>
                <li @class(['active' => Route::is('site.home')])>
                    <a href="/">
                        <i class="fa-solid fa-house"></i>
                        <span> Anasayfa </span>
                    </a>
                </li>
                <li @class(['active' => Route::is('services.index')])>
                    <a href="{{route('services.index')}}">
                        <i class="fa-solid fa-business-time"></i>
                        <span> Hizmetler </span>
                    </a>
                </li>
                <li @class(['active' => Route::is('idea.index')])>
                    <a href="{{route('idea.index')}}">
                        <i class="fa-solid fa-comment"></i>
                        <span> Fikir Köşesi </span>
                    </a>
                </li>
                <li @class(['active' => Route::is('companies.index')])>
                    <a href="{{route('companies.index')}}">
                        <i class="fa-solid fa-building"></i>
                        <span> Firma Bul </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="index-theme-settings">
            <div class="its-box dark-light-mode">
                <b class="dark-light-mode-trigger"> Tema: </b>
                <div class="dark-light-mode-box">
                    <button id="dark-mode">Karanlık</button>
                    <button id="light-mode">Aydınlık</button>
                </div>
            </div>
            <div class="its-box">
                <b> Dil: </b>
                <select class="form-select" aria-label="Default select example">
                    <option selected>Türkçe</option>
                </select>
            </div>
        </div>
        <div class="index-socials-web">
            @if(!empty($siteSettings->instagram))
                <div class="isw-box">
                    <a href="{{ $siteSettings->instagram }}" target="_blank" rel="noopener">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            @endif

            @if(!empty($siteSettings->youtube))
                <div class="isw-box">
                    <a href="{{ $siteSettings->youtube }}" target="_blank" rel="noopener">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            @endif

            @if(!empty($siteSettings->facebook))
                <div class="isw-box">
                    <a href="{{ $siteSettings->facebook }}" target="_blank" rel="noopener">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </div>
            @endif

            @if(!empty($siteSettings->twitter))
                <div class="isw-box">
                    <a href="{{ $siteSettings->twitter }}" target="_blank" rel="noopener">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                </div>
            @endif
        </div>

        <div class="index-footer">
            <div class="if-box d-flex">
                <div class="if-area">
                    <a href="{{route('about.index')}}"> Hakkımızda </a>
                </div>
                <div class="if-area">
                    <a href="{{route('contact.index')}}"> İletişim </a>
                </div>
            </div>
            <div class="if-box d-flex">
                <div class="if-area">
                    <a href="#"> Reklam </a>
                </div>
                <div class="if-area">
                    <a data-bs-toggle="modal" data-bs-target="#kvkkmodal"> Kvkk </a>
                </div>
            </div>
            <div class="if-box d-flex">
                <div class="if-area">
                    <a data-bs-toggle="modal" data-bs-target="#kullanimkosullari"
                       style="text-align: right;"> Kullanım Koşulları </a>
                </div>
                <div class="if-area">
                    <a data-bs-toggle="modal" data-bs-target="#aydinlatmametni"
                       style="text-align: right;"> Aydınlatma Metni </a>
                </div>
            </div>
            <div class="if-box d-flex">
                <div class="if-area">
                    <a data-bs-toggle="modal" data-bs-target="#cerezpolitikasi"
                       style="text-align: right; cursor: pointer;"> Çerez Politikası </a>
                </div>
                <div class="if-area">
                    <a data-bs-toggle="modal" data-bs-target="#gizlilikpolitikasi"
                       style="text-align: right; cursor: pointer;"> Gizlilik Politikası </a>
                </div>
            </div>
        </div>
    </div>

</div>
