@extends('admin.inc.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Firma Listesi</h5>
        <a href="{{ route('admin.companies.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Yeni Firma Ekle
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Firma Adı</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>İl / İlçe</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->mobile_phone }}</td>
                        <td>{{ $company->province }} / {{ $company->district }}</td>
                        <td>
                            <a href="{{ route('admin.companies.edit', $company->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                            <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
