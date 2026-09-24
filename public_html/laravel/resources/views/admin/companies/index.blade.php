@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Firmalar ({{$companyCount}})</h5>

            <form action="" method="GET">
                <div class="d-flex gap-3">
                    <div class="form-group">
                        <label for="">Üst Kategori</label>
                        <select name="category" class="form-select" onchange="getSubCategories()">
                            <option value="">Tümü</option>
                            @foreach(get_categories() as $category)
                                <option value="{{$category->id}}" @selected(request()?->category == $category->id)>
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Alt Kategori</label>
                        <select name="sub_category" class="form-select" id="sub-category-select">
                            <option value="">Alt Kategori</option>
                            @if(request()->category)
                                @foreach(get_sub_categories(request()->category) as $subCategory)
                                    <option value="{{$subCategory->id}}" @selected(request()?->sub_category == $subCategory->id)>
                                        {{$subCategory->name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Pro Üyelik</label>
                        <select name="pro_package" class="form-select">
                            <option value="">Tümü</option>
                            @foreach($packages as $package)
                                <option value="{{$package->id}}" @selected(request()?->pro_package == $package->id)>
                                    {{$package->title}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-flex gap-2 align-items-center pt-3">
                        <button type="submit" class="btn btn-info">Filtrele</button>

                        <a href="{{route('admin.companies.index')}}" class="btn btn-danger">Temizle</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Firma Adı</th>
                        <th>E-posta</th>
                        <th>Üst Kategori</th>
                        <th>Alt Kategori</th>
                        <th>Pro Üyelik</th>
                        <th>Aktif Hizmetler</th>
                        <th>Üyelik Tarihi</th>
                        <th>Onaylı Firma</th>
                        <th>İşlemler</th>
                        <th>Tüm Bilgiler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($companies as $company)
                        <tr>
                            <td>
                                <img src="{{ asset($company->avatar) }}" alt="Kullanıcı Görseli"
                                     style="width: 100px; height: 60px; object-fit: cover;" class="rounded shadow-sm">


                                <div class="modal-group">
                                    <div class="modal fade" id="infoModal-{{$company->id}}" tabindex="-1"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Firma Bilgileri</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul>
                                                        <li>
                                                            <b>Firma Adı: </b> {{$company->name}}
                                                        </li>

                                                        <li>
                                                            <b>E-posta Adresi: </b> {{$company->user->email}}
                                                        </li>

                                                        <li>
                                                            <b>Telefon Numarası: </b> {{$company->mobile_phone}}
                                                        </li>

                                                        <li>
                                                            <b>Vergi Numarası: </b> {{$company->tax_number}}
                                                        </li>

                                                        <li>
                                                            <b>İl: </b> {{$company->province}}
                                                        </li>

                                                        <li>
                                                            <b>İlçe: </b> {{$company->district}}
                                                        </li>

                                                        <li>
                                                            <b>Address: </b> {{$company->address}}
                                                        </li>

                                                        <li>
                                                            <b>Harita Lokasyonu: </b> {{$company->map_location}}
                                                        </li>

                                                        <li>
                                                            <b>Kategori: </b> {{$company->category?->name}}
                                                        </li>

                                                        <li>
                                                            <b>Alt Kategori: </b> {{$company->subCategory?->name}}
                                                        </li>

                                                        <li>
                                                            <b>Facebook Linki: </b> {{$company->facebook}}
                                                        </li>

                                                        <li>
                                                            <b>İnstagram Linki: </b> {{$company->instagram}}
                                                        </li>

                                                        <li>
                                                            <b>Youtube Linki: </b> {{$company->youtube}}
                                                        </li>

                                                        <li>
                                                            <b>Website Linki: </b> {{$company->website}}
                                                        </li>

                                                        <li>
                                                            <b>Hakkında: </b>
                                                            <p>{{$company->about}}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Kapat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="addRightModal-{{$company->id}}" tabindex="-1"
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Ek Hizmet</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.companies.extra-right', $company->id)}}"
                                                          method="POST">

                                                        <div class="form-group mb-3">
                                                            <select name="pro_package_id" class="form-select" required>
                                                                <option value="">Paket Seçiniz</option>
                                                                @foreach($packages as $pck)
                                                                    <option value="{{$pck->id}}">{{$pck->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <select name="category_id" class="form-select" required>
                                                                <option value="">Kategori Seçiniz</option>
                                                                @foreach(get_categories() as $cat)
                                                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <input type="number" name="right" placeholder="Hak Sayısı" class="form-control"
                                                                   min="0">

                                                            @error('right')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group mb-3">
                                                            <label for="end_date" class="form-label">Son Geçerlilik Tarihi</label>
                                                            <input type="date" name="end_date" class="form-control">
                                                            <small class="form-text text-muted">Boş bırakılırsa 30 gün sonrası otomatik atanır</small>
                                                            
                                                            @error('end_date')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary mt-2 w-100">
                                                                Ekle
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Kapat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Package Modals -->
                                    @if($company?->purchasedPackages->isNotEmpty())
                                        @foreach($company?->purchasedPackages as $purchasedPackage)
                                            <div class="modal fade" id="editPackageModal-{{$purchasedPackage->id}}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5">Paket Düzenle</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('admin.companies.edit-package', $purchasedPackage->id)}}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Paket</label>
                                                                    <select name="pro_package_id" class="form-select" required>
                                                                        @foreach($packages as $pck)
                                                                            <option value="{{$pck->id}}" @selected($purchasedPackage->pro_package_id == $pck->id)>
                                                                                {{$pck->title}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Kategori</label>
                                                                    <select name="category_id" class="form-select" required>
                                                                        @foreach(get_categories() as $cat)
                                                                            <option value="{{$cat->id}}" @selected($purchasedPackage->category_id == $cat->id)>
                                                                                {{$cat->name}}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <input type="number" name="total_rights" placeholder="Toplam Hak" 
                                                                           class="form-control" min="0" value="{{$purchasedPackage->total_rights}}" required>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label for="end_date" class="form-label">Son Geçerlilik Tarihi</label>
                                                                    <input type="date" name="end_date" class="form-control" 
                                                                           value="{{$purchasedPackage->end_date ? date('Y-m-d', strtotime($purchasedPackage->end_date)) : ''}}">
                                                                    <small class="form-text text-muted">Boş bırakılırsa mevcut tarih korunur</small>
                                                                </div>

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary mt-2 w-100">
                                                                        Güncelle
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                Kapat
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td>{{ $company->name }}</td>
                            <td>{{ $company?->user->email }}</td>
                            <td>{{ $company?->category?->name }}</td>
                            <td>{{ $company?->subCategory?->name }}</td>
                            <td>
                                @if($company?->purchasedPackages->isNotEmpty())
                                    <ul class="list-unstyled">
                                        @foreach($company?->purchasedPackages as $purchasedPackage)
                                            <li class="d-flex align-items-center justify-content-between mb-2">
                                                <span>{{$purchasedPackage?->package?->title
                                                    ? $purchasedPackage?->package?->title . ' | ' . $purchasedPackage?->category?->name
                                                    . ' | ' . $purchasedPackage->total_rights . ' Hak'
                                                    : '-' }}</span>
                                                <div class="d-flex gap-2">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editPackageModal-{{$purchasedPackage->id}}" 
                                                       class="text-primary" title="Düzenle">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{route('admin.companies.delete-package', $purchasedPackage->id)}}" 
                                                          method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Bu paketi silmek istediğinize emin misiniz?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0 text-danger" title="Sil">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                @else
                                    Aktif paket bulunmuyor.
                                @endif
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#addRightModal-{{$company->id}}"
                                   class="text-decoration-underline">
                                    ekle
                                </a>
                            </td>
                            {{--                            <td>--}}
                            {{--                                @if($company?->purchasedPackage)--}}
                            {{--                                    <form action="{{route('admin.companies.extra-right', $company->id)}}" method="POST">--}}
                            {{--                                        <div class="form-group">--}}
                            {{--                                            <input type="number" name="right" class="form-control" min="0" required>--}}

                            {{--                                            @error('right')--}}
                            {{--                                            <span class="text-danger">{{$message}}</span>--}}
                            {{--                                            @enderror--}}

                            {{--                                            @csrf--}}
                            {{--                                            <button type="submit" class="btn btn-primary mt-2 w-100">Ekle</button>--}}
                            {{--                                        </div>--}}
                            {{--                                    </form>--}}

                            {{--                                @else--}}
                            {{--                                    Aktif paket bulunmuyor.--}}
                            {{--                                @endif--}}
                            {{--                            </td>--}}
                            <td>{{change_timezone($company->created_at, 'd.m.Y')}}</td>
                            <td>
                                @if($company?->is_verified == 0)
                                    <span class="badge bg-primary">Onaylı Değil</span>

                                @elseif($company?->is_verified == 1)
                                    <span class="badge bg-success">Onaylı</span>

                                @elseif($company?->is_verified == 2)
                                    <span class="badge bg-info">İstek Gönderildi</span>
                                @endif
                            </td>
                            <td>
                                @if($company?->is_verified == 1)
                                    <a href="{{ route('admin.companies.verify', ['id' => $company->id, 'status' => 0]) }}"
                                       class="btn btn-sm btn-primary">Onayı Kaldır</a>

                                @elseif($company?->is_verified == 2)
                                    <a href="{{ route('admin.companies.verify', ['id' => $company->id, 'status' => 1]) }}"
                                       class="btn btn-sm btn-primary">Onayla</a>

                                    <form action="{{ route('admin.companies.verify', ['id' => $company->id, 'status' => 0]) }}"
                                          method="GET" class="d-inline"
                                          onsubmit="return confirm('Firma onayını silmek istediğinize emin misiniz?');">
                                        <button type="submit" class="btn btn-danger btn-sm">Başvuruyu Sil</button>
                                    </form>
                                @endif

                                @if($company->status)
                                    <a href="{{ route('admin.companies.status', $company->user_id) }}"
                                       class="btn btn-sm btn-danger">Pasif Yap</a>
                                @else
                                    <a href="{{ route('admin.companies.status', $company->user_id) }}"
                                       class="btn btn-sm btn-success">Aktif Yap</a>
                                @endif

                                {{--                                <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST"--}}
                                {{--                                      class="d-inline" onsubmit="return confirm('Firma hesabını silmek istediğinize emin misiniz?');">--}}
                                {{--                                    @csrf--}}
                                {{--                                    @method('DELETE')--}}

                                {{--                                    <button type="submit" class="btn btn-danger btn-sm mt-3">--}}
                                {{--                                        <i class="fa-solid fa-trash me-2"></i> Hesabı Sil--}}
                                {{--                                    </button>--}}
                                {{--                                </form>--}}
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#infoModal-{{$company->id}}"
                                   class="text-decoration-underline">
                                    görüntüle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Kayıtlı firma bulunamadı.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{$companies->links()}}
        </div>
    </div>
@endsection
