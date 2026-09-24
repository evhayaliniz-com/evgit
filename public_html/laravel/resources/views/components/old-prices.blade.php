<div class="fiyat-gecmisi-trigger">
    <i class="fa-solid fa-rotate-left"></i>
</div>
<div class="fiyat-gecmisi-area">
    @auth()
        <div class="fiyat-gecmisi-detail">
            <div class="d-flex">
                <h5>
                    Fiyat Geçmişi
                </h5>
                <div class="fiyat-gecmisi-close">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <div class="fiyat-gecmisi-list">
                <ul>
                    @foreach($prices as $price)
                        <li>
                            <span>
                                {{\Carbon\Carbon::parse($price->created_at)->tz('Europe/Istanbul')->format('d.m.Y')}}
                                @if($loop->first)
                                    (Eklendiğinde)
                                @endif
                            </span>
                            <b>
                                {{ number_format($price->price, 0, ',', '.') }} TL
                            </b>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bottomarrow"></div>
        </div>
    @endauth

    @guest
        <div class="fiyat-gecmisi-giris">
            <div class="fiyat-gecmisi-close">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <p class="mb-0">
                Fiyat geçmişini görmek için
            </p>
            <a href="#" onclick="
                console.log('Giriş yap tıklandı');
                
                // Tüm fiyat geçmişi popup'larını bul ve kapat
                const allPopups = document.querySelectorAll('.fiyat-gecmisi-area');
                console.log('Bulunan popup sayısı:', allPopups.length);
                
                allPopups.forEach((popup, index) => {
                    console.log('Popup', index, '- classList:', popup.classList.toString());
                    console.log('Popup', index, '- style.display:', popup.style.display);
                    console.log('Popup', index, '- computed display:', window.getComputedStyle(popup).display);
                    
                    // Tüm olası durumları kapat
                    popup.classList.remove('active', 'show', 'visible', 'open');
                    popup.style.display = 'none';
                    popup.style.visibility = 'hidden';
                    popup.style.opacity = '0';
                    
                    console.log('Popup', index, 'kapatıldı');
                });
                
                // Modal'ı aç
                setTimeout(() => {
                    const modal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                    modal.show();
                }, 200);
                return false;
            ">
                Giriş Yap
            </a>
            <div class="bottomarrow"></div>
        </div>
    @endguest
</div>
