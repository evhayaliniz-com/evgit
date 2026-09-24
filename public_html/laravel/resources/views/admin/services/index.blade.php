@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Hizmetler ({{$serviceCount}})</h5>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Başlangıç Tarihi</label>
                            <input type="date" name="start_date" class="form-control" value="{{request()->start_date}}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Bitiş Tarihi</label>
                            <input type="date" name="end_date" class="form-control" value="{{request()->end_date}}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="">Alt Kategori</label>
                                <select name="sub_category" class="form-select">
                                    <option value="">Tümü</option>
                                    @foreach($subCategories as $subCategory)
                                        <option value="{{$subCategory->id}}" @selected(request()?->sub_category == $subCategory->id)>
                                            {{$subCategory->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Servis Adı</label>
                            <input type="text" class="form-control" name="service_name"
                                   value="{{request()->service_name}}">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Firma Adı</label>
                            <input type="text" class="form-control" name="company_name"
                                   value="{{request()->company_name}}">
                        </div>
                    </div>
                </div>


                <div class="text-end">
                    <a href="{{route('admin.services.index')}}" class="btn btn-danger">Temizle</a>
                    <button type="submit" class="btn btn-info">Filtrele</button>
                </div>
            </form>


            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Firma Adı</th>
                        <th>Üst Kategori</th>
                        <th>Alt Kategori</th>
                        <th>Ücret</th>
                        <th>İl</th>
                        <th>İlçe</th>
                        <th>Görüntülenme</th>
                        <th>Mesajlaşma</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Ödeme Türü</th>
                        <th>Durum</th>
                        <th>Onay Durumu</th>
                        <th>İşlemler</th>
                        <th>Açıklama</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($services as $service)
                        <tr>
                            <!-- Başlık sütunu, sınırlı genişlik ve metin kısaltma -->
                            <td class="text-truncate" style="max-width: 200px;">
                                <span title="{{ $service->title }}">{{ Str::limit($service->title, 30) }}</span>
                                @if(strlen($service->title) > 30)
                                    <a href="#descriptionModal-{{ $service->id }}" data-bs-toggle="modal" class="ms-1">
                                        <i class="bx bx-info-circle"></i>
                                    </a>
                                @endif
                            </td>
                            <td>{{$service->company?->name}}</td>
                            <td>{{ $service->category?->name }}</td>
                            <td>{{ $service->subCategory?->name }}</td>
                            <td>{{ number_format($service->price) }} TL</td>
                            <td>{{ $service->province?->name }}</td>
                            <td>{{ $service->district?->name }}</td>
                            <td>{{ $service->viewCount() }}</td>
                            <td>
                                <a href="#">görüntüle</a>
                            </td>
                            <td>{{\Carbon\Carbon::parse($service->created_at)->tz('Europe/Istanbul')->format('d.m.Y')}}</td>
                            <td>{{ $service->payment_type == 'card' ? 'Kart' : 'Nakit' }}</td>
                            <td>
                                @if($service->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                            <td>
                                @if($service->is_confirmed)
                                    <span class="badge bg-label-success">Onaylı</span>
                                @else
                                    <span class="badge bg-label-warning">Onay Bekliyor</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.services.edit', $service->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Düzenle
                                </a>

                                @if($service->is_confirmed)
                                    <form action="{{ route('admin.services.unconfirm', $service->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bu hizmetin onayını kaldırmak istediğinize emin misiniz?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            <i class="bx bx-x"></i> Onayı Kaldır
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.services.confirm', $service->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bu hizmeti onaylamak istediğinize emin misiniz?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bx bx-check"></i> Onayla
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu hizmeti silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i> Sil
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#descriptionModal-{{$service->id}}">
                                    görüntüle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Henüz hizmet eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {!! $services->links() !!}
            </div>
        </div>
    </div>
@endsection
