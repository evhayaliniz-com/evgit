@extends('site.inc.master')

@section('css')
<style>
  /* ==========================================================================
     Modern "Fikirlerim" (My Design Ideas) Management Page — Web & Mobile
     100% Cohesive with "Hizmetlerim" (site/services/profile-index.blade.php)
     ========================================================================== */
  :root,
  .ms-page-wrapper {
    --ms-primary: #2563eb;
    --ms-primary-hover: #1d4ed8;
    --ms-primary-soft: rgba(37, 99, 235, 0.08);
    --ms-surface: #ffffff;
    --ms-surface-alt: #f8fafc;
    --ms-bg: #f4f7fb;
    --ms-border: #e2e8f0;
    --ms-border-subtle: #f1f5f9;
    --ms-text-main: #0f172a;
    --ms-text-secondary: #334155;
    --ms-text-muted: #64748b;
    --ms-success: #10b981;
    --ms-success-soft: rgba(16, 185, 129, 0.12);
    --ms-warning: #f59e0b;
    --ms-warning-soft: rgba(245, 158, 11, 0.14);
    --ms-danger: #ef4444;
    --ms-danger-soft: rgba(239, 68, 68, 0.1);
    --ms-radius-lg: 16px;
    --ms-radius-md: 12px;
    --ms-radius-sm: 8px;
    --ms-shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.04), 0 4px 12px rgba(15, 23, 42, 0.03);
    --ms-shadow-pop: 0 12px 32px rgba(15, 23, 42, 0.14), 0 2px 6px rgba(15, 23, 42, 0.06);
  }

  body.dark .ms-page-wrapper,
  body.dark {
    --ms-primary: #3b82f6;
    --ms-primary-hover: #60a5fa;
    --ms-primary-soft: rgba(59, 130, 246, 0.15);
    --ms-surface: #1e293b;
    --ms-surface-alt: #0f172a;
    --ms-bg: #0b1120;
    --ms-border: rgba(255, 255, 255, 0.09);
    --ms-border-subtle: rgba(255, 255, 255, 0.05);
    --ms-text-main: #f8fafc;
    --ms-text-secondary: #cbd5e1;
    --ms-text-muted: #94a3b8;
    --ms-shadow-sm: 0 4px 20px rgba(0, 0, 0, 0.28);
    --ms-shadow-pop: 0 14px 36px rgba(0, 0, 0, 0.55);
  }

  .ms-page-wrapper {
    background: var(--ms-bg);
    min-height: calc(100vh - 55px);
    padding: 20px 24px 100px;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: var(--ms-text-main);
  }

  .ms-container {
    max-width: 1440px;
    margin: 0 auto;
  }

  /* --- Top Header & CTA --- */
  .ms-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .ms-header-left {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .ms-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 12.5px;
    color: var(--ms-text-muted);
  }

  .ms-breadcrumb a {
    color: var(--ms-text-muted);
    text-decoration: none;
    transition: color 0.15s;
  }

  .ms-breadcrumb a:hover {
    color: var(--ms-primary);
  }

  .ms-page-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .ms-page-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: var(--ms-text-main);
    margin: 0;
    letter-spacing: -0.02em;
  }

  .ms-total-pill {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 999px;
    background: var(--ms-primary-soft);
    color: var(--ms-primary);
    font-size: 12px;
    font-weight: 700;
  }

  .ms-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .ms-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff !important;
    font-size: 13.5px;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px;
    border: none;
    text-decoration: none !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    cursor: pointer;
    white-space: nowrap;
  }

  .ms-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    color: #ffffff !important;
  }

  /* --- KPI Summary Cards --- */
  .ms-kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 18px;
  }

  .ms-kpi-card {
    background: var(--ms-surface);
    border: 1px solid var(--ms-border);
    border-radius: var(--ms-radius-md);
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: var(--ms-shadow-sm);
    text-align: left;
    width: 100%;
  }

  .ms-kpi-card:hover {
    border-color: var(--ms-primary);
    transform: translateY(-1px);
  }

  .ms-kpi-card.is-active {
    border-color: var(--ms-primary);
    background: linear-gradient(180deg, var(--ms-surface) 0%, var(--ms-primary-soft) 100%);
    box-shadow: 0 0 0 2px var(--ms-primary-soft);
  }

  .ms-kpi-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
  }

  .ms-kpi-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--ms-text-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .ms-kpi-value {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: var(--ms-text-main);
    line-height: 1.2;
  }

  .ms-kpi-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
  }

  .ms-kpi-icon.kpi-all {
    background: var(--ms-primary-soft);
    color: var(--ms-primary);
  }

  .ms-kpi-icon.kpi-published {
    background: var(--ms-success-soft);
    color: var(--ms-success);
  }

  .ms-kpi-icon.kpi-pending {
    background: var(--ms-warning-soft);
    color: var(--ms-warning);
  }

  .ms-kpi-icon.kpi-passive {
    background: var(--ms-danger-soft);
    color: var(--ms-danger);
  }

  /* --- Filter & Search Toolbar --- */
  .ms-toolbar-card {
    background: var(--ms-surface);
    border: 1px solid var(--ms-border);
    border-radius: var(--ms-radius-md);
    padding: 14px 16px;
    margin-bottom: 16px;
    box-shadow: var(--ms-shadow-sm);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }

  .ms-search-box {
    position: relative;
    flex: 1 1 280px;
    max-width: 440px;
  }

  .ms-search-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--ms-text-muted);
    font-size: 14px;
    pointer-events: none;
  }

  .ms-search-input {
    width: 100%;
    height: 40px;
    padding: 0 36px 0 38px;
    border-radius: 10px;
    border: 1px solid var(--ms-border) !important;
    background: var(--ms-surface-alt);
    color: var(--ms-text-main);
    font-size: 13.5px;
    transition: border-color 0.15s, background 0.15s;
  }

  .ms-search-input:focus {
    background: var(--ms-surface);
    border-color: var(--ms-primary) !important;
    outline: none;
  }

  .ms-search-clear {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: none;
    background: transparent;
    color: var(--ms-text-muted);
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 13px;
  }

  .ms-search-clear:hover {
    background: var(--ms-border);
    color: var(--ms-text-main);
  }

  .ms-toolbar-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .ms-select-group {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .ms-select-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--ms-text-muted);
    white-space: nowrap;
  }

  .ms-select {
    height: 40px;
    padding: 0 32px 0 12px;
    border-radius: 10px;
    border: 1px solid var(--ms-border) !important;
    background-color: var(--ms-surface-alt);
    color: var(--ms-text-main);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
  }

  .ms-mobile-sort-wrap {
    display: none;
  }

  /* --- Main Data Table Container --- */
  .ms-table-card {
    background: var(--ms-surface);
    border: 1px solid var(--ms-border);
    border-radius: var(--ms-radius-lg);
    box-shadow: var(--ms-shadow-sm);
    overflow: hidden;
    position: relative;
  }

  .ms-table-region {
    width: 100%;
    overflow-x: auto;
    max-height: min(680px, 75vh);
    overflow-y: auto;
    container-type: inline-size;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
  }

  body.dark .ms-table-region {
    scrollbar-color: #334155 transparent;
  }

  .ms-table-region:focus-visible {
    outline: 2px solid var(--ms-primary);
    outline-offset: -2px;
  }

  .ms-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
  }

  .ms-table thead {
    position: sticky;
    top: 0;
    z-index: 15;
    background: var(--ms-surface-alt);
  }

  .ms-table thead th {
    background: var(--ms-surface-alt);
    color: var(--ms-text-muted);
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 13px 14px;
    border-bottom: 1px solid var(--ms-border);
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
  }

  .ms-table thead th.sortable {
    cursor: pointer;
    transition: color 0.15s, background 0.15s;
  }

  .ms-table thead th.sortable:hover {
    color: var(--ms-primary);
    background: var(--ms-primary-soft);
  }

  .ms-th-inner {
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .ms-table thead th.sortable .sort-icon {
    font-size: 11px;
    opacity: 0.45;
    transition: opacity 0.15s, color 0.15s;
  }

  .ms-table thead th.sortable.sort-asc .sort-icon,
  .ms-table thead th.sortable.sort-desc .sort-icon {
    opacity: 1;
    color: var(--ms-primary);
  }

  .ms-table tbody tr.ms-service-row {
    transition: background-color 0.15s ease;
  }

  .ms-table tbody tr.ms-service-row:hover td {
    background-color: var(--ms-primary-soft);
  }

  .ms-table tbody td {
    padding: 14px;
    border-bottom: 1px solid var(--ms-border-subtle);
    vertical-align: middle;
    color: var(--ms-text-main);
    font-size: 13.5px;
    background: var(--ms-surface);
  }

  .ms-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Column Specific Styles */
  .ms-col-id {
    width: 68px;
  }

  .ms-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: var(--ms-text-muted);
    background: var(--ms-surface-alt);
    border: 1px solid var(--ms-border);
    padding: 3px 8px;
    border-radius: 6px;
  }

  .ms-col-thumb {
    width: 84px;
  }

  .ms-thumb-wrap {
    position: relative;
    width: 64px;
    height: 48px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid var(--ms-border);
    background: var(--ms-surface-alt);
    flex-shrink: 0;
  }

  .ms-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .ms-photo-count {
    position: absolute;
    right: 3px;
    bottom: 3px;
    background: rgba(15, 23, 42, 0.75);
    color: #fff;
    font-size: 9.5px;
    font-weight: 600;
    padding: 1px 5px;
    border-radius: 4px;
    line-height: 1.3;
  }

  .ms-col-title {
    min-width: 240px;
    max-width: 400px;
  }

  .ms-title-block {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .ms-service-title-link {
    font-weight: 700;
    font-size: 14px;
    color: var(--ms-text-main);
    text-decoration: none;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.15s;
  }

  .ms-service-title-link:hover {
    color: var(--ms-primary);
  }

  .ms-idea-excerpt {
    font-size: 12px;
    color: var(--ms-text-muted);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .ms-external-icon {
    font-size: 11px;
    margin-left: 4px;
    opacity: 0.65;
  }

  .ms-category-crumbs {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 4px;
  }

  .ms-cat-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 500;
    color: var(--ms-text-muted);
    background: var(--ms-surface-alt);
    padding: 2px 8px;
    border-radius: 6px;
    border: 1px solid var(--ms-border-subtle);
  }

  .ms-cat-tag i {
    color: var(--ms-primary);
    font-size: 10.5px;
  }

  .ms-metric-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 999px;
    background: var(--ms-surface-alt);
    border: 1px solid var(--ms-border-subtle);
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ms-text-secondary);
    white-space: nowrap;
  }

  .ms-metric-pill i {
    color: var(--ms-primary);
    font-size: 12px;
  }

  .ms-metric-likes i {
    color: #ef4444;
  }

  .ms-metric-comments i {
    color: #10b981;
  }

  /* --- Status & Approval Badges --- */
  .ms-status-stack {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 5px;
  }

  .ms-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
  }

  .ms-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
  }

  .ms-status-active {
    background: var(--ms-success-soft);
    color: var(--ms-success);
  }

  .ms-status-active .ms-status-dot {
    background: var(--ms-success);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
  }

  .ms-status-passive {
    background: var(--ms-danger-soft);
    color: var(--ms-danger);
  }

  .ms-status-passive .ms-status-dot {
    background: var(--ms-danger);
  }

  .ms-approval-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 6px;
    white-space: nowrap;
  }

  .ms-approval-confirmed {
    color: var(--ms-success);
    background: rgba(16, 185, 129, 0.08);
  }

  .ms-approval-pending {
    color: #d97706;
    background: var(--ms-warning-soft);
  }

  body.dark .ms-approval-pending {
    color: #fbbf24;
  }

  /* --- Date Column --- */
  .ms-date-wrap {
    display: flex;
    flex-direction: column;
    line-height: 1.3;
    white-space: nowrap;
  }

  .ms-date-day {
    font-weight: 600;
    font-size: 12.5px;
    color: var(--ms-text-secondary);
  }

  .ms-date-time {
    font-size: 11px;
    color: var(--ms-text-muted);
  }

  /* --- Actions Column --- */
  .ms-col-actions {
    width: 140px;
    text-align: right;
  }

  .ms-actions-group {
    display: inline-flex;
    align-items: center;
    justify-content: flex-end;
    gap: 6px;
  }

  .ms-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1px solid var(--ms-border);
    background: var(--ms-surface-alt);
    color: var(--ms-text-secondary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 13px;
    text-decoration: none !important;
    cursor: pointer;
    transition: all 0.15s ease;
  }

  .ms-action-label {
    display: none;
  }

  .ms-action-edit:hover {
    background: var(--ms-primary);
    border-color: var(--ms-primary);
    color: #fff !important;
  }

  .ms-action-deactivate:hover {
    background: var(--ms-warning);
    border-color: var(--ms-warning);
    color: #fff !important;
  }

  .ms-action-activate {
    color: var(--ms-success);
    border-color: rgba(16, 185, 129, 0.35);
    background: var(--ms-success-soft);
  }

  .ms-action-activate:hover {
    background: var(--ms-success);
    border-color: var(--ms-success);
    color: #fff !important;
  }

  .ms-action-delete:hover {
    background: var(--ms-danger);
    border-color: var(--ms-danger);
    color: #fff !important;
  }

  /* --- Empty State --- */
  .ms-empty-cell {
    padding: 48px 20px !important;
    text-align: center;
  }

  .ms-empty-state {
    max-width: 420px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .ms-empty-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--ms-primary-soft);
    color: var(--ms-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 4px;
  }

  .ms-empty-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--ms-text-main);
    margin: 0;
  }

  .ms-empty-desc {
    font-size: 13px;
    color: var(--ms-text-muted);
    margin: 0 0 8px;
  }

  .ms-empty-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .ms-btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    border-radius: 10px;
    border: 1px solid var(--ms-border);
    background: var(--ms-surface-alt);
    color: var(--ms-text-secondary);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
  }

  .ms-btn-reset:hover {
    border-color: var(--ms-primary);
    color: var(--ms-primary);
  }

  /* --- Loading Overlay --- */
  .ms-table-loading {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.72);
    backdrop-filter: blur(2px);
    z-index: 30;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 10px;
    font-size: 13px;
    font-weight: 600;
    color: var(--ms-primary);
  }

  body.dark .ms-table-loading {
    background: rgba(15, 23, 42, 0.72);
  }

  /* --- Pagination Footer --- */
  .ms-pagination-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-top: 1px solid var(--ms-border);
    background: var(--ms-surface-alt);
    flex-wrap: wrap;
    gap: 12px;
  }

  .ms-pagination-info {
    font-size: 12.5px;
    color: var(--ms-text-muted);
    font-weight: 500;
  }

  .ms-pagination-links nav > div:first-child {
    display: none;
  }

  .ms-pagination-links .pagination {
    margin: 0;
    gap: 4px;
    flex-wrap: wrap;
  }

  .ms-pagination-links .page-link {
    border-radius: 8px !important;
    border: 1px solid var(--ms-border);
    background: var(--ms-surface);
    color: var(--ms-text-secondary);
    font-size: 13px;
    font-weight: 600;
    padding: 6px 12px;
  }

  .ms-pagination-links .page-item.active .page-link {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    border-color: #2563eb !important;
    color: #fff !important;
  }

  /* ==========================================================================
     RESPONSIVE MOBILE & TABLET TRANSFORMATION (< 992px)
     Converts the 9-column table into sleek, touch-friendly Idea Cards
     ========================================================================== */
  @media (max-width: 991.98px) {
    .ms-page-wrapper {
      padding: 14px 12px 110px;
    }

    .ms-page-title {
      font-size: 18px;
    }

    .ms-kpi-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }

    .ms-kpi-card {
      padding: 12px;
    }

    .ms-kpi-value {
      font-size: 18px;
    }

    .ms-kpi-icon {
      width: 36px;
      height: 36px;
      font-size: 14px;
    }

    .ms-toolbar-card {
      padding: 12px;
      gap: 10px;
    }

    .ms-search-box {
      flex: 1 1 100%;
      max-width: 100%;
    }

    .ms-toolbar-controls {
      width: 100%;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 8px;
    }

    .ms-mobile-sort-wrap {
      display: flex;
    }

    .ms-select-group {
      flex-direction: column;
      align-items: stretch;
      gap: 4px;
    }

    .ms-select {
      width: 100%;
      height: 38px;
      padding: 0 24px 0 9px;
      font-size: 12px;
    }

    /* Transform Table into Stacked Idea Cards on Mobile */
    .ms-table-card {
      background: transparent;
      border: none;
      box-shadow: none;
      overflow: visible;
    }

    .ms-table-region {
      max-height: none;
      overflow: visible;
    }

    .ms-table,
    .ms-table tbody {
      display: block;
      width: 100%;
    }

    .ms-table thead {
      display: none !important;
    }

    .ms-table tbody tr.ms-service-row {
      display: grid;
      grid-template-columns: 76px 1fr;
      gap: 10px 12px;
      background: var(--ms-surface);
      border: 1px solid var(--ms-border);
      border-radius: 14px;
      padding: 14px;
      margin-bottom: 12px;
      box-shadow: var(--ms-shadow-sm);
      position: relative;
    }

    .ms-table tbody tr.ms-service-row td {
      display: block;
      padding: 0;
      border: none;
      background: transparent !important;
      width: auto !important;
      min-width: 0 !important;
      max-width: none !important;
      text-align: left;
    }

    /* Card Top-Right ID Badge */
    .ms-table tbody td.ms-col-id {
      position: absolute;
      top: 12px;
      right: 12px;
      z-index: 2;
    }

    /* Card Thumbnail (Top-Left) */
    .ms-table tbody td.ms-col-thumb {
      grid-column: 1 / 2;
      grid-row: 1 / 3;
    }

    .ms-thumb-wrap {
      width: 76px;
      height: 76px;
      border-radius: 10px;
    }

    /* Card Title & Category (Top-Right next to thumb) */
    .ms-table tbody td.ms-col-title {
      grid-column: 2 / 3;
      grid-row: 1 / 2;
      padding-right: 54px;
    }

    /* Card Status & Approval Badges (Below Title) */
    .ms-table tbody td.ms-col-status {
      grid-column: 2 / 3;
      grid-row: 2 / 3;
    }

    .ms-status-stack {
      flex-direction: row;
      flex-wrap: wrap;
      align-items: center;
      gap: 6px;
    }

    /* Card Meta Grid: Views, Likes, Comments, Date */
    .ms-table tbody td.ms-col-metric,
    .ms-table tbody td.ms-col-date {
      grid-column: 1 / -1;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 12px;
      padding: 6px 10px !important;
      background: var(--ms-surface-alt) !important;
      border-radius: 8px;
    }

    .ms-table tbody td.ms-col-metric::before,
    .ms-table tbody td.ms-col-date::before {
      content: attr(data-label);
      font-size: 11.5px;
      font-weight: 600;
      color: var(--ms-text-muted);
    }

    .ms-date-wrap {
      flex-direction: row;
      gap: 6px;
      align-items: center;
    }

    /* Card Touch Action Buttons Bar */
    .ms-table tbody td.ms-col-actions {
      grid-column: 1 / -1;
      padding-top: 8px !important;
      border-top: 1px solid var(--ms-border) !important;
    }

    .ms-actions-group {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 8px;
      width: 100%;
    }

    .ms-action-btn {
      width: 100%;
      height: 38px;
      font-size: 12.5px;
      font-weight: 600;
      padding: 0 10px;
    }

    .ms-action-label {
      display: inline;
    }

    .ms-pagination-bar {
      border-radius: 12px;
      border: 1px solid var(--ms-border);
      background: var(--ms-surface);
      justify-content: center;
      text-align: center;
    }
  }

  @media (max-width: 420px) {
    .ms-toolbar-controls {
      grid-template-columns: 1fr 1fr;
    }
    .ms-mobile-sort-wrap {
      grid-column: 1 / -1;
    }
  }
</style>
@endsection

@section('content')
@php
  $stats = $ideaStats ?? [
    'total' => $ideas->total(),
    'published' => 0,
    'active' => 0,
    'pending' => 0,
    'passive' => 0,
  ];
  $currentStatus = request('status', '');
  $currentSortBy = request('sort_by', '');
  $currentSortOrder = request('sort_order', 'desc');
  $currentPerPage = request('per_page', 20);
  $currentSearch = request('search', '');
  $isCompanyUser = auth()->check() && auth()->user()->user_type === 'company';
@endphp

<div class="main sidebar">
  <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
    <div class="index-right ms-page-wrapper">
      <div class="ms-container">

        {{-- 1. Üst Başlık ve Hızlı Aksiyon --}}
        <div class="ms-page-header">
          <div class="ms-header-left">
            <ul class="ms-breadcrumb">
              <li><a href="{{ route('site.home') }}"><i class="fa-solid fa-house"></i> Anasayfa</a></li>
              <li><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></li>
              @if($isCompanyUser)
                <li><a href="{{ route('company.dashboard') }}">Firma Paneli</a></li>
              @else
                <li><a href="{{ route('user.profile.edit') }}">Hesabım</a></li>
              @endif
              <li><i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i></li>
              <li>Fikirlerim</li>
            </ul>
            <div class="ms-page-title-row">
              <h1 class="ms-page-title" id="ms-table-heading">Fikirlerim</h1>
              <span class="ms-total-pill" id="js-header-total">{{ $ideas->total() }} Kayıt</span>
            </div>
          </div>

          <div class="ms-header-actions">
            <a href="{{ route('idea.create') }}" class="ms-btn-primary">
              <i class="fa-solid fa-plus"></i>
              <span>Yeni Fikir Oluştur</span>
            </a>
          </div>
        </div>

        {{-- 2. Özet KPI Kartları (Tıklanabilir Hızlı Filtreler) --}}
        <div class="ms-kpi-grid" role="group" aria-label="Fikir Durum Özeti">
          <button type="button" class="ms-kpi-card js-kpi-filter {{ $currentStatus === '' ? 'is-active' : '' }}" data-status="">
            <div class="ms-kpi-info">
              <span class="ms-kpi-label">Toplam Fikir</span>
              <span class="ms-kpi-value" id="kpi-total">{{ $stats['total'] }}</span>
            </div>
            <div class="ms-kpi-icon kpi-all">
              <i class="fa-solid fa-lightbulb"></i>
            </div>
          </button>

          <button type="button" class="ms-kpi-card js-kpi-filter {{ $currentStatus === 'yayinda' ? 'is-active' : '' }}" data-status="yayinda">
            <div class="ms-kpi-info">
              <span class="ms-kpi-label">Yayında (Onaylı)</span>
              <span class="ms-kpi-value" id="kpi-published">{{ $stats['published'] }}</span>
            </div>
            <div class="ms-kpi-icon kpi-published">
              <i class="fa-solid fa-circle-check"></i>
            </div>
          </button>

          <button type="button" class="ms-kpi-card js-kpi-filter {{ $currentStatus === 'onay_bekleyen' ? 'is-active' : '' }}" data-status="onay_bekleyen">
            <div class="ms-kpi-info">
              <span class="ms-kpi-label">Onay Bekleyen</span>
              <span class="ms-kpi-value" id="kpi-pending">{{ $stats['pending'] }}</span>
            </div>
            <div class="ms-kpi-icon kpi-pending">
              <i class="fa-solid fa-clock"></i>
            </div>
          </button>

          <button type="button" class="ms-kpi-card js-kpi-filter {{ $currentStatus === 'pasif' ? 'is-active' : '' }}" data-status="pasif">
            <div class="ms-kpi-info">
              <span class="ms-kpi-label">Pasif Fikirler</span>
              <span class="ms-kpi-value" id="kpi-passive">{{ $stats['passive'] }}</span>
            </div>
            <div class="ms-kpi-icon kpi-passive">
              <i class="fa-solid fa-eye-slash"></i>
            </div>
          </button>
        </div>

        {{-- 3. Arama, Filtreleme ve Sıralama Araç Çubuğu --}}
        <div class="ms-toolbar-card">
          <div class="ms-search-box">
            <i class="fa-solid fa-magnifying-glass ms-search-icon"></i>
            <input
              type="text"
              id="search-input"
              class="ms-search-input"
              placeholder="Fikir açıklaması, başlık veya #ID ile ara..."
              value="{{ $currentSearch }}"
              autocomplete="off"
            >
            <button type="button" id="search-clear-btn" class="ms-search-clear" title="Aramayı Temizle" aria-label="Aramayı Temizle">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>

          <div class="ms-toolbar-controls">
            {{-- Durum Filtresi --}}
            <div class="ms-select-group">
              <label for="status-filter" class="ms-select-label">Durum:</label>
              <select id="status-filter" class="form-select ms-select">
                <option value="" @selected($currentStatus === '')>Tümü</option>
                <option value="yayinda" @selected($currentStatus === 'yayinda')>Yayında (Onaylı)</option>
                <option value="aktif" @selected($currentStatus === 'aktif')>Aktif</option>
                <option value="onay_bekleyen" @selected($currentStatus === 'onay_bekleyen')>Onay Bekleyen</option>
                <option value="pasif" @selected($currentStatus === 'pasif')>Pasif</option>
              </select>
            </div>

            {{-- Mobil Sıralama Seçici --}}
            <div class="ms-select-group ms-mobile-sort-wrap">
              <label for="mobile-sort-filter" class="ms-select-label">Sırala:</label>
              <select id="mobile-sort-filter" class="form-select ms-select">
                <option value="id:desc" @selected(!$currentSortBy || ($currentSortBy === 'id' && $currentSortOrder === 'desc'))>En Yeni</option>
                <option value="view_count:desc" @selected($currentSortBy === 'view_count' && $currentSortOrder === 'desc')>En Çok Görüntülenen</option>
                <option value="like_count:desc" @selected($currentSortBy === 'like_count' && $currentSortOrder === 'desc')>En Çok Beğenilen</option>
                <option value="reply_count:desc" @selected($currentSortBy === 'reply_count' && $currentSortOrder === 'desc')>En Çok Yorum Alan</option>
              </select>
            </div>

            {{-- Sayfa Başı Gösterim --}}
            <div class="ms-select-group">
              <label for="per-page-filter" class="ms-select-label">Gösterim:</label>
              <select id="per-page-filter" class="form-select ms-select">
                <option value="10" @selected($currentPerPage == 10)>10 Satır</option>
                <option value="20" @selected($currentPerPage == 20)>20 Satır</option>
                <option value="50" @selected($currentPerPage == 50)>50 Satır</option>
                <option value="100" @selected($currentPerPage == 100)>100 Satır</option>
              </select>
            </div>
          </div>
        </div>

        {{-- 4. Tek Semantik Tablo (Masaüstünde Sticky Header, Mobilde Akıllı Fikir Kartları) --}}
        <div class="ms-table-card">
          <div class="ms-table-loading" id="ms-table-loading">
            <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
            <span>Yükleniyor...</span>
          </div>

          <div tabindex="0" role="region" aria-labelledby="ms-table-heading" class="ms-table-region" id="tableBody">
            <table class="ms-table">
              <thead>
                <tr>
                  <th class="sortable {{ $currentSortBy === 'id' ? 'sort-' . $currentSortOrder : '' }}" data-sort="id">
                    <span class="ms-th-inner">ID <i class="fa-solid fa-sort sort-icon"></i></span>
                  </th>
                  <th>Görsel</th>
                  <th>Fikir İçeriği & Kategori</th>
                  <th class="sortable {{ $currentSortBy === 'view_count' ? 'sort-' . $currentSortOrder : '' }}" data-sort="view_count">
                    <span class="ms-th-inner">Görüntülenme <i class="fa-solid fa-sort sort-icon"></i></span>
                  </th>
                  <th class="sortable {{ $currentSortBy === 'like_count' ? 'sort-' . $currentSortOrder : '' }}" data-sort="like_count">
                    <span class="ms-th-inner">Beğeni <i class="fa-solid fa-sort sort-icon"></i></span>
                  </th>
                  <th class="sortable {{ $currentSortBy === 'reply_count' ? 'sort-' . $currentSortOrder : '' }}" data-sort="reply_count">
                    <span class="ms-th-inner">Yorum <i class="fa-solid fa-sort sort-icon"></i></span>
                  </th>
                  <th>Durum & Onay</th>
                  <th class="sortable {{ $currentSortBy === 'created_at' ? 'sort-' . $currentSortOrder : '' }}" data-sort="created_at">
                    <span class="ms-th-inner">Tarih <i class="fa-solid fa-sort sort-icon"></i></span>
                  </th>
                  <th style="text-align: right;">İşlemler</th>
                </tr>
              </thead>
              <tbody id="ideas-table-body">
                @include('site.idea.partials.ideas-table', ['ideas' => $ideas])
              </tbody>
            </table>
          </div>

          {{-- Sayfalama Barı --}}
          <div class="ms-pagination-bar">
            <div class="ms-pagination-info" id="ms-pagination-info">
              Toplam <strong>{{ $ideas->total() }}</strong> tasarım fikri listeleniyor
            </div>
            <div class="ms-pagination-links" id="pagination-container">
              {{ $ideas->links() }}
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

{{-- Fikir Silme Onay Modalı --}}
<div class="modal fade" id="deleteIdeaModal" tabindex="-1" aria-labelledby="deleteIdeaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content" style="border-radius: 16px; border: 1px solid var(--ms-border); background: var(--ms-surface); color: var(--ms-text-main);">
      <div class="modal-body text-center p-4">
        <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(239, 68, 68, 0.12); color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 14px;">
          <i class="fa-regular fa-trash-can"></i>
        </div>
        <h6 class="fw-bold mb-2" id="deleteIdeaModalLabel">Fikri Silmek İstiyor Musunuz?</h6>
        <p class="text-muted small mb-4" id="deleteIdeaModalDesc">
          Bu işlem geri alınamaz. Tasarım fikri kalıcı olarak silinecektir.
        </p>
        <div class="d-flex gap-2 justify-content-center">
          <button type="button" class="btn btn-light btn-sm px-3 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">
            Vazgeç
          </button>
          <button type="button" class="btn btn-danger btn-sm px-3 fw-semibold" id="confirmDeleteIdeaBtn" style="border-radius: 8px;">
            <i class="fa-regular fa-trash-can me-1"></i> Evet, Sil
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    var searchTimeout = null;
    var currentSortBy = @json($currentSortBy);
    var currentSortOrder = @json($currentSortOrder ?: 'desc');
    var currentPage = {{ (int) request('page', 1) }};
    var pendingDeleteUrl = null;
    var pendingDeleteId = null;

    // Aramayı temizle butonu görünürlüğü
    function syncClearBtn() {
      var val = $('#search-input').val();
      if (val && val.trim().length > 0) {
        $('#search-clear-btn').css('display', 'inline-flex');
      } else {
        $('#search-clear-btn').hide();
      }

      var hasActiveFilter = (val && val.trim().length > 0) || $('#status-filter').val() !== '';
      $('.js-reset-filters').toggle(Boolean(hasActiveFilter));
    }

    syncClearBtn();

    // KPI sayaçlarını güncelle
    function updateKpiStats(stats, filteredTotal) {
      if (stats) {
        $('#kpi-total').text(stats.total ?? 0);
        $('#kpi-published').text(stats.published ?? 0);
        $('#kpi-pending').text(stats.pending ?? 0);
        $('#kpi-passive').text(stats.passive ?? 0);
      }
      if (typeof filteredTotal !== 'undefined') {
        $('#js-header-total').text(filteredTotal + ' Kayıt');
        $('#ms-pagination-info').html('Toplam <strong>' + filteredTotal + '</strong> tasarım fikri listeleniyor');
      }
    }

    // URL durumunu (Query String) sayfa yenilemeden senkronize et
    function syncBrowserUrl() {
      if (!window.history || !window.history.replaceState) return;
      var params = new URLSearchParams();
      var search = $('#search-input').val().trim();
      var status = $('#status-filter').val();
      var perPage = $('#per-page-filter').val();

      if (search) params.set('search', search);
      if (status) params.set('status', status);
      if (perPage && perPage !== '20') params.set('per_page', perPage);
      if (currentSortBy) {
        params.set('sort_by', currentSortBy);
        params.set('sort_order', currentSortOrder);
      }
      if (currentPage > 1) {
        params.set('page', currentPage);
      }

      var queryString = params.toString();
      var newUrl = window.location.pathname + (queryString ? '?' + queryString : '');
      window.history.replaceState({ path: newUrl }, '', newUrl);
    }

    // AJAX Arama / Filtreleme / Sıralama / Sayfalama
    function performSearch(resetPage) {
      if (resetPage) {
        currentPage = 1;
      }

      var search = $('#search-input').val().trim();
      var status = $('#status-filter').val();
      var perPage = $('#per-page-filter').val();

      // KPI kartı aktiflik durumu
      $('.js-kpi-filter').removeClass('is-active');
      $('.js-kpi-filter[data-status="' + status + '"]').addClass('is-active');

      syncClearBtn();
      syncBrowserUrl();

      $('#ms-table-loading').css('display', 'flex');

      $.ajax({
        url: '{{ route("idea.profile.search") }}',
        method: 'POST',
        data: {
          search: search,
          status: status,
          per_page: perPage,
          sort_by: currentSortBy,
          sort_order: currentSortOrder,
          page: currentPage,
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.success) {
            $('#ideas-table-body').html(response.html);
            $('#pagination-container').html(response.pagination);
            updateKpiStats(response.stats, response.total);
            syncClearBtn();
          }
        },
        error: function () {
          if (typeof toastr !== 'undefined') {
            toastr.error('Fikirler yüklenirken bir hata oluştu.');
          }
        },
        complete: function () {
          $('#ms-table-loading').hide();
        }
      });
    }

    // Arama kutusu (Debounce 350ms)
    $('#search-input').on('input', function () {
      syncClearBtn();
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(function () {
        performSearch(true);
      }, 350);
    });

    // Aramayı temizle
    $('#search-clear-btn').on('click', function () {
      $('#search-input').val('').trigger('focus');
      performSearch(true);
    });

    // Filtreleri sıfırla (Boş durum butonu)
    $(document).on('click', '.js-reset-filters', function () {
      $('#search-input').val('');
      $('#status-filter').val('');
      currentSortBy = '';
      currentSortOrder = 'desc';
      $('.sortable').removeClass('sort-asc sort-desc');
      $('.sortable .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
      performSearch(true);
    });

    // KPI Kartlarına tıklayınca filtrele
    $('.js-kpi-filter').on('click', function () {
      var status = $(this).data('status');
      $('#status-filter').val(status);
      performSearch(true);
    });

    // Durum & Sayfa Başı filtre değişimi
    $('#status-filter, #per-page-filter').on('change', function () {
      performSearch(true);
    });

    // Mobil sıralama seçici
    $('#mobile-sort-filter').on('change', function () {
      var parts = ($(this).val() || 'id:desc').split(':');
      currentSortBy = parts[0];
      currentSortOrder = parts[1] || 'desc';
      performSearch(true);
    });

    // Masaüstü Sütun Başlığı Sıralama
    $(document).on('click', '.sortable', function () {
      var sortBy = $(this).data('sort');

      if (currentSortBy === sortBy) {
        currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
      } else {
        currentSortBy = sortBy;
        currentSortOrder = 'desc';
      }

      $('.sortable').removeClass('sort-asc sort-desc');
      $('.sortable .sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');

      $(this).addClass('sort-' + currentSortOrder);
      var icon = $(this).find('.sort-icon');
      icon.removeClass('fa-sort').addClass(currentSortOrder === 'asc' ? 'fa-sort-up' : 'fa-sort-down');

      performSearch(true);
    });

    // Sayfalama (Pagination) Tıklaması
    $(document).on('click', '#pagination-container .pagination a', function (e) {
      e.preventDefault();
      var url = $(this).attr('href');
      if (!url || url === '#') return;

      try {
        var parsedUrl = new URL(url, window.location.origin);
        var pageParam = parsedUrl.searchParams.get('page');
        currentPage = pageParam ? parseInt(pageParam, 10) : 1;
      } catch (err) {
        var match = url.match(/[?&]page=(\d+)/);
        currentPage = match ? parseInt(match[1], 10) : 1;
      }

      performSearch(false);

      if (window.innerWidth < 992) {
        $('html, body').animate({ scrollTop: $('.ms-toolbar-card').offset().top - 65 }, 250);
      }
    });

    // =========================================================================
    // ANLIK DURUM DEĞİŞTİRME (AKTİF / PASİF AJAX TOGGLE)
    // =========================================================================
    $(document).on('click', '.js-toggle-status', function (e) {
      e.preventDefault();
      var $btn = $(this);
      if ($btn.prop('disabled')) return;

      var ideaId = $btn.data('idea-id');
      var url = $btn.data('url');
      $btn.prop('disabled', true);

      $.ajax({
        url: url,
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          if (response.success) {
            var isNowActive = Number(response.new_status) === 1;
            var $badge = $('.js-status-badge[data-idea-id="' + ideaId + '"]');

            $badge
              .removeClass('ms-status-active ms-status-passive')
              .addClass(isNowActive ? 'ms-status-active' : 'ms-status-passive');
            $badge.find('.js-status-text').text(isNowActive ? 'Aktif' : 'Pasif');

            $btn
              .removeClass('ms-action-deactivate ms-action-activate')
              .addClass(isNowActive ? 'ms-action-deactivate' : 'ms-action-activate')
              .attr('title', isNowActive ? 'Fikri Pasife Al' : 'Fikri Aktif Et')
              .attr('aria-label', isNowActive ? 'Fikri Pasife Al' : 'Fikri Aktif Et');

            $btn.find('.js-toggle-icon')
              .removeClass('fa-ban fa-check')
              .addClass(isNowActive ? 'fa-ban' : 'fa-check');
            $btn.find('.js-toggle-label').text(isNowActive ? 'Pasif Et' : 'Aktif Et');

            if (response.stats) {
              updateKpiStats(response.stats);
            }

            if (typeof toastr !== 'undefined') {
              toastr.success(response.message);
            }

            if ($('#status-filter').val() !== '') {
              performSearch(false);
            }
          }
        },
        error: function () {
          if (typeof toastr !== 'undefined') {
            toastr.error('Durum değiştirilirken bir hata oluştu.');
          }
        },
        complete: function () {
          $btn.prop('disabled', false);
        }
      });
    });

    // =========================================================================
    // FİKİR SİLME (ONAY MODALI + AJAX)
    // =========================================================================
    $(document).on('click', '.js-delete-idea', function (e) {
      e.preventDefault();
      pendingDeleteId = $(this).data('idea-id');
      pendingDeleteUrl = $(this).data('url');
      var title = $(this).data('idea-title') || ('#' + pendingDeleteId);

      $('#deleteIdeaModalDesc').html('<strong>"' + $('<div>').text(title).html() + '"</strong> tasarım fikrini kalıcı olarak silmek istediğinize emin misiniz?');
      var modalEl = document.getElementById('deleteIdeaModal');
      var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
      modal.show();
    });

    $('#confirmDeleteIdeaBtn').on('click', function () {
      if (!pendingDeleteUrl || !pendingDeleteId) return;
      var $btn = $(this);
      var originalHtml = $btn.html();
      $btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Siliniyor...');

      $.ajax({
        url: pendingDeleteUrl,
        method: 'POST',
        data: {
          _method: 'DELETE',
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          var modalEl = document.getElementById('deleteIdeaModal');
          var modal = bootstrap.Modal.getInstance(modalEl);
          if (modal) modal.hide();

          if (typeof toastr !== 'undefined') {
            toastr.success((response && response.message) || 'Fikir başarıyla silindi.');
          }

          var $row = $('.ms-service-row[data-row-id="' + pendingDeleteId + '"]');
          $row.fadeOut(220, function () {
            $(this).remove();
            performSearch(false);
          });
        },
        error: function () {
          if (typeof toastr !== 'undefined') {
            toastr.error('Fikir silinirken bir hata oluştu.');
          }
        },
        complete: function () {
          $btn.prop('disabled', false).html(originalHtml);
          pendingDeleteUrl = null;
          pendingDeleteId = null;
        }
      });
    });
  });
</script>
@endsection
