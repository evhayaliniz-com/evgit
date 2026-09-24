@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Paket Listesi</h5>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Paket Ekle
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Maddeler</th>
                        <th>Durum</th>
                        <th class="text-center">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td>{{ $package->title }}

                                <div class="modal-group">
                                    @if($package->description)
                                        <!-- Paket Açıklaması Modal -->
                                        <div class="modal fade" id="descriptionModal-{{$package->id}}" tabindex="-1"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Paket Açıklaması</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! $package->description !!}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Kapat
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($package->informations)
                                        <!-- Paket Maddeleri Modal -->
                                        <div class="modal fade" id="informationsModal-{{$package->id}}" tabindex="-1"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Paket Açıklaması</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>
                                                            @foreach(json_decode($package->informations) as $information)
                                                                <li>{{$information}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Kapat
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($package->description)
                                    <a href="#" data-bs-toggle="modal"
                                       data-bs-target="#descriptionModal-{{$package->id}}">
                                        görüntüle
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($package->informations)
                                    <a href="#" data-bs-toggle="modal"
                                       data-bs-target="#informationsModal-{{$package->id}}">
                                        görüntüle
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($package->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.packages.edit', $package->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i> Düzenle
                                </a>
                                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu paketi silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bx bx-trash"></i> Sil
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Henüz paket eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
