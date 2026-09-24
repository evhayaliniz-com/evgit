@extends('site.inc.master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
    <script>
        window.userId = {{ Auth::id() }};
        window.receiverId = {{ $receiver }};
    </script>

    <style>
        body.menu-open {
            overflow: hidden;
        }
        body.menu-open {
            overflow: hidden;
        }

        /* Menü açıkken chat alanı sağa kayar */
        body.menu-open #index-right-area {
            transform: translateX(250px);
        }
        body.menu-open .msg-area-container  {
            width: calc(100% - 45%) !important;
        }


        #index-right-area {
            transition: transform 0.3s ease;
        }
    .hamburger {
    position: relative;
    width: 1em;
    top: 3px;
    height: 1em;
    font-size: inherit;
    transition: all 0.3s ease;
    cursor: pointer;
}
.hamburger.is-sm {
    font-size: 1rem;
}
.hamburger.is-md {
    font-size: 1.5rem;
}
.hamburger.is-lg {
    font-size: 2rem;
}
.hamburger-line {
    position: absolute;
    right: 0;
    width: 81%;
    height: 3px;
    border-radius: 0.125em;
    background: #445568;
    transition: inherit;
}
.hamburger-line:nth-child(1) {
    top: 0.125em;
}
.hamburger.is-active .hamburger-line:nth-child(1),
.w-nav-button.w--open .hamburger-line:nth-child(1) {
    top: 50%;
    transform: translateY(-50%) rotateZ(-136deg);
}
.hamburger-line:nth-child(2) {
    top: 0.438em;
}
.hamburger.is-active .hamburger-line:nth-child(2),
.w-nav-button.w--open .hamburger-line:nth-child(2) {
    right: 50%;
    width: 0;
}
.hamburger-line:nth-child(3) {
    top: 0.75em;
}
.hamburger.is-active .hamburger-line:nth-child(3),
.w-nav-button.w--open .hamburger-line:nth-child(3) {
    top: 50%;
    width: 88%;
    transform: translateY(-50%) rotateZ(136deg);
}
    

body.menu-open .col-12.col-md-4.col-lg-3.order-first.order-md-first.border-end.pe-md-0 {
    margin: 16px;
}   

        .index-menu-fixed, .menu-min-web, .header-left-menu {
           
        }

        .order-md-first {
            margin-left: 4rem;
            max-width: 18rem !important;
            background:#fff;
        }

        .mesajlar-detay-left {
            width: 300px;
        }

        .mesajlar-tabs button {
            font-size: 14px;
        }

        .chat-user-name {
            font-size: 15px !important;
        }

        .bg-blue-500 {
            background-color: #4068e2 !important;
        }
        #chat-messages img{
            max-width: 100%;
            max-height: 100px;
            border-radius: 8px;
            display: block;
        }
        .file-select-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #000;
            border-radius: 5px;
        }
        #chat-messages{
            background: #fff;
        }

        .mobile-fixed-menu {
            display: none;
        }

        /* Chat içindeki img öğeleri */
        .chat-image {
            max-width: 100%;
            max-height: 250px;
            border-radius: 8px;
            display: block;
        }
        .receiver-informations {
            border-bottom: 1px solid #ddd !important;
        }
        .three-dots-container {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;

        }
        .three-dots-btn{
            font-size: 35px;
        }

        .dropdown-delete-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-width: 150px;
        }

        .dropdown-delete-menu button {
            width: 100%;
            padding: 8px 15px;
            text-align: left;
            background: none;
            border: none;
            color: #ff0000;
            cursor: pointer;
        }

        .dropdown-delete-menu button:hover {
            background-color: #f5f5f5;
        }

        .receiver-informations {
            padding-right: 50px !important;
        }

        @media screen and (max-width: 767px) {
             .receiver-informations {
            position:fixed !important;
            padding-right: 50px !important;
        }
            .mesajlar-detay-box{box-shadow:unset !important;}
            .mesajlar-detay.index-right {
    padding: 0;
    height: 100vh !important;
    background: white;
}
            #chat-messages img{max-height:50px !important;}
            .order-md-first{display:none;}
            .mesajlar-detay.index-right .row.flex{flex-wrap:wrap;}
            .menu-min-web {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                width: 250px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1200;
                background-color: #fff;
            }

            body.menu-open .menu-min-web {
                transform: translateX(0);
            }

            #index-right-area {
                transition: transform 0.3s ease;
                width: 100%;
                transform: none !important;
            }

            .mesajlar-detay-left {
                width: 100%;
            }

            .msg-area-container #chat-messages {
                max-height: unset;
                margin-top:0 !important;
            }

            header {
                display: none;
            }

            .mesajlar-detay.index-right {
                margin-top: 0;
            }

            .msg-send-area {
                height: 56px;
            }

            .msg-send-area input {
                height: 35px;
                margin-top: 3px;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@endsection

@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
        <div class="mesajlar-detay index-right">
            <div class="mesajlar-detay-box">
                <livewire:chat :receiver_id="$receiver"/>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script>

        document.addEventListener('DOMContentLoaded', function () {
  const chat = document.getElementById('chat-messages');
  if (!chat) return;

  // --- Stil ekle (JS ile) ---
  const style = document.createElement('style');
  style.textContent = `
    .chat-scroll-bottom-btn {
      position: absolute;
      bottom: 16px;
      right: 12px;
      z-index: 9999;
      padding: 8px 12px;
      border-radius: 20px;
      background: #1d4ed8;
      color: #fff;
      border: 0;
      box-shadow: 0 6px 18px rgba(0,0,0,0.18);
      cursor: pointer;
      font-size: 13px;
      display: none;
      white-space: nowrap;
    }
    .chat-scroll-bottom-btn:hover { transform: translateY(-2px); }
  `;
  document.head.appendChild(style);

  // chat-messages container relative konumda değilse ayarla (buton için)
  const computed = getComputedStyle(chat).position;
  if (!computed || computed === 'static') chat.style.position = 'relative';

  // --- Buton oluştur ---
  const btn = document.createElement('button');
  btn.className = 'chat-scroll-bottom-btn';
  btn.type = 'button';
  btn.textContent = 'Yeni mesajlar';
  btn.style.display = 'none';
  chat.appendChild(btn);

  // Ayarlar
  const THRESHOLD = 150; // px: ne kadar uzaksa "yukarıda sayılır"
  let unreadCount = 0;
  let initial = true;
  let rafScheduled = false;

  const isNearBottom = () => {
    return (chat.scrollHeight - (chat.scrollTop + chat.clientHeight)) <= THRESHOLD;
  };

  function scrollToBottom(smooth = true) {
    if (smooth && 'scrollTo' in chat) {
      chat.scrollTo({ top: chat.scrollHeight, behavior: 'smooth' });
    } else {
      chat.scrollTop = chat.scrollHeight;
    }
  }

  function updateButton() {
    if (unreadCount > 0) {
      btn.textContent = unreadCount === 1 ? '1 yeni mesaj' : `${unreadCount} yeni mesaj`;
      btn.style.display = 'block';
    } else {
      btn.style.display = 'none';
    }
  }

  btn.addEventListener('click', () => {
    scrollToBottom(true);
    unreadCount = 0;
    updateButton();
  });

  // Scroll eventi (throttle via rAF)
  chat.addEventListener('scroll', () => {
    if (!rafScheduled) {
      rafScheduled = true;
      requestAnimationFrame(() => {
        rafScheduled = false;
        if (isNearBottom()) {
          unreadCount = 0;
          updateButton();
        }
      });
    }
  });

  // MutationObserver: yeni mesaj eklendiğinde çalışır
  const mo = new MutationObserver((mutations) => {
    let addedNodesCount = 0;
    const imgsToWait = [];

    for (const m of mutations) {
      for (const node of m.addedNodes) {
        if (node.nodeType !== 1) continue; // element değilse skip
        if (node === btn) continue; // bizim butonumuzsa sayma
        addedNodesCount++;
        // İçindeki img'ler yüklenene kadar bekle
        if (node.querySelectorAll) {
          node.querySelectorAll('img').forEach(img => {
            if (!img.complete) imgsToWait.push(img);
          });
        }
        if (node.tagName === 'IMG' && !node.complete) imgsToWait.push(node);
      }
    }

    if (addedNodesCount === 0) return;

    function handleNew() {
      if (isNearBottom() || initial) {
        // İlk yüklemede instant, sonrasında smooth
        scrollToBottom(initial ? false : true);
        initial = false;
      } else {
        unreadCount += addedNodesCount;
        updateButton();
      }
    }

    if (imgsToWait.length > 0) {
      let loaded = 0;
      imgsToWait.forEach(img => {
        // eğer zaten complete ise hemen say
        if (img.complete) {
          loaded++;
        } else {
          img.addEventListener('load', () => {
            loaded++;
            if (loaded === imgsToWait.length) handleNew();
          }, { once: true });
        }
      });
      if (loaded === imgsToWait.length) handleNew();
    } else {
      handleNew();
    }
  });

  mo.observe(chat, { childList: true, subtree: true });

  // İlk yüklemede en alta in (küçük bir timeout layout için)
  setTimeout(() => {
    scrollToBottom(false);
    initial = false;
  }, 30);
});

        document.addEventListener('DOMContentLoaded', function () {
  // 1) CSS'i JS ile ekle
  const style = document.createElement('style');
  style.textContent = `
    .chat-image { max-width:80px; max-height:80px; cursor:pointer; border-radius:8px; transition:transform .18s ease; display:block; }
    .chat-image:hover { transform:scale(1.05); }
    .image-modal { display:none; position:fixed; z-index:99999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.8); align-items:center; justify-content:center; }
    .image-modal img { max-width:90%; max-height:90%; border-radius:10px; }
    .image-modal.active { display:flex; }
  `;
  document.head.appendChild(style);

  // 2) Modal DOM elemanını oluştur
  const modal = document.createElement('div');
  modal.className = 'image-modal';
  const modalImg = document.createElement('img');
  modal.appendChild(modalImg);
  document.body.appendChild(modal);

  // modal kapanma
  modal.addEventListener('click', () => modal.classList.remove('active'));
  window.addEventListener('keydown', (e) => { if (e.key === 'Escape') modal.classList.remove('active'); });

  // 3) Resimleri seç (senin verdiğin div yapısına özel)
  let imgs = document.querySelectorAll('div.inline-block.p-2.rounded-lg.bg-blue-500.text-white img');

  // Eğer seçiciyle bulunamadıysa: doğrudan src ile tekil seçim (fallback)
  if (imgs.length === 0) {
    const src = 'https://evhayaliniz.com/site/chat_files/1754675813_1.png';
    const single = document.querySelector(`img[src="${src}"]`);
    if (single) imgs = [single];
  }

  // 4) Bulunan resimlere sınıf ve tıklama ekle
  imgs.forEach(img => {
    if (!img.classList.contains('chat-image')) img.classList.add('chat-image'); // sınıf ekleniyor
    img.addEventListener('click', () => {
      modalImg.src = img.src;
      modal.classList.add('active');
    });
  });

  // --- Opsiyonel: sayfaya sonradan eklenen img'ler varsa MutationObserver ile de ekleyebilirim ---
});




        document.addEventListener('DOMContentLoaded', function() {
            // Hamburger menü fonksiyonu
            const hamburger = document.querySelector('.hamburger');
            if (hamburger) {
                hamburger.addEventListener('click', function() {
                    document.body.classList.toggle('menu-open');
                });
            }

            // Chat yüksekliğini ayarla
            function adjustChatHeight() {
                const headerHeight = document.querySelector('header')?.offsetHeight || 60;
                const chatArea = document.querySelector('.mesajlar-detay.index-right');
                if (chatArea) {
                    chatArea.style.height = `calc(100vh - ${headerHeight}px)`;
                }
            }

            // 3 nokta menüsünü oluştur ve kontrol et
            function setupThreeDotsMenu() {
                const receiverInfo = document.querySelector('.receiver-informations');

                if (receiverInfo && !receiverInfo.querySelector('.three-dots-container')) {
                    // Menü container'ını oluştur
                    const container = document.createElement('div');
                    container.className = 'three-dots-container';
                    container.innerHTML = `
                <button class="three-dots-btn">⋮</button>
                <div class="dropdown-delete-menu">
                    <button class="delete-conversation-btn">Sohbeti Sil</button>
                </div>
            `;

                    // Container'ı eklemeden önce eski menüleri temizle
                    const oldContainers = receiverInfo.querySelectorAll('.three-dots-container');
                    oldContainers.forEach(el => el.remove());

                    receiverInfo.appendChild(container);

                    // Elementleri seç
                    const dotsBtn = container.querySelector('.three-dots-btn');
                    const dropdown = container.querySelector('.dropdown-delete-menu');
                    const deleteBtn = container.querySelector('.delete-conversation-btn');

                    // Tıklama olaylarını ekle
                    dotsBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    });

                    deleteBtn.addEventListener('click', function () {
                        if (confirm('Bu sohbeti silmek istediğinize emin misiniz?')) {
                            console.log("Silme isteği gönderildi:", window.receiverId);
                            fetch(`/chat/${window.receiverId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = '/chat';
                                    } else {
                                        alert('Sohbet silinemedi.');
                                    }
                                })
                                .catch(err => {
                                    console.error('Sunucu Hatası:', err);
                                    alert('Bir hata oluştu.');
                                });

                        }
                    });

                    // Receiver info için padding ayarla
                    receiverInfo.style.position = 'relative';
                    receiverInfo.style.paddingRight = '50px';
                }
            }

            // Sayfa dışına tıklanınca menüyü kapat
            function handleDocumentClick(e) {
                const dropdowns = document.querySelectorAll('.dropdown-delete-menu');
                dropdowns.forEach(dropdown => {
                    if (!dropdown.parentElement.contains(e.target)) {
                        dropdown.style.display = 'none';
                    }
                });
            }

            // MutationObserver ile DOM değişikliklerini izle
            const observer = new MutationObserver(function(mutations) {
                setupThreeDotsMenu();
            });

            // Livewire event'lerini dinle
            function handleLivewireEvents() {
                setupThreeDotsMenu();
            }

            // Sayfa yüklendiğinde ilk kurulumu yap
            setupThreeDotsMenu();
            adjustChatHeight();

            // Her 500ms'de bir kontrol et (güvenlik için)
            setInterval(setupThreeDotsMenu, 500);

            // Gözlemciyi başlat
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Event listener'ları ekle
            document.addEventListener('click', handleDocumentClick);
            document.addEventListener('livewire:load', handleLivewireEvents);
            document.addEventListener('livewire:update', handleLivewireEvents);
            window.addEventListener('resize', adjustChatHeight);

            // Arama fonksiyonları (mevcut kodunuz)
            const input = document.getElementById('searchInput');
            const dropdown = document.getElementById('resultsDropdown');

            if (input && dropdown) {
                input.addEventListener('input', function() {
                    const query = input.value;
                    if (query.length < 2) {
                        dropdown.style.display = 'none';
                        dropdown.innerHTML = '';
                        return;
                    }

                    fetch(`/chat/search?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            dropdown.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const li = document.createElement('li');
                                    li.classList.add('list-group-item', 'p-0');
                                    const a = document.createElement('a');
                                    a.href = `/chat/${item.user_id}`;
                                    a.classList.add('d-block', 'px-3', 'py-2', 'text-decoration-none', 'text-dark');
                                    a.textContent = item.name;
                                    li.appendChild(a);
                                    dropdown.appendChild(li);
                                });
                                dropdown.style.display = 'block';
                            } else {
                                const li = document.createElement('li');
                                li.classList.add('list-group-item', 'text-muted');
                                li.textContent = 'Sonuç bulunamadı';
                                dropdown.appendChild(li);
                                dropdown.style.display = 'block';
                            }
                        });
                });

                document.addEventListener('click', function(event) {
                    if (!input.contains(event.target) && !dropdown.contains(event.target)) {
                        dropdown.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
