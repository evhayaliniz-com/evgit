<div class="fiyat-gecmisi-trigger" title="Fiyat Geçmişi">
    <i class="fa-solid fa-clock-rotate-left"></i>
</div>
<div class="fiyat-gecmisi-area" style="display: none;">
    <div class="fiyat-gecmisi-header">
        <h5 class="fiyat-gecmisi-title">
            <i class="fa-solid fa-clock-rotate-left text-primary"></i>
            <span>Fiyat Geçmişi</span>
        </h5>
        <button type="button" class="fiyat-gecmisi-close" aria-label="Kapat">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="fiyat-gecmisi-body">
        @auth()
            @if(isset($prices) && count($prices) > 0)
                <div class="fiyat-gecmisi-list">
                    <ul>
                        @foreach($prices as $price)
                            <li class="fiyat-gecmisi-item">
                                <span class="fg-item-date">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    {{\Carbon\Carbon::parse($price->created_at)->tz('Europe/Istanbul')->format('d.m.Y')}}
                                    @if($loop->first)
                                        <span class="fg-badge-first">İlk Fiyat</span>
                                    @endif
                                </span>
                                <b class="fg-item-price">
                                    {{ number_format($price->price, 0, ',', '.') }} <small>TL</small>
                                </b>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="fiyat-gecmisi-empty">
                    <i class="fa-regular fa-clock"></i>
                    <p>Fiyat geçmişi kaydı bulunmuyor.</p>
                </div>
            @endif
        @endauth

        @guest
            <div class="fiyat-gecmisi-guest">
                <div class="fg-guest-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <p class="fg-guest-text">
                    Fiyat geçmişini ve indirim fırsatlarını görüntülemek için lütfen giriş yapın.
                </p>
                <button type="button" class="fg-guest-btn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Giriş Yap</span>
                </button>
            </div>
        @endguest
    </div>
</div>
