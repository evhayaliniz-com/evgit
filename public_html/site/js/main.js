// Hizmetlerim sayfası eski scroll senkronizasyonu (yalnızca eski tablo yapısı mevcutsa çalışır)
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('tableBody');
    const headerTableContainer = document.getElementById('headerTableContainer');
    const headerScroll = document.getElementById('headerScroll');
    const scrollContent = document.getElementById('scrollContent');

    if (tableBody && headerTableContainer) {
        tableBody.addEventListener('scroll', function() {
            const scrollLeft = tableBody.scrollLeft;
            headerTableContainer.style.transform = `translateX(-${scrollLeft}px)`;
        });
    }

    if (tableBody && headerScroll && scrollContent) {
        const table = tableBody.querySelector('table');
        if (table) {
            function updateScrollWidth() {
                scrollContent.style.width = table.scrollWidth + 'px';
            }
            updateScrollWidth();
            window.addEventListener('resize', updateScrollWidth);
            headerScroll.addEventListener('scroll', function() {
                tableBody.scrollLeft = headerScroll.scrollLeft;
            });
            tableBody.addEventListener('scroll', function() {
                headerScroll.scrollLeft = tableBody.scrollLeft;
            });
        }
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
    // Modern Theme Synchronization
    function syncThemeUI(isDark) {
        if (isDark) {
            $("body").addClass("dark");
            $("#theme-status-text").text("Açık");
            $("#theme-toggle-switch").attr("aria-checked", "true");
            $("#theme-card-icon i, #theme-switch-thumb-icon").removeClass("fa-sun").addClass("fa-moon");
            $("#mini-theme-toggle i").removeClass("fa-moon").addClass("fa-sun");
            $("#mini-theme-toggle").attr("data-sidebar-tooltip", "Aydınlık Mod");
        } else {
            $("body").removeClass("dark");
            $("#theme-status-text").text("Kapalı");
            $("#theme-toggle-switch").attr("aria-checked", "false");
            $("#theme-card-icon i, #theme-switch-thumb-icon").removeClass("fa-moon").addClass("fa-sun");
            $("#mini-theme-toggle i").removeClass("fa-sun").addClass("fa-moon");
            $("#mini-theme-toggle").attr("data-sidebar-tooltip", "Karanlık Mod");
        }
    }

    const isDarkMode = localStorage.getItem("darkMode") === "enabled";
    syncThemeUI(isDarkMode);

    function toggleTheme() {
        const currentlyDark = $("body").hasClass("dark");
        if (currentlyDark) {
            localStorage.removeItem("darkMode");
            syncThemeUI(false);
        } else {
            localStorage.setItem("darkMode", "enabled");
            syncThemeUI(true);
        }
    }

    $(document).on("click", "#theme-toggle-row, #theme-toggle-switch, #mini-theme-toggle", function (e) {
        e.preventDefault();
        toggleTheme();
    });

    $(document).on("keydown", "#theme-toggle-row", function (e) {
        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            toggleTheme();
        }
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
    // =========================================================================
    // Modern Responsive Sidebar & Mobile Offcanvas Drawer Controller
    // =========================================================================
    function closeMobileSidebar() {
        $('body').removeClass('mobile-sidebar-open');
        $('#header-left-menu, #header-left-menu2').removeClass('is-active');
        $('#header-left-menu .hamburger, #header-left-menu2 .hamburger').removeClass('is-active');
    }

    function openMobileSidebar() {
        $('body').addClass('mobile-sidebar-open');
        $('#header-left-menu, #header-left-menu2').addClass('is-active');
        $('#header-left-menu .hamburger, #header-left-menu2 .hamburger').addClass('is-active');
    }

    function toggleMobileSidebar() {
        if ($('body').hasClass('mobile-sidebar-open')) {
            closeMobileSidebar();
        } else {
            openMobileSidebar();
        }
    }

    $('#header-left-menu, #header-left-menu2').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (window.innerWidth < 992) {
            toggleMobileSidebar();
        } else {
            $(this).toggleClass("is-active");
            $(this).find('.hamburger').toggleClass("is-active");
            $('#menu-trigger-web').toggleClass("hide");
            $('#index-right-area').toggleClass("col-lg-12 col-md-12");
            $('.main').toggleClass("sidebar");
            $('.menu-min-web').toggleClass("show");
        }
    });

    // Close triggers for mobile drawer (Close button, backdrop click)
    $(document).on('click', '#sidebar-close-btn, #sidebar-backdrop', function(e) {
        e.preventDefault();
        closeMobileSidebar();
    });

    // Close mobile drawer on ESC key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('body').hasClass('mobile-sidebar-open')) {
            closeMobileSidebar();
        }
    });

    // Clean up mobile drawer state on screen resize
    $(window).on('resize', function() {
        if (window.innerWidth >= 992 && $('body').hasClass('mobile-sidebar-open')) {
            closeMobileSidebar();
        }
    });

    $('.header-right-trigger').on('click', function (e) {
        $('.header-right-dropdown').toggleClass("show");
    });
    function closeAllHeaderDropdowns() {
        $('.user-messages-dropdown, .login-right-dropdown').removeClass('show');
        $('body').removeClass('modal-popup-active');
        $('.mobile-fixed-menu').removeClass('d-none');
        off();
    }

    // Avatar / Profilim Toggle (Desktop & Mobile)
    $(document).on('click', '#mobile-profile-trigger, #desktop-profile-trigger, .navbar-avatar-btn, .mobile-header-avatar .hr-logo', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $dropdown = $('#login-right-dropdown');
        const willShow = !$dropdown.hasClass('show');
        closeAllHeaderDropdowns();
        if (willShow) {
            $dropdown.addClass('show');
            if (window.innerWidth <= 991) {
                $('body').addClass('modal-popup-active');
                $('.mobile-fixed-menu').addClass('d-none');
            } else {
                on();
            }
        }
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
            closeAllHeaderDropdowns();
        }
    });

    $('.header-search-area').on('click', function (e) {
        e.stopPropagation();
    });

    // Desktop Messages Toggle
    $('#user-messages-trigger').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $dropdown = $('#user-messages-dropdown');
        const willShow = !$dropdown.hasClass('show');
        closeAllHeaderDropdowns();
        if (willShow) {
            $dropdown.addClass('show');
            on();
        }
    });

    // Mobile Messages Toggle
    $('#user-messages-trigger2').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $dropdown = $('#user-messages-dropdown2');
        const willShow = !$dropdown.hasClass('show');
        closeAllHeaderDropdowns();
        if (willShow) {
            $dropdown.addClass('show');
            $('body').addClass('modal-popup-active');
            $('.mobile-fixed-menu').addClass('d-none');
        }
    });

    // Desktop Notifications Toggle
    $('#user-notif-trigger').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $dropdown = $('#user-natif-dropdown');
        const willShow = !$dropdown.hasClass('show');
        closeAllHeaderDropdowns();
        if (willShow) {
            $dropdown.addClass('show');
            on();
        }
    });

    // Mobile Notifications Toggle
    $('#user-notif-trigger2').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $dropdown = $('#user-natif-dropdown2');
        const willShow = !$dropdown.hasClass('show');
        closeAllHeaderDropdowns();
        if (willShow) {
            $dropdown.addClass('show');
            $('body').addClass('modal-popup-active');
            $('.mobile-fixed-menu').addClass('d-none');
        }
    });

    // Mobile Dropdown Close Buttons
    $(document).on('click', '.usm-mobil-close, .profile-mobile-close', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeAllHeaderDropdowns();
    });

    // Prevent clicks inside dropdown content from bubbling up to document
    $(document).on('click', '.user-messages-dropdown .mobile-dropdown-sheet, .user-messages-dropdown.modern-dropdown, .login-right-dropdown .profile-dropdown-sheet, .login-right-dropdown.modern-profile-dropdown', function (e) {
        e.stopPropagation();
    });

    // Mobile backdrop click to close
    $(document).on('click', '.user-messages-dropdown.ums-mobil, .login-right-dropdown.modern-profile-dropdown', function (e) {
        if ($(e.target).is('.user-messages-dropdown.ums-mobil, .login-right-dropdown.modern-profile-dropdown')) {
            closeAllHeaderDropdowns();
        }
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


    $(document).on('click', function (e) {
        if (!$(e.target).closest('#user-messages, #user-notif, .mobile-header-avatar, .header-mobil-profile, .header-mobil-message, .header-mobil-notif, .user-messages-dropdown, .login-right-dropdown').length) {
            closeAllHeaderDropdowns();
        }
    });

    function closeFiyatGecmisiPopup() {
        var $cloned = $(".fiyat-gecmisi-area.cloned");
        var $backdrop = $(".fiyat-gecmisi-backdrop");
        if ($cloned.length) {
            $cloned.removeClass("is-open");
            $backdrop.removeClass("show");
            setTimeout(function () {
                $cloned.remove();
                $backdrop.remove();
                if (typeof off === "function") {
                    off();
                }
            }, 200);
        }
    }

    $(document).on("click", ".fiyat-gecmisi-trigger", function (event) {
        event.preventDefault();
        event.stopPropagation();

        // Onceki acik popup varsa kaldir
        $(".fiyat-gecmisi-area.cloned").remove();
        $(".fiyat-gecmisi-backdrop").remove();

        var $original = $(this).siblings(".fiyat-gecmisi-area");
        if (!$original.length) {
            $original = $(this).closest(".psd-prices-left, .msc-old-price-box, .msc-price-row").find(".fiyat-gecmisi-area");
        }
        if (!$original.length) {
            return;
        }

        var $clone = $original.clone();
        var winWidth = $(window).width();
        var isMobile = winWidth <= 991;

        var $backdrop = $('<div class="fiyat-gecmisi-backdrop"></div>').appendTo("body");

        $clone.addClass("cloned").css({
            display: "block"
        }).appendTo("body");

        if (isMobile) {
            var hasStickyBar = $(".sd-mobile-sticky-bar:visible").length > 0;
            var bottomPos = hasStickyBar ? "67px" : "24px";

            $clone.css({
                position: "fixed",
                bottom: bottomPos,
                top: "auto",
                left: "14px",
                right: "14px",
                width: "calc(100% - 28px)",
                maxWidth: "380px",
                margin: "0 auto",
                zIndex: 100005
            });

            setTimeout(function () {
                $backdrop.addClass("show");
                $clone.addClass("is-open");
            }, 10);
        } else {
            var triggerOffset = $(this).offset();
            var triggerWidth = $(this).outerWidth();
            var triggerHeight = $(this).outerHeight();
            var cloneWidth = $clone.outerWidth() || 310;
            var cloneHeight = $clone.outerHeight() || 180;
            var scrollTop = $(window).scrollTop();

            var leftPos = triggerOffset.left + (triggerWidth / 2) - (cloneWidth / 2);
            if (leftPos < 15) leftPos = 15;
            if (leftPos + cloneWidth > winWidth - 15) leftPos = winWidth - cloneWidth - 15;

            var topPos = triggerOffset.top - cloneHeight - 10;
            if (topPos < scrollTop + 15) {
                topPos = triggerOffset.top + triggerHeight + 10;
            }

            $clone.css({
                position: "absolute",
                top: topPos + "px",
                left: leftPos + "px",
                zIndex: 100005
            });

            setTimeout(function () {
                $clone.addClass("is-open");
            }, 10);
        }

        // Kapat butonu
        $clone.find(".fiyat-gecmisi-close").on("click", function (e) {
            e.stopPropagation();
            closeFiyatGecmisiPopup();
        });

        // Giris yap butonu
        $clone.find(".fg-guest-btn").on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            closeFiyatGecmisiPopup();
            setTimeout(function () {
                var modalEl = document.getElementById("exampleModalToggle");
                if (modalEl) {
                    if (window.bootstrap && bootstrap.Modal) {
                        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();
                    } else if (window.$ && $.fn.modal) {
                        $("#exampleModalToggle").modal("show");
                    }
                }
            }, 150);
        });

        // Backdrop tiklandiginda kapat
        $backdrop.on("click", function (e) {
            e.stopPropagation();
            closeFiyatGecmisiPopup();
        });

        // Disariya tiklandiginda kapat
        setTimeout(function () {
            $(document).one("click", function (e) {
                if (!$(e.target).closest(".fiyat-gecmisi-area, .fiyat-gecmisi-trigger").length) {
                    closeFiyatGecmisiPopup();
                }
            });
        }, 50);
    });

    $(document).on("keydown", function (e) {
        if (e.key === "Escape") {
            closeFiyatGecmisiPopup();
        }
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


    var mainSlideCount = document.querySelectorAll(".mySwiper .swiper-slide").length;
    var swiper = new Swiper(".mySwiper", {
        loop: mainSlideCount > 1,
        speed: 650,
        grabCursor: mainSlideCount > 1,
        watchOverflow: true,
        pagination: {
            el: ".main-slider .swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".main-slider .main-slider-next",
            prevEl: ".main-slider .main-slider-prev",
        },
        autoplay: mainSlideCount > 1 ? {
            delay: 4500,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        } : false,
    });
    var swiper = new Swiper(".mySwiper2", {
        slidesPerView: "auto",
        spaceBetween: 10,
        speed: 500,
        freeMode: {
            enabled: true,
            sticky: false,
            momentumBounce: false,
        },
        watchOverflow: true,
        centeredSlides: false,
        loop: false,
        allowTouchMove: true,
        grabCursor: true,
        resistance: true,
        resistanceRatio: 0.45,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".category-slider .category-slider-next",
            prevEl: ".category-slider .category-slider-prev",
        },
        breakpoints: {
            992: {
                slidesPerView: "auto",
                 slidesPerGroup: 3,
                spaceBetween: 14,
                freeMode: false,
            },
        },
    });
    var swiper = new Swiper(".mySwiper3", {
        slidesPerView: "auto",
        spaceBetween: 12,
        speed: 550,
        freeMode: {
            enabled: true,
            sticky: false,
            momentumBounce: false,
        },
        watchOverflow: true,
        loop: false,
        grabCursor: true,
        resistance: true,
        resistanceRatio: 0.45,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".popular-services-slider .popular-services-next",
            prevEl: ".popular-services-slider .popular-services-prev",
        },
        breakpoints: {
            992: {
                slidesPerView: "auto",
                slidesPerGroup: 2,
                spaceBetween: 16,
                freeMode: false,
            },
        },
    });
    var swiper = new Swiper(".mySwiper4", {
        slidesPerView: "auto",
        spaceBetween: 12,
        speed: 550,
        freeMode: {
            enabled: true,
            sticky: false,
            momentumBounce: false,
        },
        watchOverflow: true,
        loop: false,
        grabCursor: true,
        resistance: true,
        resistanceRatio: 0.45,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".fikir-kosesi .fikir-kosesi-next",
            prevEl: ".fikir-kosesi .fikir-kosesi-prev",
        },
        breakpoints: {
            992: {
                slidesPerView: "auto",
                slidesPerGroup: 2,
                spaceBetween: 16,
                freeMode: false,
            },
        },
    });
    var swiper = new Swiper(".mySwiper5", {
        slidesPerView: "auto",
        spaceBetween: 12,
        speed: 550,
        freeMode: {
            enabled: true,
            sticky: false,
            momentumBounce: false,
        },
        watchOverflow: true,
        loop: false,
        grabCursor: true,
        resistance: true,
        resistanceRatio: 0.45,
        observer: true,
        observeParents: true,
        navigation: {
            nextEl: ".one-cikan-firmalar-slider .firmalar-slider-next",
            prevEl: ".one-cikan-firmalar-slider .firmalar-slider-prev",
        },
        breakpoints: {
            992: {
                slidesPerView: "auto",
                slidesPerGroup: 2,
                spaceBetween: 16,
                freeMode: false,
            },
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
    var overlay = document.getElementById("overlay");
    if (overlay) {
        overlay.style.display = "block";
    }
}

function off() {
    var overlay = document.getElementById("overlay");
    if (overlay) {
        overlay.style.display = "none";
    }
    $('.user-messages-dropdown, .login-right-dropdown').removeClass('show');
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