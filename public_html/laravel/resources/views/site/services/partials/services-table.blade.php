@forelse($services as $service)
<tr>
  <td>{{ $service->id }}</td>
  <td>
    <div class="tumhizmetlerimg">
      <img src="{{ asset($service->photos->first()['path'] ?? 'images/default-avatar.png') }}" alt="{{ $service->title }}">
    </div>
  </td>
  <td>
    <div class="tumhizmetler-name">
      <h2>{{ $service->title }}</h2>
      <h3>{{ $service?->category?->name }} / {{ $service?->subCategory?->name }}</h3>
    </div>
  </td>
  <td>
    <div class="tumhizmetlerfiyatarea">
      <div class="tumhizmetlerfiyattrigger" data-service-id="{{ $service->id }}">{{ number_format($service->price, 0, ',', '.') }} TL</div>
      <div class="tumhizmetlerfiyatbox">
        <b>Fiyat</b>
        <div class="price-input-wrapper">
          <input type="text" class="price-input" value="{{ intval($service->price) }}" placeholder="0">
          <span class="price-suffix">TL</span>
        </div>
        <div class="tumhizmetlerlerfiyatbox-islem">
          <button class="tumhizmetler-closed">Vazgeç</button>
          <button class="tumhizmetler-update" data-service-id="{{ $service->id }}">Güncelle</button>
        </div>
      </div>
    </div>
  </td>
  <td>{{ $service->view_count ?? 0 }}</td>
  <td>{{ $service->saved_count ?? 0 }}</td>
  <td>{{ $service->created_at->format('d.m.Y') }}</td>
  <td>
    <div class="tumhizmetler-status {{ $service->status ? 'statson' : 'statsoff' }}">
      <span>{{ $service->status ? 'Aktif' : 'Pasif' }}</span>
    </div>
  </td>
  <td>
    <div class="tumhizmetler-islemler">
      <div class="tumhizmetler-islemlerbox edit tooltipp tooltipp2">
        <span class="tooltiptext">Düzenle</span>
        <a href="{{ route('company.services.edit', $service->id) }}">
          <i class="fa-solid fa-pen-to-square" style="color: white !important;"></i>
        </a>
      </div>
      <div class="tumhizmetler-islemlerbox status {{ $service->status ? 'inactive' : 'active' }} tooltipp tooltipp2">
        <span class="tooltiptext">{{ $service->status ? 'Pasif Et' : 'Aktif Et' }}</span>
        <a href="{{ route('company.services.status', $service->id) }}">
          <i class="fa-solid {{ $service->status ? 'fa-eye-slash' : 'fa-eye' }}" style="color: white !important;"></i>
        </a>
      </div>
      <div class="tumhizmetler-islemlerbox remove tooltipp tooltipp2">
        <span class="tooltiptext">Sil</span>
        <form action="{{ route('company.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu servisi silmek istediğinize emin misiniz?')">
          @csrf
          @method('DELETE')
          <a href="javascript:void(0)" onclick="this.closest('form').submit()">
            <i class="fa-solid fa-trash" style="color: white !important;"></i>
          </a>
        </form>
      </div>
    </div>
  </td>
</tr>
@empty
<tr>
  <td colspan="9" class="text-center py-4">
    <p>Arama kriterlerinize uygun hizmet bulunamadı.</p>
    @if(!request('search') && !request('status'))
    <a href="{{ route('company.services.create') }}" class="btn btn-primary">İlk Hizmetinizi Ekleyin</a>
    @endif
  </td>
</tr>
@endforelse