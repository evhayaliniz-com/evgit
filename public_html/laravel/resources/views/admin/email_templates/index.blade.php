@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Email Şablonları</h5>
            <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary">
                <i class="bx bx-plus"></i> Yeni Şablon Ekle
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Kod</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($emailTemplates as $template)
                        <tr>
                            <td>{{ $template->subject }}</td>
                            <td>{{ $template->key }}</td>
                            <td>
                                @if($template->status)
                                    <span class="badge bg-label-success">Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.email-templates.edit', $template->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                                <form action="{{ route('admin.email-templates.destroy', $template->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu şablonu silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Henüz email şablonu eklenmemiş.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
