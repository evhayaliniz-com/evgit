@forelse($services as $service)
  @php
    $firstPhoto = $service->photos->first();
    $photoPath = $firstPhoto ? $firstPhoto->path : ($service->cover_photo ?: 'site/images/default-avatar.png');
    $photoUrl = asset($photoPath);
    $fallbackUrl = asset('site/images/default-avatar.png');
    $formattedPrice = number_format($service->price, 0, ',', '.');
    $rawPrice = intval($service->price);
  @endphp
  <tr class="ms-service-row" data-row-id="{{ $service->id }}" data-status="{{ $service->status ? 'aktif' : 'pasif' }}" data-confirmed="{{ $service->is_confirmed ? '1' : '0' }}">
    {{-- 1. ID --}}
    <td class="ms-col-id" data-label="ID">
      <span class="ms-id-badge">#{{ $service->id }}</span>
    </td>

    {{-- 2. Görsel --}}
    <td class="ms-col-thumb" data-label="Görsel">
      <div class="ms-thumb-wrap">
        <img
          src="{{ $photoUrl }}"
          alt="{{ $service->title }}"
          class="ms-thumb-img"
          loading="lazy"
          onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';"
        >
        @if($service->photos->count() > 1)
          <span class="ms-photo-count" title="{{ $service->photos->count() }} Fotoğraf">
            <i class="fa-regular fa-images"></i> {{ $service->photos->count() }}
          </span>
        @endif
      </div>
    </td>

    {{-- 3. Hizmet Adı & Kategori --}}
    <td class="ms-col-title" data-label="Hizmet Adı">
      <div class="ms-title-block">
        <div class="ms-title-row">
          @if($service->status && $service->is_confirmed)
            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="ms-service-title-link" title="Sitede Görüntüle">
              {{ $service->title }}
              <i class="fa-solid fa-arrow-up-right-from-square ms-external-icon"></i>
            </a>
          @else
            <a href="{{ route('company.services.edit', $service->id) }}" class="ms-service-title-link" title="Hizmeti Düzenle">
              {{ $service->title }}
            </a>
          @endif
        </div>
        <div class="ms-category-crumbs">
          @if($service->category)
            <span class="ms-cat-tag">
              <i class="fa-solid fa-layer-group"></i>
              {{ $service->category->name }}
              @if($service->subCategory)
                <span class="ms-cat-sep">/</span> {{ $service->subCategory->name }}
              @endif
            </span>
          @endif
        </div>
      </div>
    </td>

    {{-- 4. Fiyat (Satır İçi Hızlı Düzenleme) --}}
    <td class="ms-col-price" data-label="Fiyat">
      <div class="ms-price-cell">
        <button
          type="button"
          class="tumhizmetlerfiyattrigger ms-price-trigger"
          data-service-id="{{ $service->id }}"
          title="Fiyatı hızlı düzenlemek için tıklayın"
          aria-label="Fiyatı Düzenle: {{ $formattedPrice }} TL"
        >
          <span class="ms-price-val">{{ $formattedPrice }} TL</span>
          <span class="ms-price-edit-icon"><i class="fa-solid fa-pen"></i></span>
        </button>

        <div class="tumhizmetlerfiyatbox ms-price-popover" data-service-id="{{ $service->id }}" role="dialog" aria-label="Fiyat Güncelle">
          <div class="ms-price-popover-header">
            <span>Fiyatı Güncelle</span>
            <button type="button" class="tumhizmetler-closed ms-popover-close" aria-label="Kapat">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="ms-price-input-group">
            <input
              type="text"
              inputmode="numeric"
              class="price-input ms-price-input"
              value="{{ $formattedPrice }}"
              data-raw-price="{{ $rawPrice }}"
              data-service-id="{{ $service->id }}"
              placeholder="Fiyat"
              autocomplete="off"
            >
            <span class="ms-price-currency">₺</span>
          </div>
          <div class="ms-price-popover-actions">
            <button type="button" class="tumhizmetler-closed ms-btn-cancel" data-service-id="{{ $service->id }}">
              Vazgeç
            </button>
            <button type="button" class="tumhizmetler-update ms-btn-save" data-service-id="{{ $service->id }}">
              <i class="fa-solid fa-check"></i> Kaydet
            </button>
          </div>
        </div>
      </div>
    </td>

    {{-- 5. Konum (Şehir / İlçe) --}}
    <td class="ms-col-location" data-label="Konum">
      <div class="ms-location-wrap">
        <i class="fa-solid fa-location-dot ms-loc-icon"></i>
        <div>
          <div class="ms-province-name">{{ $service->province->name ?? '-' }}</div>
          @if($service->district)
            <div class="ms-district-name">{{ $service->district->name }}</div>
          @endif
        </div>
      </div>
    </td>

    {{-- 6. Görüntülenme --}}
    <td class="ms-col-metric" data-label="Görüntülenme">
      <span class="ms-metric-pill" title="Toplam Görüntülenme">
        <i class="fa-regular fa-eye"></i>
        <span>{{ number_format($service->view_count ?? 0, 0, ',', '.') }}</span>
      </span>
    </td>

    {{-- 7. Kaydedilme --}}
    <td class="ms-col-metric" data-label="Kaydedilme">
      <span class="ms-metric-pill ms-metric-saved" title="Favorilere Eklenme / Kaydedilme">
        <i class="fa-regular fa-bookmark"></i>
        <span>{{ number_format($service->saved_count ?? 0, 0, ',', '.') }}</span>
      </span>
    </td>

    {{-- 8. Durum & Onay --}}
    <td class="ms-col-status" data-label="Durum">
      <div class="ms-status-stack">
        @if($service->status)
          <span class="ms-status-badge ms-status-active js-status-badge" data-service-id="{{ $service->id }}">
            <span class="ms-status-dot"></span>
            <span class="js-status-text">Aktif</span>
          </span>
        @else
          <span class="ms-status-badge ms-status-passive js-status-badge" data-service-id="{{ $service->id }}">
            <span class="ms-status-dot"></span>
            <span class="js-status-text">Pasif</span>
          </span>
        @endif

        @if($service->is_confirmed)
          <span class="ms-approval-badge ms-approval-confirmed" title="Yönetici tarafından onaylandı">
            <i class="fa-solid fa-circle-check"></i> Onaylı
          </span>
        @else
          <span class="ms-approval-badge ms-approval-pending" title="Yönetici onayı bekleniyor">
            <i class="fa-solid fa-clock"></i> Onay Bekliyor
          </span>
        @endif
      </div>
    </td>

    {{-- 9. Eklenme Tarihi --}}
    <td class="ms-col-date" data-label="Tarih">
      <div class="ms-date-wrap" title="{{ $service->created_at?->format('d.m.Y H:i') }}">
        <span class="ms-date-day">{{ $service->created_at?->format('d.m.Y') }}</span>
        <span class="ms-date-time">{{ $service->created_at?->format('H:i') }}</span>
      </div>
    </td>

    {{-- 10. İşlemler --}}
    <td class="ms-col-actions" data-label="İşlemler">
      <div class="ms-actions-group">
        {{-- Düzenle --}}
        <a
          href="{{ route('company.services.edit', $service->id) }}"
          class="ms-action-btn ms-action-edit"
          title="Hizmeti Düzenle"
          aria-label="Hizmeti Düzenle"
        >
          <i class="fa-solid fa-pen-to-square"></i>
          <span class="ms-action-label">Düzenle</span>
        </a>

        {{-- Aktif / Pasif Et (AJAX + Fallback) --}}
        <button
          type="button"
          class="ms-action-btn {{ $service->status ? 'ms-action-deactivate' : 'ms-action-activate' }} js-toggle-status"
          data-service-id="{{ $service->id }}"
          data-url="{{ route('company.services.status', $service->id) }}"
          data-current-status="{{ $service->status ? 1 : 0 }}"
          title="{{ $service->status ? 'Hizmeti Pasife Al' : 'Hizmeti Aktif Et' }}"
          aria-label="{{ $service->status ? 'Hizmeti Pasife Al' : 'Hizmeti Aktif Et' }}"
        >
          <i class="fa-solid {{ $service->status ? 'fa-Toggle-on fa-ban' : 'fa-check' }} js-toggle-icon"></i>
          <span class="ms-action-label js-toggle-label">{{ $service->status ? 'Pasif Et' : 'Aktif Et' }}</span>
        </button>

        {{-- Sil --}}
        <button
          type="button"
          class="ms-action-btn ms-action-delete js-delete-service"
          data-service-id="{{ $service->id }}"
          data-service-title="{{ $service->title }}"
          data-url="{{ route('company.services.destroy', $service->id) }}"
          title="Hizmeti Sil"
          aria-label="Hizmeti Sil"
        >
          <i class="fa-regular fa-trash-can"></i>
          <span class="ms-action-label">Sil</span>
        </button>
      </div>
    </td>
  </tr>
@empty
  <tr class="ms-empty-row">
    <td colspan="10" class="ms-empty-cell">
      <div class="ms-empty-state">
        <div class="ms-empty-icon">
          <i class="fa-solid fa-layer-group"></i>
        </div>
        <h6 class="ms-empty-title">Gösterilecek hizmet bulunamadı</h6>
        <p class="ms-empty-desc">
          Arama kriterlerinize uygun bir hizmet bulamadık veya henüz bir hizmet eklemediniz.
        </p>
        <div class="ms-empty-actions">
          <button type="button" class="ms-btn-reset js-reset-filters" style="display: none;">
            <i class="fa-solid fa-rotate-left"></i> Filtreleri Temizle
          </button>
          <a href="{{ route('company.services.create') }}" class="ms-btn-primary">
            <i class="fa-solid fa-plus"></i> Yeni Hizmet Ekle
          </a>
        </div>
      </div>
    </td>
  </tr>
@endforelse
