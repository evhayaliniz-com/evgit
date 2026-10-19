@extends('site.inc.master')

@section('css')
<style>
  /* ==========================================================================
     Modern Service Detail Page (Desktop 2-Column & Mobile Half-Screen Redesign)
     ========================================================================== */
  .main.sidebar {
    padding-left: 0 !important;
  }

  .plus {
    display: none !important;
  }

  .sd-page-wrapper {
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
    background-color: var(--sd-bg) !important;
    padding: 20px 24px 40px !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    min-height: 100vh;
    border: none !important;
  }

  body.dark .sd-page-wrapper {
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
    max-width: 1360px;
    margin: 0 auto;
    width: 100%;
  }

  /* --- Top Breadcrumb & Quick Actions (Desktop) --- */
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
    max-width: 340px;
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

  .sd-icon-action-btn.is-saved {
    background: var(--sd-primary-soft);
    border-color: var(--sd-primary);
    color: var(--sd-primary);
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
  }

  /* --- Gallery Card --- */
  .sd-gallery-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 16px;
    position: relative;
    overflow: hidden;
  }

  .sd-gallery-layout {
    display: flex;
    gap: 14px;
    align-items: stretch;
  }

  .sd-main-swiper {
    flex: 1;
    min-width: 0;
    width: 100%;
    height: 480px;
    border-radius: var(--sd-radius-md);
    background: #0f172a;
    position: relative;
    overflow: hidden;
  }

  .sd-main-swiper .swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
  }

  .sd-slide-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    position: relative;
    z-index: 2;
  }

  .sd-main-swiper .swiper-slide img {
    width: 100%;
    height: 100%;
    aspect-ratio: 16 / 10;
    object-fit: contain;
    display: block;
    transition: transform 0.35s ease;
  }

  /* Floating Overlay Controls on Gallery */
  .sd-gallery-mobile-nav {
    display: none;
  }

  .sd-gallery-counter {
    position: absolute;
    bottom: 14px;
    right: 14px;
    z-index: 5;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    pointer-events: none;
  }

  .sd-gallery-zoom-hint {
    position: absolute;
    bottom: 14px;
    left: 14px;
    z-index: 5;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: #fff;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    cursor: pointer;
    transition: background 0.2s ease;
  }

  .sd-gallery-zoom-hint:hover {
    background: rgba(37, 99, 235, 0.9);
  }

  /* Custom Scoped Swiper Navigation Arrows (avoids global main.js conflicts) */
  .sd-gallery-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 5;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.92);
    color: #0f172a;
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .sd-gallery-nav-btn.sd-gallery-prev {
    left: 12px;
  }

  .sd-gallery-nav-btn.sd-gallery-next {
    right: 12px;
  }

  .sd-gallery-nav-btn:hover {
    background: var(--sd-primary);
    color: #fff;
    transform: translateY(-50%) scale(1.06);
  }

  .sd-gallery-nav-btn.swiper-button-disabled {
    opacity: 0.35;
    pointer-events: none;
  }

  /* Vertical Thumbs on Desktop */
  .sd-thumb-swiper {
    width: 110px;
    height: 480px;
    flex-shrink: 0;
    overflow: hidden;
  }

  .sd-thumb-swiper .swiper-slide {
    width: 100% !important;
    height: 86px !important;
    border-radius: var(--sd-radius-sm);
    overflow: hidden;
    cursor: pointer;
    opacity: 0.55;
    border: 2px solid transparent;
    transition: all 0.2s ease;
    background: #0f172a;
    flex-shrink: 0;
  }

  .sd-thumb-swiper .swiper-slide-thumb-active {
    opacity: 1;
    border-color: var(--sd-primary);
    box-shadow: 0 0 0 2px var(--sd-primary-soft);
  }

  .sd-thumb-swiper .swiper-slide img {
    width: 100%;
    height: 100%;
    aspect-ratio: 4 / 3;
    object-fit: cover;
    display: block;
  }

  /* --- Gallery Ad Slide --- */
  .sd-gallery-ad-slide {
    display: flex !important;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    height: 100% !important;
    position: relative;
    border-radius: var(--sd-radius-md);
    overflow: hidden;
  }
  body.dark .sd-gallery-ad-slide {
    background: #18181b;
  }
  .sd-gallery-ad-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    padding: 16px;
    box-sizing: border-box;
  }
  .sd-gallery-ad-badge {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--sd-text-muted);
    background: rgba(0, 0, 0, 0.05);
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 12px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }
  body.dark .sd-gallery-ad-badge {
    background: rgba(255, 255, 255, 0.1);
    color: #a1a1aa;
  }
  .sd-gallery-ad-content {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 336px;
    min-height: 250px;
  }
  .sd-gallery-ad-content .google-ad-wrapper,
  .sd-gallery-ad-content ins.adsbygoogle {
    min-height: 250px;
    width: 100% !important;
  }

  /* Gallery Ad Thumbnail in sd-thumb-swiper */
  .sd-thumb-ad-slide {
    background: #f1f5f9;
    border: 1px dashed #cbd5e1 !important;
    border-radius: 8px;
    display: flex !important;
    align-items: center;
    justify-content: center;
    aspect-ratio: 4 / 3;
    cursor: pointer;
  }
  body.dark .sd-thumb-ad-slide {
    background: #27272a;
    border-color: #3f3f46 !important;
  }
  .sd-thumb-ad-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    color: #64748b;
    font-size: 10px;
    font-weight: 600;
    text-align: center;
    padding: 4px;
  }
  body.dark .sd-thumb-ad-box {
    color: #a1a1aa;
  }
  .sd-thumb-ad-box i {
    font-size: 14px;
    color: #2563eb;
  }

  /* --- Similar Section Ad Wrapper --- */
  .sd-similar-ad-wrapper {
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-lg);
    padding: 16px 20px;
    box-shadow: var(--sd-shadow);
    overflow: hidden;
  }
  body.dark .sd-similar-ad-wrapper {
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

  /* --- Service Info & Quick Specs Header Card --- */
  .sd-header-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 22px 24px;
    margin-top: 20px;
  }

  .sd-badges-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 12px;
  }

  .sd-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 600;
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
    text-decoration: none;
  }

  .sd-badge.sd-badge-location {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
  }

  body.dark .sd-badge.sd-badge-location {
    background: rgba(16, 185, 129, 0.18);
    color: #34d399;
  }

  .sd-title-price-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
  }

  .sd-title {
    font-size: clamp(1.2rem, 1.05rem + 0.65vw, 1.65rem);
    font-weight: 700;
    color: var(--sd-text-main);
    line-height: 1.35;
    margin: 0;
    word-break: break-word;
  }

  /* Mobile Inline Price Banner inside Header Card (hidden on desktop) */
  .sd-mobile-inline-price {
    display: none;
  }

  /* Quick Highlights Strip */
  .sd-quick-specs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
    gap: 12px;
    margin-top: 18px;
    padding-top: 18px;
    border-top: 1px solid var(--sd-border);
  }

  .sd-spec-chip {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: var(--sd-radius-md);
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    min-width: 0;
  }

  .sd-chip-dot {
    display: none;
  }

  .sd-spec-chip-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
  }

  .sd-spec-chip-content {
    min-width: 0;
    flex: 1;
  }

  .sd-spec-chip-label {
    display: block;
    font-size: 11.5px;
    color: var(--sd-text-muted);
    line-height: 1.2;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sd-spec-chip-value {
    display: block;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--sd-text-main);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* --- Content Tabs Card (Açıklama, Özellikler, Soru & Cevap) --- */
  .sd-tabs-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    margin-top: 20px;
    overflow: hidden;
  }

  .sd-nav-tabs {
    display: flex;
    border-bottom: 1px solid var(--sd-border) !important;
    background: var(--sd-surface);
    padding: 0 16px;
    gap: 8px;
    overflow-x: auto;
    scrollbar-width: none;
  }

  .sd-nav-tabs::-webkit-scrollbar {
    display: none;
  }

  .sd-nav-tabs .nav-item {
    margin: 0;
  }

  .sd-nav-tabs .nav-link {
    border: none !important;
    border-bottom: 3px solid transparent !important;
    background: transparent !important;
    color: var(--sd-text-muted) !important;
    font-size: 14.5px;
    font-weight: 600;
    padding: 16px 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    white-space: nowrap;
    cursor: pointer;
    transition: color 0.2s ease, border-color 0.2s ease !important;
    border-radius: 0 !important;
  }

  .sd-nav-tabs .nav-link:hover {
    color: var(--sd-primary) !important;
  }

  .sd-nav-tabs .nav-link.active {
    color: var(--sd-primary) !important;
    border-bottom-color: var(--sd-primary) !important;
  }

  .sd-tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
  }

  .sd-tab-body {
    padding: 24px;
  }

  .sd-description-text {
    font-size: 15px;
    line-height: 1.75;
    color: var(--sd-text-main);
    white-space: pre-line;
    word-break: break-word;
    margin: 0;
  }

  /* Specifications Grid Table */
  .sd-specs-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
  }

  .sd-spec-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 13px 16px;
    border-radius: var(--sd-radius-md);
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
  }

  .sd-spec-row-label {
    font-size: 13.5px;
    font-weight: 500;
    color: var(--sd-text-muted);
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
  }

  .sd-spec-row-label i {
    color: var(--sd-primary);
    font-size: 13px;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
  }

  .sd-spec-row-val {
    font-size: 14px;
    font-weight: 600;
    color: var(--sd-text-main);
    text-align: right;
    word-break: break-word;
  }

  /* Questions & Answers Section */
  .sd-qa-form-card {
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 18px;
    margin-bottom: 24px;
  }

  .sd-qa-form-title {
    font-size: 14.5px;
    font-weight: 600;
    color: var(--sd-text-main);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .sd-qa-textarea {
    width: 100% !important;
    border: 1px solid var(--sd-border) !important;
    border-radius: var(--sd-radius-sm);
    background: var(--sd-surface);
    color: var(--sd-text-main);
    padding: 12px 14px;
    font-size: 14px;
    resize: vertical;
    min-height: 96px;
  }

  .sd-qa-submit-row {
    display: flex;
    justify-content: flex-end;
    margin-top: 12px;
  }

  .sd-guest-login-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 14px 18px;
    border-radius: var(--sd-radius-md);
    background: var(--sd-primary-soft);
    border: 1px dashed var(--sd-primary);
    margin-bottom: 20px;
    cursor: pointer;
  }

  .sd-guest-login-banner-text {
    font-size: 13.5px;
    color: var(--sd-text-main);
    font-weight: 500;
    flex: 1;
    min-width: 180px;
  }

  .sd-guest-login-banner-btn {
    flex-shrink: 0;
    white-space: nowrap;
    padding: 8px 16px;
    font-size: 13px;
  }

  .sd-qa-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .sd-qa-item {
    border: 1px solid var(--sd-border);
    border-radius: var(--sd-radius-md);
    padding: 18px;
    background: var(--sd-bg);
  }

  .sd-qa-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 10px;
  }

  .sd-qa-user {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
  }

  .sd-qa-user img {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--sd-surface);
    flex-shrink: 0;
  }

  .sd-qa-user-meta {
    display: flex;
    flex-direction: column;
    min-width: 0;
  }

  .sd-qa-user-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--sd-text-main);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sd-qa-time {
    font-size: 12px;
    color: var(--sd-text-muted);
  }

  .sd-qa-delete-btn {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .sd-qa-delete-btn:hover {
    background: #ef4444;
    color: #fff;
  }

  .sd-qa-question-text {
    font-size: 14.5px;
    line-height: 1.6;
    color: var(--sd-text-main);
    margin: 0;
    word-break: break-word;
  }

  .sd-qa-answer-box {
    margin-top: 14px;
    padding: 14px 16px;
    border-radius: var(--sd-radius-sm);
    background: var(--sd-surface);
    border-left: 3px solid var(--sd-primary);
  }

  .sd-qa-answer-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    color: var(--sd-primary);
    margin-bottom: 6px;
  }

  .sd-qa-answer-text {
    font-size: 14px;
    line-height: 1.6;
    color: var(--sd-text-main);
    margin: 0;
    word-break: break-word;
  }

  /* --- Right Sidebar: Price Card & Company Card --- */
  .sd-sidebar {
    position: sticky;
    top: 76px;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .sd-price-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 22px 24px;
  }

  .sd-price-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--sd-text-muted);
    margin-bottom: 6px;
    display: block;
  }

  .sd-price-value-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 18px;
  }

  .sd-price-amount {
    font-size: 28px;
    font-weight: 800;
    color: var(--sd-primary);
    line-height: 1.1;
    letter-spacing: -0.5px;
  }

  .sd-price-amount small {
    font-size: 16px;
    font-weight: 700;
  }

  .sd-cta-stack {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .sd-btn-primary,
  .sd-btn-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    border-radius: var(--sd-radius-md);
    font-size: 14.5px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
  }

  .sd-btn-primary {
    background: var(--sd-primary);
    color: #fff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
  }

  .sd-btn-primary:hover {
    background: var(--sd-primary-hover);
    transform: translateY(-1px);
    color: #fff !important;
  }

  .sd-btn-outline {
    background: transparent;
    color: var(--sd-primary) !important;
    border: 1.5px solid var(--sd-primary);
  }

  .sd-btn-outline:hover {
    background: var(--sd-primary-soft);
    transform: translateY(-1px);
  }

  /* Company Card */
  .sd-company-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 22px 24px;
  }

  .sd-company-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 16px;
  }

  .sd-company-avatar-link {
    flex-shrink: 0;
    position: relative;
  }

  .sd-company-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--sd-primary-soft);
  }

  .sd-company-info {
    min-width: 0;
    flex: 1;
  }

  .sd-company-label {
    font-size: 11.5px;
    font-weight: 600;
    color: var(--sd-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: block;
    margin-bottom: 3px;
  }

  .sd-company-name-row {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .sd-company-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--sd-text-main);
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sd-company-name:hover {
    color: var(--sd-primary);
  }

  .sd-verified-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
  }

  .sd-company-actions {
    display: flex;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid var(--sd-border);
  }

  .sd-company-link-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: var(--sd-radius-sm);
    font-size: 13px;
    font-weight: 600;
    background: var(--sd-bg);
    color: var(--sd-text-main);
    border: 1px solid var(--sd-border);
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .sd-company-link-btn:hover {
    border-color: var(--sd-primary);
    color: var(--sd-primary);
  }

  .sd-report-row {
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px dashed var(--sd-border);
    text-align: center;
  }

  .sd-report-btn {
    background: none;
    border: none;
    color: var(--sd-text-muted);
    font-size: 12.5px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.2s ease;
  }

  .sd-report-btn:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.08);
  }

  /* --- Similar Services Section --- */
  .sd-similar-section {
    margin-top: 32px;
  }

  /* --- Mobile Sticky Bottom Bar --- */
  .sd-mobile-sticky-bar {
    display: none;
  }

  /* --- İletişim Bilgileri Popup Stilleri --- */
  .iletisim-popup {
    position: fixed;
    background: var(--sd-surface, #fff);
    border: 1px solid var(--sd-border, #e2e8f0);
    border-radius: 14px;
    box-shadow: 0 14px 36px rgba(15, 23, 42, 0.22);
    z-index: 1060;
    min-width: 280px;
    max-width: 340px;
    overflow: hidden;
  }

  .iletisim-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid var(--sd-border, #e9ecef);
    background: var(--sd-bg, #f8f9fa);
  }

  .iletisim-popup-title {
    margin: 0;
    font-size: 14.5px;
    font-weight: 700;
    color: var(--sd-text-main, #0f172a);
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .iletisim-popup-close {
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    color: var(--sd-text-muted, #64748b);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s;
  }

  .iletisim-popup-body {
    padding: 16px;
    text-align: center;
  }

  /* Fiyat Geçmişi Trigger Modern Stili */
  .sd-price-card .fiyat-gecmisi-trigger,
  .sd-mobile-inline-price .fiyat-gecmisi-trigger,
  .sd-mobile-sticky-bar .fiyat-gecmisi-trigger {
    color: var(--sd-text-muted);
    font-size: 13.5px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
  }

  .sd-price-card .fiyat-gecmisi-trigger:hover,
  .sd-mobile-inline-price .fiyat-gecmisi-trigger:hover,
  .sd-mobile-sticky-bar .fiyat-gecmisi-trigger:hover {
    color: var(--sd-primary);
    border-color: var(--sd-primary);
    background: var(--sd-primary-soft);
    transform: rotate(-35deg);
  }

  /* ==========================================================================
     RESPONSIVE: MOBILE HALF-SCREEN GALLERY & NATURAL SCROLL LAYOUT (< 992px)
     ========================================================================== */
  @media screen and (max-width: 991px) {
    /* 1. Reset Global Container / Bootstrap / main.css Asymmetric Paddings */
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

    /* 1) Mobilde Navbar Hiç Olmasın - Görseli Navbar Alanından Başlat */
    header {
      display: none !important;
    }

    .web-menu-col.modern-sidebar-col.d-none {
      display: block !important;
    }

    .index-right.sd-page-wrapper {
      margin-top: 0 !important;
      padding-top: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      padding-bottom: 92px !important;
      border: none !important;
      width: 100% !important;
      overflow-x: clip;
    }

    .sd-topbar {
      display: none !important;
    }

    /* 2. Flatten 2-Column Grid into Ordered Mobile Stack using display: contents */
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

    .sd-gallery-card {
      order: 1;
      border-radius: 0 !important;
      border: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      padding: 0 !important;
      margin: 0 !important;
      background: var(--sd-surface);
      width: 100% !important;
    }

    .sd-gallery-card.sd-single-photo {
      padding-bottom: 0 !important;
      overflow: hidden;
    }

    .sd-gallery-layout {
      flex-direction: column;
      gap: 0 !important;
      width: 100%;
    }

    /* 1) Ana Görsel Alanı: 4:3 Altın Oran ve Kusursuz Merkezlenmiş Kadraj */
    .sd-main-swiper {
      width: 100%;
      aspect-ratio: 4 / 3;
      height: auto !important;
      max-height: 48dvh;
      border-radius: 0;
      background: #0f172a;
    }

    .sd-main-swiper .swiper-slide {
      width: 100% !important;
      height: 100% !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
    }

    .sd-main-swiper .swiper-slide a.sd-slide-link {
      width: 100% !important;
      height: 100% !important;
      display: block !important;
    }

    .sd-main-swiper .swiper-slide img {
      aspect-ratio: 4 / 3 !important;
      width: 100% !important;
      height: 100% !important;
      max-height: none !important;
      object-fit: cover !important;
      object-position: center center !important;
      display: block !important;
    }

    .sd-gallery-nav-btn {
      width: 34px;
      height: 34px;
      font-size: 13px;
      background: rgba(15, 23, 42, 0.55);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
    }

    .sd-gallery-nav-btn.sd-gallery-prev {
      left: 10px;
    }

    .sd-gallery-nav-btn.sd-gallery-next {
      right: 10px;
    }

    /* Floating Top Bar inside Mobile Gallery (Safe Area Aware) */
    .sd-gallery-mobile-nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: absolute;
      top: 12px;
      top: max(12px, env(safe-area-inset-top, 12px));
      left: 12px;
      right: 12px;
      z-index: 6;
      pointer-events: none;
    }

    .sd-gallery-mobile-nav-group {
      display: flex;
      align-items: center;
      gap: 8px;
      pointer-events: auto;
    }

    .sd-mob-circle-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(15, 23, 42, 0.65);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.22);
      color: #fff !important;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
      padding: 0;
    }

    .sd-mob-circle-btn.is-saved {
      background: var(--sd-primary);
      border-color: var(--sd-primary);
    }

    /* 1) Ana görsel üzerindeki Büyüt ve Sayaç alanları mobilde kaldırıldı */
    .sd-gallery-zoom-hint,
    .sd-gallery-counter {
      display: none !important;
    }

    /* 2) Ana Görsel Altındaki Yatay Küçük Resimler: İnce ve Modern Border */
    .sd-thumb-swiper {
      width: 100% !important;
      height: 52px !important;
      padding: 5px 12px 6px !important;
      box-sizing: border-box;
      background: var(--sd-surface);
    }

    .sd-thumb-swiper .swiper-wrapper {
      flex-direction: row !important;
      align-items: center;
    }

    .sd-thumb-swiper .swiper-slide {
      width: 62px !important;
      height: 40px !important;
      border-radius: 6px !important;
      margin-bottom: 0 !important;
      border: 1px solid rgba(203, 213, 225, 0.8) !important;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
      opacity: 0.65;
      overflow: hidden;
      flex-shrink: 0;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body.dark .sd-thumb-swiper .swiper-slide {
      border: 1px solid rgba(255, 255, 255, 0.12) !important;
    }

    .sd-thumb-swiper .swiper-slide-thumb-active {
      opacity: 1 !important;
      border: 1.5px solid var(--sd-primary) !important;
      box-shadow: 0 2px 8px rgba(37, 99, 235, 0.22) !important;
      transform: scale(1.02);
    }

    /* 2) Başlık Kartı: Açıklama kartı ile arasında hiç boşluk ve border olmasın */
    .sd-header-card {
      order: 2;
      margin: 0 !important;
      padding: 16px 14px 12px !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      border-bottom: none !important;
      box-shadow: none !important;
    }

    /* Başlık Üzerindeki Kategori ve Konum Alanı Mobilde HİÇ OLMASIN */
    .sd-header-card .sd-badges-row {
      display: none !important;
    }

    .sd-title {
      font-size: 1.15rem;
      line-height: 1.35;
      margin-top: 0 !important;
      margin-bottom: 16px !important;
    }

    /* 2) Başlık Altındaki Hizmet Bedeli Alanını Kaldır */
    .sd-mobile-inline-price {
      display: none !important;
    }

    /* 2 & 4) Başlık Altındaki Özellik Kartları: Tek Satır, Yatay Kaydırmalı, İkonsuz, Ultra Modern Tasarım */
    .sd-quick-specs {
      display: flex !important;
      flex-wrap: nowrap !important;
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch !important;
      scroll-snap-type: x mandatory;
      gap: 10px !important;
      margin-top: 0 !important;
      padding-top: 0 !important;
      padding-bottom: 4px !important;
      margin-left: -14px !important;
      margin-right: -14px !important;
      padding-left: 14px !important;
      padding-right: 14px !important;
      border-top: none !important;
      scrollbar-width: none !important;
    }

    .sd-quick-specs::-webkit-scrollbar {
      display: none !important;
    }

    /* 2 & 4) Açıklama / Sekmeler Kartı: Başlık kartı ile arasında hiç boşluk ve border yok (order: 3) */
    .sd-tabs-card {
      order: 3 !important;
      margin: 0 0 10px 0 !important;
      padding: 0 !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      border-top: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
    }

    /* 3) Hizmet Veren Firma Kartı: Açıklama kartının altında (order: 4), genişlik tam ekran, border yok, sağ/sol boşluk sıfır */
    .sd-company-card {
      order: 4 !important;
      margin: 0 0 10px 0 !important;
      padding: 16px 14px !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
    }

    .sd-price-card {
      display: none !important;
    }

    /* 2) Başlık Altındaki Özellik Kartları: Hafif Saydam Mavi Arka Plan, İnce Mavi Border, Nokta Simgeli Modern Pill */
    .sd-spec-chip {
      flex: 0 0 auto !important;
      padding: 7px 14px !important;
      border-radius: 999px !important;
      background: rgba(37, 99, 235, 0.08) !important;
      border: 1px solid rgba(37, 99, 235, 0.22) !important;
      box-shadow: none !important;
      scroll-snap-align: start;
      display: inline-flex !important;
      flex-direction: row !important;
      align-items: center !important;
      justify-content: center !important;
      gap: 0 !important;
      transition: all 0.2s ease !important;
    }

    body.dark .sd-spec-chip {
      background: rgba(59, 130, 246, 0.12) !important;
      border-color: rgba(59, 130, 246, 0.28) !important;
    }

    /* Özellik önündeki nokta işareti (.) */
    .sd-chip-dot {
      display: inline-block !important;
      width: 5px;
      height: 5px;
      border-radius: 50%;
      background: var(--sd-primary, #2563eb);
      margin-right: 7px;
      flex-shrink: 0;
    }

    body.dark .sd-chip-dot {
      background: #60a5fa !important;
    }

    /* Mobilde kart içi ikonları kaldır */
    .sd-spec-chip .sd-spec-chip-icon {
      display: none !important;
    }

    /* Mobilde küçük başlıkları kaldır */
    .sd-spec-chip .sd-spec-chip-label {
      display: none !important;
    }

    .sd-spec-chip-content {
      display: inline-flex !important;
      align-items: center !important;
      width: auto !important;
      min-width: 0 !important;
    }

    .sd-spec-chip-value {
      font-size: 13px !important;
      font-weight: 600 !important;
      color: #1d4ed8 !important;
      white-space: nowrap !important;
      line-height: 1.2 !important;
      display: inline-block !important;
    }

    body.dark .sd-spec-chip-value {
      color: #93c5fd !important;
    }

    /* Compact Company Card on Mobile */
    .sd-company-header {
      gap: 12px;
      margin-bottom: 12px;
    }

    .sd-company-avatar {
      width: 52px;
      height: 52px;
    }

    .sd-company-name {
      font-size: 15px;
    }

    .sd-company-actions {
      padding-top: 12px;
      gap: 8px;
    }

    .sd-company-link-btn {
      padding: 8px 10px;
      font-size: 12.5px;
    }

    .sd-report-row {
      margin-top: 10px;
      padding-top: 10px;
    }

    /* Full-width balanced Tabs on Mobile */
    .sd-nav-tabs {
      padding: 0 6px;
      gap: 2px;
    }

    .sd-nav-tabs .nav-item {
      flex: 1;
      text-align: center;
    }

    .sd-nav-tabs .nav-link {
      width: 100%;
      padding: 12px 6px;
      font-size: 13px;
      gap: 5px;
    }

    .sd-tab-body {
      padding: 16px 14px 10px !important;
    }

    .sd-description-text {
      font-size: 14px;
      line-height: 1.65;
    }

    /* 3 & 4) Açıklama Kartında 3 Satır Kırpma ve "Daha fazla / Daha az" Butonu */
    .sd-description-text.sd-clamped {
      display: -webkit-box !important;
      -webkit-line-clamp: 3 !important;
      line-clamp: 3 !important;
      -webkit-box-orient: vertical !important;
      overflow: hidden !important;
    }

    .sd-desc-toggle-btn {
      display: none;
      align-items: center;
      gap: 5px;
      margin-top: 8px;
      padding: 0;
      background: transparent !important;
      border: none !important;
      color: var(--sd-primary, #2563eb) !important;
      font-size: 13.5px !important;
      font-weight: 600 !important;
      cursor: pointer;
      outline: none;
      box-shadow: none !important;
      transition: color 0.15s ease;
    }

    .sd-desc-toggle-btn i {
      font-size: 11px;
      transition: transform 0.2s ease;
    }

    .sd-desc-toggle-btn:active,
    .sd-desc-toggle-btn:hover {
      color: var(--sd-primary-hover, #1d4ed8) !important;
      text-decoration: underline;
    }

    body.dark .sd-desc-toggle-btn {
      color: #60a5fa !important;
    }

    .sd-specs-grid {
      grid-template-columns: 1fr;
      gap: 8px;
    }

    .sd-spec-row {
      padding: 11px 12px;
    }

    .sd-qa-form-card,
    .sd-qa-item {
      padding: 14px;
    }

    /* Similar Services on Mobile */
    .sd-similar-section {
      padding: 0 12px;
      margin-top: 16px;
      display: block !important;
    }

    .other-hizmets {
      display: block !important;
    }

    /* Footer spacing on Mobile */
    .sd-page-wrapper footer,
    .sd-page-wrapper footer.services-detail-footer {
      margin: 20px 12px 0 !important;
      width: auto !important;
      border-radius: 14px;
    }

    /* Fix #firmasikayeti modal on mobile (override main.css .login-modal fullscreen bug) */
    #firmasikayeti .modal-dialog {
      margin: 16px;
      display: flex;
      align-items: center;
      min-height: calc(100% - 32px);
    }

    #firmasikayeti .modal-content {
      position: relative !important;
      top: auto !important;
      bottom: auto !important;
      left: auto !important;
      right: auto !important;
      height: auto !important;
      max-height: 85dvh !important;
      border-radius: 16px !important;
      padding: 16px !important;
      width: 100% !important;
    }

    /* 4) Mobil Sabit Alt Menü: Fiyat Alanı ve Buton Arka Plan Renkleri Kontrolü */
    .sd-mobile-sticky-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      background: var(--sd-surface, #ffffff) !important;
      border-top: 1px solid var(--sd-border, #e2e8f0) !important;
      padding: 10px 14px calc(10px + env(safe-area-inset-bottom, 0px)) !important;
      box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.08) !important;
    }

    .sd-mob-price-col {
      display: flex;
      flex-direction: column;
      min-width: 0;
      background: transparent !important;
    }

    .sd-mob-price-sub {
      font-size: 10.5px !important;
      color: var(--sd-text-muted, #64748b) !important;
      font-weight: 600 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.3px !important;
      line-height: 1.1 !important;
      background: transparent !important;
    }

    .sd-mob-price-wrap {
      display: flex;
      align-items: center;
      gap: 6px;
      margin-top: 2px;
      background: transparent !important;
    }

    .sd-mob-price-val {
      font-size: 18.5px !important;
      font-weight: 800 !important;
      color: var(--sd-primary, #2563eb) !important;
      white-space: nowrap !important;
      line-height: 1.2 !important;
      background: transparent !important;
    }

    .sd-mobile-sticky-bar .fiyat-gecmisi-trigger {
      background: var(--sd-primary-soft, rgba(37, 99, 235, 0.08)) !important;
      color: var(--sd-primary, #2563eb) !important;
      border: 1px solid rgba(37, 99, 235, 0.22) !important;
      width: 28px !important;
      height: 28px !important;
      font-size: 12px !important;
      border-radius: 50% !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
    }

    .sd-mob-cta-group {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-shrink: 0;
      background: transparent !important;
    }

    /* "Ara" butonu: Soft mavi arka plan, net mavi yazı & border */
    .sd-mob-cta-group .sd-btn-outline {
      background: var(--sd-primary-soft, #eff6ff) !important;
      color: var(--sd-primary, #2563eb) !important;
      border: 1.5px solid var(--sd-primary, #2563eb) !important;
      padding: 10px 16px !important;
      font-size: 13.5px !important;
      font-weight: 600 !important;
      border-radius: 10px !important;
      text-decoration: none !important;
      box-shadow: none !important;
    }

    .sd-mob-cta-group .sd-btn-outline:active {
      background: rgba(37, 99, 235, 0.16) !important;
    }

    /* "Mesaj" butonu: Kurumsal canlı mavi arka plan, beyaz yazı & gölge */
    .sd-mob-cta-group .sd-btn-primary {
      background: var(--sd-primary, #2563eb) !important;
      color: #ffffff !important;
      border: 1.5px solid var(--sd-primary, #2563eb) !important;
      padding: 10px 18px !important;
      font-size: 13.5px !important;
      font-weight: 600 !important;
      border-radius: 10px !important;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3) !important;
      text-decoration: none !important;
    }

    .sd-mob-cta-group .sd-btn-primary:active {
      background: var(--sd-primary-hover, #1d4ed8) !important;
    }

    /* Dark Mode renk uyumu */
    body.dark .sd-mobile-sticky-bar {
      background: #18181b !important;
      border-top-color: #27272a !important;
    }

    body.dark .sd-mob-cta-group .sd-btn-outline {
      background: rgba(59, 130, 246, 0.15) !important;
      color: #60a5fa !important;
      border-color: #3b82f6 !important;
    }

    body.dark .sd-mob-cta-group .sd-btn-primary {
      background: #3b82f6 !important;
      border-color: #3b82f6 !important;
      color: #ffffff !important;
    }

    /* Hide global bottom bar so sticky service conversion bar sits cleanly */
    body .mobile-fixed-menu {
      display: none !important;
    }

    /* Center Cloned Price History Popup cleanly on Mobile */
    .fiyat-gecmisi-area.cloned:not(#login-popup) {
      position: fixed !important;
      top: 50% !important;
      left: 50% !important;
      right: auto !important;
      transform: translate(-50%, -50%) !important;
      margin-top: 0 !important;
      width: min(90vw, 340px) !important;
      padding: 16px !important;
      border-radius: 14px !important;
      box-shadow: 0 20px 50px rgba(15, 23, 42, 0.35) !important;
      z-index: 99999 !important;
    }

    .fiyat-gecmisi-area.cloned:not(#login-popup) .bottomarrow {
      display: none !important;
    }
  }
</style>
@endsection

@section('content')
@php
  $isSavedService = auth()->check()
      ? \App\Models\ServiceSaved::where('user_id', auth()->id())->where('service_id', $service->id)->exists()
      : false;
  $photoCount = $service->photos->count();
  $totalSlideCount = $photoCount + 1;
@endphp

<div class="main sidebar">
  <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
    <div class="index-right hizmet-detay-ziyaretci sd-page-wrapper">
      <div class="sd-container">

        {{-- Üst Breadcrumb & Hızlı Aksiyonlar (Masaüstü) --}}
        <div class="sd-topbar">
          <ol class="sd-breadcrumb">
            <li>
              <a href="{{ route('site.home') }}">
                <i class="fa-solid fa-house"></i> Anasayfa
              </a>
            </li>
            <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
            <li>
              <a href="{{ route('services.index') }}">Hizmetler</a>
            </li>
            @if($service->category)
              <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
              <li>
                <a href="{{ route('services.index', ['category' => $service->category_id]) }}">
                  {{ $service->category->name }}
                </a>
              </li>
            @endif
            @if($service->subCategory)
              <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
              <li>
                <a href="{{ route('services.index', ['category' => $service->category_id, 'sub_category' => $service->sub_category_id]) }}">
                  {{ $service->subCategory->name }}
                </a>
              </li>
            @endif
            <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
            <li class="sd-bc-current" title="{{ $service->title }}">{{ $service->title }}</li>
          </ol>

          <div class="sd-top-actions">
            <button type="button" class="sd-icon-action-btn" onclick="shareServiceLink(this)" title="Bağlantıyı Paylaş">
              <i class="fa-solid fa-share-nodes"></i>
              <span>Paylaş</span>
            </button>

            @auth
              <a href="{{ route('services.save', $service->slug) }}"
                 class="sd-icon-action-btn {{ $isSavedService ? 'is-saved' : '' }}"
                 title="{{ $isSavedService ? 'Kaydedildi' : 'Favorilere Kaydet' }}">
                <i class="{{ $isSavedService ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                <span>{{ $isSavedService ? 'Kaydedildi' : 'Kaydet' }}</span>
              </a>
            @else
              <button type="button"
                      class="sd-icon-action-btn"
                      onclick="showLoginPopup('Kaydetmek için giriş yapmalısınız!', this)">
                <i class="fa-regular fa-bookmark"></i>
                <span>Kaydet</span>
              </button>
            @endauth
          </div>
        </div>

        {{-- Ana 2 Kolonlu Grid (Mobilde CSS order ile Galeri -> Başlık/Fiyat -> Firma -> Sekmeler sırasına dönüşür) --}}
        <div class="sd-main-grid">

          {{-- SOL KOLON: Galeri + Başlık/Özet + Sekmeler --}}
          <div class="sd-left-col">

            {{-- 1. Görsel Galeri Kartı (Mobilde Yarım Ekran, Masaüstünde Geniş Galeri) --}}
            <div class="sd-gallery-card {{ $totalSlideCount <= 1 ? 'sd-single-photo' : '' }}">
              <div class="sd-gallery-layout">
                <div class="swiper sd-main-swiper">
                  {{-- Mobil Üst Yüzen Aksiyon Butonları --}}
                  <div class="sd-gallery-mobile-nav">
                    <div class="sd-gallery-mobile-nav-group">
                      <a href="{{ route('services.index') }}"
                         onclick="if(window.history.length > 1){ history.back(); return false; }"
                         class="sd-mob-circle-btn"
                         title="Geri Dön"
                         aria-label="Geri Dön">
                        <i class="fa-solid fa-arrow-left"></i>
                      </a>
                      <a href="{{ $service->category_id ? route('services.index', array_filter(['category' => $service->category_id, 'sub_category' => $service->sub_category_id])) : route('services.index') }}"
                         class="sd-mob-circle-btn"
                         title="{{ $service->category->name ?? 'Kategori Hizmetleri' }}"
                         aria-label="{{ $service->category->name ?? 'Kategori Hizmetleri' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                          <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                      </a>
                    </div>
                    <div class="sd-gallery-mobile-nav-group">
                      <button type="button"
                              class="sd-mob-circle-btn"
                              onclick="shareServiceLink(this)"
                              title="Paylaş"
                              aria-label="Paylaş">
                        <i class="fa-solid fa-share-nodes"></i>
                      </button>
                      @auth
                        <a href="{{ route('services.save', $service->slug) }}"
                           class="sd-mob-circle-btn {{ $isSavedService ? 'is-saved' : '' }}"
                           title="Kaydet"
                           aria-label="Kaydet">
                          <i class="{{ $isSavedService ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                        </a>
                      @else
                        <button type="button"
                                class="sd-mob-circle-btn"
                                onclick="showLoginPopup('Kaydetmek için giriş yapmalısınız!', this)"
                                title="Kaydet"
                                aria-label="Kaydet">
                          <i class="fa-regular fa-bookmark"></i>
                        </button>
                      @endauth
                    </div>
                  </div>

                  <div class="swiper-wrapper">
                    @forelse($service->photos as $photo)
                      <div class="swiper-slide">
                        <a href="{{ asset($photo->path) }}"
                           data-fancybox="gallery"
                           data-caption="{{ $service->title }}"
                           class="sd-slide-link">
                          <img src="{{ asset($photo->path) }}" alt="{{ $service->title }}" />
                        </a>
                      </div>
                    @empty
                      <div class="swiper-slide">
                        <img src="{{ asset('site/images/no-image.png') }}" alt="{{ $service->title }}" />
                      </div>
                    @endforelse

                    {{-- Galeri Sonu Sponsorlu Reklam Slide'ı --}}
                    <div class="swiper-slide sd-gallery-ad-slide">
                      <div class="sd-gallery-ad-wrapper">
                        <div class="sd-gallery-ad-badge">
                          <i class="fa-solid fa-rectangle-ad"></i> Sponsorlu Reklam
                        </div>
                        <div class="sd-gallery-ad-content">
                          <x-ad-slot format="auto" />
                        </div>
                      </div>
                    </div>
                  </div>

                  @if($totalSlideCount > 1)
                    <button type="button" class="sd-gallery-nav-btn sd-gallery-prev" aria-label="Önceki Görsel">
                      <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="sd-gallery-nav-btn sd-gallery-next" aria-label="Sonraki Görsel">
                      <i class="fa-solid fa-chevron-right"></i>
                    </button>
                  @endif

                  @if($photoCount > 0)
                    <div class="sd-gallery-zoom-hint" onclick="openFirstFancybox()">
                      <i class="fa-solid fa-magnifying-glass-plus"></i>
                      <span>Büyüt</span>
                    </div>
                    <div class="sd-gallery-counter">
                      <i class="fa-regular fa-images"></i>
                      <span id="sdSlideCurrent">1</span> / <span>{{ $totalSlideCount }}</span>
                    </div>
                  @endif
                </div>

                @if($totalSlideCount > 1)
                  <div thumbsSlider="" class="swiper sd-thumb-swiper">
                    <div class="swiper-wrapper">
                      @foreach($service->photos as $photo)
                        <div class="swiper-slide">
                          <img src="{{ asset($photo->path) }}" alt="{{ $service->title }}" loading="lazy" />
                        </div>
                      @endforeach

                      {{-- Küçük Önizleme Reklam İkonu --}}
                      <div class="swiper-slide sd-thumb-ad-slide" title="Sponsorlu Reklam">
                        <div class="sd-thumb-ad-box">
                          <i class="fa-solid fa-bullhorn"></i>
                          <span>Reklam</span>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            </div>

            {{-- 2. Hizmet Başlığı, Rozetler, Mobil Fiyat Satırı ve Hızlı Özet Bilgiler --}}
            <div class="sd-header-card">
              <div class="sd-badges-row">
                @if($service->category)
                  <a href="{{ route('services.index', ['category' => $service->category_id]) }}" class="sd-badge">
                    <i class="fa-solid fa-tag"></i>
                    {{ $service->category->name }}{{ $service->subCategory ? ' / ' . $service->subCategory->name : '' }}
                  </a>
                @endif

                @if($service->province || $service->district)
                  <span class="sd-badge sd-badge-location">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $service->province->name ?? '' }}{{ $service->district ? ' / ' . $service->district->name : '' }}
                  </span>
                @endif
              </div>

              <div class="sd-title-price-row">
                <h1 class="sd-title">{{ $service->title }}</h1>
              </div>

              {{-- Öne Çıkan Özellik Rozetleri (Quick Specs) --}}
              <div class="sd-quick-specs">
                @if($service->parameterValues->count() > 0)
                  @foreach($service->parameterValues->take(4) as $paramVal)
                    @php
                      $chipVal = $paramVal->value;
                      $paramTitleLower = mb_strtolower($paramVal->categoryParameter->title ?? '', 'UTF-8');
                      if (\Illuminate\Support\Str::contains($paramTitleLower, ['alan', 'm2', 'm²', 'metrekare', 'yüzölçüm', 'yuzolcum']) && !\Illuminate\Support\Str::contains(mb_strtolower($chipVal, 'UTF-8'), ['m2', 'm²'])) {
                          $chipVal = trim($chipVal) . ' m²';
                      }
                    @endphp
                    <div class="sd-spec-chip">
                      <span class="sd-chip-dot"></span>
                      <div class="sd-spec-chip-icon">
                        <i class="fa-solid fa-sliders"></i>
                      </div>
                      <div class="sd-spec-chip-content">
                        <span class="sd-spec-chip-label">{{ $paramVal->categoryParameter->title }}</span>
                        <span class="sd-spec-chip-value" title="{{ $chipVal }}">{{ $chipVal }}</span>
                      </div>
                    </div>
                  @endforeach
                @else
                  @if($service->rooms)
                    <div class="sd-spec-chip">
                      <span class="sd-chip-dot"></span>
                      <div class="sd-spec-chip-icon">
                        <i class="fa-solid fa-door-open"></i>
                      </div>
                      <div class="sd-spec-chip-content">
                        <span class="sd-spec-chip-label">Oda Sayısı</span>
                        <span class="sd-spec-chip-value">{{ $service->rooms }}</span>
                      </div>
                    </div>
                  @endif
                  @if($service->sqm)
                    <div class="sd-spec-chip">
                      <span class="sd-chip-dot"></span>
                      <div class="sd-spec-chip-icon">
                        <i class="fa-solid fa-ruler-combined"></i>
                      </div>
                      <div class="sd-spec-chip-content">
                        <span class="sd-spec-chip-label">Alan</span>
                        <span class="sd-spec-chip-value">{{ $service->sqm }} m²</span>
                      </div>
                    </div>
                  @endif
                @endif

                {{-- Kategori Kartı (Konumun hemen solunda) --}}
                <div class="sd-spec-chip">
                  <span class="sd-chip-dot"></span>
                  <div class="sd-spec-chip-icon">
                    <i class="fa-solid fa-layer-group"></i>
                  </div>
                  <div class="sd-spec-chip-content">
                    <span class="sd-spec-chip-label">Kategori</span>
                    <span class="sd-spec-chip-value" title="{{ $service->category->name ?? 'Belirtilmemiş' }} / {{ $service->subCategory->name ?? '' }}">
                      {{ $service->subCategory->name ?? ($service->category->name ?? 'Belirtilmemiş') }}
                    </span>
                  </div>
                </div>

                {{-- Bölge / Konum Kartı (En Sonda) --}}
                <div class="sd-spec-chip">
                  <span class="sd-chip-dot"></span>
                  <div class="sd-spec-chip-icon">
                    <i class="fa-solid fa-map-location-dot"></i>
                  </div>
                  <div class="sd-spec-chip-content">
                    <span class="sd-spec-chip-label">Bölge / Konum</span>
                    <span class="sd-spec-chip-value" title="{{ $service->province->name ?? '' }} / {{ $service->district->name ?? '' }}">
                      {{ $service->province->name ?? 'Belirtilmemiş' }}{{ $service->district ? ' / ' . $service->district->name : '' }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            {{-- 3. Birleştirilmiş Modern Sekmeler: Açıklama | Özellikler | Soru & Cevap --}}
            <div class="sd-tabs-card" id="sdTabsCard">
              <ul class="nav nav-tabs sd-nav-tabs" id="sdServiceTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="sd-tab-desc-btn" type="button" role="tab" aria-selected="true" data-sd-target="#sd-pane-desc">
                    <i class="fa-regular fa-file-lines"></i>
                    <span>Açıklama</span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="sd-tab-specs-btn" type="button" role="tab" aria-selected="false" data-sd-target="#sd-pane-specs">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Özellikler</span>
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="sd-tab-qa-btn" type="button" role="tab" aria-selected="false" data-sd-target="#sd-pane-qa">
                    <i class="fa-regular fa-comments"></i>
                    <span>Soru & Cevap</span>
                    <span class="sd-tab-badge">{{ $questions->total() }}</span>
                  </button>
                </li>
              </ul>

              <div class="tab-content sd-tab-body">
                {{-- TAB 1: Açıklama --}}
                <div class="tab-pane fade show active" id="sd-pane-desc" role="tabpanel">
                  <div class="sd-desc-wrapper">
                    <p class="sd-description-text sd-clamped" id="sdDescText">{{ $service->description }}</p>
                    <button type="button" class="sd-desc-toggle-btn" id="sdDescToggleBtn" onclick="toggleServiceDescription()" aria-expanded="false" style="display: none;">
                      <span class="sd-desc-toggle-text">Daha fazla</span>
                      <i class="fa-solid fa-chevron-down ms-1"></i>
                    </button>
                  </div>
                </div>

                {{-- TAB 2: Özellikler --}}
                <div class="tab-pane fade" id="sd-pane-specs" role="tabpanel">
                  <div class="sd-specs-grid">
                    @if($service->parameterValues->count() > 0)
                      @foreach($service->parameterValues as $parameterValue)
                        @php
                          $rowVal = $parameterValue->value;
                          $rowTitleLower = mb_strtolower($parameterValue->categoryParameter->title ?? '', 'UTF-8');
                          if (\Illuminate\Support\Str::contains($rowTitleLower, ['alan', 'm2', 'm²', 'metrekare', 'yüzölçüm', 'yuzolcum']) && !\Illuminate\Support\Str::contains(mb_strtolower($rowVal, 'UTF-8'), ['m2', 'm²'])) {
                              $rowVal = trim($rowVal) . ' m²';
                          }
                        @endphp
                        <div class="sd-spec-row">
                          <span class="sd-spec-row-label">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ $parameterValue->categoryParameter->title }}
                          </span>
                          <span class="sd-spec-row-val">{{ $rowVal }}</span>
                        </div>
                      @endforeach
                    @else
                      @if($service->sqm)
                        <div class="sd-spec-row">
                          <span class="sd-spec-row-label">
                            <i class="fa-solid fa-ruler-combined"></i> Metrekare
                          </span>
                          <span class="sd-spec-row-val">{{ $service->sqm }} m²</span>
                        </div>
                      @endif
                      @if($service->rooms)
                        <div class="sd-spec-row">
                          <span class="sd-spec-row-label">
                            <i class="fa-solid fa-door-open"></i> Oda Sayısı
                          </span>
                          <span class="sd-spec-row-val">{{ $service->rooms }}</span>
                        </div>
                      @endif
                    @endif

                    <div class="sd-spec-row">
                      <span class="sd-spec-row-label">
                        <i class="fa-solid fa-tag"></i> Kategori
                      </span>
                      <span class="sd-spec-row-val">
                        {{ $service->category->name ?? 'Belirtilmemiş' }} / {{ $service->subCategory->name ?? 'Belirtilmemiş' }}
                      </span>
                    </div>

                    <div class="sd-spec-row">
                      <span class="sd-spec-row-label">
                        <i class="fa-solid fa-location-dot"></i> Konum
                      </span>
                      <span class="sd-spec-row-val">
                        {{ $service->province->name ?? 'Belirtilmemiş' }} / {{ $service->district->name ?? 'Belirtilmemiş' }}
                      </span>
                    </div>
                  </div>
                </div>

                {{-- TAB 3: Soru & Cevap --}}
                <div class="tab-pane fade" id="sd-pane-qa" role="tabpanel">
                  @auth()
                    @if((auth()->user()->user_type == 'company' && auth()->user()->company->id != $service->company_id) || auth()->user()->user_type == 'user')
                      <form action="{{ route('services.question', $service->slug) }}" method="POST" class="sd-qa-form-card">
                        @csrf
                        <div class="sd-qa-form-title">
                          <i class="fa-regular fa-circle-question text-primary"></i>
                          <span>Firmaya bu hizmet hakkında soru sorun</span>
                        </div>
                        <textarea name="question"
                                  rows="3"
                                  placeholder="Hizmet detayları, süreç veya merak ettikleriniz..."
                                  class="sd-qa-textarea"
                                  maxlength="1900"
                                  required>{{ old('question') }}</textarea>
                        <div class="sd-qa-submit-row">
                          <button class="sd-btn-primary" type="submit">
                            <i class="fa-regular fa-paper-plane"></i> Soruyu Gönder
                          </button>
                        </div>
                      </form>
                    @endif
                  @else
                    <div class="sd-guest-login-banner" onclick="openLoginModal()">
                      <span class="sd-guest-login-banner-text">
                        <i class="fa-solid fa-lock me-2 text-primary"></i>
                        Hizmet veren firmaya soru sormak için lütfen giriş yapın.
                      </span>
                      <span class="sd-btn-primary sd-guest-login-banner-btn">Giriş Yap</span>
                    </div>
                  @endauth

                  <div class="sd-qa-list">
                    @forelse($questions as $question)
                      <div class="sd-qa-item">
                        <div class="sd-qa-header">
                          <div class="sd-qa-user">
                            <img src="{{ asset(auth_info($question->user_id)->avatar) }}"
                                 alt="{{ auth_info($question->user_id)->name }}">
                            <div class="sd-qa-user-meta">
                              <span class="sd-qa-user-name">{{ auth_info($question->user_id)->name }}</span>
                              <span class="sd-qa-time">
                                {{ change_timezone($question->created_at, 'd.m.Y') }} • {{ change_timezone($question->created_at, 'H:i') }}
                              </span>
                            </div>
                          </div>

                          @if((auth()->check() && auth()->user()->user_type == 'company' && $service->company_id == auth()->user()->company->id) || (auth()->check() && auth()->user()->id == $question->user_id))
                            <form action="{{ route('services.question.destroy', [$service->slug, $question->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Bu soruyu silmek istediğinize emin misiniz?');">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="sd-qa-delete-btn" title="Soruyu Sil">
                                <i class="fa-solid fa-trash-can"></i>
                              </button>
                            </form>
                          @endif
                        </div>

                        <p class="sd-qa-question-text">{{ $question->question }}</p>

                        @if($question->answer)
                          <div class="sd-qa-answer-box">
                            <div class="sd-qa-answer-header">
                              <i class="fa-solid fa-reply"></i>
                              <span>{{ $service->company->name }} Yanıtı</span>
                            </div>
                            <p class="sd-qa-answer-text">{{ $question->answer }}</p>
                          </div>
                        @endif

                        @if(auth()->check() && auth()->user()->user_type == 'company' && $service->company_id == auth()->user()->company->id)
                          <form action="{{ route('services.answer', $service->slug) }}" method="POST" class="mt-3 pt-3 border-top">
                            @csrf
                            <input name="question" type="hidden" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($question->id) }}">
                            <textarea name="answer"
                                      rows="3"
                                      class="sd-qa-textarea"
                                      placeholder="Müşterinin sorusunu yanıtlayın..."
                                      required>{{ old('answer', $question->answer) }}</textarea>
                            <div class="sd-qa-submit-row">
                              <button type="submit" class="sd-btn-primary">
                                {{ !$question->answer ? 'Cevapla' : 'Cevabı Güncelle' }}
                              </button>
                            </div>
                          </form>
                        @endif
                      </div>
                    @empty
                      <div class="text-center py-4 text-muted">
                        <i class="fa-regular fa-comments fs-2 mb-2 d-block opacity-50"></i>
                        <span>Bu hizmet için henüz soru sorulmamış. İlk soruyu siz sorabilirsiniz!</span>
                      </div>
                    @endforelse
                  </div>

                  <div class="mt-3">
                    {{ $questions->links() }}
                  </div>
                </div>
              </div>
            </div>

          </div>

          {{-- SAĞ KOLON: Sticky Fiyat Kartı & Firma Güven Kartı --}}
          <aside class="sd-sidebar">

            {{-- Masaüstü Fiyat & İletişim Kartı --}}
            <div class="sd-price-card">
              <span class="sd-price-label">Hizmet Bedeli</span>
              <div class="sd-price-value-row">
                <div class="sd-price-amount">
                  {{ number_format($service->price, 0, ',', '.') }} <small>TL</small>
                </div>
                <div class="psd-prices-left d-flex align-items-center">
                  <x-old-prices :prices="$service->oldPrices" />
                </div>
              </div>

              <div class="sd-cta-stack">
                <a class="sd-btn-primary"
                   @auth() href="{{ route('chat.show', $service->company->user_id) }}" @endauth
                   @guest() data-bs-toggle="modal" href="#exampleModalToggle" @endguest>
                  <i class="fa-regular fa-comment-dots"></i>
                  <span>Mesaj</span>
                </a>

                <a class="sd-btn-outline ara-button"
                   href="javascript:void(0)"
                   onclick="showIletisimPopup(this)">
                  <i class="fa-solid fa-phone"></i>
                  <span>Ara</span>
                </a>
              </div>
            </div>

            {{-- Firma Profili & Güven Kartı (Mobilde Başlık Kartının Hemen Altında Gösterilir) --}}
            <div class="sd-company-card">
              <div class="sd-company-header">
                <a href="{{ route('companies.show', $service->company->slug) }}" class="sd-company-avatar-link">
                  <img src="{{ asset($service->company->avatar) }}"
                       alt="{{ $service->company->name }}"
                       class="sd-company-avatar">
                </a>
                <div class="sd-company-info">
                  <span class="sd-company-label">Hizmet Veren Firma</span>
                  <div class="sd-company-name-row">
                    <a href="{{ route('companies.show', $service->company->slug) }}" class="sd-company-name" title="{{ $service->company->name }}">
                      {{ $service->company->name }}
                    </a>
                    @if($service->company->is_verified == 1)
                      <img src="{{ asset('site/images/success.png') }}" alt="Onaylı Firma" class="sd-verified-icon" title="Onaylı Firma">
                    @endif
                  </div>
                </div>
              </div>

              <div class="sd-company-actions">
                <a href="{{ route('companies.show', $service->company->slug) }}" class="sd-company-link-btn">
                  <i class="fa-solid fa-store"></i>
                  <span>Tüm Hizmetler</span>
                </a>

                @auth()
                  @if(auth()->user()->id != $service->company->user_id)
                    <form action="{{ route('company.follow') }}" method="POST" class="flex-grow-1 d-flex m-0">
                      @csrf
                      <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($service->company->user_id) }}">
                      <button type="submit" class="sd-company-link-btn w-100">
                        @if(!auth()->user()->following($service->company->user_id))
                          <i class="fa-solid fa-user-plus"></i>
                          <span>Takip Et</span>
                        @else
                          <i class="fa-solid fa-user-check text-primary"></i>
                          <span>Takipten Çık</span>
                        @endif
                      </button>
                    </form>
                  @endif
                @else
                  <button type="button"
                          class="sd-company-link-btn"
                          onclick="showLoginPopup('Firmayı takip etmek için giriş yapmalısınız!', this)">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Takip Et</span>
                  </button>
                @endauth
              </div>

              <div class="sd-report-row">
                @auth()
                  <button type="button" class="sd-report-btn" data-bs-toggle="modal" data-bs-target="#firmasikayeti">
                    <i class="fa-solid fa-flag"></i>
                    <span>Hizmet ile ilgili şikayet bildir</span>
                  </button>
                @else
                  <button type="button"
                          class="sd-report-btn"
                          onclick="showLoginPopup('Şikayet bildirmek için giriş yapmalısınız!', this)">
                    <i class="fa-solid fa-flag"></i>
                    <span>Hizmet ile ilgili şikayet bildir</span>
                  </button>
                @endauth
              </div>
            </div>

          </aside>

        </div>

        {{-- Benzer Hizmetler Üstü Duyarlı Reklam Alanı --}}
        <div class="sd-similar-ad-wrapper my-4 text-center">
          <div class="sd-ad-badge-line mb-2">
            <span class="sd-ad-badge-text"><i class="fa-solid fa-rectangle-ad me-1"></i> Sponsorlu Reklam</span>
          </div>
          <x-ad-slot format="auto" class="sd-similar-ad-slot" />
        </div>

        {{-- Benzer Hizmetler (Masaüstü & Mobil Görünür) --}}
        @if($similarServices->count() > 0)
          <div class="other-hizmets sd-similar-section">
            <div class="popular-services">
              <div class="cs-title d-flex cs-title-link">
                <div class="ctl-left">
                  <i class="fa-solid fa-business-time"></i>
                  <h2>Benzer Hizmetler</h2>
                </div>
                <div class="ctl-right">
                  <a href="{{ route('services.index') }}" class="cs-all-link">
                    Tüm Hizmetler <i class="fa-solid fa-angle-right"></i>
                  </a>
                </div>
              </div>
              <div class="popular-slider">
                <div class="swiper mySwiper3">
                  <div class="swiper-wrapper">
                    @foreach($similarServices as $similarService)
                      <div class="swiper-slide">
                        @include('site.services.partials.single-service-card', ['service' => $similarService])
                      </div>
                    @endforeach
                  </div>
                  <div class="swiper-pagination"></div>
                </div>
              </div>
            </div>
          </div>
        @endif

      </div>

      @include('site.home.footer')
    </div>
  </div>
</div>

{{-- Mobil Sabit Alt Dönüşüm Çubuğu (Sticky Conversion Bar) --}}
<div class="sd-mobile-sticky-bar">
  <div class="sd-mob-price-col">
    <span class="sd-mob-price-sub">Hizmet Bedeli</span>
    <div class="sd-mob-price-wrap">
      <span class="sd-mob-price-val">{{ number_format($service->price, 0, ',', '.') }} TL</span>
      <div class="psd-prices-left d-flex align-items-center">
        <x-old-prices :prices="$service->oldPrices" />
      </div>
    </div>
  </div>
  <div class="sd-mob-cta-group">
    <a class="sd-btn-outline ara-button" href="javascript:void(0)" onclick="showIletisimPopup(this)">
      <i class="fa-solid fa-phone"></i>
      <span>Ara</span>
    </a>
    <a class="sd-btn-primary"
       @auth() href="{{ route('chat.show', $service->company->user_id) }}" @endauth
       @guest() data-bs-toggle="modal" href="#exampleModalToggle" @endguest>
      <i class="fa-regular fa-comment-dots"></i>
      <span>Mesaj</span>
    </a>
  </div>
</div>

{{-- İletişim Bilgileri Popup --}}
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
      <strong>{{ $service->company->authorized ?: $service->company->name }}</strong>
    </p>
    <a href="tel:{{ $service->company->mobile_phone }}"
       class="sd-btn-primary mt-3 w-100"
       style="text-decoration: none;">
      <i class="fa-solid fa-phone-volume"></i>
      <span>{{ $service->company->mobile_phone }}</span>
    </a>
  </div>
</div>

@auth()
<div class="modal fade login-modal" id="firmasikayeti" tabindex="-1" aria-labelledby="firmasikayetiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="firmasikayetiLabel">Hizmet Şikayeti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('services.report', $service->slug) }}" method="POST">
          <div class="firma-sikayeti-box">
            <textarea id="w3review" name="message" rows="4" cols="50" maxlength="4800" required placeholder="Şikayetinizi detaylıca yazınız..."></textarea>
            @csrf
            <div class="login-button">
              <button type="submit">Gönder</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endauth
@endsection

@section('js')
<script>
  function openLoginModal() {
    const headerLoginModal = document.getElementById('exampleModalToggle');
    if (headerLoginModal) {
      const loginModal = bootstrap.Modal.getOrCreateInstance(headerLoginModal);
      loginModal.show();
    }
  }

  // Ekran dışına taşmayı önleyen mobil/masaüstü uyumlu Giriş Yap uyarısı
  function showLoginPopup(message, triggerElement) {
    const popup = document.getElementById('login-popup');
    const messageElement = document.getElementById('login-popup-message');

    if (!popup || !messageElement || !triggerElement) {
      openLoginModal();
      return;
    }

    messageElement.textContent = message;
    const rect = triggerElement.getBoundingClientRect();
    const isMobile = window.innerWidth <= 991;

    popup.style.display = 'block';
    popup.style.position = 'fixed';
    popup.style.zIndex = '1065';

    const popupWidth = isMobile ? 250 : 236;
    popup.style.width = popupWidth + 'px';

    let left = rect.left + (rect.width / 2) - (popupWidth / 2);
    if (left < 12) left = 12;
    if (left + popupWidth > window.innerWidth - 12) {
      left = window.innerWidth - popupWidth - 12;
    }

    // Üstteki butonlarda (ör. mobil galeri üst bar) popup'ı butonun altına aç
    let top = rect.top - 125;
    if (top < 60) {
      top = rect.bottom + 10;
    }

    popup.style.left = left + 'px';
    popup.style.right = 'auto';
    popup.style.top = top + 'px';
    popup.style.transform = 'none';
    popup.classList.add('show');

    setTimeout(() => {
      if (typeof closeLoginPopup === 'function') {
        closeLoginPopup();
      }
    }, 4500);
  }

  function openFirstFancybox() {
    const activeSlideLink = document.querySelector('.sd-main-swiper .swiper-slide-active .sd-slide-link')
      || document.querySelector('.sd-main-swiper .sd-slide-link');
    if (activeSlideLink) {
      activeSlideLink.click();
    }
  }

  function shareServiceLink(btn) {
    const url = window.location.href;
    const title = @json($service->title);

    if (navigator.share && window.innerWidth <= 991) {
      navigator.share({ title: title, url: url }).catch(() => {});
      return;
    }

    navigator.clipboard.writeText(url).then(() => {
      const originalHtml = btn.innerHTML;
      const hasSpan = btn.querySelector('span');
      btn.innerHTML = hasSpan
        ? '<i class="fa-solid fa-check"></i><span>Kopyalandı</span>'
        : '<i class="fa-solid fa-check"></i>';
      if (window.toastr) {
        toastr.success('Hizmet bağlantısı panoya kopyalandı!', 'Başarılı');
      }
      setTimeout(() => {
        btn.innerHTML = originalHtml;
      }, 3000);
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    // 1. Galeri Swiper (Masaüstünde dikey küçük resimler, Mobilde yatay şerit)
    const thumbEl = document.querySelector('.sd-thumb-swiper');
    let sdThumbSwiper = null;

    if (thumbEl) {
      sdThumbSwiper = new Swiper('.sd-thumb-swiper', {
        direction: window.innerWidth > 991 ? 'vertical' : 'horizontal',
        slidesPerView: 'auto',
        spaceBetween: 8,
        freeMode: true,
        watchSlidesProgress: true,
        observer: true,
        observeParents: true,
      });

      window.addEventListener('resize', function() {
        if (!sdThumbSwiper) return;
        const newDir = window.innerWidth > 991 ? 'vertical' : 'horizontal';
        if (sdThumbSwiper.params.direction !== newDir) {
          sdThumbSwiper.changeDirection(newDir);
          sdThumbSwiper.update();
        }
      });
    }

    const mainEl = document.querySelector('.sd-main-swiper');
    if (mainEl) {
      const slideCount = mainEl.querySelectorAll('.swiper-slide').length;
      new Swiper('.sd-main-swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: false,
        observer: true,
        observeParents: true,
        navigation: {
          nextEl: '.sd-gallery-next',
          prevEl: '.sd-gallery-prev',
        },
        thumbs: sdThumbSwiper ? { swiper: sdThumbSwiper } : undefined,
        on: {
          slideChange: function() {
            const counterEl = document.getElementById('sdSlideCurrent');
            if (counterEl) {
              counterEl.textContent = (this.realIndex + 1);
            }
          }
        }
      });
    }

    // 2. Birleştirilmiş Modern Sekme Geçişleri
    const tabButtons = document.querySelectorAll('#sdServiceTabs .nav-link[data-sd-target]');
    const tabPanes = document.querySelectorAll('.sd-tabs-card .tab-pane');

    function activateServiceTab(targetSelector) {
      const targetPane = document.querySelector(targetSelector);
      const targetBtn = document.querySelector(`#sdServiceTabs .nav-link[data-sd-target="${targetSelector}"]`);
      if (!targetPane || !targetBtn) return;

      tabButtons.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      tabPanes.forEach(p => {
        p.classList.remove('show', 'active');
      });

      targetBtn.classList.add('active');
      targetBtn.setAttribute('aria-selected', 'true');
      targetPane.classList.add('show', 'active');

      if (targetSelector === '#sd-pane-desc') {
        setTimeout(initServiceDescClamp, 30);
      }
    }

    tabButtons.forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        activateServiceTab(this.getAttribute('data-sd-target'));
      });
    });

    // Soru & Cevap sayfalama (?page=) veya #sd-pane-qa varsa otomatik Soru & Cevap sekmesini aç
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('page') || window.location.hash === '#sd-pane-qa') {
      activateServiceTab('#sd-pane-qa');
    }

    // 3 & 4. Mobil Açıklama Metni Kırpma (3 Satır) ve "Daha fazla / Daha az" Butonu
    function initServiceDescClamp() {
      const descEl = document.getElementById('sdDescText');
      const toggleBtn = document.getElementById('sdDescToggleBtn');
      if (!descEl || !toggleBtn) return;

      if (window.innerWidth <= 991) {
        // Eğer zaten kullanıcı tarafından elle açılmışsa ("Daha az" durumundaysa) zorla kapatma
        const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        if (!isExpanded) {
          descEl.classList.add('sd-clamped');
        }

        // Kırpma durumunda taşma var mı kontrol et
        const wasClamped = descEl.classList.contains('sd-clamped');
        if (!wasClamped) descEl.classList.add('sd-clamped');
        const hasOverflow = descEl.scrollHeight > descEl.clientHeight + 4;
        if (!wasClamped && isExpanded) descEl.classList.remove('sd-clamped');

        if (hasOverflow) {
          toggleBtn.style.display = 'inline-flex';
          const isCurrentlyClamped = descEl.classList.contains('sd-clamped');
          const textSpan = toggleBtn.querySelector('.sd-desc-toggle-text');
          const icon = toggleBtn.querySelector('i');
          if (textSpan) textSpan.textContent = isCurrentlyClamped ? 'Daha fazla' : 'Daha az';
          if (icon) icon.className = isCurrentlyClamped ? 'fa-solid fa-chevron-down ms-1' : 'fa-solid fa-chevron-up ms-1';
        } else {
          toggleBtn.style.display = 'none';
          descEl.classList.remove('sd-clamped');
        }
      } else {
        descEl.classList.remove('sd-clamped');
        toggleBtn.style.display = 'none';
      }
    }

    initServiceDescClamp();
    window.addEventListener('resize', initServiceDescClamp);
  });

  // Açıklama "Daha fazla / Daha az" Açma-Kapatma Fonksiyonu
  function toggleServiceDescription() {
    const descEl = document.getElementById('sdDescText');
    const toggleBtn = document.getElementById('sdDescToggleBtn');
    if (!descEl || !toggleBtn) return;

    const isClamped = descEl.classList.contains('sd-clamped');
    const textSpan = toggleBtn.querySelector('.sd-desc-toggle-text');
    const icon = toggleBtn.querySelector('i');

    if (isClamped) {
      descEl.classList.remove('sd-clamped');
      toggleBtn.setAttribute('aria-expanded', 'true');
      if (textSpan) textSpan.textContent = 'Daha az';
      if (icon) icon.className = 'fa-solid fa-chevron-up ms-1';
    } else {
      descEl.classList.add('sd-clamped');
      toggleBtn.setAttribute('aria-expanded', 'false');
      if (textSpan) textSpan.textContent = 'Daha fazla';
      if (icon) icon.className = 'fa-solid fa-chevron-down ms-1';
    }
  }

  // İletişim Bilgileri Popup Fonksiyonları
  function showIletisimPopup(buttonElement) {
    const popup = document.getElementById('iletisimBilgileriPopup');
    if (!popup || !buttonElement) return;

    const rect = buttonElement.getBoundingClientRect();
    popup.style.display = 'block';

    const popupHeight = popup.offsetHeight;
    const popupWidth = popup.offsetWidth;
    const windowWidth = window.innerWidth;
    const windowHeight = window.innerHeight;

    let left = rect.left + (rect.width / 2) - (popupWidth / 2);
    if (left < 12) left = 12;
    if (left + popupWidth > windowWidth - 12) left = windowWidth - popupWidth - 12;

    // Eğer buton ekranın alt kısmındaysa (mobil sticky bar gibi), popup'ı üstüne aç
    let top = rect.bottom + 10;
    if (rect.bottom + popupHeight + 20 > windowHeight) {
      top = Math.max(56, rect.top - popupHeight - 10);
    }

    popup.style.left = left + 'px';
    popup.style.top = top + 'px';

    setTimeout(() => {
      document.addEventListener('click', closeIletisimPopupOnOutsideClick);
    }, 50);
  }

  function closeIletisimPopup() {
    const popup = document.getElementById('iletisimBilgileriPopup');
    if (popup) {
      popup.style.display = 'none';
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
</script>
@endsection