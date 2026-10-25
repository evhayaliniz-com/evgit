@extends('site.inc.master')

@php
    $selectedCategory = request()->category ? \App\Models\Category::find(request()->category) : null;

    $subCategoryInput = request()->sub_category;
    if (is_string($subCategoryInput) && str_contains($subCategoryInput, ',')) {
        $subCategoryIds = explode(',', $subCategoryInput);
    } else {
        $subCategoryIds = is_array($subCategoryInput) ? $subCategoryInput : ($subCategoryInput ? [$subCategoryInput] : []);
    }
    $subCategoryIds = array_values(array_filter($subCategoryIds));
    $selectedSubCategories = !empty($subCategoryIds) ? \App\Models\Category::whereIn('id', $subCategoryIds)->get() : collect();
    $selectedSubCategory = $selectedSubCategories->first();

    // Eğer URL'de kategori belirtilmemiş ama alt kategori gelmişse, üst kategoriyi otomatik tespit et
    if (!$selectedCategory && $selectedSubCategory && $selectedSubCategory->parent_id) {
        $selectedCategory = \App\Models\Category::find($selectedSubCategory->parent_id);
    }

    $selectedProvince = request()->province ? \App\Models\Province::find(request()->province) : null;

    $districtInput = request()->district;
    if (is_string($districtInput) && str_contains($districtInput, ',')) {
        $districtIds = explode(',', $districtInput);
    } else {
        $districtIds = is_array($districtInput) ? $districtInput : ($districtInput ? [$districtInput] : []);
    }
    $districtIds = array_values(array_filter($districtIds));
    $selectedDistricts = !empty($districtIds) ? \App\Models\District::whereIn('id', $districtIds)->get() : collect();
    $selectedDistrict = $selectedDistricts->first();

    // Eğer URL'de il belirtilmemiş ama ilçe gelmişse, ili otomatik tespit et
    if (!$selectedProvince && $selectedDistrict && $selectedDistrict->city_id) {
        $selectedProvince = \App\Models\Province::find($selectedDistrict->city_id);
    }

    $filterCount = ($selectedCategory ? 1 : 0)
        + count($subCategoryIds)
        + ($selectedProvince ? 1 : 0)
        + count($districtIds)
        + (request()->min_price ? 1 : 0)
        + (request()->max_price ? 1 : 0)
        + (request()->min_sqm ? 1 : 0)
        + (request()->max_sqm ? 1 : 0)
        + (request()->q ? 1 : 0)
        + count(array_filter(request()->parameters ?? []));

    $hasActiveFilters = $filterCount > 0;
@endphp

@section('css')
<style>
    /* Filtreleme Alanı Scrollbar: Ok İkonlarını Kesinlikle Gizle */
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar,
    .services-filter-scroll::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }

    /* WebKit / Chromium (Chrome, Edge, Opera): Ok Butonlarını (Yukarı & Aşağı) Kaldır */
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:single-button,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:double-button,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:vertical:decrement,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:vertical:increment,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:start:decrement,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:end:increment,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:horizontal:decrement,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-button:horizontal:increment,
    .services-filter-scroll::-webkit-scrollbar-button,
    .services-filter-scroll::-webkit-scrollbar-button:single-button,
    .services-filter-scroll::-webkit-scrollbar-button:vertical:decrement,
    .services-filter-scroll::-webkit-scrollbar-button:vertical:increment,
    #servicesFilterDrawer *::-webkit-scrollbar-button {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        max-width: 0 !important;
        max-height: 0 !important;
        background: transparent !important;
        color: transparent !important;
        border: none !important;
        font-size: 0 !important;
        line-height: 0 !important;
        pointer-events: none !important;
    }

    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-track,
    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-track-piece,
    .services-filter-scroll::-webkit-scrollbar-track,
    .services-filter-scroll::-webkit-scrollbar-track-piece {
        background: transparent !important;
        border: none !important;
    }

    .services-sidebar-col .services-filter-scroll::-webkit-scrollbar-thumb,
    .services-filter-scroll::-webkit-scrollbar-thumb {
        background-color: transparent !important;
        border-radius: 10px !important;
        border: none !important;
        transition: background-color 0.2s ease !important;
    }

    /* Hover Durumunda Scrollbar Thumb Belirir */
    .services-sidebar-col:hover .services-filter-scroll::-webkit-scrollbar-thumb,
    .services-sidebar-col .services-filter-scroll:hover::-webkit-scrollbar-thumb,
    .services-filter-panel:hover .services-filter-scroll::-webkit-scrollbar-thumb,
    .services-filter-card:hover .services-filter-scroll::-webkit-scrollbar-thumb,
    .services-filter-scroll:hover::-webkit-scrollbar-thumb {
        background-color: #cbd5e1 !important;
    }

    .services-sidebar-col:hover .services-filter-scroll::-webkit-scrollbar-thumb:hover,
    .services-sidebar-col .services-filter-scroll:hover::-webkit-scrollbar-thumb:hover,
    .services-filter-scroll:hover::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8 !important;
    }

    body.dark .services-sidebar-col:hover .services-filter-scroll::-webkit-scrollbar-thumb,
    body.dark .services-sidebar-col .services-filter-scroll:hover::-webkit-scrollbar-thumb,
    body.dark .services-filter-panel:hover .services-filter-scroll::-webkit-scrollbar-thumb,
    body.dark .services-filter-card:hover .services-filter-scroll::-webkit-scrollbar-thumb,
    body.dark .services-filter-scroll:hover::-webkit-scrollbar-thumb {
        background-color: #334155 !important;
    }

    body.dark .services-sidebar-col:hover .services-filter-scroll::-webkit-scrollbar-thumb:hover,
    body.dark .services-sidebar-col .services-filter-scroll:hover::-webkit-scrollbar-thumb:hover,
    body.dark .services-filter-scroll:hover::-webkit-scrollbar-thumb:hover {
        background-color: #475569 !important;
    }

    /* Firefox için scrollbar (Webkit desteklemeyen tarayıcılar) */
    @supports not selector(::-webkit-scrollbar) {
        .services-sidebar-col .services-filter-scroll,
        .services-filter-scroll {
            scrollbar-width: thin !important;
            scrollbar-color: transparent transparent !important;
            transition: scrollbar-color 0.2s ease !important;
        }

        .services-sidebar-col:hover .services-filter-scroll,
        .services-sidebar-col .services-filter-scroll:hover,
        .services-filter-panel:hover .services-filter-scroll,
        .services-filter-card:hover .services-filter-scroll,
        .services-filter-scroll:hover {
            scrollbar-color: #cbd5e1 transparent !important;
        }

        body.dark .services-sidebar-col:hover .services-filter-scroll,
        body.dark .services-sidebar-col .services-filter-scroll:hover,
        body.dark .services-filter-panel:hover .services-filter-scroll,
        body.dark .services-filter-card:hover .services-filter-scroll,
        body.dark .services-filter-scroll:hover {
            scrollbar-color: #334155 transparent !important;
        }
    }

    /* ==========================================
       Selectbox (Açılır Menü) Scrollbar Düzenlemesi
       ========================================== */
    .csp-options-list {
        max-height: 220px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 2px;
    }

    /* WebKit / Chromium: Ok Butonlarını Kesinlikle Kaldır */
    .csp-options-list::-webkit-scrollbar,
    .custom-select-popup .csp-options-list::-webkit-scrollbar {
        width: 5px !important;
        height: 5px !important;
    }

    .csp-options-list::-webkit-scrollbar-button,
    .csp-options-list::-webkit-scrollbar-button:single-button,
    .csp-options-list::-webkit-scrollbar-button:double-button,
    .csp-options-list::-webkit-scrollbar-button:vertical:decrement,
    .csp-options-list::-webkit-scrollbar-button:vertical:increment,
    .csp-options-list::-webkit-scrollbar-button:start:decrement,
    .csp-options-list::-webkit-scrollbar-button:end:increment,
    .csp-options-list::-webkit-scrollbar-button:horizontal:decrement,
    .csp-options-list::-webkit-scrollbar-button:horizontal:increment {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        max-width: 0 !important;
        max-height: 0 !important;
        background: transparent !important;
        color: transparent !important;
        border: none !important;
        font-size: 0 !important;
        line-height: 0 !important;
        pointer-events: none !important;
    }

    .csp-options-list::-webkit-scrollbar-track,
    .csp-options-list::-webkit-scrollbar-track-piece {
        background: transparent !important;
        border: none !important;
    }

    .csp-options-list::-webkit-scrollbar-thumb {
        background-color: transparent !important;
        border-radius: 10px !important;
        border: none !important;
        transition: background-color 0.2s ease !important;
    }

    /* Mouse selectbox / popup alanına geldiğinde scrollbar thumb görünür */
    .custom-select-popup:hover .csp-options-list::-webkit-scrollbar-thumb,
    .csp-options-list:hover::-webkit-scrollbar-thumb {
        background-color: #cbd5e1 !important;
    }

    .custom-select-popup:hover .csp-options-list::-webkit-scrollbar-thumb:hover,
    .csp-options-list::-webkit-scrollbar-thumb:hover {
        background-color: #94a3b8 !important;
    }

    body.dark .custom-select-popup:hover .csp-options-list::-webkit-scrollbar-thumb,
    body.dark .csp-options-list:hover::-webkit-scrollbar-thumb {
        background-color: #334155 !important;
    }

    body.dark .custom-select-popup:hover .csp-options-list::-webkit-scrollbar-thumb:hover,
    body.dark .csp-options-list::-webkit-scrollbar-thumb:hover {
        background-color: #475569 !important;
    }

    /* Firefox için selectbox scrollbar */
    @supports not selector(::-webkit-scrollbar) {
        .csp-options-list {
            scrollbar-width: thin !important;
            scrollbar-color: transparent transparent !important;
            transition: scrollbar-color 0.2s ease !important;
        }

        .custom-select-popup:hover .csp-options-list,
        .csp-options-list:hover {
            scrollbar-color: #cbd5e1 transparent !important;
        }

        body.dark .custom-select-popup:hover .csp-options-list,
        body.dark .csp-options-list:hover {
            scrollbar-color: #334155 transparent !important;
        }
    }

    /* Select Box Temizleme (X) Butonu */
    .cst-clear-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 6px;
        margin-left: 6px;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 10px;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
        z-index: 2;
    }

    .cst-clear-btn:hover {
        background-color: #e2e8f0;
        border-color: #cbd5e1;
        color: #0f172a;
        transform: scale(1.08);
    }

    body.dark .cst-clear-btn {
        background-color: #242f3d;
        border-color: #334155;
        color: #94a3b8;
    }

    body.dark .cst-clear-btn:hover {
        background-color: #334155;
        border-color: #475569;
        color: #f8fafc;
    }

    /* Hizmet Kartlarının Listelendiği Sağ Alanın Arka Planı (Anasayfa ile Birebir main-bg) */
    .services-modern-page {
        background: var(--main-bg);
    }

    .services-content-col {
        background: var(--main-bg) !important;
        min-height: calc(100vh - 56px);
    }

    body.dark .services-modern-page {
        background: #121212;
    }

    body.dark .services-content-col {
        background: #121212 !important;
    }

    /* ========================================================
       DİNAMİK AJAX YENİLEME VE YÜKLENİYOR (LOADING) GÖRÜNÜMÜ
       ======================================================== */
    .services-dynamic-area {
        position: relative;
        transition: opacity 0.25s ease;
        min-height: 350px;
    }

    .services-dynamic-area.is-loading {
        opacity: 0.55;
        pointer-events: none;
        user-select: none;
    }

    /* Üst Yükleme İlerleme Çubuğu (Loading Progress Bar) */
    .services-loading-indicator {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        z-index: 1050;
        overflow: hidden;
        border-radius: 3px;
        background: rgba(37, 99, 235, 0.12);
    }

    .services-dynamic-area.is-loading .services-loading-indicator {
        display: block;
    }

    .services-dynamic-area .services-loading-indicator::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 35%;
        background: linear-gradient(90deg, transparent, #2563eb, #38bdf8, transparent);
        animation: servicesIndicatorSlide 0.9s infinite ease-in-out;
    }

    @keyframes servicesIndicatorSlide {
        0% { left: -35%; }
        100% { left: 100%; }
    }

    body.dark .services-loading-indicator {
        background: rgba(56, 189, 248, 0.15);
    }

    body.dark .services-dynamic-area .services-loading-indicator::after {
        background: linear-gradient(90deg, transparent, #38bdf8, #60a5fa, transparent);
    }

    /* ========================================================
       TOOLBAR VE SEÇİLİ FİLTRELER ORTAK KART DÜZENİ
       ======================================================== */
    .services-toolbar {
        display: flex !important;
        flex-direction: column !important;
        gap: 0 !important;
    }

    .services-toolbar-header {
        width: 100% !important;
    }

    /* ========================================================
       FİLTRE İNPUTLARI: İÇ BORDER, FOCUS RING VE GÖLGE SIFIRLAMA (WEB & MOBİL)
       ======================================================== */
    .filter-input,
    .filter-input:focus,
    .filter-input:focus-visible,
    .filter-input:active {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -webkit-appearance: none !important;
        background: transparent !important;
        -webkit-tap-highlight-color: transparent !important;
    }

    .filter-input:-webkit-autofill,
    .filter-input:-webkit-autofill:hover, 
    .filter-input:-webkit-autofill:focus, 
    .filter-input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px transparent inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* ========================================================
       SIRALA ÖZEL SELECTBOX (Toolbar Akıllı Sıralama)
       ======================================================== */
    .sort-selector-wrapper {
        position: relative;
    }

    .sort-selector-wrapper .custom-select-wrapper {
        width: 205px;
        min-width: 195px;
    }

    .sort-selector-wrapper .custom-select-wrapper.open {
        z-index: 1060;
    }

    .sort-selector-wrapper .custom-select-trigger {
        height: 38px;
        border-radius: 9px;
        padding: 0 10px;
        font-size: 13px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
    }

    body.dark .sort-selector-wrapper .custom-select-trigger {
        background: #141b25 !important;
        border-color: #334155 !important;
        color: #f1f5f9 !important;
    }

    .sort-selector-wrapper .cst-text {
        font-size: 13px;
    }

    .sort-selector-wrapper .custom-select-popup {
        min-width: 205px;
        width: 100%;
        left: auto;
        right: 0;
    }

    @media (max-width: 576px) {
        .sort-selector-wrapper .custom-select-wrapper {
            width: 175px;
            min-width: 160px;
        }

        .sort-selector-wrapper .custom-select-trigger {
            height: 36px;
            padding: 0 8px;
            font-size: 12.5px;
        }

        .sort-selector-wrapper .cst-text {
            font-size: 12.5px;
        }

        .sort-selector-wrapper .custom-select-popup {
            min-width: 190px;
        }
    }

    /* Görünüm Modu Değiştirici (Grid / List Switcher) - Tutarlı Hover ve Aktif Durumu */
    .view-mode-toggle {
        display: inline-flex;
        border-radius: 8px;
        overflow: hidden;
    }

    .view-mode-toggle .btn,
    .view-mode-toggle .btn-outline-secondary {
        padding: 6px 12px !important;
        font-size: 13px !important;
        color: #64748b !important;
        background-color: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        transition: all 0.2s ease !important;
        cursor: pointer;
    }

    .view-mode-toggle .btn:hover,
    .view-mode-toggle .btn-outline-secondary:hover {
        background-color: #eff6ff !important;
        border-color: #2563eb !important;
        color: #2563eb !important;
        z-index: 2;
    }

    .view-mode-toggle .btn.active,
    .view-mode-toggle .btn-outline-secondary.active {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        z-index: 3;
    }

    .view-mode-toggle .btn.active:hover,
    .view-mode-toggle .btn-outline-secondary.active:hover {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
        color: #ffffff !important;
    }

    .view-mode-toggle .btn:focus,
    .view-mode-toggle .btn:focus-visible,
    .view-mode-toggle .btn-outline-secondary:focus {
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2) !important;
    }

    body.dark .view-mode-toggle .btn,
    body.dark .view-mode-toggle .btn-outline-secondary {
        background-color: #1e2430 !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }

    body.dark .view-mode-toggle .btn:hover,
    body.dark .view-mode-toggle .btn-outline-secondary:hover {
        background-color: #283344 !important;
        border-color: #3b82f6 !important;
        color: #60a5fa !important;
        z-index: 2;
    }

    body.dark .view-mode-toggle .btn.active,
    body.dark .view-mode-toggle .btn-outline-secondary.active {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        z-index: 3;
    }

    body.dark .view-mode-toggle .btn.active:hover,
    body.dark .view-mode-toggle .btn-outline-secondary.active:hover {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
        color: #ffffff !important;
    }

    /* Modern Kullanıcı Dostu Sayfalama Bileşeni (Firma Profili Tasarımı) */
    .sd-modern-pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding-top: 24px;
        margin-top: 24px;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        width: 100%;
    }

    .sd-pagination-info {
        font-size: 13px;
        color: #64748b;
    }

    .sd-pagination-info strong {
        color: #0f172a;
        font-weight: 600;
    }

    .sd-pagination-nav {
        margin: 0;
    }

    .sd-pagination-list {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
        flex-wrap: wrap;
    }

    .sd-page-item {
        display: inline-flex;
    }

    .sd-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        transition: all 0.2s ease;
        user-select: none;
    }

    .sd-page-btn:hover {
        background: rgba(37, 99, 235, 0.08);
        border-color: #2563eb;
        color: #2563eb;
        transform: translateY(-1px);
    }

    .sd-page-item.active .sd-page-btn {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        pointer-events: none;
    }

    .sd-page-item.disabled .sd-page-btn {
        opacity: 0.4;
        pointer-events: none;
        cursor: not-allowed;
        background: #ffffff;
        border-color: #e2e8f0;
        color: #64748b;
    }

    .sd-page-dots {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 38px;
        color: #64748b;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .sd-page-prev,
    .sd-page-next {
        padding: 0 14px;
        gap: 6px;
        font-size: 13px;
    }

    /* Dark mode */
    body.dark .sd-modern-pagination-wrapper {
        border-top-color: #283344;
    }

    body.dark .sd-pagination-info {
        color: #94a3b8;
    }

    body.dark .sd-pagination-info strong {
        color: #f1f5f9;
    }

    body.dark .sd-page-btn {
        color: #e2e8f0;
        background: #1e2430;
        border-color: #283344;
    }

    body.dark .sd-page-btn:hover {
        background: rgba(37, 99, 235, 0.15);
        border-color: #3b82f6;
        color: #60a5fa;
    }

    body.dark .sd-page-item.active .sd-page-btn {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #ffffff !important;
    }

    body.dark .sd-page-item.disabled .sd-page-btn {
        background: #1e2430;
        border-color: #283344;
        color: #64748b;
    }

    body.dark .sd-page-dots {
        color: #64748b;
    }

    /* ==========================================================================
       MOBİL DUYARLILIK & EKRANA TAM OTURUM (RESPONSIVE MOBILE OVERFLOW FIXES)
       ========================================================================== */
    @media (max-width: 991.98px) {
        /* Sayfa arka planını gövde ile eşitleyip sağdaki beyaz boşlukları ortadan kaldırma */
        body:has(.services-modern-page),
        body.services-page-active {
            background-color: var(--main-bg) !important;
        }

        body.dark:has(.services-modern-page),
        body.dark.services-page-active {
            background-color: #121212 !important;
        }

        /* Master layout container-fluid: mobildeki hardcoded 10px sağ ve 6px sol padding'i sıfırlar */
        .container-fluid:has(.services-modern-page),
        .container-fluid:has(.services-main-fullwidth),
        .services-container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
            max-width: 100vw !important;
            margin: 0 !important;
        }

        /* Sayfa Kapsayıcılarının Taşmasını Önleme */
        .services-main-fullwidth {
            width: 100% !important;
            max-width: 100vw !important;
            overflow-x: clip !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .services-modern-page {
            width: 100% !important;
            max-width: 100% !important;
            padding: 8px 0 95px 0 !important;
            overflow-x: clip !important;
            box-sizing: border-box !important;
        }

        .services-main-row {
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Master layout .row: services sayfası mobilde negatif margin taşmasını engeller */
        .container-fluid > .row:has(.services-main-fullwidth),
        .container-fluid > .row:has(.services-modern-page),
        .services-parent-row {
            margin-left: 0 !important;
            margin-right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Sağ İçerik Kolonu */
        .services-content-col {
            margin-left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 10px 0px 90px 0px !important;
            box-sizing: border-box !important;
            min-height: auto !important;
            overflow-x: clip !important;
        }

        /* Hizmet Kartları Izgarası: Kenar Boşluklarını Kart Kolonlarında Yönetme */
        .services-items-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            overflow: visible !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        #servicesCardsRow {
            margin-left: 0 !important;
            margin-right: 0 !important;
            margin-top: 0 !important;
            width: 100% !important;
            --bs-gutter-x: 0 !important;
            --bs-gutter-y: 0.3rem !important;
        }

        #servicesCardsRow > .service-card-col {
            padding-left: 0 !important;
            padding-right: 0 !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin-bottom: 0.3rem !important;
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        #servicesCardsRow > .service-card-col:last-child {
            margin-bottom: 0 !important;
        }

        /* Hizmet Kartları: Mobilde Sağ ve Solda Sıfır Boşluk, Border-Radius ve Gölge Yok */
        .services-modern-page .modern-service-card,
        .services-content-col .modern-service-card,
        #servicesCardsRow .modern-service-card {
            border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            border-left: none !important;
            border-right: none !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .services-modern-page .modern-service-card:hover,
        .services-content-col .modern-service-card:hover,
        #servicesCardsRow .modern-service-card:hover {
            transform: none !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
        }

        .services-modern-page .modern-service-card .msc-image-area,
        .services-content-col .modern-service-card .msc-image-area,
        #servicesCardsRow .modern-service-card .msc-image-area {
            border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
        }

        body.dark .services-modern-page .modern-service-card,
        body.dark .services-content-col .modern-service-card,
        body.dark #servicesCardsRow .modern-service-card {
            border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            border-left: none !important;
            border-right: none !important;
        }

        body.dark .services-modern-page .modern-service-card:hover,
        body.dark .services-content-col .modern-service-card:hover,
        body.dark #servicesCardsRow .modern-service-card:hover {
            transform: none !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
        }

        /* Kart Görseli Oran Koruma */
        .modern-service-card .msc-image-area {
            aspect-ratio: 16 / 10;
            height: auto !important;
            min-height: 180px !important;
            max-height: 220px !important;
        }

        /* Mobil Yüzen Aksiyon Barı (Sticky Floating Action Bar):
           Mobilde üst sabit yatay toolbar ve alt menü Hizmetler ikonu kullanıldığı için gizlendi */
        .services-mobile-floating-bar {
            display: none !important;
        }

        body.dark .services-mobile-floating-bar {
            display: none !important;
        }

        /* Mobil Tam Ekran Filtreleme Pop-up */
        #servicesFilterDrawer.offcanvas-bottom {
            height: 100% !important;
            height: 100dvh !important;
            max-height: 100% !important;
            max-height: 100dvh !important;
            top: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            border-radius: 0 !important;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border: none !important;
            border-top: none !important;
            box-shadow: none !important;
            background: #ffffff !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            z-index: 1065 !important;
        }

        /* Pop-up tam ekran olduğunda üst kısımdaki tutacak (handle) boşluğunu kaldır */
        #servicesFilterDrawer .services-drawer-handle {
            display: none !important;
        }

        .offcanvas-backdrop {
            z-index: 1060 !important;
        }

        body.dark #servicesFilterDrawer.offcanvas-bottom {
            background: #1a222d !important;
            border-color: transparent !important;
        }

        /* Filtrele & Sırala Başlık Alanı (Tam 48px Yükseklik) */
        #servicesFilterDrawer .offcanvas-header {
            flex-shrink: 0 !important;
            height: 48px !important;
            min-height: 48px !important;
            max-height: 48px !important;
            padding: 0 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            box-sizing: border-box !important;
            margin: 0 !important;
        }

        body.dark #servicesFilterDrawer .offcanvas-header {
            border-bottom-color: #27272a !important;
            background: #1a222d !important;
        }

        #servicesFilterDrawer .offcanvas-header .offcanvas-title {
            font-size: 15px !important;
            font-weight: 600 !important;
            line-height: 1 !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        #servicesFilterDrawer .offcanvas-header .offcanvas-title i {
            font-size: 15px !important;
        }

        #servicesFilterDrawer .offcanvas-header .offcanvas-title .badge {
            font-size: 11px !important;
            padding: 3px 6px !important;
            font-weight: 600 !important;
            line-height: 1 !important;
        }

        #servicesFilterDrawer .offcanvas-header .btn-close {
            width: 28px !important;
            height: 28px !important;
            padding: 0 !important;
            margin: 0 !important;
            background-size: 11px 11px !important;
            opacity: 0.65 !important;
        }

        #servicesFilterDrawer .offcanvas-header .btn-close:focus {
            box-shadow: none !important;
            outline: none !important;
        }

        body.dark #servicesFilterDrawer .offcanvas-header .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%) !important;
        }

        #servicesFilterDrawer .offcanvas-body {
            flex: 1 1 auto !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            padding: 0 !important;
        }

        #servicesFilterDrawer .services-filter-card {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            display: flex !important;
            flex-direction: column !important;
            flex: 1 1 auto !important;
            height: 100% !important;
            overflow: hidden !important;
            padding: 0 !important;
            background: transparent !important;
        }

        #servicesFilterDrawer #servicesFilterForm {
            display: flex !important;
            flex-direction: column !important;
            flex: 1 1 auto !important;
            height: 100% !important;
            overflow: hidden !important;
            margin: 0 !important;
        }

        /* Kaydırılabilir Filtre İçeriği (Form Alanları) */
        #servicesFilterDrawer .services-filter-scroll {
            flex: 1 1 auto !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            padding: 16px 18px 24px 18px !important;
            -webkit-overflow-scrolling: touch !important;
            overscroll-behavior: contain !important;
        }

        /* Sabit Çekmece Alt Butonları: Her Zaman Görünür */
        #servicesFilterDrawer .filter-actions-mobile {
            flex-shrink: 0 !important;
            padding: 12px 18px !important;
            margin: 0 !important;
            background: #ffffff !important;
            border-top: 1px solid #e2e8f0 !important;
            box-shadow: 0 -4px 16px rgba(15, 23, 42, 0.08) !important;
            z-index: 10 !important;
            display: flex !important;
            gap: 8px !important;
        }

        body.dark #servicesFilterDrawer .filter-actions-mobile {
            background: #1a222d !important;
            border-top-color: #334155 !important;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.4) !important;
        }

        #servicesFilterDrawer .filter-actions-mobile .btn {
            flex: 1 1 0% !important;
            height: 44px !important;
            border-radius: 12px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
        }
    }

    /* Ekran Genişliği <= 767.98px (Akıllı Telefonlar & Küçük Tabletler) */
    @media (max-width: 767.98px) {
        /* Breadcrumb: Tek Satırda Akıcı Yatay Kaydırma */
        .services-breadcrumb .breadcrumb {
            font-size: 12px !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            padding-bottom: 4px !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
            -webkit-overflow-scrolling: touch !important;
        }

        .services-breadcrumb .breadcrumb::-webkit-scrollbar {
            display: none !important;
        }

        .services-breadcrumb .breadcrumb-item {
            white-space: nowrap !important;
            flex-shrink: 0 !important;
        }

        /* Toolbar: Mobilde Çerçevesiz & Köşesiz Düz Düzen (No Border, No Border-Radius) */
        .services-toolbar {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 8px 10px !important;
            margin-bottom: 0 !important;
            position: relative !important;
            background: #ffffff !important;
        }

        body.dark .services-toolbar {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: #1e2430 !important;
            margin-bottom: 0 !important;
        }

        /* Mobilde Sayfa Aşağı Kaydırıldığında Navbar'ın Gizlenmesi & Animasyonu */
        header {
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease !important;
            will-change: transform, opacity;
        }

        body.services-navbar-hidden header {
            transform: translateY(-100%) !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Hızlı Filtre Çubuğunun Üste Yapışması & Yumuşak Giriş Animasyonu */
        .services-toolbar.is-sticky {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100vw !important;
            z-index: 1030 !important;
            background: #ffffff !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            border-radius: 0 !important;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08) !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 6px 10px !important;
            margin: 0 !important;
            animation: mobileFilterBarSlideDown 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards !important;
            will-change: transform;
        }

        body.dark .services-toolbar.is-sticky {
            background: #1e2430 !important;
            border-bottom-color: #283344 !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4) !important;
        }

        @keyframes mobileFilterBarSlideDown {
            0% {
                transform: translateY(-100%);
                opacity: 0.6;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Yapışkan modda sayaç ve çipler kompakt kalsın, sadece yatay filtre çubuğu odakta olsun */
        .services-toolbar.is-sticky .services-count-text {
            display: none !important;
        }

        .services-toolbar.is-sticky .services-active-chips-bar {
            display: none !important;
        }

        .services-toolbar-placeholder {
            width: 100%;
            margin-bottom: 0 !important;
        }

        .services-toolbar .st-left {
            width: 100% !important;
            flex: 1 1 100% !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 6px !important;
            overflow: hidden !important;
        }

        /* Mobil Yatay Filtre Çubuğu (Sabit İkonlar + Sağa/Sola Kaydırılabilir Filtreler) */
        .services-mobile-filter-bar {
            display: flex !important;
            align-items: center !important;
            width: 100% !important;
            max-width: 100% !important;
            overflow: hidden !important;
            position: relative !important;
            padding: 1px 0 !important;
            gap: 0 !important;
        }

        .services-mobile-fixed-actions {
            display: flex !important;
            align-items: center !important;
            gap: 5px !important;
            flex-shrink: 0 !important;
            position: relative !important;
            z-index: 5 !important;
            background: #ffffff !important;
            padding-right: 7px !important;
            box-shadow: 4px 0 8px -3px rgba(15, 23, 42, 0.08) !important;
        }

        body.dark .services-mobile-fixed-actions {
            background: #1e2430 !important;
            box-shadow: 4px 0 8px -3px rgba(0, 0, 0, 0.4) !important;
        }

        .services-mobile-fixed-actions::after {
            content: '' !important;
            display: block !important;
            width: 1px !important;
            height: 18px !important;
            background-color: #e2e8f0 !important;
            margin-left: 2px !important;
            flex-shrink: 0 !important;
        }

        body.dark .services-mobile-fixed-actions::after {
            background-color: #334155 !important;
        }

        .services-toolbar-btn-icon {
            width: 33px !important;
            height: 33px !important;
            min-width: 33px !important;
            max-width: 33px !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            position: relative !important;
            transition: all 0.15s ease !important;
            cursor: pointer !important;
        }

        .services-toolbar-filter-btn {
            border: 1px solid #dbeafe !important;
            color: #2563eb !important;
            background: #eff6ff !important;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.05) !important;
        }

        .services-toolbar-filter-btn:hover,
        .services-toolbar-filter-btn:active {
            background: #2563eb !important;
            color: #ffffff !important;
            border-color: #2563eb !important;
        }

        .services-toolbar-filter-btn .badge {
            position: absolute !important;
            top: -4px !important;
            right: -4px !important;
            font-size: 9.5px !important;
            font-weight: 700 !important;
            padding: 1px 4.5px !important;
            border-radius: 999px !important;
            background: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
            border: 1.5px solid #ffffff !important;
        }

        body.dark .services-toolbar-filter-btn {
            background: rgba(37, 99, 235, 0.16) !important;
            border-color: #3b82f6 !important;
            color: #93c5fa !important;
            box-shadow: none !important;
        }

        body.dark .services-toolbar-filter-btn .badge {
            border-color: #1e2430 !important;
        }

        .services-toolbar-sort-btn {
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            background: #f8fafc !important;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03) !important;
        }

        .services-toolbar-sort-btn:hover,
        .services-toolbar-sort-btn.active,
        .services-toolbar-sort-btn:active {
            border-color: #93c5fd !important;
            color: #2563eb !important;
            background: #eff6ff !important;
        }

        body.dark .services-toolbar-sort-btn {
            background: #1e2430 !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
            box-shadow: none !important;
        }

        body.dark .services-toolbar-sort-btn.active {
            border-color: #3b82f6 !important;
            color: #93c5fa !important;
            background: rgba(37, 99, 235, 0.16) !important;
        }

        .services-sort-active-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #2563eb;
            box-shadow: 0 0 0 1.5px #ffffff;
        }

        body.dark .services-sort-active-dot {
            background-color: #3b82f6;
            box-shadow: 0 0 0 1.5px #1e2430;
        }

        /* Sağa/Sola Kaydırılabilir Hızlı Filtre Çubuğu (Swipeable Filter Track) */
        .services-mobile-scroll-track {
            display: flex !important;
            align-items: center !important;
            gap: 6px !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            flex-wrap: nowrap !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
            -webkit-overflow-scrolling: touch !important;
            flex-grow: 1 !important;
            min-width: 0 !important;
            padding: 1px 4px 1px 6px !important;
        }

        .services-mobile-scroll-track::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        /* Yatay Hızlı Filtre Çubuğu: Custom Select Elemanları */
        .services-mobile-scroll-track .mobile-track-select-wrap {
            flex-shrink: 0 !important;
            display: inline-flex;
            align-items: center !important;
        }

        .services-mobile-scroll-track .mobile-track-select-wrap.d-none,
        .services-mobile-scroll-track .mobile-track-select-wrap[style*="display: none"],
        .services-mobile-scroll-track .mobile-track-select-wrap[style*="display:none"] {
            display: none !important;
        }

        .services-mobile-scroll-track .custom-select-wrapper {
            flex-shrink: 0 !important;
            min-width: 68px !important;
            max-width: 195px !important;
            width: auto !important;
            margin: 0 !important;
            transition: width 0.22s cubic-bezier(0.16, 1, 0.3, 1), min-width 0.22s ease !important;
        }

        .services-mobile-scroll-track .custom-select-trigger {
            height: 33px !important;
            min-height: 33px !important;
            padding: 0 10px 0 10px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            color: #334155 !important;
            white-space: nowrap !important;
            gap: 6px !important;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03) !important;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        /* Açılır Menü (Popup): Çip daralsa dahi liste seçenekleri ferah ve okunur açılır */
        .services-mobile-scroll-track .custom-select-popup {
            min-width: 220px !important;
            max-width: 280px !important;
            width: max-content !important;
            z-index: 100006 !important;
        }

        /* Mobil Yatay Hızlı Filtre Select Box Popup Açıldığında Arka Plan Karartması (Fiyat Geçmişi ile Birebir Aynı) */
        .services-mobile-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            z-index: 100004;
            opacity: 0;
            pointer-events: auto;
            transition: opacity 0.22s ease;
        }

        .services-mobile-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Popupların karartma üzerinde kalması ve Stacking Context Yükseltmesi */
        .services-toolbar:has(.custom-select-wrapper.open),
        .services-toolbar.has-open-select {
            z-index: 100005 !important;
            position: relative !important;
        }

        .services-toolbar.is-sticky:has(.custom-select-wrapper.open),
        .services-toolbar.is-sticky.has-open-select {
            z-index: 100005 !important;
            position: fixed !important;
        }

        .sort-selector-wrapper .custom-select-wrapper.open {
            z-index: 100006 !important;
        }

        .services-toolbar .sort-selector-wrapper .custom-select-wrapper.open .custom-select-popup,
        .services-toolbar .sort-selector-wrapper .custom-select-popup,
        .services-mobile-scroll-track .custom-select-wrapper.open .custom-select-popup {
            z-index: 100006 !important;
        }

        .services-mobile-scroll-track .custom-select-trigger:hover {
            border-color: #cbd5e1 !important;
            background: #ffffff !important;
        }

        .services-mobile-scroll-track .custom-select-wrapper.open .custom-select-trigger {
            border-color: #3b82f6 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15) !important;
        }

        .services-mobile-scroll-track .custom-select-wrapper.has-value .custom-select-trigger {
            border-color: #3b82f6 !important;
            background: #eff6ff !important;
            color: #1d4ed8 !important;
            font-weight: 600 !important;
        }

        .services-mobile-scroll-track .cst-text {
            font-size: 12px !important;
            letter-spacing: -0.15px !important;
        }

        .services-mobile-scroll-track .cst-arrow {
            font-size: 9px !important;
            color: #94a3b8 !important;
            transition: transform 0.2s ease !important;
        }

        .services-mobile-scroll-track .custom-select-wrapper.has-value .cst-arrow {
            color: #3b82f6 !important;
        }

        .services-mobile-scroll-track .cst-clear-btn {
            font-size: 9.5px !important;
            width: 15px !important;
            height: 15px !important;
            border-radius: 50% !important;
            background: rgba(37, 99, 235, 0.12) !important;
            color: #2563eb !important;
            display: none !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 2px !important;
        }

        .services-mobile-scroll-track .custom-select-wrapper.has-value .cst-clear-btn {
            display: inline-flex !important;
        }

        body.dark .services-mobile-scroll-track .custom-select-trigger {
            background: #1e2430 !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
            box-shadow: none !important;
        }

        body.dark .services-mobile-scroll-track .custom-select-trigger:hover {
            border-color: #475569 !important;
            background: #272f3d !important;
        }

        body.dark .services-mobile-scroll-track .custom-select-wrapper.open .custom-select-trigger {
            border-color: #3b82f6 !important;
            background: #1e2430 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
        }

        body.dark .services-mobile-scroll-track .custom-select-wrapper.has-value .custom-select-trigger {
            border-color: #3b82f6 !important;
            background: rgba(37, 99, 235, 0.18) !important;
            color: #93c5fa !important;
        }

        /* Yatay Hızlı Filtre Çubuğu: Fiyat ve m² Input Grupları */
        .mobile-track-range-group {
            display: inline-flex !important;
            align-items: center !important;
            gap: 3px !important;
            flex-shrink: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            background: transparent !important;
            border: none !important;
        }

        .mobile-track-range-group .filter-input-wrapper,
        #mobileTrackDynamicContainer .filter-input-wrapper {
            height: 33px !important;
            min-height: 33px !important;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            width: 66px !important;
            min-width: 66px !important;
            max-width: 112px !important;
            padding: 0 6px !important;
            display: flex !important;
            align-items: center !important;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03) !important;
            transition: width 0.22s cubic-bezier(0.16, 1, 0.3, 1), background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        .mobile-track-range-group .filter-input-wrapper.step-mid,
        #mobileTrackDynamicContainer .filter-input-wrapper.step-mid {
            width: 84px !important;
        }

        .mobile-track-range-group .filter-input-wrapper.step-wide,
        #mobileTrackDynamicContainer .filter-input-wrapper.step-wide {
            width: 98px !important;
        }

        .mobile-track-range-group .filter-input-wrapper.step-xwide,
        #mobileTrackDynamicContainer .filter-input-wrapper.step-xwide {
            width: 108px !important;
        }

        .mobile-track-range-group .filter-input-wrapper:hover,
        #mobileTrackDynamicContainer .filter-input-wrapper:hover {
            border-color: #cbd5e1 !important;
            background: #ffffff !important;
        }

        .mobile-track-range-group .filter-input-wrapper:focus-within,
        #mobileTrackDynamicContainer .filter-input-wrapper:focus-within {
            border-color: #3b82f6 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.18) !important;
        }

        .mobile-track-range-group .filter-input-wrapper.has-value,
        #mobileTrackDynamicContainer .filter-input-wrapper.has-value {
            border-color: #3b82f6 !important;
            background: #eff6ff !important;
            box-shadow: none !important;
        }

        .mobile-track-range-group .filter-input-wrapper.has-value:focus-within,
        #mobileTrackDynamicContainer .filter-input-wrapper.has-value:focus-within {
            border-color: #3b82f6 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.18) !important;
        }

        .mobile-track-range-group .filter-input-wrapper.has-value .filter-input,
        #mobileTrackDynamicContainer .filter-input-wrapper.has-value .filter-input {
            color: #1d4ed8 !important;
            font-weight: 600 !important;
        }

        .mobile-track-range-group .filter-input-wrapper.has-value .input-unit-symbol {
            color: #2563eb !important;
        }

        .mobile-track-range-group .filter-input-wrapper.has-value .input-unit-badge {
            background: #dbeafe !important;
            color: #1d4ed8 !important;
        }

        .mobile-track-range-group .filter-input,
        .mobile-track-range-group .filter-input:focus,
        .mobile-track-range-group .filter-input:focus-visible,
        .mobile-track-range-group .filter-input:active,
        #mobileTrackDynamicContainer .filter-input,
        #mobileTrackDynamicContainer .filter-input:focus,
        #mobileTrackDynamicContainer .filter-input:focus-visible,
        #mobileTrackDynamicContainer .filter-input:active {
            font-size: 11px !important;
            font-weight: 500 !important;
            color: #1e293b !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            -webkit-box-shadow: none !important;
            -webkit-appearance: none !important;
            background: transparent !important;
            width: 100% !important;
            padding: 0 !important;
            text-align: left !important;
            -webkit-tap-highlight-color: transparent !important;
        }

        .mobile-track-range-group .input-unit-symbol {
            font-size: 11.5px !important;
            color: #64748b !important;
            margin-right: 2px !important;
            font-weight: 600 !important;
            flex-shrink: 0 !important;
            transition: color 0.2s ease !important;
        }

        .mobile-track-range-group .input-unit-badge {
            font-size: 9.5px !important;
            color: #64748b !important;
            background: #e2e8f0 !important;
            border-radius: 3px !important;
            padding: 1px 3px !important;
            font-weight: 600 !important;
            flex-shrink: 0 !important;
            transition: all 0.2s ease !important;
        }

        .mobile-track-range-group .range-separator {
            color: #94a3b8 !important;
            font-size: 9px !important;
            padding: 0 1px !important;
            flex-shrink: 0 !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper,
        body.dark #mobileTrackDynamicContainer .filter-input-wrapper {
            background: #1e2430 !important;
            border-color: #334155 !important;
            box-shadow: none !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper:hover,
        body.dark #mobileTrackDynamicContainer .filter-input-wrapper:hover {
            border-color: #475569 !important;
            background: #272f3d !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper:focus-within,
        body.dark #mobileTrackDynamicContainer .filter-input-wrapper:focus-within {
            background: #1e2430 !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper.has-value,
        body.dark #mobileTrackDynamicContainer .filter-input-wrapper.has-value {
            border-color: #3b82f6 !important;
            background: rgba(37, 99, 235, 0.18) !important;
            box-shadow: none !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper.has-value:focus-within,
        body.dark #mobileTrackDynamicContainer .filter-input-wrapper.has-value:focus-within {
            background: #1e2430 !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25) !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper.has-value .filter-input,
        body.dark #mobileTrackDynamicContainer .filter-input-wrapper.has-value .filter-input {
            color: #93c5fa !important;
            font-weight: 600 !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper.has-value .input-unit-symbol {
            color: #60a5fa !important;
        }

        body.dark .mobile-track-range-group .filter-input-wrapper.has-value .input-unit-badge {
            background: rgba(59, 130, 246, 0.3) !important;
            color: #bfdbfe !important;
        }

        body.dark .mobile-track-range-group .filter-input,
        body.dark #mobileTrackDynamicContainer .filter-input {
            color: #f1f5f9 !important;
        }

        body.dark .mobile-track-range-group .input-unit-symbol {
            color: #94a3b8 !important;
        }

        body.dark .mobile-track-range-group .input-unit-badge {
            background: #2d3748 !important;
            color: #94a3b8 !important;
        }

        /* Sıfırla (Temizle) Butonu */
        .mobile-track-reset-btn {
            flex-shrink: 0 !important;
            height: 33px !important;
            border-radius: 8px !important;
            padding: 0 9px !important;
            font-size: 11.5px !important;
            font-weight: 600 !important;
            display: inline-flex;
            align-items: center !important;
            gap: 4px !important;
            white-space: nowrap !important;
            border: 1px solid #fecaca !important;
            background: #fef2f2 !important;
            color: #dc2626 !important;
            cursor: pointer !important;
            box-shadow: 0 1px 2px rgba(220, 38, 38, 0.04) !important;
            transition: all 0.15s ease !important;
        }

        .mobile-track-reset-btn.d-none {
            display: none !important;
        }

        .mobile-track-reset-btn:hover,
        .mobile-track-reset-btn:active {
            background: #fee2e2 !important;
            border-color: #f87171 !important;
            color: #b91c1c !important;
        }

        body.dark .mobile-track-reset-btn {
            background: rgba(239, 68, 68, 0.15) !important;
            border-color: rgba(239, 68, 68, 0.35) !important;
            color: #fca5a5 !important;
            box-shadow: none !important;
        }



        .services-toolbar .services-count-text {
            font-size: 13px !important;
            color: #64748b !important;
            width: 100% !important;
            display: block !important;
            margin: 0 !important;
            padding-top: 2px !important;
            padding-bottom: 0 !important;
        }

        .services-toolbar .services-toolbar-header {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        body.dark .services-toolbar .services-count-text {
            color: #94a3b8 !important;
        }

        .services-toolbar .st-right {
            position: static !important;
            width: 0 !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
        }

        .services-toolbar .sort-selector-wrapper {
            position: static !important;
            width: 0 !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .services-toolbar .sort-selector-wrapper .custom-select-wrapper {
            position: static !important;
            width: 0 !important;
            height: 0 !important;
            min-width: 0 !important;
        }

        .services-toolbar .sort-selector-wrapper .custom-select-trigger {
            display: none !important;
        }

        /* Sıralama Açılır Menüsü (Popup): Sırala İkonunun Hemen Altında, Sağ & Soldan Boşluklu */
        .services-toolbar .sort-selector-wrapper .custom-select-popup {
            position: absolute !important;
            top: 44px !important;
            left: 44px !important;
            right: auto !important;
            width: 215px !important;
            min-width: 190px !important;
            max-width: calc(100vw - 24px) !important;
            margin-top: 0 !important;
            box-sizing: border-box !important;
            z-index: 100006 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.16) !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
        }

        body.dark .services-toolbar .sort-selector-wrapper .custom-select-popup {
            background: #1e2430 !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        }

        /* Aktif Filtre Çipleri: Mobilde Kart İçi Ayracı & Yatay Kayan Çipler */
        .services-active-chips-bar {
            display: block !important;
            width: 100% !important;
            margin-top: 0 !important;
            padding-top: 6px !important;
            padding-bottom: 2px !important;
            margin-bottom: 0 !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        body.dark .services-active-chips-bar {
            border-top-color: #283344 !important;
        }

        .services-active-chips-bar .active-chips-container {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-bottom: 0 !important;
            padding: 0 2px !important;
            gap: 6px 0 !important;
        }

        .services-active-chips-bar .active-chips-label {
            order: 1 !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            color: #475569 !important;
            margin: 0 !important;
            width: auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        body.dark .services-active-chips-bar .active-chips-label {
            color: #94a3b8 !important;
        }

        .services-active-chips-bar .btn-clear-active-filters,
        .services-active-chips-bar .btn-clear-active-filters-mobile {
            order: 2 !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #ef4444 !important;
            text-decoration: none !important;
            line-height: 1 !important;
            padding: 4px 6px !important;
            border-radius: 6px !important;
            transition: all 0.15s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            white-space: nowrap !important;
            margin-left: auto !important;
        }

        .services-active-chips-bar .btn-clear-active-filters:hover,
        .services-active-chips-bar .btn-clear-active-filters:active,
        .services-active-chips-bar .btn-clear-active-filters-mobile:hover,
        .services-active-chips-bar .btn-clear-active-filters-mobile:active {
            color: #dc2626 !important;
            background: rgba(239, 68, 68, 0.08) !important;
        }

        body.dark .services-active-chips-bar .btn-clear-active-filters,
        body.dark .services-active-chips-bar .btn-clear-active-filters-mobile {
            color: #f87171 !important;
        }

        body.dark .services-active-chips-bar .btn-clear-active-filters:hover,
        body.dark .services-active-chips-bar .btn-clear-active-filters:active,
        body.dark .services-active-chips-bar .btn-clear-active-filters-mobile:hover,
        body.dark .services-active-chips-bar .btn-clear-active-filters-mobile:active {
            color: #fca5a5 !important;
            background: rgba(239, 68, 68, 0.15) !important;
        }

        .services-active-chips-bar .active-chips-wrapper {
            order: 3 !important;
            width: 100% !important;
            flex: 0 0 100% !important;
            position: relative !important;
            margin-top: 2px !important;
        }

        .services-active-chips-bar .active-chips-scroll-track {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
            gap: 8px !important;
            padding: 2px 2px 4px 2px !important;
            width: 100% !important;
        }

        .services-active-chips-bar .active-chips-scroll-track::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .services-active-chips-bar .filter-chip {
            flex-shrink: 0 !important;
            white-space: nowrap !important;
            max-width: none !important;
            box-sizing: border-box !important;
            font-size: 11.5px !important;
            padding: 4px 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .services-active-chips-bar .filter-chip .chip-text {
            overflow: visible !important;
            text-overflow: clip !important;
            white-space: nowrap !important;
            max-width: none !important;
        }

        /* Kart İçi Düzenlemeler */
        .modern-service-card .msc-body {
            padding: 12px 14px 14px 14px !important;
        }

        .modern-service-card .msc-title {
            font-size: 14px !important;
            line-height: 1.35 !important;
            margin-bottom: 8px !important;
        }

        .modern-service-card .msc-firm-location-row {
            padding: 5px 8px !important;
            margin-bottom: 10px !important;
        }

        .modern-service-card .msc-company-name {
            font-size: 11.5px !important;
        }

        .modern-service-card .msc-location {
            font-size: 11px !important;
        }

        .modern-service-card .msc-current-price {
            font-size: 16.5px !important;
        }

        .modern-service-card .msc-action-btn {
            padding: 6px 12px !important;
            font-size: 11.5px !important;
        }

        /* Sayfalama (Pagination): Mobilde Ortalanmış ve Sıkışmayan Boyutlar */
        .sd-modern-pagination-wrapper {
            padding-top: 16px !important;
            margin-top: 16px !important;
            justify-content: center !important;
        }

        .sd-pagination-list {
            gap: 4px !important;
            justify-content: center !important;
            max-width: 100% !important;
        }

        .sd-page-btn {
            min-width: 34px !important;
            height: 34px !important;
            font-size: 12.5px !important;
            padding: 0 6px !important;
            border-radius: 8px !important;
        }

        .sd-page-dots {
            width: 20px !important;
            height: 34px !important;
        }

        /* Footer Yasal Açıklama: Floating bar altında kalmaması için yeterli boşluk */
        .services-content-col footer {
            padding-bottom: 30px !important;
            margin-bottom: 30px !important;
        }

        /* ========================================================
           MOBİL MODERN SKELETON LOADER (Shimmer Efektli Yükleme Kartları)
           ======================================================== */
        .services-dynamic-area.is-loading {
            opacity: 1 !important;
            pointer-events: none;
            user-select: none;
        }

        .services-dynamic-area.is-loading .services-active-chips-bar {
            opacity: 0.55;
            transition: opacity 0.2s ease;
        }

        /* Temel Shimmer Efekti */
        .skeleton-shimmer {
            position: relative !important;
            overflow: hidden !important;
            background-color: #f1f5f9 !important;
        }

        .skeleton-shimmer::after {
            content: "" !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            left: 0 !important;
            transform: translateX(-100%) !important;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.7) 50%,
                rgba(255, 255, 255, 0) 100%
            ) !important;
            animation: modernSkeletonShimmer 1.35s infinite ease-in-out !important;
        }

        @keyframes modernSkeletonShimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Dark Mode Shimmer */
        body.dark .skeleton-shimmer {
            background-color: #1a222d !important;
        }

        body.dark .skeleton-shimmer::after {
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.08) 50%,
                rgba(255, 255, 255, 0) 100%
            ) !important;
        }

        /* Skeleton Kart Gövdesi */
        .modern-service-skeleton {
            pointer-events: none;
            border: 1px solid rgba(226, 232, 240, 0.85) !important;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.04) !important;
            background: #ffffff !important;
            border-radius: 16px !important;
            overflow: hidden;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        body.dark .modern-service-skeleton {
            background: #1e2430 !important;
            border-color: #2e384d !important;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25) !important;
        }

        /* Görsel Alanı Skeleton */
        .modern-service-skeleton .skeleton-image-box {
            width: 100% !important;
            aspect-ratio: 16 / 10;
            min-height: 180px;
            max-height: 220px;
            border-radius: 15px 15px 0 0 !important;
            position: relative;
        }

        /* Kategori Rozeti Skeleton */
        .modern-service-skeleton .skeleton-pill-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            width: 76px;
            height: 22px;
            border-radius: 20px !important;
            background-color: #e2e8f0 !important;
            z-index: 2;
        }

        body.dark .modern-service-skeleton .skeleton-pill-badge {
            background-color: #2b3648 !important;
        }

        /* Çizgi Skeleton Parçaları */
        .skeleton-line {
            height: 12px;
            border-radius: 6px;
            display: block;
        }

        /* Başlık Skeleton */
        .modern-service-skeleton .skeleton-title-long {
            height: 14px;
            width: 85%;
            margin-bottom: 7px;
            border-radius: 6px;
        }

        .modern-service-skeleton .skeleton-title-short {
            height: 14px;
            width: 55%;
            margin-bottom: 12px;
            border-radius: 6px;
        }

        /* Firma / Konum Satırı */
        .modern-service-skeleton .skeleton-firm-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 8px !important;
            margin-bottom: 12px !important;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
        }

        body.dark .modern-service-skeleton .skeleton-firm-bar {
            background: #161b24;
            border-color: #232d3d;
        }

        .modern-service-skeleton .skeleton-avatar-circle {
            width: 22px;
            height: 22px;
            border-radius: 50% !important;
            flex-shrink: 0;
            background-color: #e2e8f0 !important;
        }

        body.dark .modern-service-skeleton .skeleton-avatar-circle {
            background-color: #2b3648 !important;
        }

        .modern-service-skeleton .skeleton-company-text {
            height: 11px;
            width: 75px;
            border-radius: 4px;
        }

        .modern-service-skeleton .skeleton-location-text {
            height: 11px;
            width: 65px;
            border-radius: 4px;
            margin-left: auto;
        }

        /* Footer Satırı (Fiyat & Buton) */
        .modern-service-skeleton .skeleton-footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
        }

        body.dark .modern-service-skeleton .skeleton-footer-bar {
            border-top-color: #283344;
        }

        .modern-service-skeleton .skeleton-price-wrapper {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .modern-service-skeleton .skeleton-price-sub {
            height: 9px;
            width: 44px;
            border-radius: 4px;
        }

        .modern-service-skeleton .skeleton-price-main {
            height: 18px;
            width: 90px;
            border-radius: 6px;
        }

        .modern-service-skeleton .skeleton-action-btn {
            width: 76px;
            height: 30px;
            border-radius: 8px !important;
        }

        /* Liste Görünümü (Tablet 768px-991.98px) için Skeleton Uyarlaması */
        @media (min-width: 768px) {
            .services-list-view .modern-service-skeleton {
                flex-direction: row !important;
                height: 230px !important;
            }
            .services-list-view .modern-service-skeleton .skeleton-image-box {
                width: 300px !important;
                height: 230px !important;
                border-radius: 15px 0 0 15px !important;
                flex-shrink: 0;
            }
            .services-list-view .modern-service-skeleton .msc-body {
                flex: 1 !important;
                padding: 18px 24px !important;
            }
        }

        /* Yeni gelen içerik için akıcı modern fade-in animasyonu */
        .services-dynamic-area:not(.is-loading) #servicesCardsRow > .service-card-col {
            animation: modernCardsFadeIn 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modernCardsFadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }

    @media (min-width: 992px) {
        /* Masaüstü Sol Sidebar Filtre Paneli Görünürlüğü ve Sabitlemesi */
        .services-sidebar-col .services-filter-panel,
        .services-sidebar-col #servicesFilterDrawer {
            position: static !important;
            visibility: visible !important;
            transform: none !important;
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            max-height: 100% !important;
            min-height: 100% !important;
            background: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            overflow: hidden !important;
            z-index: auto !important;
            width: 100% !important;
        }

        .services-sidebar-col .offcanvas-body,
        .services-sidebar-col .services-filter-card {
            visibility: visible !important;
            transform: none !important;
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            max-height: 100% !important;
            overflow: hidden !important;
            width: 100% !important;
        }

        /* Masaüstünde seçili filtreler: Kart İçinde Tek Satırda Sol: Başlık, Orta: Çipler, Sağ: Filtreleri Temizle */
        .services-active-chips-bar {
            display: block !important;
            width: 100% !important;
            margin-top: 10px !important;
            padding-top: 10px !important;
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        body.dark .services-active-chips-bar {
            border-top-color: #283344 !important;
        }

        .services-active-chips-bar .active-chips-container {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            width: 100% !important;
            padding: 0 2px !important;
            gap: 12px !important;
        }

        .services-active-chips-bar .active-chips-label {
            order: 1 !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #475569 !important;
            margin: 0 !important;
            flex: 0 0 auto !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            white-space: nowrap !important;
        }

        body.dark .services-active-chips-bar .active-chips-label {
            color: #94a3b8 !important;
        }

        .services-active-chips-bar .active-chips-wrapper {
            order: 2 !important;
            flex: 1 1 0% !important;
            min-width: 0 !important;
            position: relative !important;
            width: auto !important;
        }

        .services-active-chips-bar .btn-clear-active-filters,
        .services-active-chips-bar .btn-clear-active-filters-mobile {
            order: 3 !important;
            font-size: 12.5px !important;
            font-weight: 600 !important;
            color: #ef4444 !important;
            text-decoration: none !important;
            line-height: 1 !important;
            padding: 4px 8px !important;
            border-radius: 6px !important;
            transition: all 0.15s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            white-space: nowrap !important;
            cursor: pointer !important;
            flex: 0 0 auto !important;
            margin-left: 0 !important;
        }

        .services-active-chips-bar .btn-clear-active-filters:hover,
        .services-active-chips-bar .btn-clear-active-filters:active,
        .services-active-chips-bar .btn-clear-active-filters-mobile:hover,
        .services-active-chips-bar .btn-clear-active-filters-mobile:active {
            color: #dc2626 !important;
            background: rgba(239, 68, 68, 0.08) !important;
        }

        body.dark .services-active-chips-bar .btn-clear-active-filters,
        body.dark .services-active-chips-bar .btn-clear-active-filters-mobile {
            color: #f87171 !important;
        }

        body.dark .services-active-chips-bar .btn-clear-active-filters:hover,
        body.dark .services-active-chips-bar .btn-clear-active-filters:active,
        body.dark .services-active-chips-bar .btn-clear-active-filters-mobile:hover,
        body.dark .services-active-chips-bar .btn-clear-active-filters-mobile:active {
            color: #fca5a5 !important;
            background: rgba(239, 68, 68, 0.15) !important;
        }

        .services-active-chips-bar .active-chips-scroll-track {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
            gap: 8px !important;
            padding: 2px 2px 4px 2px !important;
            width: 100% !important;
            cursor: grab !important;
        }

        .services-active-chips-bar .active-chips-scroll-track.is-dragging {
            cursor: grabbing !important;
            user-select: none !important;
        }

        .services-active-chips-bar .active-chips-scroll-track::-webkit-scrollbar {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        .services-active-chips-bar .filter-chip {
            flex-shrink: 0 !important;
            white-space: nowrap !important;
            max-width: none !important;
            box-sizing: border-box !important;
            font-size: 12px !important;
            padding: 4px 10px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
        }

        .services-active-chips-bar .filter-chip .chip-text {
            overflow: visible !important;
            text-overflow: clip !important;
            white-space: nowrap !important;
            max-width: none !important;
        }

        .active-chips-wrapper {
            position: relative;
            width: 100%;
        }

        .chips-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 5;
            color: #334155;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 0;
        }

        .chips-nav-btn:hover {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #93c5fd;
            box-shadow: 0 4px 12px rgba(29, 78, 216, 0.2);
            transform: translateY(-50%) scale(1.08);
        }

        body.dark .chips-nav-btn {
            background: #1e2430;
            border-color: #334155;
            color: #cbd5e1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        body.dark .chips-nav-btn:hover {
            background: #283244;
            color: #ffffff;
            border-color: #60a5fa;
        }

        .chips-nav-prev {
            left: -6px;
        }

        .chips-nav-next {
            right: -6px;
        }
    }
</style>
@endsection

@section('content')
    <div class="main services-main-fullwidth">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="services-modern-page">
                <div class="row g-0 services-main-row">
                    
                    {{-- ========================================================
                         SOL SÜTUN: FİLTRE PANELİ (Desktop: Fixed Navbar Altı / Mobil: Drawer)
                         ======================================================== --}}
                    <aside class="col-lg-3 services-sidebar-col">
                        <div class="services-filter-panel offcanvas-lg offcanvas-bottom" id="servicesFilterDrawer" tabindex="-1" aria-labelledby="servicesFilterDrawerLabel">
                            
                            {{-- Mobil Bottom Sheet Tutacağı (Handle Bar) --}}
                            <div class="services-drawer-handle d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#servicesFilterDrawer">
                                <span class="handle-bar"></span>
                            </div>

                            {{-- Mobil Drawer Başlığı --}}
                            <div class="offcanvas-header d-lg-none border-bottom px-3 py-2">
                                <h5 class="offcanvas-title d-flex align-items-center gap-2 mb-0" id="servicesFilterDrawerLabel">
                                    <i class="fa-solid fa-sliders text-primary"></i> Filtrele & Sırala
                                    @if($filterCount > 0)
                                        <span class="badge bg-primary text-white rounded-pill">{{ $filterCount }}</span>
                                    @endif
                                </h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" data-bs-target="#servicesFilterDrawer" aria-label="Kapat"></button>
                            </div>

                            {{-- Filtre Formu Kapsayıcısı --}}
                            <div class="offcanvas-body p-0">
                                <div class="services-filter-card w-100">
                                    
                                    {{-- Desktop Başlığı --}}
                                    <div class="sfc-header d-none d-lg-flex align-items-center justify-content-between">
                                        <h6 class="sfc-title mb-0 d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-sliders text-primary"></i> Filtrele
                                            @if($filterCount > 0)
                                                <span class="badge bg-primary text-white rounded-pill">{{ $filterCount }}</span>
                                            @endif
                                        </h6>
                                    </div>

                                    <form action="{{ route('services.index') }}" method="GET" id="servicesFilterForm">
                                        {{-- Sıralama Değerini Korumak İçin Gizli Input --}}
                                        <input type="hidden" name="order_by" id="filterOrderByInput" value="{{ request()->order_by }}">

                                        {{-- Kaydırılabilir Filtreler Alanı --}}
                                        <div class="services-filter-scroll">
                                            {{-- 1. Arama Çubuğu --}}
                                            <div class="filter-group mb-3">
                                                <label class="filter-label" for="filterSearchInput">
                                                    <i class="fa-solid fa-magnifying-glass me-1"></i> Kelime ile Ara
                                                </label>
                                                <div class="filter-input-wrapper search-wrapper">
                                                    <i class="fa-solid fa-magnifying-glass input-prefix-icon"></i>
                                                    <input type="text" name="q" id="filterSearchInput" class="filter-input"
                                                           placeholder="Örn: Mutfak dolabı, boya..." value="{{ request()->q }}">
                                                    <button type="button" class="input-clear-btn {{ request()->q ? '' : 'd-none' }}" id="searchClearBtn" title="Aramayı Temizle"
                                                            onclick="clearSearchInput(this)">
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- 2. Kategori Seçimi --}}
                                            <div class="filter-group mb-3">
                                                <label class="filter-label" for="categorySelect">
                                                    <i class="fa-solid fa-layer-group me-1"></i> Kategori
                                                </label>
                                                <select name="category" id="categorySelect" class="form-select filter-select" data-placeholder="Tüm Kategoriler" onchange="onCategoryChange()">
                                                    <option value="">Tüm Kategoriler</option>
                                                    @foreach(get_categories() as $category)
                                                        <option value="{{ $category->id }}" @selected(($selectedCategory?->id ?? request()->category) == $category->id)>{{ trim($category->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- 3. Alt Kategori Seçimi (Çoklu Seçim) --}}
                                            <div class="filter-group mb-3" id="subCategoryGroup" style="{{ !$selectedCategory ? 'display:none;' : '' }}">
                                                <label class="filter-label" for="sub-category-select">
                                                    <i class="fa-solid fa-tags me-1"></i> Alt Kategori
                                                </label>
                                                <select name="sub_category[]" class="form-select filter-select" id="sub-category-select" multiple data-placeholder="Tüm Alt Kategoriler">
                                                    <option value="">Tüm Alt Kategoriler</option>
                                                    @if($selectedCategory)
                                                        @foreach(get_sub_categories($selectedCategory->id) as $subCategory)
                                                            <option value="{{ $subCategory->id }}" @selected(in_array($subCategory->id, $subCategoryIds))>{{ trim($subCategory->name) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            {{-- 4. Konum (İl / İlçe) --}}
                                            <div class="filter-group mb-3">
                                                <label class="filter-label" for="provinceSelect">
                                                    <i class="fa-solid fa-location-dot me-1"></i> Şehir (İl)
                                                </label>
                                                <select name="province" id="provinceSelect" class="form-select filter-select" data-placeholder="Tüm Şehirler" onchange="onProvinceChange()">
                                                    <option value="">Tüm Şehirler</option>
                                                    @foreach(get_provinces() as $province)
                                                        <option value="{{ $province->id }}" @selected(($selectedProvince?->id ?? request()->province) == $province->id)>{{ trim($province->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="filter-group mb-3" id="districtGroup" style="{{ !$selectedProvince ? 'display:none;' : '' }}">
                                                <label class="filter-label" for="district-select">
                                                    <i class="fa-solid fa-map-pin me-1"></i> İlçe
                                                </label>
                                                <select name="district[]" class="form-select filter-select" id="district-select" multiple data-placeholder="Tüm İlçeler">
                                                    <option value="">Tüm İlçeler</option>
                                                    @if($selectedProvince)
                                                        @foreach(get_districts($selectedProvince->id) as $district)
                                                            <option value="{{ $district->id }}" @selected(in_array($district->id, $districtIds))>{{ trim($district->name) }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            {{-- 5. Fiyat Aralığı (TL) --}}
                                            <div class="filter-group mb-3">
                                                <label class="filter-label">
                                                    <i class="fa-solid fa-wallet me-1"></i> Fiyat Aralığı (TL)
                                                </label>
                                                <div class="filter-range-grid">
                                                    <div class="filter-input-wrapper">
                                                        <span class="input-unit-symbol">₺</span>
                                                        <input type="text" inputmode="numeric" name="min_price" id="filterMinPrice" class="filter-input" placeholder="Min TL"
                                                               value="{{ request()->min_price ? number_format((float)str_replace(['.', ','], '', request()->min_price), 0, ',', '.') : '' }}"
                                                               oninput="onPriceInput(this)" onchange="onPriceCommit(this)" onblur="onPriceCommit(this)">
                                                    </div>
                                                    <span class="range-separator"><i class="fa-solid fa-arrow-right-long"></i></span>
                                                    <div class="filter-input-wrapper">
                                                        <span class="input-unit-symbol">₺</span>
                                                        <input type="text" inputmode="numeric" name="max_price" id="filterMaxPrice" class="filter-input" placeholder="Max TL"
                                                               value="{{ request()->max_price ? number_format((float)str_replace(['.', ','], '', request()->max_price), 0, ',', '.') : '' }}"
                                                               oninput="onPriceInput(this)" onchange="onPriceCommit(this)" onblur="onPriceCommit(this)">
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- 6. Metrekare (m²) Akordeonu --}}
                                            <div class="filter-group mb-3">
                                                <a class="filter-accordion-toggle d-flex justify-content-between align-items-center text-decoration-none" 
                                                   data-bs-toggle="collapse" href="#sqmCollapse" role="button" 
                                                   aria-expanded="{{ (request()->min_sqm || request()->max_sqm) ? 'true' : 'false' }}">
                                                    <label class="filter-label mb-0" style="cursor: pointer;">
                                                        <i class="fa-solid fa-ruler-combined me-1"></i> Metrekare (m²)
                                                    </label>
                                                    <i class="fa-solid fa-chevron-down toggle-icon"></i>
                                                </a>
                                                <div class="collapse {{ (request()->min_sqm || request()->max_sqm) ? 'show' : '' }} mt-2" id="sqmCollapse">
                                                    <div class="filter-range-grid">
                                                        <div class="filter-input-wrapper">
                                                            <input type="number" name="min_sqm" id="filterMinSqm" class="filter-input" placeholder="Min" 
                                                                   value="{{ request()->min_sqm }}" min="0"
                                                                   oninput="onSqmInput(this)" onchange="onSqmCommit(this)" onblur="onSqmCommit(this)">
                                                            <span class="input-unit-badge">m²</span>
                                                        </div>
                                                        <span class="range-separator"><i class="fa-solid fa-arrow-right-long"></i></span>
                                                        <div class="filter-input-wrapper">
                                                            <input type="number" name="max_sqm" id="filterMaxSqm" class="filter-input" placeholder="Max" 
                                                                   value="{{ request()->max_sqm }}" min="0"
                                                                   oninput="onSqmInput(this)" onchange="onSqmCommit(this)" onblur="onSqmCommit(this)">
                                                            <span class="input-unit-badge">m²</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- 7. Dinamik Kategori Parametreleri --}}
                                            <div id="dynamicParametersContainer" class="filter-group mb-3">
                                                @if(isset($categoryParameters) && count($categoryParameters) > 0)
                                                    @foreach($categoryParameters as $parameter)
                                                        <div class="mb-3" data-dynamic-parameter>
                                                            <label class="filter-label">
                                                                <i class="fa-solid fa-sliders me-1"></i> {{ $parameter->title }}
                                                            </label>
                                                            @if($parameter->type === 'input')
                                                                <div class="filter-input-wrapper">
                                                                    <input type="text" 
                                                                           name="parameters[{{ $parameter->id }}]" 
                                                                           class="filter-input" 
                                                                           placeholder="{{ $parameter->title }}"
                                                                           value="{{ request()->parameters[$parameter->id] ?? '' }}">
                                                                </div>
                                                            @elseif($parameter->type === 'select' && !empty($parameter->options))
                                                                <select name="parameters[{{ $parameter->id }}]" class="form-select filter-select" data-placeholder="Tümü">
                                                                    <option value="">Tümü</option>
                                                                    @foreach($parameter->options as $option)
                                                                        <option value="{{ $option }}" 
                                                                                @selected((request()->parameters[$parameter->id] ?? '') == $option)>
                                                                            {{ $option }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        {{-- 8. Desktop Aksiyon Butonları (Her Zaman Sayfanın Altında Sabit) --}}
                                        <div class="filter-actions-desktop d-none d-lg-flex gap-2">
                                            <button type="submit" form="servicesFilterForm" id="desktopFilterSubmitBtn" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                                                <i class="fa-solid fa-filter"></i> Filtrele
                                            </button>
                                            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary {{ $hasActiveFilters ? 'd-flex' : 'd-none' }} align-items-center justify-content-center gap-2" id="desktopFilterClearBtn" title="Filtreleri Temizle">
                                                <i class="fa-solid fa-rotate-left"></i> Temizle
                                            </a>
                                        </div>

                                        {{-- Mobil Bottom Sheet Sabit Alt Butonları --}}
                                        <div class="filter-actions-mobile d-lg-none mt-3 pt-3 border-top d-flex gap-2 px-3 pb-3">
                                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center gap-2" id="mobileFilterSubmitBtn">
                                                <i class="fa-solid fa-filter"></i> Filtrele
                                            </button>
                                            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary {{ $hasActiveFilters ? 'd-flex' : 'd-none' }} align-items-center justify-content-center gap-2" id="mobileFilterClearBtn" title="Filtreleri Temizle">
                                                <i class="fa-solid fa-rotate-left"></i> Temizle
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </aside>

                    {{-- ========================================================
                         SAĞ SÜTUN: HEADER REKLAM, BREADCRUMB, BAŞLIK, PİLLER & İÇERİK
                         ======================================================== --}}
                    <main class="col-lg-9 services-content-col">
                        
                        {{-- 1. Header Altı Leaderboard Reklam Alanı --}}
                        <div class="services-hero-ad header-leaderboard-ad text-center mb-3 d-none d-md-block">
                            <x-ad-slot format="" :responsive="false" class="leaderboard-ad-top" />
                        </div>

                        {{-- ========================================================
                             DİNAMİK YENİLENEN İÇERİK ALANI (AJAX KAPSAYICISI)
                             ======================================================== --}}
                        <div id="servicesDynamicArea" class="services-dynamic-area">
                            <div class="services-loading-indicator"></div>

                            {{-- 2. Breadcrumb / Ekmek Kırıntısı Navigasyonu --}}
                            <nav class="services-breadcrumb mb-3" aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="fa-solid fa-house"></i> Anasayfa</a>
                                    </li>
                                    @if($selectedCategory)
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('services.index') }}">Hizmetler</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $selectedCategory->name }}</li>
                                        @if($selectedSubCategories->isNotEmpty())
                                            <li class="breadcrumb-item active" aria-current="page">{{ $selectedSubCategories->pluck('name')->join(', ') }}</li>
                                        @endif
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page">Hizmetler</li>
                                    @endif
                                </ol>
                            </nav>

                            {{-- 5. Sonuç Toolbar & Seçili Filtreler Kartı (Sayaç, Sıralama, Grid/List Switcher ve Seçili Filtreler) --}}
                            <div id="servicesToolbarPlaceholder" class="services-toolbar-placeholder d-none"></div>
                            <div class="services-toolbar" id="servicesToolbar">
                                <div class="services-toolbar-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="st-left d-flex align-items-center gap-2">
                                {{-- Mobilde Sabit İkonlar ve Sağa/Sola Kaydırılabilir Hızlı Filtreleme Seçenekleri --}}
                                <div class="services-mobile-filter-bar d-lg-none">
                                    {{-- 1. Solda Sabit Kalan Filtrele ve Sırala İkonları --}}
                                    <div class="services-mobile-fixed-actions">
                                        <button type="button" class="btn btn-outline-primary services-toolbar-btn-icon services-toolbar-filter-btn"
                                                data-bs-toggle="offcanvas" data-bs-target="#servicesFilterDrawer" aria-controls="servicesFilterDrawer" title="Tüm Filtreler">
                                            <i class="fa-solid fa-sliders"></i>
                                            @if($filterCount > 0)
                                                <span class="badge bg-primary text-white rounded-pill">{{ $filterCount }}</span>
                                            @endif
                                        </button>

                                        <button type="button" class="btn btn-outline-secondary services-toolbar-btn-icon services-toolbar-sort-btn"
                                                id="mobileSortIconBtn" onclick="toggleSortDropdown(event)" title="Sırala">
                                            <i class="fa-solid fa-arrow-down-short-wide"></i>
                                            @if(request()->order_by)
                                                <span class="services-sort-active-dot"></span>
                                            @endif
                                        </button>
                                    </div>

                                    {{-- 2. Sağ Taraf: Sağa ve Sola Kaydırılabilir Filtreler (Kategori, Şehir, Fiyat, m², Arama) --}}
                                    <div class="services-mobile-scroll-track">
                                        {{-- Kategori Seçimi (Normal filtre ile birebir aynı custom-select, başlıksız) --}}
                                        <div class="mobile-track-select-wrap">
                                            <select id="mobileTrackCategorySelect" class="form-select filter-select" data-placeholder="Tüm Kategoriler" data-icon="fa-solid fa-layer-group" onchange="onMobileTrackCategoryChange(this.value)">
                                                <option value="">Tüm Kategoriler</option>
                                                @foreach(get_categories() as $category)
                                                    <option value="{{ $category->id }}" @selected(($selectedCategory?->id ?? request()->category) == $category->id)>
                                                        {{ trim($category->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Alt Kategori Seçimi (Çoklu Seçim, Başlıksız) --}}
                                        <div class="mobile-track-select-wrap {{ !$selectedCategory ? 'd-none' : '' }}" id="mobileTrackSubCatWrapper" style="{{ !$selectedCategory ? 'display:none;' : '' }}">
                                            <select id="mobileTrackSubCatSelect" class="form-select filter-select" multiple data-placeholder="Tüm Alt Kategoriler" data-icon="fa-solid fa-tags" onchange="onMobileTrackSubCatChange()">
                                                <option value="">Tüm Alt Kategoriler</option>
                                                @if($selectedCategory)
                                                    @foreach(get_sub_categories($selectedCategory->id) as $subCategory)
                                                        <option value="{{ $subCategory->id }}" @selected(in_array($subCategory->id, $subCategoryIds))>
                                                            {{ trim($subCategory->name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        {{-- Şehir (İl) Seçimi (Başlıksız) --}}
                                        <div class="mobile-track-select-wrap">
                                            <select id="mobileTrackProvinceSelect" class="form-select filter-select" data-placeholder="Tüm Şehirler" data-icon="fa-solid fa-location-dot" onchange="onMobileTrackProvinceChange(this.value)">
                                                <option value="">Tüm Şehirler</option>
                                                @foreach(get_provinces() as $province)
                                                    <option value="{{ $province->id }}" @selected(($selectedProvince?->id ?? request()->province) == $province->id)>
                                                        {{ trim($province->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- İlçe Seçimi (Çoklu Seçim, Başlıksız) --}}
                                        <div class="mobile-track-select-wrap {{ !$selectedProvince ? 'd-none' : '' }}" id="mobileTrackDistrictWrapper" style="{{ !$selectedProvince ? 'display:none;' : '' }}">
                                            <select id="mobileTrackDistrictSelect" class="form-select filter-select" multiple data-placeholder="Tüm İlçeler" data-icon="fa-solid fa-map-pin" onchange="onMobileTrackDistrictChange()">
                                                <option value="">Tüm İlçeler</option>
                                                @if($selectedProvince)
                                                    @foreach(get_districts($selectedProvince->id) as $district)
                                                        <option value="{{ $district->id }}" @selected(in_array($district->id, $districtIds))>
                                                            {{ trim($district->name) }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        {{-- Fiyat Aralığı (TL) (Normal filtredeki filter-input-wrapper tasarımıyla, başlıksız, kademeli & durumlu genişlik) --}}
                                        @php
                                            $minPriceVal = request()->min_price ? number_format((float)str_replace(['.', ','], '', request()->min_price), 0, ',', '.') : '';
                                            $minPriceLen = strlen($minPriceVal);
                                            $minPriceClass = $minPriceVal ? 'has-value ' . ($minPriceLen >= 10 ? 'step-xwide' : ($minPriceLen >= 7 ? 'step-wide' : ($minPriceLen >= 4 ? 'step-mid' : ''))) : '';

                                            $maxPriceVal = request()->max_price ? number_format((float)str_replace(['.', ','], '', request()->max_price), 0, ',', '.') : '';
                                            $maxPriceLen = strlen($maxPriceVal);
                                            $maxPriceClass = $maxPriceVal ? 'has-value ' . ($maxPriceLen >= 10 ? 'step-xwide' : ($maxPriceLen >= 7 ? 'step-wide' : ($maxPriceLen >= 4 ? 'step-mid' : ''))) : '';

                                            $minSqmVal = request()->min_sqm ? (string)request()->min_sqm : '';
                                            $minSqmLen = strlen($minSqmVal);
                                            $minSqmClass = $minSqmVal ? 'has-value ' . ($minSqmLen >= 10 ? 'step-xwide' : ($minSqmLen >= 7 ? 'step-wide' : ($minSqmLen >= 4 ? 'step-mid' : ''))) : '';

                                            $maxSqmVal = request()->max_sqm ? (string)request()->max_sqm : '';
                                            $maxSqmLen = strlen($maxSqmVal);
                                            $maxSqmClass = $maxSqmVal ? 'has-value ' . ($maxSqmLen >= 10 ? 'step-xwide' : ($maxSqmLen >= 7 ? 'step-wide' : ($maxSqmLen >= 4 ? 'step-mid' : ''))) : '';
                                        @endphp
                                        <div class="mobile-track-range-group" title="Fiyat Aralığı (TL)">
                                            <div class="filter-input-wrapper {{ $minPriceClass }}">
                                                 <span class="input-unit-symbol">₺</span>
                                                 <input type="text" inputmode="numeric" id="mobileTrackMinPrice" class="filter-input" placeholder="Min TL"
                                                        value="{{ $minPriceVal }}"
                                                        oninput="onMobileTrackPriceInput(this)" onchange="onMobileTrackPriceCommit(this)" onblur="onMobileTrackPriceCommit(this)">
                                            </div>
                                            <span class="range-separator"><i class="fa-solid fa-arrow-right-long"></i></span>
                                            <div class="filter-input-wrapper {{ $maxPriceClass }}">
                                                 <span class="input-unit-symbol">₺</span>
                                                 <input type="text" inputmode="numeric" id="mobileTrackMaxPrice" class="filter-input" placeholder="Max TL"
                                                        value="{{ $maxPriceVal }}"
                                                        oninput="onMobileTrackPriceInput(this)" onchange="onMobileTrackPriceCommit(this)" onblur="onMobileTrackPriceCommit(this)">
                                            </div>
                                        </div>

                                        {{-- Metrekare (m²) (Normal filtredeki filter-input-wrapper tasarımıyla, başlıksız, kademeli & durumlu genişlik) --}}
                                        <div class="mobile-track-range-group" title="Metrekare (m²)">
                                            <div class="filter-input-wrapper {{ $minSqmClass }}">
                                                 <input type="number" id="mobileTrackMinSqm" class="filter-input" placeholder="Min" min="0"
                                                        value="{{ $minSqmVal }}"
                                                        oninput="onMobileTrackSqmInput(this)" onchange="onMobileTrackSqmCommit(this)" onblur="onMobileTrackSqmCommit(this)">
                                                 <span class="input-unit-badge">m²</span>
                                            </div>
                                            <span class="range-separator"><i class="fa-solid fa-arrow-right-long"></i></span>
                                            <div class="filter-input-wrapper {{ $maxSqmClass }}">
                                                 <input type="number" id="mobileTrackMaxSqm" class="filter-input" placeholder="Max" min="0"
                                                        value="{{ $maxSqmVal }}"
                                                        oninput="onMobileTrackSqmInput(this)" onchange="onMobileTrackSqmCommit(this)" onblur="onMobileTrackSqmCommit(this)">
                                                 <span class="input-unit-badge">m²</span>
                                            </div>
                                        </div>

                                        {{-- Dinamik Kategori Parametreleri Alanı --}}
                                        <div id="mobileTrackDynamicContainer" class="d-inline-flex align-items-center gap-2"></div>

                                        {{-- Sıfırla / Temizle Butonu --}}
                                        <button type="button" class="mobile-track-reset-btn {{ $hasActiveFilters ? 'd-inline-flex' : 'd-none' }}" id="mobileTrackResetBtn" onclick="resetAllFilters(event)" title="Tüm Filtreleri Sıfırla">
                                            <i class="fa-solid fa-rotate-left"></i>
                                            <span>Temizle</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- 3. Hizmet Listeleniyor Alanı (Mobilde alt satırda, desktopta solda) --}}
                                <span class="services-count-text">
                                    <b>{{ number_format($serviceCount, 0, ',', '.') }}</b> hizmet listeleniyor
                                </span>
                            </div>

                            <div class="st-right d-flex align-items-center gap-2">
                                {{-- Akıllı Sıralama (Filtreleri Asla Kaybetmez) --}}
                                <div class="sort-selector-wrapper d-flex align-items-center gap-2">
                                    <select id="serviceSortSelect" class="form-select filter-select sort-select" data-placeholder="Varsayılan / En Yeni" onchange="updateSortOrder(this.value)">
                                        <option value="" @selected(!request()->order_by)>Varsayılan / En Yeni</option>
                                        <option value="price_asc" @selected(request()->order_by == 'price_asc')>Fiyat (Artan)</option>
                                        <option value="price_desc" @selected(request()->order_by == 'price_desc')>Fiyat (Azalan)</option>
                                        <option value="sqm_asc" @selected(request()->order_by == 'sqm_asc')>Metrekare (Artan)</option>
                                        <option value="sqm_desc" @selected(request()->order_by == 'sqm_desc')>Metrekare (Azalan)</option>
                                    </select>
                                </div>

                                {{-- Görünüm Değiştirici (Grid / List Switcher) --}}
                                <div class="view-mode-toggle btn-group btn-group-sm d-none d-sm-inline-flex" role="group" aria-label="Görünüm Seçenekleri">
                                    <button type="button" class="btn btn-outline-secondary active" id="viewModeGrid" onclick="setViewMode('grid')" title="Izgara Görünümü">
                                        <i class="fa-solid fa-grip"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="viewModeList" onclick="setViewMode('list')" title="Liste Görünümü">
                                        <i class="fa-solid fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- 6. Aktif Filtre Çipleri (Tıkla-Kaldır Rozetleri - Kart İçinde) --}}
                        @if($hasActiveFilters)
                            <div class="services-active-chips-bar services-active-filters">
                                <div class="active-chips-container d-flex align-items-center">
                                    <span class="active-chips-label m-0 flex-shrink-0"><i class="fa-solid fa-sliders text-primary"></i> Seçili Filtreler:</span>

                                    <div class="active-chips-wrapper position-relative">
                                        <button type="button" class="chips-nav-btn chips-nav-prev" onclick="scrollActiveChips(-240)" aria-label="Geri Kaydır">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </button>

                                        <div class="active-chips-scroll-track d-flex align-items-center">
                                    @if($selectedCategory)
                                        <span class="filter-chip">
                                            <span class="chip-text">Kategori: <b>{{ $selectedCategory->name }}</b></span>
                                            <a href="{{ route('services.index', request()->except(['category', 'sub_category', 'parameters', 'page'])) }}" class="chip-remove" title="Kategori Filtresini Kaldır">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if($selectedSubCategories->isNotEmpty())
                                        @foreach($selectedSubCategories as $subCat)
                                            @php
                                                $remainingSubCatIds = array_values(array_diff($subCategoryIds, [$subCat->id]));
                                                $subCatParams = request()->except(['sub_category', 'page']);
                                                if (!empty($remainingSubCatIds)) {
                                                    $subCatParams['sub_category'] = $remainingSubCatIds;
                                                }
                                            @endphp
                                            <span class="filter-chip">
                                                <span class="chip-text">Alt Kategori: <b>{{ $subCat->name }}</b></span>
                                                <a href="{{ route('services.index', $subCatParams) }}" class="chip-remove" title="Bu Alt Kategori Filtresini Kaldır">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </span>
                                        @endforeach
                                    @endif

                                    @if($selectedProvince)
                                        <span class="filter-chip">
                                            <span class="chip-text">İl: <b>{{ $selectedProvince->name }}</b></span>
                                            <a href="{{ route('services.index', request()->except(['province', 'district', 'page'])) }}" class="chip-remove" title="İl Filtresini Kaldır">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if($selectedDistricts->isNotEmpty())
                                        @foreach($selectedDistricts as $dist)
                                            @php
                                                $remainingDistrictIds = array_values(array_diff($districtIds, [$dist->id]));
                                                $distParams = request()->except(['district', 'page']);
                                                if (!empty($remainingDistrictIds)) {
                                                    $distParams['district'] = $remainingDistrictIds;
                                                }
                                            @endphp
                                            <span class="filter-chip">
                                                <span class="chip-text">İlçe: <b>{{ $dist->name }}</b></span>
                                                <a href="{{ route('services.index', $distParams) }}" class="chip-remove" title="Bu İlçe Filtresini Kaldır">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </span>
                                        @endforeach
                                    @endif

                                    @if(request()->min_price || request()->max_price)
                                        @php
                                            $chipMinPrice = request()->min_price ? (float)str_replace(['.', ','], '', request()->min_price) : null;
                                            $chipMaxPrice = request()->max_price ? (float)str_replace(['.', ','], '', request()->max_price) : null;
                                        @endphp
                                        <span class="filter-chip">
                                            <span class="chip-text">
                                                Fiyat: 
                                                <b>
                                                    @if($chipMinPrice !== null && $chipMaxPrice !== null)
                                                        {{ number_format($chipMinPrice, 0, ',', '.') }} - {{ number_format($chipMaxPrice, 0, ',', '.') }} TL
                                                    @elseif($chipMinPrice !== null)
                                                        Min {{ number_format($chipMinPrice, 0, ',', '.') }} TL
                                                    @else
                                                        Max {{ number_format($chipMaxPrice, 0, ',', '.') }} TL
                                                    @endif
                                                </b>
                                            </span>
                                            <a href="{{ route('services.index', request()->except(['min_price', 'max_price', 'page'])) }}" class="chip-remove" title="Fiyat Filtresini Kaldır">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request()->min_sqm || request()->max_sqm)
                                        <span class="filter-chip">
                                            <span class="chip-text">
                                                m²: <b>{{ request()->min_sqm ?? 0 }} - {{ request()->max_sqm ?? '∞' }} m²</b>
                                            </span>
                                            <a href="{{ route('services.index', request()->except(['min_sqm', 'max_sqm', 'page'])) }}" class="chip-remove" title="Metrekare Filtresini Kaldır">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request()->q)
                                        <span class="filter-chip">
                                            <span class="chip-text">Arama: <b>"{{ request()->q }}"</b></span>
                                            <a href="{{ route('services.index', request()->except(['q', 'page'])) }}" class="chip-remove" title="Aramayı Kaldır">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>
                                        </span>
                                    @endif

                                    @if(request()->has('parameters') && is_array(request()->parameters))
                                        @foreach(request()->parameters as $paramId => $paramVal)
                                            @if(!empty($paramVal) && $cp = \App\Models\CategoryParameter::find($paramId))
                                                <span class="filter-chip">
                                                    <span class="chip-text">{{ $cp->title }}: <b>{{ $paramVal }}</b></span>
                                                    @php
                                                        $remainingParams = request()->parameters;
                                                        unset($remainingParams[$paramId]);
                                                    @endphp
                                                    <a href="{{ route('services.index', array_merge(request()->except(['parameters', 'page']), ['parameters' => $remainingParams])) }}" class="chip-remove" title="Parametreyi Kaldır">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        @endforeach
                                    @endif

                                    </div>

                                    <button type="button" class="chips-nav-btn chips-nav-next" onclick="scrollActiveChips(240)" aria-label="İleri Kaydır">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>
                                </div>

                                <a href="{{ route('services.index') }}" class="btn-clear-active-filters btn-clear-active-filters-mobile text-danger text-decoration-none fw-semibold flex-shrink-0">
                                    Filtreleri Temizle
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                        {{-- 7. Hizmet Kartları Izgarası / Listesi --}}
                        <div class="services-items-wrapper" id="servicesItemsContainer">
                            <div class="row g-3 g-md-4" id="servicesCardsRow">
                                @forelse($services as $service)
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 d-flex service-card-col">
                                        @include('site.services.partials.single-service-card', ['service' => $service])
                                    </div>

                                    {{-- Mobilde her 4 içerikten sonra duyarlı reklam --}}
                                    @if($loop->iteration % 4 == 0)
                                        <div class="col-12 d-block d-md-none text-center my-2">
                                            <div class="p-2 bg-light rounded border">
                                                <x-ad-slot format="auto" />
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    {{-- Boş Durum (Empty State) --}}
                                    <div class="col-12">
                                        <div class="services-empty-state text-center py-5 px-3">
                                            <div class="empty-icon-wrap mb-3">
                                                <i class="fa-solid fa-magnifying-glass-chart"></i>
                                            </div>
                                            <h4 class="empty-title">Aramanıza Uygun Hizmet Bulunamadı</h4>
                                            <p class="empty-desc text-muted mb-4 mx-auto" style="max-width: 520px;">
                                                Arama kriterlerinizi genişleterek, farklı bir il veya ilçe seçerek ya da filtreleri temizleyerek daha fazla sonuca ulaşabilirsiniz.
                                            </p>
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('services.index') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                                                    <i class="fa-solid fa-rotate-left me-1"></i> Filtreleri Sıfırla
                                                </a>
                                                <a href="/" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                                                    <i class="fa-solid fa-house me-1"></i> Anasayfaya Dön
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                                {{-- Masaüstü Sayfa Altı Yatay Reklam --}}
                                @if($services->count() > 0)
                                    <div class="col-12 d-none d-md-block my-4 text-center">
                                        <x-ad-slot format="auto" />
                                    </div>

                                    {{-- Modern Sayfalama (Pagination - Firma Profili ile Birebir Aynı) --}}
                                    @if($services->hasPages())
                                        <div class="col-12 services-pagination">
                                            <div class="sd-modern-pagination-wrapper">
                                                <div class="sd-pagination-info d-none d-md-block">
                                                    <span>Toplam <strong>{{ $services->total() }}</strong> hizmetten <strong>{{ $services->firstItem() }}-{{ $services->lastItem() }}</strong> arası listeleniyor</span>
                                                </div>

                                                <nav class="sd-pagination-nav" aria-label="Hizmet sayfaları">
                                                    <ul class="sd-pagination-list">
                                                        {{-- Önceki Sayfa --}}
                                                        @if ($services->onFirstPage())
                                                            <li class="sd-page-item disabled" aria-disabled="true">
                                                                <span class="sd-page-btn sd-page-prev">
                                                                    <i class="fa-solid fa-chevron-left"></i>
                                                                    <span class="d-none d-sm-inline">Önceki</span>
                                                                </span>
                                                            </li>
                                                        @else
                                                            <li class="sd-page-item">
                                                                <a href="{{ $services->previousPageUrl() }}" class="sd-page-btn sd-page-prev" rel="prev">
                                                                    <i class="fa-solid fa-chevron-left"></i>
                                                                    <span class="d-none d-sm-inline">Önceki</span>
                                                                </a>
                                                            </li>
                                                        @endif

                                                        {{-- Sayfa Numaraları --}}
                                                        @php
                                                            $currentPage = $services->currentPage();
                                                            $lastPage = $services->lastPage();
                                                            $start = max(1, $currentPage - 2);
                                                            $end = min($lastPage, $currentPage + 2);
                                                        @endphp

                                                        @if($start > 1)
                                                            <li class="sd-page-item">
                                                                <a href="{{ $services->url(1) }}" class="sd-page-btn">1</a>
                                                            </li>
                                                            @if($start > 2)
                                                                <li class="sd-page-item disabled"><span class="sd-page-dots">…</span></li>
                                                            @endif
                                                        @endif

                                                        @for($page = $start; $page <= $end; $page++)
                                                            @if ($page == $currentPage)
                                                                <li class="sd-page-item active" aria-current="page">
                                                                    <span class="sd-page-btn">{{ $page }}</span>
                                                                </li>
                                                            @else
                                                                <li class="sd-page-item">
                                                                    <a href="{{ $services->url($page) }}" class="sd-page-btn">{{ $page }}</a>
                                                                </li>
                                                            @endif
                                                        @endfor

                                                        @if($end < $lastPage)
                                                            @if($end < $lastPage - 1)
                                                                <li class="sd-page-item disabled"><span class="sd-page-dots">…</span></li>
                                                            @endif
                                                            <li class="sd-page-item">
                                                                <a href="{{ $services->url($lastPage) }}" class="sd-page-btn">{{ $lastPage }}</a>
                                                            </li>
                                                        @endif

                                                        {{-- Sonraki Sayfa --}}
                                                        @if ($services->hasMorePages())
                                                            <li class="sd-page-item">
                                                                <a href="{{ $services->nextPageUrl() }}" class="sd-page-btn sd-page-next" rel="next">
                                                                    <span class="d-none d-sm-inline">Sonraki</span>
                                                                    <i class="fa-solid fa-chevron-right"></i>
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li class="sd-page-item disabled" aria-disabled="true">
                                                                <span class="sd-page-btn sd-page-next">
                                                                    <span class="d-none d-sm-inline">Sonraki</span>
                                                                    <i class="fa-solid fa-chevron-right"></i>
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>{{-- /#servicesDynamicArea --}}

                    {{-- 8. Yasal Bilgilendirme Footer --}}
                        <footer class="mt-4 pt-3 border-top text-muted small">
                            <p class="mb-0">
                                {{ str_replace(['http://', 'https://'], '', env('APP_URL')) }}'da yer alan üyelerin oluşturduğu tüm içerik, görüş ve bilgilerin doğruluğu,
                                eksiksiz ve değişmez olduğu, yayınlanması ile ilgili yasal yükümlülükler içeriği oluşturulan üyeye aittir.
                                Bu içeriğin, görüş ve bilgilerin yanlışlık, eksiklik veya yasalarla düzenlenmiş kurallara aykırılığından 
                                {{ str_replace(['http://', 'https://'], '', env('APP_URL')) }} hiçbir şekilde sorumlu değildir.
                            </p>
                        </footer>
                    </main>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================
         MOBİL YÜZEN SABİT AKSİYON BARI (Sticky Floating Action Bar)
         ======================================================== --}}
    <div class="services-mobile-floating-bar d-lg-none">
        <button type="button" class="btn btn-primary smfb-btn flex-grow-1 d-flex align-items-center justify-content-center gap-2"
                data-bs-toggle="offcanvas" data-bs-target="#servicesFilterDrawer" aria-controls="servicesFilterDrawer">
            <i class="fa-solid fa-sliders"></i>
            <span>Filtrele</span>
            @if($filterCount > 0)
                <span class="badge bg-white text-primary rounded-pill">{{ $filterCount }}</span>
            @endif
        </button>
        <button type="button" class="btn btn-light smfb-sort-btn d-flex align-items-center justify-content-center gap-1"
                onclick="openSortDropdown()">
            <i class="fa-solid fa-arrow-down-short-wide"></i>
            <span>Sırala</span>
        </button>
    </div>
@endsection

@section('js')
    <script>
        // Görünüm Modu Değiştirme (Grid / List) & Tercih Saklama
        function setViewMode(mode) {
            const container = document.getElementById('servicesCardsRow');
            const btnGrid = document.getElementById('viewModeGrid');
            const btnList = document.getElementById('viewModeList');

            if (!container) return;

            if (mode === 'list') {
                container.classList.add('services-list-view');
                if (btnList) btnList.classList.add('active');
                if (btnGrid) btnGrid.classList.remove('active');
                localStorage.setItem('evhayaliniz_services_view', 'list');
            } else {
                container.classList.remove('services-list-view');
                if (btnGrid) btnGrid.classList.add('active');
                if (btnList) btnList.classList.remove('active');
                localStorage.setItem('evhayaliniz_services_view', 'grid');
            }
        }

        // Akıllı Sıralama Güncelleme (Filtreleri Korumak İçin AJAX Motorunu Tetikler)
        function updateSortOrder(orderValue) {
            const val = (orderValue !== undefined && orderValue !== null) ? orderValue : '';
            const orderInput = document.getElementById('filterOrderByInput');
            if (orderInput) {
                orderInput.value = val;
            }
            applyFiltersAjax();
        }

        // Mobilde Sıralama Popup Menüsünü Açıp Kapatır (Aç/Kapa Geçişi)
        function toggleSortDropdown(event) {
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }
            const sortWrapper = document.querySelector('.sort-selector-wrapper .custom-select-wrapper');
            if (!sortWrapper) return;
            const isOpen = sortWrapper.classList.contains('open');
            closeAllCustomSelects();
            if (!isOpen) {
                sortWrapper.classList.add('open');
                document.getElementById('servicesToolbar')?.classList.add('has-open-select');
                document.getElementById('mobileSortIconBtn')?.classList.add('active');

                // Mobilde Sıralama Popup'ını Sırala İkonunun Hemen Altına & Boşluklu Konumlandır
                const popup = sortWrapper.querySelector('.custom-select-popup');
                const sortBtn = document.getElementById('mobileSortIconBtn');
                const toolbar = document.getElementById('servicesToolbar');
                if (popup && sortBtn && toolbar && window.innerWidth < 992) {
                    const btnRect = sortBtn.getBoundingClientRect();
                    const tbRect = toolbar.getBoundingClientRect();
                    const screenW = window.innerWidth;
                    const popupW = Math.min(215, screenW - 24);

                    // Dikey: Sırala ikonunun hemen 5px altına yerleştir
                    const topPos = Math.round(btnRect.bottom - tbRect.top + 5);

                    // Yatay: Sırala ikonunun sol kenarını baz al, sağ/sol ekrandan en az 12px boşluk bırak
                    let leftPos = Math.round(btnRect.left - tbRect.left);
                    if (btnRect.left + popupW > screenW - 12) {
                        leftPos = Math.round((screenW - 12 - popupW) - tbRect.left);
                    }
                    if (leftPos < 12) leftPos = 12;

                    popup.style.top = topPos + 'px';
                    popup.style.left = leftPos + 'px';
                    popup.style.right = 'auto';
                    popup.style.width = popupW + 'px';
                }

                showMobileBackdrop();
            } else {
                document.getElementById('servicesToolbar')?.classList.remove('has-open-select');
                document.getElementById('mobileSortIconBtn')?.classList.remove('active');
            }
        }

        // Mobilde Yüzen Sırala Butonu veya Toolbar Sırala İkonu için Menüyü Açar
        function openSortDropdown(event) {
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }
            const toolbar = document.querySelector('.services-toolbar');
            if (toolbar && window.innerWidth < 992) {
                toolbar.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                setTimeout(() => {
                    const sortWrapper = document.querySelector('.sort-selector-wrapper .custom-select-wrapper');
                    if (sortWrapper && !sortWrapper.classList.contains('open')) {
                        toggleSortDropdown();
                    }
                }, 100);
            } else {
                const sortWrapper = document.querySelector('.sort-selector-wrapper .custom-select-wrapper');
                if (!sortWrapper) return;
                const trigger = sortWrapper.querySelector('.custom-select-trigger');
                if (trigger) trigger.click();
            }
        }

        // Fiyat Girişi Binlik Ayracı (.) Motoru
        function formatNumberWithDots(val) {
            if (val === null || val === undefined || val === '') return '';
            const clean = val.toString().replace(/\D/g, '');
            if (!clean) return '';
            const num = parseInt(clean, 10);
            if (isNaN(num)) return '';
            return num.toLocaleString('tr-TR');
        }

        // Filtre Giriş Değeri Değişimi Onaylama (Input'tan çıkıldığında / blur / change)
        function commitFilterInputChange(input) {
            if (!input) return;
            const cur = (input.value || '').trim();
            if (input._lastCommittedValue !== cur) {
                input._lastCommittedValue = cur;
                const counterpartId = {
                    'filterMinPrice': 'mobileTrackMinPrice',
                    'mobileTrackMinPrice': 'filterMinPrice',
                    'filterMaxPrice': 'mobileTrackMaxPrice',
                    'mobileTrackMaxPrice': 'filterMaxPrice',
                    'filterMinSqm': 'mobileTrackMinSqm',
                    'mobileTrackMinSqm': 'filterMinSqm',
                    'filterMaxSqm': 'mobileTrackMaxSqm',
                    'mobileTrackMaxSqm': 'filterMaxSqm'
                }[input.id];
                if (counterpartId) {
                    const cp = document.getElementById(counterpartId);
                    if (cp) {
                        cp.value = input.value;
                        cp._lastCommittedValue = cur;
                    }
                }
                applyFiltersAjax();
            }
        }

        // Pop Up Fiyat Girişi Dinleyicisi (Yazarken sadece formatlar ve senkronize eder, AJAX çağırmaz)
        function onPriceInput(input) {
            if (!input) return;
            const rawVal = input.value.replace(/\D/g, '');
            input.value = rawVal ? parseInt(rawVal, 10).toLocaleString('tr-TR') : '';

            // Mobil yatay çubuğa anında senkronize et
            const counterpartId = (input.id === 'filterMinPrice') ? 'mobileTrackMinPrice' : (input.id === 'filterMaxPrice' ? 'mobileTrackMaxPrice' : null);
            if (counterpartId) {
                const trackInput = document.getElementById(counterpartId);
                if (trackInput && document.activeElement !== trackInput) {
                    trackInput.value = input.value;
                }
            }
            updateFilterButtonsState();
        }

        function onPriceCommit(input) {
            commitFilterInputChange(input);
        }

        // Pop Up Metrekare Girişi Dinleyicisi (Yazarken sadece senkronize eder, AJAX çağırmaz)
        function onSqmInput(input) {
            if (!input) return;
            const counterpartId = (input.id === 'filterMinSqm') ? 'mobileTrackMinSqm' : (input.id === 'filterMaxSqm' ? 'mobileTrackMaxSqm' : null);
            if (counterpartId) {
                const trackInput = document.getElementById(counterpartId);
                if (trackInput && document.activeElement !== trackInput) {
                    trackInput.value = input.value;
                }
            }
            updateFilterButtonsState();
        }

        function onSqmCommit(input) {
            commitFilterInputChange(input);
        }

        // Arama Çubuğunu Temizleme
        function clearSearchInput(btn) {
            const searchInput = document.getElementById('filterSearchInput');
            if (searchInput) searchInput.value = '';
            const clearBtn = btn || document.getElementById('searchClearBtn');
            if (clearBtn) clearBtn.classList.add('d-none');
            clearTimeout(filterDebounceTimer);
            updateFilterButtonsState();
            applyFiltersAjax();
        }

        // ==========================================================================
        // MOBİL YATAY FİLTRE ÇUBUĞU (Horizontal Scroll Track) ETKİLEŞİM VE SENKRONİZASYON
        // ==========================================================================

        // Mobil Yatay Hızlı Filtre Çubuğu: Doğrudan Ekran Ortasına Merkezle (Direct Screen Center Modeli)
        function centerMobileFilter(targetEl, attempts = 0) {
            if (!targetEl) return;
            // Eğer doğrudan input veya select verilmişse uygun kapsayıcıyı (wrapper) hedef al
            if (targetEl.classList && (targetEl.classList.contains('filter-input') || targetEl.tagName === 'INPUT')) {
                const wrapper = targetEl.closest('.filter-input-wrapper');
                if (wrapper) targetEl = wrapper;
            } else if (targetEl.tagName === 'SELECT') {
                const wrapper = targetEl.closest('.mobile-track-select-wrap');
                if (wrapper) targetEl = wrapper;
            }

            const track = document.querySelector('.services-mobile-scroll-track');
            if (!track) return;

            requestAnimationFrame(() => {
                setTimeout(() => {
                    // Eğer hedef gizliyse veya asenkron yükleniyorsa retry mekanizmasıyla bekle
                    if (targetEl.offsetParent === null || targetEl.classList.contains('d-none') || targetEl.style.display === 'none') {
                        if (attempts < 6) {
                            setTimeout(() => centerMobileFilter(targetEl, attempts + 1), 70);
                        }
                        return;
                    }

                    const targetRect = targetEl.getBoundingClientRect();

                    // Mobil ekranın tam yatay merkezi ile hedefin merkezi arasındaki fark
                    const screenCenter = window.innerWidth / 2;
                    const targetCenter = targetRect.left + (targetRect.width / 2);
                    const diff = targetCenter - screenCenter;

                    if (Math.abs(diff) > 2) {
                        const targetLeft = Math.max(0, track.scrollLeft + diff);
                        track.scrollTo({
                            left: targetLeft,
                            behavior: 'smooth'
                        });
                    }
                }, attempts === 0 ? 100 : 50);
            });
        }
        function smartRevealMobileFilter(targetEl) { centerMobileFilter(targetEl); }

        function onMobileTrackCategoryChange(catId) {
            const catSelect = document.getElementById('categorySelect');
            if (catSelect) {
                catSelect.value = catId || '';
                if (catSelect._refreshCustomSelect) catSelect._refreshCustomSelect();
            }
            onCategoryChange();
            applyFiltersAjax();
        }

        function onMobileTrackSubCatChange() {
            const trackSelect = document.getElementById('mobileTrackSubCatSelect');
            const drawerSelect = document.getElementById('sub-category-select');
            if (trackSelect && drawerSelect) {
                const selVals = Array.from(trackSelect.options).filter(o => o.selected).map(o => String(o.value));
                Array.from(drawerSelect.options).forEach(opt => {
                    opt.selected = selVals.includes(String(opt.value));
                });
                if (drawerSelect._refreshCustomSelect) drawerSelect._refreshCustomSelect();
            }
            updateFilterButtonsState();
            applyFiltersAjax();

            // Eğer açılır menü kapalıysa doğrudan sonraki alanı ortala
            const isPopupOpen = trackSelect?.closest('.custom-select-wrapper')?.classList.contains('open');
            if (!isPopupOpen) {
                const provWrap = document.getElementById('mobileTrackProvinceSelect')?.closest('.mobile-track-select-wrap');
                if (provWrap) centerMobileFilter(provWrap);
            }
        }

        function onMobileTrackProvinceChange(provId) {
            const provSelect = document.getElementById('provinceSelect');
            if (provSelect) {
                provSelect.value = provId || '';
                if (provSelect._refreshCustomSelect) provSelect._refreshCustomSelect();
            }
            onProvinceChange();
            applyFiltersAjax();
        }

        function onMobileTrackDistrictChange() {
            const trackSelect = document.getElementById('mobileTrackDistrictSelect');
            const drawerSelect = document.getElementById('district-select');
            if (trackSelect && drawerSelect) {
                const selVals = Array.from(trackSelect.options).filter(o => o.selected).map(o => String(o.value));
                Array.from(drawerSelect.options).forEach(opt => {
                    opt.selected = selVals.includes(String(opt.value));
                });
                if (drawerSelect._refreshCustomSelect) drawerSelect._refreshCustomSelect();
            }
            updateFilterButtonsState();
            applyFiltersAjax();

            // Eğer açılır menü kapalıysa doğrudan sonraki fiyat alanını ortala
            const isPopupOpen = trackSelect?.closest('.custom-select-wrapper')?.classList.contains('open');
            if (!isPopupOpen) {
                const priceGroup = document.querySelector('.mobile-track-range-group');
                if (priceGroup) centerMobileFilter(priceGroup);
            }
        }

        // Mobil Hızlı Filtre Çubuğu: Kademeli & Durumlu İnput Genişlik Yönetimi
        function syncMobileTrackInputState(inputEl) {
            if (!inputEl) return;
            const wrapper = inputEl.closest('.filter-input-wrapper');
            if (!wrapper) return;

            const val = (inputEl.value || '').trim();
            const len = val.length;

            wrapper.classList.remove('has-value', 'step-mid', 'step-wide', 'step-xwide');

            if (len > 0) {
                wrapper.classList.add('has-value');
                if (len >= 10) {
                    wrapper.classList.add('step-xwide');
                } else if (len >= 7) {
                    wrapper.classList.add('step-wide');
                } else if (len >= 4) {
                    wrapper.classList.add('step-mid');
                }
            }
        }

        function syncAllMobileTrackInputs() {
            const inputs = [
                document.getElementById('mobileTrackMinPrice'),
                document.getElementById('mobileTrackMaxPrice'),
                document.getElementById('mobileTrackMinSqm'),
                document.getElementById('mobileTrackMaxSqm')
            ];
            inputs.forEach(el => {
                if (el) syncMobileTrackInputState(el);
            });

            const dynInputs = document.querySelectorAll('#mobileTrackDynamicContainer .filter-input');
            dynInputs.forEach(el => {
                if (el) syncMobileTrackInputState(el);
            });
        }

        // Mobil Yatay Çubuk Fiyat Girişi (Yazarken formatlar & pop up formuyla eşitler, AJAX çağırmaz)
        function onMobileTrackPriceInput(inputEl) {
            if (inputEl) {
                let rawVal = inputEl.value.replace(/\D/g, '');
                inputEl.value = rawVal ? parseInt(rawVal, 10).toLocaleString('tr-TR') : '';
                syncMobileTrackInputState(inputEl);
            }

            const trackMin = document.getElementById('mobileTrackMinPrice');
            const trackMax = document.getElementById('mobileTrackMaxPrice');
            const filterMin = document.getElementById('filterMinPrice');
            const filterMax = document.getElementById('filterMaxPrice');

            if (filterMin && trackMin) filterMin.value = trackMin.value || '';
            if (filterMax && trackMax) filterMax.value = trackMax.value || '';

            updateFilterButtonsState();
        }

        // Mobil Yatay Çubuk Fiyat Girişi Onaylama (Kullanıcı inputtan çıktığında AJAX tetikler)
        function onMobileTrackPriceCommit(inputEl) {
            onMobileTrackPriceInput(inputEl);
            commitFilterInputChange(inputEl);

            if (inputEl && inputEl.value.trim() !== '') {
                if (inputEl.id === 'mobileTrackMinPrice') {
                    const maxP = document.getElementById('mobileTrackMaxPrice');
                    if (maxP) smartRevealMobileFilter(maxP.closest('.filter-input-wrapper'));
                } else if (inputEl.id === 'mobileTrackMaxPrice') {
                    const minS = document.getElementById('mobileTrackMinSqm');
                    if (minS) smartRevealMobileFilter(minS.closest('.filter-input-wrapper'));
                }
            }
        }

        // Geriye dönük uyumluluk
        function onMobileTrackPriceChange(inputEl) {
            onMobileTrackPriceCommit(inputEl);
        }

        // Mobil Yatay Çubuk Metrekare Girişi (Yazarken pop up formuyla eşitler, AJAX çağırmaz)
        function onMobileTrackSqmInput(inputEl) {
            if (inputEl) syncMobileTrackInputState(inputEl);

            const form = document.getElementById('servicesFilterForm');
            const trackMin = document.getElementById('mobileTrackMinSqm');
            const trackMax = document.getElementById('mobileTrackMaxSqm');
            const formMin = document.getElementById('filterMinSqm') || (form ? form.querySelector('input[name="min_sqm"]') : null);
            const formMax = document.getElementById('filterMaxSqm') || (form ? form.querySelector('input[name="max_sqm"]') : null);

            if (formMin && trackMin) formMin.value = trackMin.value || '';
            if (formMax && trackMax) formMax.value = trackMax.value || '';

            updateFilterButtonsState();
        }

        // Mobil Yatay Çubuk Metrekare Girişi Onaylama (Kullanıcı inputtan çıktığında AJAX tetikler)
        function onMobileTrackSqmCommit(inputEl) {
            onMobileTrackSqmInput(inputEl);
            commitFilterInputChange(inputEl);

            if (inputEl && inputEl.value.trim() !== '') {
                if (inputEl.id === 'mobileTrackMinSqm') {
                    const maxS = document.getElementById('mobileTrackMaxSqm');
                    if (maxS) smartRevealMobileFilter(maxS.closest('.filter-input-wrapper'));
                } else if (inputEl.id === 'mobileTrackMaxSqm') {
                    const dynContainer = document.getElementById('mobileTrackDynamicContainer');
                    const firstDyn = dynContainer ? dynContainer.firstElementChild : null;
                    if (firstDyn) {
                        smartRevealMobileFilter(firstDyn);
                    } else {
                        const resetBtn = document.getElementById('mobileTrackResetBtn');
                        if (resetBtn && !resetBtn.classList.contains('d-none')) {
                            smartRevealMobileFilter(resetBtn);
                        }
                    }
                }
            }
        }

        // Geriye dönük uyumluluk
        function onMobileTrackSqmChange(inputEl) {
            onMobileTrackSqmCommit(inputEl);
        }

        function onMobileTrackDynamicInput(paramId, val, inputEl) {
            if (inputEl) syncMobileTrackInputState(inputEl);
            const form = document.getElementById('servicesFilterForm');
            if (form) {
                const targetEl = form.querySelector(`[name="parameters[${paramId}]"]`);
                if (targetEl) {
                    targetEl.value = val || '';
                    if (targetEl._refreshCustomSelect) targetEl._refreshCustomSelect();
                }
            }
            updateFilterButtonsState();
        }

        function onMobileTrackDynamicCommit(paramId, val, inputEl) {
            onMobileTrackDynamicInput(paramId, val, inputEl);
            applyFiltersAjax();

            if (inputEl) {
                const wrap = inputEl.closest('.filter-input-wrapper, .mobile-track-select-wrap');
                const nextEl = wrap ? wrap.nextElementSibling : null;
                if (nextEl) {
                    centerMobileFilter(nextEl);
                } else {
                    const resetBtn = document.getElementById('mobileTrackResetBtn');
                    if (resetBtn && !resetBtn.classList.contains('d-none')) {
                        centerMobileFilter(resetBtn);
                    }
                }
            }
        }

        function onMobileTrackDynamicChange(paramId, val, selectEl) {
            onMobileTrackDynamicCommit(paramId, val, selectEl);
        }

        // Form alanlarının durumunu yatay mobil çubukla senkronize eder
        function syncMobileTrackFromForm() {
            const form = document.getElementById('servicesFilterForm');
            if (!form) return;

            // 1. Kategori
            const catSelect = document.getElementById('categorySelect');
            const trackCat = document.getElementById('mobileTrackCategorySelect');
            if (trackCat && catSelect) {
                trackCat.value = catSelect.value || '';
                if (trackCat._refreshCustomSelect) trackCat._refreshCustomSelect();
            }

            // 2. Alt Kategori
            const subCatSelect = document.getElementById('sub-category-select');
            const trackSubCat = document.getElementById('mobileTrackSubCatSelect');
            const trackSubCatWrap = document.getElementById('mobileTrackSubCatWrapper');
            if (trackSubCat && subCatSelect) {
                const selVals = Array.from(subCatSelect.options).filter(o => o.selected).map(o => String(o.value));
                Array.from(trackSubCat.options).forEach(opt => {
                    opt.selected = selVals.includes(String(opt.value));
                });
                if (trackSubCat._refreshCustomSelect) trackSubCat._refreshCustomSelect();
                if (trackSubCatWrap) {
                    const shouldShow = !!(catSelect && catSelect.value);
                    if (shouldShow) {
                        trackSubCatWrap.classList.remove('d-none');
                        trackSubCatWrap.style.display = 'inline-flex';
                    } else {
                        trackSubCatWrap.classList.add('d-none');
                        trackSubCatWrap.style.display = 'none';
                    }
                }
            }

            // 3. İl
            const provSelect = document.getElementById('provinceSelect');
            const trackProv = document.getElementById('mobileTrackProvinceSelect');
            if (trackProv && provSelect) {
                trackProv.value = provSelect.value || '';
                if (trackProv._refreshCustomSelect) trackProv._refreshCustomSelect();
            }

            // 4. İlçe
            const distSelect = document.getElementById('district-select');
            const trackDist = document.getElementById('mobileTrackDistrictSelect');
            const trackDistWrap = document.getElementById('mobileTrackDistrictWrapper');
            if (trackDist && distSelect) {
                const selDistVals = Array.from(distSelect.options).filter(o => o.selected).map(o => String(o.value));
                Array.from(trackDist.options).forEach(opt => {
                    opt.selected = selDistVals.includes(String(opt.value));
                });
                if (trackDist._refreshCustomSelect) trackDist._refreshCustomSelect();
                if (trackDistWrap) {
                    const shouldShow = !!(provSelect && provSelect.value);
                    if (shouldShow) {
                        trackDistWrap.classList.remove('d-none');
                        trackDistWrap.style.display = 'inline-flex';
                    } else {
                        trackDistWrap.classList.add('d-none');
                        trackDistWrap.style.display = 'none';
                    }
                }
            }

            // 5. Fiyat (Aktif odaklanılan inputun değerini bozma)
            const filterMin = document.getElementById('filterMinPrice');
            const filterMax = document.getElementById('filterMaxPrice');
            const trackMinP = document.getElementById('mobileTrackMinPrice');
            const trackMaxP = document.getElementById('mobileTrackMaxPrice');
            if (trackMinP && filterMin && document.activeElement !== trackMinP) trackMinP.value = filterMin.value || '';
            if (trackMaxP && filterMax && document.activeElement !== trackMaxP) trackMaxP.value = filterMax.value || '';

            // 6. Metrekare (Aktif odaklanılan inputun değerini bozma)
            const formMinSqm = document.getElementById('filterMinSqm') || form.querySelector('input[name="min_sqm"]');
            const formMaxSqm = document.getElementById('filterMaxSqm') || form.querySelector('input[name="max_sqm"]');
            const trackMinSqm = document.getElementById('mobileTrackMinSqm');
            const trackMaxSqm = document.getElementById('mobileTrackMaxSqm');
            if (trackMinSqm && formMinSqm && document.activeElement !== trackMinSqm) trackMinSqm.value = formMinSqm.value || '';
            if (trackMaxSqm && formMaxSqm && document.activeElement !== trackMaxSqm) trackMaxSqm.value = formMaxSqm.value || '';

            // Senkronizasyon sonrası committed durumlarını ve input genişliklerini güncelle
            [filterMin, filterMax, trackMinP, trackMaxP, formMinSqm, formMaxSqm, trackMinSqm, trackMaxSqm].forEach(el => {
                if (el) el._lastCommittedValue = (el.value || '').trim();
            });
            syncAllMobileTrackInputs();

            // 7. Reset butonu görünürlüğü
            const resetBtn = document.getElementById('mobileTrackResetBtn');
            if (resetBtn) {
                const hasFilters = checkFilterHasSelection();
                if (hasFilters) {
                    resetBtn.classList.remove('d-none');
                    resetBtn.classList.add('d-inline-flex');
                } else {
                    resetBtn.classList.add('d-none');
                    resetBtn.classList.remove('d-inline-flex');
                }
            }
        }

        function syncMobileHbarFromForm() {
            syncMobileTrackFromForm();
        }

        window.__currentSelectedSubCats = @json(array_map('strval', $subCategoryIds));
        window.__currentSelectedDistricts = @json(array_map('strval', $districtIds));

        function onCategoryChange() {
            window.__currentSelectedSubCats = [];
            const subCatSelect = document.getElementById('sub-category-select');
            if (subCatSelect) {
                subCatSelect.innerHTML = '<option value="">Tüm Alt Kategoriler</option>';
                if (subCatSelect._refreshCustomSelect) subCatSelect._refreshCustomSelect();
            }
            const dynamicContainer = document.getElementById('dynamicParametersContainer');
            if (dynamicContainer) dynamicContainer.innerHTML = '';

            servicesGetSubCategories();
            servicesLoadCategoryParameters();
            updateFilterButtonsState();
        }

        function onProvinceChange() {
            window.__currentSelectedDistricts = [];
            const districtSelect = document.getElementById('district-select');
            if (districtSelect) {
                districtSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
                if (districtSelect._refreshCustomSelect) districtSelect._refreshCustomSelect();
            }
            servicesGetDistricts();
            updateFilterButtonsState();
        }

        // Filtreleme alanında herhangi bir seçim yapılıp yapılmadığını kontrol et
        function checkFilterHasSelection() {
            const form = document.getElementById('servicesFilterForm');
            if (!form) return false;

            // 1. Text, number, search gibi inputlar (order_by gizli inputu ve selectbox içi hızlı arama hariç)
            const inputs = form.querySelectorAll('input:not([type="hidden"]):not(.csp-search-input)');
            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].value && inputs[i].value.trim() !== '') {
                    return true;
                }
            }

            // 2. Selectbox'lar
            const selects = form.querySelectorAll('select.filter-select');
            for (let s = 0; s < selects.length; s++) {
                const sel = selects[s];
                if (sel.multiple) {
                    const hasSelected = Array.from(sel.options).some(opt => opt.selected && opt.value !== '');
                    if (hasSelected) return true;
                } else {
                    if (sel.value && sel.value !== '') {
                        return true;
                    }
                }
            }

            return false;
        }

        // Filtrele / Temizle Butonlarının Görünümünü ve Boyutunu Güncelle
        function updateFilterButtonsState() {
            const hasSelection = checkFilterHasSelection();
            const clearBtnDesktop = document.getElementById('desktopFilterClearBtn');
            const clearBtnMobile = document.getElementById('mobileFilterClearBtn');
            const clearBtnHeader = document.getElementById('sidebarHeaderClearBtn');

            if (clearBtnDesktop) {
                if (hasSelection) {
                    clearBtnDesktop.classList.remove('d-none');
                    clearBtnDesktop.classList.add('d-flex');
                } else {
                    clearBtnDesktop.classList.add('d-none');
                    clearBtnDesktop.classList.remove('d-flex');
                }
            }

            if (clearBtnMobile) {
                if (hasSelection) {
                    clearBtnMobile.classList.remove('d-none');
                    clearBtnMobile.classList.add('d-flex');
                } else {
                    clearBtnMobile.classList.add('d-none');
                    clearBtnMobile.classList.remove('d-flex');
                }
            }

            if (clearBtnHeader) {
                if (hasSelection) {
                    clearBtnHeader.classList.remove('d-none');
                    clearBtnHeader.classList.add('d-inline-flex');
                } else {
                    clearBtnHeader.classList.add('d-none');
                    clearBtnHeader.classList.remove('d-inline-flex');
                }
            }
        }

        // ==========================================================================
        // ANLIK DİNAMİK AJAX FİLTRELEME MOTORU (Instant Partial Refresh Architecture)
        // ==========================================================================

        let currentFilterAbortController = null;
        let filterDebounceTimer = null;

        // Form alanlarından temiz sorgu URL'i üretir
        function buildFilterUrl() {
            const form = document.getElementById('servicesFilterForm');
            if (!form) return window.location.pathname;

            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (const [key, value] of formData.entries()) {
                const strVal = (typeof value === 'string') ? value.trim() : '';
                if (!strVal) continue;

                // Fiyat alanlarındaki binlik ayracı noktaları temizle
                if (key === 'min_price' || key === 'max_price') {
                    const cleanVal = strVal.replace(/\D/g, '');
                    if (cleanVal) params.append(key, cleanVal);
                    continue;
                }

                params.append(key, strVal);
            }

            const action = form.getAttribute('action') || window.location.pathname;
            const qs = params.toString();
            return qs ? `${action}?${qs}` : action;
        }

        // Debounce motoru: Kullanıcı yazarken istek trafiğini optimize eder
        function debouncedApplyFilters() {
            clearTimeout(filterDebounceTimer);
            filterDebounceTimer = setTimeout(() => {
                applyFiltersAjax();
            }, 400);
        }

        // Mobilde İçerik Alanı İçin Modern Shimmer Skeleton Yükleme Şablonu
        function renderMobileSkeletonLoading() {
            const cardsRow = document.getElementById('servicesCardsRow');
            if (!cardsRow) return;

            let skeletonHtml = '';
            for (let i = 0; i < 4; i++) {
                skeletonHtml += `
                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 d-flex service-card-col service-skeleton-col">
                        <div class="modern-service-card modern-service-skeleton">
                            <div class="msc-image-area skeleton-shimmer skeleton-image-box">
                                <span class="skeleton-shimmer skeleton-pill-badge"></span>
                            </div>
                            <div class="msc-body">
                                <div class="skeleton-shimmer skeleton-line skeleton-title-long"></div>
                                <div class="skeleton-shimmer skeleton-line skeleton-title-short"></div>
                                <div class="msc-firm-location-row skeleton-firm-bar">
                                    <div class="skeleton-shimmer skeleton-avatar-circle"></div>
                                    <div class="skeleton-shimmer skeleton-line skeleton-company-text"></div>
                                    <div class="skeleton-shimmer skeleton-line skeleton-location-text"></div>
                                </div>
                                <div class="msc-footer skeleton-footer-bar">
                                    <div class="skeleton-price-wrapper">
                                        <div class="skeleton-shimmer skeleton-line skeleton-price-sub"></div>
                                        <div class="skeleton-shimmer skeleton-line skeleton-price-main"></div>
                                    </div>
                                    <div class="skeleton-shimmer skeleton-action-btn"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            cardsRow.innerHTML = skeletonHtml;
        }

        // Sadece içerik alanını anlık olarak yenileyen ana AJAX motoru
        function applyFiltersAjax(targetUrl = null, updateHistory = true) {
            if (currentFilterAbortController) {
                currentFilterAbortController.abort();
            }
            currentFilterAbortController = new AbortController();

            const url = targetUrl || buildFilterUrl();
            const dynamicArea = document.getElementById('servicesDynamicArea');

            // Kullanıcının mobil yatay kaydırma konumunu ve aktif odak alanını koru
            const scrollTrack = document.querySelector('.services-mobile-scroll-track');
            const scrollLeft = scrollTrack ? scrollTrack.scrollLeft : 0;
            const activeElId = document.activeElement ? document.activeElement.id : null;
            const activeSelStart = (document.activeElement && 'selectionStart' in document.activeElement) ? document.activeElement.selectionStart : null;
            const activeSelEnd = (document.activeElement && 'selectionEnd' in document.activeElement) ? document.activeElement.selectionEnd : null;

            if (dynamicArea) {
                dynamicArea.classList.add('is-loading');
            }

            // Sadece mobilde filtreleme yenilenirken içerik alanında modern skeleton göster
            if (window.innerWidth < 992) {
                renderMobileSkeletonLoading();
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: currentFilterAbortController.signal
            })
            .then(response => {
                if (!response.ok) throw new Error('Ağ yanıtı başarısız');
                return response.text();
            })
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // 1. Dinamik İçerik Alanını Akıllıca Güncelle (Mobil Yatay Filtre Çubuğunun DOM'unu yok etmeden korur)
                const newDynamicArea = doc.getElementById('servicesDynamicArea');
                if (newDynamicArea && dynamicArea) {
                    const curItems = dynamicArea.querySelector('.services-items-wrapper');
                    const newItems = newDynamicArea.querySelector('.services-items-wrapper');

                    if (curItems && newItems) {
                        // Breadcrumb güncelle
                        const curBreadcrumb = dynamicArea.querySelector('.services-breadcrumb');
                        const newBreadcrumb = newDynamicArea.querySelector('.services-breadcrumb');
                        if (curBreadcrumb && newBreadcrumb) curBreadcrumb.innerHTML = newBreadcrumb.innerHTML;

                        // Toolbar filtre rozeti güncelle
                        const curToolbarBadge = dynamicArea.querySelector('.services-toolbar-filter-btn .badge');
                        const newToolbarBadge = newDynamicArea.querySelector('.services-toolbar-filter-btn .badge');
                        const toolbarFilterBtn = dynamicArea.querySelector('.services-toolbar-filter-btn');
                        if (toolbarFilterBtn) {
                            if (newToolbarBadge) {
                                if (curToolbarBadge) curToolbarBadge.textContent = newToolbarBadge.textContent;
                                else toolbarFilterBtn.appendChild(newToolbarBadge.cloneNode(true));
                            } else if (curToolbarBadge) {
                                curToolbarBadge.remove();
                            }
                        }

                        // Sıralama aktif noktası
                        const curSortDot = dynamicArea.querySelector('#mobileSortIconBtn .services-sort-active-dot');
                        const newSortDot = newDynamicArea.querySelector('#mobileSortIconBtn .services-sort-active-dot');
                        const sortBtn = document.getElementById('mobileSortIconBtn');
                        if (sortBtn) {
                            if (newSortDot && !curSortDot) sortBtn.appendChild(newSortDot.cloneNode(true));
                            else if (!newSortDot && curSortDot) curSortDot.remove();
                        }

                        // Masaüstü ve mobil toplam sayı
                        const curTotalCount = dynamicArea.querySelector('.services-total-count, .services-count-text');
                        const newTotalCount = newDynamicArea.querySelector('.services-total-count, .services-count-text');
                        if (curTotalCount && newTotalCount) curTotalCount.innerHTML = newTotalCount.innerHTML;

                        const curDesktopSort = dynamicArea.querySelector('.st-right .sort-selector-wrapper');
                        const newDesktopSort = newDynamicArea.querySelector('.st-right .sort-selector-wrapper');
                        if (curDesktopSort && newDesktopSort) {
                            curDesktopSort.innerHTML = newDesktopSort.innerHTML;
                            initAllCustomSelects(curDesktopSort);
                        }

                        // Aktif Filtre Çipleri (Aynı Kart İçinde Güncelleme)
                        const curToolbar = dynamicArea.querySelector('.services-toolbar');
                        const curChips = dynamicArea.querySelector('.services-active-chips-bar, .services-active-filters');
                        const newChips = newDynamicArea.querySelector('.services-active-chips-bar, .services-active-filters');
                        if (curChips && newChips) {
                            curChips.replaceWith(newChips.cloneNode(true));
                            if (window.updateChipsNavButtons) updateChipsNavButtons();
                        } else if (newChips && curToolbar) {
                            curToolbar.appendChild(newChips.cloneNode(true));
                            if (window.updateChipsNavButtons) updateChipsNavButtons();
                        } else if (newChips && curItems) {
                            curItems.insertAdjacentElement('beforebegin', newChips.cloneNode(true));
                            if (window.updateChipsNavButtons) updateChipsNavButtons();
                        } else if (curChips && !newChips) {
                            curChips.remove();
                        }

                        // Hizmet Kartları Izgarası ve Sayfalama
                        curItems.innerHTML = newItems.innerHTML;
                    } else {
                        // Eğer yapı bulunamazsa güvenli fallback olarak tüm alanı yenile
                        dynamicArea.innerHTML = newDynamicArea.innerHTML;
                        initAllCustomSelects(dynamicArea);
                    }
                }

                // 2. Mobil Yüzen Bar Filtre Rozet Sayısını Güncelle
                const newMobileBadge = doc.querySelector('.services-mobile-floating-bar .smfb-btn .badge');
                const curMobileBtn = document.querySelector('.services-mobile-floating-bar .smfb-btn');
                if (curMobileBtn) {
                    const curMobileBadge = curMobileBtn.querySelector('.badge');
                    if (newMobileBadge) {
                        if (curMobileBadge) {
                            curMobileBadge.textContent = newMobileBadge.textContent;
                        } else {
                            curMobileBtn.appendChild(newMobileBadge.cloneNode(true));
                        }
                    } else if (curMobileBadge) {
                        curMobileBadge.remove();
                    }
                }

                // 3. Masaüstü Filtre Başlığı Rozet Sayısını Güncelle
                const newSidebarBadge = doc.querySelector('.services-filter-card .sfc-title .badge');
                const curSidebarTitle = document.querySelector('.services-filter-card .sfc-title');
                if (curSidebarTitle) {
                    const curSidebarBadge = curSidebarTitle.querySelector('.badge');
                    if (newSidebarBadge) {
                        if (curSidebarBadge) {
                            curSidebarBadge.textContent = newSidebarBadge.textContent;
                        } else {
                            curSidebarTitle.appendChild(newSidebarBadge.cloneNode(true));
                        }
                    } else if (curSidebarBadge) {
                        curSidebarBadge.remove();
                    }
                }

                // 4. Görünüm Modunu (Grid / List) Koru
                const savedView = localStorage.getItem('evhayaliniz_services_view') || 'grid';
                setViewMode(savedView);

                // 5. Filtrele / Temizle Buton Durumunu Güncelle
                updateFilterButtonsState();
                syncMobileTrackFromForm();

                // 6. Tarayıcı Adres Çubuğunu ve Geçmişini Güncelle
                if (updateHistory) {
                    window.history.pushState({ url: url }, '', url);
                }
            })
            .catch(err => {
                if (err.name === 'AbortError') {
                    // Kullanıcı hızlı seçim yaptığında önceki isteğin iptal edilmesi normaldir
                    return;
                }
                console.error('Filtreleme hatası:', err);
            })
            .finally(() => {
                if (dynamicArea) {
                    dynamicArea.classList.remove('is-loading');
                }
            });
        }

        // Tüm filtreleri sıfırlar ve sayfayı anlık AJAX ile varsayılan listelemeye döndürür
        function resetAllFilters(e) {
            if (e && e.preventDefault) e.preventDefault();
            clearTimeout(filterDebounceTimer);

            const form = document.getElementById('servicesFilterForm');
            if (form) {
                // 1. Text & Number inputları temizle
                form.querySelectorAll('input:not([type="hidden"]):not(.csp-search-input)').forEach(i => i.value = '');

                // Arama temizleme butonunu gizle
                const searchClearBtn = document.getElementById('searchClearBtn');
                if (searchClearBtn) searchClearBtn.classList.add('d-none');

                // 2. Selectbox'ları sıfırla
                form.querySelectorAll('select.filter-select').forEach(sel => {
                    if (sel.multiple) {
                        Array.from(sel.options).forEach(opt => opt.selected = false);
                    } else {
                        sel.selectedIndex = 0;
                        sel.value = '';
                    }
                    if (sel._refreshCustomSelect) sel._refreshCustomSelect();
                });

                // 3. Bağımlı alanları gizle
                const subCatGroup = document.getElementById('subCategoryGroup');
                if (subCatGroup) subCatGroup.style.display = 'none';

                const districtGroup = document.getElementById('districtGroup');
                if (districtGroup) districtGroup.style.display = 'none';

                const dynamicContainer = document.getElementById('dynamicParametersContainer');
                if (dynamicContainer) dynamicContainer.innerHTML = '';
            }

            // Sıralama inputunu ve özel selectbox'ını sıfırla
            const orderInput = document.getElementById('filterOrderByInput');
            if (orderInput) orderInput.value = '';

            const sortSelect = document.getElementById('serviceSortSelect');
            if (sortSelect) {
                sortSelect.value = '';
                if (sortSelect._refreshCustomSelect) sortSelect._refreshCustomSelect();
            }

            // Mobil yatay filtre çubuğunu sıfırla
            const trackCat = document.getElementById('mobileTrackCategorySelect');
            if (trackCat) {
                trackCat.selectedIndex = 0;
                trackCat.value = '';
                if (trackCat._refreshCustomSelect) trackCat._refreshCustomSelect();
            }

            const trackSubCat = document.getElementById('mobileTrackSubCatSelect');
            const trackSubCatWrap = document.getElementById('mobileTrackSubCatWrapper');
            if (trackSubCat) {
                trackSubCat.innerHTML = '<option value="">Tüm Alt Kategoriler</option>';
                if (trackSubCat._refreshCustomSelect) trackSubCat._refreshCustomSelect();
            }
            if (trackSubCatWrap) {
                trackSubCatWrap.style.display = 'none';
                trackSubCatWrap.classList.add('d-none');
            }

            const trackProv = document.getElementById('mobileTrackProvinceSelect');
            if (trackProv) {
                trackProv.selectedIndex = 0;
                trackProv.value = '';
                if (trackProv._refreshCustomSelect) trackProv._refreshCustomSelect();
            }

            const trackDist = document.getElementById('mobileTrackDistrictSelect');
            const trackDistWrap = document.getElementById('mobileTrackDistrictWrapper');
            if (trackDist) {
                trackDist.innerHTML = '<option value="">Tüm İlçeler</option>';
                if (trackDist._refreshCustomSelect) trackDist._refreshCustomSelect();
            }
            if (trackDistWrap) {
                trackDistWrap.style.display = 'none';
                trackDistWrap.classList.add('d-none');
            }

            const trackMinP = document.getElementById('mobileTrackMinPrice');
            if (trackMinP) trackMinP.value = '';
            const trackMaxP = document.getElementById('mobileTrackMaxPrice');
            if (trackMaxP) trackMaxP.value = '';

            const trackMinS = document.getElementById('mobileTrackMinSqm');
            if (trackMinS) trackMinS.value = '';
            const trackMaxS = document.getElementById('mobileTrackMaxSqm');
            if (trackMaxS) trackMaxS.value = '';

            const trackDynamic = document.getElementById('mobileTrackDynamicContainer');
            if (trackDynamic) trackDynamic.innerHTML = '';

            [
                document.getElementById('filterMinPrice'),
                document.getElementById('filterMaxPrice'),
                document.getElementById('filterMinSqm'),
                document.getElementById('filterMaxSqm'),
                trackMinP,
                trackMaxP,
                trackMinS,
                trackMaxS
            ].forEach(el => {
                if (el) el._lastCommittedValue = '';
            });
            syncAllMobileTrackInputs();

            const trackResetBtn = document.getElementById('mobileTrackResetBtn');
            if (trackResetBtn) {
                trackResetBtn.classList.add('d-none');
                trackResetBtn.classList.remove('d-inline-flex');
            }

            const scrollTrack = document.querySelector('.services-mobile-scroll-track');
            if (scrollTrack) scrollTrack.scrollTo({ left: 0, behavior: 'smooth' });

            const baseUrl = '{{ route("services.index") }}';
            applyFiltersAjax(baseUrl);

            // Mobil filtre çekmecesi açıksa kapat
            const drawerEl = document.getElementById('servicesFilterDrawer');
            if (drawerEl && typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
                const offcanvasInstance = bootstrap.Offcanvas.getInstance(drawerEl);
                if (offcanvasInstance) offcanvasInstance.hide();
            }
        }

        // Harici tıklamalarda (çip kaldırma, kategori pilleri vb.) sol menü formunu URL parametreleriyle senkronize eder
        function syncFormFromUrl(targetUrl) {
            try {
                const urlObj = new URL(targetUrl, window.location.origin);
                const params = urlObj.searchParams;
                const form = document.getElementById('servicesFilterForm');
                if (!form) return;

                // 1. Text & Sayısal Alanlar
                const qInput = document.getElementById('filterSearchInput');
                if (qInput) {
                    const qVal = params.get('q') || '';
                    qInput.value = qVal;
                    const searchClearBtn = document.getElementById('searchClearBtn');
                    if (searchClearBtn) {
                        if (qVal) searchClearBtn.classList.remove('d-none');
                        else searchClearBtn.classList.add('d-none');
                    }
                }

                const minPriceInput = document.getElementById('filterMinPrice');
                if (minPriceInput) {
                    const rawMin = params.get('min_price');
                    minPriceInput.value = rawMin ? parseInt(rawMin.replace(/\D/g, ''), 10).toLocaleString('tr-TR') : '';
                }

                const maxPriceInput = document.getElementById('filterMaxPrice');
                if (maxPriceInput) {
                    const rawMax = params.get('max_price');
                    maxPriceInput.value = rawMax ? parseInt(rawMax.replace(/\D/g, ''), 10).toLocaleString('tr-TR') : '';
                }

                const minSqmInput = form.querySelector('input[name="min_sqm"]');
                if (minSqmInput) minSqmInput.value = params.get('min_sqm') || '';

                const maxSqmInput = form.querySelector('input[name="max_sqm"]');
                if (maxSqmInput) maxSqmInput.value = params.get('max_sqm') || '';

                // 2. Kategori & Alt Kategori
                const newCatVal = params.get('category') || '';
                const catSelect = document.getElementById('categorySelect');
                const subCatVals = params.getAll('sub_category[]').concat(params.getAll('sub_category')).filter(Boolean);

                if (catSelect) {
                    const catChanged = catSelect.value !== newCatVal;
                    catSelect.value = newCatVal;
                    if (catSelect._refreshCustomSelect) catSelect._refreshCustomSelect();

                    if (catChanged) {
                        window.__currentSelectedSubCats = subCatVals;
                        servicesGetSubCategories();
                        servicesLoadCategoryParameters();
                    } else {
                        const subCatSelect = document.getElementById('sub-category-select');
                        if (subCatSelect) {
                            Array.from(subCatSelect.options).forEach(opt => {
                                opt.selected = subCatVals.includes(String(opt.value));
                            });
                            if (subCatSelect._refreshCustomSelect) subCatSelect._refreshCustomSelect();
                        }
                    }
                }

                // 3. İl & İlçe
                const newProvVal = params.get('province') || '';
                const provSelect = document.getElementById('provinceSelect');
                const distVals = params.getAll('district[]').concat(params.getAll('district')).filter(Boolean);

                if (provSelect) {
                    const provChanged = provSelect.value !== newProvVal;
                    provSelect.value = newProvVal;
                    if (provSelect._refreshCustomSelect) provSelect._refreshCustomSelect();

                    if (provChanged) {
                        window.__currentSelectedDistricts = distVals;
                        servicesGetDistricts();
                    } else {
                        const distSelect = document.getElementById('district-select');
                        if (distSelect) {
                            Array.from(distSelect.options).forEach(opt => {
                                opt.selected = distVals.includes(String(opt.value));
                            });
                            if (distSelect._refreshCustomSelect) distSelect._refreshCustomSelect();
                        }
                    }
                }

                // 4. Sıralama
                const orderVal = params.get('order_by') || '';
                const orderInput = document.getElementById('filterOrderByInput');
                if (orderInput) orderInput.value = orderVal;

                const sortSelect = document.getElementById('serviceSortSelect');
                if (sortSelect) {
                    sortSelect.value = orderVal;
                    if (sortSelect._refreshCustomSelect) sortSelect._refreshCustomSelect();
                }

                // 5. Dinamik Parametreler
                const paramRegex = /^parameters\[(\d+)\]$/;
                params.forEach((val, key) => {
                    const match = key.match(paramRegex);
                    if (match) {
                        const paramInput = form.querySelector(`[name="parameters[${match[1]}]"]`);
                        if (paramInput) {
                            paramInput.value = val;
                            if (paramInput._refreshCustomSelect) paramInput._refreshCustomSelect();
                        }
                    }
                });

                updateFilterButtonsState();
                syncMobileTrackFromForm();
            } catch (e) {
                console.error('URL senkronizasyon hatası:', e);
            }
        }

        // ==========================================================================
        // Özel Selectbox & Açılır Popup Menü Motoru (Searchable Custom Select Engine)
        // ==========================================================================

        // Mobilde Açık Kalan Popup'lar İçin Karartma (Backdrop) Yönetimi
        function getOrCreateMobileBackdrop() {
            let backdrop = document.getElementById('servicesMobileBackdrop');
            if (!backdrop) {
                backdrop = document.createElement('div');
                backdrop.id = 'servicesMobileBackdrop';
                backdrop.className = 'services-mobile-backdrop';
                document.body.appendChild(backdrop);
                backdrop.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closeAllCustomSelects();
                });
            }
            return backdrop;
        }

        function showMobileBackdrop() {
            if (window.innerWidth >= 992) return;
            const backdrop = getOrCreateMobileBackdrop();
            backdrop.classList.add('show');
        }

        function hideMobileBackdrop() {
            const backdrop = document.getElementById('servicesMobileBackdrop');
            if (backdrop) {
                backdrop.classList.remove('show');
            }
        }

        function closeAllCustomSelects() {
            const openWrappers = Array.from(document.querySelectorAll('.custom-select-wrapper.open'));
            openWrappers.forEach(w => {
                w.classList.remove('open');
                const innerSelect = w.querySelector('select') || w.previousElementSibling;
                if (innerSelect) {
                    if (innerSelect.id === 'mobileTrackSubCatSelect') {
                        const provWrap = document.getElementById('mobileTrackProvinceSelect')?.closest('.mobile-track-select-wrap');
                        if (provWrap) centerMobileFilter(provWrap);
                    } else if (innerSelect.id === 'mobileTrackDistrictSelect') {
                        const priceGroup = document.querySelector('.mobile-track-range-group');
                        if (priceGroup) centerMobileFilter(priceGroup);
                    }
                }
            });
            document.getElementById('servicesToolbar')?.classList.remove('has-open-select');
            document.getElementById('mobileSortIconBtn')?.classList.remove('active');
            if (window.innerWidth >= 992) {
                const sortPopup = document.querySelector('.sort-selector-wrapper .custom-select-popup');
                if (sortPopup) {
                    sortPopup.style.top = '';
                    sortPopup.style.left = '';
                    sortPopup.style.right = '';
                    sortPopup.style.width = '';
                }
            }
            hideMobileBackdrop();
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select-wrapper') && !e.target.closest('#mobileSortIconBtn') && !e.target.closest('.smfb-sort-btn')) {
                closeAllCustomSelects();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAllCustomSelects();
            }
        });

        function initCustomSelect(select) {
            if (!select || select.dataset.customized === 'true') return;
            select.dataset.customized = 'true';
            select.classList.add('has-custom-select');

            const isMultiple = select.multiple;
            const wrapper = document.createElement('div');
            wrapper.className = 'custom-select-wrapper' + (isMultiple ? ' is-multiple' : '');

            const iconClass = select.getAttribute('data-icon') || 'fa-solid fa-angle-right';
            const placeholderText = select.getAttribute('data-placeholder') || 'Seçiniz...';

            // 1. Tetikleyici Buton (Trigger)
            const trigger = document.createElement('div');
            trigger.className = 'custom-select-trigger';
            trigger.setAttribute('tabindex', '0');
            trigger.setAttribute('role', 'button');

            const left = document.createElement('div');
            left.className = 'cst-left';

            const text = document.createElement('span');
            text.className = 'cst-text';

            left.appendChild(text);

            // Sağ Taraf: Temizleme (X) Butonu ve Ok Yönü
            const clearBtn = document.createElement('span');
            clearBtn.className = 'cst-clear-btn';
            clearBtn.setAttribute('title', 'Seçimi Temizle');
            clearBtn.setAttribute('role', 'button');
            clearBtn.setAttribute('tabindex', '0');
            clearBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            clearBtn.style.display = 'none';

            // X Butonuna Tıklanınca Seçimi Temizle
            clearBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Açılır menünün açılmasını engeller
                e.preventDefault();

                if (isMultiple) {
                    Array.from(select.options).forEach(opt => {
                        opt.selected = false;
                    });
                } else {
                    select.selectedIndex = 0;
                    select.value = '';
                }

                closeAllCustomSelects();
                updateTriggerDisplay();

                // Değişikliği form ve diğer bağlı elementlere bildir (bubbles: true form listener'ı tetikler)
                select.dispatchEvent(new Event('change', { bubbles: true }));
            });

            clearBtn.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    e.stopPropagation();
                    clearBtn.click();
                }
            });

            const arrow = document.createElement('i');
            arrow.className = 'fa-solid fa-chevron-down cst-arrow';

            trigger.appendChild(left);
            trigger.appendChild(clearBtn);
            trigger.appendChild(arrow);

            // 2. Açılır Popup (Dropdown Menu)
            const popup = document.createElement('div');
            popup.className = 'custom-select-popup' + (isMultiple ? ' csp-multi-popup' : '');

            // 3. Mini Arama Alanı (Seçenek sayısı > 6 ise)
            let searchInput = null;
            const searchBox = document.createElement('div');
            searchBox.className = 'csp-search custom-select-search';
            searchBox.innerHTML = `
                <i class="fa-solid fa-magnifying-glass csp-search-icon"></i>
                <input type="text" class="csp-search-input" placeholder="Hızlı ara...">
            `;
            popup.appendChild(searchBox);
            searchInput = searchBox.querySelector('.csp-search-input');

            const optionsList = document.createElement('div');
            optionsList.className = 'csp-options-list';

            const emptyEl = document.createElement('div');
            emptyEl.className = 'csp-empty';
            emptyEl.innerText = 'Sonuç bulunamadı';
            emptyEl.style.display = 'none';

            popup.appendChild(optionsList);
            popup.appendChild(emptyEl);

            // Arama filtresi dinleyicisi (Form filtre tetiklemesini engellemek için stopPropagation)
            searchInput.addEventListener('input', function(e) {
                e.stopPropagation();
                const query = e.target.value.toLocaleLowerCase('tr').trim();
                const optionEls = optionsList.querySelectorAll('.csp-option');
                let hasVisible = false;
                optionEls.forEach(opt => {
                    const optText = opt.innerText.toLocaleLowerCase('tr');
                    if (optText.includes(query)) {
                        opt.style.display = 'flex';
                        hasVisible = true;
                    } else {
                        opt.style.display = 'none';
                    }
                });
                emptyEl.style.display = hasVisible ? 'none' : 'block';
            });

            searchBox.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Seçenekleri Render Etme
            function renderOptions() {
                optionsList.innerHTML = '';
                if (searchInput) searchInput.value = '';

                // Seçenek sayısı 6'dan az ise arama kutusunu gizle
                if (select.options.length <= 6) {
                    searchBox.style.display = 'none';
                } else {
                    searchBox.style.display = 'block';
                }

                Array.from(select.options).forEach(opt => {
                    const cleanText = (opt.text || '').trim();
                    const isEmptyVal = opt.value === '';

                    // Çoklu seçimde arama kutusunun altındaki boş (Tümü) seçeneği kaldırıldı
                    if (isMultiple && isEmptyVal) {
                        return;
                    }

                    const optEl = document.createElement('div');
                    optEl.className = 'csp-option';
                    if (isMultiple) optEl.classList.add('csp-option-multi');
                    if (opt.selected && !isEmptyVal) optEl.classList.add('selected');
                    if (isEmptyVal && !isMultiple && opt.selected) optEl.classList.add('selected');
                    optEl.dataset.value = opt.value;

                    if (isMultiple) {
                        optEl.innerHTML = `
                            <div class="csp-checkbox"><i class="fa-solid fa-check"></i></div>
                            <span class="csp-opt-label">${cleanText}</span>
                        `;
                    } else {
                        optEl.innerHTML = `
                            <span>${cleanText}</span>
                            <i class="fa-solid fa-check check-icon"></i>
                        `;
                    }

                    optEl.addEventListener('click', function(e) {
                        e.stopPropagation();

                        if (isMultiple) {
                            opt.selected = !opt.selected;
                            optEl.classList.toggle('selected', opt.selected);
                            const defaultOpt = Array.from(select.options).find(o => o.value === '');
                            if (defaultOpt) defaultOpt.selected = false;

                            select.dispatchEvent(new Event('change', { bubbles: true }));
                            updateTriggerDisplay();
                        } else {
                            select.value = opt.value;
                            select.dispatchEvent(new Event('change', { bubbles: true }));
                            updateTriggerDisplay();
                            closeAllCustomSelects();
                        }
                    });

                    optionsList.appendChild(optEl);
                });

                updateTriggerDisplay();
            }

            function updateTriggerDisplay() {
                const cleanPlaceholder = (placeholderText || '').trim();

                if (isMultiple) {
                    const selectedOpts = Array.from(select.options).filter(o => o.selected && o.value !== '');
                    if (selectedOpts.length === 0) {
                        text.innerText = cleanPlaceholder || 'Tümü';
                        text.classList.remove('has-value');
                        trigger.removeAttribute('title');
                        wrapper.classList.remove('has-value');
                        clearBtn.style.display = 'none';
                    } else if (selectedOpts.length === 1) {
                        text.innerText = selectedOpts[0].text.trim();
                        text.classList.add('has-value');
                        trigger.setAttribute('title', selectedOpts[0].text.trim());
                        wrapper.classList.add('has-value');
                        clearBtn.style.display = 'inline-flex';
                    } else {
                        text.innerText = `${selectedOpts[0].text.trim()} (+${selectedOpts.length - 1})`;
                        text.classList.add('has-value');
                        trigger.setAttribute('title', selectedOpts.map(o => o.text.trim()).join(', '));
                        wrapper.classList.add('has-value');
                        clearBtn.style.display = 'inline-flex';
                    }

                    optionsList.querySelectorAll('.csp-option').forEach(el => {
                        const isSelected = selectedOpts.some(o => o.value === el.dataset.value);
                        el.classList.toggle('selected', isSelected);
                    });
                } else {
                    const currentOpt = select.options[select.selectedIndex];
                    const cleanCurrentText = currentOpt ? (currentOpt.text || '').trim() : '';

                    text.innerText = (cleanCurrentText && select.value !== '') ? cleanCurrentText : (cleanPlaceholder || 'Seçiniz...');
                    if (cleanCurrentText && select.value !== '') {
                        text.classList.add('has-value');
                        wrapper.classList.add('has-value');
                        clearBtn.style.display = 'inline-flex';
                    } else {
                        text.classList.remove('has-value');
                        wrapper.classList.remove('has-value');
                        clearBtn.style.display = 'none';
                    }

                    optionsList.querySelectorAll('.csp-option').forEach(el => {
                        if (el.dataset.value === select.value) {
                            el.classList.add('selected');
                        } else {
                            el.classList.remove('selected');
                        }
                    });
                }
            }

            renderOptions();

            // Tetikleyiciye Tıklama & Akıllı Konumlandırma (Flip)
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = wrapper.classList.contains('open');
                closeAllCustomSelects();
                if (!isOpen) {
                    const rect = wrapper.getBoundingClientRect();
                    const isInsideTrack = !!wrapper.closest('.services-mobile-scroll-track');
                    if (isInsideTrack) {
                        popup.style.position = 'fixed';
                        const spaceBelow = window.innerHeight - rect.bottom;
                        if (spaceBelow < 260 && rect.top > 260) {
                            popup.style.top = 'auto';
                            popup.style.bottom = (window.innerHeight - rect.top + 6) + 'px';
                        } else {
                            popup.style.top = (rect.bottom + 6) + 'px';
                            popup.style.bottom = 'auto';
                        }
                        const screenW = window.innerWidth;
                        const popupW = Math.min(280, screenW - 24);
                        let left = rect.left;
                        if (left + popupW > screenW - 12) left = screenW - popupW - 12;
                        if (left < 12) left = 12;
                        popup.style.left = left + 'px';
                        popup.style.right = 'auto';
                        popup.style.width = popupW + 'px';
                        popup.style.zIndex = '1060';
                    } else {
                        popup.style.position = '';
                        popup.style.left = '';
                        popup.style.right = '';
                        popup.style.width = '';
                        popup.style.zIndex = '';
                        const spaceBelow = window.innerHeight - rect.bottom;
                        if (spaceBelow < 250 && rect.top > 250) {
                            popup.style.top = 'auto';
                            popup.style.bottom = 'calc(100% + 5px)';
                        } else {
                            popup.style.top = 'calc(100% + 5px)';
                            popup.style.bottom = 'auto';
                        }
                    }

                    wrapper.classList.add('open');
                    if (isInsideTrack) {
                        document.getElementById('servicesToolbar')?.classList.add('has-open-select');
                        showMobileBackdrop();
                    }
                    if (searchInput && searchBox.style.display !== 'none') {
                        searchInput.value = '';
                        searchInput.dispatchEvent(new Event('input'));
                        setTimeout(() => searchInput.focus(), 50);
                    }
                }
            });

            // Klavye Enter/Space tuşları
            trigger.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    trigger.click();
                }
            });

            // Dışarıdan güncelleme metodu (AJAX yenilemesi için)
            select._refreshCustomSelect = function() {
                renderOptions();
            };

            // DOM'a yerleştir
            select.parentNode.insertBefore(wrapper, select);
            wrapper.appendChild(select);
            wrapper.appendChild(trigger);
            wrapper.appendChild(popup);
        }

        function initAllCustomSelects(container) {
            const root = container || document;
            root.querySelectorAll('select.filter-select').forEach(select => {
                initCustomSelect(select);
            });
        }

        // Sayfa yüklendiğinde mevcut kullanıcı tercihlerini ve dinamik dinleyicileri bağla
        document.addEventListener('DOMContentLoaded', function() {
            // Hizmetler sayfasında mobil ebeveyn container ve satırının kenar boşluklarını sıfırla
            document.body.classList.add('services-page-active');
            const mainFullwidth = document.querySelector('.services-main-fullwidth');
            if (mainFullwidth) {
                if (mainFullwidth.parentElement) {
                    mainFullwidth.parentElement.classList.add('services-parent-row');
                }
                const containerFluid = mainFullwidth.closest('.container-fluid');
                if (containerFluid) {
                    containerFluid.classList.add('services-container-fluid');
                }
            }

            // Kaydedilmiş Grid/List görünüm tercihini geri yükle
            const savedView = localStorage.getItem('evhayaliniz_services_view');
            if (savedView === 'list') {
                setViewMode('list');
            }

            // Sayfa açılışında kategori varsa alt kategori ve dinamik parametre görünümünü aç
            const categorySelect = document.getElementById('categorySelect');
            if (categorySelect && categorySelect.value) {
                const subCatGroup = document.getElementById('subCategoryGroup');
                if (subCatGroup) subCatGroup.style.display = 'block';
            }

            const provinceSelect = document.getElementById('provinceSelect');
            if (provinceSelect && provinceSelect.value) {
                const districtGroup = document.getElementById('districtGroup');
                if (districtGroup) districtGroup.style.display = 'block';
            }

            // Tüm özel selectbox'ları başlat
            initAllCustomSelects();

            // Arama kutusu giriş dinleyicisi (Temizle X butonunu göster/gizle)
            const searchInput = document.getElementById('filterSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const clearBtn = document.getElementById('searchClearBtn');
                    if (clearBtn) {
                        if (this.value && this.value.trim().length > 0) {
                            clearBtn.classList.remove('d-none');
                        } else {
                            clearBtn.classList.add('d-none');
                        }
                    }
                });
            }

            // Filtre Formu Dinleyicileri (Anlık AJAX Tetikleyicileri)
            const filterForm = document.getElementById('servicesFilterForm');
            if (filterForm) {
                // Form submit: Sayfa yenilemeyi engelle, AJAX ile filtrele ve mobilde drawer'ı kapat
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearTimeout(filterDebounceTimer);
                    applyFiltersAjax();

                    const drawerEl = document.getElementById('servicesFilterDrawer');
                    if (drawerEl && typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
                        const offcanvasInstance = bootstrap.Offcanvas.getInstance(drawerEl);
                        if (offcanvasInstance) offcanvasInstance.hide();
                    }
                });

                // Selectbox Değişikliği: Anında yenile
                filterForm.addEventListener('change', function(e) {
                    updateFilterButtonsState();
                    if (e.target && (e.target.tagName === 'SELECT' || e.target.type === 'checkbox' || e.target.type === 'radio')) {
                        applyFiltersAjax();
                    }
                });

                // Metin ve Sayısal Inputlar
                filterForm.addEventListener('input', function(e) {
                    if (e.target.closest('.custom-select-search')) {
                        return; // Selectbox içi hızlı arama kutusunu filtre tetikleyicisinden muaf tut
                    }
                    updateFilterButtonsState();
                    if (e.target && e.target.tagName === 'INPUT') {
                        const isPriceOrSqm = e.target.id === 'filterMinPrice' || 
                                             e.target.id === 'filterMaxPrice' || 
                                             e.target.name === 'min_price' || 
                                             e.target.name === 'max_price' || 
                                             e.target.id === 'filterMinSqm' ||
                                             e.target.id === 'filterMaxSqm' ||
                                             e.target.name === 'min_sqm' || 
                                             e.target.name === 'max_sqm' ||
                                             (e.target.name && e.target.name.startsWith('parameters['));
                        
                        const isMobile = window.innerWidth < 992;
                        if (isMobile && isPriceOrSqm) {
                            // Mobilde fiyat ve m2 girilirken filtrelemeyi tetikleme, sadece inputtan çıkıldığında uygula
                            return;
                        }
                        debouncedApplyFilters();
                    }
                });

                // Form içindeki inputlardan çıkıldığında (change / focusout) filtrelemeyi başlat
                filterForm.addEventListener('change', function(e) {
                    if (e.target && e.target.tagName === 'INPUT') {
                        const isPriceOrSqm = e.target.id === 'filterMinPrice' || 
                                             e.target.id === 'filterMaxPrice' || 
                                             e.target.name === 'min_price' || 
                                             e.target.name === 'max_price' || 
                                             e.target.id === 'filterMinSqm' ||
                                             e.target.id === 'filterMaxSqm' ||
                                             e.target.name === 'min_sqm' || 
                                             e.target.name === 'max_sqm' ||
                                             (e.target.name && e.target.name.startsWith('parameters['));
                        if (isPriceOrSqm) {
                            commitFilterInputChange(e.target);
                        }
                    }
                });

                filterForm.addEventListener('focusout', function(e) {
                    if (e.target && e.target.tagName === 'INPUT') {
                        const isPriceOrSqm = e.target.id === 'filterMinPrice' || 
                                             e.target.id === 'filterMaxPrice' || 
                                             e.target.name === 'min_price' || 
                                             e.target.name === 'max_price' || 
                                             e.target.id === 'filterMinSqm' ||
                                             e.target.id === 'filterMaxSqm' ||
                                             e.target.name === 'min_sqm' || 
                                             e.target.name === 'max_sqm' ||
                                             (e.target.name && e.target.name.startsWith('parameters['));
                        if (isPriceOrSqm) {
                            commitFilterInputChange(e.target);
                        }
                    }
                });

                // Enter tuşuna basıldığında klavyeyi kapat ve filtrelemeyi tetikle
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && e.target && e.target.tagName === 'INPUT') {
                        const isTarget = e.target.id === 'mobileTrackMinPrice' ||
                                         e.target.id === 'mobileTrackMaxPrice' ||
                                         e.target.id === 'mobileTrackMinSqm' ||
                                         e.target.id === 'mobileTrackMaxSqm' ||
                                         e.target.id === 'filterMinPrice' ||
                                         e.target.id === 'filterMaxPrice' ||
                                         e.target.id === 'filterMinSqm' ||
                                         e.target.id === 'filterMaxSqm' ||
                                         e.target.name === 'min_sqm' ||
                                         e.target.name === 'max_sqm' ||
                                         (e.target.name && e.target.name.startsWith('parameters['));
                        if (isTarget) {
                            e.preventDefault();
                            e.target.blur();
                        }
                    }
                });
            }

            // Temizleme Butonları (Desktop, Mobil ve Başlık Temizle)
            const clearBtnDesktop = document.getElementById('desktopFilterClearBtn');
            if (clearBtnDesktop) clearBtnDesktop.addEventListener('click', resetAllFilters);

            const clearBtnMobile = document.getElementById('mobileFilterClearBtn');
            if (clearBtnMobile) clearBtnMobile.addEventListener('click', resetAllFilters);

            const clearBtnHeader = document.getElementById('sidebarHeaderClearBtn');
            if (clearBtnHeader) clearBtnHeader.addEventListener('click', resetAllFilters);

            // Dinamik İçerik Alanındaki Tıklamaları Yakala (Sayfalama, Kategori Pilleri, Çipler)
            document.addEventListener('click', function(e) {
                // 1. Kategori Pilleri (.services-cat-pill)
                const pill = e.target.closest('.services-cat-pill');
                if (pill) {
                    e.preventDefault();
                    const url = pill.getAttribute('href');
                    if (url) {
                        applyFiltersAjax(url);
                        syncFormFromUrl(url);
                    }
                    return;
                }

                // 2. Aktif Filtre Çipleri (.chip-remove)
                const chipRemove = e.target.closest('.chip-remove');
                if (chipRemove) {
                    e.preventDefault();
                    const url = chipRemove.getAttribute('href');
                    if (url) {
                        applyFiltersAjax(url);
                        syncFormFromUrl(url);
                    }
                    return;
                }

                // 3. İçerik Alanı İçindeki Filtre Temizleme Butonları
                const clearAllLink = e.target.closest('.services-active-chips-bar a.text-danger, .btn-clear-active-filters, .btn-clear-active-filters-mobile, .btn-clear-active-filters-desktop, .services-hero-head a.btn-outline-danger, .services-empty-state a.btn-primary');
                if (clearAllLink) {
                    e.preventDefault();
                    resetAllFilters(e);
                    return;
                }

                // 4. Sayfalama Linkleri (Pagination)
                const paginationLink = e.target.closest('.services-pagination a, .sd-modern-pagination-wrapper a, .sd-page-btn[href]');
                if (paginationLink) {
                    e.preventDefault();
                    const url = paginationLink.getAttribute('href');
                    if (url && url !== '#') {
                        applyFiltersAjax(url);
                        const dynamicArea = document.getElementById('servicesDynamicArea');
                        if (dynamicArea) {
                            dynamicArea.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                    return;
                }
            });

            // 5. Seçili Çipler Alanında Masaüstü Yatay Kaydırma (Mouse Wheel & Drag-to-Scroll)
            let isChipsDragging = false;
            let chipsStartX = 0;
            let chipsScrollStart = 0;
            let chipsHasDragged = false;
            let activeChipsTrack = null;

            // Mouse Tekerleği ile Yatay Kaydırma (Tekerlek yukarı/aşağı çevrildiğinde yatay kaydırır)
            document.addEventListener('wheel', function(e) {
                const track = e.target.closest('.active-chips-scroll-track');
                if (!track) return;
                if (track.scrollWidth > track.clientWidth) {
                    if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                        e.preventDefault();
                        track.scrollLeft += e.deltaY * 0.9;
                    }
                }
            }, { passive: false });

            // Mouse ile Tutup Sürükleme (Drag-to-Scroll)
            document.addEventListener('mousedown', function(e) {
                const track = e.target.closest('.active-chips-scroll-track');
                if (!track) return;
                if (e.target.closest('.chip-remove')) return;
                if (track.scrollWidth <= track.clientWidth) return;

                isChipsDragging = true;
                chipsHasDragged = false;
                activeChipsTrack = track;
                chipsStartX = e.pageX - track.getBoundingClientRect().left;
                chipsScrollStart = track.scrollLeft;
                track.classList.add('is-dragging');
            });

            document.addEventListener('mousemove', function(e) {
                if (!isChipsDragging || !activeChipsTrack) return;
                const currentX = e.pageX - activeChipsTrack.getBoundingClientRect().left;
                const walk = (currentX - chipsStartX) * 1.3;
                if (Math.abs(walk) > 4) {
                    chipsHasDragged = true;
                }
                activeChipsTrack.scrollLeft = chipsScrollStart - walk;
            });

            document.addEventListener('mouseup', function() {
                if (!isChipsDragging) return;
                isChipsDragging = false;
                if (activeChipsTrack) {
                    activeChipsTrack.classList.remove('is-dragging');
                    activeChipsTrack = null;
                }
                setTimeout(() => { chipsHasDragged = false; }, 60);
            });

            // Sürükleme yapılmışsa çipe tıklanıp yanlışlıkla link açılmasını önle
            document.addEventListener('click', function(e) {
                if (chipsHasDragged && e.target.closest('.active-chips-scroll-track')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);

            window.scrollActiveChips = function(offset) {
                const track = document.querySelector('.active-chips-scroll-track');
                if (track) {
                    track.scrollBy({ left: offset, behavior: 'smooth' });
                    setTimeout(updateChipsNavButtons, 250);
                }
            };

            window.updateChipsNavButtons = function() {
                const track = document.querySelector('.active-chips-scroll-track');
                const prevBtn = document.querySelector('.chips-nav-prev');
                const nextBtn = document.querySelector('.chips-nav-next');
                if (!track || !prevBtn || !nextBtn) return;

                if (window.innerWidth < 992) {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                    return;
                }

                const maxScroll = track.scrollWidth - track.clientWidth;
                if (maxScroll > 6) {
                    prevBtn.style.display = track.scrollLeft > 6 ? 'flex' : 'none';
                    nextBtn.style.display = track.scrollLeft < (maxScroll - 6) ? 'flex' : 'none';
                } else {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                }
            };

            document.addEventListener('scroll', function(e) {
                if (e.target && e.target.classList && e.target.classList.contains('active-chips-scroll-track')) {
                    updateChipsNavButtons();
                }
            }, true);

            window.addEventListener('resize', updateChipsNavButtons, { passive: true });
            setTimeout(updateChipsNavButtons, 400);

            // Tarayıcı İleri / Geri Tuşları Desteği (HTML5 History API)
            window.addEventListener('popstate', function() {
                applyFiltersAjax(window.location.href, false);
                syncFormFromUrl(window.location.href);
            });

            // Sayfa açılışında butonların ve mobil yatay çubuğun görünümünü senkronize et
            updateFilterButtonsState();
            syncMobileTrackFromForm();

            const scrollTrack = document.querySelector('.services-mobile-scroll-track');
            if (scrollTrack) {
                scrollTrack.addEventListener('scroll', closeAllCustomSelects, { passive: true });
            }
            window.addEventListener('scroll', closeAllCustomSelects, { passive: true });
        });

        // Alt kategorileri getir
        function servicesGetSubCategories() {
            const categorySelect = document.getElementById('categorySelect');
            const subCategorySelect = document.getElementById('sub-category-select');
            const subCatGroup = document.getElementById('subCategoryGroup');
            const trackSubCatWrap = document.getElementById('mobileTrackSubCatWrapper');
            const trackSubCatSelect = document.getElementById('mobileTrackSubCatSelect');

            if (!categorySelect) return;

            const categoryId = categorySelect.value;

            if (!categoryId) {
                if (subCategorySelect) {
                    subCategorySelect.innerHTML = '<option value="">Tüm Alt Kategoriler</option>';
                    if (subCategorySelect._refreshCustomSelect) subCategorySelect._refreshCustomSelect();
                }
                if (subCatGroup) subCatGroup.style.display = 'none';

                if (trackSubCatSelect) {
                    trackSubCatSelect.innerHTML = '<option value="">Tüm Alt Kategoriler</option>';
                    if (trackSubCatSelect._refreshCustomSelect) trackSubCatSelect._refreshCustomSelect();
                }
                if (trackSubCatWrap) {
                    trackSubCatWrap.style.display = 'none';
                    trackSubCatWrap.classList.add('d-none');
                }

                updateFilterButtonsState();
                const provWrap = document.getElementById('mobileTrackProvinceSelect')?.closest('.mobile-track-select-wrap');
                if (provWrap) centerMobileFilter(provWrap);
                return;
            }

            if (subCatGroup) subCatGroup.style.display = 'block';

            fetch(`/get-sub-categories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Tüm Alt Kategoriler</option>';
                    const selSubCats = window.__currentSelectedSubCats || [];

                    if (data && data.length > 0) {
                        data.forEach(subCategory => {
                            const isSelected = selSubCats.includes(String(subCategory.id)) ? 'selected' : '';
                            options += `<option value="${subCategory.id}" ${isSelected}>${(subCategory.name || '').trim()}</option>`;
                        });

                        if (subCategorySelect) {
                            subCategorySelect.innerHTML = options;
                            if (subCategorySelect._refreshCustomSelect) {
                                subCategorySelect._refreshCustomSelect();
                            } else {
                                initCustomSelect(subCategorySelect);
                            }
                        }

                        if (trackSubCatSelect) {
                            trackSubCatSelect.innerHTML = options;
                            if (trackSubCatSelect._refreshCustomSelect) {
                                trackSubCatSelect._refreshCustomSelect();
                            } else {
                                initCustomSelect(trackSubCatSelect);
                            }
                        }
                        if (trackSubCatWrap) {
                            trackSubCatWrap.classList.remove('d-none');
                            trackSubCatWrap.style.display = 'inline-flex';
                            smartRevealMobileFilter(trackSubCatWrap);
                        }
                    } else {
                        if (subCategorySelect) {
                            subCategorySelect.innerHTML = '<option value="">Tüm Alt Kategoriler</option>';
                            if (subCategorySelect._refreshCustomSelect) subCategorySelect._refreshCustomSelect();
                        }
                        if (subCatGroup) subCatGroup.style.display = 'none';

                        if (trackSubCatSelect) {
                            trackSubCatSelect.innerHTML = '<option value="">Tüm Alt Kategoriler</option>';
                            if (trackSubCatSelect._refreshCustomSelect) trackSubCatSelect._refreshCustomSelect();
                        }
                        if (trackSubCatWrap) {
                            trackSubCatWrap.style.display = 'none';
                            trackSubCatWrap.classList.add('d-none');
                            const provWrap = document.getElementById('mobileTrackProvinceSelect')?.closest('.mobile-track-select-wrap');
                            if (provWrap) smartRevealMobileFilter(provWrap);
                        }
                    }

                    updateFilterButtonsState();
                })
                .catch(error => {
                    console.error('Alt kategoriler yüklenirken hata:', error);
                });
        }

        // Kategori parametrelerini dinamik yükle
        function servicesLoadCategoryParameters() {
            const categorySelect = document.getElementById('categorySelect');
            const container = document.getElementById('dynamicParametersContainer');
            const trackDynamicWrap = document.getElementById('mobileTrackDynamicContainer');
            
            if (!container || !categorySelect) return;

            const categoryId = categorySelect.value;
            container.innerHTML = '';
            if (trackDynamicWrap) trackDynamicWrap.innerHTML = '';

            if (!categoryId) {
                updateFilterButtonsState();
                return;
            }

            fetch(`/company/services/category-parameters/${categoryId}`)
                .then(response => response.json())
                .then(parameters => {
                    if (!parameters || parameters.length === 0) {
                        updateFilterButtonsState();
                        return;
                    }

                    const currentValue = '{!! addslashes(json_encode(request()->parameters ?? [])) !!}';
                    let currentParams = {};
                    try {
                        currentParams = JSON.parse(currentValue);
                    } catch (e) {
                        currentParams = {};
                    }

                    parameters.forEach(parameter => {
                        const paramValue = currentParams[parameter.id] || '';

                        // 1. Drawer İçi (Başlıklı)
                        const formGroup = document.createElement('div');
                        formGroup.className = 'mb-3';
                        formGroup.setAttribute('data-dynamic-parameter', '');

                        if (parameter.type === 'input') {
                            formGroup.innerHTML = `
                                <label class="filter-label"><i class="fa-solid fa-sliders me-1"></i> ${parameter.title}</label>
                                <div class="filter-input-wrapper">
                                    <input type="text" 
                                           name="parameters[${parameter.id}]" 
                                           class="filter-input" 
                                           placeholder="${parameter.title}"
                                           value="${paramValue}">
                                </div>
                            `;
                        } else if (parameter.type === 'select' && parameter.options) {
                            let selectHtml = `
                                <label class="filter-label"><i class="fa-solid fa-sliders me-1"></i> ${parameter.title}</label>
                                <select name="parameters[${parameter.id}]" class="form-select filter-select" data-placeholder="${parameter.title}">
                                    <option value="">${parameter.title}: Tümü</option>
                            `;
                            parameter.options.forEach(option => {
                                const cleanOpt = (option || '').trim();
                                const selected = cleanOpt === paramValue ? 'selected' : '';
                                selectHtml += `<option value="${cleanOpt}" ${selected}>${cleanOpt}</option>`;
                            });
                            selectHtml += '</select>';
                            formGroup.innerHTML = selectHtml;
                        }

                        container.appendChild(formGroup);

                        // 2. Mobil Yatay Filtre Çubuğu İçi (Başlıksız, Aynı Tasarım)
                        if (trackDynamicWrap) {
                            if (parameter.type === 'input') {
                                const wrap = document.createElement('div');
                                wrap.className = 'filter-input-wrapper';
                                wrap.innerHTML = `
                                    <input type="text" class="filter-input" placeholder="${parameter.title}" value="${paramValue}" data-param-id="${parameter.id}"
                                           oninput="onMobileTrackDynamicInput('${parameter.id}', this.value, this)"
                                           onchange="onMobileTrackDynamicCommit('${parameter.id}', this.value, this)"
                                           onblur="onMobileTrackDynamicCommit('${parameter.id}', this.value, this)">
                                `;
                                trackDynamicWrap.appendChild(wrap);
                                syncMobileTrackInputState(wrap.querySelector('input'));
                            } else if (parameter.type === 'select' && parameter.options) {
                                const wrap = document.createElement('div');
                                wrap.className = 'mobile-track-select-wrap';
                                let sel = `<select class="form-select filter-select" data-placeholder="${parameter.title}" data-icon="fa-solid fa-sliders" data-param-id="${parameter.id}" onchange="onMobileTrackDynamicChange('${parameter.id}', this.value)">`;
                                sel += `<option value="">${parameter.title}</option>`;
                                parameter.options.forEach(option => {
                                    const cleanOpt = (option || '').trim();
                                    const selected = cleanOpt === paramValue ? 'selected' : '';
                                    sel += `<option value="${cleanOpt}" ${selected}>${cleanOpt}</option>`;
                                });
                                sel += `</select>`;
                                wrap.innerHTML = sel;
                                trackDynamicWrap.appendChild(wrap);
                            }
                        }
                    });

                    // Dinamik yüklenen yeni selectbox'ları özel tasarıma dönüştür
                    initAllCustomSelects(container);
                    if (trackDynamicWrap) initAllCustomSelects(trackDynamicWrap);
                    updateFilterButtonsState();
                })
                .catch(error => {
                    console.error('Parametreler yüklenirken hata:', error);
                });
        }

        // İlçeleri getir
        function servicesGetDistricts() {
            const provinceSelect = document.getElementById('provinceSelect');
            const districtSelect = document.getElementById('district-select');
            const districtGroup = document.getElementById('districtGroup');
            const trackDistWrap = document.getElementById('mobileTrackDistrictWrapper');
            const trackDistSelect = document.getElementById('mobileTrackDistrictSelect');

            if (!provinceSelect) return;

            const provinceId = provinceSelect.value;

            if (!provinceId) {
                if (districtSelect) {
                    districtSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
                    if (districtSelect._refreshCustomSelect) districtSelect._refreshCustomSelect();
                }
                if (districtGroup) districtGroup.style.display = 'none';

                if (trackDistSelect) {
                    trackDistSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
                    if (trackDistSelect._refreshCustomSelect) trackDistSelect._refreshCustomSelect();
                }
                if (trackDistWrap) {
                    trackDistWrap.style.display = 'none';
                    trackDistWrap.classList.add('d-none');
                }

                updateFilterButtonsState();
                const priceGroup = document.querySelector('.mobile-track-range-group');
                if (priceGroup) centerMobileFilter(priceGroup);
                return;
            }

            if (districtGroup) districtGroup.style.display = 'block';

            fetch(`/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Tüm İlçeler</option>';
                    const selDistricts = window.__currentSelectedDistricts || [];

                    if (data && data.length > 0) {
                        data.forEach(district => {
                            const isSelected = selDistricts.includes(String(district.id)) ? 'selected' : '';
                            options += `<option value="${district.id}" ${isSelected}>${(district.name || '').trim()}</option>`;
                        });

                        if (districtSelect) {
                            districtSelect.innerHTML = options;
                            if (districtSelect._refreshCustomSelect) {
                                districtSelect._refreshCustomSelect();
                            } else {
                                initCustomSelect(districtSelect);
                            }
                        }

                        if (trackDistSelect) {
                            trackDistSelect.innerHTML = options;
                            if (trackDistSelect._refreshCustomSelect) {
                                trackDistSelect._refreshCustomSelect();
                            } else {
                                initCustomSelect(trackDistSelect);
                            }
                        }
                        if (trackDistWrap) {
                            trackDistWrap.classList.remove('d-none');
                            trackDistWrap.style.display = 'inline-flex';
                            smartRevealMobileFilter(trackDistWrap);
                        }
                    } else {
                        if (districtSelect) {
                            districtSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
                            if (districtSelect._refreshCustomSelect) districtSelect._refreshCustomSelect();
                        }
                        if (districtGroup) districtGroup.style.display = 'none';

                        if (trackDistSelect) {
                            trackDistSelect.innerHTML = '<option value="">Tüm İlçeler</option>';
                            if (trackDistSelect._refreshCustomSelect) trackDistSelect._refreshCustomSelect();
                        }
                        if (trackDistWrap) {
                            trackDistWrap.style.display = 'none';
                            trackDistWrap.classList.add('d-none');
                            const priceGroup = document.querySelector('.mobile-track-range-group');
                            if (priceGroup) smartRevealMobileFilter(priceGroup);
                        }
                    }

                    updateFilterButtonsState();
                })
                .catch(error => {
                    console.error('İlçeler yüklenirken hata:', error);
                });
        }

        // ==========================================================================
        // Mobilde Sayfa Aşağı Kaydırıldığında Navbar'ı Gizle & Hızlı Filtreyi Üste Yerleştir
        // ==========================================================================
        (function() {
            let ticking = false;
            let initialToolbarTop = 0;
            let toolbarHeight = 0;
            let isStickyActive = false;

            function getElements() {
                return {
                    toolbar: document.getElementById('servicesToolbar') || document.querySelector('.services-toolbar'),
                    placeholder: document.getElementById('servicesToolbarPlaceholder')
                };
            }

            function measureToolbar() {
                if (window.innerWidth >= 992) return;
                const { toolbar } = getElements();
                if (!toolbar) return;

                if (!isStickyActive) {
                    const rect = toolbar.getBoundingClientRect();
                    initialToolbarTop = rect.top + (window.scrollY || window.pageYOffset || 0);
                    toolbarHeight = toolbar.offsetHeight;
                }
            }

            function updateStickyState() {
                if (window.innerWidth >= 992) {
                    if (isStickyActive) removeSticky();
                    return;
                }

                const { toolbar, placeholder } = getElements();
                if (!toolbar) return;

                const scrollY = window.scrollY || window.pageYOffset || 0;
                // Eşik değeri: Toolbar'ın sayfa üstündeki orijinal konumu
                const threshold = initialToolbarTop > 10 ? (initialToolbarTop - 5) : 75;

                if (scrollY > threshold) {
                    if (!isStickyActive) {
                        isStickyActive = true;
                        if (placeholder) {
                            placeholder.style.height = (toolbarHeight || toolbar.offsetHeight || 44) + 'px';
                            placeholder.classList.remove('d-none');
                        }
                        toolbar.classList.add('is-sticky');
                        document.body.classList.add('services-navbar-hidden');
                    }
                } else {
                    if (isStickyActive) {
                        removeSticky();
                    }
                }
            }

            function removeSticky() {
                isStickyActive = false;
                const { toolbar, placeholder } = getElements();
                if (toolbar) toolbar.classList.remove('is-sticky');
                if (placeholder) {
                    placeholder.classList.add('d-none');
                    placeholder.style.height = '0';
                }
                document.body.classList.remove('services-navbar-hidden');
            }

            function onScroll() {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        updateStickyState();
                        ticking = false;
                    });
                    ticking = true;
                }
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', () => {
                if (!isStickyActive) measureToolbar();
                updateStickyState();
            }, { passive: true });
            window.addEventListener('load', measureToolbar, { passive: true });

            setTimeout(measureToolbar, 100);
            setTimeout(measureToolbar, 500);
        })();
    </script>
@endsection
