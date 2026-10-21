@extends('site.inc.master')

@section('css')
<style>
  /* ==========================================================================
     Modern Company Profile Page (Desktop 2-Column & Mobile Redesign)
     Cohesive Design System matching Service and Idea Detail Pages
     ========================================================================== */
  .plus {
    display: none !important;
  }

  /* ==========================================================================
     Kusursuz Kenar Boşluğu Hizalaması (Sidebar ile İçerik & Sağ Kenar Eşit 16px)
     ========================================================================== */
  body > .container-fluid {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  body > .container-fluid > .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  .main,
  .main.sidebar {
    transition: padding-left 0.28s cubic-bezier(0.4, 0, 0.2, 1) !important;
  }

  /* Reset Bootstrap Gutters so Content Fills the Remaining Width Beside Sidebar */
  #index-right-area {
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    width: 100% !important;
  }

  :root,
  .index-right,
  .sd-page-wrapper,
  .index-right.sd-page-wrapper,
  .sd-mobile-sticky-bar {
    --sd-primary: #2563eb;
    --sd-primary-hover: #1d4ed8;
    --sd-primary-soft: rgba(37, 99, 235, 0.08);
    --sd-surface: #ffffff;
    --sd-bg: #f4f7fb;
    --sd-border: #e2e8f0;
    --sd-text-main: #0f172a;
    --sd-text-muted: #64748b;
    --sd-radius-lg: 16px;
    --sd-radius-md: 12px;
    --sd-radius-sm: 8px;
    --sd-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.04);
  }

  .index-right,
  .sd-page-wrapper,
  .index-right.sd-page-wrapper {
    background-color: var(--sd-bg) !important;
    padding-left: 16px !important;
    padding-right: 16px !important;
    padding-top: 20px !important;
    padding-bottom: 40px !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    min-height: 100vh;
    border: none !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }

  body.dark,
  body.dark .sd-page-wrapper,
  body.dark .sd-mobile-sticky-bar {
    --sd-primary: #3b82f6;
    --sd-primary-hover: #60a5fa;
    --sd-primary-soft: rgba(59, 130, 246, 0.15);
    --sd-surface: #18181b;
    --sd-bg: #0f0f12;
    --sd-border: #27272a;
    --sd-text-main: #f4f4f5;
    --sd-text-muted: #a1a1aa;
    --sd-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.4);
  }

  .sd-container {
    max-width: 100% !important;
    margin: 0 !important;
    width: 100% !important;
  }

  /* --- Top Breadcrumb & Desktop Quick Actions --- */
  .sd-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 18px;
    flex-wrap: wrap;
  }

  .sd-breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 13.5px;
    color: var(--sd-text-muted);
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .sd-breadcrumb a {
    color: var(--sd-text-muted);
    text-decoration: none;
    transition: color 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .sd-breadcrumb a:hover {
    color: var(--sd-primary);
  }

  .sd-breadcrumb .sd-bc-sep {
    font-size: 11px;
    opacity: 0.6;
  }

  .sd-breadcrumb .sd-bc-current {
    color: var(--sd-text-main);
    font-weight: 500;
    max-width: 320px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sd-top-actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sd-icon-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 999px;
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    color: var(--sd-text-main);
    font-size: 13.5px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
  }

  .sd-icon-action-btn:hover {
    border-color: var(--sd-primary);
    color: var(--sd-primary);
    transform: translateY(-1px);
  }

  /* --- Main Two-Column Grid --- */
  .sd-main-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 24px;
    align-items: start;
  }

  .sd-left-col {
    min-width: 0;
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    overflow: visible;
  }

  /* --- Company Hero Card (Masaüstünde Sekmeler Kartı ile Birleşik - Sıfır Border ve Gölge) --- */
  .sd-company-hero-card {
    background: var(--sd-surface);
    border: none !important;
    border-bottom: none !important;
    box-shadow: none !important;
    border-radius: var(--sd-radius-lg) var(--sd-radius-lg) 0 0 !important;
    overflow: hidden;
    margin-bottom: 0 !important;
    position: relative;
  }

  .sd-hero-banner {
    height: 120px;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #38bdf8 100%);
    position: relative;
  }

  @if($company->cover_photo)
  .sd-hero-banner.has-cover {
    background-image: url('{{ asset($company->cover_photo) }}');
    background-size: cover;
    background-position: center;
  }
  .sd-hero-banner.has-cover::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.55) 100%);
  }
  @endif

  .sd-hero-content {
    padding: 16px 24px 20px;
    position: relative;
  }

  /* 1) Logo En Solda, Firma Adı Sağında Düzeni */
  .sd-hero-main-row {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 22px;
  }

  .sd-hero-info-col {
    flex: 1;
    min-width: 0;
  }

  .sd-hero-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    flex-wrap: wrap;
  }

  .sd-hero-title {
    font-size: clamp(1.3rem, 1.15rem + 0.6vw, 1.75rem);
    font-weight: 700;
    color: var(--sd-text-main);
    line-height: 1.3;
    margin: 0;
  }

  .sd-hero-verified-inline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    cursor: pointer;
    flex-shrink: 0;
  }

  .sd-hero-verified-inline img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .sd-hero-badges-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
  }

  .sd-badge-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 500;
    background: var(--sd-bg);
    color: var(--sd-text-muted);
    border: 1px solid var(--sd-border);
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .sd-badge-pill i {
    color: var(--sd-primary);
    font-size: 12px;
  }

  .sd-badge-pill.sd-rating-badge {
    background: rgba(245, 158, 11, 0.1);
    border-color: rgba(245, 158, 11, 0.3);
    color: #d97706;
    font-weight: 600;
  }

  .sd-badge-pill.sd-rating-badge i {
    color: #f59e0b;
  }

  body.dark .sd-badge-pill.sd-rating-badge {
    color: #fbbf24;
  }

  /* Logo Sağ Kolon */
  .sd-hero-logo-col {
    flex-shrink: 0;
    margin-top: -50px;
    position: relative;
    z-index: 3;
  }

  .sd-hero-avatar-wrapper {
    position: relative;
    display: inline-block;
  }

  .sd-hero-avatar {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    object-fit: cover;
    background: var(--sd-surface);
    border: 4px solid var(--sd-surface);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    display: block;
  }

  /* Social Links Row */
  .sd-hero-social-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid var(--sd-border);
    flex-wrap: wrap;
  }

  .sd-social-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    color: var(--sd-text-muted);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease;
  }

  .sd-social-btn:hover {
    background: var(--sd-primary);
    border-color: var(--sd-primary);
    color: #fff;
    transform: translateY(-2px);
  }

  /* --- Tabs Card (Masaüstünde Üst Kart ile Birleşik - Sıfır Border ve Gölge) --- */
  .sd-tabs-card {
    background: var(--sd-surface);
    border: none !important;
    border-top: none !important;
    box-shadow: none !important;
    border-radius: 0 !important;
    overflow: visible;
    margin-top: 0 !important;
  }

  .sd-nav-tabs {
    display: flex;
    border-bottom: 1px solid var(--sd-border) !important;
    background: var(--sd-surface);
    padding: 0 16px;
    gap: 8px;
    overflow-x: auto;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    margin: 0;
    list-style: none;
  }

  .sd-nav-tabs::-webkit-scrollbar {
    display: none;
  }

  .sd-nav-item {
    margin: 0;
  }

  /* 4) İkonsuz Sekme Butonları */
  .sd-nav-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 16px 20px;
    font-size: 14.5px;
    font-weight: 600;
    color: var(--sd-text-muted);
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
    text-decoration: none;
  }

  .sd-nav-link:hover {
    color: var(--sd-primary);
  }

  .sd-nav-link.active {
    color: var(--sd-primary);
    border-bottom-color: var(--sd-primary);
  }

  .sd-nav-link .sd-tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 2px 8px;
    border-radius: 999px;
    font-size: 11.5px;
    background: var(--sd-bg);
    color: var(--sd-text-muted);
    font-weight: 600;
    border: 1px solid var(--sd-border);
  }

  .sd-nav-link.active .sd-tab-count {
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
    border-color: rgba(37, 99, 235, 0.2);
  }

  .sd-tab-content {
    padding: 24px;
  }

  /* --- Tab 1: Hizmetler --- */
  .sd-services-header {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .sd-services-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0;
  }

  /* --- Professional Sorting Anchored Popup & Trigger Button --- */
  .sd-sort-wrapper {
    position: relative;
    display: inline-block;
  }

  .sd-sort-trigger-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    padding: 0;
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-sm);
    color: var(--sd-text-main);
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    text-decoration: none;
    user-select: none;
    position: relative;
    flex-shrink: 0;
  }

  .sd-sort-trigger-btn:hover {
    border-color: var(--sd-primary);
    color: var(--sd-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
  }

  .sd-sort-trigger-btn.is-active,
  .sd-sort-trigger-btn[aria-expanded="true"] {
    border-color: var(--sd-primary);
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
  }

  .sd-sort-icon {
    font-size: 15px;
    color: var(--sd-text-muted);
    transition: color 0.2s;
  }

  .sd-sort-trigger-btn:hover .sd-sort-icon,
  .sd-sort-trigger-btn.is-active .sd-sort-icon,
  .sd-sort-trigger-btn[aria-expanded="true"] .sd-sort-icon {
    color: var(--sd-primary);
  }

  .sd-sort-active-dot {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--sd-primary);
  }

  /* Anchored Popup directly underneath trigger button */
  .sd-sort-popup {
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    min-width: 220px;
    width: max-content;
    max-width: calc(100vw - 32px);
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.14), 0 4px 10px -2px rgba(15, 23, 42, 0.05);
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-6px) scale(0.97);
    transform-origin: top right;
    transition: opacity 0.18s cubic-bezier(0.16, 1, 0.3, 1), transform 0.18s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.18s;
    pointer-events: none;
    padding: 6px;
    overflow: hidden;
  }

  .sd-sort-popup.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
    pointer-events: auto;
  }

  .sd-sort-options-list {
    display: flex;
    flex-direction: column;
    gap: 2px;
    padding: 0;
    margin: 0;
  }

  .sd-sort-option-item {
    display: flex;
    align-items: center;
    padding: 10px 14px;
    border-radius: var(--sd-radius-sm);
    color: var(--sd-text-main);
    background: transparent;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
    font-size: 13.5px;
    font-weight: 500;
  }

  .sd-sort-option-item:hover {
    background: var(--sd-bg);
    color: var(--sd-primary);
  }

  .sd-sort-option-item.is-selected {
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
    font-weight: 600;
  }

  .sd-sort-option-name {
    display: block;
    white-space: nowrap;
  }

  .sd-empty-state {
    text-align: center;
    padding: 48px 20px;
    color: var(--sd-text-muted);
  }

  .sd-empty-icon {
    font-size: 42px;
    color: var(--sd-text-muted);
    opacity: 0.5;
    margin-bottom: 14px;
  }

  /* --- 5) Modern Kullanıcı Dostu Sayfalama Bileşeni (Pagination) --- */
  .sd-modern-pagination-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding-top: 24px;
    margin-top: 24px;
    border-top: 1px solid var(--sd-border);
    flex-wrap: wrap;
  }

  .sd-pagination-info {
    font-size: 13px;
    color: var(--sd-text-muted);
  }

  .sd-pagination-info strong {
    color: var(--sd-text-main);
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
    color: var(--sd-text-main);
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    text-decoration: none;
    transition: all 0.2s ease;
    user-select: none;
  }

  .sd-page-btn:hover {
    background: var(--sd-primary-soft);
    border-color: var(--sd-primary);
    color: var(--sd-primary);
    transform: translateY(-1px);
  }

  .sd-page-item.active .sd-page-btn {
    background: var(--sd-primary) !important;
    border-color: var(--sd-primary) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    pointer-events: none;
  }

  .sd-page-item.disabled .sd-page-btn {
    opacity: 0.4;
    pointer-events: none;
    cursor: not-allowed;
    background: var(--sd-bg);
    border-color: var(--sd-border);
  }

  .sd-page-dots {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 38px;
    color: var(--sd-text-muted);
    font-weight: 700;
    letter-spacing: 1px;
  }

  .sd-page-prev,
  .sd-page-next {
    padding: 0 14px;
    gap: 6px;
    font-size: 13px;
  }

  /* --- Tab 2: Değerlendirmeler --- */
  .sd-rating-summary-card {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
  }

  .sd-rating-big-score {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-width: 110px;
    padding-right: 24px;
    border-right: 1px solid var(--sd-border);
  }

  .sd-rating-num {
    font-size: 40px;
    font-weight: 800;
    color: var(--sd-text-main);
    line-height: 1;
    margin-bottom: 4px;
  }

  .sd-rating-stars-row {
    color: #f59e0b;
    font-size: 16px;
    display: flex;
    gap: 3px;
  }

  .sd-rating-total-count {
    font-size: 12.5px;
    color: var(--sd-text-muted);
    margin-top: 6px;
  }

  .sd-rating-desc-text {
    flex: 1;
    min-width: 220px;
    font-size: 14px;
    color: var(--sd-text-muted);
    margin: 0;
    line-height: 1.5;
  }

  /* Değerlendirme Formu */
  .sd-add-review-card {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
  }

  .sd-review-form-title {
    font-size: 15.5px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin-bottom: 14px;
  }

  .sd-star-picker {
    direction: rtl;
    unicode-bidi: bidi-override;
    display: inline-flex;
    gap: 4px;
    margin-bottom: 14px;
  }

  .sd-star-picker input {
    display: none;
  }

  .sd-star-picker label {
    color: var(--sd-border);
    font-size: 26px;
    cursor: pointer;
    transition: color 0.15s ease, transform 0.15s ease;
  }

  .sd-star-picker input:checked ~ label,
  .sd-star-picker label:hover,
  .sd-star-picker label:hover ~ label {
    color: #f59e0b;
  }

  .sd-star-picker label:hover {
    transform: scale(1.15);
  }

  .sd-review-textarea {
    width: 100%;
    padding: 12px 14px;
    border-radius: var(--sd-radius-sm);
    border: 1px solid var(--sd-border);
    background: var(--sd-bg);
    color: var(--sd-text-main);
    font-size: 14px;
    outline: none;
    margin-bottom: 14px;
    transition: border-color 0.2s, background 0.2s;
    resize: vertical;
  }

  .sd-review-textarea:focus {
    border-color: var(--sd-primary);
    background: var(--sd-surface);
  }

  /* Review Item Card */
  .sd-review-item {
    border-bottom: 1px solid var(--sd-border);
    padding: 18px 0;
  }

  .sd-review-item:first-child {
    padding-top: 0;
  }

  .sd-review-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .sd-review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
  }

  .sd-review-user {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sd-review-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid var(--sd-border);
  }

  .sd-review-name {
    font-size: 14.5px;
    font-weight: 600;
    color: var(--sd-text-main);
  }

  .sd-review-date {
    font-size: 12px;
    color: var(--sd-text-muted);
  }

  .sd-review-stars {
    color: #f59e0b;
    font-size: 13.5px;
    margin-bottom: 8px;
    display: flex;
    gap: 3px;
  }

  .sd-review-body {
    font-size: 14px;
    color: var(--sd-text-main);
    line-height: 1.55;
    margin: 0;
  }

  /* --- Tab 3: Hakkında --- */
  .sd-about-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
  }

  .sd-about-text-area {
    font-size: 14.5px;
    line-height: 1.7;
    color: var(--sd-text-main);
    white-space: pre-line;
  }

  .sd-about-info-box {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 18px;
  }

  .sd-info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--sd-border);
    font-size: 13.5px;
  }

  .sd-info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .sd-info-label {
    color: var(--sd-text-muted);
    font-weight: 500;
    flex-shrink: 0;
  }

  .sd-info-val {
    color: var(--sd-text-main);
    font-weight: 600;
    text-align: right;
    word-break: break-word;
  }

  .sd-map-card {
    margin-top: 20px;
    border-radius: var(--sd-radius-md);
    overflow: hidden;
    border: 1px solid var(--sd-border);
  }

  /* --- Right Sticky Sidebar --- */
  .sd-sidebar {
    position: sticky;
    top: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .sd-action-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 20px;
  }

  .sd-btn-group-vertical {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .sd-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 18px;
    border-radius: var(--sd-radius-sm);
    font-size: 14.5px;
    font-weight: 600;
    color: #fff !important;
    background: var(--sd-primary);
    border: 1px solid var(--sd-primary);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
  }

  .sd-btn-primary:hover {
    background: var(--sd-primary-hover);
    border-color: var(--sd-primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
  }

  .sd-btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 18px;
    border-radius: var(--sd-radius-sm);
    font-size: 14.5px;
    font-weight: 600;
    color: var(--sd-primary) !important;
    background: var(--sd-surface);
    border: 1.5px solid var(--sd-primary);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .sd-btn-outline:hover {
    background: var(--sd-primary-soft);
    transform: translateY(-1px);
  }

  .sd-btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px 16px;
    border-radius: var(--sd-radius-sm);
    font-size: 13.5px;
    font-weight: 500;
    color: var(--sd-text-main);
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .sd-btn-secondary:hover {
    border-color: var(--sd-primary);
    color: var(--sd-primary);
  }

  .sd-report-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    margin-top: 10px;
    font-size: 12.5px;
    color: var(--sd-text-muted);
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    transition: color 0.2s;
  }

  .sd-report-link:hover {
    color: #ef4444;
  }

  /* Quick Stats Strip in Sidebar */
  .sd-stats-strip {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--sd-border);
  }

  .sd-stat-box {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-sm);
    padding: 10px 12px;
    text-align: center;
  }

  .sd-stat-num {
    display: block;
    font-size: 18px;
    font-weight: 700;
    color: var(--sd-text-main);
    line-height: 1.2;
  }

  .sd-stat-lbl {
    font-size: 11.5px;
    color: var(--sd-text-muted);
    font-weight: 500;
  }

  /* --- İletişim Bilgileri Popup Stilleri --- */
  .iletisim-backdrop {
    display: none;
  }

  .iletisim-popup {
    position: fixed;
    padding: 0 !important;
    background: #ffffff;
    background: var(--sd-surface, #ffffff);
    border: 1px solid #e2e8f0;
    border: 1px solid var(--sd-border, #e2e8f0);
    border-radius: 14px;
    box-shadow: 0 14px 36px rgba(15, 23, 42, 0.22);
    z-index: 100005;
    min-width: 280px;
    max-width: 340px;
    overflow: hidden !important;
    box-sizing: border-box !important;
  }

  body.dark .iletisim-popup {
    background: #18181b;
    background: var(--sd-surface, #18181b);
    border-color: #27272a;
    border-color: var(--sd-border, #27272a);
    box-shadow: 0 14px 36px rgba(0, 0, 0, 0.6);
  }

  .iletisim-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #e9ecef;
    border-bottom: 1px solid var(--sd-border, #e9ecef);
    background: #f8f9fa;
    background: var(--sd-bg, #f8f9fa);
  }

  body.dark .iletisim-popup-header {
    background: #202024;
    border-bottom-color: #27272a;
  }

  .iletisim-popup-title {
    margin: 0;
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    color: var(--sd-text-main, #0f172a);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  body.dark .iletisim-popup-title {
    color: #f4f4f5;
  }

  .iletisim-popup-close {
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    color: #64748b;
    color: var(--sd-text-muted, #64748b);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
  }

  body.dark .iletisim-popup-close {
    color: #a1a1aa;
  }

  .iletisim-popup-body {
    padding: 16px;
    text-align: center;
  }

  /* --- Mobile Sticky Bottom Bar --- */
  .sd-mobile-sticky-bar {
    display: none;
  }

  /* Floating Overlay Topbar on Mobile */
  .sd-mobile-top-nav {
    display: none;
  }

  /* ==========================================================================
     RESPONSIVE: MOBILE VIEW (< 992px)
     Matches Service & Idea Detail Page Patterns
     ========================================================================== */
  @media screen and (max-width: 991px) {
    body > .container-fluid {
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-top: 0 !important;
      margin-top: 0 !important;
    }

    body > .container-fluid > .row {
      margin-left: 0 !important;
      margin-right: 0 !important;
      margin-top: 0 !important;
      padding-top: 0 !important;
    }

    body > .container-fluid > .row > .main,
    body > .container-fluid > .row > .main.sidebar,
    #index-right-area {
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-top: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      margin-top: 0 !important;
      width: 100% !important;
    }

    header {
      display: none !important;
    }

    .index-right.sd-page-wrapper {
      margin-top: 0 !important;
      padding-top: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-bottom: 84px !important;
      border: none !important;
      width: 100% !important;
      overflow-x: clip;
    }

    .sd-topbar {
      display: none !important;
    }

    .sd-main-grid {
      display: flex;
      flex-direction: column;
      gap: 0 !important;
      width: 100%;
    }

    .sd-left-col,
    .sd-sidebar {
      display: contents;
    }

    .sd-left-col {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      border-radius: 0 !important;
      overflow: visible !important;
    }

    /* Floating Safe-Area Top Nav for Mobile */
    .sd-mobile-top-nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: absolute;
      top: 12px;
      top: max(12px, env(safe-area-inset-top, 12px));
      left: 12px;
      right: 12px;
      z-index: 10;
      pointer-events: none;
    }

    .sd-mob-nav-group {
      display: flex;
      align-items: center;
      gap: 8px;
      pointer-events: auto;
    }

    .sd-mob-circle-btn {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: #fff !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
      padding: 0;
    }

    .sd-mob-circle-btn:active {
      transform: scale(0.92);
    }

    /* Company Hero Card on Mobile */
    .sd-company-hero-card {
      order: 1;
      border-radius: 0 !important;
      border: none !important;
      border-bottom: none !important;
      margin: 0 !important;
      box-shadow: none !important;
    }

    .sd-hero-banner {
      height: 80px;
    }

    .sd-hero-content {
      padding: 12px 14px 16px !important;
    }

    .sd-hero-content:has(.sd-hero-social-row) {
      padding-bottom: 0 !important;
    }

    .sd-hero-main-row {
      display: grid !important;
      grid-template-columns: auto 1fr !important;
      grid-template-areas:
        "logo title"
        "badges badges"
        "social social" !important;
      column-gap: 12px !important;
      row-gap: 6px !important;
      align-items: center !important;
    }

    .sd-hero-logo-col {
      grid-area: logo;
      margin-top: -36px !important;
      flex-shrink: 0;
    }

    .sd-hero-avatar {
      width: 72px;
      height: 72px;
      border-radius: 16px;
      border: 3px solid var(--sd-surface);
    }

    .sd-hero-info-col {
      display: contents !important;
    }

    .sd-hero-title-row {
      grid-area: title;
      display: flex !important;
      align-items: center !important;
      gap: 6px !important;
      margin-bottom: 0 !important;
    }

    .sd-hero-title {
      font-size: 1.05rem;
      font-weight: 700;
      line-height: 1.25;
      margin: 0 !important;
    }

    .sd-hero-verified-inline {
      width: 17px;
      height: 17px;
      flex-shrink: 0;
    }

    /* Mobile Badges Strip (Horizontal Scroll / Sağa Sola Kaydırılır) */
    .sd-hero-badges-row {
      grid-area: badges;
      display: flex !important;
      flex-wrap: nowrap !important;
      overflow-x: auto !important;
      scrollbar-width: none !important;
      -webkit-overflow-scrolling: touch !important;
      gap: 6px !important;
      margin-top: 4px !important;
      margin-bottom: 0 !important;
      margin-left: -14px !important;
      margin-right: -14px !important;
      padding-left: 14px !important;
      padding-right: 14px !important;
      padding-bottom: 2px !important;
      padding-top: 2px !important;
      width: calc(100% + 28px) !important;
    }

    .sd-hero-badges-row::-webkit-scrollbar {
      display: none !important;
    }

    .sd-badge-pill {
      flex-shrink: 0 !important;
      white-space: nowrap !important;
      font-size: 11px !important;
      padding: 4px 9px !important;
      gap: 5px !important;
      border-radius: 999px !important;
    }

    .sd-badge-pill i {
      font-size: 10.5px !important;
    }

    /* Mobile Social Links Row: No borders, centered */
    .sd-hero-social-row {
      grid-area: social;
      display: flex !important;
      justify-content: center !important;
      align-items: center !important;
      gap: 10px !important;
      margin-top: 6px !important;
      margin-bottom: 6px !important;
      padding: 0 !important;
      border: none !important;
      border-top: none !important;
      border-bottom: none !important;
      width: 100% !important;
    }

    .sd-social-btn {
      width: 36px !important;
      height: 36px !important;
      font-size: 14.5px !important;
    }

    /* Seamless Tabs Card on Mobile */
    .sd-tabs-card {
      order: 2 !important;
      margin: 0 0 12px 0 !important;
      padding: 0 !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      border-top: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
    }

    /* Mobile Tabs (Horizontal Scroll / Sağa Sola Kaydırılır) */
    .sd-nav-tabs {
      display: flex !important;
      flex-wrap: nowrap !important;
      overflow-x: auto !important;
      scrollbar-width: none !important;
      -webkit-overflow-scrolling: touch !important;
      scroll-behavior: smooth !important;
      scroll-snap-type: x proximity !important;
      padding: 0 14px !important;
      gap: 4px !important;
      border-bottom: 1px solid var(--sd-border) !important;
    }

    .sd-nav-tabs::-webkit-scrollbar {
      display: none !important;
    }

    .sd-nav-item {
      flex-shrink: 0 !important;
      scroll-snap-align: center !important;
    }

    .sd-nav-link {
      white-space: nowrap !important;
      flex-shrink: 0 !important;
      padding: 12px 14px !important;
      font-size: 13px !important;
      gap: 6px !important;
    }

    .sd-tab-count {
      padding: 2px 7px !important;
      font-size: 11px !important;
      border-radius: 999px !important;
    }

    .sd-tab-content {
      padding: 16px 14px;
    }

    /* Mobile Sayfalama */
    .sd-modern-pagination-wrapper {
      justify-content: center;
      padding-top: 18px;
      margin-top: 18px;
    }

    .sd-pagination-list {
      gap: 4px;
      justify-content: center;
    }

    .sd-page-btn {
      min-width: 34px;
      height: 34px;
      font-size: 13px;
      padding: 0 8px;
      border-radius: 8px;
    }

    /* Mobile About Layout */
    .sd-about-layout {
      grid-template-columns: 1fr;
      gap: 16px;
    }

    /* Hide Desktop Sidebar in Mobile flow, functions placed in bottom bar */
    .sd-sidebar {
      display: none !important;
    }

    /* Hide global site bottom menu on mobile so company profile action bar sits cleanly */
    body .mobile-fixed-menu {
      display: none !important;
    }

    /* Mobile Sticky Bottom Bar */
    .sd-mobile-sticky-bar {
      display: flex !important;
      align-items: center !important;
      position: fixed !important;
      bottom: 0 !important;
      left: 0 !important;
      right: 0 !important;
      width: 100% !important;
      height: 55px !important;
      z-index: 99999 !important;
      background: #ffffff !important;
      background: var(--sd-surface, #ffffff) !important;
      border-top: 1px solid #e2e8f0 !important;
      border-top: 1px solid var(--sd-border, #e2e8f0) !important;
      padding: 0 16px !important;
      box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.12) !important;
      gap: 12px !important;
      box-sizing: border-box !important;
    }

    body.dark .sd-mobile-sticky-bar {
      background: #18181b !important;
      background: var(--sd-surface, #18181b) !important;
      border-top: 1px solid #27272a !important;
      border-top: 1px solid var(--sd-border, #27272a) !important;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.5) !important;
    }

    .sd-mob-bar-btn {
      flex: 1 1 0% !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 7px !important;
      height: 38px !important;
      border-radius: 10px !important;
      font-size: 13px !important;
      font-weight: 600 !important;
      text-decoration: none !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      user-select: none !important;
      box-sizing: border-box !important;
    }

    /* Mesaj Gönder Button */
    .sd-mob-bar-btn.sd-btn-chat {
      background: #eff6ff !important;
      background: var(--sd-primary-soft, #eff6ff) !important;
      border: 1.5px solid #2563eb !important;
      border: 1.5px solid var(--sd-primary, #2563eb) !important;
      color: #2563eb !important;
      color: var(--sd-primary, #2563eb) !important;
    }

    .sd-mob-bar-btn.sd-btn-chat:active {
      transform: scale(0.97) !important;
      background: #2563eb !important;
      color: #ffffff !important;
    }

    /* Hemen Ara Button */
    .sd-mob-bar-btn.sd-btn-call {
      background: #2563eb !important;
      background: var(--sd-primary, #2563eb) !important;
      border: 1.5px solid #2563eb !important;
      border: 1.5px solid var(--sd-primary, #2563eb) !important;
      color: #ffffff !important;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28) !important;
    }

    .sd-mob-bar-btn.sd-btn-call:active {
      transform: scale(0.97) !important;
      background: #1d4ed8 !important;
      border-color: #1d4ed8 !important;
      color: #ffffff !important;
    }

    body.dark .sd-mob-bar-btn.sd-btn-chat {
      background: rgba(59, 130, 246, 0.15) !important;
      border-color: #3b82f6 !important;
      border-color: var(--sd-primary, #3b82f6) !important;
      color: #3b82f6 !important;
      color: var(--sd-primary, #3b82f6) !important;
    }

    body.dark .sd-mob-bar-btn.sd-btn-call {
      background: #3b82f6 !important;
      background: var(--sd-primary, #3b82f6) !important;
      border-color: #3b82f6 !important;
      border-color: var(--sd-primary, #3b82f6) !important;
      color: #ffffff !important;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
    }

    .sd-sort-trigger-btn {
      width: 31px !important;
      height: 31px !important;
      border-radius: 8px !important;
    }

    .sd-sort-icon {
      font-size: 12.5px !important;
    }

    .sd-sort-active-dot {
      top: 4px !important;
      right: 4px !important;
      width: 5px !important;
      height: 5px !important;
    }

    .sd-services-header {
      margin-bottom: 12px !important;
    }

    .sd-sort-popup {
      right: 0;
      width: min(220px, calc(100vw - 32px));
    }

    /* Mobile İletişim Bilgileri Popup & Backdrop */
    .iletisim-backdrop {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(15, 23, 42, 0.45);
      backdrop-filter: blur(2px);
      -webkit-backdrop-filter: blur(2px);
      z-index: 100000;
      opacity: 0;
      transition: opacity 0.22s ease;
    }

    .iletisim-backdrop.show {
      display: block;
      opacity: 1;
    }

    body.dark .iletisim-backdrop {
      background: rgba(0, 0, 0, 0.7);
    }

    .iletisim-popup {
      position: fixed !important;
      padding: 0 !important;
      left: 14px !important;
      right: 14px !important;
      width: calc(100% - 28px) !important;
      max-width: 400px !important;
      margin: 0 auto !important;
      bottom: 67px !important;
      top: auto !important;
      border-radius: 18px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.28) !important;
      z-index: 100005 !important;
      overflow: hidden !important;
      box-sizing: border-box !important;
      transform: translateY(10px) scale(0.97);
      opacity: 0;
      transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.22s ease !important;
    }

    .iletisim-popup.is-open {
      transform: translateY(0) scale(1) !important;
      opacity: 1 !important;
    }

    .iletisim-popup-header {
      width: 100% !important;
      margin: 0 !important;
      box-sizing: border-box !important;
      padding: 13px 18px !important;
      border-top-left-radius: 18px !important;
      border-top-right-radius: 18px !important;
    }

    .iletisim-popup-title {
      font-size: 15px !important;
    }

    .iletisim-popup-close {
      width: 30px !important;
      height: 30px !important;
      border-radius: 50% !important;
      background: rgba(0, 0, 0, 0.05) !important;
    }

    body.dark .iletisim-popup-close {
      background: rgba(255, 255, 255, 0.08) !important;
    }

    .iletisim-popup-body {
      padding: 18px 20px 20px !important;
    }

    .iletisim-popup-body .sd-btn-outline {
      height: 48px !important;
      font-size: 15px !important;
      border-radius: 12px !important;
      font-weight: 600 !important;
      box-shadow: 0 2px 10px rgba(37, 99, 235, 0.1) !important;
    }
  }

  /* --- Company Profile AdSense Styles --- */
  .sd-sidebar-ad-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 16px;
    overflow: hidden;
  }
  body.dark .sd-sidebar-ad-card {
    background: #18181b;
    border-color: #27272a;
  }
  .sd-bottom-ad-wrapper {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-lg);
    padding: 16px 20px;
    box-shadow: var(--sd-shadow);
    overflow: hidden;
  }
  body.dark .sd-bottom-ad-wrapper {
    background: #18181b;
    border-color: #27272a;
  }
  .sd-service-ad-mobile {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 12px;
    box-shadow: var(--sd-shadow);
    overflow: hidden;
  }
  body.dark .sd-service-ad-mobile {
    background: #18181b;
    border-color: #27272a;
  }
  .sd-ad-badge-line {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .sd-ad-badge-text {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: var(--sd-text-muted);
    background: rgba(0, 0, 0, 0.04);
    padding: 2px 10px;
    border-radius: 12px;
  }
  body.dark .sd-ad-badge-text {
    background: rgba(255, 255, 255, 0.08);
    color: #a1a1aa;
  }
</style>
@endsection

@section('content')
<div class="main sidebar">
  <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
    <div class="index-right sd-page-wrapper">
      <div class="sd-container">

        <!-- Desktop Topbar (Breadcrumb & Action Pills) -->
        <div class="sd-topbar">
          <ul class="sd-breadcrumb">
            <li>
              <a href="{{ route('site.home') }}">
                <i class="fa-solid fa-house"></i>
                <span>Anasayfa</span>
              </a>
            </li>
            <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
            <li>
              <a href="{{ route('companies.index') }}">Firmalar</a>
            </li>
            @if($company->category)
              <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
              <li>
                <a href="{{ route('companies.index', ['category' => $company->category_id]) }}">
                  {{ $company->category->name }}
                </a>
              </li>
            @endif
            <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
            <li class="sd-bc-current">{{ $company->name }}</li>
          </ul>

          <div class="sd-top-actions">
            @auth
              @if(auth()->user()->id != $company->user_id)
                <form action="{{ route('company.follow') }}" method="POST" style="margin: 0;">
                  @csrf
                  <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($company->user_id) }}">
                  <button type="submit" class="sd-icon-action-btn {{ auth()->user()->following($company->user_id) ? 'is-saved' : '' }}">
                    <i class="fa-solid {{ auth()->user()->following($company->user_id) ? 'fa-check' : 'fa-plus' }}"></i>
                    <span>{{ auth()->user()->following($company->user_id) ? 'Takip Ediliyor' : 'Takip Et' }}</span>
                  </button>
                </form>
              @endif
            @endauth
          </div>
        </div>

        <!-- Main Two-Column Layout -->
        <div class="sd-main-grid">

          <!-- Left Column: Hero Card & Tabs (Masaüstünde Tek Birleşik Kart Görünümü) -->
          <div class="sd-left-col">

            <!-- Company Hero Card -->
            <div class="sd-company-hero-card">

              <!-- Mobile Floating Top Nav Controls -->
              <div class="sd-mobile-top-nav">
                <div class="sd-mob-nav-group">
                  <a href="javascript:history.back()" class="sd-mob-circle-btn" aria-label="Geri">
                    <i class="fa-solid fa-arrow-left"></i>
                  </a>
                </div>
                <div class="sd-mob-nav-group">
                  <button type="button" class="sd-mob-circle-btn share-btn" aria-label="Paylaş" title="Paylaş">
                    <i class="fa-solid fa-share-nodes"></i>
                  </button>
                  @auth
                    @if(auth()->user()->id != $company->user_id)
                      <form action="{{ route('company.follow') }}" method="POST" style="margin:0;">
                        @csrf
                        <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($company->user_id) }}">
                        <button type="submit" class="sd-mob-circle-btn" aria-label="Takip Et">
                          <i class="fa-solid {{ auth()->user()->following($company->user_id) ? 'fa-check' : 'fa-plus' }}"></i>
                        </button>
                      </form>
                    @endif
                  @endauth
                </div>
              </div>

              <!-- Cover Banner -->
              <div class="sd-hero-banner {{ $company->cover_photo ? 'has-cover' : '' }}"></div>

              <!-- Hero Content Body -->
              <div class="sd-hero-content">
                <!-- 1) Logo En Solda, Firma Adı ve Bilgileri Sağında -->
                <div class="sd-hero-main-row">

                  <!-- Sol Kolon: Firma Logosu (En Solda) -->
                  <div class="sd-hero-logo-col">
                    <div class="sd-hero-avatar-wrapper">
                      @php
                        $avatarUrl = $company->avatar ? asset($company->avatar) : asset('site/images/default-avatar.png');
                      @endphp
                      <img src="{{ $avatarUrl }}" alt="{{ $company->name }}" class="sd-hero-avatar">
                    </div>
                  </div>

                  <!-- Sağ / Yan Kolon: Firma Adı, Onay Rozeti, Etiketler ve Sosyal Medya -->
                  <div class="sd-hero-info-col">
                    <div class="sd-hero-title-row">
                      <h1 class="sd-hero-title">{{ $company->name }}</h1>

                      @if($company->is_verified == 1)
                        <span class="sd-hero-verified-inline" tabindex="0" data-bs-toggle="popover"
                              data-bs-trigger="hover focus"
                              data-bs-content="Firma bilgileri ve konumu, uzmanlarımız tarafından onaylanmıştır."
                              title="Onaylı Firma">
                          <img src="{{ asset('site/images/success.png') }}" alt="Onaylı">
                        </span>
                      @endif
                    </div>

                    <!-- Badges / Tags -->
                    <div class="sd-hero-badges-row">
                      @if($company->category)
                        <span class="sd-badge-pill">
                          <i class="fa-solid fa-briefcase"></i>
                          <span>{{ $company->category->name }} @if($company->subCategory) / {{ $company->subCategory->name }} @endif</span>
                        </span>
                      @endif

                      @if($company->provinceInfo)
                        <span class="sd-badge-pill">
                          <i class="fa-solid fa-location-dot"></i>
                          <span>{{ $company->provinceInfo->name }} @if($company->districtInfo) / {{ $company->districtInfo->name }} @endif</span>
                        </span>
                      @endif

                      @if($company->authorized)
                        <span class="sd-badge-pill">
                          <i class="fa-solid fa-user-tie"></i>
                          <span>{{ $company->authorized }}</span>
                        </span>
                      @endif

                      @php
                        $avgRating = $company->ratings()->avg('rating') ?? 0;
                        $ratingCount = $company->ratings()->count();
                      @endphp
                      @if($ratingCount > 0)
                        <span class="sd-badge-pill sd-rating-badge">
                          <i class="fa-solid fa-star"></i>
                          <span>{{ number_format($avgRating, 1) }} ({{ $ratingCount }} Değerlendirme)</span>
                        </span>
                      @endif
                    </div>

                    <!-- Social Links Row -->
                    @if($company->instagram || $company->youtube || $company->facebook || $company->website)
                      <div class="sd-hero-social-row">
                        @if($company->instagram)
                          <a href="{{ $company->instagram }}" target="_blank" rel="noopener noreferrer" class="sd-social-btn" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                          </a>
                        @endif
                        @if($company->youtube)
                          <a href="{{ $company->youtube }}" target="_blank" rel="noopener noreferrer" class="sd-social-btn" title="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                          </a>
                        @endif
                        @if($company->facebook)
                          <a href="{{ $company->facebook }}" target="_blank" rel="noopener noreferrer" class="sd-social-btn" title="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                          </a>
                        @endif
                        @if($company->website)
                          <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="sd-social-btn" title="Web Sitesi">
                            <i class="fa-solid fa-globe"></i>
                          </a>
                        @endif
                      </div>
                    @endif
                  </div>

                </div>
              </div>
            </div>

            <!-- 3) Tabs Card (Masaüstünde Üst Kart ile Boşluksuz ve Radius Olmadan Birleşir) -->
            <div class="sd-tabs-card">
              <!-- 4) İkonsuz Sekme Butonları -->
              <ul class="sd-nav-tabs nav nav-tabs" id="companyTab" role="tablist">
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link active" id="tab-services-btn" data-bs-toggle="tab" data-bs-target="#tab-services" type="button" role="tab" aria-controls="tab-services" aria-selected="true">
                    <span>Hizmetler</span>
                    <span class="sd-tab-count">{{ $serviceCount }}</span>
                  </button>
                </li>
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link" id="tab-reviews-btn" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button" role="tab" aria-controls="tab-reviews" aria-selected="false">
                    <span>Değerlendirmeler</span>
                    <span class="sd-tab-count">{{ $company->ratings()->count() }}</span>
                  </button>
                </li>
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link" id="tab-about-btn" data-bs-toggle="tab" data-bs-target="#tab-about" type="button" role="tab" aria-controls="tab-about" aria-selected="false">
                    <span>Hakkında & Konum</span>
                  </button>
                </li>
              </ul>

              <!-- Tabs Content -->
              <div class="tab-content sd-tab-content" id="companyTabContent">

                <!-- 1. Hizmetler Tab -->
                <div class="tab-pane fade show active" id="tab-services" role="tabpanel" aria-labelledby="tab-services-btn">
                  <div class="sd-services-header">
                    @php
                      $currentSort = request()->order_by ?? '';
                      $sortLabels = [
                        '' => 'Standart Sıralama',
                        'price_asc' => 'Fiyata Göre (Artan)',
                        'price_desc' => 'Fiyata Göre (Azalan)',
                        'date_desc' => 'Tarihe Göre (En Yeni)',
                        'date_asc' => 'Tarihe Göre (En Eski)',
                      ];
                      $currentLabel = $sortLabels[$currentSort] ?? 'Standart Sıralama';
                      $isCustomSort = !empty($currentSort) && isset($sortLabels[$currentSort]);
                    @endphp

                    <div class="sd-sort-wrapper" id="sortWrapper">
                      <button type="button" class="sd-sort-trigger-btn {{ $isCustomSort ? 'is-active' : '' }}" id="sortTriggerBtn" aria-expanded="false" aria-haspopup="true" title="Sıralama: {{ $currentLabel }}" aria-label="Sıralama: {{ $currentLabel }}">
                        <i class="fa-solid fa-arrow-down-wide-short sd-sort-icon"></i>
                        @if($isCustomSort)
                          <span class="sd-sort-active-dot"></span>
                        @endif
                      </button>

                      <!-- Direk Butonun Altında Açılan Sıralama Pop-up Menüsü -->
                      <div class="sd-sort-popup" id="sortPopup" role="menu">
                        <form action="{{ url()->current() }}" method="GET" id="sortServicesForm" class="m-0">
                          {{-- Mevcut filtre ve parametreleri koru (order_by ve sayfa hariç) --}}
                          @foreach(request()->except(['order_by', 'page']) as $k => $v)
                            @if(is_array($v))
                              @foreach($v as $sv)
                                <input type="hidden" name="{{ $k }}[]" value="{{ $sv }}">
                              @endforeach
                            @else
                              <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                          @endforeach

                          <input type="hidden" name="order_by" id="sortOrderByInput" value="{{ request()->order_by ?? '' }}">

                          <div class="sd-sort-options-list">
                            @php
                              $options = [
                                ['value' => '',           'label' => 'Standart Sıralama'],
                                ['value' => 'price_asc',  'label' => 'Fiyata Göre (Artan)'],
                                ['value' => 'price_desc', 'label' => 'Fiyata Göre (Azalan)'],
                                ['value' => 'date_desc',  'label' => 'Tarihe Göre (En Yeni)'],
                                ['value' => 'date_asc',   'label' => 'Tarihe Göre (En Eski)'],
                              ];
                              $currentSortVal = request()->order_by ?? '';
                            @endphp

                            @foreach($options as $opt)
                              @php
                                $isSelected = ($currentSortVal === $opt['value']);
                              @endphp
                              <div class="sd-sort-option-item {{ $isSelected ? 'is-selected' : '' }}" 
                                   data-value="{{ $opt['value'] }}"
                                   role="menuitem"
                                   tabindex="0">
                                <span class="sd-sort-option-name">{{ $opt['label'] }}</span>
                              </div>
                            @endforeach
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  @if($services->count() > 0)
                    <div class="row g-3">
                      @foreach($services as $service)
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
                          @include('site.services.partials.single-service-card', ['service' => $service])
                        </div>

                        {{-- Mobilde her 4 hizmet kartından sonra duyarlı reklam --}}
                        @if($loop->iteration % 4 == 0)
                          <div class="col-12 d-block d-md-none text-center my-3">
                            <div class="sd-service-ad-mobile">
                              <div class="sd-ad-badge-line mb-2">
                                <span class="sd-ad-badge-text"><i class="fa-solid fa-rectangle-ad me-1"></i> Sponsorlu Reklam</span>
                              </div>
                              <x-ad-slot format="auto" />
                            </div>
                          </div>
                        @endif
                      @endforeach
                    </div>

                    <!-- 5) Modern Kullanıcı Dostu Sayfa Geçişi Bileşeni -->
                    @if($services->hasPages())
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
                    @endif
                  @else
                    <div class="sd-empty-state">
                      <div class="sd-empty-icon">
                        <i class="fa-solid fa-box-open"></i>
                      </div>
                      <h5>Henüz Hizmet Eklenmemiş</h5>
                      <p>Bu firmanın şu an için yayınlanmış aktif bir hizmeti bulunmamaktadır.</p>
                    </div>
                  @endif
                </div>

                <!-- 2. Değerlendirmeler Tab -->
                <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-btn">

                  <!-- Rating Score Overview Card -->
                  @php
                    $averageRating = $company->ratings()->avg('rating') ?? 0;
                    $fullStars = floor($averageRating);
                    $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    $totalRatingsCount = $company->ratings()->count();
                  @endphp
                  <div class="sd-rating-summary-card">
                    <div class="sd-rating-big-score">
                      <span class="sd-rating-num">{{ number_format($averageRating, 1) }}</span>
                      <div class="sd-rating-stars-row">
                        @for($i = 0; $i < $fullStars; $i++)
                          <i class="fa-solid fa-star"></i>
                        @endfor
                        @if($hasHalfStar)
                          <i class="fa-solid fa-star-half-stroke"></i>
                        @endif
                        @for($i = 0; $i < $emptyStars; $i++)
                          <i class="fa-regular fa-star"></i>
                        @endfor
                      </div>
                      <span class="sd-rating-total-count">{{ $totalRatingsCount }} değerlendirme</span>
                    </div>
                    <p class="sd-rating-desc-text">
                      Müşterilerimizin bu firma ile tamamladığı hizmet ve işlemler neticesindeki deneyim puanı ve yorumları burada listelenmektedir.
                    </p>
                  </div>

                  <!-- Review Submission Form (Auth & Not Own Profile & Not Already Rated) -->
                  @if(auth()->check() && !$company->ratings()->where('user_id', auth()->id())->exists() && auth()->user()->id != $company->user_id)
                    <div class="sd-add-review-card">
                      <h3 class="sd-review-form-title">
                        <i class="fa-solid fa-pen-nib me-1 text-primary"></i> Firmayı Değerlendir
                      </h3>
                      <form id="ratingForm" action="{{ route('company.rating.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">

                        <div class="mb-2">
                          <label class="form-label d-block text-muted small fw-semibold">Puanınız:</label>
                          <div class="sd-star-picker">
                            @for($i = 5; $i >= 1; $i--)
                              <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                              <label for="star{{ $i }}" title="{{ $i }} Yıldız">
                                <i class="fa-solid fa-star"></i>
                              </label>
                            @endfor
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="reviewComment" class="form-label text-muted small fw-semibold">Deneyiminiz ve Yorumunuz:</label>
                          <textarea name="comment" id="reviewComment" class="sd-review-textarea" rows="3" placeholder="Firma ile olan deneyimlerinizi buraya yazabilirsiniz..." required></textarea>
                        </div>

                        <button type="submit" class="sd-btn-primary" id="ratingSubmitBtn" style="width: auto; padding: 10px 24px;">
                          <span class="btn-text">Değerlendirmeyi Gönder</span>
                          <span class="btn-loading d-none">
                            <i class="fa-solid fa-spinner fa-spin me-1"></i> Gönderiliyor...
                          </span>
                        </button>
                      </form>
                    </div>
                  @endif

                  <!-- Reviews List -->
                  <div id="ratingsList">
                    @forelse($company->ratings()->with(['user.informations', 'user.company'])->latest()->paginate(5) as $rating)
                      <div class="sd-review-item">
                        <div class="sd-review-header">
                          <div class="sd-review-user">
                            @php
                              $user = $rating->user ?? null;
                              $userInfo = $user->informations ?? null;
                              $userCompany = $user->company ?? null;
                              $displayName = 'Silinmiş Kullanıcı';
                              $avatarPath = 'site/images/default-avatar.png';

                              if ($user) {
                                  $displayName = $user->getDisplayName();
                                  if ($user->user_type === 'company' && $userCompany) {
                                      $companyAvatar = $userCompany->avatar ?? null;
                                      if ($companyAvatar && !empty(trim($companyAvatar))) {
                                          $avatarPath = $companyAvatar;
                                      }
                                  } else {
                                      $userInfoAvatar = $userInfo->avatar ?? null;
                                      $userAvatar = $user->avatar ?? null;
                                      if ($userInfoAvatar && !empty(trim($userInfoAvatar))) {
                                          $avatarPath = $userInfoAvatar;
                                      } elseif ($userAvatar && !empty(trim($userAvatar))) {
                                          $avatarPath = $userAvatar;
                                      }
                                  }
                              }
                            @endphp

                            <img src="{{ asset($avatarPath) }}" class="sd-review-avatar" alt="{{ $displayName }}" onerror="this.src='{{ asset('site/images/default-avatar.png') }}'">
                            <div>
                              <div class="sd-review-name">{{ $displayName }}</div>
                              <div class="sd-review-date">{{ $rating->created_at->format('d.m.Y') }}</div>
                            </div>
                          </div>

                          @if($rating->user_id == auth()->id())
                            <form action="{{ route('company.rating.destroy', $rating->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-link text-danger p-0 ms-2" onclick="return confirm('Bu değerlendirmeyi silmek istediğinize emin misiniz?')" title="Yorumu Sil">
                                <i class="fa-solid fa-trash-can"></i>
                              </button>
                            </form>
                          @endif
                        </div>

                        <div class="sd-review-stars">
                          @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating->rating)
                              <i class="fa-solid fa-star"></i>
                            @else
                              <i class="fa-regular fa-star text-muted"></i>
                            @endif
                          @endfor
                        </div>

                        @if($rating->comment)
                          <p class="sd-review-body">{{ $rating->comment }}</p>
                        @endif
                      </div>
                    @empty
                      <div class="sd-empty-state">
                        <div class="sd-empty-icon">
                          <i class="fa-regular fa-comment-dots"></i>
                        </div>
                        <h5>Henüz Değerlendirme Yok</h5>
                        <p>Bu firma hakkında henüz bir değerlendirme yapılmamış. İlk yorumu siz yapabilirsiniz!</p>
                      </div>
                    @endforelse
                  </div>

                  <!-- Pagination for reviews -->
                  @if($company->ratings()->count() > 5)
                    <div class="mt-4 d-flex justify-content-center">
                      {{ $company->ratings()->paginate(5)->links() }}
                    </div>
                  @endif
                </div>

                <!-- 3. Hakkında Tab -->
                <div class="tab-pane fade" id="tab-about" role="tabpanel" aria-labelledby="tab-about-btn">
                  <div class="sd-about-layout">
                    <!-- About Text -->
                    <div class="sd-about-main">
                      <h3 class="sd-services-title mb-3">Firma Hakkında</h3>
                      <div class="sd-about-text-area">
                        @if($company->about)
                          {{ $company->about }}
                        @else
                          <p class="text-muted">Firma henüz detaylı bir hakkında açıklaması belirtmedi.</p>
                        @endif
                      </div>

                      <!-- Google Maps Embed -->
                      @if($company->lat && $company->lng)
                        <div class="sd-map-card">
                          <iframe
                            src="https://www.google.com/maps?q={{ $company->lat }},{{ $company->lng }}&output=embed"
                            width="100%" height="320" style="border:0;"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                          </iframe>
                        </div>
                      @endif
                    </div>

                    <!-- Official Info Box -->
                    <div class="sd-about-sidebar">
                      <div class="sd-about-info-box">
                        <h4 class="sd-services-title mb-3" style="font-size: 14.5px;">Resmi Bilgiler</h4>

                        <div class="sd-info-row">
                          <span class="sd-info-label">Firma Yetkilisi</span>
                          <span class="sd-info-val">{{ $company->authorized ?? 'Belirtilmemiş' }}</span>
                        </div>

                        <div class="sd-info-row">
                          <span class="sd-info-label">İletişim Tel</span>
                          <span class="sd-info-val">
                            @if($company->mobile_phone)
                              <a href="tel:{{ $company->mobile_phone }}" class="text-primary text-decoration-none">{{ $company->mobile_phone }}</a>
                            @elseif($company->fixed_phone)
                              <a href="tel:{{ $company->fixed_phone }}" class="text-primary text-decoration-none">{{ $company->fixed_phone }}</a>
                            @else
                              Belirtilmemiş
                            @endif
                          </span>
                        </div>

                        <div class="sd-info-row">
                          <span class="sd-info-label">Adres</span>
                          <span class="sd-info-val">{{ $company->address ?? 'Belirtilmemiş' }}</span>
                        </div>

                        @if($company->provinceInfo)
                          <div class="sd-info-row">
                            <span class="sd-info-label">İl</span>
                            <span class="sd-info-val">{{ $company->provinceInfo->name }}</span>
                          </div>
                        @endif

                        @if($company->districtInfo)
                          <div class="sd-info-row">
                            <span class="sd-info-label">İlçe</span>
                            <span class="sd-info-val">{{ $company->districtInfo->name }}</span>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <!-- Right Column: Sticky Sidebar (Desktop Only) -->
          <div class="sd-sidebar">

            <!-- Fast Action Card -->
            <div class="sd-action-card">
              <h3 class="sd-services-title mb-3" style="font-size: 15px;">İletişim & Hızlı İşlemler</h3>

              <div class="sd-btn-group-vertical">
                @if($company->mobile_phone || $company->fixed_phone)
                  <a href="javascript:void(0)" onclick="showIletisimPopup(this)" class="sd-btn-primary ara-button">
                    <i class="fa-solid fa-phone"></i>
                    <span>Hemen Ara ({{ $company->mobile_phone ?: $company->fixed_phone }})</span>
                  </a>
                @endif

                @auth
                  @if(auth()->user()->id != $company->user_id)
                    <a href="{{ route('chat.show', $company->user_id) }}" class="sd-btn-outline">
                      <i class="fa-solid fa-comment-dots"></i>
                      <span>Mesaj Gönder</span>
                    </a>

                    <form action="{{ route('company.follow') }}" method="POST" style="margin: 0;">
                      @csrf
                      <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($company->user_id) }}">
                      <button type="submit" class="sd-btn-secondary w-100">
                        <i class="fa-solid {{ auth()->user()->following($company->user_id) ? 'fa-check text-success' : 'fa-plus' }}"></i>
                        <span>{{ auth()->user()->following($company->user_id) ? 'Takipten Çık' : 'Firmayı Takip Et' }}</span>
                      </button>
                    </form>
                  @endif
                @else
                  <a href="#exampleModalToggle" data-bs-toggle="modal" class="sd-btn-outline">
                    <i class="fa-solid fa-comment-dots"></i>
                    <span>Mesaj Gönder</span>
                  </a>
                  <a href="#exampleModalToggle" data-bs-toggle="modal" class="sd-btn-secondary">
                    <i class="fa-solid fa-plus"></i>
                    <span>Takip Et</span>
                  </a>
                @endauth

                <button type="button" class="sd-btn-secondary share-btn">
                  <i class="fa-solid fa-share-nodes"></i>
                  <span>Profili Paylaş</span>
                </button>
              </div>

              <!-- Report Link -->
              @auth
                <button type="button" class="sd-report-link" data-bs-toggle="modal" data-bs-target="#firmasikayeti">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                  <span>Firma ile ilgili şikayetim var</span>
                </button>
              @endauth

              <!-- Profile Stats Strip -->
              <div class="sd-stats-strip">
                <div class="sd-stat-box">
                  <span class="sd-stat-num">{{ $serviceCount }}</span>
                  <span class="sd-stat-lbl">Aktif Hizmet</span>
                </div>
                <div class="sd-stat-box">
                  <span class="sd-stat-num">{{ number_format($avgRating, 1) }}</span>
                  <span class="sd-stat-lbl">Puan ({{ $totalRatingsCount }})</span>
                </div>
              </div>
            </div>

            <!-- Masaüstü: İletişim & Hızlı İşlemler Kartı Altı Reklam Alanı -->
            <div class="sd-sidebar-ad-card text-center d-none d-lg-block">
              <div class="sd-ad-badge-line mb-2">
                <span class="sd-ad-badge-text"><i class="fa-solid fa-rectangle-ad me-1"></i> Sponsorlu Reklam</span>
              </div>
              <x-ad-slot format="auto" class="sd-sidebar-ad-slot" />
            </div>

          </div>

        </div>

        <!-- Sayfa Altı Duyarlı Reklam Alanı (Masaüstü & Mobil) -->
        <div class="sd-bottom-ad-wrapper my-4 text-center">
          <div class="sd-ad-badge-line mb-2">
            <span class="sd-ad-badge-text"><i class="fa-solid fa-rectangle-ad me-1"></i> Sponsorlu Reklam</span>
          </div>
          <x-ad-slot format="auto" class="sd-bottom-ad-slot" />
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Mobile Sticky Bottom Action Bar -->
@php
  $canChat = !auth()->check() || (auth()->check() && auth()->user()->id != $company->user_id);
  $hasPhone = !empty($company->mobile_phone) || !empty($company->fixed_phone);
@endphp
@if($canChat || $hasPhone)
<div class="sd-mobile-sticky-bar">
  @if($canChat)
    @auth
      <a href="{{ route('chat.show', $company->user_id) }}" class="sd-mob-bar-btn sd-btn-chat">
        <i class="fa-solid fa-comment-dots"></i>
        <span>Mesaj Gönder</span>
      </a>
    @else
      <a href="#exampleModalToggle" data-bs-toggle="modal" class="sd-mob-bar-btn sd-btn-chat">
        <i class="fa-solid fa-comment-dots"></i>
        <span>Mesaj Gönder</span>
      </a>
    @endauth
  @endif

  @if($hasPhone)
    <a href="javascript:void(0)" onclick="showIletisimPopup(this)" class="sd-mob-bar-btn sd-btn-call ara-button">
      <i class="fa-solid fa-phone"></i>
      <span>Hemen Ara</span>
    </a>
  @endif
</div>
@endif

{{-- İletişim Bilgileri Popup & Backdrop --}}
<div id="iletisimBackdrop" class="iletisim-backdrop" onclick="closeIletisimPopup()"></div>
<div id="iletisimBilgileriPopup" class="iletisim-popup" style="display: none;">
  <div class="iletisim-popup-header">
    <h5 class="iletisim-popup-title">
      <i class="fa-solid fa-headset text-primary"></i>
      <span>İletişim Bilgileri</span>
    </h5>
    <button type="button" class="iletisim-popup-close" onclick="closeIletisimPopup()" aria-label="Kapat">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>
  <div class="iletisim-popup-body">
    <p style="margin: 0; font-size: 13px; color: var(--sd-text-muted, #64748b);">Yetkili Kişi / Firma</p>
    <p style="margin: 2px 0 0; font-size: 15.5px; color: var(--sd-text-main, #0f172a);">
      <strong>{{ $company->authorized ?: $company->name }}</strong>
    </p>
    @php
      $companyPhone = $company->mobile_phone ?: $company->fixed_phone;
    @endphp
    @if(!empty($companyPhone))
      <a href="tel:{{ $companyPhone }}"
         class="sd-btn-outline mt-3 w-100"
         style="text-decoration: none;">
        <i class="fa-solid fa-phone"></i>
        <span>{{ $companyPhone }}</span>
      </a>
    @endif
  </div>
</div>

<!-- Report Modal -->
@auth
<div class="modal fade" id="firmasikayeti" tabindex="-1" aria-labelledby="firmasikayetiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: var(--sd-radius-lg, 16px); border: 1px solid var(--sd-border, #e2e8f0); box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
      <div class="modal-header" style="border-bottom: 1px solid var(--sd-border, #e2e8f0); padding: 18px 24px;">
        <h5 class="modal-title fw-bold" id="firmasikayetiLabel" style="font-size: 16px; color: var(--sd-text-main, #0f172a);">
          <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i> Firma Şikayeti Bildir
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <form action="{{ route('companies.report', $company->slug) }}" method="POST">
        @csrf
        <div class="modal-body" style="padding: 24px;">
          <p class="text-muted small mb-3">
            Lütfen şikayet nedeninizi detaylı şekilde açıklayınız. Moderasyon ekibimiz en kısa sürede inceleyecektir.
          </p>
          <div class="mb-3">
            <textarea name="message" class="form-control" rows="5" maxlength="4800" required
                      placeholder="Şikayetinizi buraya yazınız..."
                      style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;"></textarea>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid var(--sd-border, #e2e8f0); padding: 14px 24px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Vazgeç</button>
          <button type="submit" class="btn btn-danger" style="border-radius: 8px; font-weight: 600;">Şikayeti İlet</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endauth

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // 1. Tab State Management via URL Hash (#reviews, #contact, etc.)
  const urlHash = window.location.hash;
  if (urlHash === '#ratings' || urlHash === '#reviews' || urlHash === '#contact') {
    const reviewsTabBtn = document.getElementById('tab-reviews-btn');
    if (reviewsTabBtn) {
      const tab = new bootstrap.Tab(reviewsTabBtn);
      tab.show();
    }
  } else if (urlHash === '#about' || urlHash === '#takipedilen') {
    const aboutTabBtn = document.getElementById('tab-about-btn');
    if (aboutTabBtn) {
      const tab = new bootstrap.Tab(aboutTabBtn);
      tab.show();
    }
  }

  // 1.1 Mobile Tab Centering on Click
  function centerTabButton(tabButton) {
    if (!tabButton || window.innerWidth > 991) return;
    const navTabs = document.querySelector('.sd-nav-tabs');
    if (!navTabs) return;

    const tabOffsetLeft = tabButton.offsetLeft;
    const tabWidth = tabButton.offsetWidth;
    const containerWidth = navTabs.clientWidth;
    const targetScrollLeft = tabOffsetLeft - (containerWidth / 2) + (tabWidth / 2);

    navTabs.scrollTo({
      left: Math.max(0, targetScrollLeft),
      behavior: 'smooth'
    });
  }

  const tabButtons = document.querySelectorAll('.sd-nav-link[data-bs-toggle="tab"]');
  tabButtons.forEach(btn => {
    btn.addEventListener('shown.bs.tab', function(e) {
      centerTabButton(e.target);
    });
    btn.addEventListener('click', function() {
      centerTabButton(this);
    });
  });

  const initialActiveTab = document.querySelector('.sd-nav-link.active');
  if (initialActiveTab) {
    setTimeout(() => {
      centerTabButton(initialActiveTab);
    }, 250);
  }

  // 2. Share Functionality
  const shareButtons = document.querySelectorAll('.share-btn');
  shareButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const currentUrl = window.location.href;
      const shareData = {
        title: '{{ addslashes($company->name) }} - Evhayaliniz',
        text: '{{ addslashes($company->name) }} firma profilini inceleyin.',
        url: currentUrl
      };

      if (navigator.share && /mobile|android|iphone/i.test(navigator.userAgent.toLowerCase())) {
        navigator.share(shareData).catch(() => {});
      } else {
        navigator.clipboard.writeText(currentUrl).then(() => {
          showNotification('Profil bağlantısı panoya kopyalandı!', 'success');
        }).catch(() => {
          showNotification('Bağlantı kopyalanamadı!', 'error');
        });
      }
    });
  });

  // 3. AJAX Rating Form Submission
  const ratingForm = document.getElementById('ratingForm');
  const ratingSubmitBtn = document.getElementById('ratingSubmitBtn');
  const btnText = ratingSubmitBtn ? ratingSubmitBtn.querySelector('.btn-text') : null;
  const btnLoading = ratingSubmitBtn ? ratingSubmitBtn.querySelector('.btn-loading') : null;

  if (ratingForm) {
    ratingForm.addEventListener('submit', function(e) {
      e.preventDefault();

      if (ratingSubmitBtn) {
        ratingSubmitBtn.disabled = true;
        if (btnText) btnText.classList.add('d-none');
        if (btnLoading) btnLoading.classList.remove('d-none');
      }

      const formData = new FormData(ratingForm);
      const csrfMeta = document.querySelector('meta[name="csrf-token"]');
      const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

      fetch(ratingForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': csrfToken
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showNotification('Değerlendirmeniz başarıyla gönderildi!', 'success');

          if (data.rating) {
            addNewRatingToList(data.rating);
          }

          const addReviewCard = ratingForm.closest('.sd-add-review-card');
          if (addReviewCard) {
            addReviewCard.style.display = 'none';
          }
        } else {
          showNotification(data.message || 'Bir hata oluştu!', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('Bir hata oluştu!', 'error');
      })
      .finally(() => {
        if (ratingSubmitBtn) {
          ratingSubmitBtn.disabled = false;
          if (btnText) btnText.classList.remove('d-none');
          if (btnLoading) btnLoading.classList.add('d-none');
        }
      });
    });
  }

  function addNewRatingToList(rating) {
    const ratingsList = document.getElementById('ratingsList');
    if (!ratingsList) return;

    const user = rating.user || {};
    const displayName = user.display_name || 'Kullanıcı';
    const avatarPath = '{{ asset("") }}' + (user.avatar_path || 'site/images/default-avatar.png');
    const ratingDate = new Date().toLocaleDateString('tr-TR');

    let starsHTML = '';
    for (let i = 1; i <= 5; i++) {
      if (i <= rating.rating) {
        starsHTML += '<i class="fa-solid fa-star"></i>';
      } else {
        starsHTML += '<i class="fa-regular fa-star text-muted"></i>';
      }
    }

    const newRatingHTML = `
      <div class="sd-review-item">
        <div class="sd-review-header">
          <div class="sd-review-user">
            <img src="${avatarPath}" class="sd-review-avatar" alt="${displayName}" onerror="this.src='{{ asset('site/images/default-avatar.png') }}'">
            <div>
              <div class="sd-review-name">${displayName}</div>
              <div class="sd-review-date">${ratingDate}</div>
            </div>
          </div>
        </div>
        <div class="sd-review-stars">
          ${starsHTML}
        </div>
        ${rating.comment ? `<p class="sd-review-body">${rating.comment}</p>` : ''}
      </div>
    `;

    const emptyState = ratingsList.querySelector('.sd-empty-state');
    if (emptyState) {
      emptyState.remove();
    }

    ratingsList.insertAdjacentHTML('afterbegin', newRatingHTML);
  }

  function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 24px; right: 24px; z-index: 99999; min-width: 280px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); border-radius: 10px; font-weight: 500;';
    notification.innerHTML = `
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 4500);
  }

  // 4. Anchored Services Sort Popup Functionality
  const sortWrapper = document.getElementById('sortWrapper');
  const sortTriggerBtn = document.getElementById('sortTriggerBtn');
  const sortPopup = document.getElementById('sortPopup');
  const sortForm = document.getElementById('sortServicesForm');
  const sortInput = document.getElementById('sortOrderByInput');

  if (sortTriggerBtn && sortPopup) {
    function openSortPopup() {
      sortPopup.classList.add('show');
      sortTriggerBtn.setAttribute('aria-expanded', 'true');
    }

    function closeSortPopup() {
      sortPopup.classList.remove('show');
      sortTriggerBtn.setAttribute('aria-expanded', 'false');
    }

    function toggleSortPopup() {
      if (sortPopup.classList.contains('show')) {
        closeSortPopup();
      } else {
        openSortPopup();
      }
    }

    sortTriggerBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleSortPopup();
    });

    sortPopup.addEventListener('click', function(e) {
      e.stopPropagation();
    });

    document.addEventListener('click', function(e) {
      if (sortWrapper && !sortWrapper.contains(e.target)) {
        closeSortPopup();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && sortPopup.classList.contains('show')) {
        closeSortPopup();
      }
    });

    if (sortForm && sortInput) {
      const sortOptionItems = sortPopup.querySelectorAll('.sd-sort-option-item');

      sortOptionItems.forEach(item => {
        item.addEventListener('click', function(e) {
          e.stopPropagation();
          const val = this.getAttribute('data-value') || '';
          sortOptionItems.forEach(el => el.classList.remove('is-selected'));
          this.classList.add('is-selected');
          sortInput.value = val;

          setTimeout(() => {
            sortForm.submit();
          }, 100);
        });

        item.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
          }
        });
      });
    }
  }
});

// İletişim Bilgileri Popup Fonksiyonları
function showIletisimPopup(buttonElement) {
  const popup = document.getElementById('iletisimBilgileriPopup');
  const backdrop = document.getElementById('iletisimBackdrop');
  if (!popup || !buttonElement) return;

  const isMobile = window.innerWidth <= 991;

  if (isMobile) {
    popup.style.display = 'block';
    popup.style.top = '';
    popup.style.left = '';

    if (backdrop) {
      backdrop.style.display = 'block';
      setTimeout(() => backdrop.classList.add('show'), 10);
    }
    setTimeout(() => popup.classList.add('is-open'), 10);
  } else {
    popup.style.display = 'block';
    popup.classList.add('is-open');

    const rect = buttonElement.getBoundingClientRect();
    const popupHeight = popup.offsetHeight;
    const popupWidth = popup.offsetWidth;
    const windowWidth = window.innerWidth;
    const windowHeight = window.innerHeight;

    let left = rect.left + (rect.width / 2) - (popupWidth / 2);
    if (left < 12) left = 12;
    if (left + popupWidth > windowWidth - 12) left = windowWidth - popupWidth - 12;

    let top = rect.bottom + 10;
    if (rect.bottom + popupHeight + 20 > windowHeight) {
      top = Math.max(16, rect.top - popupHeight - 12);
    }

    popup.style.left = left + 'px';
    popup.style.top = top + 'px';
  }

  setTimeout(() => {
    document.addEventListener('click', closeIletisimPopupOnOutsideClick);
  }, 50);
}

function closeIletisimPopup() {
  const popup = document.getElementById('iletisimBilgileriPopup');
  const backdrop = document.getElementById('iletisimBackdrop');

  if (popup) {
    popup.classList.remove('is-open');
    setTimeout(() => {
      popup.style.display = 'none';
      popup.style.top = '';
      popup.style.left = '';
    }, 200);
  }

  if (backdrop) {
    backdrop.classList.remove('show');
    setTimeout(() => {
      backdrop.style.display = 'none';
    }, 200);
  }

  document.removeEventListener('click', closeIletisimPopupOnOutsideClick);
}

function closeIletisimPopupOnOutsideClick(event) {
  const popup = document.getElementById('iletisimBilgileriPopup');
  const araButtons = document.querySelectorAll('.ara-button');

  if (popup && popup.contains(event.target)) {
    return;
  }

  let clickedAraButton = false;
  araButtons.forEach(btn => {
    if (btn.contains(event.target)) {
      clickedAraButton = true;
    }
  });

  if (!clickedAraButton) {
    closeIletisimPopup();
  }
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeIletisimPopup();
  }
});
</script>
@endsection
