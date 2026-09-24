@extends('site.inc.master')

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="index-right">
                <div class="firma-profil-box">
                    <div class="firma-profil-top">
                        <div class="success-firma-profil sfp-mobil">
                            <a data-bs-toggle="modal"
                               @if(auth()->user()->company->is_verified == 0) data-bs-target="#onayliprofilol" @endif>
                                <span class="text-dark">
                                    @if(auth()->user()->company->is_verified == 0)
                                        <img src="{{asset('site/images/success.png')}}" alt="">
                                        Onaylı Profil Ol

                                    @elseif(auth()->user()->company->is_verified == 1)
                                        <img src="{{asset('site/images/success.png')}}" alt="">
                                        Onaylı Profil

                                    @elseif(auth()->user()->company->is_verified == 2)
                                        Değerlendiriliyor
                                    @endif
                                 </span>
                            </a>
                        </div>
                    </div>
                    <div class="firma-profil-in">
                        <div class="firma-profil-logo">
                            <img src="{{asset(auth()->user()->company->avatar)}}" alt="Avatar">
                        </div>
                        <div class="firma-profil-membership fpm-web">
                            <style>
                                .eplan-button {
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 6px;
                                    background-color: #fff;
                                    color: #007BFF;
                                    border: 2px solid #007BFF;
                                    padding: 8px 14px;
                                    border-radius: 6px;
                                    font-weight: 600;
                                    text-decoration: none;
                                    transition: all 0.3s ease;
                                }

                                .eplan-button:hover {
                                    background-color: #007BFF;
                                    color: #fff;
                                }
                            </style>
                            @php
                                use App\Models\ProPackageCategory;

                                $company = auth()->user()->company;
                                $hasEplanPreview = false;

                                if ($company) {
                                    $latestPackage = $company->latestActivePackage();
                                    if ($latestPackage) {
                                        $hasEplanPreview = ProPackageCategory::where('pro_package_id', $latestPackage->id)
                                            ->where('eplan_preview', 1)
                                            ->exists();
                                    }
                                }
                            @endphp

                            @if($hasEplanPreview)
                                <div class=" fp-eplan">
                                    <a href="{{ route('company.eplan') }}" class="btn btn-outline-primary button-outline button">
                                        <i class="fa-solid fa-house-circle-check"></i> 
                                        <span>E-Plan</span>
                                    </a>
                                </div>
                            @endif

                            <div class="fp-edit">
                                <a class="button button-mid" href="{{ route('company.profile.edit') }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Profili Düzenle</span>
                                </a>
                            </div>

                            <div class="fp-edit fp-pro">
                                <a class="button-primary button" href="{{ route('company.packages.index') }}">
                                    <i class="fa-solid fa-crown"></i>
                                    <span>Pro Üyelik</span>
                                </a>
                            </div>




                        </div>

                        <div class="firma-profil-informations">
                            <div class="fpi-title d-flex">
                                <div>
                                    <h1>
                                        {{auth()->user()->company->name}}
                                    </h1>
                                </div>
                                <div class="success-firma-profil sfp-web">
                                    <a data-bs-toggle="modal" data-bs-target="#onayliprofilol"
                                       @if(auth()->user()->company->is_verified == 0)
                                           data-bs-target="#onayliprofilol"
                                        @endif>
                                        <span>
                                            @if(auth()->user()->company->is_verified == 0)
                                                <img src="{{asset('site/images/success.png')}}" alt="">
                                                Onaylı Profil Ol

                                            @elseif(auth()->user()->company->is_verified == 1)
                                                <img src="{{asset('site/images/success.png')}}" alt="">
                                                Onaylı Profil

                                            @elseif(auth()->user()->company->is_verified == 2)
                                                Değerlendiriliyor
                                            @endif
                                       </span>
                                    </a>

                                </div>
                            </div>
                            <div class="fp-infos">
                                {{--                                <div class="fp-infos-box">--}}
                                {{--                                    <i class="fa-solid fa-location-dot"></i>--}}
                                {{--                                    <span>--}}
                                {{--                                       Kayseri--}}
                                {{--                                    </span>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="fp-infos-box">--}}
                                {{--                                    <i class="fa-solid fa-phone"></i>--}}
                                {{--                                    <span>--}}
                                {{--                                      0555 555 55 55--}}
                                {{--                                    </span>--}}
                                {{--                                </div>--}}
                            </div>
                        </div>
                        <div class="firma-profil-membership fpm-mobil">
                            <div class="fp-edit">
                                <a class="button button-mid" href="{{route('company.profile.edit')}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>
                                       Profili Düzenle
                                    </span>
                                </a>
                            </div>
                            <div class="fp-edit fp-pro">
                                <a class="button-primary button" href="{{route('company.packages.index')}}">
                                    <i class="fa-solid fa-crown"></i>
                                    <span>
                                          Pro Üyelik
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="firma-tabs-area">
                    <div class="firma-tabs-box">
                        <div class="container py-5">
                            <h2 class="mb-4">E-Planlar</h2>

                            {{-- 🔎 Filtreleme --}}
                            <form method="GET" class="row g-3 mb-4">
                                <div class="col-md-2">
                                    <select name="structure_type_id" class="form-select">
                                        <option value="">Yapı Türü</option>
                                        @foreach($structureTypes as $type)
                                            <option value="{{ $type->id }}" @selected(request('structure_type_id') == $type->id)>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="structure_class_id" class="form-select">
                                        <option value="">Yapı Sınıfı</option>
                                        @foreach($structureClasses as $class)
                                            <option value="{{ $class->id }}" @selected(request('structure_class_id') == $class->id)>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="room_count_id" class="form-select">
                                        <option value="">Oda Sayısı</option>
                                        @foreach($roomCounts as $room)
                                            <option value="{{ $room->id }}" @selected(request('room_count_id') == $room->id)>
                                                {{ $room->label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <input type="number" name="min_area" class="form-control" placeholder="Min m²"
                                           value="{{ request('min_area') }}">
                                </div>

                                <div class="col-md-2">
                                    <input type="number" name="max_area" class="form-control" placeholder="Max m²"
                                           value="{{ request('max_area') }}">
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-outline-primary w-100">Filtrele</button>
                                </div>
                            </form>

                            {{-- 🔍 Liste --}}
                            @if($plans->isEmpty())
                                <div class="alert alert-warning">Henüz e-plan içeriğiniz bulunmamaktadır.</div>
                            @else
                                <div class="row">
                                    @foreach($plans as $plan)
                                        <div class="col-md-4 mb-4">
                                            <a href="{{ route('company.eplan.show', $plan->id) }}" class="text-decoration-none text-dark">
                                                <div class="card h-100">
                                                    <img src="{{ asset($plan->photos->first()->path ?? 'site/images/default.jpg') }}"
                                                         class="card-img-top" alt="{{ $plan->title }}">

                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $plan->title }}</h5>
                                                    </div>

                                                    <div class="card-footer bg-light d-flex flex-wrap gap-2 py-2 px-3">
                                                        @if($plan->structureType?->name)
                                                            <span class="badge bg-secondary">{{ $plan->structureType->name }}</span>
                                                        @endif

                                                        @if($plan->structureClass?->name)
                                                            <span class="badge bg-secondary">{{ $plan->structureClass->name }}</span>
                                                        @endif

                                                        @if($plan->roomCount?->label)
                                                            <span class="badge bg-secondary">{{ $plan->roomCount->label }}</span>
                                                        @endif


                                                        @if($plan->gross_area)
                                                            <span class="badge bg-secondary">{{ $plan->gross_area }} m²</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                    @endforeach
                                </div>
                                <div class="mt-4">
                                    {{ $plans->withQueryString()->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade login-modal" id="onayliprofilol" tabindex="-1" aria-labelledby="onayliprofilolLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="onayliprofilolLabel">Onaylı Profil Ol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="firma-sikayeti-box">
                        <p>
                            Uzmanlarımız Vergi bilgileriniz ve Konum adresinizi doğrulamak için size ulaşacak.
                        </p>
                        <div class="login-button">
                            <a href="{{route('company.send-verify')}}">
                                <button type="button">Başvur</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
