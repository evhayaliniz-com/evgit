@extends('site.inc.master')

@section('css')
<style>
    blockquote {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 5px;
        border-radius: 5px;
    }

    .comment-like {
        font-size: 0.9rem;
        cursor: pointer;
    }

    .hdzb-mobil-top {
        background-color: #000 !important;
    }

    .main.sidebar {
        padding-left: 0;
    }

    .hdzb-mobil-top .swiper-slide {
        display: flex;
        align-items: center;
    }

    /* Yorum Kapatma Butonu Stilleri */
    .mobile-comment-header {
        position: sticky;
        top: 0;
        z-index: 10;
        width: 100vw !important;
        /* Viewport genişliği kadar */
        margin-left: -15px;
        /* Padding'i dengelemek için */
        padding: 15px;
        background: white;
        border-bottom: 1px solid #e0e0e0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .mobile-comment-close-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        max-width: 500px;
        /* Maksimum genişlik */
        margin: 0 auto;
        /* Ortalamak için */
        padding: 14px 20px;
        background: #f5f5f5;
        border: none;
        border-radius: 10px;
        color: #333;
        font-size: 16px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.25s ease;
    }

    .mobile-comment-close-btn i {
        margin-right: 12px;
        font-size: 18px;
        color: #666;
    }

    .mobile-comment-close-btn:hover {
        background: #e0e0e0;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .mobile-comment-close-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Yorumlar bölümü için */
    #mobile-comments-section {
        width: 100%;
        padding: 0;
        background: #fff;
        box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('content')
<div class="main sidebar">
    <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
        <div class="index-right fikir-detay">

            @include('site.idea.desktop-show')

            @include('site.idea.mobile-show')

            <div class="fikir-detay-one-cikan-hizmet fikir-detay-popular-slider">
                <div class="popular-services">
                    <div class="cs-title d-flex cs-title-link">
                        <div class="ctl-left">
                            <i class="fa-solid fa-business-time"></i>
                            <h2> Güncel Fikirler </h2>
                        </div>
                        <div class="ctl-right">
                            <a href="{{route('idea.index')}}">
                                Tüm Fikirler <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="popular-slider hizmetdetayslider">
                        <div class="swiper mySwiper3">
                            <div class="swiper-wrapper">
                                @foreach($lastIdeas as $lastIdea)
                                <div class="swiper-slide">
                                    @include('site.idea.partials.single-idea-card', ['idea' => $lastIdea])
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('site.home.footer')
</div>
@endsection


@section('js')


<script>
    function likeToggle(id) {
        @guest()
        showLoginPopup('Beğenmek için giriş yapmalısınız!', event.currentTarget);
        return false;
        @else
        let likeArea = event.currentTarget;
        let likeCount = likeArea.querySelector('span');

        fetch("{{ route('idea.reply.like') }}/" + id, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    if (data.status == 'add') {
                        likeArea.classList.add('text-primary');
                        likeCount.textContent = parseInt(likeCount.textContent) + 1;

                    } else {
                        likeArea.classList.remove('text-primary');
                        likeCount.textContent = parseInt(likeCount.textContent) - 1;
                    }
                }
            })
        @endguest
    }

    // Yorum sayısını güncelleyen fonksiyon
    function updateCommentCount(increment = true) {
        const desktopCount = document.getElementById('comment-count');
        const mobileCount = document.getElementById('mobile-comment-count');
        const desktopStatsCount = document.getElementById('desktop-comment-count-stats');

        if (desktopCount) {
            let currentCount = parseInt(desktopCount.textContent);
            desktopCount.textContent = increment ? currentCount + 1 : Math.max(0, currentCount - 1);
        }

        if (mobileCount) {
            let currentCount = parseInt(mobileCount.textContent);
            mobileCount.textContent = increment ? currentCount + 1 : Math.max(0, currentCount - 1);
        }

        if (desktopStatsCount) {
            let currentCount = parseInt(desktopStatsCount.textContent);
            desktopStatsCount.textContent = increment ? currentCount + 1 : Math.max(0, currentCount - 1);
        }
    }

    // Yorum formlarını dinle
    function attachCommentFormListeners() {
        const commentForms = document.querySelectorAll('form[action*="reply.store"]');

        commentForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // Form submit edildikten sonra sayıyı artır
                setTimeout(() => {
                    updateCommentCount(true);
                }, 100);
            });
        });
    }

    // Yorum silme linklerini dinle
    function attachDeleteListeners() {
        const deleteLinks = document.querySelectorAll('a[href*="reply.destroy"]');

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Eğer kullanıcı onaylarsa sayıyı azalt
                if (confirm('Yorumu silmek istediğinize emin misiniz ?')) {
                    setTimeout(() => {
                        updateCommentCount(false);
                    }, 100);
                } else {
                    e.preventDefault();
                }
            });
        });
    }

    // Görüntüleme sayısını güncelleyen fonksiyon (backend tarafından otomatik yapılıyor)
    function updateViewCount() {
        // Bu fonksiyon şu anda kullanılmıyor çünkü görüntüleme sayısı
        // backend'de IP bazlı olarak otomatik artırılıyor
        const viewCountElement = document.getElementById('desktop-view-count');
        if (viewCountElement) {
            // Görüntüleme sayısı backend'den gelir, manuel artırma yapılmaz
            console.log('View count is automatically handled by backend');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const commentButton = document.getElementById('comment-toggle-button');
        const commentsSection = document.getElementById('mobile-comments-section');

        // Yorumları kapatma fonksiyonu
        window.closeComments = function() {
            if (commentsSection) {
                commentsSection.style.display = 'none';
                // Arka tarafın scroll'ını geri aç
                document.body.style.overflow = 'auto';
                // URL'den comment parametresini kaldır
                const url = new URL(window.location.href);
                url.searchParams.delete('comment');
                window.history.pushState({}, '', url);
                // Ana sayfaya kaydır (daha yumuşak bir geçiş için)
                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 100);
            }
        };

        if (commentButton && commentsSection) {
            commentButton.addEventListener('click', function() {
                if (commentsSection.style.display === 'none') {
                    commentsSection.style.display = 'block';
                    // Arka tarafın scroll'ını engelle
                    document.body.style.overflow = 'hidden';
                    // URL'yi güncelle
                    const url = new URL(window.location.href);
                    url.searchParams.set('comment', 'show');
                    window.history.pushState({}, '', url);
                    // Sayfayı kaydır
                    commentsSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                } else {
                    closeComments();
                }
            });

            // Sayfa yüklendiğinde URL'de comment=show varsa yorumları göster
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('comment') && urlParams.get('comment') === 'show') {
                commentsSection.style.display = 'block';
                // Arka tarafın scroll'ını engelle
                document.body.style.overflow = 'hidden';
            }
        }

        // Yorum formlarını dinlemeye başla
        attachCommentFormListeners();

        // Yorum silme linklerini dinlemeye başla
        attachDeleteListeners();
        
        // Yanıt göster/gizle fonksiyonunu ekle
        attachAnswerToggleListeners();

    });
    
    // Yanıt göster/gizle fonksiyonu
    function attachAnswerToggleListeners() {
        const answerTriggers = document.querySelectorAll('.fikir-detay-yanit-goster-gizle-trigger');
        
        answerTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const answersDiv = this.nextElementSibling;
                
                if (answersDiv && answersDiv.classList.contains('fikir-detay-yanitlari-goster-gizle')) {
                    if (answersDiv.classList.contains('show')) {
                        // Gizle
                        answersDiv.classList.remove('show');
                        this.textContent = '- Yanitları Göster';
                    } else {
                        // Diğer açık yanıtları kapat
                        document.querySelectorAll('.fikir-detay-yanitlari-goster-gizle.show').forEach(openAnswer => {
                            openAnswer.classList.remove('show');
                        });
                        document.querySelectorAll('.fikir-detay-yanit-goster-gizle-trigger').forEach(otherTrigger => {
                            otherTrigger.textContent = '- Yanitları Göster';
                        });
                        
                        // Bu yanıtı göster
                        answersDiv.classList.add('show');
                        this.textContent = '- Yanitları Gizle';
                    }
                }
            });
        });
    }
</script>
@endsection