@extends('admin.inc.master') @section('css') <style>
  /* Sortable Header Styles */
  .sortable-header {
    color: inherit !important;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .sortable-header:hover {
    color: #007bff !important;
    text-decoration: none !important;
  }

  .sortable-header:hover i {
    opacity: 1 !important;
  }

  html.dark-style .sortable-header {
    color: white !important;
  }

  html.dark-style .sortable-header:hover {
    color: #4da3ff !important;
  }

  html.dark-style h4 {
    color: white;
  }

  html.dark-style .analiz-main-search-area {
    border: 1px solid #6969696e;
    color: white;
  }

  html.dark-style .nav-link {
    color: white !important;
  }

  html.dark-style .analiz-page {
    background: #1C222F;
  }

  html.dark-style .analiz-top-stats-container.d-flex {
    background: #283144;
    border: 1px solid #6969696e;
  }

  html.dark-style .search-area-last-buttons button:last-child {
    color: white;
  }

  html.dark-style .input-search-box.search-area-top-input i {
    color: white;
  }

  html.dark-style input {
    background: #283144;
    color: white !important;
    border: 1px solid #6969696e;
  }

  html.dark-style .datepicker-overlay {
    background: #283144;
    color: white !important;
    border: 1px solid #6969696e;
  }

  html.dark-style .ddropdown-menu {
    border: 1px solid #6969696e;
    background: transparent;
  }

  html.dark-style .header-scroll::-webkit-scrollbar-track {
    background: #283144 !important;
  }

  html.dark-style li.page-item:hover a {
    background: #1e50da !important;
    color: white !important;
  }

  html.dark-style div#pagination-container li.page-item:hover a {
    background: #1e50da !important;
    color: white !important;
  }

  html.dark-style li.page-item.disabled .page-link {
    height: 33px;
    line-height: 19px;
  }

  html.dark-style li.page-item.disabled:hover .page-link {
    background: #730303 !important;
    color: white !important;
  }

  html.dark-style .analiz-top-stats-box::after {
    background: linear-gradient(to bottom, transparent, #ffffff, transparent);
  }

  html.dark-style .day:hover:not(.header) {
    background: #212529;
  }

  html.dark-style .ddropdown-item {
    background: #283144;
    color: white !important;
    border-bottom: 1px solid #6969696e;
  }

  html.dark-style .tumhizmetlernewtable.table-responsive thead tr:hover th {
    background: #1c222f !important;
  }

  html.dark-style .search-results-text.mb-2.mt-2 h4 {
    color: white !important;
  }

  html.dark-style .status-dropdown-menu {
    background: transparent;
  }

  html.dark-style .yesno-dropdown-menu {
    background: transparent;
  }

  html.dark-style .table-wrapper {
    border: 1px solid #6969696e !important;
  }

  html.dark-style .status-option {
    border-top: 1px solid #6969696e !important;
    background: #283144;
  }

  html.dark-style .yesno-option {
    border-top: 1px solid #6969696e !important;
    background: #283144;
  }

  html.dark-style .yesno-badge.is-no {
    background: #5f000e;
  }

  html.dark-style .status-indicator.is-inactive {
    background: #5f000e;
    color: #c62828;
  }

  html.dark-style .status-indicator.is-active {
    background: #1c222f;
    color: #2e7d32;
  }

  html.dark-style .yesno-badge.is-yes {
    background: #1c222f;
    color: #1976d2;
  }

  html.dark-style .tumhizmetlernewtable.table-responsive td {
    background: #283144;
    color: white !important;
    border-right: 1px solid #6969696e !important;
    border-bottom: 1px solid #6969696e !important;
  }

  html.dark-style .tumhizmetlernewtable.table-responsive thead th {
    background: #283144;
    color: white !important;
  }

  html.dark-style .day.inrange {
    background: #1a1a1a;
  }

  html.dark-style .day.selected {
    background: #000 !important;
    color: #fff;
  }

  html.dark-style .day.header {
    color: white;
  }

  html.dark-style .date-select-container .select-date {
    background: #283144;
    color: white !important;
    border: 1px solid #6969696e;
  }

  html.dark-style .analizsearch-toggle {
    background: #283144;
    color: white !important;
    border: 1px solid #6969696e;
  }

  html.dark-style .date-sub {
    color: white;
  }

  html.dark-style .date-select-container svg {
    filter: invert(1);
  }

  html.dark-style .analizsearch-item {
    background: #283144;
    color: white !important;
    border-bottom: 1px solid #6969696e;
  }

  html.dark-style input::placeholder {
    color: white !important;
  }

  html.dark-style div#ddropdownToggle {
    background: #283144;
    color: white;
    border: 1px solid #6969696e;
  }

  html.dark-style h1 {
    color: white;
  }

  html.dark-style .chart-box {
    background: #283144;
  }

  html.dark-style h2 {
    color: white;
  }

  html.dark-style h3 {
    color: white;
  }

  html.dark-style b {
    color: white;
  }

  html.dark-style span {
    color: white;
  }

  html.dark-style span.page-link {
    color: white !important;
    border: 0;
  }

  html.dark-style .analiz-top-stats-box {
    color: white;
  }

  html.dark-style .ddropdown-toggle span:first-child {
    color: white;
  }

  html.dark-style .date-select-container .select-date span {
    color: white;
  }

  html.dark-style .search-area-top-input.min-max-inputs span:first-child {
    color: white;
  }

  html.dark-style .ddropdown-toggle span:last-child {
    color: white;
  }

  .status-container {
    width: 100%;
    min-width: 100px;
    margin: 0 auto;
    position: relative;
    /* Parent'a relative eklendi */
  }

  .status-dropdown-wrapper {
    position: static;
    /* Static yapıldı */
    border-radius: 8px;
    margin-bottom: 0;
    /* Margin kaldırıldı */
  }

  .status-dropdown-btn {
    padding: 0;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    transition: background 0.2s;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
  }

  .status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
  }

  .status-indicator.is-active {
    background: #e8f5e9;
    color: #2e7d32;
  }

  .status-indicator.is-inactive {
    background: #ffebee;
    color: #c62828;
  }

  .status-symbol {
    font-size: 18px;
    line-height: 1;
  }

  .status-dropdown-menu {
    display: none;
    position: absolute;
    /* Absolute positioning */
    top: calc(-130% + 4px);
    left: 50%;
    transform: translateX(-50%);
    /* Ortala */
    min-width: 120px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    /* Çok yüksek z-index - tablo üstünde olması için */
    margin: 0;
    overflow: hidden;
  }

  .status-dropdown-wrapper.is-open .status-dropdown-menu {
    display: block;
  }

  .status-option {
    padding: 12px 20px;
    cursor: pointer;
    transition: background 0.2s;
    border-top: 1px solid #e0e0e0;
    background: #fafafa;
    white-space: nowrap;
  }

  .status-option:first-child {
    border-top: none;
  }

  .status-option:hover {
    background: #f0f0f0;
  }

  .status-option:active {
    background: #e8e8e8;
  }

  .status-dropdown-btn:active {
    opacity: 0.8;
  }

  /* Tablo hücresinde kullanım için */
  td .status-container,
  th .status-container,
  td .yesno-container,
  th .yesno-container {
    position: relative;
    overflow: visible;
  }

  td,
  th {
    overflow: visible !important;
  }

  table {
    overflow: visible !important;
  }

  /* ============== YESNO DROPDOWN STYLES ============== */
  .yesno-container {
    width: 100%;
    min-width: 100px;
    margin: 0 auto;
    position: relative;
  }

  .yesno-dropdown-wrapper {
    position: static;
    border-radius: 8px;
    margin-bottom: 0;
  }

  .yesno-dropdown-btn {
    padding: 0;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    transition: background 0.2s;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
  }

  .yesno-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
  }

  .yesno-badge.is-yes {
    background: #e3f2fd;
    color: #1976d2;
  }

  .yesno-badge.is-no {
    background: #fff3e0;
    color: #f57c00;
  }

  .yesno-icon {
    font-size: 16px;
    line-height: 1;
  }

  .yesno-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(-130% + 4px);
    left: 50%;
    transform: translateX(-50%);
    min-width: 120px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    margin: 0;
    overflow: hidden;
  }

  .yesno-dropdown-wrapper.is-open .yesno-dropdown-menu {
    display: block;
  }

  .yesno-option {
    padding: 12px 20px;
    cursor: pointer;
    transition: background 0.2s;
    border-top: 1px solid #e0e0e0;
    background: #fafafa;
    white-space: nowrap;
  }

  .yesno-option:first-child {
    border-top: none;
  }

  .yesno-option:hover {
    background: #f0f0f0;
  }

  .yesno-option:active {
    background: #e8e8e8;
  }

  .yesno-dropdown-btn:active {
    opacity: 0.8;
  }

  .search-results-text.mb-2.mt-2 h4 {
    color: #445568;
    font-size: 14px;
    margin-left: 12px;
    margin-top: 10px;
    font-weight: 300;
    margin-bottom: -4px;
  }

  .search-area-top-input.min-max-inputs {
    width: auto;
  }

  .analiz-title h1 {
    font-size: 20px;
  }

  .analiz-top-stats-container.d-flex:last-child {
    width: 44%;
  }

  div#pagination-container .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between {
    justify-content: center !important;
  }

  div#pagination-container li.page-item {
    border-radius: 0;
  }

  div#pagination-container a.page-link {
    border: 0;
    border-radius: 0 !important;
    line-height: 21px;
  }

  .search-results-text.mb-2.mt-2 b {
    font-weight: 600;
  }

  .tumhizmetlernewtable.table-responsive td:nth-child(3) {
    width: 240px;
  }

  .tumhizmetlernewtable.table-responsive th:nth-child(3) {
    width: 240px;
  }

  nav#layout-navbar {
    position: relative !important;
  }

  .search-area-top-input input:focus-visible {
    outline: 1px solid #4068e2 !important;
  }

  aside#layout-menu {
    position: absolute !important;
  }

  .tumhizmetlernewtable.table-responsive td {
    width: 120px;
  }

  .tumhizmetlernewtable.table-responsive thead th {
    width: 121px;
  }

  .ddropdown-container {
    position: relative;
    width: 260px;
  }

  /* Üst dropdown */
  .ddropdown-toggle {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px 12px;
    width: 100%;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    cursor: pointer;
    color: #333;
    font-size: 14px;
  }

  .ddropdown-toggle span:first-child {
    color: #111;
    font-weight: 500;
    font-size: 12px;
  }

  .ddropdown-toggle span:last-child {
    color: #555;
    font-size: 15px;
    margin-top: 4px;
  }

  /* Menü */
  .ddropdown-menu {
    position: absolute;
    top: 105%;
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    display: none;
    z-index: 10;
  }

  .ddropdown-menu.show {
    display: block;
  }

  .ddropdown-item {
    padding: 10px 14px;
    cursor: pointer;
    font-size: 14px;
    border-bottom: 1px solid #f2f2f2;
  }

  .ddropdown-item:last-child {
    border-bottom: none;
  }

  .ddropdown-item:hover {
    background: #f8f9fa;
  }

  /* Datepicker overlay */
  .datepicker-overlay {
    position: absolute;
    top: 0;
    left: 0;
    min-width: 265px;
    width: 100%;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 16px;
    display: none;
    z-index: 50;
  }

  .datepicker-overlay.show {
    display: block;
  }

  .date-header {
    font-size: 14px;
    font-weight: 600;
  }

  .date-sub {
    font-size: 12px;
    color: #555;
    margin-bottom: 8px;
  }

  .calendar {
    text-align: center;
    font-size: 12px;
  }

  .calendar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 6px;
  }

  .calendar-title {
    font-weight: 600;
    flex: 1;
    text-align: center;
  }

  .calendar-nav-btn {
    background: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }

  .calendar-nav-btn:hover {
    background: #e0e0e0;
    border-color: #ccc;
  }

  .days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 4px;
  }

  .day {
    padding: 5px 0;
    cursor: pointer;
    border-radius: 4px;
  }

  .day.header {
    font-weight: 600;
    color: #777;
    cursor: default;
  }

  .day:hover:not(.header) {
    background: #eee;
  }

  .day.selected {
    background: #000;
    color: #fff;
  }

  .day.inrange {
    background: #dcdcdc;
  }

  .date-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 8px;
  }

  .date-actions button {
    border-radius: 20px;
    padding: 4px 14px;
    font-size: 13px;
  }

  .analiz-title-area.d-flex {
    display: flex;
    vertical-align: middle;
    align-items: center;
    justify-content: space-between;
  }

  .analiz-top-stats-box {
    position: relative;
  }

  .analiz-top-stats-box::after {
    content: "";
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    width: 1px;
    height: 95%;
    background: linear-gradient(to bottom, transparent, #000000, transparent);
    filter: blur(1px);
  }

  .analiz-top-stats-container {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 12px;
    background: white;
    margin-top: 15px;
    padding-right: 0;
  }

  .analiz-top-stats-results.results-flex {
    display: flex;
    vertical-align: middle;
    align-items: center;
    justify-content: space-between;
  }

  .analiz-top-stats-title h2 {
    font-size: 15px;
  }

  .analiz-top-stats-box {
    width: 100%;
    margin-left: 16px;
    margin-right: 15px;
  }

  .analiz-top-stats-container.d-flex {
    justify-content: space-between;
    width: 54%;
  }

  .analiz-top-stats-flex {
    display: flex;
    justify-content: space-between;
  }

  .analiz-top-stats-bottom .d-flex {
    width: 100%;
    justify-content: space-between;
  }

  span.analiz-top-stats-results-min.green {
    color: green;
  }

  .analiz-top-stats-bottom {
    margin-right: 30px;
  }

  span.analiz-top-stats-results-min.red {
    color: red;
  }

  .analiz-top-min-results {
    margin-right: 30px;
  }

  .analiz-top-min-results span {
    margin-bottom: 0px;
    margin-right: 6px;
    font-size: 12px;
  }

  .analiz-top-main-results {
    margin-right: 10px;
  }

  .analiz-top-min-results b {
    font-size: 12px;
  }

  .analiz-top-main-results h3 {
    margin-bottom: 15px;
    margin-top: 20px;
  }

  .analiz-top-stats-title h2 {
    margin: 0;
  }

  .analiz-top-stats-box:last-child:after {
    display: none;
  }

  .analiz-top-stats-box:last-child:after {}

  .analiz-top-stats-box:last-child .analiz-top-stats-title:after {
    display: none;
  }

  span.analiz-top-stats-results-min {
    font-size: 12px;
  }

  .analiz-page {
    margin-top: -127px;
    padding-top: 20px;
    padding-bottom: 60px;
  }

  .chart-box {
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
    padding: 20px;
    width: 100%;
    height: auto;
  }

  .chart-box h4 {
    text-align: right;
    font-size: 12px;
    font-weight: bold;
    color: #999;
    margin-bottom: -10px;
  }

  canvas {
    width: 100% !important;
    height: 180px !important;
  }

  .chart-box h3 {
    font-size: 15px;
    text-align: center;
    width: 100%;
    margin-top: 15px;
    margin-bottom: 0;
  }

  .chart-box h4 {
    margin-bottom: 5px;
  }

  .analiz-charts-area {
    margin-top: 25px;
  }

  div#ddropdownToggle:after {
    content: "\f107";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
  }

  .container-xxl.flex-grow-1.container-p-y {
    padding: 0;
    margin: 0;
    max-width: unset;
  }

  .date-select-container {
    position: relative;
  }

  .date-select-container svg {
    width: 25px;
    position: absolute;
    right: 10px;
  }

  .date-select-container .select-date {
    background: #fff;
    border: 1px solid #ddd;
    width: 100%;
    border-radius: 6px;
    padding: 6px 12px;
    display: inline-flex;
    min-width: 225px;
    align-items: center;
    gap: 11px;
    cursor: pointer;
    font-size: 14px;
  }

  .analiz-main-search-area-top {
    display: flex;
    vertical-align: middle;
    align-items: center;
    width: 100%;
    overflow-x: scroll;
    justify-content: space-between;
    padding-top: 20px;
    margin-top: -9px;
    overflow-y: hidden;
  }

  .analizsearch-container {
    position: relative;
    max-width: 300px;
    margin-bottom: 0px;
  }

  .analizsearch-toggle {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 10px 12px;
    width: 100%;
    min-width: 175px;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    cursor: pointer;
    color: #445568;
    font-size: 14px;
    position: relative;
  }

  .analizsearch-toggle span:last-child {
    color: #555;
    font-size: 15px;
    margin-top: 4px;
  }

  .analizsearch-toggle:after {
    content: "\f107";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s ease;
  }

  .analizsearch-toggle.active:after {
    transform: translateY(-50%) rotate(180deg);
  }

  .analizsearch-menu {
    position: fixed;
    /* absolute yerine fixed */
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    display: none;
    z-index: 1000;
    max-height: 250px;
    overflow-y: auto;
  }

  .analizsearch-menu.show {
    display: block;
  }

  .analizsearch-item {
    padding: 10px 14px;
    cursor: pointer;
    font-size: 14px;
    border-bottom: 1px solid #f2f2f2;
    color: #333;
  }

  .analizsearch-item:last-child {
    border-bottom: none;
  }

  .analizsearch-item:hover {
    background: #f8f9fa;
  }

  .search-area-top-input input {
    width: 100%;
    border: 1px solid #ddd;
    font-size: 14px;
    border-radius: 8px;
    min-width: 90px;
    padding: 5px 10px;
    color: #445568;
  }

  .search-area-top-input input::placeholder {
    color: #445568;
  }

  .min-max-inputs-area.d-flex input {
    max-width: 80px;
  }

  .search-area-top-input {
    margin: 0px 5px;
    width: 100%;
  }

  .input-search-box.search-area-top-input {
    position: relative;
  }

  .input-search-box.search-area-top-input i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #445568
  }

  .search-area-top-input select {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px 10px;
    width: 100%;
    color: #445568
  }

  .search-area-top-input.min-max-inputs span:first-child {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    text-align: center;
    font-size: 14px;
    color: #445568
  }

  .search-area-top-input {
    position: relative;
  }

  .search-area-top-input.min-max-inputs .d-flex span {
    position: relative;
    top: 3px;
    margin: 0px 5px;
  }

  .analiz-main-search-area div#pills-tabContent {
    padding: 0;
  }

  .analiz-main-search-area {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 12px;
    margin-top: 25px;
  }

  .analiz-main-search-area div#pills-tabContent {
    padding: 0;
  }

  .search-area-last-buttons {
    display: flex;
    vertical-align: middle;
    align-items: center;
  }

  .search-area-last-buttons button:first-child {
    background: #0d6efd;
    color: white;
    margin-left: 10px;
    margin-right: 10px;
    border: 1px solid #0d6efd;
  }

  .search-area-last-buttons button {
    padding: 5px 10px;
    border-radius: 8px;
    width: 100%;
    min-width: 120px;
    height: 40px;
    border: 1px solid #0d6efd;
  }

  .search-area-last-buttons button:last-child {
    color: #0d6efd;
    background: transparent;
  }

  .search-area-top-input input:first-child {}

  .date-select-container .select-date span {
    white-space: nowrap;
    color: #445568
  }

  .date-select-container .select-date {
    height: 40px;
  }

  .search-area-top-input input {
    height: 40px;
  }

  .search-area-top-input select {
    height: 40px;
  }

  .analiz-main-search-area {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 12px;
    margin-top: 25px;
  }

  .analiz-main-search-area .nav-link.active {
    border-bottom: 2px solid #5a8dee !important;
    background: transparent !important;
    color: #5a8dee !important;
    box-shadow: unset;
    border-radius: 0;
  }

  .analiz-main-search-area .nav-link {
    font-weight: 600;
  }

  .analiz-main-search-area .nav-link {
    color: #777777 !important;
  }

  .mobileshowflex {
    display: none !important;
  }

  .addnewhizmetflex {
    display: flex !important;
    justify-content: space-between;
  }

  .addnewhizmetflex .hizmetler-title-right-search.mobileshowflex {
    width: 50%;
    justify-content: flex-end;
  }

  .tumhizmetler-islemlerbox.edit:hover {
    background: #2841a9;
  }

  .tumhizmetler-islemlerbox.tooltipp.tooltipp2 {
    display: block;
  }

  .input-search-box.search-area-top-input input {
    min-width: 200px;
  }

  .tumhizmetler-islemlerbox.tooltipp.tooltipp2 .tooltiptext {
    right: unset !important;
    left: -170%;
    z-index: 999;
    width: auto !important;
    bottom: 0;
    min-width: 65px;
  }

  .tumhizmetler-islemlerbox.tooltipp.tooltipp2 .tooltiptext::after {
    right: -8px;
    left: unset;
    transform: rotate(270deg);
    top: 37%;
  }

  .tumhizmetler-islemlerbox.status.active:hover {
    background: #3c9bbb;
  }

  .tumhizmetler-islemlerbox.remove:hover {
    background: #b91b64;
  }

  .tumhizmetler-islemlerbox.status.inactive:hover {
    background: #a5661b;
  }

  .tumhizmetlernewtable.table-responsive thead th:first-child {
    width: 30px;
  }

  .tumhizmetlernewtable.table-responsive td:first-child {
    width: 40px;
    text-align: center;
  }

  .tumhizmetlernewtable.table-responsive {
    overflow: visible !important;
  }

  /* Table wrapper - header ve body'yi ayırmak için */
  .table-wrapper {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    overflow: hidden;
  }

  /* Header kısmı - sabit */
  .table-header {
    background: white;
    border-bottom: 2px solid #dee2e6;
    overflow: hidden;
  }

  .table-header table {
    margin-bottom: 0;
    table-layout: fixed;
  }

  .table-header .table thead th {
    border-bottom: none;
    white-space: nowrap;
    background: #f8f9fa;
    position: relative;
  }

  /* Header altındaki scroll alanı */
  .header-scroll {
    overflow-x: auto;
    overflow-y: hidden;
    height: 9px;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    position: relative;
  }

  .header-scroll-content {
    height: 1px;
    background: transparent;
  }

  /* Body kısmı */
  .table-body {
    overflow-x: auto;
    overflow-y: visible;
    /* İsterseniz sabit yükseklik */
  }

  .table-body table {
    margin-bottom: 0;
    table-layout: fixed;
  }

  .table-body .table thead {
    display: none;
    /* Header'ı gizle, üstte zaten var */
  }

  /* Scrollbar gizle - sadece üstteki görünsün */
  .table-body::-webkit-scrollbar {
    display: none;
  }

  /* Üstteki scrollbar stilleri */
  .header-scroll::-webkit-scrollbar {
    height: 8px;
  }

  .header-scroll::-webkit-scrollbar-track {
    background: #e9ecef;
    border-radius: 6px;
  }

  .header-scroll::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 6px;
  }

  .header-scroll::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
  }

  .tumhizmetlernewtable.table-responsive td:hover {
    background: red;
  }

  .tumhizmetlernewtable.table-responsive tr:hover td {
    background: rgba(67, 97, 238, 0.05);
  }

  .tumhizmetlernewtable.table-responsive thead tr:hover th {
    background: #efefef !important;
  }

  .tumhizmetlernewtable.table-responsive tr:hover th {
    background: rgba(67, 97, 238, 0.05);
  }

  .tumhizmetlerpagination .page-item.active .page-link {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
  }

  .addnewhizmet a:hover {
    color: #4068e2;
    background: transparent;
  }

  .hizmetler-title-right-search {
    width: 100%;
    position: relative;
  }

  .tum-hizmetler-box.index-right .d-flex.align-items-center.justify-content-between {
    margin-top: 30px;
  }

  .tumhizmetlernewtable.table-responsive th {
    align-items: center;
    vertical-align: middle;
    text-align: center;
    color: #445568;
    font-weight: 400;
  }

  .tumhizmetlernewtable.table-responsive td {
    vertical-align: middle;
  }

  .tumhizmetlernewtable.table-responsive thead {
    background: gray !important;
  }

  .tumhizmetlerfiyattrigger {
    border: 1px solid #cdcccf !important;
    display: inline-block;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 8px;
  }

  .tumhizmetlerfiyatarea {
    position: relative;
  }

  .tumhizmetlerfiyatbox {
    position: absolute;
    background: white;
    border: 1px solid #cdcccf !important;
    padding: 10px;
    text-align: left;
    border-radius: 12px;
    top: -10px;
  }

  .tumhizmetlerfiyatbox input {
    border: 1px solid #cdcccf !important;
    text-align: center;
    margin: 10px 0px;
    border-radius: 8px;
  }

  .tumhizmetlerfiyatbox button {
    width: 100%;
    margin: 0px 3px;
    font-size: 14px !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    padding: 5px 10px;
    justify-content: center !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    transition: all 0.25s ease !important;
  }

  .tumhizmetlerfiyatbox {
    display: none;
  }

  .tumhizmetler-islemlerbox {
    padding: 4px 15px;
    margin-bottom: 5px;
    border-radius: 8px;
    text-align: left;
    cursor: pointer;
    color: white;
    transition: all .3s;
  }

  .tumhizmetler-islemlerbox.edit {
    background: #4162EE;
  }

  .tumhizmetler-islemler {
    width: 45px !important;
    align-items: center !important;
    justify-content: center !important;
    margin-left: 40% !important;
  }

  .tumhizmetler-islemlerbox.status.active {
    background: #4CC8F2;
  }

  .tumhizmetler-islemlerbox.remove {
    background: #F72586;
  }

  .tumhizmetler-islemlerbox.status.inactive {
    background: #F89622;
  }

  .tumhizmetler-status.statsoff {
    background: #FED2E7;
    color: #f35773;
  }

  .tumhizmetler-status {
    padding: 5px 10px;
    border-radius: 20px;
    font-weight: bold;
  }

  .tumhizmetler-status.statson {
    background: #DEF1FA;
    color: #429197;
  }

  .tumhizmetlerlerfiyatbox-islem {
    display: flex;
    vertical-align: middle;
    align-items: center;
  }

  button.tumhizmetler-closed {
    background: #eff3ff;
    color: #2563eb !important;
    border: 1px solid #eff3ff;
  }

  .tumhizmetlerlerfiyatbox-islem button:last-child {
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    color: #fff !important;
    /* box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3) !important; */
    border: 0 !important;
  }

  .tumhizmetlerfiyatbox.show {
    display: block;
  }

  .analiz-title h1 {
    color: #445568;
  }

  .analiz-top-stats-box {
    color: #445568;
  }

  .analiz-top-stats-bottom b {
    font-weight: 400;
    font-size: 14px;
  }

  .tumhizmetlernewtable.table-responsive thead th {
    background: #efefef;
    color: #445568;
    text-align: center;
    padding-left: 0px;
    padding-right: 0px;
    font-weight: 600;
    font-size: 12px;
  }

  .thi-new {}

  .tumhizmetlerimg img {
    border-radius: 8px;
  }

  .tumhizmetlernewtable.table-responsive td {
    text-align: center;
    color: #445568;
    font-size: 15px;
  }

  .tumhizmetler-name h2 {
    text-align: left;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    overflow: hidden;
    /* margin-left: 2px; */
    height: 20px;
    font-size: 15px;
    margin-bottom: 0;
    -webkit-box-orient: vertical;
  }

  .tumhizmetler-name h3 {
    font-size: 14px;
    font-weight: 400;
    text-align: left;
    padding-left: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    overflow: hidden;
    height: 32px;
    margin-bottom: 0;
    -webkit-box-orient: vertical;
  }

  .tumhizmetlernewtable.table-responsive thead th:nth-child(2) {}

  .tum-hizmetler-box.index-right .d-flex.align-items-center.justify-content-between {
    margin-top: 30px;
  }

  .tumhizmetlernewtable.table-responsive th {
    align-items: center;
    vertical-align: middle;
  }

  .tumhizmetlernewtable.table-responsive td:last-child {
    border-right: 0;
  }

  .tumhizmetlernewtable.table-responsive td {
    vertical-align: middle;
    border-right: 1px solid #ddd;
  }

  .tumhizmetlernewtable.table-responsive thead {
    background: gray !important;
  }

  .tumhizmetlernewtable.table-responsive thead th {
    background: #efefef;
  }

  .tumhizmetlerimg img {
    border-radius: 8px;
  }

  .addnewhizmet a {
    white-space: nowrap;
    background: #4068e2;
    padding: 12px 20px;
    color: #fff;
    transition: all 0.3s;
    text-decoration: unset;
    border: 1px solid #5555ff;
    transition: all .3s;
    font-size: 15px;
    border-radius: 8px;
  }

  .form-group.d-flex.gap-3.hizmetler-title-right form {
    display: flex;
    vertical-align: middle;
    align-items: center;
    width: 100%;
  }

  .hizmetler-title-right-search input {
    width: 100% !important;
    background: #f1f4f9 !important;
    border: 1px solid #cdcccf !important;
    border-radius: 5px !important;
    font-size: 15px !important;
    padding: 5px 15px !important;
    position: relative;
  }

  .hizmetler-title-right-search i {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 15px;
    color: gray;
  }

  .form-group.d-flex.gap-3.hizmetler-title-right {
    width: 50%;
  }

  .form-group.d-flex.gap-3.hizmetler-title-right select {
    display: inline-block;
    width: auto;
    height: 34px;
    margin-left: 10px;
  }

  .hizmetler-title-right-search input:focus {
    border-color: #4068e2 !important;
    box-shadow: 0 0 0.25rem rgba(24, 145, 247, 0.5) !important;
    outline: none !important;
    border: 1px solid;
  }

  a.share-btn.share-svg svg {
    width: 27px;
  }

  .tooltipp {
    position: relative;
    display: inline-block;
  }

  .sorular-cevap.hizmetdetaysendbutton {
    text-align: center !important;
    display: flex;
    justify-content: center;
  }

  .tooltipp .tooltiptext {
    visibility: hidden;
    opacity: 0;
    background-color: #000;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 12px;
    position: absolute;
    z-index: 1;
    bottom: -40%;
    /* Resmin üstünde gösterilir */
    left: 145%;
    /* Tooltip'i ortalamak için */
    width: 260px;
    font-size: 13px;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    /* Tooltip'in alt kısmında üçgen ok */
    box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.3);
  }

  .tooltipp .tooltiptext::after {
    content: "";
    position: absolute;
    top: 50%;
    /* Tooltip'in altında */
    left: 0;
    margin-left: -10px;
    transform: rotate(90deg);
    border-width: 5px;
    border-style: solid;
    border-color: #000 transparent transparent transparent;
  }

  .tooltipp:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
  }

  /* Resim için hover efekti */
  .tooltipp img {
    transition: transform 0.2s ease;
  }

  .tooltipp:hover img {
    transform: scale(1.1);
  }

  .ftir-texts .d-flex {
    display: flex;
    vertical-align: middle;
    align-items: center;
    margin-bottom: 6px;
  }

  .degerlendirme-inner textarea {
    font-size: 15px;
  }

  .ftir-texts h5 {
    margin: 0;
  }

  .ftir-texts b {
    font-size: 15px;
    color: #445568;
    margin-right: 5px;
  }

  .ftir-texts h5 {
    font-weight: 400;
  }

  .ftir-texts span {
    font-weight: 400;
  }

  .firma-tab-info-left h3 {
    font-size: 15px;
    font-weight: 600;
    margin-left: 10px;
    margin-bottom: 15px;
  }

  .firma-analiz-main-title h3 {
    margin: 0 !important;
  }

  .firma-analiz-main-title {
    display: flex;
    vertical-align: middle;
    align-items: center;
    justify-content: space-between;
  }

  .firma-analiz-open-area.open {}

  .firma-analiz-open-area.open svg.faoa-down {
    display: none;
  }

  .firma-analiz-open-area.open svg.faoa-close {
    display: block;
  }

  .firma-analiz-open-area.open .d-flex.firma-analiz-title {
    display: flex !important;
  }

  .firma-analiz-open-area.open .analiz-inner {
    /* display: block !important; */
  }

  .firma-analiz.bg-white.open {}

  .firma-analiz.bg-white.open .d-flex.firma-analiz-title {
    display: flex !important;
  }

  .firma-analiz.bg-white.open .analiz-inner {
    display: block !important;
  }

  .firma-analiz.bg-white.open {}

  .firma-analiz.bg-white.open .firma-analiz-main-title {
    margin-bottom: 20px;
  }

  .firma-analiz-open-area {
    cursor: pointer;
  }

  .tum-hizmetler-inner img {
    height: 120px;
    width: 85%;
    object-fit: cover;
  }

  @media(max-width:768px) {
    div#datepickerOverlay2 {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      margin-top: 0 !important;
    }

    div#datepickerOverlay3 {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      margin-top: 0 !important;
    }

    div#datepickerOverlay4 {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      margin-top: 0 !important;
    }

    div#datepickerOverlay5 {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      margin-top: 0 !important;
    }

    div#datepickerOverlay6 {
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      margin-top: 0 !important;
    }

    .analiz-top-stats-container.d-flex {
      justify-content: space-between;
      margin-right: 20px;
      min-width: 790px;
    }

    .analiz-top-stats-container.d-flex:last-child {
      width: 100%;
      min-width: 567px;
    }

    .analiz-top-stats-container.d-flex:last-child {
      width: 100%;
    }

    .analiz-top-stats-flex {
      overflow-x: scroll;
    }

    .analiz-main-search-area ul#pills-tab {
      display: flex !important;
      flex-wrap: unset !important;
      overflow-y: scroll;
    }

    .analiz-main-search-area ul#pills-tab button {
      width: 100%;
      white-space: nowrap;
    }

    .analiz-main-search-area ul#pills-tab li {
      width: 100%;
    }

    .tumhizmetlernewtable.table-responsive {
      margin-top: -15px;
    }

    .tumhizmetlernewtable.table-responsive thead th:nth-child(2) {
      width: 114px;
    }

    .mobilehidden {
      display: none !important;
    }

    .mobileshowflex {
      display: flex !important;
    }

    .tumhizmetlernewtable.table-responsive td:nth-child(2) img {
      height: 90px;
    }

    .tumhizmetlernewtable.table-responsive td:nth-child(2) {
      width: 120px;
    }

    .tum-hizmetler-box.index-right h5 {
      /* margin-bottom: 40px; */
    }

    .tum-hizmetler-box.index-right .d-flex.align-items-center.justify-content-between {
      display: block !important;
    }

    .form-group.d-flex.gap-3.hizmetler-title-right {
      width: 100%;
      margin-top: 5px;
    }

    .tumhizmetlernewtable.table-responsive thead th:first-child {
      width: 30px;
    }

    .tumhizmetlernewtable.table-responsive td:first-child {
      width: 30px;
    }

    .tumhizmetlernewtable.table-responsive td {
      width: 120px;
    }

    .tumhizmetlernewtable.table-responsive thead th {
      width: 120px;
    }

    .tooltipp .tooltiptext {
      visibility: hidden;
      opacity: 0;
      background-color: #000;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 3px;
      position: absolute;
      z-index: 1;
      bottom: -40%;
      left: 145%;
      width: 130px;
      font-size: 11px;
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.3);
    }
  }

  div#datepickerOverlay2 {
    position: fixed;
    top: 50%;
    left: unset;
    width: 260px;
    margin-top: -65px;
  }

  div#datepickerOverlay3 {
    position: fixed;
    top: 50%;
    left: unset;
    width: 260px;
    margin-top: -65px;
  }

  div#datepickerOverlay4 {
    position: fixed;
    top: 50%;
    left: unset;
    width: 260px;
    margin-top: -65px;
  }

  div#datepickerOverlay5 {
    position: fixed;
    top: 50%;
    left: unset;
    width: 260px;
    margin-top: -65px;
  }

  div#datepickerOverlay6 {
    position: fixed;
    top: 50%;
    left: unset;
    width: 260px;
    margin-top: -65px;
  }

  .yesno-option {
    padding: 12px 20px;
    cursor: pointer;
    transition: background 0.2s;
    border-top: 1px solid #e0e0e0;
  }

  .yesno-option:hover {
    background: #f0f0f0;
  }

  .yesno-label {
    color: #666;
    opacity: 0;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: auto;
  }

  .yesno-arrow {
    margin-left: auto;
    transition: transform 0.3s;
    color: #999;
  }

  .yesno-dropdown-wrapper.is-open .yesno-arrow {
    transform: rotate(180deg);
  }

  .tumhizmetler-status-new {
    height: 33px;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@php
    $turkishMonths = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
    $currentMonth = $turkishMonths[date('n') - 1]; // Bulunduğumuz ay
    $previousMonth = $turkishMonths[date('n') - 2 < 0 ? 11 : date('n') - 2]; // Bir önceki ay
    $currentYear = date('Y'); // Bulunduğumuz yıl
    $previousYear = date('Y') - 1; // Bir önceki yıl
@endphp

@section('content')
<div class="analiz-page">
  <div class="container-fluid">
    <div class="row mb-4">
      <div class="col-12">
        <div class="analiz-title-area d-flex">
          <div class="analiz-title">
            <h1 class="mb-0">Analizler</h1>
          </div>
          <div class="analiz-date-select">
            <div class="ddropdown-container">
              <div id="ddropdownToggle" class="ddropdown-toggle">
                <span id="selectedLabel">27 Eyl – 24 Eki 2025</span>
                <span>28 Gün</span>
              </div>
              <div id="ddropdownMenu" class="ddropdown-menu">
                <div class="ddropdown-item">Bugün</div>
                <div class="ddropdown-item">7 Gün</div>
                <div class="ddropdown-item">28 Gün</div>
                <div class="ddropdown-item">90 Gün</div>
                <div class="ddropdown-item">365 Gün</div>
                <div class="ddropdown-item">{{ $currentMonth }}</div>
                <div class="ddropdown-item">{{ $previousMonth }}</div>
                <div class="ddropdown-item">{{ $currentYear }}</div>
                <div class="ddropdown-item">{{ $previousYear }}</div>
                <div class="ddropdown-item">Ömür Boyu</div>
                <div class="ddropdown-item" id="ozelOption">Özel</div>
              </div>
              <!-- Overlay tarih seçici -->
              <div id="datepickerOverlay" class="datepicker-overlay">
                <div class="date-header" id="rangeText">27 Eyl 2025 – 24 Eki 2025</div>
                <div class="date-sub" id="dayCount">28 gün seçildi</div>
                <div class="calendar" id="calendar"></div>
                <div class="date-actions">
                  <button class="btn btn-light btn-sm" id="cancelBtn">İptal</button>
                  <button class="btn btn-dark btn-sm" id="applyBtn">Uygula</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="analiz-top-stats-area">
      <div class="row">
        <div class="col-lg-12">
          <div class="analiz-top-stats-flex">
            <div class="analiz-top-stats-container d-flex">
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Toplam Hizmet </h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> {{ $servicesCount }} </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> {{ $comparisonLabel }} </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min {{ $servicesChange >= 0 ? 'green' : 'red' }}"> {{ abs($servicesChange) }}% </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Toplam Fikir </h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> {{ $ideasCount }} </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> {{ $comparisonLabel }} </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min {{ $ideasChange >= 0 ? 'green' : 'red' }}"> {{ abs($ideasChange) }}% </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Kayıtlı Firma </h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> {{ $companiesCount }} </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span>Normal</span>
                      <b>{{ $normalCompanies }}</b>
                    </div>
                    <div class="d-flex">
                      <span>Pro</span>
                      <b>{{ $proCompanies }}</b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> {{ $comparisonLabel }} </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min {{ $companiesChange >= 0 ? 'green' : 'red' }}"> {{ abs($companiesChange) }}% </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Bireysel Üye</h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> {{ $usersCount }} </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> {{ $comparisonLabel }} </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min {{ $usersChange >= 0 ? 'green' : 'red' }}"> {{ abs($usersChange) }}% </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="analiz-top-stats-container d-flex">
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Toplam Ziyaretçi </h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> {{ number_format($totalVisitors ?? 0) }} </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> {{ $comparisonLabel }} </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min {{ $visitorsChange >= 0 ? 'green' : 'red' }}"> {{ abs($visitorsChange) }}% </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Üye Olan Ziyaretçi </h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> {{ number_format($registeredMembers ?? 0) }} </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span>Bireysel</span>
                      <b>{{ number_format($individualMembers ?? 0) }}</b>
                    </div>
                    <div class="d-flex">
                      <span>Kurumsal</span>
                      <b>{{ number_format($corporateMembers ?? 0) }}</b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> {{ $comparisonLabel }} </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min {{ $registeredMembersChange >= 0 ? 'green' : 'red' }}"> {{ abs($registeredMembersChange) }}% </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="analiz-top-stats-box">
                <div class="analiz-top-stats-title">
                  <h2> Ziyaretçi</h2>
                </div>
                <div class="analiz-top-stats-results results-flex">
                  <div class="analiz-top-main-results">
                    <h3> 350 </h3>
                  </div>
                  <div class="analiz-top-min-results">
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                    <div class="d-flex">
                      <span></span>
                      <b></b>
                    </div>
                  </div>
                </div>
                <div class="analiz-top-stats-bottom">
                  <div class="d-flex">
                    <div>
                      <b> Son 7 gün </b>
                    </div>
                    <div>
                      <span class="analiz-top-stats-results-min red"> 12% </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="analiz-charts-area">
      <div class="row">
        <div class="col-lg-3">
          <div class="chart-box">
            <h4 id="chart1-title">{{ $comparisonLabel }}</h4>
            <canvas id="chart1"></canvas>
            <h3>İçerik Dağılımı</h3>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="chart-box">
            <h4 id="chart2-title">{{ $comparisonLabel }}</h4>
            <canvas id="chart2"></canvas>
            <h3>Üyelik Dağılımı</h3>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="chart-box">
            <h4 id="chart3-title">{{ $comparisonLabel }}</h4>
            <canvas id="chart3"></canvas>
            <h3>Hizmet Kategori Dağılımı</h3>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="chart-box">
            <h4 id="chart4-title">{{ $comparisonLabel }}</h4>
            <canvas id="chart4"></canvas>
            <h3>Fikirt Kategori Dağılımı</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="analiz-main-search-area">
      <div class="row">
        <div class="col-lg-12">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Hizmetler</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Fikirler</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Firmalar</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill" data-bs-target="#pills-contact2" type="button" role="tab" aria-controls="pills-contact2" aria-selected="false">Bireysel Üye</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact-tab3" data-bs-toggle="pill" data-bs-target="#pills-contact3" type="button" role="tab" aria-controls="pills-contact3" aria-selected="false">Slaytlar</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
              <form id="services-filter-form" method="GET" action="{{ route('admin.analytics.index') }}">
              <div class="analiz-main-search-area-top">
                <div class="input-search-box search-area-top-input">
                  <input type="text" name="search" id="services-search" placeholder="Hizmet Adı" value="{{ request('search') }}">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="category_id" id="services-category-id" value="{{ request('category_id') }}">
                    <div class="analizsearch-toggle" data-dropdown="dropdown1">
                      @if(request('category_id') && $categories->where('id', request('category_id'))->first())
                        {{ $categories->where('id', request('category_id'))->first()->name }}
                      @else
                        Kategori
                      @endif
                    </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown1">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      @foreach($categories as $category)
                        <div class="analizsearch-item" data-value="{{ $category->id }}">{{ $category->name }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="sub_category_id" id="services-sub-category-id" value="{{ request('sub_category_id') }}">
                    <div class="analizsearch-toggle" data-dropdown="dropdown2"> Alt Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown2">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      {{-- Sub categories will be loaded dynamically via JavaScript --}}
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="date-select-container">
                    <input type="hidden" name="service_start_date" id="services-start-date" value="{{ request('service_start_date') }}">
                    <input type="hidden" name="service_end_date" id="services-end-date" value="{{ request('service_end_date') }}">
                    <div class="select-date">
                      <span>Tarih Aralığı</span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                        <path fill="#292929" d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6zm7 6q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4 0q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m8 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4 0q-.425 0-.712-.288T7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18m8 0q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18" />
                      </svg>
                    </div>
                    <!-- Overlay tarih seçici -->
                    <div id="datepickerOverlay2" class="datepicker-overlay">
                      <div class="date-header" id="rangeText2">27 Eyl 2025 – 24 Eki 2025</div>
                      <div class="date-sub" id="dayCount2">28 gün seçildi</div>
                      <div class="calendar" id="calendar2"></div>
                      <div class="date-actions">
                        <button class="btn btn-light btn-sm" id="cancelBtn2">İptal</button>
                        <button class="btn btn-dark btn-sm" id="applyBtn2">Uygula</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input min-max-inputs">
                  <span> Görüntülenme </span>
                  <div class="min-max-inputs-area d-flex">
                    <input type="text" name="view_min" id="services-views-min" class="format-number" placeholder="Min" value="{{ request('view_min') }}">
                    <span> - </span>
                    <input type="text" name="view_max" id="services-views-max" class="format-number" placeholder="Max" value="{{ request('view_max') }}">
                  </div>
                </div>
                <div class="search-area-top-input min-max-inputs">
                  <span> Kaydetme </span>
                  <div class="min-max-inputs-area d-flex">
                    <input type="text" name="save_min" id="services-saves-min" class="format-number" placeholder="Min" value="{{ request('save_min') }}">
                    <span> - </span>
                    <input type="text" name="save_max" id="services-saves-max" class="format-number" placeholder="Max" value="{{ request('save_max') }}">
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="province_id" id="services-province-id" value="{{ request('province_id') }}">
                    <div class="analizsearch-toggle" data-dropdown="dropdown3">
                      @if(request('province_id') && $provinces->where('id', request('province_id'))->first())
                        {{ $provinces->where('id', request('province_id'))->first()->name }}
                      @else
                        İl
                      @endif
                    </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown3">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      @foreach($provinces as $province)
                        <div class="analizsearch-item" data-value="{{ $province->id }}">{{ $province->name }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="district_id" id="services-district-id" value="{{ request('district_id') }}">
                    <div class="analizsearch-toggle" data-dropdown="dropdown4">
                      @if(request('district_id') && isset($districts) && $districts->where('id', request('district_id'))->first())
                        {{ $districts->where('id', request('district_id'))->first()->name }}
                      @else
                        İlçe
                      @endif
                    </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown4">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      {{-- Districts will be loaded dynamically via JavaScript --}}
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="status" id="services-status" value="{{ request('status') }}">
                    <div class="analizsearch-toggle" data-dropdown="dropdown5">
                      @if(request('status') === '1')
                        Aktif
                      @elseif(request('status') === '0')
                        Pasif
                      @else
                        Durum
                      @endif
                    </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown5">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      <div class="analizsearch-item" data-value="1">Aktif</div>
                      <div class="analizsearch-item" data-value="0">Pasif</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-last-buttons">
                  <button type="submit" id="services-filter-btn"> Filtrele </button>
                  <button type="button" id="services-clear-btn"> Temizle </button>
                </div>
              </div>
              </form>
              <div class="search-results-text mb-2 mt-2">
                <h4> Filtrelemenize uygun <b>{{ $services->total() }}</b> hizmet bulundu. </h4>
              </div>
              <div class="tum-hizmetler-inner thi-new mt-3">
                <div class="tumhizmetlernewtable table-responsive">
                  <div class="table-wrapper">
                    <!-- Table Header -->
                    <div class="table-header">
                      <div class="header-table-container" id="headerTableContainer" style="transform: translateX(0px);">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  ID
                                  @if($sortField === 'id')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">Görsel</th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => $sortField === 'title' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Başlık Açıklama
                                  @if($sortField === 'title')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => $sortField === 'category' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Kategori
                                  @if($sortField === 'category')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'sub_category', 'direction' => $sortField === 'sub_category' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Alt Kategori
                                  @if($sortField === 'sub_category')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'views_count', 'direction' => $sortField === 'views_count' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Görüntülenme
                                  @if($sortField === 'views_count')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'saved_services_count', 'direction' => $sortField === 'saved_services_count' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Kaydetme
                                  @if($sortField === 'saved_services_count')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'province', 'direction' => $sortField === 'province' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  İl
                                  @if($sortField === 'province')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'district', 'direction' => $sortField === 'district' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  İlçe
                                  @if($sortField === 'district')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Durum
                                  @if($sortField === 'status')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => $sortField === 'created_at' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                  Oluşturulma Tarihi
                                  @if($sortField === 'created_at')
                                    <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                  @else
                                    <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                  @endif
                                </a>
                              </th>
                              <th scope="col">İşlemler</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                    <!-- Header altındaki scroll alanı -->
                    <div class="header-scroll" id="headerScroll">
                      <div class="header-scroll-content" id="scrollContent" style="width: 1873px;"></div>
                    </div>
                    <!-- Table Body -->
                    <div class="table-body" id="tableBody">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                ID
                                @if($sortField === 'id')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">Görsel</th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => $sortField === 'title' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Başlık Açıklama
                                @if($sortField === 'title')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => $sortField === 'category' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Kategori
                                @if($sortField === 'category')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'sub_category', 'direction' => $sortField === 'sub_category' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Alt Kategori
                                @if($sortField === 'sub_category')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'views_count', 'direction' => $sortField === 'views_count' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Görüntülenme
                                @if($sortField === 'views_count')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'saved_services_count', 'direction' => $sortField === 'saved_services_count' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Kaydetme
                                @if($sortField === 'saved_services_count')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'province', 'direction' => $sortField === 'province' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                İl
                                @if($sortField === 'province')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'district', 'direction' => $sortField === 'district' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                İlçe
                                @if($sortField === 'district')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Durum
                                @if($sortField === 'status')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">
                              <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => $sortField === 'created_at' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}" class="sortable-header">
                                Oluşturulma Tarihi
                                @if($sortField === 'created_at')
                                  <i class="fa-solid fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}" style="color: #007bff; margin-left: 5px;"></i>
                                @else
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                @endif
                              </a>
                            </th>
                            <th scope="col">İşlemler</th>
                          </tr>
                        </thead>
                        <tbody id="services-table-body">
                          @forelse($services as $service)
                          <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                @php
                                  $serviceImage = $service->cover_photo ?? ($service->photos->first()->path ?? null);
                                @endphp
                                <img src="{{ $serviceImage ? asset($serviceImage) : asset('site/images/default-service.jpg') }}" alt="{{ $service->title }}">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>{{ Str::limit($service->title, 50) }}</h2>
                                <h3>{{ $service->company->name ?? '-' }}</h3>
                              </div>
                            </td>
                            <td>{{ $service->category->name ?? '-' }}</td>
                            <td>{{ $service->subCategory->name ?? '-' }}</td>
                            <td>{{ number_format($service->views_count) }}</td>
                            <td>{{ number_format($service->saved_services_count) }}</td>
                            <td>{{ $service->province->name ?? '-' }}</td>
                            <td>{{ $service->district->name ?? '-' }}</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" data-service-id="{{ $service->id }}">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator {{ $service->status == 1 ? 'is-active' : 'is-inactive' }}">
                                        <span class="status-symbol">{{ $service->status == 1 ? '✓' : '⊖' }}</span>
                                        <span>{{ $service->status == 1 ? 'Aktif' : 'Pasif' }}</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="1">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="0">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span>{{ $service->created_at->locale('tr')->translatedFormat('d M Y') }}</span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="{{ route('admin.services.edit', $service->id) }}" target="_blank">
                                    <i class="fa-solid fa-pen" style="color: white !important;"></i>
                                  </a>
                                </div>
                              </div>
                            </td>
                          </tr>
                          @empty
                          <tr>
                            <td colspan="12" class="text-center py-4">
                              <p class="text-muted">Henüz hizmet bulunmamaktadır.</p>
                            </td>
                          </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tumhizmetlerpagination mt-3" id="pagination-container">
                  {{ $services->links() }}
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
              <form id="ideas-filter-form">
              <div class="analiz-main-search-area-top">
                <div class="input-search-box search-area-top-input">
                  <input type="text" name="search" id="ideas-search" placeholder="Fikir Adı">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="category_id" id="ideas-category-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown7"> Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown7">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      @foreach($categories as $category)
                        <div class="analizsearch-item" data-value="{{ $category->id }}">{{ $category->name }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="sub_category_id" id="ideas-sub-category-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown8"> Alt Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown8">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="date-select-container-3 date-select-container">
                    <input type="hidden" name="start_date" id="ideas-start-date">
                    <input type="hidden" name="end_date" id="ideas-end-date">
                    <div class="select-date-3 select-date">
                      <span>Tarih Seç</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                      <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                      <path fill="#292929" d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6zm7 6q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4 0q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m8 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4 0q-.425 0-.712-.288T7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18m8 0q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18"></path>
                    </svg>
                    <div id="datepickerOverlay3" class="datepicker-overlay">
                      <div class="date-header" id="rangeText3">27 Eyl 2025 – 24 Eki 2025</div>
                      <div class="date-sub" id="dayCount3">28 gün seçildi</div>
                      <div class="calendar" id="calendar3"></div>
                      <div class="date-actions">
                        <button class="btn btn-light btn-sm" id="cancelBtn3">İptal</button>
                        <button class="btn btn-dark btn-sm" id="applyBtn3">Uygula</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input min-max-inputs">
                  <span> Görüntülenme </span>
                  <div class="min-max-inputs-area d-flex">
                    <input type="text" name="view_min" id="ideas-views-min" class="format-number" placeholder="Min">
                    <span> - </span>
                    <input type="text" name="view_max" id="ideas-views-max" class="format-number" placeholder="Max">
                  </div>
                </div>
                <div class="search-area-top-input min-max-inputs">
                  <span> Beğeni </span>
                  <div class="min-max-inputs-area d-flex">
                    <input type="text" name="like_min" id="ideas-likes-min" class="format-number" placeholder="Min">
                    <span> - </span>
                    <input type="text" name="like_max" id="ideas-likes-max" class="format-number" placeholder="Max">
                  </div>
                </div>
                <div class="search-area-top-input min-max-inputs">
                  <span> Yorum </span>
                  <div class="min-max-inputs-area d-flex">
                    <input type="text" name="reply_min" id="ideas-replies-min" class="format-number" placeholder="Min">
                    <span> - </span>
                    <input type="text" name="reply_max" id="ideas-replies-max" class="format-number" placeholder="Max">
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="status" id="ideas-status">
                    <div class="analizsearch-toggle" data-dropdown="dropdown11"> Durum </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown11">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      <div class="analizsearch-item" data-value="1">Aktif</div>
                      <div class="analizsearch-item" data-value="0">Pasif</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-last-buttons">
                  <button type="button" id="ideas-filter-btn"> Filtrele </button>
                  <button type="button" id="ideas-clear-btn"> Temizle </button>
                </div>
              </div>
              </form>
              <div class="search-results-text mb-2 mt-2">
                <h4 id="ideas-result-text"> Filtrelemenize uygun <b>0</b> fikir bulundu. </h4>
              </div>
              <div class="tum-hizmetler-inner thi-new mt-3">
                <div class="tumhizmetlernewtable table-responsive">
                  <div class="table-wrapper">
                    <!-- Table Header -->
                    <div class="table-header">
                      <div class="header-table-container" id="headerTableContainer" style="transform: translateX(0px);">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="id">
                                  ID
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">Görsel</th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="title">
                                  Açıklama
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="category">
                                  Kategori
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="sub_category">
                                  Alt Kategori
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="views_count">
                                  Görüntülenme
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="likes_count">
                                  Beğeni
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="replies_count">
                                  Yorum
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="status">
                                  Durum
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="created_at">
                                  Oluşturulma Tarihi
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">İşlemler</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                    <!-- Header altındaki scroll alanı -->
                    <div class="header-scroll" id="headerScroll">
                      <div class="header-scroll-content" id="scrollContent" style="width: 1873px;"></div>
                    </div>
                    <!-- Table Body -->
                    <div class="table-body" id="tableBody">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="id">
                                ID
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">Görsel</th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="title">
                                Açıklama
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="category">
                                Kategori
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="sub_category">
                                Alt Kategori
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="views_count">
                                Görüntülenme
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="likes_count">
                                Beğeni
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="replies_count">
                                Yorum
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="status">
                                Durum
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header ideas-sortable" data-sort="created_at">
                                Oluşturulma Tarihi
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">İşlemler</th>
                          </tr>
                        </thead>
                        <tbody id="services-table-body">
                          <tr>
                            <td>1</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı 4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>İnşaat</td>
                            <td>Prefabrik Ev</td>
                            <td>1.000</td>
                            <td>2.000</td>
                            <td>2.000</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" id="statusDropdown3">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator is-active">
                                        <span class="status-symbol">✓</span>
                                        <span>Aktif</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="active">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="inactive">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="yesno-container">
                                <div class="yesno-dropdown-wrapper" id="yesnoDropdown3">
                                  <div class="yesno-dropdown-btn">
                                    <span class="yesno-badge is-yes">
                                      <span class="yesno-icon">👍</span>
                                      <span>Evet</span>
                                    </span>
                                  </div>
                                  <div class="yesno-dropdown-menu">
                                    <div class="yesno-option" data-value="yes">
                                      <span class="yesno-badge is-yes">
                                        <span class="yesno-icon">👍</span>
                                        <span>Evet</span>
                                      </span>
                                    </div>
                                    <div class="yesno-option" data-value="no">
                                      <span class="yesno-badge is-no">
                                        <span class="yesno-icon">👎</span>
                                        <span>Hayır</span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>İnşaat</td>
                            <td>Prefabrik Ev</td>
                            <td>1.000</td>
                            <td>2.000</td>
                            <td>2.000</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" id="statusDropdown4">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator is-inactive">
                                        <span class="status-symbol">⊖</span>
                                        <span>Pasif</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="active">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="inactive">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="yesno-container">
                                <div class="yesno-dropdown-wrapper" id="yesnoDropdown4">
                                  <div class="yesno-dropdown-btn">
                                    <span class="yesno-badge is-no">
                                      <span class="yesno-icon">👎</span>
                                      <span>Hayır</span>
                                    </span>
                                  </div>
                                  <div class="yesno-dropdown-menu">
                                    <div class="yesno-option" data-value="yes">
                                      <span class="yesno-badge is-yes">
                                        <span class="yesno-icon">👍</span>
                                        <span>Evet</span>
                                      </span>
                                    </div>
                                    <div class="yesno-option" data-value="no">
                                      <span class="yesno-badge is-no">
                                        <span class="yesno-icon">👎</span>
                                        <span>Hayır</span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tumhizmetlerpagination mt-3" id="pagination-container">
                  <nav class="d-flex justify-items-center justify-content-between">
                    <div class="d-flex justify-content-between flex-fill d-sm-none">
                      <ul class="pagination">
                        <li class="page-item disabled" aria-disabled="true">
                          <span class="page-link">« Önceki</span>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next">Sonraki »</a>
                        </li>
                      </ul>
                    </div>
                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                      <div>
                        <ul class="pagination">
                          <li class="page-item disabled" aria-disabled="true" aria-label="« Önceki">
                            <span class="page-link" aria-hidden="true">‹</span>
                          </li>
                          <li class="page-item active" aria-current="page">
                            <span class="page-link">1</span>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2">2</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next" aria-label="Sonraki »">›</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
              <form id="companies-filter-form">
              <div class="analiz-main-search-area-top">
                <div class="input-search-box search-area-top-input">
                  <input type="text" name="search" id="companies-search" placeholder="Firma Adı">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="category_id" id="companies-category-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown12"> Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown12">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      @foreach($categories as $category)
                        <div class="analizsearch-item" data-value="{{ $category->id }}">{{ $category->name }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="sub_category_id" id="companies-sub-category-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown13"> Alt Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown13">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="date-select-container-4 date-select-container">
                    <input type="hidden" name="start_date" id="companies-start-date">
                    <input type="hidden" name="end_date" id="companies-end-date">
                    <div class="select-date-4 select-date">
                      <span>Tarih Seç</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                      <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                      <path fill="#292929" d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6zm7 6q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4 0q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m8 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4 0q-.425 0-.712-.288T7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18m8 0q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18"></path>
                    </svg>
                    <div id="datepickerOverlay4" class="datepicker-overlay">
                      <div class="date-header" id="rangeText4">27 Eyl 2025 – 24 Eki 2025</div>
                      <div class="date-sub" id="dayCount4">28 gün seçildi</div>
                      <div class="calendar" id="calendar4"></div>
                      <div class="date-actions">
                        <button class="btn btn-light btn-sm" id="cancelBtn4">İptal</button>
                        <button class="btn btn-dark btn-sm" id="applyBtn4">Uygula</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input min-max-inputs">
                  <span> Görüntülenme </span>
                  <div class="min-max-inputs-area d-flex">
                    <input type="text" name="view_min" id="companies-min-views" class="format-number" placeholder="Min">
                    <span> - </span>
                    <input type="text" name="view_max" id="companies-max-views" class="format-number" placeholder="Max">
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="province_id" id="companies-province-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown15"> İl </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown15">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      @foreach($provinces as $province)
                        <div class="analizsearch-item" data-value="{{ $province->id }}">{{ $province->name }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="district_id" id="companies-district-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown16"> İlçe </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown16">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="status" id="companies-status">
                    <div class="analizsearch-toggle" data-dropdown="dropdown14"> Durum </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown14">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      <div class="analizsearch-item" data-value="1">Aktif</div>
                      <div class="analizsearch-item" data-value="0">Pasif</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="is_pro" id="companies-is-pro">
                    <div class="analizsearch-toggle" data-dropdown="dropdown17"> Pro Üyelik </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown17">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      <div class="analizsearch-item" data-value="1">Evet</div>
                      <div class="analizsearch-item" data-value="0">Hayır</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-last-buttons">
                  <button type="button" id="companies-filter-btn"> Filtrele </button>
                  <button type="button" id="companies-clear-btn"> Temizle </button>
                </div>
              </div>
              </form>
              <div class="search-results-text mb-2 mt-2">
                <h4 id="companies-result-text"> Filtrelemenize uygun <b>0</b> firma bulundu. </h4>
              </div>
              <div class="tum-hizmetler-inner thi-new mt-3">
                <div class="tumhizmetlernewtable table-responsive">
                  <div class="table-wrapper">
                    <!-- Table Header -->
                    <div class="table-header">
                      <div class="header-table-container" id="headerTableContainer" style="transform: translateX(0px);">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="id">
                                  ID
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">Görsel</th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="name">
                                  Firma Adı
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="category">
                                  Kategori
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="sub_category">
                                  Alt Kategori
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="views_count">
                                  Görüntülenme
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="services_count">
                                  Hizmet Sayısı
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="province">
                                  İl
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="district">
                                  İlçe
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">Paket Türü</th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="status">
                                  Durum
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="created_at">
                                  Oluşturulma Tarihi
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">İşlemler</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                    <!-- Header altındaki scroll alanı -->
                    <div class="header-scroll" id="headerScroll">
                      <div class="header-scroll-content" id="scrollContent" style="width: 1873px;"></div>
                    </div>
                    <!-- Table Body -->
                    <div class="table-body" id="tableBody">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="id">
                                ID
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">Görsel</th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="name">
                                Firma Adı
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="category">
                                Kategori
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="sub_category">
                                Alt Kategori
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="views_count">
                                Görüntülenme
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="services_count">
                                Hizmet Sayısı
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="province">
                                İl
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="district">
                                İlçe
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">Paket Türü</th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="status">
                                Durum
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header companies-sortable" data-sort="created_at">
                                Oluşturulma Tarihi
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">İşlemler</th>
                          </tr>
                        </thead>
                        <tbody id="services-table-body">
                          <tr>
                            <td>1</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı 4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>İnşaat</td>
                            <td>Prefabrik Ev</td>
                            <td> 5 </td>
                            <td>1.000</td>
                            <td>2.000</td>
                            <td>2.000</td>
                            <td>Aksaray</td>
                            <td>Ortaköy</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" id="statusDropdown5">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator is-active">
                                        <span class="status-symbol">✓</span>
                                        <span>Aktif</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="active">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="inactive">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="yesno-container">
                                <div class="yesno-dropdown-wrapper" id="yesnoDropdown5">
                                  <div class="yesno-dropdown-btn">
                                    <span class="yesno-badge is-yes">
                                      <span class="yesno-icon">👍</span>
                                      <span>Evet</span>
                                    </span>
                                  </div>
                                  <div class="yesno-dropdown-menu">
                                    <div class="yesno-option" data-value="yes">
                                      <span class="yesno-badge is-yes">
                                        <span class="yesno-icon">👍</span>
                                        <span>Evet</span>
                                      </span>
                                    </div>
                                    <div class="yesno-option" data-value="no">
                                      <span class="yesno-badge is-no">
                                        <span class="yesno-icon">👎</span>
                                        <span>Hayır</span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>İnşaat</td>
                            <td>Prefabrik Ev</td>
                            <td> 5 </td>
                            <td>1.000</td>
                            <td>2.000</td>
                            <td>2.000</td>
                            <td>Aksaray</td>
                            <td>Ortaköy</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" id="statusDropdown6">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator is-inactive">
                                        <span class="status-symbol">⊖</span>
                                        <span>Pasif</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="active">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="inactive">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="yesno-container">
                                <div class="yesno-dropdown-wrapper" id="yesnoDropdown6">
                                  <div class="yesno-dropdown-btn">
                                    <span class="yesno-badge is-no">
                                      <span class="yesno-icon">👎</span>
                                      <span>Hayır</span>
                                    </span>
                                  </div>
                                  <div class="yesno-dropdown-menu">
                                    <div class="yesno-option" data-value="yes">
                                      <span class="yesno-badge is-yes">
                                        <span class="yesno-icon">👍</span>
                                        <span>Evet</span>
                                      </span>
                                    </div>
                                    <div class="yesno-option" data-value="no">
                                      <span class="yesno-badge is-no">
                                        <span class="yesno-icon">👎</span>
                                        <span>Hayır</span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tumhizmetlerpagination mt-3" id="pagination-container">
                  <nav class="d-flex justify-items-center justify-content-between">
                    <div class="d-flex justify-content-between flex-fill d-sm-none">
                      <ul class="pagination">
                        <li class="page-item disabled" aria-disabled="true">
                          <span class="page-link">« Önceki</span>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next">Sonraki »</a>
                        </li>
                      </ul>
                    </div>
                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                      <div>
                        <ul class="pagination">
                          <li class="page-item disabled" aria-disabled="true" aria-label="« Önceki">
                            <span class="page-link" aria-hidden="true">‹</span>
                          </li>
                          <li class="page-item active" aria-current="page">
                            <span class="page-link">1</span>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2">2</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next" aria-label="Sonraki »">›</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-contact2" role="tabpanel" aria-labelledby="pills-contact-tab2" tabindex="0">
              <form id="users-filter-form">
              <div class="analiz-main-search-area-top">
                <div class="input-search-box search-area-top-input">
                  <input type="text" name="search" id="users-search" placeholder="Üye Adı">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="category_id" id="users-category-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown20"> Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown20">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      @foreach($categories as $category)
                        <div class="analizsearch-item" data-value="{{ $category->id }}">{{ $category->name }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="sub_category_id" id="users-sub-category-id">
                    <div class="analizsearch-toggle" data-dropdown="dropdown21"> Alt Kategori </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown21">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="date-select-container-5 date-select-container">
                    <input type="hidden" name="start_date" id="users-start-date">
                    <input type="hidden" name="end_date" id="users-end-date">
                    <div class="select-date-5 select-date">
                      <span>Tarih Seç</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                      <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                      <path fill="#292929" d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6zm7 6q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4 0q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m8 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4 0q-.425 0-.712-.288T7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18m8 0q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18"></path>
                    </svg>
                    <div id="datepickerOverlay5" class="datepicker-overlay">
                      <div class="date-header" id="rangeText5">27 Eyl 2025 – 24 Eki 2025</div>
                      <div class="date-sub" id="dayCount5">28 gün seçildi</div>
                      <div class="calendar" id="calendar5"></div>
                      <div class="date-actions">
                        <button class="btn btn-light btn-sm" id="cancelBtn5">İptal</button>
                        <button class="btn btn-dark btn-sm" id="applyBtn5">Uygula</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="status" id="users-status">
                    <div class="analizsearch-toggle" data-dropdown="dropdown22"> Durum </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown22">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      <div class="analizsearch-item" data-value="1">Aktif</div>
                      <div class="analizsearch-item" data-value="0">Pasif</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-last-buttons">
                  <button type="button" id="users-filter-btn"> Filtrele </button>
                  <button type="button" id="users-clear-btn"> Temizle </button>
                </div>
              </div>
              </form>
              <div class="search-results-text mb-2 mt-2">
                <h4 id="users-result-text"> Filtrelemenize uygun <b>0</b> üye bulundu. </h4>
              </div>
              <div class="tum-hizmetler-inner thi-new mt-3">
                <div class="tumhizmetlernewtable table-responsive">
                  <div class="table-wrapper">
                    <!-- Table Header -->
                    <div class="table-header">
                      <div class="header-table-container" id="headerTableContainer" style="transform: translateX(0px);">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="id">
                                  ID
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">Profil</th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="name">
                                  Üye Adı
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="category">
                                  Kategori
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="sub_category">
                                  Alt Kategori
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="ideas_count">
                                  Fikir Sayısı
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="status">
                                  Durum
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">
                                <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="created_at">
                                  Oluşturulma Tarihi
                                  <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                                </a>
                              </th>
                              <th scope="col">İşlemler</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                    <!-- Header altındaki scroll alanı -->
                    <div class="header-scroll" id="headerScroll">
                      <div class="header-scroll-content" id="scrollContent" style="width: 1873px;"></div>
                    </div>
                    <!-- Table Body -->
                    <div class="table-body" id="tableBody">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="id">
                                ID
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">Profil</th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="name">
                                Üye Adı
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="category">
                                Kategori
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="sub_category">
                                Alt Kategori
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="ideas_count">
                                Fikir Sayısı
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="status">
                                Durum
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">
                              <a href="javascript:void(0)" class="sortable-header users-sortable" data-sort="created_at">
                                Oluşturulma Tarihi
                                <i class="fa-solid fa-sort" style="opacity: 0.4; margin-left: 5px;"></i>
                              </a>
                            </th>
                            <th scope="col">İşlemler</th>
                          </tr>
                        </thead>
                        <tbody id="services-table-body">
                          <tr>
                            <td>1</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı 4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>İnşaat</td>
                            <td>Prefabrik Ev</td>
                            <td>5</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" id="statusDropdown7">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator is-active">
                                        <span class="status-symbol">✓</span>
                                        <span>Aktif</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="active">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="inactive">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="yesno-container">
                                <div class="yesno-dropdown-wrapper" id="yesnoDropdown7">
                                  <div class="yesno-dropdown-btn">
                                    <span class="yesno-badge is-yes">
                                      <span class="yesno-icon">👍</span>
                                      <span>Evet</span>
                                    </span>
                                  </div>
                                  <div class="yesno-dropdown-menu">
                                    <div class="yesno-option" data-value="yes">
                                      <span class="yesno-badge is-yes">
                                        <span class="yesno-icon">👍</span>
                                        <span>Evet</span>
                                      </span>
                                    </div>
                                    <div class="yesno-option" data-value="no">
                                      <span class="yesno-badge is-no">
                                        <span class="yesno-icon">👎</span>
                                        <span>Hayır</span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>İnşaat</td>
                            <td>Prefabrik Ev</td>
                            <td>5</td>
                            <td>
                              <div class="tumhizmetler-status-new">
                                <div class="status-container">
                                  <div class="status-dropdown-wrapper" id="statusDropdown8">
                                    <div class="status-dropdown-btn">
                                      <span class="status-indicator is-inactive">
                                        <span class="status-symbol">⊖</span>
                                        <span>Pasif</span>
                                      </span>
                                    </div>
                                    <div class="status-dropdown-menu">
                                      <div class="status-option" data-status="active">
                                        <span class="status-indicator is-active">
                                          <span class="status-symbol">✓</span>
                                          <span>Aktif</span>
                                        </span>
                                      </div>
                                      <div class="status-option" data-status="inactive">
                                        <span class="status-indicator is-inactive">
                                          <span class="status-symbol">⊖</span>
                                          <span>Pasif</span>
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="yesno-container">
                                <div class="yesno-dropdown-wrapper" id="yesnoDropdown8">
                                  <div class="yesno-dropdown-btn">
                                    <span class="yesno-badge is-no">
                                      <span class="yesno-icon">👎</span>
                                      <span>Hayır</span>
                                    </span>
                                  </div>
                                  <div class="yesno-dropdown-menu">
                                    <div class="yesno-option" data-value="yes">
                                      <span class="yesno-badge is-yes">
                                        <span class="yesno-icon">👍</span>
                                        <span>Evet</span>
                                      </span>
                                    </div>
                                    <div class="yesno-option" data-value="no">
                                      <span class="yesno-badge is-no">
                                        <span class="yesno-icon">👎</span>
                                        <span>Hayır</span>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tumhizmetlerpagination mt-3" id="pagination-container">
                  <nav class="d-flex justify-items-center justify-content-between">
                    <div class="d-flex justify-content-between flex-fill d-sm-none">
                      <ul class="pagination">
                        <li class="page-item disabled" aria-disabled="true">
                          <span class="page-link">« Önceki</span>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next">Sonraki »</a>
                        </li>
                      </ul>
                    </div>
                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                      <div>
                        <ul class="pagination">
                          <li class="page-item disabled" aria-disabled="true" aria-label="« Önceki">
                            <span class="page-link" aria-hidden="true">‹</span>
                          </li>
                          <li class="page-item active" aria-current="page">
                            <span class="page-link">1</span>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2">2</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next" aria-label="Sonraki »">›</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-contact3" role="tabpanel" aria-labelledby="pills-contact-tab3" tabindex="0">
              <form id="sliders-filter-form">
              <div class="analiz-main-search-area-top">
                <div class="input-search-box search-area-top-input">
                  <input type="text" name="search" id="sliders-search" placeholder="Slayt Başlık">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="search-area-top-input">
                  <div class="date-select-container-6 date-select-container">
                    <input type="hidden" name="start_date" id="sliders-start-date">
                    <input type="hidden" name="end_date" id="sliders-end-date">
                    <div class="select-date-6 select-date">
                      <span>Tarih Seç</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                      <!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE -->
                      <path fill="#292929" d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6zm7 6q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m-4 0q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m8 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14m-4 4q-.425 0-.712-.288T11 17t.288-.712T12 16t.713.288T13 17t-.288.713T12 18m-4 0q-.425 0-.712-.288T7 17t.288-.712T8 16t.713.288T9 17t-.288.713T8 18m8 0q-.425 0-.712-.288T15 17t.288-.712T16 16t.713.288T17 17t-.288.713T16 18"></path>
                    </svg>
                    <div id="datepickerOverlay6" class="datepicker-overlay">
                      <div class="date-header" id="rangeText6">27 Eyl 2025 – 24 Eki 2025</div>
                      <div class="date-sub" id="dayCount6">28 gün seçildi</div>
                      <div class="calendar" id="calendar6"></div>
                      <div class="date-actions">
                        <button class="btn btn-light btn-sm" id="cancelBtn6">İptal</button>
                        <button class="btn btn-dark btn-sm" id="applyBtn6">Uygula</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="search-area-top-input">
                  <div class="analizsearch-container">
                    <input type="hidden" name="status" id="sliders-status">
                    <div class="analizsearch-toggle" data-dropdown="dropdown25"> Durum </div>
                    <div class="analizsearch-menu" data-dropdown-menu="dropdown25">
                      <div class="analizsearch-item" data-value="">Tümü</div>
                      <div class="analizsearch-item" data-value="1">Aktif</div>
                      <div class="analizsearch-item" data-value="0">Pasif</div>
                    </div>
                  </div>
                </div>
                <div class="search-area-last-buttons">
                  <button type="button" id="sliders-filter-btn"> Filtrele </button>
                  <button type="button" id="sliders-clear-btn"> Temizle </button>
                </div>
              </div>
              </form>
              <div class="search-results-text mb-2 mt-2">
                <h4 id="sliders-result-text"> Filtrelemenize uygun <b>0</b> slayt bulundu. </h4>
              </div>
              <div class="tum-hizmetler-inner thi-new mt-3">
                <div class="tumhizmetlernewtable table-responsive">
                  <div class="table-wrapper">
                    <!-- Table Header -->
                    <div class="table-header">
                      <div class="header-table-container" id="headerTableContainer" style="transform: translateX(0px);">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Slayt</th>
                              <th scope="col">Başlık</th>
                              <th scope="col">Görüntülenme </th>
                              <th scope="col">Tıklanma</th>
                              <th scope="col">Oluşturulma Tarihi</th>
                              <th scope="col">İşlemler</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                    <!-- Header altındaki scroll alanı -->
                    <div class="header-scroll" id="headerScroll">
                      <div class="header-scroll-content" id="scrollContent" style="width: 1873px;"></div>
                    </div>
                    <!-- Table Body -->
                    <div class="table-body" id="tableBody">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Slayt</th>
                            <th scope="col">Başlık</th>
                            <th scope="col">Görüntülenme </th>
                            <th scope="col">Tıklanma</th>
                            <th scope="col">Oluşturulma Tarihi</th>
                            <th scope="col">İşlemler</th>
                          </tr>
                        </thead>
                        <tbody id="services-table-body">
                          <tr>
                            <td>1</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı 4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe3D Tasarım / Dış Cephe 3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>5</td>
                            <td>1.000</td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>
                              <div class="tumhizmetlerimg">
                                <img src="https://demo.evhayaliniz.com/site/images/services/1759229755_68dbb73b546a9.webp" alt="4+1 Müstakil Ev Planı">
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-name">
                                <h2>4+1 Müstakil Ev Planı</h2>
                                <h3>3D Tasarım / Dış Cephe</h3>
                              </div>
                            </td>
                            <td>5</td>
                            <td>1.000</td>
                            <td>
                              <div class="olusturulma-tarihi">
                                <span> 4 Mar 2030 </span>
                              </div>
                            </td>
                            <td>
                              <div class="tumhizmetler-islemler">
                                <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                                  <span class="tooltiptext">Düzenle</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/edit">
                                    <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox status inactive tooltipp tooltipp2">
                                  <span class="tooltiptext">Pasif Et</span>
                                  <a href="https://www.demo.evhayaliniz.com/company/services/125/status">
                                    <i class="fa-solid fa-eye-slash" style="color: white !important;"></i>
                                  </a>
                                </div>
                                <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
                                  <span class="tooltiptext">Sil</span>
                                  <form action="https://www.demo.evhayaliniz.com/company/services/125" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="llcnPoK78pBEHIrSrhU7e8jpDcNtnAIFRvYWu0sC" autocomplete="off">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                                      <i class="fa-solid fa-trash" style="color: white !important;"></i>
                                    </a>
                                  </form>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tumhizmetlerpagination mt-3" id="pagination-container">
                  <nav class="d-flex justify-items-center justify-content-between">
                    <div class="d-flex justify-content-between flex-fill d-sm-none">
                      <ul class="pagination">
                        <li class="page-item disabled" aria-disabled="true">
                          <span class="page-link">« Önceki</span>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next">Sonraki »</a>
                        </li>
                      </ul>
                    </div>
                    <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                      <div>
                        <ul class="pagination">
                          <li class="page-item disabled" aria-disabled="true" aria-label="« Önceki">
                            <span class="page-link" aria-hidden="true">‹</span>
                          </li>
                          <li class="page-item active" aria-current="page">
                            <span class="page-link">1</span>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2">2</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="https://www.demo.evhayaliniz.com/company/services?page=2" rel="next" aria-label="Sonraki »">›</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> @endsection @section('js')
  <!-- Ek JavaScript gerekirse buraya ekleyin -->
  <script>
    document.querySelectorAll('.format-number').forEach(input => {
      input.addEventListener('input', function(e) {
        let value = this.value.replace(/[^\d,]/g, '');
        // Virgülden önceki kısmı formatla
        let parts = value.split(',');
        if (parts[0]) {
          parts[0] = parseInt(parts[0]).toLocaleString('tr-TR');
        }
        this.value = parts.join(',');
      });
    });
    document.addEventListener('DOMContentLoaded', function() {
      const toggles = document.querySelectorAll('.analizsearch-toggle');
      // Dropdown toggle'a tıklanınca
      toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
          e.stopPropagation();
          const dropdownId = this.getAttribute('data-dropdown');
          const menu = document.querySelector(`[data-dropdown-menu="${dropdownId}"]`);
          // Diğer açık dropdownları kapat
          document.querySelectorAll('.analizsearch-menu').forEach(m => {
            if (m !== menu) {
              m.classList.remove('show');
            }
          });
          document.querySelectorAll('.analizsearch-toggle').forEach(t => {
            if (t !== this) {
              t.classList.remove('active');
            }
          });
          // Mevcut dropdown'u aç/kapat
          if (!menu.classList.contains('show')) {
            // Pozisyon hesapla
            const rect = this.getBoundingClientRect();
            menu.style.position = 'fixed';
            menu.style.top = rect.bottom + 5 + 'px';
            menu.style.left = rect.left + 'px';
            menu.style.width = rect.width + 'px';
            menu.classList.add('show');
            this.classList.add('active');
          } else {
            menu.classList.remove('show');
            this.classList.remove('active');
          }
        });
      });
      // Dropdown item seçimi
      document.querySelectorAll('.analizsearch-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.stopPropagation();
          const text = this.textContent;
          const menu = this.closest('.analizsearch-menu');
          const dropdownId = menu.getAttribute('data-dropdown-menu');
          const toggle = document.querySelector(`[data-dropdown="${dropdownId}"]`);
          // Seçilen değeri güncelle
          toggle.textContent = text;
          // Dropdown'u kapat
          menu.classList.remove('show');
          toggle.classList.remove('active');
        });
      });
      // Dışarı tıklanınca tüm dropdownları kapat
      document.addEventListener('click', function() {
        document.querySelectorAll('.analizsearch-menu').forEach(menu => {
          menu.classList.remove('show');
        });
        document.querySelectorAll('.analizsearch-toggle').forEach(toggle => {
          toggle.classList.remove('active');
        });
      });
      // Scroll olunca dropdown pozisyonunu güncelle
      window.addEventListener('scroll', function() {
        document.querySelectorAll('.analizsearch-menu.show').forEach(menu => {
          const dropdownId = menu.getAttribute('data-dropdown-menu');
          const toggle = document.querySelector(`[data-dropdown="${dropdownId}"]`);
          if (toggle) {
            const rect = toggle.getBoundingClientRect();
            menu.style.top = rect.bottom + 5 + 'px';
            menu.style.left = rect.left + 'px';
            menu.style.width = rect.width + 'px';
          }
        });
      }, true);
    });
    const initializedDropdowns = new Set();

    function addGlobalDropdownCloseHandler() {
      if (addGlobalDropdownCloseHandler.added) return;
      addGlobalDropdownCloseHandler.added = true;
      const closeAllDropdowns = (e) => {
        if (!e.target.closest('.status-dropdown-wrapper') && !e.target.closest('.yesno-dropdown-wrapper')) {
          document.querySelectorAll('.status-dropdown-wrapper.is-open, .yesno-dropdown-wrapper.is-open').forEach((d) => d.classList.remove('is-open'));
        }
      };
      document.addEventListener('click', closeAllDropdowns);
      document.addEventListener('touchstart', closeAllDropdowns);
    }
    // ============== STATUS DROPDOWN ==============
    function initDropdown(dropdownId) {
      if (initializedDropdowns.has(dropdownId)) return;
      const dropdown = document.getElementById(dropdownId);
      if (!dropdown) {
        console.warn('Dropdown bulunamadı:', dropdownId);
        return;
      }
      const header = dropdown.querySelector('.status-dropdown-btn');
      const items = dropdown.querySelectorAll('.status-option');
      const badge = header.querySelector('.status-indicator');
      if (!header || !badge || items.length === 0) {
        console.error('Dropdown elementleri eksik:', dropdownId);
        return;
      }
      const toggleDropdown = (e) => {
        e.preventDefault();
        e.stopPropagation();
        // Diğer dropdownları kapat
        document.querySelectorAll('.status-dropdown-wrapper.is-open, .yesno-dropdown-wrapper.is-open').forEach((d) => {
          if (d.id !== dropdownId) d.classList.remove('is-open');
        });
        dropdown.classList.toggle('is-open');
      };
      header.addEventListener('click', toggleDropdown);
      header.addEventListener('touchstart', toggleDropdown, {
        passive: false
      });
      items.forEach((item) => {
        const selectItem = (e) => {
          e.preventDefault();
          e.stopPropagation();
          const status = item.dataset.status;
          const selectedBadge = item.querySelector('.status-indicator').cloneNode(true);
          badge.className = selectedBadge.className;
          badge.innerHTML = selectedBadge.innerHTML;
          dropdown.classList.remove('is-open');
        };
        item.addEventListener('click', selectItem);
        item.addEventListener('touchstart', selectItem, {
          passive: false
        });
      });
      initializedDropdowns.add(dropdownId);
    }
    // ============== YESNO DROPDOWN ==============
    function initYesNoDropdown(dropdownId) {
      if (initializedDropdowns.has(dropdownId)) return;
      const dropdown = document.getElementById(dropdownId);
      if (!dropdown) {
        console.warn('YesNo dropdown bulunamadı:', dropdownId);
        return;
      }
      const header = dropdown.querySelector('.yesno-dropdown-btn');
      const items = dropdown.querySelectorAll('.yesno-option');
      const badge = header.querySelector('.yesno-badge');
      if (!header || !badge || items.length === 0) {
        console.error('YesNo dropdown elementleri eksik:', dropdownId);
        return;
      }
      const toggleDropdown = (e) => {
        e.preventDefault();
        e.stopPropagation();
        // Diğer dropdownları kapat
        document.querySelectorAll('.status-dropdown-wrapper.is-open, .yesno-dropdown-wrapper.is-open').forEach((d) => {
          if (d.id !== dropdownId) d.classList.remove('is-open');
        });
        dropdown.classList.toggle('is-open');
      };
      header.addEventListener('click', toggleDropdown);
      header.addEventListener('touchstart', toggleDropdown, {
        passive: false
      });
      items.forEach((item) => {
        const selectItem = (e) => {
          e.preventDefault();
          e.stopPropagation();
          const value = item.dataset.value;
          const selectedBadge = item.querySelector('.yesno-badge').cloneNode(true);
          badge.className = selectedBadge.className;
          badge.innerHTML = selectedBadge.innerHTML;
          dropdown.classList.remove('is-open');
        };
        item.addEventListener('click', selectItem);
        item.addEventListener('touchstart', selectItem, {
          passive: false
        });
      });
      initializedDropdowns.add(dropdownId);
    }
    // ============== INIT FUNCTIONS ==============
    function initAllDropdowns() {
      document.querySelectorAll('.status-dropdown-wrapper[id^="statusDropdown"]').forEach((dropdown) => {
        if (dropdown.id && !initializedDropdowns.has(dropdown.id)) {
          initDropdown(dropdown.id);
        }
      });
      document.querySelectorAll('.yesno-dropdown-wrapper[id^="yesnoDropdown"]').forEach((dropdown) => {
        if (dropdown.id && !initializedDropdowns.has(dropdown.id)) {
          initYesNoDropdown(dropdown.id);
        }
      });
      initAnalyticsDropdowns();
      addGlobalDropdownCloseHandler();
    }

    // Analytics dropdown'ları için event handler
    let analyticsDropdownsInitialized = false;
    function initAnalyticsDropdowns() {
      if (analyticsDropdownsInitialized) return; // Sadece bir kez çalıştır

      // Event delegation ile tüm dropdown'ları yönet
      document.body.addEventListener('click', function(e) {
        // Toggle click
        if (e.target.classList.contains('analizsearch-toggle') || e.target.closest('.analizsearch-toggle')) {
          e.stopPropagation();
          const toggle = e.target.classList.contains('analizsearch-toggle') ? e.target : e.target.closest('.analizsearch-toggle');
          const container = toggle.closest('.analizsearch-container');
          const menu = container.querySelector('.analizsearch-menu');

          if (!menu) return;

          const isOpen = menu.classList.contains('show');

          // Tüm menüleri kapat
          document.querySelectorAll('.analizsearch-menu').forEach(m => m.classList.remove('show'));

          // Bu menüyü aç/kapat
          if (!isOpen) {
            menu.classList.add('show');
          }
          return;
        }

        // Item click
        if (e.target.classList.contains('analizsearch-item') || e.target.closest('.analizsearch-item')) {
          e.stopPropagation();
          const item = e.target.classList.contains('analizsearch-item') ? e.target : e.target.closest('.analizsearch-item');
          const container = item.closest('.analizsearch-container');
          const hiddenInput = container.querySelector('input[type="hidden"]');
          const toggle = container.querySelector('.analizsearch-toggle');
          const menu = container.querySelector('.analizsearch-menu');

          const value = item.getAttribute('data-value');
          const text = item.textContent.trim();

          // Hidden input'a değeri yaz
          if (hiddenInput) {
            hiddenInput.value = value;
          }

          // Toggle text'i güncelle
          if (toggle) {
            toggle.textContent = text;
          }

          // Menüyü kapat
          if (menu) {
            menu.classList.remove('show');
          }
          return;
        }

        // Dışarı tıklanınca menüleri kapat
        if (!e.target.closest('.analizsearch-container')) {
          document.querySelectorAll('.analizsearch-menu').forEach(menu => {
            menu.classList.remove('show');
          });
        }
      });

      analyticsDropdownsInitialized = true;
    }
    // Sayfa yüklendiğinde veya tab değişiminde çağırabilirsin
    initAllDropdowns();
    // Bootstrap tab değişim eventi
    document.addEventListener('DOMContentLoaded', function() {
      // İlk yükleme
      initAllDropdowns();
      // Bootstrap tab eventlerini dinle
      const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
      tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function() {
          // Tab değiştiğinde yeni dropdown'ları initialize et
          setTimeout(() => {
            initAllDropdowns();
          }, 100);
        });
      });
    });
    // Sayfa zaten yüklüyse hemen çalıştır
    if (document.readyState !== 'loading') {
      initAllDropdowns();
    }
    const getChartTextColor = () => {
      return document.documentElement.classList.contains('dark-style') ? '#ffffff' : '#000000';
    };
    const getGridColor = () => {
      return document.documentElement.classList.contains('dark-style') ? '#444444' : '#dddddd';
    };
    const getCommonOptions = () => ({
      responsive: true,
      plugins: {
        legend: {
          labels: {
            color: getChartTextColor(),
            usePointStyle: true,
            boxWidth: 8
          },
        },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            color: getChartTextColor()
          },
          grid: {
            color: getGridColor()
          }
        },
        x: {
          ticks: {
            color: getChartTextColor(),
            font: {
              size: 10
            }
          },
          grid: {
            color: getGridColor()
          }
        }
      }
    });
    // Backend'den gelen veriler
    const initialServiceCategories = @json($topServiceCategories->map(function($item) {
        return ['name' => $item->category->name ?? 'Bilinmiyor', 'total' => $item->total];
    }));
    const initialIdeaCategories = @json($topIdeaCategories->map(function($item) {
        return ['name' => $item->category->name ?? 'Bilinmiyor', 'total' => $item->total];
    }));

    // Backend'den gelen chart verileri
    const initialChartLabels = @json($chartLabels ?? []);
    const initialServicesData = @json($servicesDailyData ?? []);
    const initialIdeasData = @json($ideasDailyData ?? []);
    const initialUsersData = @json($usersDailyData ?? []);
    const initialCompaniesData = @json($companiesDailyData ?? []);

    const chart3 = new Chart(document.getElementById('chart3'), {
      type: 'bar',
      data: {
        labels: initialServiceCategories.map(c => c.name),
        datasets: [{
          label: 'Hizmet Sayısı',
          data: initialServiceCategories.map(c => c.total),
          backgroundColor: '#ff7c43',
          borderRadius: 4,
          barThickness: 20
        }]
      },
      options: getCommonOptions()
    });
    const chart4 = new Chart(document.getElementById('chart4'), {
      type: 'bar',
      data: {
        labels: initialIdeaCategories.map(c => c.name),
        datasets: [{
          label: 'Fikir Sayısı',
          data: initialIdeaCategories.map(c => c.total),
          backgroundColor: '#ff7c43',
          borderRadius: 4,
          barThickness: 20
        }]
      },
      options: getCommonOptions()
    });
    const chart1 = new Chart(document.getElementById('chart1'), {
      type: 'line',
      data: {
        labels: initialChartLabels,
        datasets: [{
          label: 'Hizmetler',
          data: initialServicesData,
          borderColor: '#f4a62a',
          backgroundColor: '#f4a62a',
          tension: 0.4,
          fill: false,
          pointRadius: 4,
          pointBackgroundColor: '#f4a62a'
        }, {
          label: 'Fikirler',
          data: initialIdeasData,
          borderColor: '#36a2eb',
          backgroundColor: '#36a2eb',
          tension: 0.4,
          fill: false,
          pointRadius: 4,
          pointBackgroundColor: '#36a2eb'
        }]
      },
      options: getCommonOptions()
    });
    const chart2 = new Chart(document.getElementById('chart2'), {
      type: 'line',
      data: {
        labels: initialChartLabels,
        datasets: [{
          label: 'Bireysel',
          data: initialUsersData,
          borderColor: '#f4a62a',
          backgroundColor: '#f4a62a',
          tension: 0.4,
          fill: false,
          pointRadius: 4,
          pointBackgroundColor: '#f4a62a'
        }, {
          label: 'Kurumsal',
          data: initialCompaniesData,
          borderColor: '#36a2eb',
          backgroundColor: '#36a2eb',
          tension: 0.4,
          fill: false,
          pointRadius: 4,
          pointBackgroundColor: '#36a2eb'
        }]
      },
      options: getCommonOptions()
    });
    const observer = new MutationObserver(() => {
      [chart1, chart2, chart3, chart4].forEach(chart => {
        chart.options = getCommonOptions();
        chart.update();
      });
    });
    observer.observe(document.documentElement, {
      attributes: true,
      attributeFilter: ['class']
    });
    // calendar and dropdown
    const dropdownToggle = document.getElementById('ddropdownToggle');
    const dropdownMenu = document.getElementById('ddropdownMenu');
    const ozelOption = document.getElementById('ozelOption');
    const datepickerOverlay = document.getElementById('datepickerOverlay');
    // Tüm picker overlay'leri
    const datepickerOverlay2 = document.getElementById('datepickerOverlay2');
    const datepickerOverlay3 = document.getElementById('datepickerOverlay3');
    const datepickerOverlay4 = document.getElementById('datepickerOverlay4');
    const datepickerOverlay5 = document.getElementById('datepickerOverlay5');
    const datepickerOverlay6 = document.getElementById('datepickerOverlay6');
    const rangeText = document.getElementById('rangeText');
    const dayCount = document.getElementById('dayCount');
    const applyBtn = document.getElementById('applyBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    // Picker 2 elementleri
    const rangeText2 = document.getElementById('rangeText2');
    const dayCount2 = document.getElementById('dayCount2');
    const applyBtn2 = document.getElementById('applyBtn2');
    const cancelBtn2 = document.getElementById('cancelBtn2');
    // Picker 3 elementleri
    const rangeText3 = document.getElementById('rangeText3');
    const dayCount3 = document.getElementById('dayCount3');
    const applyBtn3 = document.getElementById('applyBtn3');
    const cancelBtn3 = document.getElementById('cancelBtn3');
    // Picker 4 elementleri
    const rangeText4 = document.getElementById('rangeText4');
    const dayCount4 = document.getElementById('dayCount4');
    const applyBtn4 = document.getElementById('applyBtn4');
    const cancelBtn4 = document.getElementById('cancelBtn4');
    // Picker 5 elementleri
    const rangeText5 = document.getElementById('rangeText5');
    const dayCount5 = document.getElementById('dayCount5');
    const applyBtn5 = document.getElementById('applyBtn5');
    const cancelBtn5 = document.getElementById('cancelBtn5');
    // Picker 6 elementleri
    const rangeText6 = document.getElementById('rangeText6');
    const dayCount6 = document.getElementById('dayCount6');
    const applyBtn6 = document.getElementById('applyBtn6');
    const cancelBtn6 = document.getElementById('cancelBtn6');
    const selectedLabel = document.getElementById('selectedLabel');
    const selectDateDiv = document.querySelector('.select-date');
    const selectDateInnerSpan = selectDateDiv ? selectDateDiv.querySelector('span') : null;
    // Trigger divleri (HTML'de class="select-date-3" gibi olacak)
    const selectDateDiv3 = document.querySelector('.select-date-3');
    const selectDateInnerSpan3 = selectDateDiv3 ? selectDateDiv3.querySelector('span') : null;
    const selectDateDiv4 = document.querySelector('.select-date-4');
    const selectDateInnerSpan4 = selectDateDiv4 ? selectDateDiv4.querySelector('span') : null;
    const selectDateDiv5 = document.querySelector('.select-date-5');
    const selectDateInnerSpan5 = selectDateDiv5 ? selectDateDiv5.querySelector('span') : null;
    const selectDateDiv6 = document.querySelector('.select-date-6');
    const selectDateInnerSpan6 = selectDateDiv6 ? selectDateDiv6.querySelector('span') : null;
    // Her picker için ayrı state
    let startDate = null;
    let endDate = null;
    let startDate2 = null;
    let endDate2 = null;
    let startDate3 = null;
    let endDate3 = null;
    let startDate4 = null;
    let endDate4 = null;
    let startDate5 = null;
    let endDate5 = null;
    let startDate6 = null;
    let endDate6 = null;
    // Dropdown toggle
    dropdownToggle.addEventListener('click', () => {
      dropdownMenu.classList.toggle('show');
      datepickerOverlay.classList.remove('show');
    });
    // Özel → dropdown kapanır, tarih overlay açılır
    ozelOption.addEventListener('click', () => {
      dropdownMenu.classList.remove('show');
      datepickerOverlay.classList.add('show');
    });
    // .select-date tıklanınca picker 2 açılır (Services tab)
    if (selectDateDiv) {
      selectDateDiv.addEventListener('click', () => {
        // Eğer daha önce tarih seçilmişse, o aya git ve seçili tarihleri göster
        if (startDate2 && endDate2) {
          currentYear2 = startDate2.getFullYear();
          currentMonth2 = startDate2.getMonth();
          buildCalendar2('calendar2', currentYear2, currentMonth2);
          setTimeout(() => markRange2(), 10);
        }
        if (datepickerOverlay2) datepickerOverlay2.classList.toggle('show');
        dropdownMenu.classList.remove('show');
      });
    }
    // .select-date-3 tıklanınca picker 3 açılır (Ideas tab)
    if (selectDateDiv3) {
      selectDateDiv3.addEventListener('click', () => {
        // Eğer daha önce tarih seçilmişse, o aya git ve seçili tarihleri göster
        if (startDate3 && endDate3) {
          currentYear3 = startDate3.getFullYear();
          currentMonth3 = startDate3.getMonth();
          buildCalendar3('calendar3', currentYear3, currentMonth3);
          setTimeout(() => markRange3(), 10);
        }
        if (datepickerOverlay3) datepickerOverlay3.classList.toggle('show');
        dropdownMenu.classList.remove('show');
      });
    }
    // .select-date-4 tıklanınca picker 4 açılır (Companies tab)
    if (selectDateDiv4) {
      selectDateDiv4.addEventListener('click', () => {
        // Eğer daha önce tarih seçilmişse, o aya git ve seçili tarihleri göster
        if (startDate4 && endDate4) {
          currentYear4 = startDate4.getFullYear();
          currentMonth4 = startDate4.getMonth();
          buildCalendar4('calendar4', currentYear4, currentMonth4);
          setTimeout(() => markRange4(), 10);
        }
        if (datepickerOverlay4) datepickerOverlay4.classList.toggle('show');
        dropdownMenu.classList.remove('show');
      });
    }
    // .select-date-5 tıklanınca picker 5 açılır (Users tab)
    if (selectDateDiv5) {
      selectDateDiv5.addEventListener('click', () => {
        // Eğer daha önce tarih seçilmişse, o aya git ve seçili tarihleri göster
        if (startDate5 && endDate5) {
          currentYear5 = startDate5.getFullYear();
          currentMonth5 = startDate5.getMonth();
          buildCalendar5('calendar5', currentYear5, currentMonth5);
          setTimeout(() => markRange5(), 10);
        }
        if (datepickerOverlay5) datepickerOverlay5.classList.toggle('show');
        dropdownMenu.classList.remove('show');
      });
    }
    // .select-date-6 tıklanınca picker 6 açılır (Sliders tab)
    if (selectDateDiv6) {
      selectDateDiv6.addEventListener('click', () => {
        // Eğer daha önce tarih seçilmişse, o aya git ve seçili tarihleri göster
        if (startDate6 && endDate6) {
          currentYear6 = startDate6.getFullYear();
          currentMonth6 = startDate6.getMonth();
          buildCalendar6('calendar6', currentYear6, currentMonth6);
          setTimeout(() => markRange6(), 10);
        }
        if (datepickerOverlay6) datepickerOverlay6.classList.toggle('show');
        dropdownMenu.classList.remove('show');
      });
    }
    // Diğer dropdown item'lar
    document.querySelectorAll('.ddropdown-item:not(#ozelOption)').forEach(item => {
      item.addEventListener('click', () => {
        const text = item.textContent.trim();
        const smallSpan = dropdownToggle.querySelector('span:last-child');
        if (smallSpan) smallSpan.textContent = text;
        const stripTime = d => new Date(d.getFullYear(), d.getMonth(), d.getDate());
        const formatRange = (s, e) => s && e ? `${formatDate(s)} – ${formatDate(e)}` : '';
        const now = new Date();
        let start = null;
        let end = null;
        const lower = text.toLowerCase();
        if (lower === 'bugün') {
          start = end = stripTime(now);
        }
        const dayMatch = lower.match(/^(\d+)\s*gün$/);
        if (dayMatch) {
          const n = parseInt(dayMatch[1], 10);
          end = stripTime(now);
          start = new Date(end);
          start.setDate(end.getDate() - (n - 1));
        }
        const yearMatch = lower.match(/^(\d{4})$/);
        if (yearMatch) {
          const y = parseInt(yearMatch[1], 10);
          start = new Date(y, 0, 1);
          end = new Date(y, 11, 31);
        }
        const monthMap = {
          'ocak': 0,
          'şub': 1,
          'şubat': 1,
          'mar': 2,
          'mart': 2,
          'nis': 3,
          'nisan': 3,
          'may': 4,
          'mayıs': 4,
          'haz': 5,
          'haziran': 5,
          'tem': 6,
          'temmuz': 6,
          'ağu': 7,
          'ağustos': 7,
          'ağ': 7,
          'eyl': 8,
          'eylül': 8,
          'ekim': 9,
          'kas': 10,
          'kasım': 10,
          'ara': 11,
          'aralık': 11
        };
        for (const k of Object.keys(monthMap)) {
          if (lower.indexOf(k) !== -1) {
            const monthIndex = monthMap[k];
            const year = now.getFullYear();
            start = new Date(year, monthIndex, 1);
            end = new Date(year, monthIndex + 1, 0);
            break;
          }
        }
        if (lower === 'ömür boyu' || lower === 'ömürboyu') {
          selectedLabel.textContent = 'Tüm Zamanlar';
          dropdownMenu.classList.remove('show');
          // AJAX call for lifetime
          updateAnalytics({ period: 'lifetime' });
          return;
        }
        if (start && end) {
          selectedLabel.textContent = formatRange(start, end);
          // AJAX call with date range
          updateAnalytics({
            start_date: start.toISOString().split('T')[0],
            end_date: end.toISOString().split('T')[0]
          });
        } else {
          selectedLabel.textContent = text;
          // AJAX call with period
          const periodMap = {
            'bugün': 'today',
            '7 gün': '7',
            '28 gün': '28',
            '90 gün': '90',
            '365 gün': '365'
          };
          const period = periodMap[lower] || '28';
          updateAnalytics({ period: period });
        }
        dropdownMenu.classList.remove('show');
      });
    });
    // İptal butonları
    cancelBtn.addEventListener('click', () => {
      datepickerOverlay.classList.remove('show');
      dropdownMenu.classList.add('show');
    });
    if (cancelBtn2) {
      cancelBtn2.addEventListener('click', () => {
        if (datepickerOverlay2) datepickerOverlay2.classList.remove('show');
      });
    }
    if (cancelBtn3) {
      cancelBtn3.addEventListener('click', () => {
        if (datepickerOverlay3) datepickerOverlay3.classList.remove('show');
      });
    }
    if (cancelBtn4) {
      cancelBtn4.addEventListener('click', () => {
        if (datepickerOverlay4) datepickerOverlay4.classList.remove('show');
      });
    }
    if (cancelBtn5) {
      cancelBtn5.addEventListener('click', () => {
        if (datepickerOverlay5) datepickerOverlay5.classList.remove('show');
      });
    }
    if (cancelBtn6) {
      cancelBtn6.addEventListener('click', () => {
        if (datepickerOverlay6) datepickerOverlay6.classList.remove('show');
      });
    }
    // AJAX function to update analytics
    function updateAnalytics(params) {
      fetch('{{ route('admin.analytics.data') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(params)
      })
      .then(response => response.json())
      .then(data => {
        // İstatistik kartlarını güncelle
        updateStatCards(data.stats, data.comparisonLabel);
        // Grafikleri güncelle
        updateCharts(data.charts, data.comparisonLabel);
      })
      .catch(error => {
        console.error('Analytics update error:', error);
      });
    }

    // İstatistik kartlarını güncelleme
    function updateStatCards(stats, comparisonLabel) {
      // İlk Container - Hizmet/Fikir/Firma/Üye
      const firstContainer = document.querySelectorAll('.analiz-top-stats-container')[0];

      // Toplam Hizmet
      const serviceBox = firstContainer.querySelector('.analiz-top-stats-box:nth-child(1)');
      serviceBox.querySelector('.analiz-top-main-results h3').textContent = stats.services.count.toLocaleString();
      serviceBox.querySelector('.analiz-top-stats-bottom b').textContent = comparisonLabel;
      const serviceChange = serviceBox.querySelector('.analiz-top-stats-results-min');
      serviceChange.textContent = Math.round(Math.abs(stats.services.change)) + '%';
      serviceChange.className = 'analiz-top-stats-results-min ' + (stats.services.change >= 0 ? 'green' : 'red');

      // Toplam Fikir
      const ideaBox = firstContainer.querySelector('.analiz-top-stats-box:nth-child(2)');
      ideaBox.querySelector('.analiz-top-main-results h3').textContent = stats.ideas.count.toLocaleString();
      ideaBox.querySelector('.analiz-top-stats-bottom b').textContent = comparisonLabel;
      const ideaChange = ideaBox.querySelector('.analiz-top-stats-results-min');
      ideaChange.textContent = Math.round(Math.abs(stats.ideas.change)) + '%';
      ideaChange.className = 'analiz-top-stats-results-min ' + (stats.ideas.change >= 0 ? 'green' : 'red');

      // Kayıtlı Firma
      const companyBox = firstContainer.querySelector('.analiz-top-stats-box:nth-child(3)');
      companyBox.querySelector('.analiz-top-main-results h3').textContent = stats.companies.count.toLocaleString();
      const normalSpan = companyBox.querySelectorAll('.analiz-top-min-results .d-flex b')[0];
      const proSpan = companyBox.querySelectorAll('.analiz-top-min-results .d-flex b')[1];
      normalSpan.textContent = stats.companies.normal.toLocaleString();
      proSpan.textContent = stats.companies.pro.toLocaleString();
      companyBox.querySelector('.analiz-top-stats-bottom b').textContent = comparisonLabel;
      const companyChange = companyBox.querySelector('.analiz-top-stats-results-min');
      companyChange.textContent = Math.round(Math.abs(stats.companies.change)) + '%';
      companyChange.className = 'analiz-top-stats-results-min ' + (stats.companies.change >= 0 ? 'green' : 'red');

      // Bireysel Üye
      const userBox = firstContainer.querySelector('.analiz-top-stats-box:nth-child(4)');
      userBox.querySelector('.analiz-top-main-results h3').textContent = stats.users.count.toLocaleString();
      userBox.querySelector('.analiz-top-stats-bottom b').textContent = comparisonLabel;
      const userChange = userBox.querySelector('.analiz-top-stats-results-min');
      userChange.textContent = Math.round(Math.abs(stats.users.change)) + '%';
      userChange.className = 'analiz-top-stats-results-min ' + (stats.users.change >= 0 ? 'green' : 'red');

      // İkinci Container - Ziyaretçi Bilgileri
      if (stats.visitors && stats.registeredMembers) {
        const secondContainer = document.querySelectorAll('.analiz-top-stats-container')[1];

        // Toplam Ziyaretçi
        const visitorBox = secondContainer.querySelector('.analiz-top-stats-box:nth-child(1)');
        visitorBox.querySelector('.analiz-top-main-results h3').textContent = stats.visitors.total.toLocaleString();
        visitorBox.querySelector('.analiz-top-stats-bottom b').textContent = comparisonLabel;
        const visitorChange = visitorBox.querySelector('.analiz-top-stats-results-min');
        visitorChange.textContent = Math.round(Math.abs(stats.visitors.change)) + '%';
        visitorChange.className = 'analiz-top-stats-results-min ' + (stats.visitors.change >= 0 ? 'green' : 'red');

        // Üye Olan Ziyaretçi
        const memberBox = secondContainer.querySelector('.analiz-top-stats-box:nth-child(2)');
        memberBox.querySelector('.analiz-top-main-results h3').textContent = stats.registeredMembers.total.toLocaleString();
        const individualSpan = memberBox.querySelectorAll('.analiz-top-min-results .d-flex b')[0];
        const corporateSpan = memberBox.querySelectorAll('.analiz-top-min-results .d-flex b')[1];
        individualSpan.textContent = stats.registeredMembers.individual.toLocaleString();
        corporateSpan.textContent = stats.registeredMembers.corporate.toLocaleString();
        memberBox.querySelector('.analiz-top-stats-bottom b').textContent = comparisonLabel;
        const memberChange = memberBox.querySelector('.analiz-top-stats-results-min');
        memberChange.textContent = Math.round(Math.abs(stats.registeredMembers.change)) + '%';
        memberChange.className = 'analiz-top-stats-results-min ' + (stats.registeredMembers.change >= 0 ? 'green' : 'red');
      }
    }

    // Grafikleri güncelleme
    function updateCharts(chartData, comparisonLabel) {
      // Chart başlıklarını güncelle
      document.getElementById('chart1-title').textContent = comparisonLabel;
      document.getElementById('chart2-title').textContent = comparisonLabel;
      document.getElementById('chart3-title').textContent = comparisonLabel;
      document.getElementById('chart4-title').textContent = comparisonLabel;

      // Chart 1 - İçerik Dağılımı (Line)
      chart1.data.labels = chartData.labels;
      chart1.data.datasets[0].data = chartData.services;
      chart1.data.datasets[1].data = chartData.ideas;
      chart1.update();

      // Chart 2 - Üyelik Dağılımı (Line)
      chart2.data.labels = chartData.labels;
      chart2.data.datasets[0].data = chartData.users;
      chart2.data.datasets[1].data = chartData.companies;
      chart2.update();

      // Chart 3 - Hizmet Kategori Dağılımı (Bar)
      if (chartData.serviceCategories && chartData.serviceCategories.length > 0) {
        chart3.data.labels = chartData.serviceCategories.map(c => c.name);
        chart3.data.datasets[0].data = chartData.serviceCategories.map(c => c.total);
        chart3.update();
      }

      // Chart 4 - Fikir Kategori Dağılımı (Bar)
      if (chartData.ideaCategories && chartData.ideaCategories.length > 0) {
        chart4.data.labels = chartData.ideaCategories.map(c => c.name);
        chart4.data.datasets[0].data = chartData.ideaCategories.map(c => c.total);
        chart4.update();
      }
    }

    // Uygula butonları
    applyBtn.addEventListener('click', () => {
      if (startDate && endDate) {
        const diff = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        selectedLabel.textContent = `${formatDate(startDate)} – ${formatDate(endDate)}`;
        dropdownToggle.querySelector('span:last-child').textContent = `${diff} Gün`;

        // AJAX call
        updateAnalytics({
          start_date: startDate.toISOString().split('T')[0],
          end_date: endDate.toISOString().split('T')[0]
        });
      }
      dropdownMenu.classList.remove('show');
      datepickerOverlay.classList.remove('show');
    });
    if (applyBtn2) {
      applyBtn2.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (startDate2 && endDate2) {
          if (selectDateInnerSpan) {
            selectDateInnerSpan.textContent = `${formatDate(startDate2)} – ${formatDate(endDate2)}`;
          }
          // Services tab: Gizli input'lara tarihleri yaz
          const startInput = document.getElementById('services-start-date');
          const endInput = document.getElementById('services-end-date');
          if (startInput) startInput.value = startDate2.toISOString().split('T')[0];
          if (endInput) endInput.value = endDate2.toISOString().split('T')[0];
        }
        if (datepickerOverlay2) datepickerOverlay2.classList.remove('show');
      });
    }
    if (applyBtn3) {
      applyBtn3.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (startDate3 && endDate3) {
          if (selectDateInnerSpan3) {
            selectDateInnerSpan3.textContent = `${formatDate(startDate3)} – ${formatDate(endDate3)}`;
          }
          // Ideas tab: Gizli input'lara tarihleri yaz
          const startInput = document.getElementById('ideas-start-date');
          const endInput = document.getElementById('ideas-end-date');
          if (startInput) startInput.value = startDate3.toISOString().split('T')[0];
          if (endInput) endInput.value = endDate3.toISOString().split('T')[0];
        }
        if (datepickerOverlay3) datepickerOverlay3.classList.remove('show');
      });
    }
    if (applyBtn4) {
      applyBtn4.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (startDate4 && endDate4) {
          if (selectDateInnerSpan4) {
            selectDateInnerSpan4.textContent = `${formatDate(startDate4)} – ${formatDate(endDate4)}`;
          }
          // Companies tab: Gizli input'lara tarihleri yaz
          const startInput = document.getElementById('companies-start-date');
          const endInput = document.getElementById('companies-end-date');
          if (startInput) startInput.value = startDate4.toISOString().split('T')[0];
          if (endInput) endInput.value = endDate4.toISOString().split('T')[0];
        }
        if (datepickerOverlay4) datepickerOverlay4.classList.remove('show');
      });
    }
    if (applyBtn5) {
      applyBtn5.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (startDate5 && endDate5) {
          if (selectDateInnerSpan5) {
            selectDateInnerSpan5.textContent = `${formatDate(startDate5)} – ${formatDate(endDate5)}`;
          }
          // Users tab: Gizli input'lara tarihleri yaz
          const startInput = document.getElementById('users-start-date');
          const endInput = document.getElementById('users-end-date');
          if (startInput) startInput.value = startDate5.toISOString().split('T')[0];
          if (endInput) endInput.value = endDate5.toISOString().split('T')[0];
        }
        if (datepickerOverlay5) datepickerOverlay5.classList.remove('show');
      });
    }
    if (applyBtn6) {
      applyBtn6.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (startDate6 && endDate6) {
          if (selectDateInnerSpan6) {
            selectDateInnerSpan6.textContent = `${formatDate(startDate6)} – ${formatDate(endDate6)}`;
          }
          // Sliders tab: Gizli input'lara tarihleri yaz
          const startInput = document.getElementById('sliders-start-date');
          const endInput = document.getElementById('sliders-end-date');
          if (startInput) startInput.value = startDate6.toISOString().split('T')[0];
          if (endInput) endInput.value = endDate6.toISOString().split('T')[0];
        }
        if (datepickerOverlay6) datepickerOverlay6.classList.remove('show');
      });
    }
    // Dışarı tıklama
    document.addEventListener('click', e => {
      // Tüm picker elementlerini ve trigger'larını kontrol et
      const isInsidePicker = e.target.closest('.ddropdown-container') || e.target.closest('.date-select-container') || e.target.closest('.date-select-container-3') || e.target.closest('.date-select-container-4') || e.target.closest('.date-select-container-5') || e.target.closest('.date-select-container-6') || e.target.closest('.select-date') || e.target.closest('.select-date-3') || e.target.closest('.select-date-4') || e.target.closest('.select-date-5') || e.target.closest('.select-date-6') || e.target.closest('#datepickerOverlay') || e.target.closest('#datepickerOverlay2') || e.target.closest('#datepickerOverlay3') || e.target.closest('#datepickerOverlay4') || e.target.closest('#datepickerOverlay5') || e.target.closest('#datepickerOverlay6');
      if (!isInsidePicker) {
        dropdownMenu.classList.remove('show');
        datepickerOverlay.classList.remove('show');
        if (datepickerOverlay2) datepickerOverlay2.classList.remove('show');
        if (datepickerOverlay3) datepickerOverlay3.classList.remove('show');
        if (datepickerOverlay4) datepickerOverlay4.classList.remove('show');
        if (datepickerOverlay5) datepickerOverlay5.classList.remove('show');
        if (datepickerOverlay6) datepickerOverlay6.classList.remove('show');
      }
    });
    // --- Takvim fonksiyonları ---
    function buildCalendar(container, year, month) {
      const cal = document.getElementById(container);
      cal.innerHTML = `
    
																																																												
																																																												<div class='calendar-title'>${getMonthName(month)} ${year}</div>
																																																												<div class='days'></div>`;
      const grid = cal.querySelector('.days');
      const headers = ['P', 'S', 'Ç', 'P', 'C', 'C', 'P'];
      headers.forEach(h => {
        const d = document.createElement('div');
        d.className = 'day header';
        d.textContent = h;
        grid.appendChild(d);
      });
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const e = document.createElement('div');
        grid.appendChild(e);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = d;
        el.addEventListener('click', () => selectDate(new Date(year, month, d), el));
        grid.appendChild(el);
      }
    }

    function buildCalendar2(container, year, month) {
      const cal = document.getElementById(container);
      if (!cal) return;
      cal.innerHTML = `
        <div class='calendar-header'>
          <button class='calendar-nav-btn' id='prevMonth2'>&lt;</button>
          <div class='calendar-title'>${getMonthName(month)} ${year}</div>
          <button class='calendar-nav-btn' id='nextMonth2'>&gt;</button>
        </div>
        <div class='days'></div>`;

      // Prev/Next buton event listeners
      const prevBtn = cal.querySelector('#prevMonth2');
      const nextBtn = cal.querySelector('#nextMonth2');
      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth2--;
          if (currentMonth2 < 0) {
            currentMonth2 = 11;
            currentYear2--;
          }
          buildCalendar2(container, currentYear2, currentMonth2);
          if (startDate2 && endDate2) markRange2();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth2++;
          if (currentMonth2 > 11) {
            currentMonth2 = 0;
            currentYear2++;
          }
          buildCalendar2(container, currentYear2, currentMonth2);
          if (startDate2 && endDate2) markRange2();
        });
      }

      const grid = cal.querySelector('.days');
      const headers = ['P', 'S', 'Ç', 'P', 'C', 'C', 'P'];
      headers.forEach(h => {
        const d = document.createElement('div');
        d.className = 'day header';
        d.textContent = h;
        grid.appendChild(d);
      });
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const e = document.createElement('div');
        grid.appendChild(e);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = d;
        el.addEventListener('click', () => selectDate2(new Date(year, month, d), el));
        grid.appendChild(el);
      }
    }

    function buildCalendar3(container, year, month) {
      const cal = document.getElementById(container);
      if (!cal) return;
      cal.innerHTML = `
        <div class='calendar-header'>
          <button class='calendar-nav-btn' id='prevMonth3'>&lt;</button>
          <div class='calendar-title'>${getMonthName(month)} ${year}</div>
          <button class='calendar-nav-btn' id='nextMonth3'>&gt;</button>
        </div>
        <div class='days'></div>`;

      const prevBtn = cal.querySelector('#prevMonth3');
      const nextBtn = cal.querySelector('#nextMonth3');
      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth3--;
          if (currentMonth3 < 0) {
            currentMonth3 = 11;
            currentYear3--;
          }
          buildCalendar3(container, currentYear3, currentMonth3);
          if (startDate3 && endDate3) markRange3();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth3++;
          if (currentMonth3 > 11) {
            currentMonth3 = 0;
            currentYear3++;
          }
          buildCalendar3(container, currentYear3, currentMonth3);
          if (startDate3 && endDate3) markRange3();
        });
      }

      const grid = cal.querySelector('.days');
      const headers = ['P', 'S', 'Ç', 'P', 'C', 'C', 'P'];
      headers.forEach(h => {
        const d = document.createElement('div');
        d.className = 'day header';
        d.textContent = h;
        grid.appendChild(d);
      });
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const e = document.createElement('div');
        grid.appendChild(e);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = d;
        el.addEventListener('click', () => selectDate3(new Date(year, month, d), el));
        grid.appendChild(el);
      }
    }

    function buildCalendar4(container, year, month) {
      const cal = document.getElementById(container);
      if (!cal) return;
      cal.innerHTML = `
        <div class='calendar-header'>
          <button class='calendar-nav-btn' id='prevMonth4'>&lt;</button>
          <div class='calendar-title'>${getMonthName(month)} ${year}</div>
          <button class='calendar-nav-btn' id='nextMonth4'>&gt;</button>
        </div>
        <div class='days'></div>`;

      const prevBtn = cal.querySelector('#prevMonth4');
      const nextBtn = cal.querySelector('#nextMonth4');
      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth4--;
          if (currentMonth4 < 0) {
            currentMonth4 = 11;
            currentYear4--;
          }
          buildCalendar4(container, currentYear4, currentMonth4);
          if (startDate4 && endDate4) markRange4();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth4++;
          if (currentMonth4 > 11) {
            currentMonth4 = 0;
            currentYear4++;
          }
          buildCalendar4(container, currentYear4, currentMonth4);
          if (startDate4 && endDate4) markRange4();
        });
      }

      const grid = cal.querySelector('.days');
      const headers = ['P', 'S', 'Ç', 'P', 'C', 'C', 'P'];
      headers.forEach(h => {
        const d = document.createElement('div');
        d.className = 'day header';
        d.textContent = h;
        grid.appendChild(d);
      });
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const e = document.createElement('div');
        grid.appendChild(e);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = d;
        el.addEventListener('click', () => selectDate4(new Date(year, month, d), el));
        grid.appendChild(el);
      }
    }

    function buildCalendar5(container, year, month) {
      const cal = document.getElementById(container);
      if (!cal) return;
      cal.innerHTML = `
        <div class='calendar-header'>
          <button class='calendar-nav-btn' id='prevMonth5'>&lt;</button>
          <div class='calendar-title'>${getMonthName(month)} ${year}</div>
          <button class='calendar-nav-btn' id='nextMonth5'>&gt;</button>
        </div>
        <div class='days'></div>`;

      const prevBtn = cal.querySelector('#prevMonth5');
      const nextBtn = cal.querySelector('#nextMonth5');
      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth5--;
          if (currentMonth5 < 0) {
            currentMonth5 = 11;
            currentYear5--;
          }
          buildCalendar5(container, currentYear5, currentMonth5);
          if (startDate5 && endDate5) markRange5();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth5++;
          if (currentMonth5 > 11) {
            currentMonth5 = 0;
            currentYear5++;
          }
          buildCalendar5(container, currentYear5, currentMonth5);
          if (startDate5 && endDate5) markRange5();
        });
      }

      const grid = cal.querySelector('.days');
      const headers = ['P', 'S', 'Ç', 'P', 'C', 'C', 'P'];
      headers.forEach(h => {
        const d = document.createElement('div');
        d.className = 'day header';
        d.textContent = h;
        grid.appendChild(d);
      });
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const e = document.createElement('div');
        grid.appendChild(e);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = d;
        el.addEventListener('click', () => selectDate5(new Date(year, month, d), el));
        grid.appendChild(el);
      }
    }

    function buildCalendar6(container, year, month) {
      const cal = document.getElementById(container);
      if (!cal) return;
      cal.innerHTML = `
        <div class='calendar-header'>
          <button class='calendar-nav-btn' id='prevMonth6'>&lt;</button>
          <div class='calendar-title'>${getMonthName(month)} ${year}</div>
          <button class='calendar-nav-btn' id='nextMonth6'>&gt;</button>
        </div>
        <div class='days'></div>`;

      const prevBtn = cal.querySelector('#prevMonth6');
      const nextBtn = cal.querySelector('#nextMonth6');
      if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth6--;
          if (currentMonth6 < 0) {
            currentMonth6 = 11;
            currentYear6--;
          }
          buildCalendar6(container, currentYear6, currentMonth6);
          if (startDate6 && endDate6) markRange6();
        });
      }
      if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          currentMonth6++;
          if (currentMonth6 > 11) {
            currentMonth6 = 0;
            currentYear6++;
          }
          buildCalendar6(container, currentYear6, currentMonth6);
          if (startDate6 && endDate6) markRange6();
        });
      }

      const grid = cal.querySelector('.days');
      const headers = ['P', 'S', 'Ç', 'P', 'C', 'C', 'P'];
      headers.forEach(h => {
        const d = document.createElement('div');
        d.className = 'day header';
        d.textContent = h;
        grid.appendChild(d);
      });
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      for (let i = 0; i < firstDay; i++) {
        const e = document.createElement('div');
        grid.appendChild(e);
      }
      for (let d = 1; d <= daysInMonth; d++) {
        const el = document.createElement('div');
        el.className = 'day';
        el.textContent = d;
        el.addEventListener('click', () => selectDate6(new Date(year, month, d), el));
        grid.appendChild(el);
      }
    }
    // Tarih seçme fonksiyonları
    function selectDate(date, el) {
      if (!startDate || (startDate && endDate)) {
        startDate = date;
        endDate = null;
        clearSelection();
        el.classList.add('selected');
        rangeText.textContent = formatDate(startDate);
        dayCount.textContent = 'Başlangıç tarihi seçildi';
      } else {
        if (date < startDate) {
          [startDate, date] = [date, startDate];
        }
        endDate = date;
        markRange();
        const diff = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        rangeText.textContent = `${formatDate(startDate)} – ${formatDate(endDate)}`;
        dayCount.textContent = `${diff} gün seçildi`;
      }
    }

    function selectDate2(date, el) {
      if (!startDate2 || (startDate2 && endDate2)) {
        startDate2 = date;
        endDate2 = null;
        clearSelection2();
        el.classList.add('selected');
        if (rangeText2) rangeText2.textContent = formatDate(startDate2);
        if (dayCount2) dayCount2.textContent = 'Başlangıç tarihi seçildi';
      } else {
        if (date < startDate2) {
          [startDate2, date] = [date, startDate2];
        }
        endDate2 = date;
        markRange2();
        const diff = Math.round((endDate2 - startDate2) / (1000 * 60 * 60 * 24)) + 1;
        if (rangeText2) rangeText2.textContent = `${formatDate(startDate2)} – ${formatDate(endDate2)}`;
        if (dayCount2) dayCount2.textContent = `${diff} gün seçildi`;
      }
    }

    function selectDate3(date, el) {
      if (!startDate3 || (startDate3 && endDate3)) {
        startDate3 = date;
        endDate3 = null;
        clearSelection3();
        el.classList.add('selected');
        if (rangeText3) rangeText3.textContent = formatDate(startDate3);
        if (dayCount3) dayCount3.textContent = 'Başlangıç tarihi seçildi';
      } else {
        if (date < startDate3) {
          [startDate3, date] = [date, startDate3];
        }
        endDate3 = date;
        markRange3();
        const diff = Math.round((endDate3 - startDate3) / (1000 * 60 * 60 * 24)) + 1;
        if (rangeText3) rangeText3.textContent = `${formatDate(startDate3)} – ${formatDate(endDate3)}`;
        if (dayCount3) dayCount3.textContent = `${diff} gün seçildi`;
      }
    }

    function selectDate4(date, el) {
      if (!startDate4 || (startDate4 && endDate4)) {
        startDate4 = date;
        endDate4 = null;
        clearSelection4();
        el.classList.add('selected');
        if (rangeText4) rangeText4.textContent = formatDate(startDate4);
        if (dayCount4) dayCount4.textContent = 'Başlangıç tarihi seçildi';
      } else {
        if (date < startDate4) {
          [startDate4, date] = [date, startDate4];
        }
        endDate4 = date;
        markRange4();
        const diff = Math.round((endDate4 - startDate4) / (1000 * 60 * 60 * 24)) + 1;
        if (rangeText4) rangeText4.textContent = `${formatDate(startDate4)} – ${formatDate(endDate4)}`;
        if (dayCount4) dayCount4.textContent = `${diff} gün seçildi`;
      }
    }

    function selectDate5(date, el) {
      if (!startDate5 || (startDate5 && endDate5)) {
        startDate5 = date;
        endDate5 = null;
        clearSelection5();
        el.classList.add('selected');
        if (rangeText5) rangeText5.textContent = formatDate(startDate5);
        if (dayCount5) dayCount5.textContent = 'Başlangıç tarihi seçildi';
      } else {
        if (date < startDate5) {
          [startDate5, date] = [date, startDate5];
        }
        endDate5 = date;
        markRange5();
        const diff = Math.round((endDate5 - startDate5) / (1000 * 60 * 60 * 24)) + 1;
        if (rangeText5) rangeText5.textContent = `${formatDate(startDate5)} – ${formatDate(endDate5)}`;
        if (dayCount5) dayCount5.textContent = `${diff} gün seçildi`;
      }
    }

    function selectDate6(date, el) {
      if (!startDate6 || (startDate6 && endDate6)) {
        startDate6 = date;
        endDate6 = null;
        clearSelection6();
        el.classList.add('selected');
        if (rangeText6) rangeText6.textContent = formatDate(startDate6);
        if (dayCount6) dayCount6.textContent = 'Başlangıç tarihi seçildi';
      } else {
        if (date < startDate6) {
          [startDate6, date] = [date, startDate6];
        }
        endDate6 = date;
        markRange6();
        const diff = Math.round((endDate6 - startDate6) / (1000 * 60 * 60 * 24)) + 1;
        if (rangeText6) rangeText6.textContent = `${formatDate(startDate6)} – ${formatDate(endDate6)}`;
        if (dayCount6) dayCount6.textContent = `${diff} gün seçildi`;
      }
    }
    // Clear ve mark fonksiyonları
    function clearSelection() {
      document.querySelectorAll('#calendar .day').forEach(d => d.classList.remove('selected', 'inrange'));
    }

    function markRange() {
      clearSelection();
      document.querySelectorAll('#calendar .day').forEach(d => {
        const day = parseInt(d.textContent);
        if (!isNaN(day)) {
          const date = new Date(2025, 8, day);
          if (date >= startDate && date <= endDate) {
            d.classList.add('inrange');
          }
          if (date.getTime() === startDate.getTime() || date.getTime() === endDate?.getTime()) {
            d.classList.add('selected');
          }
        }
      });
    }

    function clearSelection2() {
      const nodes = document.querySelectorAll('#calendar2 .day');
      nodes.forEach(d => d.classList.remove('selected', 'inrange'));
    }

    function markRange2() {
      clearSelection2();
      document.querySelectorAll('#calendar2 .day').forEach(d => {
        const day = parseInt(d.textContent);
        if (!isNaN(day)) {
          const date = new Date(currentYear2, currentMonth2, day);
          if (date >= startDate2 && date <= endDate2) {
            d.classList.add('inrange');
          }
          if (date.getTime() === startDate2.getTime() || date.getTime() === endDate2?.getTime()) {
            d.classList.add('selected');
          }
        }
      });
    }

    function clearSelection3() {
      const nodes = document.querySelectorAll('#calendar3 .day');
      nodes.forEach(d => d.classList.remove('selected', 'inrange'));
    }

    function markRange3() {
      clearSelection3();
      document.querySelectorAll('#calendar3 .day').forEach(d => {
        const day = parseInt(d.textContent);
        if (!isNaN(day)) {
          const date = new Date(currentYear3, currentMonth3, day);
          if (date >= startDate3 && date <= endDate3) {
            d.classList.add('inrange');
          }
          if (date.getTime() === startDate3.getTime() || date.getTime() === endDate3?.getTime()) {
            d.classList.add('selected');
          }
        }
      });
    }

    function clearSelection4() {
      const nodes = document.querySelectorAll('#calendar4 .day');
      nodes.forEach(d => d.classList.remove('selected', 'inrange'));
    }

    function markRange4() {
      clearSelection4();
      document.querySelectorAll('#calendar4 .day').forEach(d => {
        const day = parseInt(d.textContent);
        if (!isNaN(day)) {
          const date = new Date(currentYear4, currentMonth4, day);
          if (date >= startDate4 && date <= endDate4) {
            d.classList.add('inrange');
          }
          if (date.getTime() === startDate4.getTime() || date.getTime() === endDate4?.getTime()) {
            d.classList.add('selected');
          }
        }
      });
    }

    function clearSelection5() {
      const nodes = document.querySelectorAll('#calendar5 .day');
      nodes.forEach(d => d.classList.remove('selected', 'inrange'));
    }

    function markRange5() {
      clearSelection5();
      document.querySelectorAll('#calendar5 .day').forEach(d => {
        const day = parseInt(d.textContent);
        if (!isNaN(day)) {
          const date = new Date(currentYear5, currentMonth5, day);
          if (date >= startDate5 && date <= endDate5) {
            d.classList.add('inrange');
          }
          if (date.getTime() === startDate5.getTime() || date.getTime() === endDate5?.getTime()) {
            d.classList.add('selected');
          }
        }
      });
    }

    function clearSelection6() {
      const nodes = document.querySelectorAll('#calendar6 .day');
      nodes.forEach(d => d.classList.remove('selected', 'inrange'));
    }

    function markRange6() {
      clearSelection6();
      document.querySelectorAll('#calendar6 .day').forEach(d => {
        const day = parseInt(d.textContent);
        if (!isNaN(day)) {
          const date = new Date(currentYear6, currentMonth6, day);
          if (date >= startDate6 && date <= endDate6) {
            d.classList.add('inrange');
          }
          if (date.getTime() === startDate6.getTime() || date.getTime() === endDate6?.getTime()) {
            d.classList.add('selected');
          }
        }
      });
    }
    // Yardımcı fonksiyonlar
    function formatDate(date) {
      const m = ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara'];
      return `${date.getDate()} ${m[date.getMonth()]} ${date.getFullYear()}`;
    }

    function getMonthName(m) {
      const arr = ['OCA', 'ŞUB', 'MAR', 'NİS', 'MAY', 'HAZ', 'TEM', 'AĞU', 'EYL', 'EKİ', 'KAS', 'ARA'];
      return arr[m];
    }

    // Takvim state değişkenleri - bugünün tarihi ile başlat
    const today = new Date();
    let currentYear = today.getFullYear();
    let currentMonth = today.getMonth();
    let currentYear2 = today.getFullYear();
    let currentMonth2 = today.getMonth();
    let currentYear3 = today.getFullYear();
    let currentMonth3 = today.getMonth();
    let currentYear4 = today.getFullYear();
    let currentMonth4 = today.getMonth();
    let currentYear5 = today.getFullYear();
    let currentMonth5 = today.getMonth();
    let currentYear6 = today.getFullYear();
    let currentMonth6 = today.getMonth();

    // Takvimleri oluştur
    buildCalendar('calendar', currentYear, currentMonth);
    buildCalendar2('calendar2', currentYear2, currentMonth2);
    buildCalendar3('calendar3', currentYear3, currentMonth3);
    buildCalendar4('calendar4', currentYear4, currentMonth4);
    buildCalendar5('calendar5', currentYear5, currentMonth5);
    buildCalendar6('calendar6', currentYear6, currentMonth6);

    // Sayfa yüklendiğinde mevcut filtreleri takvime uygula
    function restoreServicesDates() {
      const startInput = document.getElementById('services-start-date');
      const endInput = document.getElementById('services-end-date');
      const selectDateInnerSpan = document.querySelector('.date-select-container .select-date span');

      if (startInput && endInput && startInput.value && endInput.value) {
        startDate2 = new Date(startInput.value);
        endDate2 = new Date(endInput.value);

        currentYear2 = startDate2.getFullYear();
        currentMonth2 = startDate2.getMonth();
        buildCalendar2('calendar2', currentYear2, currentMonth2);

        // Takvim render edildikten sonra seçili tarihleri işaretle
        setTimeout(() => {
          markRange2();
        }, 50);

        if (selectDateInnerSpan) {
          selectDateInnerSpan.textContent = `${formatDate(startDate2)} – ${formatDate(endDate2)}`;
        }

        const rangeText2 = document.getElementById('rangeText2');
        const dayCount2 = document.getElementById('dayCount2');
        if (rangeText2) {
          rangeText2.textContent = `${formatDate(startDate2)} – ${formatDate(endDate2)}`;
        }
        if (dayCount2) {
          const diff = Math.round((endDate2 - startDate2) / (1000 * 60 * 60 * 24)) + 1;
          dayCount2.textContent = `${diff} gün seçildi`;
        }
      }
    }

    function restoreIdeasDates() {
      const startInput = document.getElementById('ideas-start-date');
      const endInput = document.getElementById('ideas-end-date');
      const selectDateInnerSpan = document.querySelector('.date-select-container-3 .select-date-inner span');

      if (startInput && endInput && startInput.value && endInput.value) {
        startDate3 = new Date(startInput.value);
        endDate3 = new Date(endInput.value);

        currentYear3 = startDate3.getFullYear();
        currentMonth3 = startDate3.getMonth();
        buildCalendar3('calendar3', currentYear3, currentMonth3);

        setTimeout(() => {
          markRange3();
        }, 50);

        if (selectDateInnerSpan) {
          selectDateInnerSpan.textContent = `${formatDate(startDate3)} – ${formatDate(endDate3)}`;
        }

        const rangeText3 = document.getElementById('rangeText3');
        const dayCount3 = document.getElementById('dayCount3');
        if (rangeText3) {
          rangeText3.textContent = `${formatDate(startDate3)} – ${formatDate(endDate3)}`;
        }
        if (dayCount3) {
          const diff = Math.round((endDate3 - startDate3) / (1000 * 60 * 60 * 24)) + 1;
          dayCount3.textContent = `${diff} gün seçildi`;
        }
      }
    }

    function restoreCompaniesDates() {
      const startInput = document.getElementById('companies-start-date');
      const endInput = document.getElementById('companies-end-date');
      const selectDateInnerSpan = document.querySelector('.date-select-container-4 .select-date-inner span');

      if (startInput && endInput && startInput.value && endInput.value) {
        startDate4 = new Date(startInput.value);
        endDate4 = new Date(endInput.value);

        currentYear4 = startDate4.getFullYear();
        currentMonth4 = startDate4.getMonth();
        buildCalendar4('calendar4', currentYear4, currentMonth4);

        setTimeout(() => {
          markRange4();
        }, 50);

        if (selectDateInnerSpan) {
          selectDateInnerSpan.textContent = `${formatDate(startDate4)} – ${formatDate(endDate4)}`;
        }

        const rangeText4 = document.getElementById('rangeText4');
        const dayCount4 = document.getElementById('dayCount4');
        if (rangeText4) {
          rangeText4.textContent = `${formatDate(startDate4)} – ${formatDate(endDate4)}`;
        }
        if (dayCount4) {
          const diff = Math.round((endDate4 - startDate4) / (1000 * 60 * 60 * 24)) + 1;
          dayCount4.textContent = `${diff} gün seçildi`;
        }
      }
    }

    function restoreUsersDates() {
      const startInput = document.getElementById('users-start-date');
      const endInput = document.getElementById('users-end-date');
      const selectDateInnerSpan = document.querySelector('.date-select-container-5 .select-date-inner span');

      if (startInput && endInput && startInput.value && endInput.value) {
        startDate5 = new Date(startInput.value);
        endDate5 = new Date(endInput.value);

        currentYear5 = startDate5.getFullYear();
        currentMonth5 = startDate5.getMonth();
        buildCalendar5('calendar5', currentYear5, currentMonth5);

        setTimeout(() => {
          markRange5();
        }, 50);

        if (selectDateInnerSpan) {
          selectDateInnerSpan.textContent = `${formatDate(startDate5)} – ${formatDate(endDate5)}`;
        }

        const rangeText5 = document.getElementById('rangeText5');
        const dayCount5 = document.getElementById('dayCount5');
        if (rangeText5) {
          rangeText5.textContent = `${formatDate(startDate5)} – ${formatDate(endDate5)}`;
        }
        if (dayCount5) {
          const diff = Math.round((endDate5 - startDate5) / (1000 * 60 * 60 * 24)) + 1;
          dayCount5.textContent = `${diff} gün seçildi`;
        }
      }
    }

    function restoreSlidersDates() {
      const startInput = document.getElementById('sliders-start-date');
      const endInput = document.getElementById('sliders-end-date');
      const selectDateInnerSpan = document.querySelector('.date-select-container-6 .select-date-inner span');

      if (startInput && endInput && startInput.value && endInput.value) {
        startDate6 = new Date(startInput.value);
        endDate6 = new Date(endInput.value);

        currentYear6 = startDate6.getFullYear();
        currentMonth6 = startDate6.getMonth();
        buildCalendar6('calendar6', currentYear6, currentMonth6);

        setTimeout(() => {
          markRange6();
        }, 50);

        if (selectDateInnerSpan) {
          selectDateInnerSpan.textContent = `${formatDate(startDate6)} – ${formatDate(endDate6)}`;
        }

        const rangeText6 = document.getElementById('rangeText6');
        const dayCount6 = document.getElementById('dayCount6');
        if (rangeText6) {
          rangeText6.textContent = `${formatDate(startDate6)} – ${formatDate(endDate6)}`;
        }
        if (dayCount6) {
          const diff = Math.round((endDate6 - startDate6) / (1000 * 60 * 60 * 24)) + 1;
          dayCount6.textContent = `${diff} gün seçildi`;
        }
      }
    }

    // Services tab ilk açılışta restore et
    restoreServicesDates();
    //maintable
    document.addEventListener('DOMContentLoaded', function() {
      // Tüm table-body elementlerini bul
      const tableBodies = document.querySelectorAll('.table-body');
      tableBodies.forEach((tableBody) => {
        // Her table için ilgili header container'ı bul
        const wrapper = tableBody.closest('.table-wrapper');
        if (!wrapper) return;
        const headerTableContainer = wrapper.querySelector('.header-table-container');
        const headerScroll = wrapper.querySelector('.header-scroll');
        const scrollContent = wrapper.querySelector('.header-scroll-content');
        const table = tableBody.querySelector('table');
        if (!headerTableContainer || !headerScroll || !scrollContent || !table) return;
        // Table body scroll olduğunda header'ı senkronize et
        tableBody.addEventListener('scroll', function() {
          const scrollLeft = tableBody.scrollLeft;
          headerTableContainer.style.transform = `translateX(-${scrollLeft}px)`;
          headerScroll.scrollLeft = scrollLeft;
        });
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
        // Tab değiştiğinde genişliği güncelle
        const tabPane = wrapper.closest('.tab-pane');
        if (tabPane) {
          // MutationObserver ile tab'ın görünür olup olmadığını izle
          const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
              if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                if (tabPane.classList.contains('active') || tabPane.classList.contains('show')) {
                  // Tab aktif olduğunda genişliği güncelle
                  setTimeout(updateScrollWidth, 100);
                }
              }
            });
          });
          observer.observe(tabPane, {
            attributes: true
          });
        }
      });
      // Bootstrap tab değişim eventini dinle (eğer Bootstrap kullanıyorsanız)
      const tabLinks = document.querySelectorAll('a[data-bs-toggle="tab"], a[data-toggle="tab"]');
      tabLinks.forEach(link => {
        link.addEventListener('shown.bs.tab', function() {
          // Her tab değiştiğinde tüm tabloların genişliğini güncelle
          tableBodies.forEach(tableBody => {
            const wrapper = tableBody.closest('.table-wrapper');
            if (!wrapper) return;
            const scrollContent = wrapper.querySelector('.header-scroll-content');
            const table = tableBody.querySelector('table');
            if (scrollContent && table) {
              const tableWidth = table.scrollWidth;
              scrollContent.style.width = tableWidth + 'px';
            }
          });
        });
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
      fiyatBox = element.nextElementSibling?.classList.contains('tumhizmetlerfiyatbox') ? element.nextElementSibling : null;
      if (fiyatBox) return fiyatBox;
      fiyatBox = element.previousElementSibling?.classList.contains('tumhizmetlerfiyatbox') ? element.previousElementSibling : null;
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
      if (event.target.classList.contains('tumhizmetler-closed') || event.target.classList.contains('tumhizmetler-update')) {
        // Tıklanan elementin en yakın .tumhizmetlerfiyatbox'ını bul
        const fiyatBox = findClosestFiyatBox(event.target);
        if (fiyatBox) {
          fiyatBox.classList.remove('show');
        }
        // Event'in bubbling yapmasını engelle
        event.stopPropagation();
      }
    });

    // ============== ANALYTICS FILTER SYSTEM ==============
    document.addEventListener('DOMContentLoaded', function() {

      // HİZMETLER TAB - Filtre dropdown'ları için hidden input güncellemeleri
      document.querySelectorAll('#pills-home .analizsearch-item').forEach(item => {
        item.addEventListener('click', function() {
          const value = this.getAttribute('data-value');
          const menu = this.closest('.analizsearch-menu');
          const dropdownId = menu.getAttribute('data-dropdown-menu');

          // Hidden input'u bul ve güncelle
          if (dropdownId === 'dropdown1') { // Kategori
            document.getElementById('services-category-id').value = value;
            // Kategori değiştiğinde alt kategorileri yükle
            loadSubCategories(value, 'dropdown2', 'services-sub-category-id');
          } else if (dropdownId === 'dropdown2') { // Alt Kategori
            document.getElementById('services-sub-category-id').value = value;
          } else if (dropdownId === 'dropdown3') { // İl
            document.getElementById('services-province-id').value = value;
            // İl değiştiğinde ilçeleri yükle
            loadDistricts(value, 'dropdown4', 'services-district-id');
          } else if (dropdownId === 'dropdown4') { // İlçe
            document.getElementById('services-district-id').value = value;
          } else if (dropdownId === 'dropdown5') { // Durum
            document.getElementById('services-status').value = value;
          }
        });
      });

      // Temizle butonu
      const clearBtn = document.getElementById('services-clear-btn');
      if (clearBtn) {
        clearBtn.addEventListener('click', function() {
          window.location.href = '{{ route('admin.analytics.index') }}';
        });
      }

      // FİKİRLER TAB - Filtre dropdown'ları için hidden input güncellemeleri
      document.querySelectorAll('#pills-profile .analizsearch-item').forEach(item => {
        item.addEventListener('click', function() {
          const value = this.getAttribute('data-value');
          const menu = this.closest('.analizsearch-menu');
          const dropdownId = menu.getAttribute('data-dropdown-menu');

          // Hidden input'u bul ve güncelle
          if (dropdownId === 'dropdown7') { // Kategori
            document.getElementById('ideas-category-id').value = value;
            loadSubCategories(value, 'dropdown8', 'ideas-sub-category-id');
          } else if (dropdownId === 'dropdown8') { // Alt Kategori
            document.getElementById('ideas-sub-category-id').value = value;
          } else if (dropdownId === 'dropdown11') { // Durum
            document.getElementById('ideas-status').value = value;
          }
        });
      });

      // FİRMALAR TAB - Filtre dropdown'ları için hidden input güncellemeleri
      document.querySelectorAll('#pills-contact .analizsearch-item').forEach(item => {
        item.addEventListener('click', function() {
          const value = this.getAttribute('data-value');
          const menu = this.closest('.analizsearch-menu');
          const dropdownId = menu.getAttribute('data-dropdown-menu');

          // Hidden input'u bul ve güncelle
          if (dropdownId === 'dropdown12') { // Kategori
            document.getElementById('companies-category-id').value = value;
            loadSubCategories(value, 'dropdown13', 'companies-sub-category-id');
          } else if (dropdownId === 'dropdown13') { // Alt Kategori
            document.getElementById('companies-sub-category-id').value = value;
          } else if (dropdownId === 'dropdown15') { // İl
            document.getElementById('companies-province-id').value = value;
            loadDistricts(value, 'dropdown16', 'companies-district-id');
          } else if (dropdownId === 'dropdown16') { // İlçe
            document.getElementById('companies-district-id').value = value;
          } else if (dropdownId === 'dropdown14') { // Durum
            document.getElementById('companies-status').value = value;
          } else if (dropdownId === 'dropdown17') { // Pro Üyelik
            document.getElementById('companies-is-pro').value = value;
          }
        });
      });

      // BİREYSEL ÜYELER TAB - Filtre dropdown'ları için hidden input güncellemeleri
      document.querySelectorAll('#pills-contact2 .analizsearch-item').forEach(item => {
        item.addEventListener('click', function() {
          const value = this.getAttribute('data-value');
          const menu = this.closest('.analizsearch-menu');
          const dropdownId = menu.getAttribute('data-dropdown-menu');

          // Hidden input'u bul ve güncelle
          if (dropdownId === 'dropdown20') { // Kategori
            document.getElementById('users-category-id').value = value;
            loadSubCategories(value, 'dropdown21', 'users-sub-category-id');
          } else if (dropdownId === 'dropdown21') { // Alt Kategori
            document.getElementById('users-sub-category-id').value = value;
          } else if (dropdownId === 'dropdown22') { // Durum
            document.getElementById('users-status').value = value;
          }
        });
      });

      // SLAYTLAR TAB - Filtre dropdown'ları için hidden input güncellemeleri
      document.querySelectorAll('#pills-contact3 .analizsearch-item').forEach(item => {
        item.addEventListener('click', function() {
          const value = this.getAttribute('data-value');
          const menu = this.closest('.analizsearch-menu');
          const dropdownId = menu.getAttribute('data-dropdown-menu');

          // Hidden input'u bul ve güncelle
          if (dropdownId === 'dropdown25') { // Durum
            document.getElementById('sliders-status').value = value;
          }
        });
      });

      // Alt kategorileri yükleme fonksiyonu
      function loadSubCategories(categoryId, dropdownMenuId, hiddenInputId) {
        if (!categoryId) {
          // Kategori temizlendiğinde alt kategoriyi de temizle
          const menu = document.querySelector(`[data-dropdown-menu="${dropdownMenuId}"]`);
          menu.innerHTML = '<div class="analizsearch-item" data-value="">Tümü</div>';
          document.getElementById(hiddenInputId).value = '';
          const toggle = document.querySelector(`[data-dropdown="${dropdownMenuId}"]`);
          toggle.textContent = 'Alt Kategori';
          return;
        }

        fetch(`/get-sub-categories/${categoryId}`)
          .then(response => response.json())
          .then(data => {
            const menu = document.querySelector(`[data-dropdown-menu="${dropdownMenuId}"]`);
            let html = '<div class="analizsearch-item" data-value="">Tümü</div>';
            data.forEach(subCat => {
              html += `<div class="analizsearch-item" data-value="${subCat.id}">${subCat.name}</div>`;
            });
            menu.innerHTML = html;

            // Yeni eklenen itemlere click eventi ekle
            menu.querySelectorAll('.analizsearch-item').forEach(item => {
              item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                document.getElementById(hiddenInputId).value = value;
                const toggle = document.querySelector(`[data-dropdown="${dropdownMenuId}"]`);
                toggle.textContent = this.textContent;
                menu.classList.remove('show');
                toggle.classList.remove('active');
              });
            });

            // Hidden input ve toggle'ı sıfırla
            document.getElementById(hiddenInputId).value = '';
            const toggle = document.querySelector(`[data-dropdown="${dropdownMenuId}"]`);
            toggle.textContent = 'Alt Kategori';
          })
          .catch(error => console.error('Alt kategoriler yüklenemedi:', error));
      }

      // İlçeleri yükleme fonksiyonu
      function loadDistricts(provinceId, dropdownMenuId, hiddenInputId) {
        if (!provinceId) {
          const menu = document.querySelector(`[data-dropdown-menu="${dropdownMenuId}"]`);
          menu.innerHTML = '<div class="analizsearch-item" data-value="">Tümü</div>';
          document.getElementById(hiddenInputId).value = '';
          const toggle = document.querySelector(`[data-dropdown="${dropdownMenuId}"]`);
          toggle.textContent = 'İlçe';
          return;
        }

        fetch(`/get-districts/${provinceId}`)
          .then(response => response.json())
          .then(data => {
            const menu = document.querySelector(`[data-dropdown-menu="${dropdownMenuId}"]`);
            let html = '<div class="analizsearch-item" data-value="">Tümü</div>';
            data.forEach(district => {
              html += `<div class="analizsearch-item" data-value="${district.id}">${district.name}</div>`;
            });
            menu.innerHTML = html;

            // Yeni eklenen itemlere click eventi ekle
            menu.querySelectorAll('.analizsearch-item').forEach(item => {
              item.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                document.getElementById(hiddenInputId).value = value;
                const toggle = document.querySelector(`[data-dropdown="${dropdownMenuId}"]`);
                toggle.textContent = this.textContent;
                menu.classList.remove('show');
                toggle.classList.remove('active');
              });
            });

            document.getElementById(hiddenInputId).value = '';
            const toggle = document.querySelector(`[data-dropdown="${dropdownMenuId}"]`);
            toggle.textContent = 'İlçe';
          })
          .catch(error => console.error('İlçeler yüklenemedi:', error));
      }

      // Sayfa yüklendiğinde eğer kategori seçiliyse alt kategorileri yükle
      const selectedCategory = document.getElementById('services-category-id')?.value;
      if (selectedCategory) {
        loadSubCategories(selectedCategory, 'dropdown2', 'services-sub-category-id');
      }

      // Sayfa yüklendiğinde eğer il seçiliyse ilçeleri yükle
      const selectedProvince = document.getElementById('services-province-id')?.value;
      if (selectedProvince) {
        loadDistricts(selectedProvince, 'dropdown4', 'services-district-id');
      }

      // ============== TAB SWITCHING SYSTEM ==============
      const tabButtons = document.querySelectorAll('#pills-tab button[data-bs-toggle="pill"]');
      const tabsLoaded = {
        'pills-home': true, // Hizmetler zaten PHP ile yüklendi
        'pills-profile': false, // Fikirler
        'pills-contact': false, // Firmalar
        'pills-contact2': false, // Bireysel Üye
        'pills-contact3': false // Slaytlar
      };

      tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
          const targetTabId = event.target.getAttribute('data-bs-target').replace('#', '');

          // Eğer bu tab daha önce yüklenmediyse AJAX ile yükle
          if (!tabsLoaded[targetTabId]) {
            loadTabData(targetTabId);
            tabsLoaded[targetTabId] = true;
          }
        });
      });

      function loadTabData(tabId) {
        let endpoint = '';
        let renderFunction = null;

        switch(tabId) {
          case 'pills-profile': // Fikirler
            endpoint = '{{ route('admin.analytics.ideas') }}';
            renderFunction = renderIdeasTab;
            break;
          case 'pills-contact': // Firmalar
            endpoint = '{{ route('admin.analytics.companies') }}';
            renderFunction = renderCompaniesTab;
            break;
          case 'pills-contact2': // Bireysel Üye
            endpoint = '{{ route('admin.analytics.users') }}';
            renderFunction = renderUsersTab;
            break;
          case 'pills-contact3': // Slaytlar
            endpoint = '{{ route('admin.analytics.sliders') }}';
            renderFunction = renderSlidersTab;
            break;
        }

        if (!endpoint || !renderFunction) return;

        // Fikirler için sıralama parametrelerini ekle
        if (tabId === 'pills-profile') {
          const params = new URLSearchParams();
          params.append('sort', ideasSortField);
          params.append('direction', ideasSortDirection);
          endpoint += '?' + params.toString();
        }

        // Loading göster
        const tabContent = document.getElementById(tabId);
        const tableBody = tabContent.querySelector('tbody');
        if (tableBody) {
          tableBody.innerHTML = '<tr><td colspan="12" class="text-center py-4"><i class="fa fa-spinner fa-spin"></i> Yükleniyor...</td></tr>';
        }

        // AJAX ile veri çek
        fetch(endpoint)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              renderFunction(data.data, data.pagination, tabContent);
            } else {
              tableBody.innerHTML = '<tr><td colspan="12" class="text-center py-4 text-danger">Veri yüklenirken hata oluştu.</td></tr>';
            }
          })
          .catch(error => {
            console.error('Tab data loading error:', error);
            if (tableBody) {
              tableBody.innerHTML = '<tr><td colspan="12" class="text-center py-4 text-danger">Veri yüklenirken hata oluştu.</td></tr>';
            }
          });
      }

      // ============== RENDER FUNCTIONS ==============

      // Fikirler tabını render et
      function renderIdeasTab(ideas, pagination, tabContent) {
        const tableBody = tabContent.querySelector('tbody');

        if (ideas.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="11" class="text-center py-4"><p class="text-muted">Henüz fikir bulunmamaktadır.</p></td></tr>';
          return;
        }

        let html = '';
        ideas.forEach(idea => {
          html += `
            <tr>
              <td>${idea.id}</td>
              <td>
                <div class="tumhizmetlerimg">
                  <img src="${idea.cover_photo && idea.cover_photo !== 'null' ? idea.cover_photo : '{{ asset('site/images/default-service.jpg') }}'}" alt="${idea.title}">
                </div>
              </td>
              <td>
                <div class="tumhizmetler-name">
                  <h2>${idea.title ? idea.title.substring(0, 50) : '-'}</h2>
                  <h3>${idea.content ? idea.content.substring(0, 100) : idea.user_name}</h3>
                </div>
              </td>
              <td>${idea.category}</td>
              <td>${idea.sub_category || '-'}</td>
              <td>${(idea.views_count || 0).toLocaleString('tr-TR')}</td>
              <td>${(idea.likes_count || 0).toLocaleString('tr-TR')}</td>
              <td>${(idea.replies_count || 0).toLocaleString('tr-TR')}</td>
              <td>
                <div class="tumhizmetler-status-new">
                  <div class="status-container">
                    <div class="status-dropdown-wrapper" data-idea-id="${idea.id}">
                      <div class="status-dropdown-btn">
                        <span class="status-indicator ${idea.status == 1 ? 'is-active' : 'is-inactive'}">
                          <span class="status-symbol">${idea.status == 1 ? '✓' : '⊖'}</span>
                          <span>${idea.status == 1 ? 'Aktif' : 'Pasif'}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="olusturulma-tarihi">
                  <span>${idea.created_at}</span>
                </div>
              </td>
              <td>
                <div class="tumhizmetler-islemler">
                  <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                    <span class="tooltiptext">Görüntüle</span>
                    <a href="/idea/${idea.slug}" target="_blank">
                      <i class="fa-solid fa-eye" style="color: white !important;"></i>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          `;
        });

        tableBody.innerHTML = html;

        // Sonuç sayısını güncelle
        const resultText = tabContent.querySelector('.search-results-text h4');
        if (resultText && pagination) {
          resultText.innerHTML = `Filtrelemenize uygun <b>${pagination.total}</b> fikir bulundu.`;
        }

        // Pagination render et
        renderPagination(pagination, tabContent, 'ideas');

        // Tarihleri restore et
        setTimeout(() => restoreIdeasDates(), 100);
      }

      // Firmalar tabını render et
      function renderCompaniesTab(companies, pagination, tabContent) {
        const tableBody = tabContent.querySelector('tbody');

        if (companies.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="13" class="text-center py-4"><p class="text-muted">Henüz firma bulunmamaktadır.</p></td></tr>';
          return;
        }

        let html = '';
        companies.forEach(company => {
          html += `
            <tr>
              <td>${company.id}</td>
              <td>
                <div class="tumhizmetlerimg">
                  <img src="${company.avatar && company.avatar !== 'null' ? company.avatar : '{{ asset('site/images/default-avatar.jpg') }}'}" alt="${company.name}">
                </div>
              </td>
              <td>
                <div class="tumhizmetler-name">
                  <h2>${company.name.substring(0, 50)}</h2>
                  <h3>${company.category || '-'}</h3>
                </div>
              </td>
              <td>${company.category || '-'}</td>
              <td>${company.sub_category || '-'}</td>
              <td>${(company.views_count || 0).toLocaleString('tr-TR')}</td>
              <td>${(company.services_count || 0).toLocaleString('tr-TR')}</td>
              <td>${company.province || '-'}</td>
              <td>${company.district || '-'}</td>
              <td>
                <span class="badge ${company.package_type === 'Pro' ? 'bg-warning' : 'bg-secondary'}">${company.package_type}</span>
              </td>
              <td>
                <div class="tumhizmetler-status-new">
                  <div class="status-container">
                    <div class="status-dropdown-wrapper" data-company-id="${company.id}">
                      <div class="status-dropdown-btn">
                        <span class="status-indicator ${company.status == 1 ? 'is-active' : 'is-inactive'}">
                          <span class="status-symbol">${company.status == 1 ? '✓' : '⊖'}</span>
                          <span>${company.status == 1 ? 'Aktif' : 'Pasif'}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="olusturulma-tarihi">
                  <span>${company.created_at}</span>
                </div>
              </td>
              <td>
                <div class="tumhizmetler-islemler">
                  <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                    <span class="tooltiptext">Görüntüle</span>
                    <a href="/companies/${company.slug}" target="_blank">
                      <i class="fa-solid fa-eye" style="color: white !important;"></i>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          `;
        });

        tableBody.innerHTML = html;

        const resultText = tabContent.querySelector('.search-results-text h4');
        if (resultText && pagination) {
          resultText.innerHTML = `Filtrelemenize uygun <b>${pagination.total}</b> firma bulundu.`;
        }

        // Pagination render et
        renderPagination(pagination, tabContent, 'companies');

        // Tarihleri restore et
        setTimeout(() => restoreCompaniesDates(), 100);
      }

      // Bireysel Üye tabını render et
      function renderUsersTab(users, pagination, tabContent) {
        const tableBody = tabContent.querySelector('tbody');

        if (users.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="9" class="text-center py-4"><p class="text-muted">Henüz üye bulunmamaktadır.</p></td></tr>';
          return;
        }

        let html = '';
        users.forEach(user => {
          html += `
            <tr>
              <td>${user.id}</td>
              <td>
                <div class="tumhizmetlerimg">
                  <img src="${user.avatar && user.avatar !== 'null' ? user.avatar : '{{ asset('site/images/default-avatar.jpg') }}'}" alt="${user.name}">
                </div>
              </td>
              <td>
                <div class="tumhizmetler-name">
                  <h2>${user.name}</h2>
                  <h3>${user.email || '-'}</h3>
                </div>
              </td>
              <td>${user.category || '-'}</td>
              <td>${user.sub_category || '-'}</td>
              <td>${(user.ideas_count || 0).toLocaleString('tr-TR')}</td>
              <td>
                <div class="tumhizmetler-status-new">
                  <div class="status-container">
                    <div class="status-dropdown-wrapper" data-user-id="${user.id}">
                      <div class="status-dropdown-btn">
                        <span class="status-indicator ${user.status == 1 ? 'is-active' : 'is-inactive'}">
                          <span class="status-symbol">${user.status == 1 ? '✓' : '⊖'}</span>
                          <span>${user.status == 1 ? 'Aktif' : 'Pasif'}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="olusturulma-tarihi">
                  <span>${user.created_at}</span>
                </div>
              </td>
              <td>
                <div class="tumhizmetler-islemler">
                  <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
                    <span class="tooltiptext">Görüntüle</span>
                    <a href="/user/profile/${user.id}" target="_blank">
                      <i class="fa-solid fa-eye" style="color: white !important;"></i>
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          `;
        });

        tableBody.innerHTML = html;

        const resultText = tabContent.querySelector('.search-results-text h4');
        if (resultText && pagination) {
          resultText.innerHTML = `Filtrelemenize uygun <b>${pagination.total}</b> üye bulundu.`;
        }

        // Pagination render et
        renderPagination(pagination, tabContent, 'users');

        // Tarihleri restore et
        setTimeout(() => restoreUsersDates(), 100);
      }

      // Slaytlar tabını render et
      function renderSlidersTab(sliders, pagination, tabContent) {
        const tableBody = tabContent.querySelector('tbody');

        if (sliders.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-4"><p class="text-muted">Henüz slayt bulunmamaktadır.</p></td></tr>';
          return;
        }

        let html = '';
        sliders.forEach(slider => {
          html += `
            <tr>
              <td>${slider.id}</td>
              <td>
                <div class="tumhizmetlerimg">
                  <img src="${slider.image || '{{ asset('site/images/default-slider.jpg') }}'}" alt="${slider.title}">
                </div>
              </td>
              <td>
                <div class="tumhizmetler-name">
                  <h2>${slider.title}</h2>
                </div>
              </td>
              <td>${slider.order}</td>
              <td>
                <div class="tumhizmetler-status-new">
                  <div class="status-container">
                    <div class="status-dropdown-wrapper" data-slider-id="${slider.id}">
                      <div class="status-dropdown-btn">
                        <span class="status-indicator ${slider.status == 1 ? 'is-active' : 'is-inactive'}">
                          <span class="status-symbol">${slider.status == 1 ? '✓' : '⊖'}</span>
                          <span>${slider.status == 1 ? 'Aktif' : 'Pasif'}</span>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="olusturulma-tarihi">
                  <span>${slider.created_at}</span>
                </div>
              </td>
            </tr>
          `;
        });

        tableBody.innerHTML = html;

        const resultText = tabContent.querySelector('.search-results-text h4');
        if (resultText && pagination) {
          resultText.innerHTML = `Filtrelemenize uygun <b>${pagination.total}</b> slayt bulundu.`;
        }

        // Pagination render et
        renderPagination(pagination, tabContent, 'sliders');

        // Tarihleri restore et
        setTimeout(() => restoreSlidersDates(), 100);
      }

      // ============== PAGINATION ==============

      function renderPagination(pagination, tabContent, tabType) {
        const paginationContainer = tabContent.querySelector('#pagination-container');
        if (!paginationContainer || !pagination) return;

        const { current_page, last_page, from, to, total } = pagination;

        // Pagination yoksa (tek sayfa), container'ı gizle
        if (last_page <= 1) {
          paginationContainer.innerHTML = '';
          return;
        }

        // Pagination HTML'i oluştur
        let pagesHTML = '';

        // Önceki butonu
        const prevDisabled = current_page === 1;
        pagesHTML += `
          <li class="page-item ${prevDisabled ? 'disabled' : ''}" ${prevDisabled ? 'aria-disabled="true"' : ''}>
            ${prevDisabled
              ? '<span class="page-link" aria-hidden="true">‹</span>'
              : `<a class="page-link" href="#" data-page="${current_page - 1}" data-tab="${tabType}">‹</a>`
            }
          </li>
        `;

        // Sayfa numaraları
        let startPage = Math.max(1, current_page - 2);
        let endPage = Math.min(last_page, current_page + 2);

        if (current_page <= 3) {
          endPage = Math.min(5, last_page);
        }
        if (current_page >= last_page - 2) {
          startPage = Math.max(1, last_page - 4);
        }

        for (let i = startPage; i <= endPage; i++) {
          if (i === current_page) {
            pagesHTML += `<li class="page-item active" aria-current="page"><span class="page-link">${i}</span></li>`;
          } else {
            pagesHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${i}" data-tab="${tabType}">${i}</a></li>`;
          }
        }

        // Sonraki butonu
        const nextDisabled = current_page === last_page;
        pagesHTML += `
          <li class="page-item ${nextDisabled ? 'disabled' : ''}">
            ${nextDisabled
              ? '<span class="page-link" aria-hidden="true">›</span>'
              : `<a class="page-link" href="#" data-page="${current_page + 1}" data-tab="${tabType}">›</a>`
            }
          </li>
        `;

        // Pagination container'ı güncelle
        paginationContainer.innerHTML = `
          <nav class="d-flex justify-items-center justify-content-between">
            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
              <div>
                <ul class="pagination">
                  ${pagesHTML}
                </ul>
              </div>
            </div>
          </nav>
        `;

        // Pagination linklerine event listener ekle
        paginationContainer.querySelectorAll('.page-link[data-page]').forEach(link => {
          link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            const tab = this.getAttribute('data-tab');
            loadPageData(tab, page);
          });
        });
      }

      // Sayfa verilerini yükle
      function loadPageData(tabType, page) {
        let endpoint = '';
        let renderFunction = null;
        let tabContent = null;
        let formId = '';
        let colspan = 12;

        switch(tabType) {
          case 'ideas':
            endpoint = '{{ route('admin.analytics.ideas') }}';
            renderFunction = renderIdeasTab;
            tabContent = document.getElementById('pills-profile');
            formId = 'ideas-filter-form';
            colspan = 11;
            break;
          case 'companies':
            endpoint = '{{ route('admin.analytics.companies') }}';
            renderFunction = renderCompaniesTab;
            tabContent = document.getElementById('pills-contact');
            formId = 'companies-filter-form';
            colspan = 13;
            break;
          case 'users':
            endpoint = '{{ route('admin.analytics.users') }}';
            renderFunction = renderUsersTab;
            tabContent = document.getElementById('pills-contact2');
            formId = 'users-filter-form';
            colspan = 9;
            break;
          case 'sliders':
            endpoint = '{{ route('admin.analytics.sliders') }}';
            renderFunction = renderSlidersTab;
            tabContent = document.getElementById('pills-contact3');
            formId = 'sliders-filter-form';
            colspan = 6;
            break;
        }

        if (!endpoint || !renderFunction || !tabContent) return;

        // Form verilerini al - sadece dolu değerleri gönder
        const formData = new FormData(document.getElementById(formId));
        const params = new URLSearchParams();

        // Boş olmayan değerleri ekle
        for (let [key, value] of formData.entries()) {
          if (value !== null && value !== undefined && value.toString().trim() !== '') {
            params.append(key, value);
          }
        }
        params.set('page', page);

        // Loading göster
        const tableBody = tabContent.querySelector('tbody');
        if (tableBody) {
          tableBody.innerHTML = `<tr><td colspan="${colspan}" class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Yükleniyor...</span></div></td></tr>`;
        }

        // AJAX isteği
        fetch(`${endpoint}?${params.toString()}`)
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              renderFunction(data.data, data.pagination, tabContent);
            }
          })
          .catch(error => {
            console.error('Pagination error:', error);
            if (tableBody) {
              tableBody.innerHTML = `<tr><td colspan="${colspan}" class="text-center py-4 text-danger">Veri yüklenirken hata oluştu.</td></tr>`;
            }
          });
      }

      // ============== FILTER HANDLERS ==============

      // ===== FİKİRLER TAB FİLTRELEME =====
      const ideasFilterBtn = document.getElementById('ideas-filter-btn');
      const ideasClearBtn = document.getElementById('ideas-clear-btn');

      // Sıralama değişkenleri
      let ideasSortField = 'created_at';
      let ideasSortDirection = 'desc';

      // Sıralama header'larına click eventi ekle
      document.querySelectorAll('.ideas-sortable').forEach(header => {
        header.addEventListener('click', function(e) {
          e.preventDefault();
          const sortField = this.getAttribute('data-sort');

          // Aynı alana tıklanırsa direction'ı değiştir
          if (ideasSortField === sortField) {
            ideasSortDirection = ideasSortDirection === 'asc' ? 'desc' : 'asc';
          } else {
            ideasSortField = sortField;
            ideasSortDirection = 'desc';
          }

          // Tüm header'ların ikonlarını resetle
          document.querySelectorAll('.ideas-sortable i').forEach(icon => {
            icon.className = 'fa-solid fa-sort';
            icon.style.opacity = '0.4';
            icon.style.color = '';
          });

          // Aktif header'ın ikonunu güncelle
          const icon = this.querySelector('i');
          icon.className = `fa-solid fa-sort-${ideasSortDirection === 'asc' ? 'up' : 'down'}`;
          icon.style.opacity = '1';
          icon.style.color = '#007bff';

          // Filtre butonuna trigger et
          ideasFilterBtn.click();
        });
      });

      if (ideasFilterBtn) {
        ideasFilterBtn.addEventListener('click', function() {
          const search = document.getElementById('ideas-search')?.value || '';
          const categoryId = document.getElementById('ideas-category-id')?.value || '';
          const subCategoryId = document.getElementById('ideas-sub-category-id')?.value || '';
          const startDate = document.getElementById('ideas-start-date')?.value || '';
          const endDate = document.getElementById('ideas-end-date')?.value || '';
          const minViews = document.getElementById('ideas-views-min')?.value || '';
          const maxViews = document.getElementById('ideas-views-max')?.value || '';
          const minLikes = document.getElementById('ideas-likes-min')?.value || '';
          const maxLikes = document.getElementById('ideas-likes-max')?.value || '';
          const minReplies = document.getElementById('ideas-replies-min')?.value || '';
          const maxReplies = document.getElementById('ideas-replies-max')?.value || '';
          const status = document.getElementById('ideas-status')?.value || '';

          const params = new URLSearchParams();
          if (search) params.append('search', search);
          if (categoryId) params.append('category_id', categoryId);
          if (subCategoryId) params.append('sub_category_id', subCategoryId);
          if (startDate) params.append('start_date', startDate);
          if (endDate) params.append('end_date', endDate);
          if (minViews) params.append('view_min', minViews);
          if (maxViews) params.append('view_max', maxViews);
          if (minLikes) params.append('like_min', minLikes);
          if (maxLikes) params.append('like_max', maxLikes);
          if (minReplies) params.append('reply_min', minReplies);
          if (maxReplies) params.append('reply_max', maxReplies);
          if (status !== '') params.append('status', status);

          // Sıralama parametrelerini ekle
          params.append('sort', ideasSortField);
          params.append('direction', ideasSortDirection);

          const tabContent = document.getElementById('pills-profile');
          const loadingDiv = tabContent.querySelector('.loading-indicator');
          if (loadingDiv) loadingDiv.style.display = 'block';

          fetch(`{{ route('admin.analytics.ideas') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              if (data.success) {
                renderIdeasTab(data.data, data.pagination, tabContent);
              }
            })
            .catch(error => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              console.error('Filtreleme hatası:', error);
            });
        });
      }

      if (ideasClearBtn) {
        ideasClearBtn.addEventListener('click', function() {
          ['ideas-search', 'ideas-category-id', 'ideas-sub-category-id',
           'ideas-start-date', 'ideas-end-date', 'ideas-views-min',
           'ideas-views-max', 'ideas-likes-min', 'ideas-likes-max',
           'ideas-replies-min', 'ideas-replies-max', 'ideas-status'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
          });

          // Dropdown metinlerini sıfırla
          const categoryToggle = document.querySelector('[data-dropdown="dropdown7"]');
          if (categoryToggle) categoryToggle.textContent = 'Kategori';
          const statusToggle = document.querySelector('[data-dropdown="dropdown11"]');
          if (statusToggle) statusToggle.textContent = 'Durum';

          // Tarih seçici metni sıfırla
          const dateSelect = document.querySelector('.select-date-2 span');
          if (dateSelect) dateSelect.textContent = 'Tarih Seç';

          // Sıralama değişkenlerini resetle
          ideasSortField = 'created_at';
          ideasSortDirection = 'desc';

          // Tüm header ikonlarını resetle
          document.querySelectorAll('.ideas-sortable i').forEach(icon => {
            icon.className = 'fa-solid fa-sort';
            icon.style.opacity = '0.4';
            icon.style.color = '';
          });

          // Default data yükle
          loadTabData('pills-profile');
        });
      }

      // ===== FİRMALAR TAB FİLTRELEME =====
      const companiesFilterBtn = document.getElementById('companies-filter-btn');
      const companiesClearBtn = document.getElementById('companies-clear-btn');

      // Sıralama değişkenleri
      let companiesSortField = 'created_at';
      let companiesSortDirection = 'desc';

      // Sıralama header'larına click eventi ekle
      document.querySelectorAll('.companies-sortable').forEach(header => {
        header.addEventListener('click', function(e) {
          e.preventDefault();
          const sortField = this.getAttribute('data-sort');

          // Aynı alana tıklanırsa direction'ı değiştir
          if (companiesSortField === sortField) {
            companiesSortDirection = companiesSortDirection === 'asc' ? 'desc' : 'asc';
          } else {
            companiesSortField = sortField;
            companiesSortDirection = 'desc';
          }

          // Tüm header'ların ikonlarını resetle
          document.querySelectorAll('.companies-sortable i').forEach(icon => {
            icon.className = 'fa-solid fa-sort';
            icon.style.opacity = '0.4';
            icon.style.color = '';
          });

          // Aktif header'ın ikonunu güncelle
          const icon = this.querySelector('i');
          icon.className = `fa-solid fa-sort-${companiesSortDirection === 'asc' ? 'up' : 'down'}`;
          icon.style.opacity = '1';
          icon.style.color = '#007bff';

          // Filtre butonuna trigger et
          companiesFilterBtn.click();
        });
      });

      if (companiesFilterBtn) {
        companiesFilterBtn.addEventListener('click', function() {
          const search = document.getElementById('companies-search')?.value || '';
          const categoryId = document.getElementById('companies-category-id')?.value || '';
          const subCategoryId = document.getElementById('companies-sub-category-id')?.value || '';
          const startDate = document.getElementById('companies-start-date')?.value || '';
          const endDate = document.getElementById('companies-end-date')?.value || '';
          const minViews = document.getElementById('companies-min-views')?.value || '';
          const maxViews = document.getElementById('companies-max-views')?.value || '';
          const provinceId = document.getElementById('companies-province-id')?.value || '';
          const districtId = document.getElementById('companies-district-id')?.value || '';
          const status = document.getElementById('companies-status')?.value || '';
          const isPro = document.getElementById('companies-is-pro')?.value || '';

          const params = new URLSearchParams();
          if (search) params.append('search', search);
          if (categoryId) params.append('category_id', categoryId);
          if (subCategoryId) params.append('sub_category_id', subCategoryId);
          if (startDate) params.append('start_date', startDate);
          if (endDate) params.append('end_date', endDate);
          if (minViews) params.append('view_min', minViews);
          if (maxViews) params.append('view_max', maxViews);
          if (provinceId) params.append('province_id', provinceId);
          if (districtId) params.append('district_id', districtId);
          if (status !== '') params.append('status', status);
          if (isPro !== '') params.append('is_pro', isPro);

          // Sıralama parametrelerini ekle
          params.append('sort', companiesSortField);
          params.append('direction', companiesSortDirection);

          const tabContent = document.getElementById('pills-contact');
          const loadingDiv = tabContent.querySelector('.loading-indicator');
          if (loadingDiv) loadingDiv.style.display = 'block';

          fetch(`{{ route('admin.analytics.companies') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              if (data.success) {
                renderCompaniesTab(data.data, data.pagination, tabContent);
              }
            })
            .catch(error => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              console.error('Filtreleme hatası:', error);
            });
        });
      }

      if (companiesClearBtn) {
        companiesClearBtn.addEventListener('click', function() {
          ['companies-search', 'companies-category-id', 'companies-sub-category-id',
           'companies-start-date', 'companies-end-date', 'companies-min-views',
           'companies-max-views', 'companies-province-id', 'companies-district-id',
           'companies-status', 'companies-is-pro'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
          });

          // Dropdown metinlerini sıfırla
          const categoryToggle = document.querySelector('[data-dropdown="dropdown12"]');
          if (categoryToggle) categoryToggle.textContent = 'Kategori';
          const subCategoryToggle = document.querySelector('[data-dropdown="dropdown13"]');
          if (subCategoryToggle) subCategoryToggle.textContent = 'Alt Kategori';
          const provinceToggle = document.querySelector('[data-dropdown="dropdown15"]');
          if (provinceToggle) provinceToggle.textContent = 'İl';
          const districtToggle = document.querySelector('[data-dropdown="dropdown16"]');
          if (districtToggle) districtToggle.textContent = 'İlçe';
          const statusToggle = document.querySelector('[data-dropdown="dropdown14"]');
          if (statusToggle) statusToggle.textContent = 'Durum';
          const proToggle = document.querySelector('[data-dropdown="dropdown17"]');
          if (proToggle) proToggle.textContent = 'Pro Üyelik';

          // Tarih seçici metni sıfırla
          const dateSelect = document.querySelector('.select-date-4 span');
          if (dateSelect) dateSelect.textContent = 'Tarih Seç';

          // Default data yükle
          loadTabData('pills-contact');
        });
      }

      // ===== BİREYSEL ÜYE TAB FİLTRELEME =====
      const usersFilterBtn = document.getElementById('users-filter-btn');
      const usersClearBtn = document.getElementById('users-clear-btn');

      // Sıralama değişkenleri
      let usersSortField = 'created_at';
      let usersSortDirection = 'desc';

      // Sıralama header'larına click eventi ekle
      document.querySelectorAll('.users-sortable').forEach(header => {
        header.addEventListener('click', function(e) {
          e.preventDefault();
          const sortField = this.getAttribute('data-sort');

          // Aynı alana tıklanırsa direction'ı değiştir
          if (usersSortField === sortField) {
            usersSortDirection = usersSortDirection === 'asc' ? 'desc' : 'asc';
          } else {
            usersSortField = sortField;
            usersSortDirection = 'desc';
          }

          // Tüm header'ların ikonlarını resetle
          document.querySelectorAll('.users-sortable i').forEach(icon => {
            icon.className = 'fa-solid fa-sort';
            icon.style.opacity = '0.4';
            icon.style.color = '';
          });

          // Aktif header'ın ikonunu güncelle
          const icon = this.querySelector('i');
          icon.className = `fa-solid fa-sort-${usersSortDirection === 'asc' ? 'up' : 'down'}`;
          icon.style.opacity = '1';
          icon.style.color = '#007bff';

          // Filtre butonuna trigger et
          usersFilterBtn.click();
        });
      });

      if (usersFilterBtn) {
        usersFilterBtn.addEventListener('click', function() {
          const search = document.getElementById('users-search')?.value || '';
          const categoryId = document.getElementById('users-category-id')?.value || '';
          const subCategoryId = document.getElementById('users-sub-category-id')?.value || '';
          const startDate = document.getElementById('users-start-date')?.value || '';
          const endDate = document.getElementById('users-end-date')?.value || '';
          const status = document.getElementById('users-status')?.value || '';

          const params = new URLSearchParams();
          if (search) params.append('search', search);
          if (categoryId) params.append('category_id', categoryId);
          if (subCategoryId) params.append('sub_category_id', subCategoryId);
          if (startDate) params.append('start_date', startDate);
          if (endDate) params.append('end_date', endDate);
          if (status !== '') params.append('status', status);

          // Sıralama parametrelerini ekle
          params.append('sort', usersSortField);
          params.append('direction', usersSortDirection);

          const tabContent = document.getElementById('pills-contact2');
          const loadingDiv = tabContent.querySelector('.loading-indicator');
          if (loadingDiv) loadingDiv.style.display = 'block';

          fetch(`{{ route('admin.analytics.users') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              if (data.success) {
                renderUsersTab(data.data, data.pagination, tabContent);
              }
            })
            .catch(error => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              console.error('Filtreleme hatası:', error);
            });
        });
      }

      if (usersClearBtn) {
        usersClearBtn.addEventListener('click', function() {
          ['users-search', 'users-category-id', 'users-sub-category-id',
           'users-start-date', 'users-end-date', 'users-status'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
          });

          // Dropdown metinlerini sıfırla
          const categoryToggle = document.querySelector('[data-dropdown="dropdown20"]');
          if (categoryToggle) categoryToggle.textContent = 'Kategori';
          const subCategoryToggle = document.querySelector('[data-dropdown="dropdown21"]');
          if (subCategoryToggle) subCategoryToggle.textContent = 'Alt Kategori';
          const statusToggle = document.querySelector('[data-dropdown="dropdown22"]');
          if (statusToggle) statusToggle.textContent = 'Durum';

          // Tarih seçici metni sıfırla
          const dateSelect = document.querySelector('.select-date-5 span');
          if (dateSelect) dateSelect.textContent = 'Tarih Seç';

          // Default data yükle
          loadTabData('pills-contact2');
        });
      }

      // ===== SLAYTLAR TAB FİLTRELEME =====
      const slidersFilterBtn = document.getElementById('sliders-filter-btn');
      const slidersClearBtn = document.getElementById('sliders-clear-btn');

      if (slidersFilterBtn) {
        slidersFilterBtn.addEventListener('click', function() {
          const search = document.getElementById('sliders-search')?.value || '';
          const startDate = document.getElementById('sliders-start-date')?.value || '';
          const endDate = document.getElementById('sliders-end-date')?.value || '';
          const status = document.getElementById('sliders-status')?.value || '';

          const params = new URLSearchParams();
          if (search) params.append('search', search);
          if (startDate) params.append('start_date', startDate);
          if (endDate) params.append('end_date', endDate);
          if (status !== '') params.append('status', status);

          const tabContent = document.getElementById('pills-contact3');
          const loadingDiv = tabContent.querySelector('.loading-indicator');
          if (loadingDiv) loadingDiv.style.display = 'block';

          fetch(`{{ route('admin.analytics.sliders') }}?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              if (data.success) {
                renderSlidersTab(data.data, data.pagination, tabContent);
              }
            })
            .catch(error => {
              if (loadingDiv) loadingDiv.style.display = 'none';
              console.error('Filtreleme hatası:', error);
            });
        });
      }

      if (slidersClearBtn) {
        slidersClearBtn.addEventListener('click', function() {
          ['sliders-search', 'sliders-start-date', 'sliders-end-date', 'sliders-status'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
          });

          // Dropdown metnini sıfırla
          const statusToggle = document.querySelector('[data-dropdown="dropdown25"]');
          if (statusToggle) statusToggle.textContent = 'Durum';

          // Tarih seçici metni sıfırla
          const dateSelect = document.querySelector('.select-date-6 span');
          if (dateSelect) dateSelect.textContent = 'Tarih Seç';

          // Default data yükle
          loadTabData('pills-contact3');
        });
      }

      // ===== HİZMETLER FORM SUBMIT (Boş alanları temizle) =====
      const servicesForm = document.getElementById('services-filter-form');
      if (servicesForm) {
        servicesForm.addEventListener('submit', function(e) {
          // Boş inputları disabled yap ki URL'ye eklenmesin
          const inputs = this.querySelectorAll('input[type="text"], input[type="hidden"]');
          inputs.forEach(input => {
            if (!input.value || input.value.trim() === '') {
              input.disabled = true;
            }
          });
          // Form submit edilecek, disabled alanlar URL'ye eklenmeyecek
        });
      }

      // Temizle butonuna tıklandığında disabled alanları enable et
      const servicesClearBtn = document.getElementById('services-clear-btn');
      if (servicesClearBtn) {
        servicesClearBtn.addEventListener('click', function() {
          // Tüm disabled inputları enable et
          const inputs = servicesForm.querySelectorAll('input[disabled]');
          inputs.forEach(input => {
            input.disabled = false;
          });
        });
      }

    });
  </script> @endsection