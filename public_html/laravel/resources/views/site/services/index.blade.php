@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="tum-hizmetler">
                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-slider tum-hizmetler-top"></div>
                    <x-slider/>

                    <h5 class="mobile-small-title" style="top: 16px">Hizmetler</h5>
                </div>

                <div class="tum-hizmetler-inputs-flex">
                    <form action="" method="GET">
                        <div class="tum-hizmetler-inputs">
                            <div class="form-group">
                                <select name="category" class="form-select" onchange="getSubCategories(); loadCategoryParameters();">
                                    <option value="">Kategori</option>
                                    @foreach(get_categories() as $category)
                                        <option
                                            value="{{$category->id}}" @selected(request()->category == $category->id)>
                                            {{$category->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="sub_category" class="form-select" id="sub-category-select">
                                    <option value="">Alt Kategori</option>

                                    @if(request()->category)
                                        @foreach(get_sub_categories(request()->category) as $subCategory)
                                            <option
                                                value="{{$subCategory->id}}" @selected(request()->sub_category == $subCategory->id)>
                                                {{$subCategory->name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="province" class="form-select" onchange="getDistricts()">
                                    <option value="">İl</option>
                                    @foreach(get_provinces() as $province)
                                        <option
                                            value="{{$province->id}}" @selected(request()->province == $province->id)>
                                            {{$province->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="district" class="form-select" id="district-select">
                                    <option value="">İlçe</option>

                                    @if(request()->province)
                                        @foreach(get_districts(request()->province) as $district)
                                            <option
                                                value="{{$district->id}}" @selected(request()->district == $district->id)>
                                                {{$district->name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group d-flex align-items-center gap-2">
                                <span>
                                <input type="text" class="form-control"
                                       value="{{format_decimal_input(request()->min_price)['visible']}}"
                                       placeholder="Min Ücret" oninput="priceEdit()">
                                <input type="hidden" name="min_price" class="price-area"
                                       value="{{format_decimal_input(request()->min_price)['raw']}}">
                                    </span>
                                -
                                <span>
                                <input type="text" class="form-control"
                                       value="{{format_decimal_input(request()->max_price)['visible']}}"
                                       placeholder="Max Ücret" oninput="priceEdit()">
                                <input type="hidden" name="max_price" class="price-area"
                                       value="{{format_decimal_input(request()->max_price)['raw']}}">
                                </span>
                            </div>

                            <!-- Dinamik Parametreler -->
                            @if(isset($categoryParameters) && count($categoryParameters) > 0)
                                @foreach($categoryParameters as $parameter)
                                    <div class="form-group" data-dynamic-parameter>
                                        @if($parameter->type === 'input')
                                            <input type="text" 
                                                   name="parameters[{{ $parameter->id }}]" 
                                                   class="form-control" 
                                                   placeholder="{{ $parameter->title }}"
                                                   value="{{ request()->parameters[$parameter->id] ?? '' }}"
                                                   style="min-width: 150px;">
                                        @elseif($parameter->type === 'select' && !empty($parameter->options))
                                            <select name="parameters[{{ $parameter->id }}]" class="form-select" style="min-width: 150px;">
                                                <option value="">{{ $parameter->title }}</option>
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


                            <div class="tum-fikirler-arama">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="q" placeholder="Servislerde Ara..."
                                               value="{{request()->q}}">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group tum-hizmetler-inputs-flex-button ms-3 mt-1">
                                <button type="submit">
                                    Filtrele
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="tum-hizmetler-box index-right">
                    <div class="tum-hizmetler-filter-title d-flex">
                        <div class="thft-left">
                            <div class="thft-box">
                                @if(request()->all())
                                    <a href="{{route('services.index')}}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </a>
                                @endif
                                @if(request()->category)
                                    <span>{{\App\Models\Category::select('name')->whereId(request()->category)->first()?->name}}</span>
                                    /
                                @endif

                                @if(request()->sub_category)
                                    <span>{{\App\Models\Category::select('name')->where('parent_id', request()->category)
                                            ->whereId(request()->sub_category)->first()?->name}}</span>
                                    /
                                @endif

                                @if(request()->province)
                                    <span>{{\App\Models\Province::select('name')->whereId(request()->province)->first()?->name}}</span>
                                    /
                                @endif

                                @if(request()->district)
                                    <span>{{\App\Models\District::select('name')->whereId(request()->district)
                                    ->where('city_id', request()->province)->first()?->name}}</span>
                                @endif
                            </div>
                            <b>{{$serviceCount}}</b>
                            <small class="mobile-extrasmall-title">Servis Bulundu</small>
                        </div>

                        <div class="thft-right" style="margin-bottom: 10px">
                            <form action="" method="GET">
                                <select name="order_by" class="form-select" onchange="this.closest('form').submit()">
                                    <option value="">Varsayılan</option>
                                    <option value="price_asc" @selected(request()?->order_by == 'price_asc')>Fiyat
                                        (Artan)
                                    </option>
                                    <option value="price_desc" @selected(request()?->order_by == 'price_desc')>Fiyat
                                        (Azalan)
                                    </option>
                                    <option value="sqm_asc" @selected(request()?->order_by == 'sqm_asc')>Metrekare
                                        (Artan)
                                    </option>
                                    <option value="sqm_desc" @selected(request()?->order_by == 'sqm_desc')>Metrekare
                                        (Azalan)
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>


                    <div class="tum-hizmetler-inner">
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                                    @include('site.services.partials.single-service-card', ['service' => $service])
                                </div>
                            @endforeach

                            {{$services->links()}}
                        </div>
                    </div>
                    <footer class="mt-0">
                        <p class="mb-0">
                            {{str_replace(['http://', 'https://'], '', env('APP_URL'))}}'da yer alan üyelerin oluşturduğu tüm içerik, görüş ve bilgilerin doğruluğu,
                            eksiksiz ve değişmez olduğu, yayınlanması ile ilgili yasal yükümlülükler içeriği oluşturulan
                            üyeye aittir. Bu içeriğin, görüş ve bilgilerin yanlışlık, eksiklik veya yasalarla
                            düzenlenmiş kurallara aykırılığından {{str_replace(['http://', 'https://'], '', env('APP_URL'))}} hiç bir şekilde sorumlu değildir.
                            Sorularınız için içerik sahibi ile irtibata geçebilirsiniz.
                        </p>
                    </footer>
                </div>


            </div>


        </div>
    </div>
@endsection


@section('js')
    <script>
        window.addEventListener('scroll', _ => {
            scrollFilterAreaFixed()
        })

        // Sayfa yüklendiğinde mevcut kategori varsa parametreleri yükle
        document.addEventListener('DOMContentLoaded', function() {
            const categoryId = document.querySelector('select[name="category"]').value;
            if (categoryId) {
                loadCategoryParameters();
            }
        });

        // Alt kategorileri getir
        function getSubCategories() {
            const categoryId = document.querySelector('select[name="category"]').value;
            const subCategorySelect = document.getElementById('sub-category-select');

            if (!categoryId) {
                subCategorySelect.innerHTML = '<option value="">Alt Kategori</option>';
                return;
            }

            fetch(`/get-sub-categories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">Alt Kategori</option>';
                    data.forEach(subCategory => {
                        const selected = subCategory.id == {{ request()->sub_category ?? 'null' }} ? 'selected' : '';
                        options += `<option value="${subCategory.id}" ${selected}>${subCategory.name}</option>`;
                    });
                    subCategorySelect.innerHTML = options;
                })
                .catch(error => {
                    console.error('Alt kategoriler yüklenirken hata:', error);
                });
        }

        // Kategori parametrelerini yükle
        function loadCategoryParameters() {
            const categoryId = document.querySelector('select[name="category"]').value;
            const tumHizmetlerInputs = document.querySelector('.tum-hizmetler-inputs');
            
            // Önce mevcut dinamik parametreleri sil
            const existingParams = tumHizmetlerInputs.querySelectorAll('[data-dynamic-parameter]');
            existingParams.forEach(param => param.remove());
            
            if (!categoryId) {
                return;
            }

            fetch(`/company/services/category-parameters/${categoryId}`)
                .then(response => response.json())
                .then(parameters => {
                    if (parameters.length === 0) {
                        return;
                    }

                    const currentValue = '{{ json_encode(request()->parameters ?? []) }}';
                    const currentParams = JSON.parse(currentValue);
                    
                    // Max Price alanından sonra, arama alanından önce ekle
                    const maxPriceDiv = tumHizmetlerInputs.querySelector('input[name="max_price"]').closest('.form-group');
                    
                    parameters.forEach(parameter => {
                        const paramValue = currentParams[parameter.id] || '';
                        
                        const formGroup = document.createElement('div');
                        formGroup.className = 'form-group';
                        formGroup.setAttribute('data-dynamic-parameter', '');
                        
                        if (parameter.type === 'input') {
                            formGroup.innerHTML = `
                                <input type="text" 
                                       name="parameters[${parameter.id}]" 
                                       class="form-control" 
                                       placeholder="${parameter.title}"
                                       value="${paramValue}"
                                       style="min-width: 150px;">
                            `;
                        } else if (parameter.type === 'select' && parameter.options) {
                            let selectHtml = `
                                <select name="parameters[${parameter.id}]" class="form-select" style="min-width: 150px;">
                                    <option value="">${parameter.title}</option>
                            `;
                            parameter.options.forEach(option => {
                                const selected = option === paramValue ? 'selected' : '';
                                selectHtml += `<option value="${option}" ${selected}>${option}</option>`;
                            });
                            selectHtml += '</select>';
                            formGroup.innerHTML = selectHtml;
                        }
                        
                        // Max price alanından sonra ekle
                        maxPriceDiv.insertAdjacentElement('afterend', formGroup);
                    });
                })
                .catch(error => {
                    console.error('Parametreler yüklenirken hata:', error);
                });
        }

        // İlçeleri getir
        function getDistricts() {
            const provinceId = document.querySelector('select[name="province"]').value;
            const districtSelect = document.getElementById('district-select');

            if (!provinceId) {
                districtSelect.innerHTML = '<option value="">İlçe</option>';
                return;
            }

            fetch(`/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">İlçe</option>';
                    data.forEach(district => {
                        const selected = district.id == {{ request()->district ?? 'null' }} ? 'selected' : '';
                        options += `<option value="${district.id}" ${selected}>${district.name}</option>`;
                    });
                    districtSelect.innerHTML = options;
                })
                .catch(error => {
                    console.error('İlçeler yüklenirken hata:', error);
                });
        }
    </script>
@endsection
