@extends('site.inc.master')

@section('css')
<style>
  /* ==========================================================================
     Modern Idea Detail Page (Desktop 2-Column & Mobile Half-Screen Redesign)
     Cohesive Design System matching Service Detail Page
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

  .main.sidebar {
    padding-left: 0 !important;
  }

  #index-right-area {
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    width: 100% !important;
  }

  .plus {
    display: none !important;
  }

  :root,
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
  }

  body.dark,
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

  .sd-page-wrapper {
    background-color: var(--sd-bg) !important;
    padding: 20px 24px 40px !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    min-height: 100vh;
    border: none !important;
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

  .sd-icon-action-btn.is-liked {
    background: rgba(239, 68, 68, 0.1);
    border-color: #ef4444;
    color: #ef4444;
  }

  /* --- Main Two-Column Grid --- */
  .sd-main-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 420px;
    gap: 20px;
    align-items: start;
  }

  .sd-left-col {
    min-width: 0;
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    overflow: hidden;
  }

  /* --- Gallery Card --- */
  .sd-gallery-card {
    background: transparent;
    border-radius: 0;
    border: none;
    box-shadow: none;
    padding: 16px 16px 8px 16px;
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

  .sd-main-swiper .swiper-slide video {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
    background: #000;
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

  /* Swiper Navigation Arrows */
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
    position: relative;
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

  .sd-video-thumb-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.4);
    color: #fff;
    font-size: 16px;
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

  /* --- Idea Info & Quick Specs Header Area --- */
  .sd-header-card {
    background: transparent !important;
    border-radius: 0 !important;
    border: none !important;
    box-shadow: none !important;
    padding: 4px 16px 14px 16px !important;
    margin: 0 !important;
  }

  .sd-badges-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 0;
  }

  .sd-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 500;
    background: var(--sd-primary-soft);
    color: var(--sd-primary);
    text-decoration: none;
    transition: all 0.2s ease;
  }

  a.sd-badge:hover {
    background: var(--sd-primary);
    color: #ffffff !important;
  }

  .sd-title {
    font-size: clamp(1.2rem, 1.05rem + 0.65vw, 1.65rem);
    font-weight: 700;
    color: var(--sd-text-main);
    line-height: 1.35;
    margin: 0;
    word-break: break-word;
  }

  /* Quick Highlights Strip */
  .sd-quick-specs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(145px, 1fr));
    gap: 12px;
    margin-top: 14px;
    padding-top: 0;
    border-top: none;
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

  /* --- Content Description Area --- */
  .sd-desc-card {
    background: transparent;
    border-top: 1px solid var(--sd-border);
    padding: 16px 20px 24px;
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
    transition: all 0.2s ease;
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

  .sd-desc-toggle-btn:hover {
    color: var(--sd-primary-hover, #1d4ed8) !important;
    text-decoration: underline;
  }

  /* Most Liked Reply Highlight Card */
  .sd-highlight-comment-card {
    margin-top: 20px;
    padding: 16px 18px;
    border-radius: var(--sd-radius-md);
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.05) 0%, rgba(37, 99, 235, 0.01) 100%);
    border: 1px solid rgba(37, 99, 235, 0.2);
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.04);
  }

  .sd-highlight-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
  }

  .sd-highlight-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--sd-primary);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
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

  /* Comments & Discussion Section */
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
    text-decoration: none;
  }

  .sd-qa-user-name:hover {
    color: var(--sd-primary);
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
    text-decoration: none;
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

  .sd-comment-actions-bar {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(226, 232, 240, 0.6);
  }

  .sd-comment-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--sd-text-muted);
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.2s ease;
  }

  .sd-comment-action-btn:hover,
  .sd-comment-action-btn.is-liked {
    color: var(--sd-primary);
    background: var(--sd-primary-soft);
  }

  .sd-reply-form-box {
    margin-top: 12px;
    padding: 12px;
    border-radius: var(--sd-radius-sm);
    background: var(--sd-surface);
    border: 1px solid var(--sd-border);
  }

  .sd-nested-answers {
    margin-top: 12px;
    padding-left: 16px;
    border-left: 2px solid var(--sd-primary-soft);
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .sd-nested-item {
    background: var(--sd-surface);
    padding: 12px 14px;
    border-radius: var(--sd-radius-sm);
    border: 1px solid var(--sd-border);
  }

  /* --- Sidebar Comments & Actions Unified Card --- */
  .sd-comments-card {
    background: var(--sd-surface);
    border-radius: var(--sd-radius-lg);
    border: 1px solid var(--sd-border);
    box-shadow: var(--sd-shadow);
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }

  .sd-comments-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding-top: 14px;
    border-top: 1px solid var(--sd-border);
  }

  .sd-comments-title {
    font-size: 14.5px;
    font-weight: 700;
    color: var(--sd-text-main);
    display: flex;
    align-items: center;
    gap: 7px;
  }

  /* --- Professional Sorting Anchored Popup & Trigger Button (Firma Profili ile Aynı) --- */
  .sd-sort-wrapper {
    position: relative;
    display: inline-block;
  }

  .sd-sort-trigger-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
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
    font-size: 14px;
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
    top: 5px;
    right: 5px;
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
    min-width: 190px;
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
    padding: 9px 12px;
    border-radius: var(--sd-radius-sm);
    color: var(--sd-text-main);
    background: transparent;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
    font-size: 13px;
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

  .sd-comments-scroll-area {
    max-height: 480px;
    overflow-y: auto;
    padding-right: 4px;
  }

  .sd-comments-scroll-area::-webkit-scrollbar {
    width: 5px;
  }

  .sd-comments-scroll-area::-webkit-scrollbar-track {
    background: transparent;
  }

  .sd-comments-scroll-area::-webkit-scrollbar-thumb {
    background: var(--sd-border);
    border-radius: 999px;
  }

  .sd-comments-card .sd-qa-form-card {
    padding: 12px;
    margin-bottom: 0;
    border-radius: var(--sd-radius-sm);
  }

  .sd-comments-card .sd-qa-textarea {
    min-height: 70px;
    padding: 10px 12px;
    font-size: 13.5px;
  }

  .sd-comments-card .sd-qa-item {
    padding: 12px 14px;
  }

  .sd-comments-card .sd-qa-user img {
    width: 32px;
    height: 32px;
  }

  .sd-comments-card .sd-qa-user-name {
    font-size: 13.5px;
  }

  .sd-comments-card .sd-qa-question-text {
    font-size: 13.5px;
    line-height: 1.5;
  }

  .sd-comments-card .sd-qa-list {
    gap: 12px;
  }

  .sd-comments-card .sd-guest-login-banner {
    padding: 10px 14px;
    margin-bottom: 0;
  }

  .sd-comments-card .sd-guest-login-banner-btn {
    padding: 6px 12px;
    font-size: 12px;
  }

  /* --- Modern Giriş Yap Pop-up (Fiyat Geçmişi Tasarımı ile Birebir) --- */
  .sd-auth-popup-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    z-index: 100004;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.22s ease;
  }

  .sd-auth-popup-backdrop.is-open {
    opacity: 1;
    pointer-events: auto;
  }

  .sd-auth-popup {
    display: none;
    position: fixed;
    width: 320px;
    max-width: calc(100vw - 28px);
    background-color: #ffffff !important;
    background: #ffffff !important;
    background: var(--sd-surface, #ffffff) !important;
    border: 1px solid #e2e8f0 !important;
    border: 1px solid var(--sd-border, #e2e8f0) !important;
    border-radius: 16px !important;
    border-radius: var(--sd-radius-lg, 16px) !important;
    box-shadow: 0 16px 40px -4px rgba(15, 23, 42, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.04) !important;
    z-index: 100005;
    overflow: hidden !important;
    opacity: 0;
    transform: translateY(8px) scale(0.96);
    transform-origin: center center;
    transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.22s ease;
    box-sizing: border-box !important;
  }

  .sd-auth-popup.is-open {
    display: block;
    opacity: 1;
    transform: translateY(0) scale(1);
  }

  body.dark .sd-auth-popup {
    background-color: #18181b !important;
    background: #18181b !important;
    background: var(--sd-surface, #18181b) !important;
    border-color: #27272a !important;
    border-color: var(--sd-border, #27272a) !important;
    box-shadow: 0 16px 40px -4px rgba(0, 0, 0, 0.65) !important;
  }

  .sd-auth-popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f8f9fa !important;
    background: var(--sd-bg, #f8f9fa) !important;
    border-bottom: 1px solid #e9ecef !important;
    border-bottom: 1px solid var(--sd-border, #e9ecef) !important;
    box-sizing: border-box;
    width: 100%;
  }

  body.dark .sd-auth-popup-header {
    background: #202024 !important;
    border-bottom-color: #27272a !important;
    border-bottom-color: var(--sd-border, #27272a) !important;
  }

  .sd-auth-popup-title {
    font-size: 14.5px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #0f172a !important;
    color: var(--sd-text-main, #0f172a) !important;
  }

  body.dark .sd-auth-popup-title {
    color: #f4f4f5 !important;
  }

  .sd-auth-popup-close {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: rgba(0, 0, 0, 0.05);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    color: var(--sd-text-muted, #64748b);
    cursor: pointer;
    transition: all 0.15s ease;
  }

  .sd-auth-popup-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #0f172a;
    color: var(--sd-text-main, #0f172a);
  }

  body.dark .sd-auth-popup-close {
    background: rgba(255, 255, 255, 0.08);
    color: #a1a1aa;
  }

  body.dark .sd-auth-popup-close:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
  }

  .sd-auth-popup-body {
    padding: 18px 18px 16px;
    text-align: center;
    box-sizing: border-box;
    background-color: #ffffff !important;
    background: #ffffff !important;
    background: var(--sd-surface, #ffffff) !important;
  }

  body.dark .sd-auth-popup-body {
    background-color: #18181b !important;
    background: #18181b !important;
    background: var(--sd-surface, #18181b) !important;
  }

  /* --- Right Sidebar: Stats Card & Author Card --- */
  .sd-sidebar {
    position: sticky;
    top: 76px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .sd-side-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
    align-items: center;
  }

  .sd-side-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 4px;
    border-radius: var(--sd-radius-md, 10px);
    background: var(--sd-bg);
    border: 1px solid var(--sd-border);
    color: var(--sd-text-main);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
    width: 100%;
    min-width: 0;
    white-space: nowrap;
    user-select: none;
    box-sizing: border-box;
  }

  .sd-side-action-btn i {
    font-size: 14px;
    flex-shrink: 0;
  }

  .sd-side-action-btn span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .sd-side-action-btn.sd-action-like:hover,
  .sd-side-action-btn.sd-action-like.is-liked {
    background: rgba(239, 68, 68, 0.1);
    border-color: #ef4444;
    color: #ef4444;
  }

  .sd-side-action-btn.sd-action-comment:hover {
    background: var(--sd-primary-soft);
    border-color: var(--sd-primary);
    color: var(--sd-primary);
  }

  .sd-side-action-btn.sd-action-share:hover {
    background: var(--sd-primary-soft);
    border-color: var(--sd-primary);
    color: var(--sd-primary);
  }

  .sd-side-action-btn.sd-action-view {
    cursor: default;
    color: var(--sd-text-muted);
  }

  body.dark .sd-side-action-btn {
    background: #27272a;
    border-color: #3f3f46;
    color: #f4f4f5;
  }

  body.dark .sd-side-action-btn.sd-action-view {
    color: #a1a1aa;
  }

  .sd-cta-stack {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 16px;
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

  .sd-btn-sm {
    padding: 8px 14px;
    font-size: 13px;
    border-radius: var(--sd-radius-sm);
  }

  /* Author / Company Card */
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

  /* --- Similar / Latest Ideas Section --- */
  .sd-similar-section {
    margin-top: 32px;
  }

  /* --- Mobile Sticky Bottom Bar --- */
  .sd-mobile-sticky-bar {
    display: none;
  }

  /* ==========================================================================
     RESPONSIVE: MOBILE HALF-SCREEN GALLERY & NATURAL SCROLL LAYOUT (< 992px)
     ========================================================================== */
  @media screen and (max-width: 991px) {
    /* 1. Reset Global Container & Header */
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
      padding-bottom: 74px !important;
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

    /* Galeri Kartı (order: 1) */
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

    /* Ana Görsel Alanı: Ekranın 5'te 3'ünü (%60 Viewport / 60dvh) Kesintisiz ve Tam Dolduran Yükseklik */
    .sd-main-swiper {
      width: 100% !important;
      height: 60vh !important;
      height: 60dvh !important;
      min-height: 60vh !important;
      min-height: 60dvh !important;
      max-height: 60vh !important;
      max-height: 60dvh !important;
      aspect-ratio: unset !important;
      border-radius: 0 !important;
      background: #0f172a;
      position: relative;
      overflow: hidden;
    }

    .sd-main-swiper .swiper-wrapper {
      height: 100% !important;
      width: 100% !important;
      display: flex !important;
    }

    .sd-main-swiper .swiper-slide {
      width: 100% !important;
      height: 100% !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      overflow: hidden !important;
    }

    .sd-main-swiper .swiper-slide a.sd-slide-link,
    .sd-main-swiper .sd-slide-link {
      width: 100% !important;
      height: 100% !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      position: relative !important;
      overflow: hidden !important;
    }

    .sd-main-swiper .swiper-slide img,
    .sd-main-swiper .sd-slide-link img {
      width: 100% !important;
      height: 100% !important;
      min-height: 100% !important;
      max-height: 100% !important;
      aspect-ratio: unset !important;
      object-fit: cover !important;
      object-position: center center !important;
      display: block !important;
      margin: auto !important;
    }

    .sd-main-swiper .swiper-slide video,
    .sd-main-swiper .sd-slide-link video {
      width: 100% !important;
      height: 100% !important;
      min-height: 100% !important;
      max-height: 100% !important;
      aspect-ratio: unset !important;
      object-fit: cover !important;
      object-position: center center !important;
      display: block !important;
      margin: auto !important;
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

    /* Floating Top Bar inside Mobile Gallery */
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

    .sd-mob-circle-btn.is-liked {
      background: #ef4444 !important;
      border-color: #ef4444 !important;
      color: #fff !important;
    }

    .sd-gallery-counter {
      display: none !important;
    }

    /* Ana Görsel Altındaki Yatay Küçük Resimler: İnce ve Modern Border */
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

    /* 2) Özellik Rozetleri Kartı: Açıklama kartı ile arasında hiç boşluk ve border olmasın (order: 2) */
    .sd-header-card {
      order: 2;
      margin: 0 !important;
      padding: 10px 14px !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      box-shadow: none !important;
      background: var(--sd-surface) !important;
    }

    .sd-header-card .sd-badges-row {
      display: flex !important;
      flex-wrap: nowrap !important;
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch !important;
      scrollbar-width: none !important;
      gap: 8px !important;
      margin-bottom: 0 !important;
      padding-bottom: 2px !important;
    }

    .sd-header-card .sd-badges-row::-webkit-scrollbar {
      display: none !important;
    }

    .sd-header-card .sd-badge {
      flex: 0 0 auto !important;
      white-space: nowrap !important;
      padding: 6px 12px !important;
      font-size: 12px !important;
    }

    /* 2 & 4) Açıklama Kartı: Başlık ve yorumlar kartı ile arasında hiç boşluk, border ve gölge yok (order: 3) */
    .sd-desc-card,
    .sd-tabs-card {
      order: 3 !important;
      margin: 0 !important;
      padding: 6px 16px !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      border-top: none !important;
      border-bottom: none !important;
      box-shadow: none !important;
      background: var(--sd-surface) !important;
    }

    /* 3) Yorumlar Kartı: Açıklama kartının altında, aralarında hiç boşluk, border ve gölge yok (order: 4) */
    .sd-comments-card {
      order: 4 !important;
      margin: 0 0 10px 0 !important;
      padding: 16px !important;
      border-radius: 0 !important;
      border: none !important;
      border-top: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
      width: 100% !important;
      background: var(--sd-surface) !important;
    }

    .sd-comments-scroll-area {
      max-height: none !important;
      overflow-y: visible !important;
      padding-right: 0 !important;
    }

    .sd-sort-trigger-btn {
      width: 32px !important;
      height: 32px !important;
      border-radius: 8px !important;
    }

    .sd-sort-icon {
      font-size: 13px !important;
    }

    .sd-sort-active-dot {
      top: 4px !important;
      right: 4px !important;
      width: 5px !important;
      height: 5px !important;
    }

    .sd-sort-popup {
      right: 0;
      width: min(200px, calc(100vw - 32px));
    }

    /* 4) Yazar / Paylaşan Kartı: Yorumlar kartının altında (order: 5), genişlik tam ekran, border yok, sağ/sol boşluk sıfır */
    .sd-company-card {
      order: 5 !important;
      margin: 0 0 10px 0 !important;
      padding: 16px 14px !important;
      width: 100% !important;
      border-radius: 0 !important;
      border: none !important;
      border-bottom: 1px solid var(--sd-border) !important;
      box-shadow: none !important;
    }

    .sd-comments-card .sd-side-actions-grid {
      display: none !important;
    }

    .sd-comments-card-header {
      padding-top: 0 !important;
      border-top: none !important;
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

    /* Açıklama Kartında 3 Satır Kırpma ve "Daha fazla / Daha az" Butonu */
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

    /* Similar Ideas on Mobile */
    .sd-similar-section {
      padding: 0 12px;
      margin-top: 16px;
      display: block !important;
    }

    .fikir-detay-one-cikan-hizmet {
      display: block !important;
    }

    /* Footer spacing on Mobile */
    .sd-page-wrapper footer,
    .sd-page-wrapper footer.services-detail-footer {
      margin: 20px 12px 0 !important;
      width: auto !important;
      border-radius: 14px;
    }

    /* 4) Mobil Sabit Alt Menü: İstatistikler (Butonlar kaldırıldı) */
    .sd-mobile-sticky-bar {
      display: flex;
      align-items: center;
      justify-content: center;
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

    .sd-mob-stats-col {
      display: flex;
      align-items: center;
      justify-content: space-around;
      width: 100%;
      max-width: 440px;
      margin: 0 auto;
      gap: 10px;
    }

    .sd-mob-stat-item {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 7px;
      padding: 8px 16px;
      border-radius: 999px;
      background: var(--sd-bg, #f4f7fb);
      border: 1px solid var(--sd-border, #e2e8f0);
      font-size: 13.5px;
      font-weight: 600;
      color: var(--sd-text-main, #0f172a);
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
      flex: 1;
      text-align: center;
    }

    .sd-mob-stat-item i {
      font-size: 15px;
    }

    .sd-mob-stat-item.is-liked {
      background: rgba(239, 68, 68, 0.1) !important;
      border-color: rgba(239, 68, 68, 0.28) !important;
      color: #ef4444 !important;
    }

    body.dark .sd-mob-stat-item {
      background: #27272a;
      border-color: #3f3f46;
      color: #f4f4f5;
    }

    .sd-mob-cta-group {
      display: none !important;
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

    /* Mobile Giriş Pop-up (Fiyat Geçmişi ile Birebir) */
    .sd-auth-popup {
      position: fixed !important;
      left: 14px !important;
      right: 14px !important;
      width: calc(100% - 28px) !important;
      max-width: 360px !important;
      margin: 0 auto !important;
      bottom: 80px !important;
      top: auto !important;
      border-radius: 18px !important;
      box-shadow: 0 12px 42px rgba(0, 0, 0, 0.32) !important;
      background-color: #ffffff !important;
      background: #ffffff !important;
      background: var(--sd-surface, #ffffff) !important;
      border: 1px solid var(--sd-border, #e2e8f0) !important;
      transform: translateY(16px) scale(0.96);
    }

    body.dark .sd-auth-popup {
      background-color: #18181b !important;
      background: #18181b !important;
      background: var(--sd-surface, #18181b) !important;
      border-color: #27272a !important;
    }

    .sd-auth-popup.is-open {
      transform: translateY(0) scale(1) !important;
    }

    /* Hide global bottom bar so sticky idea bar sits cleanly */
    body .mobile-fixed-menu {
      display: none !important;
    }
  }
</style>
@endsection

@section('content')
@php
  $mediaList = json_decode($idea->path, true) ?? [];
  $mediaCount = count($mediaList);
  $totalSlideCount = $mediaCount + 1;
  $isLiked = auth()->check() ? $idea->ideaLikeExists($idea->id) : false;
  $authorInfo = auth_info($idea->user_id);
  $authorModel = \App\Models\User::with('company')->find($idea->user_id);
  $isCompanyAuthor = ($authorModel && $authorModel->user_type === 'company' && $authorModel->company);
  $authorAvatar = $authorInfo->avatar ?? ($authorModel->avatar ?? 'default-avatar.png');
  $authorName = $authorInfo->name ?? ($authorModel->name ?? 'Kullanıcı');
  $ideaTitle = !empty($idea->title) ? $idea->title : \Illuminate\Support\Str::limit($idea->content, 65, '...');
@endphp

<div class="main sidebar">
  <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
    <div class="index-right fikir-detay sd-page-wrapper">
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
              <a href="{{ route('idea.index') }}">Fikirler</a>
            </li>
            @if($idea->category)
              <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
              <li>
                <a href="{{ route('idea.index', ['category' => $idea->category_id]) }}">
                  {{ $idea->category->name }}
                </a>
              </li>
            @endif
            @if($idea->subCategory)
              <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
              <li>
                <a href="{{ route('idea.index', ['category' => $idea->category_id, 'sub_category' => $idea->sub_category_id]) }}">
                  {{ $idea->subCategory->name }}
                </a>
              </li>
            @endif
            <li class="sd-bc-sep"><i class="fa-solid fa-chevron-right"></i></li>
            <li class="sd-bc-current" title="{{ $ideaTitle }}">{{ $ideaTitle }}</li>
          </ol>
        </div>

        {{-- Ana 2 Kolonlu Grid (Mobilde CSS order ile Galeri -> Başlık -> Sekmeler -> Yazar sırasına dönüşür) --}}
        <div class="sd-main-grid">

          {{-- SOL KOLON: Galeri + Başlık/Özet + Sekmeler --}}
          <div class="sd-left-col">

            {{-- 1. Görsel & Video Galeri Kartı (Mobilde Yarım Ekran, Masaüstünde Geniş Galeri) --}}
            <div class="sd-gallery-card {{ $totalSlideCount <= 1 ? 'sd-single-photo' : '' }}">
              <div class="sd-gallery-layout">
                <div class="swiper sd-main-swiper">
                  {{-- Mobil Üst Yüzen Aksiyon Butonları --}}
                  <div class="sd-gallery-mobile-nav">
                    <div class="sd-gallery-mobile-nav-group">
                      <a href="{{ route('idea.index') }}"
                         onclick="if(window.history.length > 1){ history.back(); return false; }"
                         class="sd-mob-circle-btn"
                         title="Geri Dön"
                         aria-label="Geri Dön">
                        <i class="fa-solid fa-arrow-left"></i>
                      </a>
                      <a href="{{ $idea->category_id ? route('idea.index', array_filter(['category' => $idea->category_id, 'sub_category' => $idea->sub_category_id])) : route('idea.index') }}"
                         class="sd-mob-circle-btn"
                         title="{{ $idea->category->name ?? 'Kategori Fikirleri' }}"
                         aria-label="{{ $idea->category->name ?? 'Kategori Fikirleri' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                          <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                      </a>
                    </div>
                    <div class="sd-gallery-mobile-nav-group">
                      <button type="button"
                              class="sd-mob-circle-btn"
                              onclick="shareIdeaLink(this)"
                              title="Paylaş"
                              aria-label="Paylaş">
                        <i class="fa-solid fa-share-nodes"></i>
                      </button>
                      <button type="button"
                              class="sd-mob-circle-btn {{ $isLiked ? 'is-liked' : '' }}"
                              onclick="handleIdeaLike('{{ $idea->slug }}', this)"
                              title="Beğen"
                              aria-label="Beğen">
                        <i class="fa-solid fa-heart"></i>
                      </button>
                    </div>
                  </div>

                  <div class="swiper-wrapper">
                    @forelse($mediaList as $path)
                      <div class="swiper-slide">
                        @if(get_file_extension($path) != 'mp4')
                          <a href="{{ asset($path) }}"
                             data-fancybox="gallery"
                             data-caption="{{ $ideaTitle }}"
                             class="sd-slide-link">
                            <img src="{{ asset($path) }}" alt="{{ $ideaTitle }}" />
                          </a>
                        @else
                          <video controls style="width: 100%; height: 100%; object-fit: contain;">
                            <source src="{{ asset($path) }}" type="video/mp4" />
                          </video>
                        @endif
                      </div>
                    @empty
                      <div class="swiper-slide">
                        <img src="{{ asset('site/images/default-idea.jpg') }}" alt="{{ $ideaTitle }}" style="object-fit: cover;" />
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
                    <button type="button" class="sd-gallery-nav-btn sd-gallery-prev" aria-label="Önceki">
                      <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="sd-gallery-nav-btn sd-gallery-next" aria-label="Sonraki">
                      <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <div class="sd-gallery-counter">
                      <i class="fa-regular fa-image"></i>
                      <span id="sdSlideCurrent">1</span> / {{ $totalSlideCount }}
                    </div>
                  @endif
                </div>

                {{-- Dikey (Masaüstü) / Yatay (Mobil) Küçük Önizleme Şeridi --}}
                @if($totalSlideCount > 1)
                  <div class="swiper sd-thumb-swiper">
                    <div class="swiper-wrapper">
                      @foreach($mediaList as $path)
                        <div class="swiper-slide">
                          @if(get_file_extension($path) != 'mp4')
                            <img src="{{ asset($path) }}" alt="Önizleme" />
                          @else
                            <div class="sd-video-thumb-overlay">
                              <i class="fa-solid fa-play"></i>
                            </div>
                            <video muted preload="metadata" style="width: 100%; height: 100%; object-fit: cover;">
                              <source src="{{ asset($path) }}#t=0.5" type="video/mp4" />
                            </video>
                          @endif
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

            {{-- 2. Özellik Rozetleri Kartı --}}
            <div class="sd-header-card">
              <div class="sd-badges-row">
                @if($idea->category)
                  <a href="{{ route('idea.index', ['category' => $idea->category_id]) }}" class="sd-badge" title="Kategori">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>{{ $idea->category->name }}</span>
                  </a>
                @endif
                @if($idea->subCategory)
                  <a href="{{ route('idea.index', ['category' => $idea->category_id, 'sub_category' => $idea->sub_category_id]) }}" class="sd-badge" title="Alt Kategori">
                    <i class="fa-solid fa-tag"></i>
                    <span>{{ $idea->subCategory->name }}</span>
                  </a>
                @endif
                <span class="sd-badge" title="Yayın Tarihi">
                  <i class="fa-regular fa-calendar-days"></i>
                  <span>{{ change_timezone($idea->created_at, 'd.m.Y') }}</span>
                </span>
                <span class="sd-badge" title="Beğeni Sayısı">
                  <i class="fa-solid fa-heart"></i>
                  <span id="spec-like-count">{{ $idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id) }} Beğeni</span>
                </span>
                <a href="#sidebarCommentsCard" onclick="focusCommentInput(); return false;" class="sd-badge" title="Yorumlar">
                  <i class="fa-regular fa-comment"></i>
                  <span><span id="tab-comment-badge">{{ $idea->replies->count() }}</span> Yorum</span>
                </a>
                <span class="sd-badge" title="Görüntülenme Sayısı">
                  <i class="fa-regular fa-eye"></i>
                  <span>{{ $idea->ideaViewCount($idea->id) }} Görüntülenme</span>
                </span>
              </div>
            </div>

            {{-- 3. Açıklama & İçerik Alanı --}}
            <div class="sd-desc-card" id="sdDescCard">
              <div class="sd-desc-wrapper">
                <p class="sd-description-text sd-clamped" id="sdDescText">{{ $idea->content }}</p>
                <button type="button" class="sd-desc-toggle-btn" id="sdDescToggleBtn" onclick="toggleIdeaDescription()" aria-expanded="false" style="display: none;">
                  <span class="sd-desc-toggle-text">Daha fazla</span>
                  <i class="fa-solid fa-chevron-down ms-1"></i>
                </button>
              </div>

              {{-- En Çok Beğeni Alan Yorum Vurgu Kartı --}}
              @if($mostLikedReply)
                <div class="sd-highlight-comment-card" style="cursor: pointer;" onclick="document.getElementById('reply-{{ $mostLikedReply->id }}')?.scrollIntoView({behavior: 'smooth', block: 'center'});">
                  <div class="sd-highlight-header">
                    <span class="sd-highlight-title">
                      <i class="fa-solid fa-star text-warning"></i> En Çok Beğenilen Yorum
                    </span>
                    <div class="sd-comment-action-btn is-liked">
                      <i class="fa-regular fa-thumbs-up"></i>
                      <span>{{ $mostLikedReply->likes->count() }} Beğeni</span>
                    </div>
                  </div>

                  @php
                    $mostLikedUser = auth_info($mostLikedReply->user_id);
                    $mostLikedUserModel = \App\Models\User::find($mostLikedReply->user_id);
                  @endphp
                  <div class="sd-qa-user mb-2">
                    <img src="{{ asset($mostLikedUser->avatar ?? 'default-avatar.png') }}" alt="{{ $mostLikedUser->name ?? 'Kullanıcı' }}">
                    <div class="sd-qa-user-meta">
                      <span class="sd-qa-user-name">{{ $mostLikedUser->name ?? 'Kullanıcı' }}</span>
                      <span class="sd-qa-time">{{ change_timezone($mostLikedReply->created_at, 'd.m.Y H:i') }}</span>
                    </div>
                  </div>

                  <p class="sd-qa-question-text">{{ $mostLikedReply->content }}</p>
                </div>
              @endif
            </div>

          </div>

          {{-- SAĞ KOLON: İstatistik / Etkileşim & Yorumlar & Yazar / Firma Kartı --}}
          <aside class="sd-sidebar">

            {{-- 1. Masaüstü Hızlı Etkileşim & Yorumlar Kartı (Birleşik Tek Kart) --}}
            <div class="sd-comments-card" id="sidebarCommentsCard">
              {{-- Hızlı Aksiyon Butonları --}}
              <div class="sd-side-actions-grid">
                {{-- 1. Beğen --}}
                <button type="button"
                        class="sd-side-action-btn sd-action-like {{ $isLiked ? 'is-liked' : '' }}"
                        id="desktop-like-btn"
                        onclick="handleIdeaLike('{{ $idea->slug }}', this)"
                        title="Beğen">
                  <i class="fa-solid fa-heart"></i>
                  <span id="desktop-like-count">{{ $idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id) }}</span>
                </button>

                {{-- 2. Yorum --}}
                <button type="button"
                        class="sd-side-action-btn sd-action-comment"
                        onclick="focusCommentInput();"
                        title="Yorumlar">
                  <i class="fa-regular fa-comment"></i>
                  <span id="desktop-comment-count-stats">{{ $idea->replies->count() }}</span>
                </button>

                {{-- 3. Paylaş --}}
                <button type="button"
                        class="sd-side-action-btn sd-action-share"
                        onclick="shareIdeaLink(this)"
                        title="Paylaş">
                  <i class="fa-solid fa-share-nodes"></i>
                  <span>Paylaş</span>
                </button>

                {{-- 4. Görüntülenme --}}
                <div class="sd-side-action-btn sd-action-view"
                     title="Görüntülenme">
                  <i class="fa-regular fa-eye"></i>
                  <span>{{ $idea->ideaViewCount($idea->id) }}</span>
                </div>
              </div>

              {{-- Yorumlar Başlığı & Sıralama Pop-up Menüsü (Firma Profili ile Aynı) --}}
              <div class="sd-comments-card-header">
                <span class="sd-comments-title">
                  <i class="fa-regular fa-comments text-primary"></i>
                  <span>Yorumlar (<span id="comments-section-count">{{ $idea->replies->count() }}</span>)</span>
                </span>

                @php
                  $currentSort = request()->sort_by ?? 'new';
                  $isCustomSort = ($currentSort === 'like');
                  $sortLabels = [
                    'new' => 'En Yeni',
                    'like' => 'En Çok Beğenilen',
                  ];
                  $currentLabel = $sortLabels[$currentSort] ?? 'En Yeni';
                @endphp

                <div class="sd-sort-wrapper" id="sortCommentsWrapper">
                  <button type="button" 
                          class="sd-sort-trigger-btn {{ $isCustomSort ? 'is-active' : '' }}" 
                          id="sortCommentsTriggerBtn" 
                          aria-expanded="false" 
                          aria-haspopup="true" 
                          title="Sıralama: {{ $currentLabel }}" 
                          aria-label="Sıralama: {{ $currentLabel }}">
                    <i class="fa-solid fa-arrow-down-wide-short sd-sort-icon"></i>
                    @if($isCustomSort)
                      <span class="sd-sort-active-dot"></span>
                    @endif
                  </button>

                  <!-- Direk Butonun Altında Açılan Sıralama Pop-up Menüsü -->
                  <div class="sd-sort-popup" id="sortCommentsPopup" role="menu">
                    <form action="{{ url()->current() }}" method="GET" id="sortCommentsForm" class="m-0">
                      {{-- Mevcut filtre ve parametreleri koru (sort_by hariç) --}}
                      @foreach(request()->except(['sort_by']) as $k => $v)
                        @if(is_array($v))
                          @foreach($v as $sv)
                            <input type="hidden" name="{{ $k }}[]" value="{{ $sv }}">
                          @endforeach
                        @else
                          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                      @endforeach

                      <input type="hidden" name="sort_by" id="sortCommentsInput" value="{{ $currentSort }}">

                      <div class="sd-sort-options-list">
                        @php
                          $sortOptions = [
                            ['value' => 'new',  'label' => 'En Yeni',           'icon' => 'fa-regular fa-clock'],
                            ['value' => 'like', 'label' => 'En Çok Beğenilen', 'icon' => 'fa-regular fa-heart'],
                          ];
                        @endphp

                        @foreach($sortOptions as $opt)
                          @php
                            $isSelected = ($currentSort === $opt['value']);
                          @endphp
                          <div class="sd-sort-option-item {{ $isSelected ? 'is-selected' : '' }}" 
                               data-value="{{ $opt['value'] }}"
                               role="menuitem"
                               tabindex="0">
                            <i class="{{ $opt['icon'] }} me-2" style="font-size: 13px; opacity: 0.85;"></i>
                            <span class="sd-sort-option-name">{{ $opt['label'] }}</span>
                            @if($isSelected)
                              <i class="fa-solid fa-check ms-auto text-primary" style="font-size: 11px;"></i>
                            @endif
                          </div>
                        @endforeach
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              {{-- Yorum Yazma Formu --}}
              @auth()
                <form action="{{ route('idea.reply.store') }}" method="POST" class="sd-qa-form-card" id="commentFormCard">
                  @csrf
                  <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                  <textarea name="content"
                            id="mainCommentTextarea"
                            rows="2"
                            placeholder="Bu fikir hakkında bir yorum yazın..."
                            class="sd-qa-textarea"
                            required>{{ old('content') }}</textarea>
                  <div class="sd-qa-submit-row">
                    <button class="sd-btn-primary sd-btn-sm" type="submit">
                      <i class="fa-regular fa-paper-plane"></i> Gönder
                    </button>
                  </div>
                </form>
              @else
                <div class="sd-guest-login-banner" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                  <span class="sd-guest-login-banner-text">
                    <i class="fa-solid fa-lock me-1 text-primary"></i> Yorum yapmak için giriş yapın.
                  </span>
                  <span class="sd-btn-primary sd-guest-login-banner-btn">Giriş</span>
                </div>
              @endauth

              {{-- Kaydırılabilir Yorum Listesi --}}
              <div class="sd-comments-scroll-area">
                <div class="sd-qa-list">
                  @forelse($replies as $reply)
                    @php
                      $replyUser = auth_info($reply->user_id);
                      $replyUserModel = \App\Models\User::find($reply->user_id);
                      $isReplyCompany = ($replyUserModel && $replyUserModel->user_type === 'company' && $replyUserModel->company);
                    @endphp
                    <div class="sd-qa-item" id="reply-{{ $reply->id }}">
                      <div class="sd-qa-header">
                        <div class="sd-qa-user">
                          <img src="{{ asset($replyUser->avatar ?? 'default-avatar.png') }}"
                               alt="{{ $replyUser->name ?? 'Kullanıcı' }}">
                          <div class="sd-qa-user-meta">
                            @if($isReplyCompany)
                              <a href="{{ route('companies.show', $replyUserModel->company->slug) }}" class="sd-qa-user-name">
                                {{ $replyUser->name ?? 'Firma' }}
                                <i class="fa-solid fa-circle-check text-primary ms-1" style="font-size: 11px;"></i>
                              </a>
                            @else
                              <span class="sd-qa-user-name">{{ $replyUser->name ?? 'Kullanıcı' }}</span>
                            @endif
                            <span class="sd-qa-time">
                              {{ change_timezone($reply->created_at, 'd.m.Y') }} • {{ change_timezone($reply->created_at, 'H:i') }}
                            </span>
                          </div>
                        </div>

                        @auth()
                          @if($reply->user_id == auth()->id() || $reply->idea->user_id == auth()->id())
                            <a href="{{ route('idea.reply.destroy', $reply->id) }}"
                               class="sd-qa-delete-btn"
                               onclick="return confirm('Yorumu silmek istediğinize emin misiniz?')"
                               title="Yorumu Sil">
                              <i class="fa-solid fa-trash-can"></i>
                            </a>
                          @endif
                        @endauth
                      </div>

                      <p class="sd-qa-question-text">{{ $reply->content }}</p>

                      <div class="sd-comment-actions-bar">
                        <button type="button"
                                class="sd-comment-action-btn {{ $reply->like($reply->id) ? 'is-liked' : '' }}"
                                onclick="likeToggle({{ $reply->id }}, this)">
                          <i class="fa-regular fa-thumbs-up"></i>
                          <span class="reply-like-count">{{ $reply->likes->count() }}</span>
                        </button>

                        <button type="button"
                                class="sd-comment-action-btn"
                                onclick="toggleReplyForm({{ $reply->id }})">
                          <i class="fa-regular fa-comment"></i>
                          <span>Yanıtla</span>
                        </button>

                        @if($reply->answers->count() > 0)
                          <button type="button"
                                  class="sd-comment-action-btn ms-auto text-primary"
                                  onclick="toggleNestedAnswers({{ $reply->id }}, this)">
                            <i class="fa-solid fa-chevron-down"></i>
                            <span>Yanıtlar ({{ $reply->answers->count() }})</span>
                          </button>
                        @endif
                      </div>

                      {{-- Yanıt Gönderme Formu --}}
                      <div class="sd-reply-form-box" id="replyFormBox-{{ $reply->id }}" style="display: none;">
                        @auth()
                          <form action="{{ route('idea.reply.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idea_id" value="{{ $idea->id }}">
                            <input type="hidden" name="parent_reply_id" value="{{ $reply->id }}">
                            <input type="hidden" name="quoted_reply_id" value="{{ $reply->id }}">
                            <div class="d-flex gap-2">
                              <input type="text" name="content" class="form-control" style="font-size: 13px; border-radius: 8px;" placeholder="Yanıtınızı yazın..." required>
                              <button type="submit" class="sd-btn-primary sd-btn-sm" style="flex-shrink: 0; padding: 6px 12px; font-size: 12px;">Gönder</button>
                            </div>
                          </form>
                        @else
                          <div class="text-center py-2 text-muted small">
                            Yanıt vermek için lütfen <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" class="text-primary fw-bold">giriş yapın</a>.
                          </div>
                        @endauth
                      </div>

                      {{-- İç İçe Alt Yanıtlar --}}
                      @if($reply->answers->count() > 0)
                        <div class="sd-nested-answers" id="nestedAnswers-{{ $reply->id }}" style="display: none;">
                          @foreach($reply->answers as $answer)
                            @php
                              $answerUser = auth_info($answer->user_id);
                              $answerUserModel = \App\Models\User::find($answer->user_id);
                              $isAnswerCompany = ($answerUserModel && $answerUserModel->user_type === 'company' && $answerUserModel->company);
                            @endphp
                            <div class="sd-nested-item">
                              <div class="sd-qa-header mb-1">
                                <div class="sd-qa-user">
                                  <img src="{{ asset($answerUser->avatar ?? 'default-avatar.png') }}"
                                       alt="{{ $answerUser->name ?? 'Kullanıcı' }}"
                                       style="width: 28px; height: 28px;">
                                  <div class="sd-qa-user-meta">
                                    @if($isAnswerCompany)
                                      <a href="{{ route('companies.show', $answerUserModel->company->slug) }}" class="sd-qa-user-name" style="font-size: 12.5px;">
                                        {{ $answerUser->name ?? 'Firma' }}
                                      </a>
                                    @else
                                      <span class="sd-qa-user-name" style="font-size: 12.5px;">{{ $answerUser->name ?? 'Kullanıcı' }}</span>
                                    @endif
                                    <span class="sd-qa-time" style="font-size: 11px;">
                                      {{ change_timezone($answer->created_at, 'd.m.Y H:i') }}
                                    </span>
                                  </div>
                                </div>

                                @auth()
                                  @if($answer->user_id == auth()->id() || $answer->idea->user_id == auth()->id())
                                    <a href="{{ route('idea.reply.destroy', $answer->id) }}"
                                       class="sd-qa-delete-btn"
                                       style="width: 24px; height: 24px; font-size: 10px;"
                                       onclick="return confirm('Yanıtı silmek istediğinize emin misiniz?')"
                                       title="Yanıtı Sil">
                                      <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                  @endif
                                @endauth
                              </div>

                              <p class="sd-qa-question-text" style="font-size: 13px;">{{ $answer->content }}</p>

                              <div class="d-flex align-items-center gap-2 mt-2">
                                <button type="button"
                                        class="sd-comment-action-btn {{ $answer->like($answer->id) ? 'is-liked' : '' }}"
                                        style="font-size: 11.5px; padding: 2px 6px;"
                                        onclick="likeToggle({{ $answer->id }}, this)">
                                  <i class="fa-regular fa-thumbs-up"></i>
                                  <span class="reply-like-count">{{ $answer->likes->count() }}</span>
                                </button>
                              </div>
                            </div>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  @empty
                    <div class="text-center py-4 text-muted">
                      <i class="fa-regular fa-comments fs-3 mb-2 d-block opacity-50"></i>
                      <span style="font-size: 13px;">Bu fikir hakkında henüz yorum yapılmamış.<br>İlk yorumu siz yazın!</span>
                    </div>
                  @endforelse
                </div>
              </div>
            </div>

            {{-- Yazar / Firma Profili Kartı (Mobilde Başlık ve Sekmelerin Altında Gösterilir) --}}
            <div class="sd-company-card">
              <div class="sd-company-header">
                @if($isCompanyAuthor)
                  <a href="{{ route('companies.show', $authorModel->company->slug) }}" class="sd-company-avatar-link">
                    <img src="{{ asset($authorAvatar) }}" alt="{{ $authorName }}" class="sd-company-avatar">
                  </a>
                @else
                  <div class="sd-company-avatar-link">
                    <img src="{{ asset($authorAvatar) }}" alt="{{ $authorName }}" class="sd-company-avatar">
                  </div>
                @endif

                <div class="sd-company-info">
                  <span class="sd-company-label">
                    {{ $isCompanyAuthor ? 'Paylaşan Firma' : 'Fikir Sahibi' }}
                  </span>
                  <div class="sd-company-name-row">
                    @if($isCompanyAuthor)
                      <a href="{{ route('companies.show', $authorModel->company->slug) }}" class="sd-company-name" title="{{ $authorName }}">
                        {{ $authorName }}
                      </a>
                      @if($authorModel->company->is_verified == 1)
                        <img src="{{ asset('site/images/success.png') }}" alt="Onaylı Firma" class="sd-verified-icon" title="Onaylı Firma">
                      @endif
                    @else
                      <span class="sd-company-name">{{ $authorName }}</span>
                    @endif
                  </div>
                </div>
              </div>

              <div class="sd-company-actions">
                @if($isCompanyAuthor)
                  <a href="{{ route('companies.show', $authorModel->company->slug) }}" class="sd-company-link-btn">
                    <i class="fa-solid fa-store"></i>
                    <span>Firma Sayfası</span>
                  </a>

                  @auth()
                    @if(auth()->id() != $authorModel->id)
                      <form action="{{ route('company.follow') }}" method="POST" class="flex-grow-1 d-flex m-0">
                        @csrf
                        <input type="hidden" name="user" value="{{ \Illuminate\Support\Facades\Crypt::encryptString($authorModel->id) }}">
                        <button type="submit" class="sd-company-link-btn w-100">
                          @if(!auth()->user()->following($authorModel->id))
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
                @else
                  <a href="{{ route('idea.index') }}" class="sd-company-link-btn">
                    <i class="fa-solid fa-lightbulb"></i>
                    <span>Tüm Fikirler</span>
                  </a>

                  @auth()
                    @if(auth()->id() != $authorModel->id)
                      <a href="{{ route('chat.show', $authorModel->id) }}" class="sd-company-link-btn">
                        <i class="fa-regular fa-comment-dots"></i>
                        <span>Mesaj Gönder</span>
                      </a>
                    @endif
                  @else
                    <button type="button"
                            class="sd-company-link-btn"
                            onclick="showLoginPopup('Mesaj göndermek için giriş yapmalısınız!', this)">
                      <i class="fa-regular fa-comment-dots"></i>
                      <span>Mesaj</span>
                    </button>
                  @endauth
                @endif
              </div>
            </div>

          </aside>

        </div>

        {{-- Güncel Fikirler Üstü Duyarlı Reklam Alanı --}}
        <div class="sd-similar-ad-wrapper my-4 text-center">
          <div class="sd-ad-badge-line mb-2">
            <span class="sd-ad-badge-text"><i class="fa-solid fa-rectangle-ad me-1"></i> Sponsorlu Reklam</span>
          </div>
          <x-ad-slot format="auto" class="sd-similar-ad-slot" />
        </div>

        {{-- Güncel / Benzer Fikirler (Masaüstü & Mobil Görünür) --}}
        @if(isset($lastIdeas) && $lastIdeas->count() > 0)
          <div class="sd-similar-section">
            <div class="popular-services">
              <div class="cs-title d-flex cs-title-link">
                <div class="ctl-left">
                  <i class="fa-solid fa-lightbulb text-warning"></i>
                  <h2>Güncel Fikirler</h2>
                </div>
                <div class="ctl-right">
                  <a href="{{ route('idea.index') }}" class="cs-all-link">
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
        @endif

      </div>

      @include('site.home.footer')
    </div>
  </div>
</div>

{{-- Mobil Sabit Alt Etkileşim Çubuğu (Sticky Bottom Bar - Butonlar kaldırıldı) --}}
<div class="sd-mobile-sticky-bar">
  <div class="sd-mob-stats-col">
    <div class="sd-mob-stat-item {{ $isLiked ? 'is-liked' : '' }}"
         id="mobile-like-btn"
         onclick="handleIdeaLike('{{ $idea->slug }}', this)"
         title="Beğen">
      <i class="fa-solid fa-heart"></i>
      <span id="mobile-like-count">{{ $idea->ideaReplyLikeCount($idea->id) + $idea->ideaLikeCount($idea->id) }}</span>
    </div>

    <div class="sd-mob-stat-item"
         onclick="focusCommentInput(); document.getElementById('sidebarCommentsCard')?.scrollIntoView({behavior: 'smooth'});"
         title="Yorumlar">
      <i class="fa-regular fa-comment"></i>
      <span id="mobile-comment-count">{{ $idea->replies->count() }}</span>
    </div>

    <div class="sd-mob-stat-item" title="Görüntülenme">
      <i class="fa-regular fa-eye"></i>
      <span>{{ $idea->ideaViewCount($idea->id) }}</span>
    </div>
  </div>
</div>

{{-- Modern Giriş Yap Pop-up Uyarısı (Fiyat Geçmişi Tasarımı ile Birebir) --}}
<div class="sd-auth-popup-backdrop" id="sdAuthPopupBackdrop" onclick="closeLoginPopup()"></div>
<div class="sd-auth-popup" id="sdAuthPopup" role="dialog" aria-modal="true" aria-labelledby="sdAuthPopupTitle">
  <div class="sd-auth-popup-header">
    <h5 class="sd-auth-popup-title" id="sdAuthPopupTitle">
      <i class="fa-solid fa-lock text-primary" id="sdAuthPopupHeaderIcon"></i>
      <span id="sdAuthPopupTitleText">Giriş Yapmalısınız</span>
    </h5>
    <button type="button" class="sd-auth-popup-close" onclick="closeLoginPopup()" aria-label="Kapat">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>
  <div class="sd-auth-popup-body">
    <div class="fg-guest-icon">
      <i class="fa-solid fa-lock" id="sdAuthPopupBodyIcon"></i>
    </div>
    <p class="fg-guest-text" id="sdAuthPopupMessage">
      Bu fikri beğenmek için lütfen giriş yapın.
    </p>
    <button type="button" class="fg-guest-btn" onclick="openLoginModalFromAuthPopup()">
      <i class="fa-solid fa-arrow-right-to-bracket"></i>
      <span>Giriş Yap</span>
    </button>
  </div>
</div>
@endsection

@section('js')
<script>
  let sdThumbSwiper = null;

  document.addEventListener('DOMContentLoaded', function() {
    // 1. Swiper Galeri Başlatma (Küçük resimler & Ana galeri)
    const thumbEl = document.querySelector('.sd-thumb-swiper');
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
      window.sdMainSwiper = new Swiper('.sd-main-swiper', {
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
      window.addEventListener('resize', function() {
        if (window.sdMainSwiper) {
          window.sdMainSwiper.update();
        }
      });
    }

    // 2. Geriye dönük uyumluluk için sekme yönlendirici
    window.activateIdeaTab = function(targetSelector) {
      if (targetSelector === '#id-pane-comments' || targetSelector === '#sidebarCommentsCard') {
        const commentsCard = document.getElementById('sidebarCommentsCard');
        if (commentsCard) {
          commentsCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
          focusCommentInput();
        }
      } else if (targetSelector === '#id-pane-desc' || targetSelector === '#sdDescCard') {
        const descCard = document.getElementById('sdDescCard');
        if (descCard) {
          descCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      }
    };

    // 2.1 Yorumlar Sıralama Pop-up Menüsü (Firma Profili ile Aynı Davranış)
    const sortCommentsWrapper = document.getElementById('sortCommentsWrapper');
    const sortCommentsTriggerBtn = document.getElementById('sortCommentsTriggerBtn');
    const sortCommentsPopup = document.getElementById('sortCommentsPopup');
    const sortCommentsForm = document.getElementById('sortCommentsForm');
    const sortCommentsInput = document.getElementById('sortCommentsInput');

    if (sortCommentsTriggerBtn && sortCommentsPopup) {
      const hasCustomSort = sortCommentsTriggerBtn.classList.contains('is-active');

      function openSortCommentsPopup() {
        sortCommentsPopup.classList.add('show');
        sortCommentsTriggerBtn.classList.add('is-active');
        sortCommentsTriggerBtn.setAttribute('aria-expanded', 'true');
      }

      function closeSortCommentsPopup() {
        sortCommentsPopup.classList.remove('show');
        if (!hasCustomSort) {
          sortCommentsTriggerBtn.classList.remove('is-active');
        }
        sortCommentsTriggerBtn.setAttribute('aria-expanded', 'false');
      }

      function toggleSortCommentsPopup() {
        if (sortCommentsPopup.classList.contains('show')) {
          closeSortCommentsPopup();
        } else {
          openSortCommentsPopup();
        }
      }

      sortCommentsTriggerBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleSortCommentsPopup();
      });

      sortCommentsPopup.addEventListener('click', function(e) {
        e.stopPropagation();
      });

      document.addEventListener('click', function(e) {
        if (sortCommentsWrapper && !sortCommentsWrapper.contains(e.target)) {
          closeSortCommentsPopup();
        }
      });

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sortCommentsPopup.classList.contains('show')) {
          closeSortCommentsPopup();
        }
      });

      if (sortCommentsForm && sortCommentsInput) {
        const sortOptionItems = sortCommentsPopup.querySelectorAll('.sd-sort-option-item');

        sortOptionItems.forEach(item => {
          item.addEventListener('click', function(e) {
            e.stopPropagation();
            const val = this.getAttribute('data-value') || '';
            sortOptionItems.forEach(el => el.classList.remove('is-selected'));
            this.classList.add('is-selected');
            sortCommentsInput.value = val;

            setTimeout(() => {
              sortCommentsForm.submit();
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

    // URL'de ?comment=show veya #sidebarCommentsCard veya sort_by varsa yorum alanına kaydır
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('comment') === 'show' || window.location.hash === '#sidebarCommentsCard' || window.location.hash === '#id-pane-comments' || urlParams.has('sort_by')) {
      const sidebarComments = document.getElementById('sidebarCommentsCard');
      if (sidebarComments) {
        setTimeout(() => sidebarComments.scrollIntoView({ behavior: 'smooth', block: 'start' }), 200);
      }
      if (urlParams.get('comment') === 'show') {
        focusCommentInput();
      }
    }

    // 3. Mobil Açıklama Metni Kırpma (3 Satır) ve "Daha fazla / Daha az" Butonu
    function initIdeaDescClamp() {
      const descEl = document.getElementById('sdDescText');
      const toggleBtn = document.getElementById('sdDescToggleBtn');
      if (!descEl || !toggleBtn) return;

      if (window.innerWidth <= 991) {
        const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
        if (!isExpanded) {
          descEl.classList.add('sd-clamped');
        }

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

    initIdeaDescClamp();
    window.addEventListener('resize', initIdeaDescClamp);
  });

  // Açıklama "Daha fazla / Daha az" Açma-Kapatma Fonksiyonu
  function toggleIdeaDescription() {
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

  // Yorum inputuna odaklanma
  function focusCommentInput() {
    const textarea = document.getElementById('mainCommentTextarea');
    const formCard = document.getElementById('commentFormCard');
    if (formCard) {
      formCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    if (textarea) {
      setTimeout(() => textarea.focus(), 300);
    }
  }

  // Modern Giriş Yap Pop-up Fonksiyonları (Fiyat Geçmişi Tasarımı ile Birebir)
  window.showLoginPopup = function(message, triggerEl, title) {
    const popup = document.getElementById('sdAuthPopup');
    const backdrop = document.getElementById('sdAuthPopupBackdrop');
    const msgEl = document.getElementById('sdAuthPopupMessage');
    const titleEl = document.getElementById('sdAuthPopupTitleText');
    if (!popup) return;

    if (message && msgEl) {
      msgEl.textContent = message;
    }
    if (title && titleEl) {
      titleEl.textContent = title;
    }

    const isMobile = window.innerWidth <= 991;

    popup.style.display = 'block';

    if (isMobile) {
      popup.style.top = '';
      popup.style.left = '';
      popup.style.transform = '';
    } else if (triggerEl && typeof triggerEl.getBoundingClientRect === 'function') {
      const rect = triggerEl.getBoundingClientRect();
      const popupWidth = popup.offsetWidth || 320;
      const popupHeight = popup.offsetHeight || 220;
      const windowWidth = window.innerWidth;
      const windowHeight = window.innerHeight;

      let left = rect.left + (rect.width / 2) - (popupWidth / 2);
      if (left < 14) left = 14;
      if (left + popupWidth > windowWidth - 14) left = windowWidth - popupWidth - 14;

      let top = rect.bottom + 10;
      if (top + popupHeight > windowHeight - 14) {
        top = Math.max(14, rect.top - popupHeight - 10);
      }

      popup.style.left = left + 'px';
      popup.style.top = top + 'px';
      popup.style.transform = '';
    } else {
      popup.style.left = '50%';
      popup.style.top = '50%';
      popup.style.transform = 'translate(-50%, -50%)';
    }

    setTimeout(() => {
      if (backdrop) backdrop.classList.add('is-open');
      popup.classList.add('is-open');
    }, 10);

    document.addEventListener('keydown', handleAuthPopupEscape);
  };

  window.closeLoginPopup = function() {
    const popup = document.getElementById('sdAuthPopup');
    const backdrop = document.getElementById('sdAuthPopupBackdrop');

    if (popup) {
      popup.classList.remove('is-open');
      setTimeout(() => {
        popup.style.display = 'none';
        popup.style.top = '';
        popup.style.left = '';
        popup.style.transform = '';
      }, 200);
    }
    if (backdrop) {
      backdrop.classList.remove('is-open');
    }

    document.removeEventListener('keydown', handleAuthPopupEscape);
  };

  function handleAuthPopupEscape(e) {
    if (e.key === 'Escape') {
      closeLoginPopup();
    }
  }

  window.openLoginModalFromAuthPopup = function() {
    closeLoginPopup();
    setTimeout(function() {
      var modalEl = document.getElementById("exampleModalToggle");
      if (modalEl) {
        if (window.bootstrap && bootstrap.Modal) {
          var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
          modal.show();
        } else if (window.$ && $.fn.modal) {
          $("#exampleModalToggle").modal("show");
        }
      } else {
        window.location.href = "{{ route('login') }}";
      }
    }, 150);
  };

  // Fikri Beğen / Beğeniden Çıkar (Desktop + Mobile Senkron)
  function handleIdeaLike(slug, el) {
    const triggerEl = el || (typeof event !== 'undefined' ? (event?.currentTarget || event?.target) : null);
    @guest()
      showLoginPopup('Bu fikri beğenmek için lütfen giriş yapın.', triggerEl, 'Fikri Beğen');
      return false;
    @else
      fetch("/idea/like/" + slug, {
        method: "GET",
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
      })
      .then(response => response.json())
      .then(data => {
        const desktopBtn = document.getElementById('desktop-like-btn');
        const mobileBtn = document.getElementById('mobile-like-btn');
        const desktopCount = document.getElementById('desktop-like-count');
        const mobileCount = document.getElementById('mobile-like-count');
        const specCount = document.getElementById('spec-like-count');

        let current = parseInt(desktopCount ? desktopCount.textContent : (mobileCount ? mobileCount.textContent : 0)) || 0;
        let nextCount = data.isDeleted ? Math.max(0, current - 1) : current + 1;

        if (desktopCount) desktopCount.textContent = nextCount;
        if (mobileCount) mobileCount.textContent = nextCount;
        if (specCount) specCount.textContent = nextCount + ' Beğeni';

        if (data.isDeleted) {
          if (desktopBtn) desktopBtn.classList.remove('is-liked');
          if (mobileBtn) mobileBtn.classList.remove('is-liked');
        } else {
          if (desktopBtn) desktopBtn.classList.add('is-liked');
          if (mobileBtn) mobileBtn.classList.add('is-liked');
        }
      })
      .catch(err => console.error('Like error:', err));
    @endguest
  }

  // Yorum Beğeni Fonksiyonu
  function likeToggle(id, el) {
    const triggerEl = el || (typeof event !== 'undefined' ? (event?.currentTarget || event?.target) : null);
    @guest()
      showLoginPopup('Yorumu beğenmek için lütfen giriş yapın.', triggerEl, 'Yorumu Beğen');
      return false;
    @else
      const btn = event.currentTarget;
      const countEl = btn.querySelector('.reply-like-count') || btn.querySelector('span');

      fetch("{{ route('idea.reply.like') }}/" + id, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
          "Accept": "application/json"
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.status) {
          let c = parseInt(countEl ? countEl.textContent : 0) || 0;
          if (data.status === 'add') {
            btn.classList.add('is-liked');
            if (countEl) countEl.textContent = c + 1;
          } else {
            btn.classList.remove('is-liked');
            if (countEl) countEl.textContent = Math.max(0, c - 1);
          }
        }
      })
      .catch(err => console.error('Reply like error:', err));
    @endguest
  }

  // Yanıt Formunu Aç/Kapat
  function toggleReplyForm(replyId) {
    const box = document.getElementById('replyFormBox-' + replyId);
    if (!box) return;
    box.style.display = (box.style.display === 'none' || !box.style.display) ? 'block' : 'none';
    if (box.style.display === 'block') {
      const input = box.querySelector('input[type="text"]');
      if (input) setTimeout(() => input.focus(), 100);
    }
  }

  // İç İçe Yanıtları Aç/Kapat
  function toggleNestedAnswers(replyId, btn) {
    const box = document.getElementById('nestedAnswers-' + replyId);
    if (!box) return;
    const isHidden = (box.style.display === 'none' || !box.style.display);
    box.style.display = isHidden ? 'flex' : 'none';
    if (btn) {
      const icon = btn.querySelector('i');
      if (icon) icon.className = isHidden ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down';
    }
  }

  // Fikir Bağlantısını Paylaş
  function shareIdeaLink(btn) {
    const url = window.location.href;
    const title = @json($ideaTitle);

    if (navigator.share) {
      navigator.share({
        title: title,
        url: url
      }).catch(() => {});
    } else if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(url).then(() => {
        showCopyTooltip(btn);
      }).catch(() => {
        fallbackCopy(url, btn);
      });
    } else {
      fallbackCopy(url, btn);
    }
  }

  function fallbackCopy(text, btn) {
    const el = document.createElement('textarea');
    el.value = text;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    showCopyTooltip(btn);
  }

  function showCopyTooltip(btn) {
    if (!btn) return;
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-check text-success"></i> <span>Kopyalandı</span>';
    setTimeout(() => {
      btn.innerHTML = originalHtml;
    }, 2200);
  }
</script>
@endsection