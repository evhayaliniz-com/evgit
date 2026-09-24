@extends('site.inc.layout')

@section('css')
<style>
    .pro-paketler-dark-bg {
        z-index: 999;
        width: 100vw;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        position: absolute;
    }

    #package-category-select {
        max-height: 300px;
        overflow-y: auto;
    }

    h4.d-inline-block.d-md-block {
        font-weight: 900;
    }

    p.mb-0.bill-text {
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="pro-paketler-dark-bg d-none"></div>

<div class="pro-paketler" style="height: 100vh">
    <div class="pro-paketler-title">
        <div class="pro-paketler-close">
            <button type="button">
                <a href="{{route('company.dashboard')}}" class="text-dark">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </button>
            <div class="pro-paketler-title-text">
                <h1>
                    Premium'a Yükselt
                </h1>
                <p>
                    Özel hizmet üreticisi araçları, üst düzey doğrulama ve güvenlikten yararlanın.
                </p>
            </div>
        </div>
    </div>
    <div class="pro-paketler-body">
        <div class="pro-paketler-tabs-box">
            <div class="pro-paketler-ul">
                <ul class="nav nav-tabs pro-paketler-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">
                            Yıllık (En Avantajlı)
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Aylık
                        </button>
                    </li>
                </ul>
            </div>

            <div class="pro-paketler-checked-category">
                <form action="{{route('company.packages.add')}}" method="POST" id="package-form">
                    <input type="hidden" name="package_id" id="package-id">
                    <input type="hidden" name="package_type" id="package-type">

                    @csrf
                    <div class="select-box" style="z-index: 99999">
                        <button type="button" class="select-button" id="category-select-button" disabled style="opacity: 0.6; cursor: not-allowed;">Kategori Ek Paketleri</button>
                        <div class="select" id="package-category-select">
                        </div>
                    </div>
                </form>
            </div>


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="pro-paketler-tab-inner">
                        <div class="pro-paketler-select">
                            <div class="grid">
                                @foreach($packages as $package)
                                <label class="card" data-type="Yıl" data-id="{{$package->id}}" data-ptype="1">
                                    <input name="plan" class="radio" type="radio" value="{{$package->id}}"
                                        onchange="packageSelect()">
                                    <span class="plan-details">
                                        <span class="plan-type mb-3">{{$package->title}}</span>

                                        <p class="mb-2">{!! clean($package->description, 'titles') !!}</p>

                                        @if($package->informations)
                                        @foreach(json_decode($package->informations) as $information)
                                        <span class="d-flex pro-paketler-info">
                                            <i class="fa-solid fa-check"></i> {{$information}}</span>
                                        @endforeach
                                        @endif
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <div class="pro-paketler-tab-inner">
                        <div class="pro-paketler-select">
                            <div class="grid">
                                @foreach($packages as $package)
                                <label class="card" data-type="Ay" data-id="{{$package->id}}" data-ptype="2">
                                    <input name="plan" class="radio" type="radio" value="{{$package->id}}"
                                        onchange="packageSelect()">
                                    <span class="plan-details">
                                        <span class="plan-type mb-3">{{$package->title}}</span>

                                        <p class="mb-2">{!! clean($package->description, 'titles') !!}</p>

                                        @if($package->informations)
                                        @foreach(json_decode($package->informations) as $information)
                                        <span class="d-flex pro-paketler-info">
                                            <i class="fa-solid fa-check"></i>
                                            {{$information}}
                                        </span>
                                        @endforeach
                                        @endif
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pro-paketler-bottom d-none" style="z-index: 99999">
                <div class="pro-paketler-bottom-left text-center">
                    <h3></h3>

                    <div class="d-inline-block d-md-flex">
                        <h4 class="d-inline-block d-md-block"></h4>

                        <span class="ms-1 ms-md-2">/<span class="duration-type ms-1"></span></span>
                    </div>

                    <p class="mb-0 bill-text"></p>
                </div>
                <div class="pro-paketler-bottom-right ">
                    <div class="ppbr-button">
                        <button type="button" onclick="packageFormSubmit()">Abone Ol ve Ödeme Yap</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    function packageSelect() {
        document.querySelector('.pro-paketler-bottom').classList.remove('d-none');
        document.querySelector('.pro-paketler-bottom').classList.add('d-md-flex');

        let card = event.target.closest('.card');
        let priceArea = document.querySelector('.pro-paketler-bottom');

        // Paketin değerini input içerisine atıyoruz
        document.querySelector('#package-id').value = card.dataset.id;
        document.querySelector('#package-type').value = card.dataset.ptype;

        // Paketin başlık, fiyat, türünü (aylık veya yıllık) atıyoruz
        // priceArea.querySelector('h3').textContent = card.querySelector('.plan-type').textContent;
        // priceArea.querySelector('h4').textContent = card.querySelector('.plan-cost .price').textContent;
        priceArea.querySelector('.duration-type').textContent = card.dataset.type;

        priceArea.querySelector('.bill-text').textContent = card.dataset.type == 'Ay' ? 'Aylık olarak faturalandırılır' :
            'Yıllık olarak faturalandırılır';

        // Kategori Ek Paketleri butonunu aktif ediyoruz
        const categorySelectButton = document.querySelector('#category-select-button');
        categorySelectButton.disabled = false;
        categorySelectButton.style.opacity = '1';
        categorySelectButton.style.cursor = 'pointer';

        getCategoryPrice(card.dataset.id, card.dataset.ptype);
    }


    function getCategoryPrice(id, pType) {
        let packageSelect = document.querySelector('#package-category-select');
        let priceArea = document.querySelector('.pro-paketler-bottom h4');

        fetch('/company/packages/category-values', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    id: id,
                    type: pType
                })
            })
            .then(response => response.json())
            .then(data => {
                packageSelect.innerHTML = '';

                if (data.selected_category) {
                    // Kullanıcının kendi kategorisini zaten satın alıp almadığını kontrol ediyoruz
                    const ownCategoryPurchase = data.purchased_packages.find(p => p.category_id === data.selected_category.category_id);
                    const isOwnCategoryPurchased = ownCategoryPurchase !== undefined;
                    const categoryPrice = pType == 1 ? data.selected_category.yearly_price : data.selected_category.monthly_price;

                    packageSelect.insertAdjacentHTML('beforeend', `
                        <label for="checkbox-${data.selected_category.category_id}" style="${isOwnCategoryPurchased ? 'opacity: 0.6;' : ''}">
                            <input name="categories[${data.selected_category.category_id}]" value="${data.selected_category.category_id}"
                                id="checkbox-${data.selected_category.category_id}" type="checkbox" checked disabled>
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <span>${data.selected_category.category.name}</span>
                                    <div class="d-flex align-items-center gap-2">
                                        ${isOwnCategoryPurchased ? `<small class="text-success" style="white-space: nowrap;">Zaten sahipsiniz (${ownCategoryPurchase.type} ${ownCategoryPurchase.package_name})</small>` : ''}
                                        <b style="color: #4068e2">${formatNumber(categoryPrice)} TL</b>
                                    </div>
                                </div>
                        </label>
                        `);

                    // Eğer zaten satın aldıysa fiyatı 0, almadıysa normal fiyat atıyoruz
                    const priceToAdd = isOwnCategoryPurchased ? 0 : categoryPrice;
                    priceArea.textContent = formatNumber(priceToAdd) + ' TL';
                    priceArea.dataset.price = priceToAdd;
                }

                for (let item of data.categories) {
                    // Satın alınmış paket kontrolü
                    const purchasedInfo = data.purchased_packages.find(p => p.category_id === item.category_id);
                    const isPurchased = purchasedInfo !== undefined;

                    packageSelect.insertAdjacentHTML('beforeend', `
                        <label for="checkbox-${item.category_id}" style="${isPurchased ? 'opacity: 0.6; cursor: not-allowed;' : ''}">
                            <input name="categories[${item.category_id}]" value="${item.category_id}"
                               id="checkbox-${item.category_id}" type="checkbox"
                               data-price="${pType == 1 ? item.yearly_price : item.monthly_price}"
                               onchange="changePackagePrice()"
                               ${isPurchased ? 'disabled' : ''}>
                            <div class="d-flex justify-content-between w-100 align-items-center">
                                <span>${item.category.name}</span>
                                <div class="d-flex align-items-center gap-2">
                                    ${isPurchased ? `<small class="text-success" style="white-space: nowrap;">Zaten abonesiniz (${purchasedInfo.type} ${purchasedInfo.package_name})</small>` : ''}
                                    <b style="color: #4068e2">${pType == 1 ? formatNumber(item.yearly_price) : formatNumber(item.monthly_price)} TL</b>
                                </div>
                            </div>
                        </label>
                        `);
                }
            })
    }


    function changePackagePrice() {
        const price = parseInt(document.querySelector('.pro-paketler-bottom h4').dataset.price);
        const selectedPrice = parseInt(event.currentTarget.dataset.price);

        // Paketin seçili olma durumuna göre ücreti ekliyoruz veya çıkarıyoruz.
        document.querySelector('.pro-paketler-bottom h4').dataset.price = event.currentTarget.checked ?
            price + selectedPrice : price - selectedPrice;

        document.querySelector('.pro-paketler-bottom h4').textContent = event.currentTarget.checked ?
            formatNumber(price + selectedPrice) + ' TL' : formatNumber(price - selectedPrice) + ' TL';
    }


    function packageFormSubmit() {
        const packageForm = document.querySelector('#package-form');
        const packageSelect = document.querySelector('#package-category-select');

        if (packageSelect.children.length > 0) {
            packageForm.submit();

        } else {
            alert('En az 1 paket seçmelisiniz.');
        }
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const darkBg = document.querySelector('.pro-paketler-dark-bg');
        const selectButton = document.querySelector('.select-button');
        // Arka plan divine tıklanırsa kapanır
        if (darkBg) {
            darkBg.addEventListener('click', function() {

                selectButton.click();
                darkBg.classList.add('d-none');
            });
        }

        // Aylık/Yıllık tab değişikliklerini dinliyoruz
        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                const packageIdInput = document.querySelector('#package-id');
                const packageTypeInput = document.querySelector('#package-type');

                // Eğer bir paket seçiliyse, kategori listesini güncelliyoruz
                if (packageIdInput.value) {
                    const targetTab = event.target.getAttribute('data-bs-target');
                    // home = yıllık (type 1), profile = aylık (type 2)
                    const newPackageType = targetTab === '#home' ? 1 : 2;

                    // Paket tipini güncelliyoruz
                    packageTypeInput.value = newPackageType;

                    // Kategori ek paketlerini yeni fiyatlarla yeniliyoruz
                    getCategoryPrice(packageIdInput.value, newPackageType);

                    // Alt kısımdaki fatura metnini güncelliyoruz
                    const billText = document.querySelector('.bill-text');
                    if (billText) {
                        billText.textContent = newPackageType == 2 ? 'Aylık olarak faturalandırılır' : 'Yıllık olarak faturalandırılır';
                    }

                    // Süre tipini güncelliyoruz
                    const durationType = document.querySelector('.duration-type');
                    if (durationType) {
                        durationType.textContent = newPackageType == 2 ? 'Ay' : 'Yıl';
                    }
                }
            });
        });
    });
</script>
@endsection