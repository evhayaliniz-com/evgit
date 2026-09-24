@extends('admin.inc.master')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Yeni E-posta Ekle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.emails.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta Adresi</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="ornek@email.com"
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bx bx-plus"></i> Ekle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bildirim E-posta Listesi</h5>
            <span class="badge bg-label-primary">Toplam: {{ $emails->count() }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>E-posta Adresi</th>
                            <th>Eklenme Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emails as $email)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $email->email }}</td>
                                <td>{{ $email->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.emails.destroy', $email->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu e-posta adresini silmek istediğinize emin misiniz?');">
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
                                <td colspan="4" class="text-center text-muted">Henüz e-posta adresi eklenmemiş.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
