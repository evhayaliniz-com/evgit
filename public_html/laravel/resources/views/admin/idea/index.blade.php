@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Fikirler ({{$ideaCount}})</h5>

            <form action="" method="GET">
                <div class="d-flex gap-3">
                    <div class="form-group">
                        <label for="">Alt Kategori</label>
                        <select name="sub_category" class="form-select" onchange="this.closest('form').submit()">
                            <option value="">Tümü</option>
                            @foreach($subCategories as $subCategory)
                                <option value="{{$subCategory->id}}" @selected(request()?->sub_category == $subCategory->id)>
                                    {{$subCategory->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Oluşturan</th>
                        <th>Başlık</th>
                        <th>İçerik</th>
                        <th>Kategori</th>
                        <th>Alt Kategori</th>
                        <th>Yorum Sayısı</th>
                        <th>Durum</th>
                        <th>Onay Durumu</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($ideas as $idea)
                        <tr>
                            <td>{{$idea->id}}</td>
                            <td>
                                @php
                                    $authUser = auth_info($idea->user_id);
                                @endphp

                                @if($authUser)
                                    {{ $authUser->id . ' - ' . $authUser->name }}
                                @else
                                    <span class="text-danger">Kullanıcı bulunamadı</span>
                                @endif
                                <div class="modal fade" id="contentModal-{{$idea->id}}" tabindex="-1"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">İçerik</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p style="white-space: pre-line">
                                                    {{$idea->content}}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Kapat
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{route('idea.show', $idea->slug)}}" target="_blank">{{ $idea?->title }}</a>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#contentModal-{{$idea->id}}">
                                    görüntüle
                                </a>
                            </td>
                            <td>{{ $idea->category?->name }}</td>
                            <td>{{ $idea?->subCategory?->name ?? '-' }}</td>
                            <td>
                                <a href="{{route('admin.ideas.comments', $idea->id)}}">{{$idea->replies->count()}}</a>
                            </td>
                            <td>
                                @if($idea->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                            <td>
                                @if($idea->is_confirmed)
                                    <span class="badge bg-label-success">Onaylı</span>
                                @else
                                    <span class="badge bg-label-warning">Onay Bekliyor</span>
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($idea->created_at)->tz('Europe/Istanbul')->format('d.m.Y') }}
                            </td>
                            <td>
                                <a href="{{route('admin.ideas.comments', $idea->id)}}"
                                   class="btn btn-sm btn-info">
                                    <i class="bx bx-comment-detail"></i> Yorumlar
                                </a>

                                @if($idea->status)
                                    <a href="{{ route('admin.ideas.status', $idea->id) }}"
                                       class="btn btn-sm btn-warning">Pasif Yap</a>
                                @else
                                    <a href="{{ route('admin.ideas.status', $idea->id) }}"
                                       class="btn btn-sm btn-success">Aktif Yap</a>
                                @endif

                                @if($idea->is_confirmed)
                                    <form action="{{ route('admin.ideas.unconfirm', $idea->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bu fikrin onayını kaldırmak istediğinize emin misiniz?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary">
                                            <i class="bx bx-x"></i> Onayı Kaldır
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.ideas.confirm', $idea->id) }}" method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Bu fikri onaylamak istediğinize emin misiniz?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bx bx-check"></i> Onayla
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.ideas.destroy', $idea->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu fikri silmek istediğinize emin misiniz?');">
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


            {{$ideas->links()}}
        </div>
    </div>
@endsection
