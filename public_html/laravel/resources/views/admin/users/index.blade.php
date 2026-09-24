@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kullanıcılar</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Ad - Soyad</th>
                        <th>E-posta</th>
                        <th>Kayıt Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <img src="{{ asset($user->avatar) }}" alt="Kullanıcı Görseli"
                                     style="width: 100px; height: 60px; object-fit: cover;" class="rounded shadow-sm">
                            </td>
                            <td>{{ optional($user->user)->name ?? '-' }}</td>
                            <td>{{ optional($user->user)->email ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($user?->created_at)->tz('Europe/Istanbul')->format('d.m.Y H:i:s') }}</td>
                            <td>
                                @if($user->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status)
                                    <a href="{{ route('admin.users.status', $user->user_id) }}"
                                       class="btn btn-sm btn-danger">Pasif Yap</a>
                                @else
                                    <a href="{{ route('admin.users.status', $user->user_id) }}"
                                       class="btn btn-sm btn-success">Aktif Yap</a>
                                @endif

                                {{--                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-warning">Düzenle</a>--}}
                                {{--                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"--}}
                                {{--                                      class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">--}}
                                {{--                                    @csrf--}}
                                {{--                                    @method('DELETE')--}}
                                {{--                                    <button type="submit" class="btn btn-sm btn-danger">Sil</button>--}}
                                {{--                                </form>--}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Kayıtlı kullanıcı bulunamadı.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{$users->links()}}
        </div>
    </div>
@endsection
