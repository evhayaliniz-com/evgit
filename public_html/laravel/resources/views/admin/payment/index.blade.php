@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Ödemeler</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Firma</th>
                        <th>Paket</th>
                        <th>Ücret</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment?->company ? $payment->company_id
                                . ' - ' . $payment?->company?->name : 'Silinmiş Hesap'}}</td>
                            <td>{{ $payment?->proPackage?->title }}</td>
                            <td>{{ $payment?->amount }} TL</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Henüz ödeme yapılmamış.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{$payments->links()}}
        </div>
    </div>
@endsection
