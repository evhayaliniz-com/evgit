@extends('site.inc.master')

@section('css')
<style>
    .main.sidebar {
        padding-left: 0;
    }

    /* Modern Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
<div class="main sidebar">
    <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
        <div class="profili-duzenle">
            <div class="profili-duzenle-box bg-white">
                <div class="profili-duzene-title d-flex">
                    <div class="pdt-left">
                        <a href="{{route('company.dashboard')}}">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                        <span>Profili Düzenle</span>
                    </div>
                    <div class="pdt-right">
                        <a href="{{route('company.password.edit')}}" class="btn btn-primary">
                            Şifre Değiştir
                        </a>
                    </div>
                </div>
                <div class="profili-duzenle-form">
                    <div class="pdform-left d-flex">
                        <div class="pdform-logo-area">
                            <img src="{{asset($company->avatar)}}" class="profile-edit-avatar" alt="Avatar">
                        </div>
                        <div class="pdform-logo-add">
                            <button class="pdf-logo-add-button" onclick="logoSelector()">
                                Logo Ekle
                            </button>
                            <button class="pdf-logo-add-button remove-button" onclick="removeAvatar()">
                                Sil
                            </button>
                        </div>
                    </div>
                    <div class="pdf-form-right">
                        <x-input-error-site />

                        <form id="profile-update-form" action="{{route('company.profile.update')}}" method="POST"
                            enctype="multipart/form-data">
                            @method('PATCH')

                            <input type="file" name="avatar"
                                accept="image/jpeg,image/jpg,image/png,image/webp"
                                style="position: absolute; top: -10000px" onchange="showAvatar()">

                            <input type="hidden" name="remove_avatar" value="1" id="avatar">

                            <div class="pdf-form-inputs d-flex login-modal-box">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="name" value="{{$company->name}}"
                                            @error('name') class="error" @enderror required="">
                                        <label>Firma Adı</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="email" value="{{$company->user->email}}" disabled>
                                        <label>E-Posta</label>
                                    </div>
                                </div>
                            </div>

                            <div class="pdf-form-inputs d-flex login-modal-box">
                                <div class="form-group">
                                    <select name="category_id"
                                        class="form-select @error('category_id') error @enderror"
                                        onchange="getSubCategories()" required>
                                        <option value="">Kategori</option>
                                        @foreach(get_categories() as $category)
                                        <option value="{{$category->id}}" @selected($category->id ==$company->category_id)>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group required">
                                    <select name="sub_category_id"
                                        class="form-select @error('sub_category_id') error @enderror"
                                        id="sub-category-select" required>
                                        <option value="">Alt Kategori</option>

                                        @foreach(get_sub_categories($company->category_id) as $subCategory)
                                        <option value="{{$subCategory->id}}" @selected($company->sub_category_id == $subCategory->id)>
                                            {{$subCategory->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="pdf-form-inputs d-flex login-modal-box">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="authorized" value="{{$company->authorized}}"
                                            @error('authorized') class="error" @enderror required="">
                                        <label>Firma Yetkilisi</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="mobile_phone" value="{{$company->mobile_phone}}"
                                            @error('mobile_phone') class="error" @enderror required="">
                                        <label>Cep Telefonu</label>
                                    </div>
                                </div>

                            </div>

                            <div class="pdf-form-inputs d-flex login-modal-box">
                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="tax_number" value="{{$company->tax_number}}"
                                            @error('tax_number') class="error" @enderror required="">
                                        <label>Vergi No</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-field">
                                        <input type="text" name="fixed_phone" value="{{$company->fixed_phone}}"
                                            @error('fixed_phone') class="error" @enderror>
                                        <label>Sabit Telefon</label>
                                    </div>
                                </div>
                            </div>

                            <div class="pdf-form-inputs d-flex login-modal-box full-width">
                                <div class="form-group full-width profil-text-area required">
                                    <textarea name="about" placeholder="Hakkında"
                                        @error('about') class="error" @enderror
                                        required>{{$company->about}}</textarea>
                                </div>
                            </div>
                            <h3 class="profil-konum">
                                Konum
                            </h3>
                            <div class="pdf-form-inputs d-flex login-modal-box quarter-witdh-flex">
                                <div class="form-group select-width">
                                    <select name="province" class="form-select @error('province') error @enderror"
                                        onchange="getDistricts()" required>
                                        <option value="">İl</option>
                                        @foreach(get_provinces() as $province)
                                        <option value="{{$province->id}}" @selected($company->province == $province->id)>
                                            {{$province->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group select-width">
                                    <select name="district" class="form-select @error('district') error @enderror"
                                        id="district-select" required>
                                        <option value="">İlçe</option>

                                        @foreach(get_districts($company->province) as $district)
                                        <option value="{{$district->id}}" @selected($company->district == $district->id)>
                                            {{$district->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>




                            <div class="pdf-form-inputs d-flex login-modal-box profil-duzenle-adres-textarea">
                                <div class="form-group half-width required" style="width: 100% !important;">
                                    <textarea name="address" id="address-input" placeholder="Adres"
                                        @error('address') class="error" @enderror
                                        required>{{ $company->address }}</textarea>
                                    <div id="geocoding-status" style="display: none; margin-top: 10px;">
                                        <div class="d-flex align-items-center">
                                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <small class="text-muted">Konum aranıyor...</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group half-width px-4">
                                    <div id="map-container">
                                        <iframe id="map-iframe" width="100%" height="120" style="border:0;" allowfullscreen=""
                                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                            @if($company->lat && $company->lng)
                                            src="https://www.google.com/maps?q={{$company->lat}},{{$company->lng}}&z=15&output=embed"
                                            @else
                                            src="https://www.google.com/maps?q=Turkey&z=6&output=embed"
                                            @endif>
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden fields for lat/lng -->
                            <input type="hidden" name="lat" id="latitude" value="{{$company->lat}}">
                            <input type="hidden" name="lng" id="longitude" value="{{$company->lng}}">


                            <h3 class="profil-konum sm-web-adres">
                                Sosyal Medya ve Web Adresleri (Pro Üyelere Özel)
                            </h3><br>
                            <div class="pdf-form-inputs d-flex login-modal-box quarter-witdh-flex">
                                <div class="form-group quarter-width">
                                    <div class="input-field">
                                        <input name="facebook" type="text" value="{{$company->facebook}}"
                                            @error('facebook') class="error" @enderror>
                                        <label>Facebook Link</label>
                                    </div>
                                </div>

                                <div class="form-group quarter-width">
                                    <div class="input-field">
                                        <input name="instagram" type="text" value="{{$company->instagram}}"
                                            @error('instagram') class="error" @enderror>
                                        <label>Instagram Link</label>
                                    </div>
                                </div>

                                <div class="form-group quarter-width">
                                    <div class="input-field">
                                        <input name="youtube" type="text" value="{{$company->youtube}}"
                                            @error('youtube') class="error" @enderror>
                                        <label>Youtube Link</label>
                                    </div>
                                </div>
                                <div class="form-group quarter-width">
                                    <div class="input-field">
                                        <input name="website" type="text" value="{{$company->website}}"
                                            @error('website') class="error" @enderror>
                                        <label>Website Link</label>
                                    </div>
                                </div>
                            </div>

                            @csrf
                            <div class="profili-duzenle-save">
                                <button type="submit">
                                    Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="profili-duzenle-pro-membership pdp-account-delete">
                <div class="pdpm-left">
                    <h4>
                        Hesabımı Sil
                    </h4>
                    <p>
                        Tüm bilgilerimi, üyelik ve hizmetlerimi tekrar geri getirilemiyecek şekilde sil.
                    </p>
                </div>
                <div class="pdpm-right">
                    <div class="pdpm-buttons">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#pdp-account-delete">
                            Hesabımı sil
                        </button>
                    </div>
                </div>
            </div>


            <div class="modal fade login-modal" id="pdp-account-delete" tabindex="-1"
                aria-labelledby="pdp-account-deleteLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pdp-account-deleteLabel">Hesabımı Sil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="hesabimi-sil-modal-body">
                                <p>Tüm bilgilerim, pro üyelik ve hizmetlerimi tekrar getirilmeyecek şekilde sil</p>

                                <div class="hsmb-button text-center">
                                    <form action="{{route('company.profile.destroy')}}" method="POST">
                                        @method('DELETE')

                                        @csrf
                                        <button type="submit">Hesabımı Sil</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Adres inputuna otomatik geocoding özelliği ekle
    document.addEventListener('DOMContentLoaded', function() {
        const addressInput = document.getElementById('address-input');
        const mapIframe = document.getElementById('map-iframe');
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const loadingStatus = document.getElementById('geocoding-status');

        if (!addressInput || !mapIframe || !latInput || !lngInput) {
            return;
        }

        addressInput.addEventListener('input', debounce(function(event) {
            try {
                const target = event.target || this;
                const address = target && target.value ? target.value.trim() : '';

                if (address && address.length > 10) {
                    showLoading();
                    geocodeAddress(address);
                } else {
                    hideLoading();
                }
            } catch (error) {
                console.error('Error in input handler:', error);
            }
        }, 1000));

        function showLoading() {
            if (loadingStatus) {
                loadingStatus.style.display = 'block';
            }
        }

        function hideLoading() {
            if (loadingStatus) {
                loadingStatus.style.display = 'none';
            }
        }

        function geocodeAddress(address) {
            if (!address || !latInput || !lngInput || !mapIframe) {
                return;
            }
            const searchStrategies = createSearchStrategies(address);
            tryGeocoding(searchStrategies, 0);
        }

        function createSearchStrategies(address) {
            const strategies = [];
            const provinceSelect = document.querySelector('select[name="province"]');
            const districtSelect = document.querySelector('select[name="district"]');
            const selectedProvinceText = provinceSelect?.selectedOptions[0]?.textContent?.trim() || '';
            const selectedDistrictText = districtSelect?.selectedOptions[0]?.textContent?.trim() || '';
            const normalizedProvince = normalizeText(selectedProvinceText);
            const normalizedDistrict = normalizeText(selectedDistrictText);
            const mahalleMatch = address.match(/([0-9a-zA-ZğüşıöçĞÜŞİÖÇ\s]+?)\s+mahallesi/i);
            const addressAfterMahalle = address.replace(/^.*?mahallesi\s+/, '');
            const sokakMatch = addressAfterMahalle.match(/([0-9a-zA-ZğüşıöçĞÜŞİÖÇ\s]+?)\s+(caddesi|sokağı|bulvarı)/i);
            if (sokakMatch && normalizedDistrict) {
                const sokakName = sokakMatch[1].trim() + ' ' + sokakMatch[2];
                strategies.push(`${sokakName}, ${normalizedDistrict}`);
            }
            if (sokakMatch && normalizedDistrict && normalizedProvince) {
                const sokakName = sokakMatch[1].trim() + ' ' + sokakMatch[2];
                strategies.push(`${sokakName}, ${normalizedDistrict}, ${normalizedProvince}`);
            }
            if (normalizedDistrict && normalizedProvince) {
                strategies.push(`${address}, ${normalizedDistrict}, ${normalizedProvince}, Turkey`);
            }
            if (normalizedProvince) {
                strategies.push(`${address}, ${normalizedProvince}, Turkey`);
            }
            strategies.push(`${address}, Turkey`);
            if (mahalleMatch && normalizedDistrict && normalizedProvince) {
                const mahalleName = mahalleMatch[1].trim();
                strategies.push(`${mahalleName} mahallesi, ${normalizedDistrict}, ${normalizedProvince}, Turkey`);
            }
            if (normalizedDistrict && normalizedProvince) {
                strategies.push(`${normalizedDistrict}, ${normalizedProvince}, Turkey`);
            }
            if (mahalleMatch && sokakMatch && normalizedDistrict && normalizedProvince) {
                const mahalleName = mahalleMatch[1].trim();
                const sokakName = sokakMatch[1].trim() + ' ' + sokakMatch[2];
                strategies.push(`${mahalleName} mahallesi ${sokakName}, ${normalizedDistrict}, ${normalizedProvince}, Turkey`);
            }
            if (mahalleMatch && sokakMatch) {
                const mahalleName = mahalleMatch[1].trim();
                const sokakName = sokakMatch[1].trim() + ' ' + sokakMatch[2];
                strategies.push(`${mahalleName} mahallesi ${sokakName}, Turkey`);
            }
            if (normalizedDistrict && normalizedProvince) {
                const addressWords = address.split(' ').filter(word =>
                    word.length > 2 &&
                    !word.match(/^(no|:|\d+)$/i) &&
                    !word.match(/^(mahallesi|caddesi|sokağı|bulvarı)$/i)
                );
                if (addressWords.length >= 2) {
                    const importantWords = addressWords.slice(0, Math.min(3, addressWords.length)).join(' ');
                    strategies.push(`${importantWords}, ${normalizedDistrict}, ${normalizedProvince}, Turkey`);
                }
            }
            if (normalizedProvince) {
                strategies.push(`${normalizedProvince}, Turkey`);
            }
            return [...new Set(strategies)].filter(s => s.trim() !== ', Turkey' && s.trim() !== ', Türkiye');
        }

        function tryGeocoding(strategies, index) {
            if (index >= strategies.length) {
                showNoResultsMessage();
                return;
            }
            const searchQuery = strategies[index];
            tryNominatimGeocoding(searchQuery, index, strategies);
        }

        function tryNominatimGeocoding(searchQuery, index, strategies) {
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(searchQuery)}&limit=3&addressdetails=1&countrycodes=tr`;
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data && data.length > 0) {
                        const originalAddress = addressInput.value.trim();
                        const validResults = validateResults(data, originalAddress, searchQuery);
                        if (validResults.length > 0) {
                            const bestResult = validResults.reduce((best, current) => {
                                const bestImportance = parseFloat(best.importance) || 0;
                                const currentImportance = parseFloat(current.importance) || 0;
                                return currentImportance > bestImportance ? current : best;
                            });
                            let lat = parseFloat(bestResult.lat);
                            let lng = parseFloat(bestResult.lon);
                            if (!isNaN(lat) && !isNaN(lng)) {
                                const originalAddress = addressInput.value.trim();
                                const hasSokak = /(caddesi|sokağı|bulvarı)/i.test(originalAddress);
                                const isOnlyMahalle = bestResult.display_name.toLowerCase().includes('mahallesi') &&
                                    !bestResult.display_name.toLowerCase().includes('bulvar') &&
                                    !bestResult.display_name.toLowerCase().includes('cadde') &&
                                    !bestResult.display_name.toLowerCase().includes('sokak');
                                if (hasSokak && isOnlyMahalle) {
                                    const offsetLat = (Math.random() - 0.5) * 0.004;
                                    const offsetLng = (Math.random() - 0.5) * 0.004;
                                    lat = lat + offsetLat;
                                    lng = lng + offsetLng;
                                }
                                latInput.value = lat;
                                lngInput.value = lng;
                                updateMapIframe(lat, lng);
                                hideLoading();
                                showSuccessMessage(bestResult.display_name + (hasSokak && isOnlyMahalle ? ' (Yaklaşık konum)' : ''));
                                return;
                            }
                        }
                    }
                    tryGoogleMapsGeocoding(searchQuery, index, strategies);
                })
                .catch(error => {
                    console.error('Nominatim error:', error);
                    tryGeocoding(strategies, index + 1);
                });
        }

        function tryGoogleMapsGeocoding(searchQuery, index, strategies) {
            const apiKey = 'AIzaSyBY5EeoyMT0HCzxlCnotyo-E8I-gcBdf34';
            const googleUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(searchQuery)}&key=${apiKey}&region=tr&language=tr`;
            fetch(googleUrl)
                .then(response => response.json())
                .then(data => {
                    if (data && data.status === 'OK' && data.results && data.results.length > 0) {
                        const convertedResults = data.results.map(result => ({
                            lat: result.geometry.location.lat,
                            lon: result.geometry.location.lng,
                            display_name: result.formatted_address,
                            importance: 0.8
                        }));
                        const originalAddress = addressInput.value.trim();
                        const validResults = validateResults(convertedResults, originalAddress, searchQuery);
                        if (validResults.length > 0) {
                            const bestResult = validResults.reduce((best, current) => {
                                const bestImportance = parseFloat(best.importance) || 0;
                                const currentImportance = parseFloat(current.importance) || 0;
                                return currentImportance > bestImportance ? current : best;
                            });
                            const lat = parseFloat(bestResult.lat);
                            const lng = parseFloat(bestResult.lon);
                            if (!isNaN(lat) && !isNaN(lng)) {
                                latInput.value = lat;
                                lngInput.value = lng;
                                updateMapIframe(lat, lng);
                                hideLoading();
                                showSuccessMessage(bestResult.display_name + ' (Google Maps)');
                                return;
                            }
                        }
                    }
                    tryGeocoding(strategies, index + 1);
                })
                .catch(error => {
                    console.error('Google Maps API error:', error);
                    tryGeocoding(strategies, index + 1);
                });
        }

        function normalizeText(text) {
            if (!text) return '';
            return text.toLowerCase()
                .replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's').replace(/ı/g, 'i')
                .replace(/ö/g, 'o').replace(/ç/g, 'c').replace(/İ/g, 'i').replace(/Ğ/g, 'g')
                .replace(/Ü/g, 'u').replace(/Ş/g, 's').replace(/Ö/g, 'o').replace(/Ç/g, 'c')
                .replace(/i̇/g, 'i').replace(/İ/g, 'i').replace(/ı/g, 'i')
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        function validateResults(results, originalAddress, searchQuery) {
            const validResults = [];
            const provinceSelect = document.querySelector('select[name="province"]');
            const districtSelect = document.querySelector('select[name="district"]');
            const expectedProvince = normalizeText(provinceSelect?.selectedOptions[0]?.textContent?.trim()) || '';
            const expectedDistrict = normalizeText(districtSelect?.selectedOptions[0]?.textContent?.trim()) || '';
            const hasSpecificAddress = originalAddress.length > 20;
            const hasMahalle = /mahallesi/i.test(originalAddress);
            const hasSokak = /(caddesi|sokağı|bulvarı)/i.test(originalAddress);

            for (const result of results) {
                const displayName = normalizeText(result.display_name);
                let isValid = true;
                let score = 0;
                if (expectedProvince && expectedProvince !== 'il') {
                    if (displayName.includes(expectedProvince)) {
                        score += 10;
                    } else {
                        isValid = false;
                    }
                }
                if (expectedDistrict && expectedDistrict !== 'ilce') {
                    if (displayName.includes(expectedDistrict)) {
                        score += 5;
                    } else {
                        score -= 2;
                    }
                }
                if (hasSpecificAddress) {
                    const isGenericResult = displayName.split(',').length <= 3;
                    if (hasMahalle) {
                        const mahalleMatch = originalAddress.match(/([0-9a-zA-ZğüşıöçĞÜŞİÖÇ\s]+?)\s+mahallesi/i);
                        if (mahalleMatch) {
                            const mahalleName = normalizeText(mahalleMatch[1].trim());
                            if (displayName.includes(mahalleName)) {
                                score += 10;
                            } else if (isGenericResult) {
                                score -= 5;
                            }
                        }
                    }
                    if (hasSokak) {
                        const addressAfterMahalle = originalAddress.replace(/^.*?mahallesi\s+/, '');
                        const sokakMatch = addressAfterMahalle.match(/([0-9a-zA-ZğüşıöçĞÜŞİÖÇ\s]+?)\s+(caddesi|sokağı|bulvarı)/i);
                        if (sokakMatch) {
                            const sokakName = normalizeText(sokakMatch[1].trim());
                            if (displayName.includes(sokakName)) {
                                score += 20;
                            } else {
                                const sokakWords = sokakName.split(' ');
                                let partialMatch = false;
                                for (const word of sokakWords) {
                                    if (word.length > 3 && displayName.includes(word)) {
                                        score += 5;
                                        partialMatch = true;
                                    }
                                }
                                if (!partialMatch && isGenericResult) {
                                    score -= 10;
                                }
                            }
                        }
                    }
                    if (isGenericResult && (hasMahalle || hasSokak)) {
                        score -= 3;
                    }
                }
                if (!expectedProvince || expectedProvince === 'il') {
                    isValid = true;
                    score = Math.max(score, 1);
                }
                if (isValid && score >= 0) {
                    result.validationScore = score;
                    validResults.push(result);
                }
            }
            return validResults.sort((a, b) => (b.validationScore || 0) - (a.validationScore || 0));
        }

        function showSuccessMessage(locationName) {
            const message = document.createElement('div');
            message.style.cssText = `position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 10px 15px; border-radius: 5px; z-index: 9999; font-size: 14px; max-width: 300px;`;
            message.textContent = `Konum bulundu: ${locationName.split(',').slice(0, 2).join(',')}`;
            document.body.appendChild(message);
            setTimeout(() => {
                document.body.removeChild(message);
            }, 3000);
        }

        function showNoResultsMessage() {
            hideLoading();
            const message = document.createElement('div');
            message.style.cssText = `position: fixed; top: 20px; right: 20px; background: #ffc107; color: #212529; padding: 10px 15px; border-radius: 5px; z-index: 9999; font-size: 14px; max-width: 300px;`;
            message.textContent = 'Adres için konum bulunamadı. Lütfen daha genel bir adres yazın.';
            document.body.appendChild(message);
            setTimeout(() => {
                document.body.removeChild(message);
            }, 4000);
        }

        function updateMapIframe(lat, lng) {
            if (!mapIframe || isNaN(lat) || isNaN(lng)) {
                return;
            }
            try {
                const newSrc = `https://www.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
                mapIframe.src = newSrc;
            } catch (error) {
                console.error('Error updating map iframe:', error);
            }
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func.apply(this, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function updateMapForLocation() {
            const provinceSelect = document.querySelector('select[name="province"]');
            const districtSelect = document.querySelector('select[name="district"]');
            const selectedProvince = provinceSelect?.selectedOptions[0]?.textContent?.trim();
            const selectedDistrict = districtSelect?.selectedOptions[0]?.textContent?.trim();
            if (selectedProvince && selectedProvince !== 'İl') {
                let searchQuery = selectedProvince;
                if (selectedDistrict && selectedDistrict !== 'İlçe') {
                    searchQuery = `${selectedDistrict}, ${selectedProvince}`;
                }
                showLoading();
                geocodeAddress(searchQuery);
            }
        }

        const provinceSelect = document.querySelector('select[name="province"]');
        const districtSelect = document.querySelector('select[name="district"]');
        if (provinceSelect) {
            provinceSelect.addEventListener('change', function() {
                setTimeout(updateMapForLocation, 500);
            });
        }
        if (districtSelect) {
            districtSelect.addEventListener('change', updateMapForLocation);
        }
    });
</script>

<script>
    $(function() {
        // Add the redirect parameter to the form action URL
        const urlParams = new URLSearchParams(window.location.search);
        const redirectParam = urlParams.get('redirect');
        const form = $('#profile-update-form');

        if (redirectParam) {
            // Create a hidden input to pass the redirect URL
            form.append('<input type="hidden" name="redirect" value="' + redirectParam + '">');
        }

        form.on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var button = form.find('button[type="submit"]');
            var buttonText = button.html();

            // Clear previous errors
            form.find('.ajax-error').remove();
            form.find('.is-invalid').removeClass('is-invalid');
            button.prop('disabled', true).html('Kaydediliyor...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST', // FormData requires POST
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message || 'Profil başarıyla güncellendi.', 'Başarılı');

                    if (response.redirect) {
                        toastr.info('Bilgileriniz tamamlandı, şimdi yönlendiriliyorsunuz...', 'Yönlendiriliyor');
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000); // Wait 2 seconds
                    } else {
                        if (response.avatar_url) {
                            $('.profile-edit-avatar').attr('src', response.avatar_url);
                            // Update header avatar if it exists
                            $('#header-avatar').attr('src', response.avatar_url);
                        }
                        button.prop('disabled', false).html(buttonText);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var response = xhr.responseJSON;
                        if (response.message) {
                            toastr.error(response.message, 'Hata');
                        }
                        if (response.errors) {
                            // Display validation errors
                            $.each(response.errors, function(key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                var errorContainer = input.closest('.input-field').length ? input.closest('.input-field') : input.parent();
                                errorContainer.append('<div class="ajax-error text-danger small mt-1">' + value[0] + '</div>');
                            });
                            if (response.errors[Object.keys(response.errors)[0]]) {
                                toastr.error(response.errors[Object.keys(response.errors)[0]][0], 'Doğrulama Hatası');
                            }
                        }
                    } else {
                        toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.', 'Hata');
                    }
                    button.prop('disabled', false).html(buttonText);
                },
            });
        });
    });
</script>
@endsection