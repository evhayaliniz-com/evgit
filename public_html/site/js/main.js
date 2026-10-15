// URL kontrol fonksiyonu
function checkURLAndApplyStyles() {
    // Mevcut sayfanın URL'ini kontrol et
    const currentURL = window.location.pathname;
    
    // URL '/company/services' ile bitiyorsa stilleri uygula
    if (currentURL.endsWith('/company/services')) {
        
        // .menu-min-web elementlerini bul ve gizle
        const menuElements = document.querySelectorAll('.menu-min-web');
        menuElements.forEach(element => {
            element.style.setProperty('display', 'none', 'important');
        });
        
        // .main elementlerini bul ve padding-left'i 0 yap
        const mainElements = document.querySelectorAll('.main');
        mainElements.forEach(element => {
            element.style.setProperty('padding-left', '0', 'important');
        });
        
        console.log('Stiller uygulandı - URL /company/services ile bitiyor');
    } else {
        console.log('URL /company/services ile bitmiyor, stiller uygulanmadı');
    }
}

// Header left menu click event handler
function setupHeaderMenuClick() {
    const headerLeftMenu = document.getElementById('header-left-menu');
    
    if (headerLeftMenu) {
        headerLeftMenu.addEventListener('click', function() {
            // .main elementlerinin padding-left stilini kaldır
            const mainElements = document.querySelectorAll('.main');
            mainElements.forEach(element => {
                element.style.removeProperty('padding-left');
            });
            
            // .menu-min-web elementlerinin display stilini kaldır
            const menuElements = document.querySelectorAll('.menu-min-web');
            menuElements.forEach(element => {
                element.style.removeProperty('display');
            });
            
            console.log('Header left menu tıklandı - padding-left ve display stilleri kaldırıldı');
        });
    }
}

// DOM yüklendiğinde fonksiyonları çalıştır
document.addEventListener('DOMContentLoaded', function() {
    checkURLAndApplyStyles();
    setupHeaderMenuClick();
});

// Sayfa değişikliklerini yakalamak için (SPA uygulamalar için)
window.addEventListener('popstate', checkURLAndApplyStyles);

// SPA (Single Page Application) için URL değişikliklerini dinle
window.addEventListener('popstate', checkURLAndApplyStyles);



document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('tableBody');
    const headerTableContainer = document.getElementById('headerTableContainer');
    
    // Table body scroll olduğunda header'ı senkronize et
    tableBody.addEventListener('scroll', function() {
        const scrollLeft = tableBody.scrollLeft;
        headerTableContainer.style.transform = `translateX(-${scrollLeft}px)`;
    });
});

document.addEventListener('DOMContentLoaded', function() {
            const headerScroll = document.getElementById('headerScroll');
            const tableBody = document.getElementById('tableBody');
            const scrollContent = document.getElementById('scrollContent');
            const table = tableBody.querySelector('table');
            
            // Table genişliğini scroll content'e aktar
            function updateScrollWidth() {
                const tableWidth = table.scrollWidth;
                scrollContent.style.width = tableWidth + 'px';
            }
            
            // İlk yüklemede genişliği ayarla
            updateScrollWidth();
            
            // Window resize olduğunda genişliği güncelle
            window.addEventListener('resize', updateScrollWidth);
            
            // Header scroll ile table body scroll'u senkronize et
            headerScroll.addEventListener('scroll', function() {
                tableBody.scrollLeft = headerScroll.scrollLeft;
            });
            
            // Table body scroll ile header scroll'u senkronize et
            tableBody.addEventListener('scroll', function() {
                headerScroll.scrollLeft = tableBody.scrollLeft;
            });
        });


// En yakın fiyat box'ı bulma fonksiyonu
function findClosestFiyatBox(element) {
    // 1. Önce closest() ile yukarı doğru ara
    let fiyatBox = element.closest('.tumhizmetlerfiyatbox');
    if (fiyatBox) return fiyatBox;
    
    // 2. Parent içinde ara
    fiyatBox = element.parentElement?.querySelector('.tumhizmetlerfiyatbox');
    if (fiyatBox) return fiyatBox;
    
    // 3. Kardeş elementlerde ara
    fiyatBox = element.nextElementSibling?.classList.contains('tumhizmetlerfiyatbox') ? 
               element.nextElementSibling : null;
    if (fiyatBox) return fiyatBox;
    
    fiyatBox = element.previousElementSibling?.classList.contains('tumhizmetlerfiyatbox') ? 
               element.previousElementSibling : null;
    if (fiyatBox) return fiyatBox;
    
    // 4. Grandparent'ta ara
    fiyatBox = element.parentElement?.parentElement?.querySelector('.tumhizmetlerfiyatbox');
    return fiyatBox;
}

// Trigger elementine tıklanınca show class'ını ekle
document.addEventListener('click', function(event) {
    // tumhizmetlerfiyattrigger class'ına tıklanırsa
    if (event.target.classList.contains('tumhizmetlerfiyattrigger')) {
        // Önce tüm açık boxları kapat
        document.querySelectorAll('.tumhizmetlerfiyatbox.show').forEach(function(openBox) {
            openBox.classList.remove('show');
        });
        
        // Tıklanan elementin en yakın .tumhizmetlerfiyatbox'ını bul
        const fiyatBox = findClosestFiyatBox(event.target);
        
        if (fiyatBox) {
            fiyatBox.classList.add('show');
        }
    }
    
    // tumhizmetler-closed veya tumhizmetler-update class'ına tıklanırsa
    if (event.target.classList.contains('tumhizmetler-closed') || 
        event.target.classList.contains('tumhizmetler-update')) {
        // Tıklanan elementin en yakın .tumhizmetlerfiyatbox'ını bul
        const fiyatBox = findClosestFiyatBox(event.target);
        
        if (fiyatBox) {
            fiyatBox.classList.remove('show');
        }
        
        // Event'in bubbling yapmasını engelle
        event.stopPropagation();
    }
});

const openAreaElements = document.querySelectorAll('.firma-analiz-open-area');

// Her bir element için click event listener ekle
openAreaElements.forEach(element => {
    element.addEventListener('click', function() {
     
        const firmaAnaliz = this.closest('.firma-analiz');
        
     
        if (firmaAnaliz) {
         
            const hasOpen = this.classList.contains('open');
            
            if (hasOpen) {
               
                this.classList.remove('open');
                firmaAnaliz.classList.remove('open');
            } else {
           
                this.classList.add('open');
                firmaAnaliz.classList.add('open');
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
   const eplanBtn = document.querySelector('.eplan-mtt-fullscreen');
   const hdzrTexts = document.querySelector('.hdzb-mobil-texts');
   
   if (eplanBtn && hdzrTexts) {
       eplanBtn.addEventListener('click', function() {
           hdzrTexts.classList.toggle('full-screen');
       });
   }
});


function checkURLAndHideMenu() {
    const currentURL = window.location.pathname;
    

    if (currentURL === '/odeme-basarili' || currentURL === '/odeme-basarisiz') {
        

        if (!document.getElementById('payment-hide-menu-styles')) {
            const style = document.createElement('style');
            style.id = 'payment-hide-menu-styles';
            style.innerHTML = `
                .menu-min-web { 
                    display: none !important; 
                    visibility: hidden !important;
                    opacity: 0 !important;
                    pointer-events: none !important;
                }
                .mobile-fixed-menu { 
                    display: none !important; 
                    visibility: hidden !important;
                    opacity: 0 !important;
                    pointer-events: none !important;
                    transform: translateY(100px) !important;
                }
            `;
            document.head.appendChild(style);
        }
        

        function createObserver() {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                        const target = mutation.target;
                        if (target.classList.contains('mobile-fixed-menu') || target.classList.contains('menu-min-web')) {
                            // Style değişikliğini tespit ettiğimizde tekrar gizle
                            target.style.setProperty('display', 'none', 'important');
                            target.style.setProperty('visibility', 'hidden', 'important');
                            target.style.setProperty('opacity', '0', 'important');
                            console.log('Element style değişikliği tespit edildi ve yeniden gizlendi:', target.className);
                        }
                    }
                });
            });

      
            const menuElements = document.querySelectorAll('.menu-min-web, .mobile-fixed-menu');
            menuElements.forEach(element => {
                observer.observe(element, {
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });
            });
            
            console.log('MutationObserver başlatıldı, gözlemlenen element sayısı:', menuElements.length);
        }


        function hideMenuElements() {
            const allMenuElements = document.querySelectorAll('.menu-min-web, .mobile-fixed-menu');
            allMenuElements.forEach(element => {
                element.style.setProperty('display', 'none', 'important');
                element.style.setProperty('visibility', 'hidden', 'important');
                element.style.setProperty('opacity', '0', 'important');
                element.style.setProperty('pointer-events', 'none', 'important');
                if (element.classList.contains('mobile-fixed-menu')) {
                    element.style.setProperty('transform', 'translateY(100px)', 'important');
                }
            });
            console.log('Menu elementleri gizlendi, toplam:', allMenuElements.length);
        }


        hideMenuElements();
        
 
        createObserver();
        

        const intervalCheck = setInterval(() => {
            const currentPath = window.location.pathname;
            if (currentPath === '/odeme-basarili' || currentPath === '/odeme-basarisiz') {
                hideMenuElements();
            } else {
                clearInterval(intervalCheck);
            }
        }, 500);
        
        console.log('Ödeme sayfası menu gizleme aktif:', currentURL);
    }
}


document.addEventListener('DOMContentLoaded', checkURLAndHideMenu);


window.addEventListener('popstate', checkURLAndHideMenu);


function onURLChange() {
    checkURLAndHideMenu();
}


checkURLAndHideMenu();


document.addEventListener('DOMContentLoaded', checkURLAndHideMenu);

window.addEventListener('popstate', checkURLAndHideMenu);


function onURLChange() {
    checkURLAndHideMenu();
}


checkURLAndHideMenu();



document.addEventListener('DOMContentLoaded', function() {

    const planDetailsSpans = document.querySelectorAll('span.plan-details');
    

    planDetailsSpans.forEach(function(span) {
        span.addEventListener('click', function() {
  
            planDetailsSpans.forEach(function(otherSpan) {
                otherSpan.classList.remove('active');
            });
            

            this.classList.add('active');
        });
    });
});

const searchInput = document.getElementById('header-search-input');
const searchIcon = document.querySelector('.header-search i');


const mobileSearchInput = document.querySelector('.hmsa-search .searchInput');
const mobileSearchIcon = document.querySelector('.hmsa-search i');


if (searchInput && searchIcon) {
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            searchIcon.className = 'fa-solid fa-xmark search-icon-btn';
        } else {
            searchIcon.className = 'fa-solid fa-magnifying-glass search-icon-btn';
        }
    });

    searchIcon.addEventListener('click', function() {
        if (this.classList.contains('fa-xmark')) {
            searchInput.value = '';
            this.className = 'fa-solid fa-magnifying-glass search-icon-btn';
            const initialHint = document.getElementById('search-initial-hint');
            const resultsGroups = document.getElementById('search-results-groups');
            if (initialHint) initialHint.style.display = 'block';
            if (resultsGroups) resultsGroups.style.display = 'none';
            const companiesDiv = document.getElementById('companies');
            const servicesDiv = document.getElementById('services');
            const ideasDiv = document.getElementById('ideas');
            if (companiesDiv) companiesDiv.innerHTML = '';
            if (servicesDiv) servicesDiv.innerHTML = '';
            if (ideasDiv) ideasDiv.innerHTML = '';
            searchInput.focus();
        }
    });
}


if (mobileSearchInput && mobileSearchIcon) {
  
    mobileSearchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
         
            mobileSearchIcon.className = 'fa-solid fa-xmark';
        } else {
        
            mobileSearchIcon.className = 'fa-solid fa-magnifying-glass';
        }
    });

 
    mobileSearchIcon.addEventListener('click', function() {
        if (this.classList.contains('fa-xmark')) {
            mobileSearchInput.value = '';
            this.className = 'fa-solid fa-magnifying-glass';
            const companiesMobile = document.getElementById('companies-mobile');
            const servicesMobile = document.getElementById('services-mobile');
            const ideasMobile = document.getElementById('ideas-mobile');
            if (companiesMobile) companiesMobile.innerHTML = '';
            if (servicesMobile) servicesMobile.innerHTML = '';
            if (ideasMobile) ideasMobile.innerHTML = '';
            mobileSearchInput.focus();
        }
    });
}



let lastScrollTop = 0;
let ticking = false;


const mobileMenu = document.querySelector('.mobile-fixed-menu');


function isMobileDevice() {
    return window.innerWidth <= 991;
}


window.addEventListener('scroll', function() {

    if (!isMobileDevice()) {
        return;
    }
    
    if (!ticking) {
        requestAnimationFrame(function() {
            handleScroll();
            ticking = false;
        });
        ticking = true;
    }
});

function handleScroll() {

    let currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    

    if (currentScrollTop > lastScrollTop) {
 
        if (mobileMenu) {
            mobileMenu.style.display = 'none';
        }
    } else {
 
        if (mobileMenu) {
            mobileMenu.style.display = 'flex';
        }
    }
    

    lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
}


window.addEventListener('resize', function() {
    if (!isMobileDevice() && mobileMenu) {
   
        mobileMenu.style.display = 'flex';
    }
});
function addServicesDetailFooterClassAdvanced() {
    const currentPath = window.location.pathname;
    

    const servicesDetailPattern = /\/services\/(\d+)(-.*)?$/;
    

    const ideaDetailPattern = /\/idea\/.*-(\d+)$/;
    
    if (servicesDetailPattern.test(currentPath)) {

        const footer = document.querySelector('footer');
        if (footer) {
            footer.classList.add('services-detail-footer');
            console.log('Services detail footer class added');
        }
        
        // index-right-area ID'sine class ekle
        const indexRightArea = document.getElementById('index-right-area');
        if (indexRightArea) {
            indexRightArea.classList.add('services-detail-index-right-area');
            console.log('Services detail index-right-area class added');
        }
    }
    
    if (ideaDetailPattern.test(currentPath)) {
    
        const footer = document.querySelector('footer');
        if (footer) {
            footer.classList.add('services-detail-footer');
            console.log('Idea detail footer class added');
        }
        

        const indexRightArea = document.getElementById('index-right-area');
        if (indexRightArea) {
            indexRightArea.classList.add('services-detail-index-right-area');
            console.log('Idea detail index-right-area class added');
        }
        
 
        const mobileMobilePl0 = document.querySelector('.mobile-mobile-pl-0');
        if (mobileMobilePl0) {
            mobileMobilePl0.classList.add('services-detail-index-right-area');
            console.log('Idea detail mobile-mobile-pl-0 class added');
        }
    }
}


document.addEventListener('click', function(e) {
    if (e.target.classList.contains('hdzb-mobil-trigger')) {
        const mobilList = document.querySelector('.hdzb-mobil-list');
        if (mobilList) {
            mobilList.classList.toggle('more');
        }
    }
});


document.addEventListener('DOMContentLoaded', function() {
    addServicesDetailFooterClassAdvanced();
});


window.addEventListener('popstate', function() {
    addServicesDetailFooterClassAdvanced();
});
function toggleMobileMenu() {
    const dropdowns = document.querySelectorAll('.user-messages-dropdown, .login-right-dropdown');
    const mobileMenu = document.querySelector('.mobile-fixed-menu');

    if (!mobileMenu) return;

    // Açık olan herhangi bir dropdown var mı?
    let anyOpen = Array.from(dropdowns).some(dropdown => dropdown.classList.contains('show'));

    if (anyOpen) {
        mobileMenu.style.display = 'none';
    } else {
        mobileMenu.style.display = '';
    }
}



document.addEventListener('DOMContentLoaded', toggleMobileMenu);
document.addEventListener('click', toggleMobileMenu);



document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.searchInput');

    inputs.forEach(input => {
        input.addEventListener('input', function () {
            const query = this.value.trim();
            const isMobile = window.innerWidth < 992;
            const companiesDiv = isMobile ? document.getElementById('companies-mobile') : document.getElementById('companies');
            const servicesDiv = isMobile ? document.getElementById('services-mobile') : document.getElementById('services');
            const ideasDiv = isMobile ? document.getElementById('ideas-mobile') : document.getElementById('ideas');

            const initialHint = document.getElementById('search-initial-hint');
            const resultsGroups = document.getElementById('search-results-groups');

            if (query.length < 2) {
                if (initialHint) initialHint.style.display = 'flex';
                if (resultsGroups) resultsGroups.style.display = 'none';
                if (companiesDiv) companiesDiv.innerHTML = '';
                if (servicesDiv) servicesDiv.innerHTML = '';
                if (ideasDiv) ideasDiv.innerHTML = '';
                return;
            }

            if (initialHint) initialHint.style.display = 'none';
            if (resultsGroups) resultsGroups.style.display = 'block';

            if (!isMobile) {
                $('.header-search-area').addClass('show');
            }

            fetch(`/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (companiesDiv) {
                        companiesDiv.innerHTML = data.companies.length
                            ? data.companies.map(c => `<a href="/companies/${c.slug}" class="text-truncate d-block">
                            <i class="fa-regular fa-building me-1 opacity-75"></i> ${c.name.length > 50 ? c.name.slice(0, 50) + '...' : c.name}
                        </a>`).join('')
                            : '<div class="text-muted search-not-found">Firma bulunamadı.</div>';
                    }

                    if (servicesDiv) {
                        servicesDiv.innerHTML = data.services.length
                            ? data.services.map(s => `<a href="/services/${s.slug}" class="text-truncate d-block">
                            <i class="fa-solid fa-briefcase me-1 opacity-75"></i> ${s.title.length > 50 ? s.title.slice(0, 50) + '...' : s.title}
                        </a>`).join('')
                            : '<div class="text-muted search-not-found">Hizmet bulunamadı.</div>';
                    }

                    if (ideasDiv) {
                        ideasDiv.innerHTML = data.ideas.length
                            ? data.ideas.map(i => `<a href="/idea/${i.slug}" class="text-truncate d-block">
                            <i class="fa-regular fa-lightbulb me-1 opacity-75"></i> ${i.content.length > 50 ? i.content.slice(0, 50) + '...' : i.content}
                        </a>`).join('')
                            : '<div class="text-muted search-not-found">Fikir bulunamadı.</div>';
                    }
                });
        });
    });
});


$(document).ready(function () {

    if (localStorage.getItem("darkMode") === "enabled") {
        $("body").addClass("dark");
    }

 
    $("#dark-mode").click(function () {
        $("body").addClass("dark");
        localStorage.setItem("darkMode", "enabled"); 
    });

  
    $("#light-mode").click(function () {
        $("body").removeClass("dark");
        localStorage.removeItem("darkMode"); 
    });
});
$(document).ready(function () {
    Fancybox.bind('[data-fancybox="gallery"]', {
      
    });
    Fancybox.bind("[data-fancybox]", {
    // Thumbnails plugin ayarları
    Thumbs: {
        // Thumbnails'i başlangıçta gizle
        showOnStart: false,
        // Otomatik gizleme ayarı
        autoStart: false
    },
    
    // Event listener'lar
    on: {
        // Fancybox açıldığında
        ready: (fancybox) => {
            // Thumbnails container'ını gizle
            const thumbsContainer = document.querySelector('.fancybox__thumbs');
            if (thumbsContainer) {
                thumbsContainer.style.display = 'none';
            }
        },
        
        // Slide değiştiğinde de gizli kalsın
        "Carousel.change": (fancybox) => {
            const thumbsContainer = document.querySelector('.fancybox__thumbs');
            if (thumbsContainer) {
                thumbsContainer.style.display = 'none';
            }
        }
    }
});
    $('#header-left-menu').on('click', function (e) {
        $(this).toggleClass("is-active");
        $(this).find('.hamburger').toggleClass("is-active");
        $('#menu-trigger-web').toggleClass("hide");
        $('#index-right-area').toggleClass("col-lg-12");
        $('#index-right-area').toggleClass("col-md-12");
        $('.main').toggleClass("sidebar");
        $('.menu-min-web').toggleClass("show");
    });

    $('#header-left-menu2').on('click', function (e) {
        $('#menu-trigger-web2').toggleClass("hide");
        $('#menu-trigger-web2').toggleClass("mobilinshow");
        $('#index-right-area').toggleClass("col-lg-12");
        $('#index-right-area').toggleClass("col-md-12");
        $('.main').toggleClass("sidebar");
        $('.menu-min-web').toggleClass("show");
    });

    $('.header-right-trigger').on('click', function (e) {
        $('.header-right-dropdown').toggleClass("show");
    });
    $('.hr-logo').on('click', function (e) {
        $('#header-right-dropdown').toggleClass("show");
        $('#login-right-dropdown').toggleClass("show");
        on();

    });
    $('#header-search-input').on('click focus', function (e) {
        e.stopPropagation();
        $('.header-search-area').addClass("show");
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.header-search, .header-search-area').length) {
            $('.header-search-area').removeClass('show');
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('.header-search-area').removeClass('show');
            $('#header-search-input').blur();
        }
    });

    $('.header-search-area').on('click', function (e) {
        e.stopPropagation();
    });
    $('#user-messages-trigger').on('click', function (e) {
        on();
        $('#user-messages-dropdown').toggleClass("show");
    });
    $('.header-right-trigger').on('click', function (e) {
        on();
        $('.login-right-dropdown').toggleClass("show");
    });
    $('#user-messages-trigger2').on('click', function (e) {
        $('#user-messages-dropdown2').toggleClass("show");
    });
    $('.usm-mobil-close').on('click', function (e) {
        $('#user-messages-dropdown2').removeClass("show");
    });
    $('#user-notif-trigger').on('click', function (e) {
        if ($('#user-natif-dropdown').hasClass("show")) {
            $('#user-natif-dropdown').removeClass("show");
            off();

        } else {
            $('#user-natif-dropdown').addClass("show");
            on();
        }
    });

    $('#user-notif-trigger2').on('click', function (e) {
        $('#user-natif-dropdown2').toggleClass("show");
    });

    $('.usm-mobil-close').on('click', function (e) {
        $('#user-natif-dropdown2').removeClass("show");
    });
    $('.header-m-search-trigger').on('click', function (e) {
        $('.header-mobil-search-area').toggleClass("show");
    });
    $('.hmsa-close').on('click', function (e) {
        $('.header-mobil-search-area').removeClass("show");
    });
    $('.hdeyu-edit').on('click', function (e) {
        $('.firma-profil-edit-box').toggleClass("show");
    });


    $('.fikir-detay-answer-trigger').on('click', function (e) {
      
        var targetDetail = $(this).next('.fikir-detay-yanitla');


        $('.fikir-detay-yanitla.show').not(targetDetail).removeClass("show");

  
        targetDetail.toggleClass("show");
    });

    $('.firma-profil-edit').on('click', function (e) {
        var targetDetail = $(this).next('.firma-profil-edit-box');

   
        $('.firma-profil-edit-box.show').not(targetDetail).removeClass("show");

     
        targetDetail.toggleClass("show");
    });


    $(document).mouseup(function (e) {
        var divSelect = $(".header-right-trigger");
        if (!divSelect.is(e.target) && divSelect.has(e.target).length === 0) {
            $('.header-right-dropdown ').removeClass("show");
            off();
        }
    });
    $(document).mouseup(function (e) {
        var divSelect = $(".login-right-dropdown");
        if (!divSelect.is(e.target) && divSelect.has(e.target).length === 0) {
            $('.login-right-dropdown').removeClass("show");
            off();
        }
    });
    $(document).mouseup(function (e) {
        var divSelect = $("#user-messages-dropdown");
        if (!divSelect.is(e.target) && divSelect.has(e.target).length === 0) {
            $('#user-messages-dropdown').removeClass("show");
            off();
        }
    });
    $('#user-notif').on('click', function (e) {
      
        $('#user-natif-dropdown').toggleClass("show");
    });
    $(document).mouseup(function (e) {
        var divSelect = $("#user-natif-dropdown");
        if (!divSelect.is(e.target) && divSelect.has(e.target).length === 0) {
            $('#user-natif-dropdown').removeClass("show");
            off();
        }
    });
    $(document).mouseup(function (e) {
        var divSelect = $("#header-right-dropdown");
        if (!divSelect.is(e.target) && divSelect.has(e.target).length === 0) {
            $('#header-right-dropdown').removeClass("show");
            off();
        }
    });
    $(document).mouseup(function (e) {
        var divSelect = $("#login-right-dropdown");
        if (!divSelect.is(e.target) && divSelect.has(e.target).length === 0) {
            $('#login-right-dropdown').removeClass("show");
            off();
        }
    });

    $(document).on("click", ".fiyat-gecmisi-trigger", function (event) {
        event.preventDefault();
        event.stopPropagation();
        on();
        $(".fiyat-gecmisi-area.cloned").remove();

        var $original = $(this).siblings(".fiyat-gecmisi-area");
        if (!$original.length) {
            $original = $(this).closest(".psd-prices-left, .msc-old-price-box, .msc-price-row").find(".fiyat-gecmisi-area");
        }

        if (!$original.length) {
            return;
        }

        var $clone = $original.clone();

        $clone.addClass("cloned").css({
            display: "block",
            position: "absolute",
            zIndex: 99999
        }).appendTo("body");

        var leftRes = 100, topRes = 10;
        var winWidth = $(window).width();
        if (winWidth < 575) {
            leftRes = 10;
            topRes = 5;
        } else if (winWidth < 768) {
            leftRes = 10;
            topRes = 5;
        } else if (winWidth < 991) {
            leftRes = 50;
            topRes = 5;
        } else if (winWidth < 1199) {
            leftRes = 50;
            topRes = 5;
        }

        var offset = $(this).offset();
        var cloneHeight = $clone.outerHeight() || 130;
        var topPos = offset.top - cloneHeight - topRes;

        if (winWidth < 991) {
            var leftPos = !$original.hasClass('copy-area') ? offset.left - leftRes : (offset.left - leftRes) - 170;
        } else {
            var leftPos = offset.left - leftRes;
        }

        // Ekranın solundan taşmayı engelle
        if (leftPos < 10) {
            leftPos = 10;
        }

        $clone.css({
            top: topPos + "px",
            left: leftPos + "px"
        });

        $clone.find(".fiyat-gecmisi-close").on("click", function (e) {
            e.stopPropagation();
            off();
            $clone.remove();
        });

        $(document).one("click", function (e) {
            if (!$(e.target).closest(".fiyat-gecmisi-area, .fiyat-gecmisi-trigger").length) {
                off();
                $clone.remove();
            }
        });
    });

    //$('.fiyat-gecmisi-trigger').on('click', function(e) {
    //  $('.fiyat-gecmisi-area').toggleClass("show");
    //});

    $('.fiyat-gecmisi-close').on('click', function (e) {
        $('.fiyat-gecmisi-area').removeClass("show");
    });
    $('.more-hizmet').on('click', function (e) {
        $('.hizmet-hakkinda-aciklama').toggleClass("show");
    });
    $('.more-hizmet').click(function () {
        var btnText = $(this).text() === "Daha Fazla" ? "Daha Az" : "Daha Fazla";
        $(this).text(btnText);
    });
    $('.hdzb-mobil-trigger').on('click', function (e) {
        $('.hdzb-mobil-box').toggleClass("hdzb-mobil-show");

        $('.hdzb-mobil-trigger-box').toggleClass("hide");
        $('.hdzb-mobil-top').addClass("hdzb-mobil-top-250");

        if ($('.hdzb-mobil-bottom .user-info').length > 0) {
            $('.hdzb-mobil-bottom .user-info').toggleClass('d-none');
            $('.fikir-detay-right-bottom').toggleClass('d-none');
        }
    });

    $('.more-hizmet2').on('click', function (e) {
        $('.hdzb-mobil-box').toggleClass("hdzb-mobil-show");
        $('.hdzb-mobil-trigger-box').toggleClass("hide");

        if (!$('.hdzb-mobil-box').hasClass('hdzb-mobil-show')) {
            $('.hdzb-mobil-top').removeClass("hdzb-mobil-top-250");

        } else {
            $('.hdzb-mobil-top').addClass("hdzb-mobil-top-250");
        }

        if ($('.hdzb-mobil-bottom .user-info').length > 0) {
            $('.hdzb-mobil-bottom .user-info').toggleClass('d-none');
            $('.fikir-detay-right-bottom').toggleClass('d-none');
        }
    });

    $('.fikir-detay-yanit-goster-gizle-trigger').on('click', function (e) {
   
        var targetDetail = $(this).next('.fikir-detay-yanitlari-goster-gizle');

        $('.fikir-detay-yanitlari-goster-gizle.show').not(targetDetail).removeClass("show");

   
        targetDetail.toggleClass("show");
    });

    $('.fikir-detay-yanit-goster-gizle-trigger').click(function () {
        var btnText = $(this).text() === "- Yanıtları Gizle" ? "- Yanıtları Göster" : "- Yanıtları Gizle";
        $(this).text(btnText);
    });


    var swiper = new Swiper(".mySwiper", {
        loop: true,
        pagination: {
            el: ".swiper-pagination",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });
var swiper = new Swiper(".mySwiper2", {
    slidesPerView: "auto",
    spaceBetween: 16,
    freeMode: false, 
    watchOverflow: true,
    centeredSlides: false,
    loop: false,
    allowTouchMove: true,
    grabCursor: true,
    resistance: true,
    resistanceRatio: 0, 
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        768: {
            slidesPerView: 4,
        },
        1024: {
            slidesPerView: 7,
        },
    },
    on: {
        init: function() {
    
            this.maxWidth = 0;
            this.slides.forEach(slide => {
                this.maxWidth += slide.offsetWidth + this.params.spaceBetween;
            });
            this.maxWidth -= this.params.spaceBetween; 
        },
        touchStart: function() {
            this.startTranslate = this.getTranslate();
        },
        touchMove: function() {
            var currentTranslate = this.getTranslate();
            var containerWidth = this.width;
            var maxTranslate = -(this.maxWidth - containerWidth);
            
   
            if (currentTranslate < maxTranslate) {
                this.setTranslate(maxTranslate);
                return false;
            }
            
            // Solda sınır kontrolü
            if (currentTranslate > 0) {
                this.setTranslate(0);
                return false;
            }
        },
        touchEnd: function() {
            var currentTranslate = this.getTranslate();
            var containerWidth = this.width;
            var maxTranslate = -(this.maxWidth - containerWidth);
            
            // Son pozisyonu düzelt
            if (currentTranslate < maxTranslate) {
                this.setTranslate(maxTranslate);
            } else if (currentTranslate > 0) {
                this.setTranslate(0);
            }
        }
    }
});
    var swiper = new Swiper(".mySwiper3", {
        slidesPerView: "auto",
        spaceBetween: 16,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper = new Swiper(".mySwiper4", {
        slidesPerView: "auto",
        spaceBetween: 16,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper = new Swiper(".mySwiper5", {
        slidesPerView: "auto",
        spaceBetween: 16,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper = new Swiper(".mySwiper6", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper7", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
    var swiper = new Swiper(".mySwiper8", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper = new Swiper(".mySwiper9", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    var swiper = new Swiper(".mySwiper10", {
        slidesPerView: 1,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
        var swiper = new Swiper(".mySwiper11", {
        slidesPerView: "auto",
        spaceBetween: 16,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});


function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}

$(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

$(document).ready(function () {
    $('.select-button').on('click', function (e) {
        e.preventDefault();
        $(this).siblings('div.select').slideToggle();
        $(this).toggleClass('active');

        if ($('.pro-paketler-dark-bg').length > 0) {
            $('.pro-paketler-dark-bg').toggleClass('d-none');
        }
    });
});


// Kaydırıcıyı ve değeri seç
const rangeInput = document.getElementById('customRange1');
const rangeValue = document.getElementById('rangeValue');

// Kaydırıcı değerini değiştirdikçe ekranda göster
if (rangeInput) {
    rangeInput.addEventListener('input', function () {
        rangeValue.textContent = rangeInput.value;
    });
}

const daysContainer = document.getElementById("daysContainer");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const monthYear = document.getElementById("monthYear");
const dateInput = document.getElementById("dateInput");
const calendar = document.getElementById("calendar");

let currentDate = new Date();
let selectedDate = null;

function handleDayClick(day) {
    selectedDate = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        day
    );
    dateInput.value = selectedDate.toLocaleDateString("en-US");
    calendar.style.display = "none";
    renderCalendar();
}

function createDayElement(day) {
    const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
    const dayElement = document.createElement("div");
    dayElement.classList.add("day");

    if (date.toDateString() === new Date().toDateString()) {
        dayElement.classList.add("current");
    }
    if (selectedDate && date.toDateString() === selectedDate.toDateString()) {
        dayElement.classList.add("selected");
    }

    dayElement.textContent = day;
    dayElement.addEventListener("click", () => {
        handleDayClick(day);
    });
    daysContainer.appendChild(dayElement);
}

function renderCalendar() {
    daysContainer.innerHTML = "";
    const firstDay = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth(),
        1
    );
    const lastDay = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth() + 1,
        0
    );

    monthYear.textContent = `${currentDate.toLocaleString("default", {
        month: "long"
    })} ${currentDate.getFullYear()}`;

    for (let day = 1; day <= lastDay.getDate(); day++) {
        createDayElement(day);
    }
}

if (prevBtn) {
    prevBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
}

if (nextBtn) {
    nextBtn.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
}

if (dateInput) {
    dateInput.addEventListener("click", () => {
        calendar.style.display = "block";
        positionCalendar();
    });

    document.addEventListener("click", (event) => {
        if (!dateInput.contains(event.target) && !calendar.contains(event.target)) {
            calendar.style.display = "none";
        }
    });

    function positionCalendar() {
        const inputRect = dateInput.getBoundingClientRect();
        calendar.style.top = inputRect.bottom + "px";
        calendar.style.left = inputRect.left + "px";
    }

    window.addEventListener("resize", positionCalendar);

    renderCalendar();
}


$(document).ready(function () {
    // Tetikleyiciye tıklama olayı ekleyelim
    $('.fikir-detay-yanit-goster-gizle-trigger').on('click', function () {
        var $target = $(this).next('.fikir-detay-yanitlari-goster-gizle'); // Tıklanan tetikleyicinin sonraki yanıtı

        // Diğer tüm yanıtları kapat
        $('.fikir-detay-yanitlari-goster-gizle').not($target).removeClass('open');

        // Sadece tıklanan alanın açık olmasını sağla
        $target.toggleClass('open');
    });
});