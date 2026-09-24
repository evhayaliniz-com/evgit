@extends('admin.inc.master')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">İletişim Mesajları</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>İsim Soyisim</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Mesaj</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}

                                <!-- Paket Maddeleri Modal -->
                                <div class="modal fade" id="messageModal-{{$contact->id}}" tabindex="-1"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Paket Açıklaması</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p>{{$contact->message}}</p>
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
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone_number }}</td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#messageModal-{{$contact->id}}"
                                   class="text-decoration-underline">
                                    görüntüle
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
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

            {{$contacts->links()}}
        </div>
    </div>
@endsection
