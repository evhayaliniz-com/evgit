@forelse($ideas as $idea)
  @php
    $decodedPaths = is_string($idea->path) ? json_decode($idea->path, true) : (is_array($idea->path) ? $idea->path : []);
    $validPaths = is_array($decodedPaths) ? array_values(array_filter($decodedPaths)) : [];
    $firstPhotoPath = $validPaths[0] ?? ($idea->cover_photo ?: 'site/images/default-avatar.png');
    $photoUrl = asset($firstPhotoPath);
    $fallbackUrl = asset('site/images/default-avatar.png');
    $photoCount = count($validPaths);
    $displayTitle = $idea->title ? trim($idea->title) : \Illuminate\Support\Str::limit(trim($idea->content), 90);
    $displaySubtext = $idea->title ? \Illuminate\Support\Str::limit(trim($idea->content), 100) : null;
  @endphp
  <tr class="ms-service-row" data-row-id="{{ $idea->id }}" data-status="{{ $idea->status ? 'aktif' : 'pasif' }}" data-confirmed="{{ $idea->is_confirmed ? '1' : '0' }}">
    {{-- 1. ID --}}
    <td class="ms-col-id" data-label="ID">
      <span class="ms-id-badge">#{{ $idea->id }}</span>
    </td>

    {{-- 2. Görsel --}}
    <td class="ms-col-thumb" data-label="Görsel">
      <div class="ms-thumb-wrap">
        <img
          src="{{ $photoUrl }}"
          alt="{{ $displayTitle }}"
          class="ms-thumb-img"
          loading="lazy"
          onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';"
        >
        @if($photoCount > 1)
          <span class="ms-photo-count" title="{{ $photoCount }} Görsel">
            <i class="fa-regular fa-images"></i> {{ $photoCount }}
          </span>
        @endif
      </div>
    </td>

    {{-- 3. Fikir İçeriği & Kategori --}}
    <td class="ms-col-title" data-label="Fikir & Kategori">
      <div class="ms-title-block">
        <div class="ms-title-row">
          @if($idea->status && $idea->slug)
            <a href="{{ route('idea.show', $idea->slug) }}" target="_blank" class="ms-service-title-link" title="Fikri Görüntüle">
              {{ $displayTitle }}
              <i class="fa-solid fa-arrow-up-right-from-square ms-external-icon"></i>
            </a>
          @else
            <a href="{{ route('idea.edit', $idea->id) }}" class="ms-service-title-link" title="Fikri Düzenle">
              {{ $displayTitle }}
            </a>
          @endif
        </div>
        @if($displaySubtext)
          <p class="ms-idea-excerpt">{{ $displaySubtext }}</p>
        @endif
        <div class="ms-category-crumbs">
          @if($idea->category)
            <span class="ms-cat-tag">
              <i class="fa-solid fa-lightbulb"></i>
              {{ $idea->category->name }}
              @if($idea->subCategory)
                <span class="ms-cat-sep">/</span> {{ $idea->subCategory->name }}
              @endif
            </span>
          @else
            <span class="ms-cat-tag">
              <i class="fa-solid fa-lightbulb"></i> Genel Tasarım Fikri
            </span>
          @endif
        </div>
      </div>
    </td>

    {{-- 4. Görüntülenme --}}
    <td class="ms-col-metric" data-label="Görüntülenme">
      <span class="ms-metric-pill" title="Toplam Görüntülenme">
        <i class="fa-regular fa-eye"></i>
        <span>{{ number_format($idea->view_count ?? 0, 0, ',', '.') }}</span>
      </span>
    </td>

    {{-- 5. Beğeni --}}
    <td class="ms-col-metric" data-label="Beğeni">
      <span class="ms-metric-pill ms-metric-likes" title="Toplam Beğeni">
        <i class="fa-regular fa-heart"></i>
        <span>{{ number_format($idea->like_count ?? 0, 0, ',', '.') }}</span>
      </span>
    </td>

    {{-- 6. Yorum --}}
    <td class="ms-col-metric" data-label="Yorum">
      <span class="ms-metric-pill ms-metric-comments" title="Toplam Yorum">
        <i class="fa-regular fa-comment"></i>
        <span>{{ number_format($idea->reply_count ?? 0, 0, ',', '.') }}</span>
      </span>
    </td>

    {{-- 7. Durum & Onay --}}
    <td class="ms-col-status" data-label="Durum">
      <div class="ms-status-stack">
        @if($idea->status)
          <span class="ms-status-badge ms-status-active js-status-badge" data-idea-id="{{ $idea->id }}">
            <span class="ms-status-dot"></span>
            <span class="js-status-text">Aktif</span>
          </span>
        @else
          <span class="ms-status-badge ms-status-passive js-status-badge" data-idea-id="{{ $idea->id }}">
            <span class="ms-status-dot"></span>
            <span class="js-status-text">Pasif</span>
          </span>
        @endif

        @if($idea->is_confirmed)
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

    {{-- 8. Eklenme Tarihi --}}
    <td class="ms-col-date" data-label="Tarih">
      <div class="ms-date-wrap" title="{{ $idea->created_at?->format('d.m.Y H:i') }}">
        <span class="ms-date-day">{{ $idea->created_at?->format('d.m.Y') }}</span>
        <span class="ms-date-time">{{ $idea->created_at?->format('H:i') }}</span>
      </div>
    </td>

    {{-- 9. İşlemler --}}
    <td class="ms-col-actions" data-label="İşlemler">
      <div class="ms-actions-group">
        {{-- Düzenle --}}
        <a
          href="{{ route('idea.edit', $idea->id) }}"
          class="ms-action-btn ms-action-edit"
          title="Fikri Düzenle"
          aria-label="Fikri Düzenle"
        >
          <i class="fa-solid fa-pen-to-square"></i>
          <span class="ms-action-label">Düzenle</span>
        </a>

        {{-- Aktif / Pasif Et (AJAX) --}}
        <button
          type="button"
          class="ms-action-btn {{ $idea->status ? 'ms-action-deactivate' : 'ms-action-activate' }} js-toggle-status"
          data-idea-id="{{ $idea->id }}"
          data-url="{{ route('idea.profile.status', $idea->id) }}"
          data-current-status="{{ $idea->status ? 1 : 0 }}"
          title="{{ $idea->status ? 'Fikri Pasife Al' : 'Fikri Aktif Et' }}"
          aria-label="{{ $idea->status ? 'Fikri Pasife Al' : 'Fikri Aktif Et' }}"
        >
          <i class="fa-solid {{ $idea->status ? 'fa-ban' : 'fa-check' }} js-toggle-icon"></i>
          <span class="ms-action-label js-toggle-label">{{ $idea->status ? 'Pasif Et' : 'Aktif Et' }}</span>
        </button>

        {{-- Sil --}}
        <button
          type="button"
          class="ms-action-btn ms-action-delete js-delete-idea"
          data-idea-id="{{ $idea->id }}"
          data-idea-title="{{ \Illuminate\Support\Str::limit($displayTitle, 60) }}"
          data-url="{{ route('idea.destroy', $idea->id) }}"
          title="Fikri Sil"
          aria-label="Fikri Sil"
        >
          <i class="fa-regular fa-trash-can"></i>
          <span class="ms-action-label">Sil</span>
        </button>
      </div>
    </td>
  </tr>
@empty
  <tr class="ms-empty-row">
    <td colspan="9" class="ms-empty-cell">
      <div class="ms-empty-state">
        <div class="ms-empty-icon">
          <i class="fa-solid fa-lightbulb"></i>
        </div>
        <h6 class="ms-empty-title">Gösterilecek fikir bulunamadı</h6>
        <p class="ms-empty-desc">
          Arama kriterlerinize uygun bir tasarım fikri bulamadık veya henüz bir fikir paylaşmadınız.
        </p>
        <div class="ms-empty-actions">
          <button type="button" class="ms-btn-reset js-reset-filters" style="display: none;">
            <i class="fa-solid fa-rotate-left"></i> Filtreleri Temizle
          </button>
          <a href="{{ route('idea.create') }}" class="ms-btn-primary">
            <i class="fa-solid fa-plus"></i> Yeni Fikir Oluştur
          </a>
        </div>
      </div>
    </td>
  </tr>
@endforelse
