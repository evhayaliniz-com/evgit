@extends('site.inc.master')

@section('css')
<style>
    .main.sidebar {
        padding-left: 0;
    }

    .payment-section {
        background: #f8f9fa;
        min-height: 100vh;
    }

    .payment-info-area {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .payment-info-area h5 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    .payment-info-area .price {
        font-size: 2rem;
        font-weight: 700;
        color: #007bff;
    }

    .payment-info-area ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .payment-info-area ul li {
        padding: 15px 0;
    }

    .payment-info-area ul li h6 {
        margin: 0;
        font-size: 1rem;
        color: #666;
    }

    .payment-form {
        background: #fff;
        border-radius: 12px;
        padding: 35px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }

    .payment-form h5 {
        font-size: 1.5rem;
        margin-bottom: 25px;
        color: #333;
        font-weight: 600;
    }

    /* CRITICAL: Override site/css/main.css - Label'ları input'un üstüne koy */
    .payment-form #payment-form .form-group,
    .payment-form form#payment-form .form-group,
    #payment-form .form-group {
        position: relative !important;
        height: auto !important;
        min-height: auto !important;
    }

    .payment-form #payment-form .form-group label.form-label,
    .payment-form form#payment-form .form-group label.form-label,
    .payment-form .form-group label.form-label,
    #payment-form .form-group label.form-label,
    form#payment-form .form-group label.form-label,
    .payment-form #payment-form .form-group label,
    .payment-form form#payment-form .form-group label,
    #payment-form .form-group label {
        display: block !important;
        margin: 0 0 10px 0 !important;
        padding: 0 !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
        color: #333 !important;
        line-height: 1.5 !important;
        width: 100% !important;
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        -webkit-transform: none !important;
        -ms-transform: none !important;
        pointer-events: auto !important;
        float: none !important;
        clear: both !important;
    }

    /* CRITICAL: Override site/css/main.css - Input stillerini düzelt */
    .payment-form #payment-form .form-group input.form-control,
    .payment-form #payment-form .form-group select.form-control,
    .payment-form form#payment-form .form-group input.form-control,
    .payment-form form#payment-form .form-group select.form-control,
    #payment-form .form-group input.form-control,
    #payment-form .form-group select.form-control,
    form#payment-form .form-group input.form-control,
    form#payment-form .form-group select.form-control,
    .payment-form #payment-form .form-group input,
    .payment-form #payment-form .form-group select,
    #payment-form .form-group input,
    #payment-form .form-group select {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 12px 15px !important;
        padding-left: 15px !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        font-size: 16px !important;
        height: 48px !important;
        box-sizing: border-box !important;
        background: #fff !important;
        color: #333 !important;
        font-family: inherit !important;
        position: relative !important;
        top: auto !important;
        left: auto !important;
    }

    /* Form Group */
    .payment-form #payment-form .form-group,
    .payment-form form#payment-form .form-group,
    #payment-form .form-group {
        margin-bottom: 24px !important;
        display: block !important;
    }

    #payment-form .form-control:focus {
        outline: none !important;
        border-color: #007bff !important;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1) !important;
    }

    #payment-form .form-control::placeholder {
        color: #999 !important;
    }

    #payment-form select.form-control {
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 15px center !important;
        padding-right: 40px !important;
    }

    /* Card Row Layout */
    #payment-form .card-row,
    form#payment-form .card-row,
    .payment-form #payment-form .card-row {
        display: flex !important;
        gap: 15px !important;
        align-items: flex-start !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    #payment-form .card-row .form-group,
    form#payment-form .card-row .form-group,
    .payment-form #payment-form .card-row .form-group {
        flex: 1 1 auto !important;
        margin-bottom: 24px !important;
        display: block !important;
    }

    /* Card row labels must be above - Override main.css */
    .payment-form #payment-form .card-row .form-group {
        position: relative !important;
        height: auto !important;
        min-height: auto !important;
    }

    .payment-form #payment-form .card-row .form-group label.form-label,
    .payment-form form#payment-form .card-row .form-group label.form-label,
    .payment-form .card-row .form-group label.form-label,
    #payment-form .card-row .form-group label.form-label,
    form#payment-form .card-row .form-group label.form-label,
    .payment-form #payment-form .card-row .form-group label,
    #payment-form .card-row .form-group label {
        display: block !important;
        margin: 0 0 10px 0 !important;
        padding: 0 !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
        color: #333 !important;
        line-height: 1.5 !important;
        width: 100% !important;
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        -webkit-transform: none !important;
        -ms-transform: none !important;
        pointer-events: auto !important;
        float: none !important;
        clear: both !important;
    }

    /* Expiry Inputs */
    #payment-form .expiry-inputs,
    form#payment-form .expiry-inputs,
    .payment-form #payment-form .expiry-inputs {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        height: 48px !important;
        margin: 0 !important;
        margin-top: 0 !important;
        padding: 0 !important;
        position: relative !important;
        z-index: 0 !important;
    }

    #payment-form .expiry-inputs .form-control {
        flex: 1 1 auto !important;
        height: 48px !important;
        padding: 12px !important;
        text-align: center !important;
    }

    #payment-form .expiry-separator {
        font-size: 1.5rem !important;
        color: #666 !important;
        font-weight: 400 !important;
        line-height: 48px !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-shrink: 0 !important;
    }

    /* Checkbox Form Group - Override main.css */
    .payment-form #payment-form .form-group.checkbox-group,
    #payment-form .form-group.checkbox-group,
    .payment-form .form-group.checkbox-group {
        position: relative !important;
        height: auto !important;
        min-height: auto !important;
    }

    /* Checkbox Label - Override main.css completely */
    .payment-form #payment-form .form-group label.checkbox-label,
    .payment-form form#payment-form .form-group label.checkbox-label,
    #payment-form .form-group label.checkbox-label,
    form#payment-form .form-group label.checkbox-label,
    .payment-form .form-group label.checkbox-label,
    .payment-form #payment-form .checkbox-group label.checkbox-label,
    #payment-form .checkbox-group label.checkbox-label {
        display: flex !important;
        align-items: center !important;
        cursor: pointer !important;
        padding: 12px !important;
        border-radius: 6px !important;
        margin: 0 !important;
        transition: background 0.2s !important;
        position: static !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        -webkit-transform: none !important;
        -ms-transform: none !important;
        pointer-events: auto !important;
        width: 100% !important;
        height: auto !important;
        min-height: auto !important;
        z-index: 10 !important;
        user-select: none !important;
    }

    .payment-form #payment-form .form-group label.checkbox-label:hover,
    #payment-form .form-group label.checkbox-label:hover {
        background: #f8f9fa !important;
    }

    /* Kayıtlı Kartlar */
    .saved-card-info {
        background: #f8f9fa !important;
        border-radius: 8px !important;
        padding: 20px !important;
        margin-bottom: 20px !important;
        border: 1px solid #e0e0e0 !important;
    }

    .saved-card-info p {
        margin: 0 0 15px 0 !important;
        font-size: 1rem !important;
        color: #333 !important;
    }

    .saved-card-info p strong {
        font-size: 1.1rem !important;
        color: #333 !important;
    }

    .saved-cards-list {
        margin-top: 15px !important;
    }

    .saved-card-item {
        margin-bottom: 12px !important;
    }

    .saved-card-item:last-child {
        margin-bottom: 0 !important;
    }

    .saved-card-label {
        display: flex !important;
        align-items: center !important;
        padding: 14px 16px !important;
        border: 2px solid #e0e0e0 !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        transition: all 0.2s ease !important;
        background: #fff !important;
        margin: 0 !important;
        width: 100% !important;
    }

    .saved-card-label:hover {
        border-color: #007bff !important;
        background: #f0f7ff !important;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.1) !important;
    }

    .saved-card-label input[type="radio"]:checked~.card-info {
        color: #007bff !important;
    }

    /* Radio seçildiğinde parent label'ı vurgula (JavaScript ile class ekleyeceğiz) */
    .saved-card-label.selected {
        border-color: #007bff !important;
        background: #e7f3ff !important;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15) !important;
    }

    .saved-card-label input[type="radio"] {
        margin-right: 14px !important;
        width: 20px !important;
        height: 20px !important;
        min-width: 20px !important;
        min-height: 20px !important;
        cursor: pointer !important;
        accent-color: #007bff !important;
        flex-shrink: 0 !important;
    }

    .saved-card-label input[type="radio"]:checked+.card-info {
        color: #007bff !important;
    }

    .saved-card-label input[type="radio"]:checked+.card-info strong {
        color: #007bff !important;
        font-weight: 600 !important;
    }

    .card-info {
        flex: 1 !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
    }

    .card-info strong {
        font-size: 1rem !important;
        color: #333 !important;
        font-weight: 500 !important;
    }

    .card-info small {
        color: #666 !important;
        font-size: 0.9rem !important;
        margin-left: 4px !important;
    }

    /* Kayıtlı kart seçildiğinde yeni kart bilgilerini gizle - TAMAMEN CSS TABANLI (JavaScript gerekmez) */
    /* :has() selector'ü ile radio button'un :checked durumuna göre gizleme */
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper,
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper *,
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper input,
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper select,
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper label,
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper .form-group {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        max-height: 0 !important;
        min-height: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
        position: absolute !important;
        left: -9999px !important;
        width: 0 !important;
        max-width: 0 !important;
        pointer-events: none !important;
    }

    /* Kayıtlı kart seçildiğinde input'ları disabled yap (form submit koruması) */
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper input[type="text"],
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper input[type="checkbox"],
    body:has(input[name="payment_method"][value="saved_card"]:checked) #new-card-details-wrapper select {
        pointer-events: none !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
    }

    /* Yeni kart seçildiğinde wrapper'ı göster */
    body:has(input[name="payment_method"][value="new_card"]:checked) #new-card-details-wrapper,
    body:not(:has(input[name="payment_method"][value="saved_card"]:checked)) #new-card-details-wrapper {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
        max-height: none !important;
        min-height: auto !important;
        overflow: visible !important;
        margin: inherit !important;
        padding: inherit !important;
        border: inherit !important;
        position: static !important;
        left: auto !important;
        width: 100% !important;
        max-width: 100% !important;
        pointer-events: auto !important;
    }

    /* Fallback: Eski tarayıcılar için class tabanlı çözüm (JavaScript ile class eklenirse) */
    body .hide-new-card-details #new-card-details-wrapper,
    body .hide-new-card-details #new-card-details-wrapper * {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
        pointer-events: none !important;
    }

    .payment-form #payment-form .form-group label.checkbox-label input[type="checkbox"],
    #payment-form .form-group label.checkbox-label input[type="checkbox"],
    .payment-form .form-group label.checkbox-label input[type="checkbox"],
    .payment-form #payment-form .checkbox-group label.checkbox-label input[type="checkbox"],
    #payment-form .checkbox-group label.checkbox-label input[type="checkbox"] {
        margin: 0 10px 0 0 !important;
        width: 20px !important;
        height: 20px !important;
        min-width: 20px !important;
        min-height: 20px !important;
        cursor: pointer !important;
        accent-color: #007bff !important;
        flex-shrink: 0 !important;
        position: relative !important;
        top: auto !important;
        left: auto !important;
        opacity: 1 !important;
        pointer-events: auto !important;
        z-index: 999 !important;
        -webkit-appearance: checkbox !important;
        -moz-appearance: checkbox !important;
        appearance: checkbox !important;
    }

    .payment-form #payment-form .form-group label.checkbox-label span,
    #payment-form .form-group label.checkbox-label span,
    .payment-form .form-group label.checkbox-label span {
        color: #333 !important;
        font-size: 0.95rem !important;
        line-height: 1.5 !important;
        margin: 0 !important;
        padding: 0 !important;
        position: static !important;
        flex: 1 !important;
    }

    .btn-payment {
        width: 100%;
        padding: 16px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
    }

    .btn-payment:hover {
        background: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    .btn-payment:active {
        transform: translateY(0);
    }

    .btn-payment:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Buton her zaman görünür olmalı - kayıtlı kart seçildiğinde bile */
    #payment-btn,
    .btn-payment,
    button.btn-payment,
    button#payment-btn,
    form#payment-form button.btn-payment,
    form#payment-form #payment-btn,
    .payment-form button.btn-payment,
    .payment-form #payment-btn,
    form button.btn-payment,
    form #payment-btn {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
        max-height: none !important;
        min-height: auto !important;
        overflow: visible !important;
        margin-top: 20px !important;
        padding: 16px !important;
        position: static !important;
        left: auto !important;
        width: 100% !important;
        max-width: 100% !important;
        pointer-events: auto !important;
        background: #007bff !important;
        color: #fff !important;
        border: none !important;
        border-radius: 6px !important;
        font-size: 18px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
    }

    /* Butonun parent element'lerini de görünür yap */
    form#payment-form,
    .payment-form,
    form#payment-form>* {
        display: block !important;
        visibility: visible !important;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .saved-card-info {
        background: #e7f3ff;
        padding: 15px 20px;
        border-radius: 6px;
        margin-bottom: 25px;
        border: 1px solid #b3d9ff;
    }

    .saved-card-info p {
        margin: 0;
        color: #004085;
        font-size: 0.95rem;
    }

    .saved-card-info p:first-child {
        font-weight: 600;
        margin-bottom: 5px;
    }


    .pro-paketler-bottom-right {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
    }

    .pro-paketler-bottom-right p {
        margin: 0;
        line-height: 1.6;
        color: #666;
    }

    .pro-paketler-bottom-right a {
        color: #007bff;
        text-decoration: none;
    }

    .pro-paketler-bottom-right a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .payment-section {
            padding: 20px 15px !important;
        }

        .payment-info-area,
        .payment-form {
            padding: 25px;
        }

        #payment-form .card-row {
            flex-direction: column !important;
            gap: 0 !important;
        }

        #payment-form .card-row .form-group {
            margin-bottom: 24px !important;
        }

        #payment-form .expiry-inputs {
            gap: 8px !important;
        }
    }

    @media (max-width: 576px) {

        .payment-info-area h5,
        .payment-form h5 {
            font-size: 1.25rem;
        }

        .payment-info-area .price {
            font-size: 1.5rem;
        }

        .payment-info-area,
        .payment-form {
            padding: 20px;
        }

        .btn-payment {
            font-size: 16px;
            padding: 14px;
        }
    }
</style>
@endsection

@section('content')
<div class="main sidebar">
    <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0 p-5 payment-section" id="index-right-area">
        <div class="row justify-content-center pt-5">
            <!-- Sol Sütun: Abonelik Detayları -->
            <div class="col-lg-5 col-md-6 col-12 mb-4 mb-lg-0">
                <div class="payment-info-area">
                    <h5 class="fw-bold">{{$package->title}} ürününe abone oluyorsunuz.</h5>

                    <p class="border-bottom pt-1 pb-4 mb-3">
                        <b class="price text-dark">&#8378;{{ number_format($price, 0, ',', '.') }}</b>
                        <span> / {{$packageType == 1 ? 'yıl' : 'ay'}}</span>
                        <span class="d-block mt-2" style="color: #666; font-size: 0.9rem;">
                            {{$packageType == 1 ? 'Yıllık' : 'Aylık'}} olarak faturalandırılır
                        </span>
                    </p>

                    <ul>
                        <li class="d-flex justify-content-between mb-4 px-3">
                            <div>
                                <h6 style="font-size: 1.1rem; font-weight: 600; color: #333;">{{$package->title}}</h6>
                                <span style="color: #666; font-size: 0.9rem;">
                                    {{$packageType == 1 ? 'Yıllık' : 'Aylık'}} olarak faturalandırılır.
                                </span>
                            </div>
                            <span class="price" style="font-size: 1.1rem; color: #333;">{{ number_format($price, 0, ',', '.') }}TL</span>
                        </li>

                        @php
                            // Toplam fiyata KDV dahil (KDV %20)
                            $priceWithoutVat = $price / 1.20; // KDV hariç fiyat
                            $vatAmount = $price - $priceWithoutVat; // KDV tutarı
                        @endphp

                        <li class="d-flex justify-content-between mb-3 px-3">
                            <h6 style="color: #666;">Ara Toplam (KDV Hariç)</h6>
                            <span class="price" style="font-size: 1rem; color: #333;">{{ number_format($priceWithoutVat, 2, ',', '.') }}TL</span>
                        </li>

                        <li class="d-flex justify-content-between mb-4 pb-2 border-bottom px-3">
                            <h6 style="color: #666;">KDV (%20)</h6>
                            <span class="price" style="font-size: 1rem; color: #333;">{{ number_format($vatAmount, 2, ',', '.') }}TL</span>
                        </li>

                        <li class="d-flex justify-content-between px-3 pt-2">
                            <h6 style="font-weight: 600; color: #333;">Toplam Tutar (KDV Dahil)</h6>
                            <span class="price" style="font-size: 1.2rem; font-weight: 700; color: #007bff;">{{ number_format($price, 2, ',', '.') }}TL</span>
                        </li>
                    </ul>
                </div>

                <div class="pro-paketler-bottom-right w-100">
                    <div class="ppbr-text">
                        <p style="font-size: 0.9rem;">
                            Abone olarak <a href="#">Alıcı Hizmet Şartları</a> şartlarımızı kabul etmiş
                            olursun. Abonelikler, iptal edilene kadar otomatik olarak yenilenir. Ek ücretleri
                            önlemek için yenileme işlemlerinden en az 24 saat önce
                            <a href="#">Dilediğin zaman iptal et.</a> Aboneliğini;
                            abone olduğun platform üzerinden yönet.
                        </p>
                        
                        <div class="mt-3" style="display: flex; align-items: flex-start; gap: 10px;">
                            <input type="checkbox" name="contract_accepted" id="contract_accepted" form="payment-form" required style="width: 18px; height: 18px; margin-top: 2px; cursor: pointer; flex-shrink: 0;">
                            <label for="contract_accepted" style="font-size: 0.9rem; cursor: pointer; margin: 0;">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#contractModal" style="color: #007bff; text-decoration: underline;">Mesafeli Hizmet Sözleşmesi</a>'ni okudum, kabul ediyorum.
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ Sütun: Ödeme Formu -->
            <div class="col-lg-5 col-md-6 col-12">
                <div class="payment-form">
                    <h5 class="mb-4">Ödeme Bilgileri</h5>

                    <div id="payment-alert"></div>

                    @if($hasSavedCard && !empty($savedCards))
                    <div class="saved-card-info mb-4">
                        <p><strong>Kayıtlı Kartlarınız</strong></p>
                        <div class="saved-cards-list">
                            @foreach($savedCards as $index => $card)
                            <div class="saved-card-item" data-utoken="{{auth()->user()->company->utoken ?? ''}}" data-ctoken="{{$card['ctoken'] ?? ''}}">
                                <label class="saved-card-label">
                                    <input type="radio" name="payment_method" value="saved_card" data-card-index="{{$index}}" class="payment-method-radio" {{$index === 0 ? 'checked' : ''}}>
                                    <span class="card-info">
                                        <strong>{{$card['c_bank'] ?? $card['c_brand'] ?? $card['schema'] ?? 'Kart'}}</strong>
                                        •••• {{$card['last_4'] ?? '****'}}
                                        @if(!empty($card['c_name']))
                                        <small>({{$card['c_name']}})</small>
                                        @endif
                                    </span>
                                </label>
                            </div>
                            @endforeach
                            <div class="saved-card-item">
                                <label class="saved-card-label">
                                    <input type="radio" name="payment_method" value="new_card" class="payment-method-radio">
                                    <span class="card-info">Yeni Kart Bilgileri Gir</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @elseif($hasSavedCard)
                    <div class="saved-card-info">
                        <p><strong>Kayıtlı Kartınız Var</strong></p>
                        <p>Kayıtlı kartınızla ödeme yapabilir veya yeni kart bilgileri girebilirsiniz.</p>
                    </div>
                    @endif

                    <form id="payment-form" method="POST" action="https://www.paytr.com/odeme" onsubmit="
                        var selectedMethod = document.querySelector('input[name=\'payment_method\']:checked');
                        if (selectedMethod && selectedMethod.value === 'saved_card') {
                            var form = document.getElementById('payment-form');
                            
                            // PayTR dokümantasyonuna göre: Kayıtlı kart ile ödeme için sadece utoken, ctoken, installment_count gönderilmeli
                            // Kart bilgileri (expiry_month, card_number, vb.) gönderilmemeli
                            
                            // KRİTİK: TÜM kart bilgilerini kaldır - querySelectorAll ile (gizli olsa bile)
                            var cardFieldsToRemove = ['card_number', 'expiry_month', 'expiry_year', 'cvv', 'cc_owner', 'store_card'];
                            for (var j = 0; j < cardFieldsToRemove.length; j++) {
                                var fieldName = cardFieldsToRemove[j];
                                // Form içinde TÜM eşleşen elementleri bul ve kaldır
                                var fields = form.querySelectorAll('input[name=\'' + fieldName + '\'], select[name=\'' + fieldName + '\']');
                                for (var k = 0; k < fields.length; k++) {
                                    fields[k].removeAttribute('name');
                                    fields[k].removeAttribute('required');
                                    fields[k].setAttribute('disabled', 'disabled');
                                    fields[k].value = '';
                                }
                                // Document genelinde de ara
                                var docFields = document.querySelectorAll('input[name=\'' + fieldName + '\'], select[name=\'' + fieldName + '\']');
                                for (var k = 0; k < docFields.length; k++) {
                                    docFields[k].removeAttribute('name');
                                    docFields[k].removeAttribute('required');
                                    docFields[k].setAttribute('disabled', 'disabled');
                                    docFields[k].value = '';
                                }
                            }
                            
                            // Installment count select'ini kaldır
                            var installmentSelects = form.querySelectorAll('select[name=\'installment_count\']');
                            for (var i = 0; i < installmentSelects.length; i++) {
                                installmentSelects[i].removeAttribute('name');
                                installmentSelects[i].setAttribute('disabled', 'disabled');
                            }
                            
                            // Son kontrol: TÜM input ve select'leri kontrol et
                            var allInputs = form.querySelectorAll('input, select');
                            var allowedNames = ['merchant_id', 'user_ip', 'merchant_oid', 'email', 'payment_amount', 'paytr_token', 'user_basket', 'payment_type', 'currency', 'test_mode', 'non_3d', 'user_name', 'user_address', 'user_phone', 'merchant_ok_url', 'merchant_fail_url', 'timeout_limit', 'lang', 'card_type', 'debug_on', 'utoken', 'ctoken', 'installment_count'];
                            
                            for (var i = 0; i < allInputs.length; i++) {
                                var el = allInputs[i];
                                var name = el.getAttribute('name');
                                if (name && allowedNames.indexOf(name) === -1) {
                                    el.removeAttribute('name');
                                    el.removeAttribute('required');
                                    el.setAttribute('disabled', 'disabled');
                                    if (el.tagName === 'INPUT' || el.tagName === 'SELECT') {
                                        el.value = '';
                                    }
                                }
                            }
                            
                            var cardItem = selectedMethod.closest('.saved-card-item');
                            var ctoken = cardItem ? cardItem.getAttribute('data-ctoken') : '';
                            var utoken = cardItem ? cardItem.getAttribute('data-utoken') : '';
                            var merchantOid = form.querySelector('[name=\'merchant_oid\']') ? form.querySelector('[name=\'merchant_oid\']').value : '';
                            
                            if (ctoken) {
                                var ctokenInput = document.createElement('input');
                                ctokenInput.type = 'hidden';
                                ctokenInput.name = 'ctoken';
                                ctokenInput.value = ctoken;
                                form.appendChild(ctokenInput);
                            }
                            
                            // Installment count hidden input ekle
                            var installmentValue = '0';
                            var existingInstallmentInput = form.querySelector('input[type=\'hidden\'][name=\'installment_count\']');
                            if (existingInstallmentInput) {
                                existingInstallmentInput.value = installmentValue;
                            } else {
                                var installmentInput = document.createElement('input');
                                installmentInput.type = 'hidden';
                                installmentInput.name = 'installment_count';
                                installmentInput.value = installmentValue;
                                form.appendChild(installmentInput);
                            }

                            var non3dInput = form.querySelector('[name=\'non_3d\']');
                            if (non3dInput) {
                                non3dInput.value = '0';
                            }
                            
                            // Kayıtlı kart için backend'den hesaplanmış token'ı kullan
                            var tokenInput = form.querySelector('[name=\'paytr_token\']');
                            if (tokenInput) {
                                tokenInput.value = '{{$paytr_token}}';
                            }
                            
                            return true;
                        } else {
                        var utokenEl=document.getElementById('selected_utoken');
                        if (utokenEl) {
                        utokenEl.removeAttribute('name');
                        }
                        var cardNumber=document.querySelector('[name=\'card_number\']');
                        if (cardNumber && cardNumber.value.trim()==='' ) {
                        alert('Lütfen kart numarası giriniz');
                        return false;
                        }
                        if (cardNumber) {
                        cardNumber.value=cardNumber.value.replace(/\s/g, '' );
                        }
                        var expiryMonth=document.querySelector('[name=\'expiry_month\']');
                        if (expiryMonth && expiryMonth.value.trim()==='' ) {
                        alert('Lütfen son kullanma ayını giriniz');
                        return false;
                        }
                        var expiryYear=document.querySelector('[name=\'expiry_year\']');
                        if (expiryYear && expiryYear.value.trim()==='' ) {
                        alert('Lütfen son kullanma yılını giriniz');
                        return false;
                        }
                        if (expiryYear && expiryYear.value.length===2) {
                        var currentYear=new Date().getFullYear();
                        var century=Math.floor(currentYear / 100);
                        var year=parseInt(expiryYear.value);
                        if (year < 50) {
                        expiryYear.value=(century * 100 + year).toString();
                        } else {
                        expiryYear.value=((century - 1) * 100 + year).toString();
                        }
                        }
                        var cvv=document.querySelector('[name=\'cvv\']');
                        if (cvv && cvv.value.trim()==='' ) {
                        alert('Lütfen CVV giriniz');
                        return false;
                        }
                        var ccOwner=document.querySelector('[name=\'cc_owner\']');
                        if (ccOwner && ccOwner.value.trim()==='' ) {
                        alert('Lütfen kart sahibi adını giriniz');
                        return false;
                        }
                        if (ccOwner) {
                        ccOwner.value=ccOwner.value.toUpperCase();
                        }
                        return true;
                        } ">
                        <input type="hidden" name="utoken" id="selected_utoken" value="{{($hasSavedCard && !empty($savedCards)) ? (auth()->user()->company->utoken ?? '') : ''}}">
                        <!-- PayTR Direkt API için gerekli hidden input'lar -->
                        <input type="hidden" name="merchant_id" value="{{$merchant_id}}">
                        <input type="hidden" name="user_ip" value="{{$user_ip}}">
                        <input type="hidden" name="merchant_oid" value="{{$merchant_oid}}">
                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="payment_amount" value="{{$payment_amount}}">
                        <input type="hidden" name="paytr_token" value="{{$paytr_token}}">
                        <input type="hidden" name="user_basket" value="{{$user_basket}}">
                        <input type="hidden" name="payment_type" value="{{$payment_type}}">
                        <input type="hidden" name="currency" value="{{$currency}}">
                        <input type="hidden" name="test_mode" value="{{$test_mode}}">
                        <input type="hidden" name="non_3d" value="{{$non_3d}}">
                        <input type="hidden" name="user_name" value="{{$user_name}}">
                        <input type="hidden" name="user_address" value="{{$user_address}}">
                        <input type="hidden" name="user_phone" value="{{$user_phone}}">
                        <input type="hidden" name="merchant_ok_url" value="{{$merchant_ok_url}}">
                        <input type="hidden" name="merchant_fail_url" value="{{$merchant_fail_url}}">
                        <input type="hidden" name="lang" value="tr">
                        <input type="hidden" name="card_type" value="credit">
                        <input type="hidden" name="debug_on" value="1">

                        <div id="new-card-details-wrapper">
                            <div class="form-group">
                                <label class="form-label">Kart Numarası</label>
                                <input type="text" name="card_number" class="form-control"
                                    placeholder="0000 0000 0000 0000"
                                    maxlength="19"
                                    {{!($hasSavedCard && !empty($savedCards)) ? 'required' : ''}}
                                    oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ')">
                            </div>

                            <div class="card-row">
                                <div class="form-group">
                                    <label class="form-label">Son Kullanma Tarihi</label>
                                    <div class="expiry-inputs">
                                        <input type="text" name="expiry_month" class="form-control"
                                            placeholder="AA"
                                            maxlength="2"
                                            {{!($hasSavedCard && !empty($savedCards)) ? 'required' : ''}}
                                            oninput="this.value = this.value.replace(/\D/g, '')">
                                        <span class="expiry-separator">/</span>
                                        <input type="text" name="expiry_year" class="form-control"
                                            placeholder="YY"
                                            maxlength="2"
                                            {{!($hasSavedCard && !empty($savedCards)) ? 'required' : ''}}
                                            oninput="this.value = this.value.replace(/\D/g, '')">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">CVV</label>
                                    <input type="text" name="cvv" class="form-control"
                                        placeholder="000"
                                        maxlength="3"
                                        {{!($hasSavedCard && !empty($savedCards)) ? 'required' : ''}}
                                        oninput="this.value = this.value.replace(/\D/g, '')">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kart Sahibi Adı</label>
                                <input type="text" name="cc_owner" class="form-control"
                                    placeholder="AD SOYAD"
                                    maxlength="50"
                                    {{!($hasSavedCard && !empty($savedCards)) ? 'required' : ''}}
                                    style="text-transform: uppercase;">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Taksit Sayısı</label>
                                <select name="installment_count" class="form-control" {{!($hasSavedCard && !empty($savedCards)) ? 'required' : ''}}>
                                    <option value="0">Tek Çekim</option>
                                    <option value="2">2 Taksit</option>
                                    <option value="3">3 Taksit</option>
                                    <option value="4">4 Taksit</option>
                                    <option value="5">5 Taksit</option>
                                    <option value="6">6 Taksit</option>
                                    <option value="7">7 Taksit</option>
                                    <option value="8">8 Taksit</option>
                                    <option value="9">9 Taksit</option>
                                    <option value="10">10 Taksit</option>
                                    <option value="11">11 Taksit</option>
                                    <option value="12">12 Taksit</option>
                                </select>
                            </div>

                            <div class="form-group checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="store_card" value="1">
                                    <span>Kartımı kaydet (Tekrarlayan ödemeler için)</span>
                                </label>
                            </div>
                        </div>
                        <!-- #new-card-details-wrapper kapanış -->
                    </form>

                    <button type="submit" form="payment-form" class="btn-payment" id="payment-btn" style="display: block !important; visibility: visible !important; opacity: 1 !important; height: auto !important; width: 100% !important; margin-top: 20px !important; padding: 16px !important; background: #007bff !important; color: #fff !important; border: none !important; border-radius: 6px !important; font-size: 18px !important; font-weight: 600 !important; cursor: pointer !important;">
                        Ödemeyi Tamamla
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sözleşme Modal -->
<div class="modal fade" id="contractModal" tabindex="-1" aria-labelledby="contractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contractModalLabel">Mesafeli Hizmet Sözleşmesi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 14px; line-height: 1.6;">
                <h6 class="fw-bold mb-3">MESAFELİ HİZMET SÖZLEŞMESİ ÖN BİLGİLENDİRME FORMU</h6>
                
                <h6 class="fw-bold mt-4 mb-2">A. HİZMET SAĞLAYICI BİLGİLERİ</h6>
                <p><strong>Unvanı:</strong> Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi<br>
                <strong>Marka / Site:</strong> EvHayaliniz – evhayaliniz.com<br>
                <strong>Adres:</strong> İstiklal Mah. Özkılıç Sok. No: 2A Ortaköy / Aksaray<br>
                <strong>Vergi Dairesi / No:</strong> Aksaray VD – 3820436873<br>
                <strong>Telefon:</strong> 0542 655 67 40<br>
                <strong>E-posta:</strong> evhayaliniz@gmail.com<br>
                <strong>MERSİS:</strong> 038951512203051</p>
                <p class="text-muted fst-italic">Bu formda "Hizmet Sağlayıcı" veya "EvHayaliniz" olarak anılacaktır.</p>

                <h6 class="fw-bold mt-4 mb-2">B. ALICI (FİRMA) BİLGİLERİ</h6>
                @php
                    $company = auth()->user()->company;
                    $user = auth()->user();
                @endphp
                <p><strong>Ticari Unvanı:</strong> {{ $company->name }}<br>
                <strong>Vergi Dairesi / No:</strong> {{ $company->tax_office ?? 'Belirtilmemiş' }} / {{ $company->tax_number ?? 'Belirtilmemiş' }}<br>
                <strong>Adres:</strong> {{ $company->address ?? 'Belirtilmemiş' }}<br>
                <strong>Yetkili Kişi:</strong> {{ $company->authorized_person ?? $user->name }}<br>
                <strong>Telefon / E-posta:</strong> {{ $company->phone ?? $user->phone ?? 'Belirtilmemiş' }} / {{ $user->email }}</p>
                <p class="text-muted fst-italic">Bu hizmetler, yalnızca ticari/mesleki amaçla faaliyet gösteren firmalara sunulmaktadır. Tüketici sıfatı ile yapılan işlemler için geçerli değildir.</p>

                <h6 class="fw-bold mt-4 mb-2">C. HİZMETİN KONUSU VE TÜRÜ</h6>
                <p>İşbu Ön Bilgilendirme Formu'nun konusu; evhayaliniz.com üzerinden Müşteri/Firma tarafından satın alınan aşağıdaki Pro Paketler kapsamında sunulan dijital tanıtım hizmetleridir:</p>
                <ul>
                    <li>Pro Standart Paket</li>
                    <li>Pro Business Paket</li>
                    <li>Pro Plus Paket</li>
                </ul>
                <p>Bu paketler kapsamında EvHayaliniz; Müşteri'ye ait firma profilini ve Müşteri'nin sunduğu hizmetleri, Site üzerinde belirlenen alanlarda yayınlama ve tanıtma hizmeti sunar.</p>

                <h6 class="fw-bold mt-4 mb-2">D. PRO PAKETLERİN TEMEL ÖZELLİKLERİ</h6>
                <p>Satın alınan pakete göre:</p>
                <ul>
                    <li>Müşteri, aynı anda belirli sayıda "Hizmet" / "Hizmet Kaydı" oluşturup yayınlayabilir.</li>
                    <li><strong>Pro Standart:</strong> 3 hizmete kadar</li>
                    <li><strong>Pro Business:</strong> 6 hizmete kadar</li>
                    <li><strong>Pro Plus:</strong> 10 hizmete kadar</li>
                </ul>
                <p>Her bir Hizmet Kaydı; Müşteri'nin sunduğu bir hizmeti tanıtan başlık, açıklama, görsel, kategori ve diğer bilgilerden oluşur.</p>
                <p>Hizmetler tamamen dijital nitelikte olup; fiziksel ürün veya inşaat teslimi içermez, sadece tanıtım ve görünürlük sağlar.</p>

                <h6 class="fw-bold mt-4 mb-2">E. HİZMETİN SÜRESİ VE İFASI</h6>
                <p>Pro Paket süresi, sipariş anında seçilen paket türüne göre 1 ay ve/veya 12 ay'dır.</p>
                <p>Ödeme işleminin başarıyla tamamlanmasının ardından ilgili paket, Müşteri'nin evhayaliniz.com hesabına tanımlanır.</p>
                <p>Hizmetin ifasına, paketin hesaba tanımlanması ve Müşteri'nin Hizmet Kayıtlarını oluşturup yayınlayabilmesi ile derhâl başlanmış sayılır.</p>

                <h6 class="fw-bold mt-4 mb-2">F. HİZMET BEDELİ VE ÖDEME BİLGİLERİ</h6>
                <p><strong>Paket:</strong> {{ $package->title }}<br>
                <strong>Paket Türü:</strong> {{ $packageType == 1 ? 'Yıllık' : 'Aylık' }}<br>
                <strong>Ara Toplam (KDV Hariç):</strong> {{ number_format($priceWithoutVat, 2, ',', '.') }}TL<br>
                <strong>KDV (%20):</strong> {{ number_format($vatAmount, 2, ',', '.') }}TL<br>
                <strong>Toplam Tutar (KDV Dahil):</strong> {{ number_format($price, 2, ',', '.') }}TL</p>
                <p>Ödeme yöntemi: Kredi kartı<br>
                Ödeme, peşin olarak tahsil edilir.<br>
                Ödeme sonrasında, Müşteri'nin bildirdiği unvan ve vergi bilgileri esas alınarak e-fatura / e-arşiv fatura düzenlenir.</p>

                <h6 class="fw-bold mt-4 mb-2">G. CAYMA, İPTAL VE İADE KOŞULLARI</h6>
                <p>Pro Standart, Pro Business ve Pro Plus Paketleri; firmalara sunulan, ödeme sonrasında derhâl ifasına başlanan dijital hizmetlerdir.</p>
                <p>Müşteri, bu hizmetlerin ticari nitelikte olduğunu ve 6502 sayılı Tüketicinin Korunması Hakkında Kanun kapsamındaki tüketici cayma hakkı hükümlerinin çoğunlukla uygulanmayacağını kabul eder.</p>
                <p>Teknik sistem hatası, mükerrer tahsilat, bariz yanlış tutar tahsili gibi istisnai durumlarda; EvHayaliniz gerekli incelemeyi yaparak uygun gördüğü ölçüde iade veya mahsup yapabilir.</p>

                <hr class="my-4">

                <h6 class="fw-bold mb-3">PRO PAKET HİZMET SÖZLEŞMESİ</h6>
                
                <h6 class="fw-bold mt-4 mb-2">Madde 1 – TARAFLAR</h6>
                <p>İşbu Hizmet Sözleşmesi ("Sözleşme");</p>
                <p><strong>1.1. Hizmet Sağlayıcı / Platform İşletmecisi</strong><br>
                <strong>Unvanı:</strong> Evhayaliniz Bilgi Teknoloji Ticaret ve Limited Şirketi<br>
                <strong>Markası:</strong> EvHayaliniz – evhayaliniz.com<br>
                <strong>Adresi:</strong> İstiklal Mah Özkılıç Sok. No 2A Ortaköy/Aksaray<br>
                <strong>Vergi Dairesi / No:</strong> Aksaray VD. / 3820436873<br>
                <strong>Tel:</strong> 0542 655 67 40<br>
                <strong>E-posta:</strong> evhayaliniz@gmail.com</p>
                
                <p><strong>1.2. Müşteri / Firma</strong><br>
                <strong>Ticari Unvanı:</strong> {{ $company->name }}<br>
                <strong>Vergi Dairesi / No:</strong> {{ $company->tax_office ?? 'Belirtilmemiş' }} / {{ $company->tax_number ?? 'Belirtilmemiş' }}<br>
                <strong>Adresi:</strong> {{ $company->address ?? 'Belirtilmemiş' }}<br>
                <strong>Yetkili Kişi:</strong> {{ $company->authorized_person ?? $user->name }}<br>
                <strong>Tel / E-posta:</strong> {{ $company->phone ?? $user->phone ?? 'Belirtilmemiş' }} / {{ $user->email }}</p>
                <p class="fst-italic">Bu Sözleşme yalnızca ticari/mesleki amaçla faaliyet gösteren firmalar için geçerlidir; tüketicilere yönelik değildir.</p>

                <h6 class="fw-bold mt-4 mb-2">Madde 2 – SÖZLEŞMENİN KONUSU</h6>
                <p>2.1. İşbu Sözleşme'nin konusu; Müşteri'nin evhayaliniz.com üzerinden satın alacağı Pro Standart, Pro Business veya Pro Plus Paketler kapsamında, Platform üzerinde belirli sayıda hizmet yayınlayabilmesi ve EvHayaliniz'in Müşteri'ye sunduğu dijital tanıtım hizmetlerinin şartlarının düzenlenmesidir.</p>
                <p>2.2. Müşteri; satın aldığı Pro Paket türü kapsamında belirlenen hizmet sayısı kadar hizmetini evhayaliniz.com üzerinden yayınlayıp tanıtabileceğini kabul eder.</p>

                <h6 class="fw-bold mt-4 mb-2">Madde 3 – HİZMETİN NİTELİĞİ</h6>
                <p>Pro Paketler kapsamındaki tüm hizmetler, dijital tanıtım hizmeti olup, fiziksel ürün veya inşaat işi teslimi değildir.</p>
                <p>EvHayaliniz, Müşteri'ye belirli bir satış, ciro, teklif sayısı veya müşteri garantisi vermez.</p>

                <h6 class="fw-bold mt-4 mb-2">Madde 4 – ÜCRET VE ÖDEME</h6>
                <p>Paket bedeli, Müşteri tarafından peşin olarak ödenir.</p>
                <p>Ödeme sonrasında ilgili Pro Paket, Müşteri hesabına tanımlanır.</p>

                <h6 class="fw-bold mt-4 mb-2">Madde 5 – MÜŞTERİ'NİN YÜKÜMLÜLÜKLERİ</h6>
                <p>Müşteri;</p>
                <ul>
                    <li>Site'ye eklediği tüm Hizmet Kayıtlarının ve görsellerin mevzuata uygun, doğru ve güncel olduğunu,</li>
                    <li>Üçüncü kişilere ait fotoğraf, proje, plan, marka, logo vb. içerikleri izinsiz kullanmayacağını,</li>
                    <li>Hizmet açıklamalarında yanıltıcı, gerçeğe aykırı veya haksız rekabet yaratacak ibareler kullanmayacağını,</li>
                </ul>
                <p>kabul ve taahhüt eder.</p>

                <h6 class="fw-bold mt-4 mb-2">Madde 6 – UYGULANACAK HUKUK VE YETKİ</h6>
                <p>İşbu Sözleşme'nin uygulanmasında ve yorumlanmasında Türkiye Cumhuriyeti hukuku uygulanır.</p>
                <p>Taraflar arasındaki uyuşmazlıkların çözümünde Aksaray Merkez Mahkemeleri ve İcra Daireleri yetkilidir.</p>

                <div class="alert alert-info mt-4">
                    <p class="mb-0"><strong>Müşteri Beyanı:</strong> Yukarıda belirtilen bilgileri okudum, anladım ve elektronik ortamda kabul ediyorum.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('contract_accepted').checked = true; bootstrap.Modal.getInstance(document.getElementById('contractModal')).hide();">Kabul Ediyorum</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    (function() {
        // Script hemen çalışsın, DOMContentLoaded beklemeden
        setTimeout(function() {
            const form = document.getElementById('payment-form');
            if (!form) {
                console.error('Payment form not found');
                return;
            }
            const merchantOid = '{{$merchant_oid}}';
            let currentToken = '{{$paytr_token}}';
            const cardInputs = form.querySelectorAll('input[name="card_number"], input[name="expiry_month"], input[name="expiry_year"], input[name="cvv"], input[name="cc_owner"]');

            // Kart bilgileri form-group'larını direkt seç (daha güvenilir)
            const cardNumberGroup = form.querySelector('input[name="card_number"]')?.closest('.form-group');
            const expiryGroup = form.querySelector('input[name="expiry_month"]')?.closest('.form-group');
            const cvvGroup = form.querySelector('input[name="cvv"]')?.closest('.form-group');
            const ccOwnerGroup = form.querySelector('input[name="cc_owner"]')?.closest('.form-group');
            const cardInputGroups = [cardNumberGroup, expiryGroup, cvvGroup, ccOwnerGroup].filter(Boolean);

            const selectedUtokenInput = document.getElementById('selected_utoken');
            const newCardDetailsWrapper = document.getElementById('new-card-details-wrapper');
            const storeCardCheckbox = form.querySelector('input[name="store_card"]');
            const storeCardGroup = storeCardCheckbox ? storeCardCheckbox.closest('.form-group') : null;
            const installmentSelect = form.querySelector('select[name="installment_count"]');
            const installmentGroup = installmentSelect ? installmentSelect.closest('.form-group') : null;

            // Sayfa yüklendiğinde varsayılan seçili radio'nun label'ına selected class'ı ekle
            // ve kart bilgilerini gizle/göster
            const defaultSelectedRadio = form.querySelector('input[name="payment_method"]:checked');
            if (defaultSelectedRadio) {
                const defaultLabel = defaultSelectedRadio.closest('.saved-card-label');
                if (defaultLabel) {
                    defaultLabel.classList.add('selected');
                }

                // Eğer varsayılan seçim kayıtlı kart ise, kart bilgilerini gizle
                if (defaultSelectedRadio.value === 'saved_card') {
                    const cardItem = defaultSelectedRadio.closest('.saved-card-item');
                    const utoken = cardItem ? cardItem.dataset.utoken : '';
                    const ctoken = cardItem ? cardItem.dataset.ctoken : '';

                    // PayTR 3D Secure zorunlu kılıyor, non_3d = "0" olmalı
                    const non3dInput = form.querySelector('[name="non_3d"]');
                    if (non3dInput) {
                        non3dInput.value = '0';
                    }

                    // ctoken ekle (recurring_payment yetkisi yok, bu yüzden eklemiyoruz)
                    if (ctoken) {
                        let ctokenInput = form.querySelector('[name="ctoken"]');
                        if (!ctokenInput) {
                            ctokenInput = document.createElement('input');
                            ctokenInput.type = 'hidden';
                            ctokenInput.name = 'ctoken';
                            form.appendChild(ctokenInput);
                        }
                        ctokenInput.value = ctoken;
                    }

                    // Form'a class ekle - CSS ile tüm kart bilgilerini gizle
                    form.classList.add('hide-new-card-details');

                    // Direkt olarak wrapper'ı gizle (ekstra güvenlik)
                    if (newCardDetailsWrapper) {
                        newCardDetailsWrapper.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important; height: 0 !important; overflow: hidden !important; margin: 0 !important; padding: 0 !important; position: absolute !important; left: -9999px !important; width: 0 !important;';
                    }

                    // Kart input'larını disabled yap ve required attribute'unu kaldır
                    cardInputs.forEach(input => {
                        input.removeAttribute('required');
                        input.disabled = true;
                        input.style.cssText = 'display: none !important; visibility: hidden !important;';
                    });

                    // Store card checkbox'ını da gizle
                    if (storeCardCheckbox) {
                        storeCardCheckbox.disabled = true;
                        if (storeCardGroup) {
                            storeCardGroup.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important; height: 0 !important; overflow: hidden !important;';
                        }
                    }

                    // Kayıtlı kart seçildiğinde installment_count varsayılan olarak "0" (Tek Çekim) gönder
                    var installmentValue = '0'; // Kayıtlı kart için her zaman Tek Çekim

                    // Select'i disabled yap (gönderilmesin)
                    if (installmentSelect) {
                        installmentSelect.disabled = true;
                        installmentSelect.removeAttribute('name');
                    }

                    // Hidden input ekle veya güncelle
                    var existingInstallmentInput = form.querySelector('input[type=\'hidden\'][name=\'installment_count\']');
                    if (existingInstallmentInput) {
                        existingInstallmentInput.value = installmentValue;
                    } else {
                        var installmentInput = document.createElement('input');
                        installmentInput.type = 'hidden';
                        installmentInput.name = 'installment_count';
                        installmentInput.value = installmentValue;
                        form.appendChild(installmentInput);
                    }
                    if (installmentGroup) {
                        installmentGroup.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important; height: 0 !important; overflow: hidden !important;';
                    }

                    // Kayıtlı kart için backend'den hesaplanmış token'ı kullan
                    const tokenInput = form.querySelector('input[name="paytr_token"]');
                    if (tokenInput) {
                        tokenInput.value = '{{$paytr_token_saved_card ?? $paytr_token}}';
                    }
                }
            }

            // Kayıtlı kart seçimi değiştiğinde token'ı yeniden hesapla
            const paymentMethodRadios = form.querySelectorAll('input[name="payment_method"]');
            paymentMethodRadios.forEach(radio => {
                radio.addEventListener('change', async function() {
                    const tokenInput = form.querySelector('input[name="paytr_token"]');
                    const installmentCount = installmentSelect ? installmentSelect.value : '0';

                    // Tüm label'lardan selected class'ını kaldır
                    document.querySelectorAll('.saved-card-label').forEach(label => {
                        label.classList.remove('selected');
                    });

                    if (this.value === 'saved_card') {
                        // Kayıtlı kart seçildi
                        const cardItem = this.closest('.saved-card-item');
                        const utoken = cardItem ? cardItem.dataset.utoken : '';
                        const ctoken = cardItem ? cardItem.dataset.ctoken : '';
                        if (selectedUtokenInput) {
                            selectedUtokenInput.value = utoken;
                        }

                        // PayTR 3D Secure zorunlu kılıyor, non_3d = "0" olmalı
                        const non3dInput = form.querySelector('[name="non_3d"]');
                        if (non3dInput) {
                            non3dInput.value = '0';
                        }

                        // ctoken ekle (recurring_payment yetkisi yok, bu yüzden eklemiyoruz)
                        let ctokenInput = form.querySelector('[name="ctoken"]');
                        if (ctoken) {
                            if (!ctokenInput) {
                                ctokenInput = document.createElement('input');
                                ctokenInput.type = 'hidden';
                                ctokenInput.name = 'ctoken';
                                form.appendChild(ctokenInput);
                            }
                            ctokenInput.value = ctoken;
                        } else if (ctokenInput) {
                            ctokenInput.remove();
                        }

                        // Seçili label'a selected class'ı ekle
                        const selectedLabel = this.closest('.saved-card-label');
                        if (selectedLabel) {
                            selectedLabel.classList.add('selected');
                        }

                        // Form'a class ekle - CSS ile tüm kart bilgilerini gizle
                        form.classList.add('hide-new-card-details');

                        // Direkt olarak wrapper'ı gizle (ekstra güvenlik)
                        if (newCardDetailsWrapper) {
                            newCardDetailsWrapper.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important; height: 0 !important; overflow: hidden !important; margin: 0 !important; padding: 0 !important; position: absolute !important; left: -9999px !important; width: 0 !important;';
                        }

                        // Kart input'larını disabled yap ve required attribute'unu kaldır
                        cardInputs.forEach(input => {
                            input.removeAttribute('required');
                            input.disabled = true;
                            input.style.cssText = 'display: none !important; visibility: hidden !important;';
                        });

                        // Store card checkbox'ını da gizle
                        if (storeCardCheckbox) {
                            storeCardCheckbox.disabled = true;
                            if (storeCardGroup) {
                                storeCardGroup.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important; height: 0 !important; overflow: hidden !important;';
                            }
                        }

                        // Kayıtlı kart seçildiğinde installment_count varsayılan olarak "0" (Tek Çekim) gönder
                        var installmentValue = '0'; // Kayıtlı kart için her zaman Tek Çekim

                        // Select'i disabled yap (gönderilmesin)
                        if (installmentSelect) {
                            installmentSelect.disabled = true;
                            installmentSelect.removeAttribute('name');
                        }

                        // Hidden input ekle veya güncelle
                        var existingInstallmentInput = form.querySelector('input[type=\'hidden\'][name=\'installment_count\']');
                        if (existingInstallmentInput) {
                            existingInstallmentInput.value = installmentValue;
                        } else {
                            var installmentInput = document.createElement('input');
                            installmentInput.type = 'hidden';
                            installmentInput.name = 'installment_count';
                            installmentInput.value = installmentValue;
                            form.appendChild(installmentInput);
                        }
                        if (installmentGroup) {
                            installmentGroup.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important; height: 0 !important; overflow: hidden !important;';
                        }

                        // Kayıtlı kart için backend'den hesaplanmış token'ı kullan
                        if (tokenInput) {
                            tokenInput.value = '{{$paytr_token_saved_card ?? $paytr_token}}';
                            currentToken = '{{$paytr_token_saved_card ?? $paytr_token}}';
                        }
                    } else {
                        // Yeni kart seçildi
                        if (selectedUtokenInput) {
                            selectedUtokenInput.value = '';
                        }

                        // PayTR dokümantasyonuna göre yeni kart için non_3d = "0" olmalı (3D Secure)
                        const non3dInput = form.querySelector('[name="non_3d"]');
                        if (non3dInput) {
                            non3dInput.value = '0';
                        }

                        // ctoken kaldır
                        const ctokenInput = form.querySelector('[name="ctoken"]');
                        if (ctokenInput) {
                            ctokenInput.remove();
                        }

                        // Seçili label'a selected class'ı ekle
                        const selectedLabel = this.closest('.saved-card-label');
                        if (selectedLabel) {
                            selectedLabel.classList.add('selected');
                        }

                        // Form'dan class'ı kaldır - CSS ile tüm kart bilgilerini göster
                        form.classList.remove('hide-new-card-details');

                        // Direkt olarak wrapper'ı göster (ekstra güvenlik)
                        if (newCardDetailsWrapper) {
                            newCardDetailsWrapper.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; height: auto !important; max-height: none !important; min-height: auto !important; overflow: visible !important; margin: inherit !important; padding: inherit !important; border: inherit !important; position: static !important; left: auto !important; width: 100% !important; max-width: 100% !important; pointer-events: auto !important;';
                        }

                        // Form'dan hide class'ını kaldır
                        form.classList.remove('hide-new-card-details');

                        // Kart input'larını enable yap ve required attribute'unu ekle
                        cardInputs.forEach(input => {
                            input.disabled = false;
                            input.setAttribute('required', 'required');
                            input.style.cssText = '';
                        });

                        // Store card checkbox'ını da göster
                        if (storeCardCheckbox) {
                            storeCardCheckbox.disabled = false;
                            if (storeCardGroup) {
                                storeCardGroup.style.cssText = '';
                            }
                        }

                        // Installment count hidden input'unu kaldır ve select'i geri ekle
                        var existingInstallmentInput = form.querySelector('input[name="installment_count"]');
                        if (existingInstallmentInput && existingInstallmentInput.type === 'hidden') {
                            existingInstallmentInput.remove();
                        }

                        if (installmentSelect) {
                            installmentSelect.setAttribute('name', 'installment_count');
                            installmentSelect.setAttribute('required', 'required');
                            installmentSelect.disabled = false;
                            if (installmentGroup) {
                                installmentGroup.style.cssText = '';
                            }
                        }

                        // Yeni kart için backend'den hesaplanmış token'ı kullan
                        if (tokenInput) {
                            tokenInput.value = '{{$paytr_token_new_card ?? $paytr_token}}';
                            currentToken = '{{$paytr_token_new_card ?? $paytr_token}}';
                        }
                    }
                });
            });

            // Installment count değiştiğinde token'ı yeniden hesapla
            if (installmentSelect) {
                installmentSelect.addEventListener('change', async function() {
                    const installmentCount = this.value;
                    const tokenInput = form.querySelector('input[name="paytr_token"]');
                    const selectedPaymentMethod = form.querySelector('input[name="payment_method"]:checked');
                    const isSavedCard = selectedPaymentMethod && selectedPaymentMethod.value === 'saved_card';
                    const cardItem = isSavedCard ? selectedPaymentMethod.closest('.saved-card-item') : null;
                    const utoken = cardItem ? cardItem.dataset.utoken : '';

                    if (!tokenInput) return;

                    try {
                        const response = await fetch('{{ route("payment.recalculate-token") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                merchant_oid: merchantOid,
                                installment_count: parseInt(installmentCount),
                                use_saved_card: isSavedCard,
                                utoken: utoken
                            })
                        });

                        const result = await response.json();
                        if (result.status === 'success' && result.paytr_token) {
                            tokenInput.value = result.paytr_token;
                            currentToken = result.paytr_token;
                        }
                    } catch (error) {
                        console.error('Token yeniden hesaplama hatası:', error);
                    }
                });
            }

            // Buton click event'i artık butonun onclick attribute'unda
        }, 100); // 100ms bekle, form yüklensin
    })();
</script>
</div>
</div>
</div>
</div>
</div>


@endsection

@section('js')

<script>
    // Sayfa yüklendiğinde çalışsın
    (function() {
        function handlePaymentFormSubmit(e) {
            var selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod && selectedMethod.value === 'saved_card') {
                // Kayıtlı kart seçildi - kart bilgilerini kaldır
                var inputs = ['card_number', 'expiry_month', 'expiry_year', 'cvv', 'cc_owner', 'installment_count', 'store_card'];
                for (var i = 0; i < inputs.length; i++) {
                    var el = document.querySelector('[name="' + inputs[i] + '"]');
                    if (el) {
                        el.removeAttribute('name');
                        el.disabled = true;
                    }
                }
            } else {
                // Yeni kart - utoken'ı kaldır
                var utokenEl = document.getElementById('selected_utoken');
                if (utokenEl) {
                    utokenEl.removeAttribute('name');
                }
                // Kart numarasından boşlukları temizle
                var cardNumber = document.querySelector('[name="card_number"]');
                if (cardNumber) {
                    cardNumber.value = cardNumber.value.replace(/\s/g, '');
                }
                // Yıl formatını düzelt
                var expiryYear = document.querySelector('[name="expiry_year"]');
                if (expiryYear && expiryYear.value.length === 2) {
                    var currentYear = new Date().getFullYear();
                    var century = Math.floor(currentYear / 100);
                    var year = parseInt(expiryYear.value);
                    if (year < 50) {
                        expiryYear.value = (century * 100 + year).toString();
                    } else {
                        expiryYear.value = ((century - 1) * 100 + year).toString();
                    }
                }
                // Kart sahibi adını büyük harfe çevir
                var ccOwner = document.querySelector('[name="cc_owner"]');
                if (ccOwner) {
                    ccOwner.value = ccOwner.value.toUpperCase();
                }
            }
            return true;
        }

        // Form yüklendiğinde event listener ekle
        function initPaymentForm() {
            var form = document.getElementById('payment-form');
            if (form) {
                form.addEventListener('submit', handlePaymentFormSubmit);
            } else {
                // Form henüz yüklenmemiş, tekrar dene
                setTimeout(initPaymentForm, 100);
            }
        }

        // Sayfa yüklendiğinde veya DOM hazır olduğunda çalıştır
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPaymentForm);
        } else {
            initPaymentForm();
        }
    })();
</script>
@endsection