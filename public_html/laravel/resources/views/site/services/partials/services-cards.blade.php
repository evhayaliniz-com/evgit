@forelse($services as $service)
<div class="col-sm-6 col-md-4 col-lg-3">
    <div class="popular-services-cards">
        <div class="psc-img">
            <a href="{{ route('services.show', $service->slug) }}">
                <img src="{{ asset($service->photos->first()['path'] ?? 'images/default-avatar.png') }}" alt="{{ $service->title }}">
            </a>
            
            <div class="fpedit-decor">
                <div class="d-flex edit">
                    <a href="{{ route('company.services.edit', $service->id) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Düzenle
                    </a>
                </div>

                <div class="d-flex">
                    <a href="{{ route('company.services.status', $service->id) }}">
                        {{ $service->status ? 'Pasif Yap' : 'Aktif Yap' }}
                    </a>
                </div>

                <div class="d-flex remove">
                    <form action="{{ route('company.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <a href="javascript:void(0)" onclick="this.closest('form').submit()">
                            <i class="fa-solid fa-trash"></i>
                            Sil
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="psd-texts">
            <h3>
                <a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a>
            </h3>
            <div class="psd-texts-icons">
                <div class="pti-area">
                    <i class="fa-solid fa-tag"></i>
                    <span>{{ $service?->category?->name }} / {{ $service?->subCategory?->name }}</span>
                </div>
                <div class="pti-area">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ $service->province->name }} / {{ $service->district->name }}</span>
                </div>
            </div>

            <div class="firma-goruntulenme d-flex mt-2">
                <span style="font-size: 13px!important;">Görüntülenme</span>
                <b>{{ $service->view_count ?? 0 }}</b>
            </div>
            
            <div class="firma-goruntulenme d-flex mt-1">
                <span style="font-size: 13px!important;">Kaydetme</span>
                <b>{{ $service->saved_count ?? 0 }}</b>
            </div>

            <div class="psd-firma">
                <a href="{{ route('companies.show', $service->company->slug) }}" class="d-flex gap-2">
                    <img src="{{ asset($service->company->avatar) }}" alt="{{ $service->company->name }}" style="width: 20px; height: 20px; border-radius: 50%">
                    <span>{{ $service->company->name }}</span>
                </a>
            </div>

            <div class="psd-prices">
                <div class="psd-prices-left">
                    <x-old-prices :prices="$service->oldPrices" />
                    <div class="price-edit-area">
                        <span class="price-trigger" data-service-id="{{ $service->id }}">
                            {{ number_format($service->price, 0, ',', '.') }} TL
                        </span>
                        <div class="price-edit-box">
                            <b>Fiyat Düzenle</b>
                            <input type="number" value="{{ $service->price }}" step="0.01" min="0">
                            <div class="price-edit-actions">
                                <button class="btn-cancel">Vazgeç</button>
                                <button class="btn-update" data-service-id="{{ $service->id }}">Güncelle</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="psd-prices-right">
                    {{ $service->payment_type == 'card' ? 'Kart' : 'Nakit' }}
                </div>
            </div>
            
            <div class="service-status mt-2">
                <span class="badge {{ $service->status ? 'bg-success' : 'bg-secondary' }}">
                    {{ $service->status ? 'Aktif' : 'Pasif' }}
                </span>
                <small class="text-muted">{{ $service->created_at->format('d.m.Y') }}</small>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-4">
    <p>Arama kriterlerinize uygun hizmet bulunamadı.</p>
    @if(!request('search') && !request('status'))
    <a href="{{ route('company.services.create') }}" class="btn btn-primary">İlk Hizmetinizi Ekleyin</a>
    @endif
</div>
@endforelse
