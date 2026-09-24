@extends('admin.inc.master')

@section('content')
    <style>
        .bg-light {
            background-color: #f8f9fa !important;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
        }

        .form-check-label {
            font-size: 13px;
        }

        h5.text-center {
            font-size: 17px;
            font-weight: 700;
        }
    </style>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Yeni Paket Ekle</h5>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-primary">
                <i class="bx bx-list-ul"></i> Paket Listesi
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="mb-3">
                    <label class="form-label">Başlık</label>
                    <input type="text" name="title" class="form-control" value="{{$package->title}}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Açıklama</label>
                    <textarea name="description" class="form-control" rows="6">{{$package->description}}</textarea>
                </div>


                <label class="form-label">Kategori - Fiyat - Kullanım</label>
                <div class="border rounded p-3 mb-5" style="max-height: 300px; overflow-y: auto">
                    @foreach(get_categories() as $category)
                        <div class="border p-3 rounded mb-3 bg-light">
                            <div class="row">
                                <div class="col-md-3 mb-3 d-flex align-items-center justify-content-center">
                                    <h5 class="text-center m-0">{{$category->name}}</h5>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Aylık Ücret</label>
                                    <input type="number" name="monthly_price[{{$category->id}}]" class="form-control"
                                           min="1"
                                           value="{{$packageCategories->firstWhere('category_id', $category->id)?->monthly_price}}">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Yıllık Ücret</label>
                                    <input type="number" name="yearly_price[{{$category->id}}]" class="form-control"
                                           min="1"
                                           value="{{$packageCategories->firstWhere('category_id', $category->id)?->yearly_price}}">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Kullanım Hakkı</label>
                                    <input type="number" name="rights[{{$category->id}}]" class="form-control" min="1"
                                           value="{{$packageCategories->firstWhere('category_id', $category->id)?->rights}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Durum</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="category_status[{{$category->id}}]" value="1"
                                               class="form-check-input" id="status-{{$category->id}}"
                                            @checked($packageCategories->firstWhere('category_id', $category->id)?->status)>
                                        <label for="status-{{$category->id}}" class="form-check-label">Aktif</label>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Ön Sunum</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="eplan_preview[{{$category->id}}]" value="1"
                                               class="form-check-input" id="preview-{{$category->id}}"
                                            @checked($packageCategories->firstWhere('category_id', $category->id)?->eplan_preview)>
                                        <label for="preview-{{$category->id}}" class="form-check-label">Aktif</label>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Detay Sunum</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="eplan_detail[{{$category->id}}]" value="1"
                                               class="form-check-input" id="detail-{{$category->id}}"
                                            @checked($packageCategories->firstWhere('category_id', $category->id)?->eplan_detail)>
                                        <label for="detail-{{$category->id}}" class="form-check-label">Aktif</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Aylık Plan İndirme</label>
                                    <input type="number" name="eplan_monthly_download_limit[{{$category->id}}]" class="form-control" min="0"
                                           value="{{$packageCategories->firstWhere('category_id', $category->id)?->eplan_monthly_download_limit}}">
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


                <div class="col-12">
                    <div class="multi-container">
                        <div class="button-container">
                            <div class="my_profile_setting_input">
                                <label class="not-required">Maddeler</label>

                                <button type="button" class="btn btn-info float-end mb-3"
                                        onclick="addRow()">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="input-container">
                            @if($package->informations)
                                @foreach(json_decode($package->informations) as $information)
                                    <div class="input-group mb-3">
                                        <input name="informations[]" type="text" value="{{$information}}"
                                               class="form-control">
                                        <button type="button" class="btn btn2 float-right btn-primary"
                                                onclick="removeRow(this)" style="width: 50px;">
                                            -
                                        </button>
                                    </div>
                                @endforeach

                            @else
                                <div class="input-group mb-3">
                                    <input name="informations[]" type="text" class="form-control">
                                    <button type="button" class="btn btn2 float-right btn-primary"
                                            onclick="removeRow(this)" style="width: 50px;">
                                        -
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-12 mb-4">
                    <label class="form-label">Durum</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" name="status" value="1" class="form-check-input" id="status"
                               @checked($package->status)>
                        <label for="status" class="form-check-label">Aktif</label>
                    </div>
                </div>



                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
