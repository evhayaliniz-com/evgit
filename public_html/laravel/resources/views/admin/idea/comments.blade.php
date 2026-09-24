@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Fikir Yorumları</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Yorum Sahibi</th>
                        <th>Fikir</th>
                        <th>Yorum</th>
                        <th>Beğeni</th>
                        <th>Alıntılanan Yorum ID</th>
                        <th>Ana Yorum ID</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td>{{$comment->id}}</td>
                            <td>
                                {{ auth_info($comment->user_id)->id . ' - ' . auth_info($comment->user_id)->name}}

                                <div class="modal fade" id="contentModal-{{$comment->id}}" tabindex="-1"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Yorum</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p style="white-space: pre-line">
                                                    {{$comment->content}}
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
                                <a href="{{route('idea.show', $comment->idea->slug)}}" target="_blank">
                                    {{ $comment->idea->id . ' - ' . $comment->idea->title }}
                                </a>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#contentModal-{{$comment->id}}">
                                    görüntüle
                                </a>
                            </td>
                            <td>{{ $comment->likes->count() }}</td>
                            <td>{{ $comment->quoted_reply_id ?? '-' }}</td>
                            <td>{{ $comment?->parent_reply_id ?? '-' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($comment->created_at)->tz('Europe/Istanbul')->format('d.m.Y') }}
                            </td>
                            <td>
                                <form action="{{ route('admin.ideas.comments.destroy', $comment->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bu yorumu silmek istediğinize emin misiniz?');">
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
                            <td colspan="5" class="text-center text-muted">Henüz yorum yapılmamış.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>


            {{$comments->links()}}
        </div>
    </div>
@endsection
