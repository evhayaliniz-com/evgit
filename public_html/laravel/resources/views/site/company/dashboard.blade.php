@extends('site.inc.master')

@section('css')
<style>
  /* ==========================================================================
     Modern Company Profile & Dashboard Page (Company Owner View)
     Cohesive Design System matching Public Visitor Company Profile (show.blade.php)
     ========================================================================== */
  .plus {
    display: none !important;
  }

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
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .sd-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
    font-size: 13.5px;
    color: var(--sd-text-muted);
    flex-wrap: wrap;
  }

  .sd-breadcrumb li a {
    color: var(--sd-text-muted);
    text-decoration: none;
    transition: color 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .sd-breadcrumb li a:hover {
    color: var(--sd-primary);
  }

  .sd-bc-sep {
    font-size: 10px;
    color: var(--sd-text-muted);
    opacity: 0.6;
  }

  .sd-bc-current {
    color: var(--sd-text-main);
    font-weight: 600;
  }

  /* --- Main Grid Layout (Desktop 2-Column: Left & Sticky Sidebar) --- */
  .sd-main-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 360px;
    gap: 16px;
    align-items: start;
    width: 100%;
  }

  .sd-left-col {
    display: flex;
    flex-direction: column;
    gap: 16px;
    min-width: 0;
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    overflow: hidden;
  }

  /* --- Company Hero Card (Masaüstünde Üst Birleşik Kısım) --- */
  .sd-company-hero-card {
    background: var(--sd-surface);
    border: none;
    box-shadow: none;
    border-radius: 0;
    overflow: hidden;
    position: relative;
    border-bottom: 1px solid var(--sd-border);
  }

  .sd-hero-banner {
    height: 120px;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #38bdf8 100%);
    position: relative;
  }

  @php
    $company = auth()->user()->company;
  @endphp

  @if($company && $company->cover_photo)
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

  .sd-hero-main-row {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 22px;
  }

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
    text-decoration: none;
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

  /* Quick Actions Row on Hero (Masaüstünde Gizli - Yalnızca Mobilde Görünür) */
  .sd-hero-actions-row {
    display: none !important;
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

  /* --- Analytics Card (Sleek SaaS Metrics Widget) --- */
  .sd-analytics-section {
    background: var(--sd-surface);
    padding: 20px 24px;
    border-bottom: 1px solid var(--sd-border);
  }

  .sd-analytics-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    gap: 12px;
    flex-wrap: wrap;
  }

  .sd-analytics-title-group {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sd-analytics-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
  }

  .sd-analytics-title {
    font-size: 15.5px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0;
  }

  .sd-analytics-subtitle {
    font-size: 12px;
    color: var(--sd-text-muted);
    margin: 2px 0 0;
  }

  .sd-analytics-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  /* --- Pop-up Dropdowns for Analytics Filters (Matching Sort Popup) --- */
  .sd-filter-wrapper {
    position: relative;
    display: inline-block;
  }

  .sd-filter-trigger-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 38px;
    padding: 0 14px;
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-sm);
    color: var(--sd-text-main);
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    user-select: none;
    white-space: nowrap;
  }

  .sd-filter-trigger-btn:hover {
    border-color: var(--sd-primary);
    color: var(--sd-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
  }

  .sd-filter-trigger-btn.is-active,
  .sd-filter-trigger-btn[aria-expanded="true"] {
    border-color: var(--sd-primary);
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
  }

  .sd-filter-icon {
    font-size: 13.5px;
    color: var(--sd-primary);
  }

  .sd-filter-chevron {
    font-size: 10.5px;
    color: var(--sd-text-muted);
    transition: transform 0.2s ease;
  }

  .sd-filter-trigger-btn[aria-expanded="true"] .sd-filter-chevron {
    transform: rotate(180deg);
  }

  .sd-filter-popup {
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    min-width: 220px;
    width: max-content;
    max-width: 320px;
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

  .sd-filter-popup.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
    pointer-events: auto;
  }

  .sd-filter-popup-header {
    padding: 6px 10px 8px;
    border-bottom: 1px solid var(--sd-border);
    margin-bottom: 4px;
  }

  .sd-filter-popup-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--sd-text-muted);
  }

  .sd-filter-scroll-list {
    max-height: 240px;
    overflow-y: auto;
    overscroll-behavior: contain;
  }

  .sd-sort-option-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 12px;
    border-radius: var(--sd-radius-sm);
    color: var(--sd-text-main);
    background: transparent;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
    font-size: 13.5px;
    font-weight: 500;
    gap: 8px;
  }

  .sd-check-icon {
    font-size: 12px;
    color: var(--sd-primary);
    flex-shrink: 0;
  }

  /* Backdrop for Mobile Popups */
  .sd-popup-backdrop {
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

  .sd-popup-backdrop.show {
    display: block;
    opacity: 1;
  }

  body.dark .sd-popup-backdrop {
    background: rgba(0, 0, 0, 0.7);
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

  .sd-analytics-grid {
    position: relative;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 14px;
  }

  .sd-stat-box {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 16px;
    position: relative;
    transition: all 0.2s;
  }

  .sd-stat-box.loading {
    opacity: 0.6;
  }

  .sd-stat-box-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--sd-text-muted);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .sd-stat-box-val {
    font-size: 26px;
    font-weight: 800;
    color: var(--sd-text-main);
    line-height: 1.1;
    margin-bottom: 8px;
    letter-spacing: -0.5px;
  }

  .sd-stat-box-sub {
    font-size: 12px;
    color: var(--sd-text-muted);
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .sd-change-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-weight: 700;
    font-size: 11.5px;
    padding: 2px 6px;
    border-radius: 6px;
  }

  .sd-change-up {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
  }

  .sd-change-down {
    background: rgba(239, 68, 68, 0.12);
    color: #ef4444;
  }

  /* Blur Overlay for Non-Pro Users */
  .sd-analytics-pro-overlay {
    position: absolute;
    inset: -6px;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    background: rgba(255, 255, 255, 0.7);
    border-radius: var(--sd-radius-md);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px;
    text-align: center;
    z-index: 5;
  }

  body.dark .sd-analytics-pro-overlay {
    background: rgba(24, 24, 27, 0.75);
  }

  .sd-pro-badge-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 8px;
    box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
  }

  .sd-pro-title {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin-bottom: 4px;
  }

  .sd-pro-desc {
    font-size: 12.5px;
    color: var(--sd-text-muted);
    max-width: 320px;
    margin-bottom: 12px;
  }

  /* --- Tabs Card (Masaüstünde Tek Birleşik Kart Görünümü) --- */
  .sd-tabs-card {
    background: var(--sd-surface);
    border: none;
    box-shadow: none;
    border-radius: 0;
    overflow: visible;
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

  /* --- Tab 1: Hizmetler Header & Sorting & Add Button --- */
  .sd-tab-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
  }

  .sd-tab-title {
    font-size: 16.5px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0;
  }

  .sd-tab-actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

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

  /* --- Company Owner Service Cards Grid --- */
  .sd-owner-service-card {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    overflow: hidden;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
  }

  .sd-owner-service-card:hover {
    border-color: var(--sd-primary);
    transform: translateY(-2px);
    box-shadow: 0 10px 24px -4px rgba(15, 23, 42, 0.08);
  }

  .sd-card-img-wrap {
    position: relative;
    height: 180px;
    background: #e2e8f0;
    overflow: hidden;
  }

  .sd-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .sd-owner-service-card:hover .sd-card-img {
    transform: scale(1.04);
  }

  .sd-status-pill {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
  }

  .sd-status-active {
    background: #10b981;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
  }

  .sd-status-passive {
    background: #64748b;
    color: #ffffff;
  }

  /* Kebab Actions on Image Top-Right */
  .sd-kebab-menu {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 3;
  }

  .sd-kebab-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0,0,0,0.08);
    color: #0f172a;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: all 0.2s;
  }

  .sd-kebab-btn:hover {
    background: #ffffff;
    transform: scale(1.05);
  }

  .sd-kebab-dropdown {
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    min-width: 160px;
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-sm);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    padding: 6px;
    display: none;
    z-index: 10;
  }

  .sd-kebab-dropdown.show {
    display: block;
  }

  .sd-kebab-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 500;
    color: var(--sd-text-main);
    text-decoration: none;
    border-radius: 6px;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
    cursor: pointer;
    transition: background 0.15s;
  }

  .sd-kebab-item:hover {
    background: var(--sd-bg);
  }

  .sd-kebab-item.text-danger:hover {
    background: rgba(239, 68, 68, 0.1);
  }

  .sd-card-body {
    padding: 14px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .sd-card-title {
    font-size: 14.5px;
    font-weight: 700;
    line-height: 1.35;
    margin: 0 0 8px 0;
  }

  .sd-card-title a {
    color: var(--sd-text-main);
    text-decoration: none;
    transition: color 0.2s;
  }

  .sd-card-title a:hover {
    color: var(--sd-primary);
  }

  .sd-card-tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
  }

  .sd-tag-mini {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: var(--sd-text-muted);
    background: var(--sd-bg);
    padding: 2px 7px;
    border-radius: 5px;
    border: 1px solid var(--sd-border);
  }

  .sd-tag-mini i {
    font-size: 10.5px;
    color: var(--sd-primary);
  }

  .sd-card-views {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: var(--sd-text-muted);
    margin-bottom: 12px;
  }

  .sd-card-views i {
    font-size: 13px;
  }

  .sd-card-footer {
    margin-top: auto;
    padding-top: 10px;
    border-top: 1px dashed var(--sd-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .sd-card-price-group {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .sd-card-price {
    font-size: 16px;
    font-weight: 700;
    color: var(--sd-primary);
  }

  .sd-card-price small {
    font-size: 12px;
    font-weight: 600;
    color: var(--sd-text-muted);
  }

  .sd-payment-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 7px;
    border-radius: 5px;
    background: var(--sd-bg);
    color: var(--sd-text-muted);
    border: 1px solid var(--sd-border);
  }

  /* --- Tab 2: Sorular (Customer Questions) --- */
  .sd-q-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .sd-q-card {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 18px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    transition: border-color 0.2s;
  }

  .sd-q-card:hover {
    border-color: var(--sd-primary);
  }

  .sd-q-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    gap: 12px;
  }

  .sd-q-user {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sd-q-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid var(--sd-border);
  }

  .sd-q-author {
    font-size: 14px;
    font-weight: 700;
    color: var(--sd-text-main);
    display: block;
    line-height: 1.2;
  }

  .sd-q-date {
    font-size: 12px;
    color: var(--sd-text-muted);
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 3px;
  }

  .sd-q-meta-right {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sd-q-service-badge {
    font-size: 12px;
    font-weight: 600;
    color: var(--sd-primary);
    background: var(--sd-primary-soft);
    padding: 4px 10px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    max-width: 240px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sd-q-delete-btn {
    background: transparent;
    border: none;
    color: #ef4444;
    cursor: pointer;
    font-size: 14px;
    padding: 6px;
    border-radius: 6px;
    transition: background 0.2s;
  }

  .sd-q-delete-btn:hover {
    background: rgba(239, 68, 68, 0.1);
  }

  .sd-q-text-bubble {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-sm);
    padding: 12px 16px;
    font-size: 13.5px;
    line-height: 1.5;
    color: var(--sd-text-main);
    margin-bottom: 14px;
  }

  .sd-q-existing-answer {
    background: rgba(16, 185, 129, 0.08);
    border: 1px solid rgba(16, 185, 129, 0.25);
    border-radius: var(--sd-radius-sm);
    padding: 12px 16px;
    margin-bottom: 14px;
  }

  .sd-q-answer-title {
    font-size: 12px;
    font-weight: 700;
    color: #10b981;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .sd-q-answer-body {
    font-size: 13.5px;
    color: var(--sd-text-main);
    margin: 0;
  }

  .sd-q-form-area {
    margin-top: 10px;
  }

  .sd-q-textarea {
    width: 100%;
    padding: 10px 14px;
    border-radius: var(--sd-radius-sm);
    border: 1px solid var(--sd-border);
    background: var(--sd-bg);
    color: var(--sd-text-main);
    font-size: 13.5px;
    outline: none;
    resize: vertical;
    min-height: 70px;
    margin-bottom: 8px;
    transition: border-color 0.2s;
  }

  .sd-q-textarea:focus {
    border-color: var(--sd-primary);
  }

  /* --- Tab 3: Değerlendirmeler (Reviews) --- */
  .sd-reviews-summary {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: var(--sd-bg);
    border-radius: var(--sd-radius-md);
    border: 1px solid var(--sd-border);
    margin-bottom: 24px;
    flex-wrap: wrap;
  }

  .sd-rating-big {
    font-size: 44px;
    font-weight: 800;
    color: var(--sd-text-main);
    line-height: 1;
    letter-spacing: -1px;
  }

  .sd-rating-stars-wrap {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .sd-stars {
    display: flex;
    gap: 4px;
    color: #f59e0b;
    font-size: 16px;
  }

  .sd-rating-subtext {
    font-size: 13px;
    color: var(--sd-text-muted);
  }

  .sd-review-card {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 18px 20px;
    margin-bottom: 14px;
    transition: all 0.2s ease;
  }

  .sd-review-card:hover {
    border-color: var(--sd-primary);
  }

  .sd-review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }

  .sd-reviewer {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .sd-reviewer-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid var(--sd-border);
  }

  .sd-reviewer-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0;
  }

  .sd-review-date {
    font-size: 12px;
    color: var(--sd-text-muted);
  }

  .sd-review-score {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  .sd-review-comment {
    font-size: 13.5px;
    color: var(--sd-text-main);
    line-height: 1.5;
    margin: 0;
  }

  .sd-review-service-thumb {
    margin-top: 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 4px 8px;
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: 6px;
    font-size: 12px;
    color: var(--sd-text-muted);
  }

  .sd-review-service-thumb img {
    width: 30px;
    height: 30px;
    border-radius: 4px;
    object-fit: cover;
  }

  /* --- Tab 4 & 5: Takipçi & Takip Edilenler --- */
  .sd-search-bar {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }

  .sd-search-input-wrap {
    position: relative;
    max-width: 320px;
    width: 100%;
  }

  .sd-search-input {
    width: 100%;
    padding: 8px 36px 8px 14px;
    border-radius: var(--sd-radius-sm);
    border: 1px solid var(--sd-border);
    background: var(--sd-bg);
    color: var(--sd-text-main);
    font-size: 13.5px;
    outline: none;
    transition: border-color 0.2s;
  }

  .sd-search-input:focus {
    border-color: var(--sd-primary);
  }

  .sd-search-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: var(--sd-text-muted);
    cursor: pointer;
  }

  .sd-user-card {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    transition: all 0.2s;
  }

  .sd-user-card:hover {
    border-color: var(--sd-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
  }

  .sd-user-card-info {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
  }

  .sd-user-card-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid var(--sd-border);
    flex-shrink: 0;
  }

  .sd-user-card-name {
    font-size: 14px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sd-user-card-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }

  /* --- Right Column: Sticky Sidebar (Desktop Only) --- */
  .sd-sidebar {
    position: sticky;
    top: 20px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .sd-action-card,
  .sd-verified-status-card,
  .sd-profile-stats-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 20px;
  }

  .sd-sidebar-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .sd-btn-group-vertical {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .sd-btn-primary,
  .sd-btn-outline,
  .sd-btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    height: 44px;
    padding: 0 16px;
    border-radius: var(--sd-radius-sm);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-sizing: border-box;
    border: 1px solid transparent;
  }

  .sd-btn-primary {
    background: var(--sd-primary);
    color: #ffffff !important;
    border-color: var(--sd-primary);
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
  }

  .sd-btn-primary:hover {
    background: var(--sd-primary-hover);
    border-color: var(--sd-primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(37, 99, 235, 0.28);
  }

  .sd-btn-outline {
    background: var(--sd-surface);
    color: var(--sd-primary) !important;
    border-color: var(--sd-primary);
  }

  .sd-btn-outline:hover {
    background: var(--sd-primary-soft);
    transform: translateY(-1px);
  }

  .sd-btn-secondary {
    background: var(--sd-bg);
    color: var(--sd-text-main) !important;
    border-color: var(--sd-border);
  }

  .sd-btn-secondary:hover {
    background: var(--sd-border);
    transform: translateY(-1px);
  }

  /* Verified Status Card */
  .sd-verified-status-card {
    display: flex;
    align-items: flex-start;
    gap: 14px;
  }

  .sd-ver-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .sd-ver-active {
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
  }

  .sd-ver-pending {
    background: rgba(245, 158, 11, 0.12);
    color: #f59e0b;
  }

  .sd-ver-unverified {
    background: rgba(100, 116, 139, 0.12);
    color: #64748b;
  }

  .sd-ver-body {
    flex: 1;
    min-width: 0;
  }

  .sd-ver-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin: 0 0 4px 0;
  }

  .sd-ver-desc {
    font-size: 12px;
    color: var(--sd-text-muted);
    margin: 0 0 10px 0;
    line-height: 1.4;
  }

  .sd-ver-link {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--sd-primary);
    text-decoration: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }

  .sd-ver-link:hover {
    text-decoration: underline;
  }

  /* Profile Stats Card */
  .sd-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .sd-stat-item {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-sm);
    padding: 12px;
    text-align: center;
  }

  .sd-stat-item-val {
    font-size: 18px;
    font-weight: 800;
    color: var(--sd-text-main);
    line-height: 1.1;
    margin-bottom: 3px;
  }

  .sd-stat-item-label {
    font-size: 11.5px;
    color: var(--sd-text-muted);
    font-weight: 600;
  }

  /* --- Modern Pagination --- */
  .sd-pagination-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid var(--sd-border);
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
    margin-bottom: 12px;
  }

  .sd-empty-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--sd-text-main);
    margin-bottom: 6px;
  }

  /* --- Mobile Floating Topbar & Sticky Bottom Bar --- */
  .sd-mobile-top-nav,
  .sd-mobile-sticky-bar {
    display: none;
  }

  /* ==========================================================================
     Mobile Responsive Breakpoint (<= 991px)
     Matches Public Profile (show.blade.php) Exactly
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

    .sd-topbar {
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
      background: var(--sd-bg) !important;
    }

    .sd-main-grid {
      display: flex !important;
      flex-direction: column !important;
      gap: 0 !important;
      width: 100% !important;
    }

    .sd-left-col,
    .sd-sidebar {
      display: contents !important;
    }

    .sd-left-col {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      border-radius: 0 !important;
      overflow: visible !important;
    }

    /* Company Hero Card on Mobile (normal firma profili ile birebir) */
    .sd-company-hero-card {
      order: 1 !important;
      border-radius: 0 !important;
      border: none !important;
      border-bottom: none !important;
      margin: 0 !important;
      box-shadow: none !important;
      background: var(--sd-surface) !important;
    }

    /* Floating Safe-Area Top Nav for Mobile (Matches show.blade.php) */
    .sd-mobile-top-nav {
      display: flex !important;
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
      width: 38px !important;
      height: 38px !important;
      border-radius: 50% !important;
      background: rgba(15, 23, 42, 0.65) !important;
      backdrop-filter: blur(8px) !important;
      -webkit-backdrop-filter: blur(8px) !important;
      border: 1px solid rgba(255, 255, 255, 0.25) !important;
      color: #fff !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      font-size: 15px !important;
      text-decoration: none !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      padding: 0 !important;
    }

    .sd-mob-circle-btn:active {
      transform: scale(0.92) !important;
    }

    .sd-hero-banner {
      height: 80px !important;
    }

    .sd-hero-content {
      padding: 12px 14px 8px !important;
    }

    .sd-hero-content:has(.sd-hero-social-row) {
      padding-bottom: 4px !important;
    }

    /* Mobile Hero Grid Layout (normal firma profili ile birebir) */
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
      grid-area: logo !important;
      margin-top: -36px !important;
      margin-bottom: 0 !important;
      flex-shrink: 0 !important;
    }

    .sd-hero-avatar {
      width: 72px !important;
      height: 72px !important;
      border-radius: 16px !important;
      border: 3px solid var(--sd-surface) !important;
    }

    .sd-hero-info-col {
      display: contents !important;
    }

    .sd-hero-title-row {
      grid-area: title !important;
      display: flex !important;
      align-items: center !important;
      gap: 6px !important;
      margin-bottom: 0 !important;
    }

    .sd-hero-title {
      font-size: 1.05rem !important;
      font-weight: 700 !important;
      line-height: 1.25 !important;
      margin: 0 !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
    }

    .sd-hero-verified-inline {
      width: 17px !important;
      height: 17px !important;
      flex-shrink: 0 !important;
    }

    /* Mobile Badges Strip (Horizontal Scroll / Sağa Sola Kaydırılır - normal firma profili ile birebir) */
    .sd-hero-badges-row {
      grid-area: badges !important;
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

    /* Quick action butonları mobilde de alt menüye taşındığı için hero kartı temiz görünür */
    .sd-hero-actions-row {
      display: none !important;
    }

    /* Social row centered on mobile */
    .sd-hero-social-row {
      grid-area: social !important;
      display: flex !important;
      justify-content: center !important;
      align-items: center !important;
      gap: 10px !important;
      margin-top: 6px !important;
      margin-bottom: 6px !important;
      padding: 0 !important;
      border: none !important;
      width: 100% !important;
    }

    .sd-social-btn {
      width: 32px !important;
      height: 32px !important;
      font-size: 13px !important;
    }

    /* Analytics on mobile (Firma adının bulunduğu kart ile bitişik, boşluksuz ve bordersız) */
    .sd-analytics-section {
      order: 2 !important;
      width: 100% !important;
      max-width: 100% !important;
      box-sizing: border-box !important;
      padding: 6px 14px 14px 14px !important;
      background: var(--sd-surface) !important;
      margin: 0 !important;
      border-radius: 0 !important;
      border: none !important;
      border-top: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
    }

    .sd-analytics-header {
      width: 100% !important;
      box-sizing: border-box !important;
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 10px !important;
      margin-bottom: 12px !important;
    }

    .sd-analytics-title-group {
      width: 100% !important;
    }

    .sd-analytics-controls {
      width: 100% !important;
      box-sizing: border-box !important;
      display: flex !important;
      gap: 8px !important;
    }

    .sd-filter-wrapper {
      flex: 1 1 0 !important;
      min-width: 0 !important;
      width: 50% !important;
    }

    .sd-filter-trigger-btn {
      width: 100% !important;
      box-sizing: border-box !important;
      justify-content: space-between !important;
      padding: 0 10px !important;
      font-size: 12px !important;
      height: 35px !important;
    }

    .sd-filter-btn-text {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      font-size: 11.5px !important;
    }

    .sd-analytics-grid {
      width: 100% !important;
      box-sizing: border-box !important;
      display: grid !important;
      grid-template-columns: repeat(2, 1fr) !important;
      gap: 10px !important;
    }

    .sd-stat-box {
      width: 100% !important;
      box-sizing: border-box !important;
      min-width: 0 !important;
      padding: 12px 10px !important;
      border-radius: 10px !important;
    }

    .sd-stat-box-title {
      font-size: 11.5px !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      gap: 5px !important;
      margin-bottom: 4px !important;
    }

    .sd-stat-box-val {
      font-size: 20px !important;
      font-weight: 800 !important;
      margin-bottom: 4px !important;
      line-height: 1.1 !important;
    }

    .sd-stat-box-sub {
      font-size: 10.5px !important;
      flex-wrap: wrap !important;
      gap: 3px !important;
      line-height: 1.2 !important;
    }

    .sd-change-pill {
      font-size: 10px !important;
      padding: 2px 5px !important;
    }

    .sd-filter-popup,
    .sd-sort-popup {
      position: fixed !important;
      top: auto !important;
      bottom: 0 !important;
      left: 0 !important;
      right: 0 !important;
      width: 100% !important;
      max-width: 100% !important;
      border-radius: 20px 20px 0 0 !important;
      padding: 16px 16px calc(16px + env(safe-area-inset-bottom, 0px)) !important;
      transform: translateY(100%) !important;
      box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.25) !important;
      z-index: 100001 !important;
      transform-origin: bottom center !important;
      box-sizing: border-box !important;
    }

    .sd-filter-popup.show,
    .sd-sort-popup.show {
      transform: translateY(0) !important;
    }

    /* Mobile Sayfalama */
    .sd-modern-pagination-wrapper {
      justify-content: center !important;
      padding-top: 18px !important;
      margin-top: 18px !important;
    }

    .sd-pagination-list {
      gap: 4px !important;
      justify-content: center !important;
    }

    .sd-page-btn {
      min-width: 34px !important;
      height: 34px !important;
      padding: 0 8px !important;
      font-size: 12.5px !important;
      border-radius: 8px !important;
    }

    .sd-page-prev,
    .sd-page-next {
      padding: 0 10px !important;
    }

    /* Tabs Card on Mobile */
    .sd-tabs-card {
      order: 3 !important;
      margin: 10px 0 0 0 !important;
      padding: 0 !important;
      width: 100% !important;
      background: var(--sd-surface) !important;
      border-radius: 0 !important;
      border: none !important;
      border-top: 1px solid var(--sd-border) !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
    }

    /* Mobile Tabs (Horizontal Scroll / Sağa Sola Kaydırılır - normal firma profili ile birebir) */
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
      padding: 16px 12px !important;
    }

    /* Sorting button on mobile */
    .sd-sort-trigger-btn {
      width: 31px !important;
      height: 31px !important;
      border-radius: 6px !important;
    }

    .sd-sort-icon {
      font-size: 12.5px !important;
    }

    .sd-sidebar {
      display: none !important;
    }

    /* Sitenin genel sabit alt menüsünü gizle ki çakışma olmasın (normal firma profili ile birebir) */
    body .mobile-fixed-menu {
      display: none !important;
    }

    /* Mobile Sticky Bottom Bar (Exact 55px height matching visitor profile) */
    .sd-mobile-sticky-bar {
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      gap: 8px !important;
      position: fixed !important;
      bottom: 0 !important;
      left: 0 !important;
      right: 0 !important;
      width: 100% !important;
      height: 55px !important;
      padding: 0 12px !important;
      background: #ffffff !important;
      background: var(--sd-surface, #ffffff) !important;
      border-top: 1px solid #e2e8f0 !important;
      border-top: 1px solid var(--sd-border, #e2e8f0) !important;
      box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.08) !important;
      z-index: 99999 !important;
      box-sizing: border-box !important;
    }

    body.dark .sd-mobile-sticky-bar {
      background: #18181b !important;
      background: var(--sd-surface, #18181b) !important;
      border-top-color: #27272a !important;
      border-top-color: var(--sd-border, #27272a) !important;
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

    .sd-mob-bar-btn.sd-btn-primary {
      background: var(--sd-primary) !important;
      color: #ffffff !important;
      border: 1.5px solid var(--sd-primary) !important;
    }

    .sd-mob-bar-btn.sd-btn-secondary {
      background: var(--sd-bg) !important;
      color: var(--sd-text-main) !important;
      border: 1.5px solid var(--sd-border) !important;
    }
  }
</style>
@endsection

@section('content')
@php
  use App\Models\ProPackageCategory;

  $company = auth()->user()->company;
  $hasEplanPreview = false;

  if ($company) {
      $latestPackage = $company->latestActivePackage();
      if ($latestPackage) {
          $hasEplanPreview = ProPackageCategory::where('pro_package_id', $latestPackage->id)
              ->where('eplan_preview', 1)
              ->exists();
      }   
  }
@endphp

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
            <li class="sd-bc-current">{{ $company->name }} (Yönetim Paneli)</li>
          </ul>
        </div>

        <!-- Main Two-Column Layout -->
        <div class="sd-main-grid">

          <!-- Left Column: Hero Card, Analytics & Tabs -->
          <div class="sd-left-col">

            <!-- 1. Company Hero Card -->
            <div class="sd-company-hero-card">

              <!-- Mobile Floating Top Nav Controls (Matches show.blade.php) -->
              <div class="sd-mobile-top-nav">
                <div class="sd-mob-nav-group">
                  <a href="javascript:history.back()" onclick="if (history.length > 1) { history.back(); } else { window.location.href = '{{ route('site.home') }}'; } return false;" class="sd-mob-circle-btn" aria-label="Geri">
                    <i class="fa-solid fa-arrow-left"></i>
                  </a>
                </div>
                <div class="sd-mob-nav-group">
                  <a href="{{ route('companies.show', $company->slug) }}" target="_blank" class="sd-mob-circle-btn" aria-label="Önizle" title="Profili Önizle">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </a>
                  <button type="button" class="sd-mob-circle-btn share-btn" aria-label="Paylaş" title="Paylaş">
                    <i class="fa-solid fa-share-nodes"></i>
                  </button>
                </div>
              </div>

              <!-- Cover Banner -->
              <div class="sd-hero-banner {{ $company->cover_photo ? 'has-cover' : '' }}"></div>

              <!-- Hero Content Body -->
              <div class="sd-hero-content">
                <div class="sd-hero-main-row">

                  <!-- En Solda: Logo -->
                  <div class="sd-hero-logo-col">
                    <div class="sd-hero-avatar-wrapper">
                      @php
                        $avatarUrl = $company->avatar ? asset($company->avatar) : asset('site/images/default-avatar.png');
                      @endphp
                      <img src="{{ $avatarUrl }}" alt="{{ $company->name }}" class="sd-hero-avatar">
                    </div>
                  </div>

                  <!-- Yanında: Başlık, Rozet, Etiketler ve Sosyal Medya -->
                  <div class="sd-hero-info-col">
                    <div class="sd-hero-title-row">
                      <h1 class="sd-hero-title">{{ $company->name }}</h1>

                      @if($company->is_verified == 0)
                        <a href="javascript:void(0)" class="sd-hero-verified-inline" data-bs-toggle="modal" data-bs-target="#onayliprofilol" title="Onaylı Profil Başvurusu Yap">
                          <img src="{{ asset('site/images/success.png') }}" alt="Onaylı Profil Ol" style="filter: grayscale(1); opacity: 0.6;">
                        </a>
                      @elseif($company->is_verified == 1)
                        <a href="javascript:void(0)" class="sd-hero-verified-inline" data-bs-toggle="modal" data-bs-target="#onayliprofildurum" title="Onaylı Firma (Detay için tıklayın)">
                          <img src="{{ asset('site/images/success.png') }}" alt="Onaylı">
                        </a>
                      @elseif($company->is_verified == 2)
                        <span class="badge bg-warning text-dark" style="font-size: 11px;">İnceleniyor</span>
                      @endif
                    </div>

                    <!-- Badges Row -->
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

                      @if($totalRatings > 0)
                        <span class="sd-badge-pill sd-rating-badge">
                          <i class="fa-solid fa-star"></i>
                          <span>{{ number_format($averageRating, 1) }} ({{ $totalRatings }} Değerlendirme)</span>
                        </span>
                      @endif
                    </div>

                    <!-- Mobile Quick Action Buttons on Hero (Hidden on Desktop via CSS) -->
                    <div class="sd-hero-actions-row">
                      <a href="{{ route('company.profile.edit') }}" class="sd-hero-btn sd-hero-btn-outline">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>Profili Düzenle</span>
                      </a>

                      @if($company->latestActivePackage())
                        <a href="{{ route('company.subscriptions.index') }}" class="sd-hero-btn sd-hero-btn-primary">
                          <i class="fa-solid fa-crown"></i>
                          <span>Aboneliğim</span>
                        </a>
                      @else
                        <a href="{{ route('company.packages.index') }}" class="sd-hero-btn sd-hero-btn-primary">
                          <i class="fa-solid fa-crown"></i>
                          <span>Pro Üye Ol</span>
                        </a>
                      @endif

                      @if($hasEplanPreview)
                        <a href="{{ route('company.eplan') }}" class="sd-hero-btn sd-hero-btn-outline">
                          <i class="fa-solid fa-house-circle-check"></i>
                          <span>E-Plan</span>
                        </a>
                      @endif
                    </div>

                    <!-- Social Media Links -->
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

            <!-- 2. Analytics Section (Modern SaaS Metrikleri) -->
            <div class="sd-analytics-section">
              <div class="sd-analytics-header">
                <div class="sd-analytics-title-group">
                  <div class="sd-analytics-icon">
                    <i class="fa-solid fa-chart-line"></i>
                  </div>
                  <div>
                    <h3 class="sd-analytics-title">Firma & Hizmet Analizleri</h3>
                    <p class="sd-analytics-subtitle">Ziyaretçi ve görüntülenme raporları</p>
                  </div>
                </div>

                @if($company->purchasedPackages->isNotEmpty())
                  <div class="sd-analytics-controls">
                    @php
                      $selectedServiceId = request()->service ?? '';
                      $selectedServiceTitle = 'Tüm Hizmetler';
                      if ($selectedServiceId) {
                          $matchedService = $services->firstWhere('id', $selectedServiceId);
                          if ($matchedService) {
                              $selectedServiceTitle = str()->limit($matchedService->title, 26);
                          }
                      }

                      $selectedDay = request()->day && in_array(request()->day, [1, 7, 30, 90]) ? request()->day : 1;
                      $dayLabels = [
                        1 => 'Son 24 Saat',
                        7 => 'Son 7 Gün',
                        30 => 'Son 30 Gün',
                        90 => 'Son 90 Gün',
                      ];
                      $selectedDayTitle = $dayLabels[$selectedDay] ?? 'Son 24 Saat';
                    @endphp

                    <!-- 1. Hizmet Filtresi Pop-up -->
                    <div class="sd-filter-wrapper" id="serviceFilterWrapper">
                      <button type="button" class="sd-filter-trigger-btn" id="serviceFilterBtn" aria-expanded="false" aria-haspopup="true">
                        <i class="fa-solid fa-layer-group sd-filter-icon"></i>
                        <span class="sd-filter-btn-text" id="serviceFilterBtnText">{{ $selectedServiceTitle }}</span>
                        <i class="fa-solid fa-chevron-down sd-filter-chevron"></i>
                      </button>

                      <div class="sd-filter-popup" id="serviceFilterPopup" role="menu">
                        <input type="hidden" name="service" id="serviceFilter" value="{{ $selectedServiceId }}">
                        <div class="sd-filter-popup-header">
                          <span class="sd-filter-popup-title">Hizmet Filtresi</span>
                        </div>
                        <div class="sd-sort-options-list sd-filter-scroll-list">
                          <div class="sd-sort-option-item {{ empty($selectedServiceId) ? 'is-selected' : '' }}" data-value="" role="menuitem">
                            <span class="sd-sort-option-name">Tüm Hizmetler</span>
                            <i class="fa-solid fa-check sd-check-icon {{ empty($selectedServiceId) ? '' : 'd-none' }}"></i>
                          </div>
                          @foreach($services as $s)
                            @php $isSel = ($selectedServiceId == $s->id); @endphp
                            <div class="sd-sort-option-item {{ $isSel ? 'is-selected' : '' }}" data-value="{{ $s->id }}" role="menuitem" title="{{ $s->title }}">
                              <span class="sd-sort-option-name">{{ str()->limit($s->title, 32) }}</span>
                              <i class="fa-solid fa-check sd-check-icon {{ $isSel ? '' : 'd-none' }}"></i>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    </div>

                    <!-- 2. Tarih Filtresi Pop-up -->
                    <div class="sd-filter-wrapper" id="dayFilterWrapper">
                      <button type="button" class="sd-filter-trigger-btn" id="dayFilterBtn" aria-expanded="false" aria-haspopup="true">
                        <i class="fa-regular fa-calendar-days sd-filter-icon"></i>
                        <span class="sd-filter-btn-text" id="dayFilterBtnText">{{ $selectedDayTitle }}</span>
                        <i class="fa-solid fa-chevron-down sd-filter-chevron"></i>
                      </button>

                      <div class="sd-filter-popup" id="dayFilterPopup" role="menu">
                        <input type="hidden" name="day" id="dayFilter" value="{{ $selectedDay }}">
                        <div class="sd-filter-popup-header">
                          <span class="sd-filter-popup-title">Zaman Aralığı</span>
                        </div>
                        <div class="sd-sort-options-list">
                          @foreach($dayLabels as $dVal => $dLabel)
                            @php $isDaySel = ($selectedDay == $dVal); @endphp
                            <div class="sd-sort-option-item {{ $isDaySel ? 'is-selected' : '' }}" data-value="{{ $dVal }}" role="menuitem">
                              <span class="sd-sort-option-name">{{ $dLabel }}</span>
                              <i class="fa-solid fa-check sd-check-icon {{ $isDaySel ? '' : 'd-none' }}"></i>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              </div>

              <!-- Stat Boxes Grid -->
              <div class="sd-analytics-grid">
                <!-- Profil Ziyaretleri -->
                <div class="sd-stat-box">
                  <div class="sd-stat-box-title">
                    <i class="fa-regular fa-building text-primary"></i>
                    <span>Profil Ziyareti</span>
                  </div>
                  <div class="sd-stat-box-val" id="profileCurrentCount">{{ $profileCurrentCount }}</div>
                  <div class="sd-stat-box-sub">
                    <span id="profilePercentage">
                      @php
                        $pChange = analytic_percentage_change($profileOldCount, $profileCurrentCount);
                      @endphp
                      @if($pChange >= 0)
                        <span class="sd-change-pill sd-change-up"><i class="fa-solid fa-arrow-up"></i> +{{ $pChange }}%</span>
                      @else
                        <span class="sd-change-pill sd-change-down"><i class="fa-solid fa-arrow-down"></i> {{ $pChange }}%</span>
                      @endif
                    </span>
                    <span>önceki döneme göre</span>
                  </div>
                </div>

                <!-- Hizmet Ziyaretleri -->
                <div class="sd-stat-box">
                  <div class="sd-stat-box-title">
                    <i class="fa-solid fa-handshake text-primary"></i>
                    <span>Hizmetler Ziyareti</span>
                  </div>
                  <div class="sd-stat-box-val" id="serviceCurrentCount">{{ $serviceCurrentCount }}</div>
                  <div class="sd-stat-box-sub">
                    <span id="servicePercentage">
                      @php
                        $sChange = analytic_percentage_change($serviceOldCount, $serviceCurrentCount);
                      @endphp
                      @if($sChange >= 0)
                        <span class="sd-change-pill sd-change-up"><i class="fa-solid fa-arrow-up"></i> +{{ $sChange }}%</span>
                      @else
                        <span class="sd-change-pill sd-change-down"><i class="fa-solid fa-arrow-down"></i> {{ $sChange }}%</span>
                      @endif
                    </span>
                    <span>önceki döneme göre</span>
                  </div>
                </div>

                <!-- Non-Pro Teaser Overlay -->
                @if($company->purchasedPackages->isEmpty())
                  <div class="sd-analytics-pro-overlay">
                    <div class="sd-pro-badge-icon">
                      <i class="fa-solid fa-crown"></i>
                    </div>
                    <div class="sd-pro-title">Detaylı İstatistikler & Raporlar</div>
                    <p class="sd-pro-desc">Hizmet dönüşüm oranları, profil ziyaret grafikleri ve detaylı analizler için Pro Üyeliğe geçin.</p>
                    <a href="{{ route('company.packages.index') }}" class="sd-btn-primary" style="height: 38px; width: auto; padding: 0 20px; font-size: 13.5px;">
                      <i class="fa-solid fa-bolt"></i>
                      <span>Pro Paketleri İncele</span>
                    </a>
                  </div>
                @endif
              </div>
            </div>

            <!-- 3. Tabs Card (İkonsuz Sekme Başlıkları) -->
            <div class="sd-tabs-card">
              <ul class="sd-nav-tabs nav nav-tabs" id="myTab" role="tablist">
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                    <span>Hizmetler</span>
                    <span class="sd-tab-count">{{ $serviceCount }}</span>
                  </button>
                </li>
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                    <span>Sorular</span>
                    <span class="sd-tab-count">{{ $questions->total() }}</span>
                  </button>
                </li>
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                    <span>Değerlendirmeler</span>
                    <span class="sd-tab-count">{{ $totalRatings }}</span>
                  </button>
                </li>
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link" id="takipci-tab" data-bs-toggle="tab" data-bs-target="#takipci" type="button" role="tab" aria-controls="takipci" aria-selected="false">
                    <span>Takipçiler</span>
                    <span class="sd-tab-count">{{ $followersCount }}</span>
                  </button>
                </li>
                <li class="sd-nav-item" role="presentation">
                  <button class="sd-nav-link" id="takipedilen-tab" data-bs-toggle="tab" data-bs-target="#takipedilen" type="button" role="tab" aria-controls="takipedilen" aria-selected="false">
                    <span>Takip Edilen</span>
                    <span class="sd-tab-count">{{ $followingsCount }}</span>
                  </button>
                </li>
              </ul>

              <!-- Tabs Content -->
              <div class="tab-content sd-tab-content" id="myTabContent">

                <!-- 1. HİZMETLER TAB -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="sd-tab-header justify-content-end">
                    <div class="sd-tab-actions">
                      <!-- Sıralama Pop-up Menüsü -->
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

                        <div class="sd-sort-popup" id="sortPopup" role="menu">
                          <form action="{{ url()->current() }}" method="GET" id="sortServicesForm" class="m-0">
                            @foreach(request()->except(['order_by', 'page', 'services_page']) as $k => $v)
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
                                $sortOpts = [
                                  ['value' => '',           'label' => 'Standart Sıralama'],
                                  ['value' => 'price_asc',  'label' => 'Fiyata Göre (Artan)'],
                                  ['value' => 'price_desc', 'label' => 'Fiyata Göre (Azalan)'],
                                  ['value' => 'date_desc',  'label' => 'Tarihe Göre (En Yeni)'],
                                  ['value' => 'date_asc',   'label' => 'Tarihe Göre (En Eski)'],
                                ];
                              @endphp
                              @foreach($sortOpts as $opt)
                                <div class="sd-sort-option-item {{ $currentSort == $opt['value'] ? 'is-selected' : '' }}" onclick="submitSort('{{ $opt['value'] }}')" role="menuitem">
                                  <span class="sd-sort-option-name">{{ $opt['label'] }}</span>
                                </div>
                              @endforeach
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Hizmet Kartları Grid -->
                  @if($services->count() > 0)
                    <div class="row g-3">
                      @foreach($services as $service)
                        <div class="col-12 col-sm-6 col-lg-4">
                          <div class="sd-owner-service-card">
                            <!-- Görsel Alanı & Kebab İşlemleri -->
                            <div class="sd-card-img-wrap">
                              <span class="sd-status-pill {{ $service->status ? 'sd-status-active' : 'sd-status-passive' }}">
                                {{ $service->status ? 'Aktif' : 'Pasif' }}
                              </span>

                              <!-- Kebab Dropdown -->
                              <div class="sd-kebab-menu">
                                <button type="button" class="sd-kebab-btn" onclick="toggleKebab(event, this)">
                                  <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <div class="sd-kebab-dropdown">
                                  <a href="{{ route('company.services.edit', $service->id) }}" class="sd-kebab-item">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                    <span>Düzenle</span>
                                  </a>
                                  <a href="{{ route('company.services.status', $service->id) }}" class="sd-kebab-item">
                                    <i class="fa-solid {{ $service->status ? 'fa-eye-slash text-warning' : 'fa-eye text-success' }}"></i>
                                    <span>{{ $service->status ? 'Pasif Yap' : 'Aktif Yap' }}</span>
                                  </a>
                                  <form action="{{ route('company.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Bu hizmeti silmek istediğinize emin misiniz?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="sd-kebab-item text-danger">
                                      <i class="fa-solid fa-trash-can"></i>
                                      <span>Sil</span>
                                    </button>
                                  </form>
                                </div>
                              </div>

                              <a href="{{ route('services.show', $service->slug) }}">
                                <img src="{{ asset($service->photos->first()['path'] ?? 'site/images/default-service.jpg') }}" alt="{{ $service->title }}" class="sd-card-img" loading="lazy">
                              </a>
                            </div>

                            <!-- Kart İçeriği -->
                            <div class="sd-card-body">
                              <h5 class="sd-card-title">
                                <a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a>
                              </h5>

                              <div class="sd-card-tags">
                                @if($service->category || $service->subCategory)
                                  <span class="sd-tag-mini">
                                    <i class="fa-solid fa-tag"></i>
                                    <span>{{ $service->subCategory?->name ?: $service->category?->name }}</span>
                                  </span>
                                @endif

                                @if($service->province || $service->district)
                                  <span class="sd-tag-mini">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>{{ $service->province?->name }}</span>
                                  </span>
                                @endif
                              </div>

                              <div class="sd-card-views">
                                <i class="fa-regular fa-eye"></i>
                                <span>{{ $service->view_count ?? 0 }} görüntülenme</span>
                              </div>

                              <!-- Fiyat & Ödeme -->
                              <div class="sd-card-footer">
                                <div class="sd-card-price-group">
                                  <x-old-prices :prices="$service->oldPrices" />
                                  <span class="sd-card-price">
                                    {{ number_format($service->price, 0, ',', '.') }} <small>TL</small>
                                  </span>
                                </div>

                                <span class="sd-payment-badge">
                                  {{ $service->payment_type == 'card' ? 'Kart' : 'Nakit' }}
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <!-- Modern Kullanıcı Dostu Sayfa Geçişi Bileşeni (Ziyaretçi Profili ile Birebir) -->
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
                                <a href="{{ $services->previousPageUrl() }}#home" class="sd-page-btn sd-page-prev" rel="prev">
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
                                <a href="{{ $services->url(1) }}#home" class="sd-page-btn">1</a>
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
                                  <a href="{{ $services->url($page) }}#home" class="sd-page-btn">{{ $page }}</a>
                                </li>
                              @endif
                            @endfor

                            @if($end < $lastPage)
                              @if($end < $lastPage - 1)
                                <li class="sd-page-item disabled"><span class="sd-page-dots">…</span></li>
                              @endif
                              <li class="sd-page-item">
                                <a href="{{ $services->url($lastPage) }}#home" class="sd-page-btn">{{ $lastPage }}</a>
                              </li>
                            @endif

                            {{-- Sonraki Sayfa --}}
                            @if ($services->hasMorePages())
                              <li class="sd-page-item">
                                <a href="{{ $services->nextPageUrl() }}#home" class="sd-page-btn sd-page-next" rel="next">
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
                      <i class="fa-solid fa-boxes-stacked sd-empty-icon"></i>
                      <div class="sd-empty-title">Henüz Hizmet Eklenmemiş</div>
                      <p>Müşterilerinizin teklif alabilmesi için hemen ilk hizmetinizi ekleyin.</p>
                      <a href="{{ route('company.services.create') }}" class="sd-btn-primary" style="width: auto; padding: 0 20px; margin-top: 10px;">
                        <i class="fa-solid fa-plus"></i>
                        <span>Hemen Hizmet Ekle</span>
                      </a>
                    </div>
                  @endif
                </div>

                <!-- 2. SORULAR TAB -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="sd-tab-header">
                    <h4 class="sd-tab-title">Müşteri Soruları ({{ $questions->total() }})</h4>
                  </div>

                  @if($questions->count() > 0)
                    <div class="sd-q-list">
                      @foreach($questions as $question)
                        <div class="sd-q-card">
                          <div class="sd-q-header">
                            <div class="sd-q-user">
                              <img src="{{ asset(auth_info($question->user_id)->avatar) }}" alt="{{ auth_info($question->user_id)->name }}" class="sd-q-avatar">
                              <div>
                                <span class="sd-q-author">{{ auth_info($question->user_id)->name }}</span>
                                <span class="sd-q-date">
                                  <i class="fa-regular fa-clock"></i>
                                  {{ change_timezone($question->created_at, 'd.m.Y H:i') }}
                                </span>
                              </div>
                            </div>

                            <div class="sd-q-meta-right">
                              @if($question->service)
                                <a href="{{ route('services.show', $question->service->slug) }}" class="sd-q-service-badge" title="{{ $question->service->title }}">
                                  <i class="fa-solid fa-tag"></i>
                                  <span>{{ $question->service->title }}</span>
                                </a>
                              @endif

                              <form action="{{ route('services.question.destroy', [$question->service->slug, $question->id]) }}" method="POST" onsubmit="return confirm('Bu soruyu silmek istediğinize emin misiniz?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sd-q-delete-btn" title="Soruyu Sil">
                                  <i class="fa-solid fa-trash-can"></i>
                                </button>
                              </form>
                            </div>
                          </div>

                          <!-- Soru Metni -->
                          <div class="sd-q-text-bubble">
                            {{ $question->question }}
                          </div>

                          <!-- Varsa Cevap -->
                          @if($question->answer)
                            <div class="sd-q-existing-answer">
                              <div class="sd-q-answer-title">
                                <i class="fa-solid fa-check-circle"></i>
                                <span>Cevabınız</span>
                              </div>
                              <p class="sd-q-answer-body">{{ $question->answer }}</p>
                            </div>
                          @endif

                          <!-- Cevaplama Formu -->
                          <form action="{{ route('services.answer', $question->service->slug) }}" method="POST" class="sd-q-form-area">
                            @csrf
                            <input name="question" type="hidden" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($question->id) }}">
                            <textarea name="answer" class="sd-q-textarea" placeholder="Müşterinize cevap verin..." required>{{ old('answer', $question->answer) }}</textarea>
                            <div class="d-flex justify-content-end">
                              <button type="submit" class="sd-btn-primary" style="height: 36px; width: auto; padding: 0 18px; font-size: 13px;">
                                <i class="fa-solid fa-reply"></i>
                                <span>{{ !$question->answer ? 'Cevapla' : 'Cevabı Güncelle' }}</span>
                              </button>
                            </div>
                          </form>
                        </div>
                      @endforeach
                    </div>

                    <div class="sd-pagination-wrapper">
                      {{ $questions->appends(request()->query())->links() }}
                    </div>
                  @else
                    <div class="sd-empty-state">
                      <i class="fa-regular fa-comments sd-empty-icon"></i>
                      <div class="sd-empty-title">Henüz Soru Bulunmuyor</div>
                      <p>Hizmetleriniz hakkında müşterilerinizden soru geldiğinde burada görüntülenecektir.</p>
                    </div>
                  @endif
                </div>

                <!-- 3. DEĞERLENDİRMELER TAB -->
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <!-- Değerlendirme Özeti -->
                  <div class="sd-reviews-summary">
                    <div class="sd-rating-big">{{ number_format($averageRating, 1) }}</div>
                    <div class="sd-rating-stars-wrap">
                      <div class="sd-stars">
                        @for($i = 1; $i <= 5; $i++)
                          @if($i <= floor($averageRating))
                            <i class="fa-solid fa-star"></i>
                          @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                            <i class="fa-solid fa-star-half-stroke"></i>
                          @else
                            <i class="fa-regular fa-star"></i>
                          @endif
                        @endfor
                      </div>
                      <div class="sd-rating-subtext">5 üzerinden puan &bull; {{ $totalRatings }} değerlendirme</div>
                    </div>
                  </div>

                  <!-- Değerlendirme Listesi -->
                  @forelse($ratings as $rating)
                    <div class="sd-review-card">
                      <div class="sd-review-header">
                        <div class="sd-reviewer">
                          <img src="{{ asset(auth_info($rating->user_id)->avatar) }}" alt="{{ auth_info($rating->user_id)->name }}" class="sd-reviewer-avatar">
                          <div>
                            <h5 class="sd-reviewer-name">{{ auth_info($rating->user_id)->name }}</h5>
                            <span class="sd-review-date">{{ $rating->created_at->format('d.m.Y') }}</span>
                          </div>
                        </div>

                        <div class="sd-review-score">
                          <div class="sd-stars" style="font-size: 13px;">
                            @for($i = 1; $i <= 5; $i++)
                              @if($i <= $rating->rating)
                                <i class="fa-solid fa-star"></i>
                              @else
                                <i class="fa-regular fa-star"></i>
                              @endif
                            @endfor
                          </div>
                          <span style="font-size: 13px; font-weight: 700; color: var(--sd-text-main);">{{ $rating->rating }}/5</span>
                        </div>
                      </div>

                      @if($rating->comment)
                        <p class="sd-review-comment">{{ $rating->comment }}</p>
                      @endif

                      @if($rating->service && $rating->service->cover_photo)
                        <div class="sd-review-service-thumb">
                          <img src="{{ asset($rating->service->cover_photo) }}" alt="{{ $rating->service->title }}">
                          <span>{{ $rating->service->title }}</span>
                        </div>
                      @endif
                    </div>
                  @empty
                    <div class="sd-empty-state">
                      <i class="fa-regular fa-star sd-empty-icon"></i>
                      <div class="sd-empty-title">Henüz Değerlendirme Yok</div>
                      <p>Müşterileriniz hizmetlerinizi tamamladıkça buraya değerlendirmeler eklenecektir.</p>
                    </div>
                  @endforelse

                  @if($ratings->hasPages())
                    <div class="sd-pagination-wrapper">
                      {{ $ratings->appends(request()->query())->links() }}
                    </div>
                  @endif
                </div>

                <!-- 4. TAKİPÇİLER TAB -->
                <div class="tab-pane fade" id="takipci" role="tabpanel" aria-labelledby="takipci-tab">
                  <div class="sd-search-bar">
                    <h4 class="sd-tab-title">Takipçilerim ({{ $followersCount }})</h4>

                    <form action="" method="GET" class="sd-search-input-wrap">
                      <input name="follower_name" type="text" class="sd-search-input" placeholder="Takipçi Ara..." value="{{ request()->follower_name }}">
                      <button type="submit" class="sd-search-btn" aria-label="Ara">
                        <i class="fa-solid fa-magnifying-glass"></i>
                      </button>
                    </form>
                  </div>

                  @if($followers->count() > 0)
                    <div class="row g-3">
                      @foreach($followers as $follower)
                        <div class="col-12 col-md-6">
                          <div class="sd-user-card">
                            <div class="sd-user-card-info">
                              <img src="{{ asset(auth_info($follower->user_id)->avatar) }}" alt="{{ auth_info($follower->user_id)->name }}" class="sd-user-card-avatar">
                              <div>
                                <h5 class="sd-user-card-name">{{ auth_info($follower->user_id)->name }}</h5>
                                <span class="badge bg-light text-muted border" style="font-size: 11px;">Kullanıcı</span>
                              </div>
                            </div>

                            <div class="sd-user-card-actions">
                              <a href="{{ route('chat.show', $follower->user_id) }}" class="sd-btn-outline" style="height: 34px; padding: 0 12px; font-size: 12.5px;">
                                <i class="fa-solid fa-comment-dots"></i>
                                <span>Mesaj</span>
                              </a>

                              <form action="{{ route('company.follow') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="status" value="2">
                                <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($follower->user_id) }}">
                                <button type="submit" class="sd-btn-secondary" style="height: 34px; padding: 0 10px; font-size: 12px;" title="Takipten Çıkar">
                                  <i class="fa-solid fa-user-minus"></i>
                                </button>
                              </form>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <div class="sd-pagination-wrapper">
                      {{ $followers->appends(request()->query())->links() }}
                    </div>
                  @else
                    <div class="sd-empty-state">
                      <i class="fa-regular fa-user sd-empty-icon"></i>
                      <div class="sd-empty-title">Henüz Takipçi Bulunmuyor</div>
                      <p>Firmanızı takip eden kullanıcılar burada listelenecektir.</p>
                    </div>
                  @endif
                </div>

                <!-- 5. TAKİP EDİLENLER TAB -->
                <div class="tab-pane fade" id="takipedilen" role="tabpanel" aria-labelledby="takipedilen-tab">
                  <div class="sd-search-bar">
                    <h4 class="sd-tab-title">Takip Ettiklerim ({{ $followingsCount }})</h4>

                    <form action="" method="GET" class="sd-search-input-wrap">
                      <input name="following_name" type="text" class="sd-search-input" placeholder="Takip Edilen Ara..." value="{{ request()->following_name }}">
                      <button type="submit" class="sd-search-btn" aria-label="Ara">
                        <i class="fa-solid fa-magnifying-glass"></i>
                      </button>
                    </form>
                  </div>

                  @if($followings->count() > 0)
                    <div class="row g-3">
                      @foreach($followings as $following)
                        <div class="col-12 col-md-6">
                          <div class="sd-user-card">
                            <div class="sd-user-card-info">
                              <img src="{{ asset(auth_info($following->to_id)->avatar) }}" alt="{{ auth_info($following->to_id)->name }}" class="sd-user-card-avatar">
                              <div>
                                <h5 class="sd-user-card-name">{{ auth_info($following->to_id)->name }}</h5>
                                <span class="badge bg-light text-muted border" style="font-size: 11px;">Takip Edilen</span>
                              </div>
                            </div>

                            <div class="sd-user-card-actions">
                              <a href="{{ route('chat.show', $following->to_id) }}" class="sd-btn-outline" style="height: 34px; padding: 0 12px; font-size: 12.5px;">
                                <i class="fa-solid fa-comment-dots"></i>
                                <span>Mesaj</span>
                              </a>

                              <form action="{{ route('company.follow') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="status" value="2">
                                <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($following->to_id) }}">
                                <button type="submit" class="sd-btn-secondary" style="height: 34px; padding: 0 10px; font-size: 12px;" title="Takipten Çık">
                                  <i class="fa-solid fa-user-xmark"></i>
                                </button>
                              </form>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>

                    <div class="sd-pagination-wrapper">
                      {{ $followings->appends(request()->query())->links() }}
                    </div>
                  @else
                    <div class="sd-empty-state">
                      <i class="fa-regular fa-heart sd-empty-icon"></i>
                      <div class="sd-empty-title">Henüz Takip Ettiğiniz Kimse Yok</div>
                      <p>Platformda takip ettiğiniz kullanıcı ve firmalar burada listelenir.</p>
                    </div>
                  @endif
                </div>

              </div>
            </div>

          </div>

          <!-- Right Column: Sticky Sidebar (Desktop Only) -->
          <div class="sd-sidebar">

            <!-- 1. Hızlı İşlemler Kartı -->
            <div class="sd-action-card">
              <h4 class="sd-sidebar-title">
                <i class="fa-solid fa-bolt text-primary"></i>
                <span>Firma Hızlı İşlemleri</span>
              </h4>

              <div class="sd-btn-group-vertical">
                <button type="button" class="sd-btn-primary share-btn">
                  <i class="fa-solid fa-share-nodes"></i>
                  <span>Profili Paylaş</span>
                </button>

                <a href="{{ route('company.profile.edit') }}" class="sd-btn-outline">
                  <i class="fa-solid fa-pen-to-square"></i>
                  <span>Firma Profilini Düzenle</span>
                </a>

                @if($company->latestActivePackage())
                  <a href="{{ route('company.subscriptions.index') }}" class="sd-btn-secondary">
                    <i class="fa-solid fa-crown text-warning"></i>
                    <span>Abonelik Yönetimi</span>
                  </a>
                @else
                  <a href="{{ route('company.packages.index') }}" class="sd-btn-secondary">
                    <i class="fa-solid fa-crown text-warning"></i>
                    <span>Pro Üyelik Paketleri</span>
                  </a>
                @endif

                @if($hasEplanPreview)
                  <a href="{{ route('company.eplan') }}" class="sd-btn-secondary">
                    <i class="fa-solid fa-house-circle-check text-primary"></i>
                    <span>E-Plan Modülü</span>
                  </a>
                @endif

                <a href="{{ route('companies.show', $company->slug) }}" target="_blank" class="sd-btn-secondary">
                  <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  <span>Profilimi Önizle (Ziyaretçi)</span>
                </a>
              </div>
            </div>

            <!-- 2. Onaylı Profil Durum Kartı -->
            <div class="sd-verified-status-card">
              <div class="sd-ver-icon-wrap {{ $company->is_verified == 1 ? 'sd-ver-active' : ($company->is_verified == 2 ? 'sd-ver-pending' : 'sd-ver-unverified') }}">
                @if($company->is_verified == 1)
                  <i class="fa-solid fa-circle-check" style="font-size: 22px;"></i>
                @elseif($company->is_verified == 2)
                  <i class="fa-solid fa-clock-rotate-left" style="font-size: 22px;"></i>
                @else
                  <i class="fa-solid fa-shield-halved" style="font-size: 22px;"></i>
                @endif
              </div>

              <div class="sd-ver-body">
                <h5 class="sd-ver-title">
                  @if($company->is_verified == 1)
                    Onaylı Profil
                  @elseif($company->is_verified == 2)
                    Belgeler İnceleniyor
                  @else
                    Onaylı Profil Olun
                  @endif
                </h5>
                <p class="sd-ver-desc">
                  @if($company->is_verified == 1)
                    Profiliniz ve hizmetleriniz onaylı rozetiyle daha fazla müşteriye güven vermektedir.
                  @elseif($company->is_verified == 2)
                    Doğrulama başvurunuz uzmanlarımız tarafından incelenmektedir.
                  @else
                    Doğrulanmış güven rozeti alarak aramalarda öne çıkın ve daha çok iş alın.
                  @endif
                </p>

                @if($company->is_verified == 1)
                  <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#onayliprofildurum" class="sd-ver-link">
                    <span>Durum detayını gör</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                  </a>
                @elseif($company->is_verified == 0)
                  <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#onayliprofilol" class="sd-ver-link">
                    <span>Hemen başvuru yap</span>
                    <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
                  </a>
                @endif
              </div>
            </div>

            <!-- 3. Profil İstatistikleri Kartı -->
            <div class="sd-profile-stats-card">
              <h4 class="sd-sidebar-title">
                <i class="fa-solid fa-chart-pie text-primary"></i>
                <span>Firma Özeti</span>
              </h4>

              <div class="sd-stats-grid">
                <div class="sd-stat-item">
                  <div class="sd-stat-item-val">{{ $serviceCount }}</div>
                  <div class="sd-stat-item-label">Aktif Hizmet</div>
                </div>

                <div class="sd-stat-item">
                  <div class="sd-stat-item-val text-warning">{{ number_format($averageRating, 1) }} ★</div>
                  <div class="sd-stat-item-label">{{ $totalRatings }} Puanlama</div>
                </div>

                <div class="sd-stat-item">
                  <div class="sd-stat-item-val">{{ $followersCount }}</div>
                  <div class="sd-stat-item-label">Takipçi</div>
                </div>

                <div class="sd-stat-item">
                  <div class="sd-stat-item-val">{{ $followingsCount }}</div>
                  <div class="sd-stat-item-label">Takip Edilen</div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<!-- Mobile Sticky Bottom Bar (Height: 55px matching visitor profile) -->
<div class="sd-mobile-sticky-bar">
  @if($company->latestActivePackage())
    <a href="{{ route('company.subscriptions.index') }}" class="sd-mob-bar-btn sd-btn-primary">
      <span>Aboneliğim</span>
    </a>
  @else
    <a href="{{ route('company.packages.index') }}" class="sd-mob-bar-btn sd-btn-primary">
      <span>Aboneliğim</span>
    </a>
  @endif

  <a href="{{ route('company.eplan') }}" class="sd-mob-bar-btn sd-btn-secondary">
    <span>E-Plan</span>
  </a>

  <a href="{{ route('company.profile.edit') }}" class="sd-mob-bar-btn sd-btn-secondary">
    <span>Profili Düzenle</span>
  </a>
</div>

<!-- Onaylı Profil Ol Modalı -->
<div class="modal fade login-modal" id="onayliprofilol" tabindex="-1" aria-labelledby="onayliprofilolLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--sd-border);">
      <div class="modal-header" style="border-bottom: 1px solid var(--sd-border); padding: 14px 20px;">
        <h5 class="modal-title fw-bold" id="onayliprofilolLabel" style="font-size: 15.5px;">Onaylı Profil Başvurusu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div class="mb-3">
          <img src="{{ asset('site/images/success.png') }}" alt="Onaylı" style="width: 56px; height: 56px;">
        </div>
        <h6 class="fw-bold mb-2" style="font-size: 15px;">Onaylı Profil Avantajları</h6>
        <p class="text-muted small mb-4" style="line-height: 1.5;">
          Uzman ekibimiz vergi bilgilerinizi ve işletme konum adresinizi doğrulamak için size ulaşacaktır. Onaylı profiller aramalarda öne çıkar ve müşterilere daha yüksek güven sunar.
        </p>
        <a href="{{ route('company.send-verify') }}" class="sd-btn-primary w-100 justify-content-center text-decoration-none" style="height: 42px;">
          Hemen Başvur
        </a>
      </div>
    </div>
  </div>
</div>

<!-- Onaylı Profil Durum Modalı -->
<div class="modal fade login-modal" id="onayliprofildurum" tabindex="-1" aria-labelledby="onayliprofildurumlabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--sd-border);">
      <div class="modal-header" style="border-bottom: 1px solid var(--sd-border); padding: 14px 20px;">
        <h5 class="modal-title fw-bold" id="onayliprofildurumlabel" style="font-size: 15.5px;">Onaylı Profil Durumu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <div class="mb-3">
          <img src="{{ asset('site/images/success.png') }}" alt="Onaylı" style="width: 60px; height: 60px;">
        </div>
        <h6 class="fw-bold text-success mb-2" style="font-size: 15.5px;">Tebrikler! Onaylı Profilsiniz</h6>
        <p class="text-muted small mb-0" style="line-height: 1.5;">
          @if($company->getVerificationDate())
            <strong>{{ $company->getVerificationDate()->format('d.m.Y') }}</strong> tarihinden itibaren onaylı profilsiniz.
          @else
            Onaylı profilsiniz.
          @endif
          <br><br>
          Profiliniz ve tüm aktif hizmetleriniz onaylı rozet ile listelenerek müşterilerinize üst düzey güven sunmaktadır.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Mobile Popup Backdrop -->
<div class="sd-popup-backdrop" id="popupBackdrop"></div>

<script>
  // Kebab Menu Toggle
  function toggleKebab(event, btn) {
    event.stopPropagation();
    const dropdown = btn.nextElementSibling;
    document.querySelectorAll('.sd-kebab-dropdown').forEach(d => {
      if (d !== dropdown) d.classList.remove('show');
    });
    dropdown.classList.toggle('show');
  }

  document.addEventListener('click', function(e) {
    if (!e.target.closest('.sd-kebab-menu')) {
      document.querySelectorAll('.sd-kebab-dropdown').forEach(d => d.classList.remove('show'));
    }
  });

  // Sorting Function
  function submitSort(sortVal) {
    const input = document.getElementById('sortOrderByInput');
    const form = document.getElementById('sortServicesForm');
    if (input && form) {
      input.value = sortVal;
      form.submit();
    }
  }

  // Pop-up Dropdowns (Analytics Filters & Sort)
  document.addEventListener('DOMContentLoaded', function() {
    const backdrop = document.getElementById('popupBackdrop');

    function closeAllPopups() {
      document.querySelectorAll('.sd-filter-popup, .sd-sort-popup').forEach(p => p.classList.remove('show'));
      document.querySelectorAll('.sd-filter-trigger-btn, .sd-sort-trigger-btn').forEach(b => {
        b.setAttribute('aria-expanded', 'false');
        b.classList.remove('is-active');
      });
      if (backdrop) backdrop.classList.remove('show');
    }

    function togglePopup(btn, popup) {
      if (!btn || !popup) return;
      const isOpen = popup.classList.contains('show');
      closeAllPopups();

      if (!isOpen) {
        popup.classList.add('show');
        btn.setAttribute('aria-expanded', 'true');
        btn.classList.add('is-active');
        if (backdrop && window.innerWidth <= 991) {
          backdrop.classList.add('show');
        }
      }
    }

    // 1. Sort Popup Toggle
    const sortBtn = document.getElementById('sortTriggerBtn');
    const sortPopup = document.getElementById('sortPopup');
    if (sortBtn && sortPopup) {
      sortBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        togglePopup(sortBtn, sortPopup);
      });
    }

    // 2. Service Filter Popup Toggle
    const serviceBtn = document.getElementById('serviceFilterBtn');
    const servicePopup = document.getElementById('serviceFilterPopup');
    if (serviceBtn && servicePopup) {
      serviceBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        togglePopup(serviceBtn, servicePopup);
      });
    }

    // 3. Day Filter Popup Toggle
    const dayBtn = document.getElementById('dayFilterBtn');
    const dayPopup = document.getElementById('dayFilterPopup');
    if (dayBtn && dayPopup) {
      dayBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        togglePopup(dayBtn, dayPopup);
      });
    }

    // Backdrop & Outside click & ESC
    if (backdrop) {
      backdrop.addEventListener('click', function() {
        closeAllPopups();
      });
    }

    document.addEventListener('click', function(e) {
      if (!e.target.closest('.sd-filter-wrapper') && !e.target.closest('.sd-sort-wrapper')) {
        closeAllPopups();
      }
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAllPopups();
      }
    });

    // Prevent clicks inside popup from bubbling to document
    document.querySelectorAll('.sd-filter-popup, .sd-sort-popup').forEach(p => {
      p.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    });

    // AJAX Analytics Filter Function
    function updateAnalytics() {
      const serviceFilter = document.getElementById('serviceFilter');
      const dayFilter = document.getElementById('dayFilter');
      if (!serviceFilter || !dayFilter) return;

      const service = serviceFilter.value;
      const day = dayFilter.value;

      const profileCount = document.getElementById('profileCurrentCount');
      const serviceCount = document.getElementById('serviceCurrentCount');
      const profilePercentage = document.getElementById('profilePercentage');
      const servicePercentage = document.getElementById('servicePercentage');

      if (serviceBtn) serviceBtn.disabled = true;
      if (dayBtn) dayBtn.disabled = true;

      const statBoxes = document.querySelectorAll('.sd-stat-box');
      statBoxes.forEach(b => b.classList.add('loading'));

      if (profileCount) profileCount.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size: 20px;"></i>';
      if (serviceCount) serviceCount.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size: 20px;"></i>';

      fetch(`{{ route('company.dashboard.analytics') }}?service=${service}&day=${day}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
      })
      .then(response => {
        if (!response.ok) throw new Error('Network error');
        return response.json();
      })
      .then(data => {
        if (profileCount) profileCount.textContent = data.profileCurrentCount;
        if (serviceCount) serviceCount.textContent = data.serviceCurrentCount;

        if (profilePercentage) {
          const pChange = data.profilePercentageChange;
          profilePercentage.innerHTML = pChange >= 0
            ? `<span class="sd-change-pill sd-change-up"><i class="fa-solid fa-arrow-up"></i> +${pChange}%</span>`
            : `<span class="sd-change-pill sd-change-down"><i class="fa-solid fa-arrow-down"></i> ${pChange}%</span>`;
        }

        if (servicePercentage) {
          const sChange = data.servicePercentageChange;
          servicePercentage.innerHTML = sChange >= 0
            ? `<span class="sd-change-pill sd-change-up"><i class="fa-solid fa-arrow-up"></i> +${sChange}%</span>`
            : `<span class="sd-change-pill sd-change-down"><i class="fa-solid fa-arrow-down"></i> ${sChange}%</span>`;
        }

        const url = new URL(window.location);
        if (service) {
          url.searchParams.set('service', service);
        } else {
          url.searchParams.delete('service');
        }
        url.searchParams.set('day', day);
        window.history.pushState({}, '', url);

        if (serviceBtn) serviceBtn.disabled = false;
        if (dayBtn) dayBtn.disabled = false;
        statBoxes.forEach(b => b.classList.remove('loading'));
      })
      .catch(err => {
        console.error('Analytics update error:', err);
        if (serviceBtn) serviceBtn.disabled = false;
        if (dayBtn) dayBtn.disabled = false;
        statBoxes.forEach(b => b.classList.remove('loading'));
      });
    }

    // Service Option Selection
    const serviceItems = document.querySelectorAll('#serviceFilterPopup .sd-sort-option-item');
    serviceItems.forEach(item => {
      item.addEventListener('click', function(e) {
        e.stopPropagation();
        const val = this.getAttribute('data-value') || '';
        const nameSpan = this.querySelector('.sd-sort-option-name');
        const text = nameSpan ? nameSpan.textContent.trim() : 'Tüm Hizmetler';

        serviceItems.forEach(el => {
          el.classList.remove('is-selected');
          const chk = el.querySelector('.sd-check-icon');
          if (chk) chk.classList.add('d-none');
        });
        this.classList.add('is-selected');
        const activeChk = this.querySelector('.sd-check-icon');
        if (activeChk) activeChk.classList.remove('d-none');

        const input = document.getElementById('serviceFilter');
        if (input) input.value = val;
        const btnText = document.getElementById('serviceFilterBtnText');
        if (btnText) btnText.textContent = text;

        closeAllPopups();
        updateAnalytics();
      });
    });

    // Day Option Selection
    const dayItems = document.querySelectorAll('#dayFilterPopup .sd-sort-option-item');
    dayItems.forEach(item => {
      item.addEventListener('click', function(e) {
        e.stopPropagation();
        const val = this.getAttribute('data-value') || '1';
        const nameSpan = this.querySelector('.sd-sort-option-name');
        const text = nameSpan ? nameSpan.textContent.trim() : 'Son 24 Saat';

        dayItems.forEach(el => {
          el.classList.remove('is-selected');
          const chk = el.querySelector('.sd-check-icon');
          if (chk) chk.classList.add('d-none');
        });
        this.classList.add('is-selected');
        const activeChk = this.querySelector('.sd-check-icon');
        if (activeChk) activeChk.classList.remove('d-none');

        const input = document.getElementById('dayFilter');
        if (input) input.value = val;
        const btnText = document.getElementById('dayFilterBtnText');
        if (btnText) btnText.textContent = text;

        closeAllPopups();
        updateAnalytics();
      });
    });

    // Preserve Active Tab across pagination and page loads
    function preserveActiveTab() {
      const hash = window.location.hash;
      const storedTab = localStorage.getItem('companyDashboardActiveTab');
      const urlParams = new URLSearchParams(window.location.search);

      let correctTab = null;
      if (urlParams.has('followers_page')) {
        correctTab = 'takipci';
      } else if (urlParams.has('followings_page')) {
        correctTab = 'takipedilen';
      } else if (urlParams.has('questions_page')) {
        correctTab = 'profile';
      } else if (urlParams.has('ratings_page')) {
        correctTab = 'contact';
      } else if (urlParams.has('services_page') || urlParams.has('page') || urlParams.has('order_by')) {
        correctTab = 'home';
      }

      const targetTab = correctTab || (hash ? hash.substring(1) : storedTab);

      if (targetTab) {
        const tabBtn = document.querySelector(`[data-bs-target="#${targetTab}"]`);
        if (tabBtn) {
          document.querySelectorAll('.sd-nav-tabs .sd-nav-link').forEach(t => t.classList.remove('active'));
          document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show', 'active'));

          tabBtn.classList.add('active');
          const targetPane = document.querySelector(`#${targetTab}`);
          if (targetPane) {
            targetPane.classList.add('show', 'active');
          }
          localStorage.setItem('companyDashboardActiveTab', targetTab);
          setTimeout(() => centerTabButton(tabBtn), 250);
        }
      }

      document.querySelectorAll('.sd-nav-tabs .sd-nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
          centerTabButton(this);
          const target = this.getAttribute('data-bs-target');
          if (target) {
            const tabId = target.substring(1);
            localStorage.setItem('companyDashboardActiveTab', tabId);

            const url = new URL(window.location);
            url.searchParams.delete('page');
            url.searchParams.delete('services_page');
            url.searchParams.delete('questions_page');
            url.searchParams.delete('followers_page');
            url.searchParams.delete('followings_page');
            url.searchParams.delete('ratings_page');

            url.hash = `#${tabId}`;
            window.history.replaceState(null, null, url.toString());
          }
        });
      });
    }

    // Mobile Tab Centering on Click & Load
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

    preserveActiveTab();

    const activeNavTab = document.querySelector('.sd-nav-tabs .sd-nav-link.active');
    if (activeNavTab) {
      setTimeout(() => centerTabButton(activeNavTab), 300);
    }

    // Share buttons handling (Web Share API + fallback copy)
    const shareBtns = document.querySelectorAll('.share-btn');
    shareBtns.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const shareData = {
          title: '{{ addslashes($company->name) }}',
          text: '{{ addslashes($company->name) }} EvHayaliniz Firma Profili',
          url: '{{ route('companies.show', $company->slug) }}'
        };

        if (navigator.share) {
          navigator.share(shareData).catch(() => {});
        } else if (navigator.clipboard) {
          navigator.clipboard.writeText(shareData.url).then(() => {
            alert('Firma profil linki panoya kopyalandı!');
          });
        }
      });
    });
  });
</script>
@endsection
