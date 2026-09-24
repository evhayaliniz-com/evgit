@extends('site.inc.master')


@section('css')
    <style>
        .main.sidebar {
            padding-left: 0;
        }
    </style>
@endsection

@section('content')
    <div class="main sidebar">
        <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
            <div class="profili-duzenle">
                <div class="profili-duzenle-box bg-white" style="min-height: 75vh">
                    <div class="profili-duzene-title d-flex">
                        <div class="pdt-left">
                            <a href="{{route('user.dashboard')}}">
                                <i class="fa-solid fa-angle-left"></i>
                            </a>
                            <span>Profili Düzenle</span>
                        </div>
                        <div class="pdt-right">
                            <a href="{{route('user.password.edit')}}" class="btn btn-primary">
                                Şifre Değiştir
                            </a>
                        </div>
                    </div>
                    <div class="profili-duzenle-form">
                        <div class="pdform-left d-flex">
                            <div class="pdform-logo-area">
                                <img
                                    src="{{ asset(optional($user ?? auth()->user())->avatar
                    ?? 'site/images/default_avatar.jpg') }}"
                                    class="profile-edit-avatar"
                                    alt="Avatar"
                                >
                            </div>

                            <div class="pdform-logo-add">
                                <button class="pdf-logo-add-button" onclick="logoSelector()">
                                    Logo Ekle
                                </button>
                                <button class="pdf-logo-add-button remove-button" onclick="removeAvatar()">
                                    Sil
                                </button>
                            </div>
                        </div>
                        <div class="pdf-form-right">
                            <x-input-error-site/>

                            <form action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
                                @method('PATCH')

                                <input type="file" name="avatar"
                                       accept="image/jpeg,image/jpg,image/png,image/webp"
                                       style="position: absolute; top: -10000px" onchange="showAvatar()">

                                <input type="hidden" name="remove_avatar" value="1" id="avatar">


                                <div class="pdf-form-inputs d-flex login-modal-box">
                                    <div class="form-group">
                                        <div class="input-field">
                                            <input type="text" name="name" value="{{$user->name}}"
                                                   @error('name') class="error" @enderror required="">
                                            <label>Ad - Soyad</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-field">
                                            <input type="email" value="{{$user->user->email}}" disabled>
                                            <label>E-Posta</label>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="profil-konum">İlgi Alanınız</h3>

                                <div class="pdf-form-inputs d-flex login-modal-box">
                                    <div class="form-group">
                                        <select name="category_id"
                                                class="form-select @error('category_id') error @enderror"
                                                onchange="getSubCategories()">
                                            <option value="">Kategori</option>
                                            @foreach(get_categories() as $category)
                                                <option value="{{$category->id}}" @selected($category->id ==$user->category_id)>
                                                    {{$category->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group required">
                                        <select name="sub_category_id"
                                                class="form-select @error('sub_category_id') error @enderror"
                                                id="sub-category-select">
                                            <option value="">Alt Kategori</option>
                                            @foreach(get_sub_categories($user->category_id) as $subCategory)
                                                <option value="{{$subCategory->id}}" @selected($user->sub_category_id == $subCategory->id)>
                                                    {{$subCategory->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @csrf
                                <div class="profili-duzenle-save">
                                    <button type="submit">Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="profili-duzenle-pro-membership pdp-account-delete">
                    <div class="pdpm-left">
                        <h4>
                            Hesabımı Sil
                        </h4>
                        <p>
                            Tüm bilgilerimi, üyelik ve hizmetlerimi tekrar geri getirilemiyecek şekilde sil.
                        </p>
                    </div>
                    <div class="pdpm-right">
                        <div class="pdpm-buttons">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#pdp-account-delete">
                                Hesabımı sil
                            </button>
                        </div>
                    </div>
                </div>


                <div class="modal fade login-modal" id="pdp-account-delete" tabindex="-1"
                     aria-labelledby="pdp-account-deleteLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pdp-account-deleteLabel">Hesabımı Sil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="hesabimi-sil-modal-body">
                                    <p>Tüm bilgilerim, pro üyelik ve hizmetlerimi tekrar getirilmeyecek şekilde sil</p>

                                    <div class="hsmb-button text-center">
                                        <form action="{{route('user.profile.destroy')}}" method="POST">
                                            @method('DELETE')

                                            @csrf
                                            <button type="submit">Hesabımı Sil</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
