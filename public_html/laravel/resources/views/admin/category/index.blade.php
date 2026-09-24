@extends('admin.inc.master')

@section('css')
<style>
    /* Kategori listeleme stilleri */
    .category-row {
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .category-row:hover {
        background-color: #f8f9fa;
    }

    /* Alt kategorilerin içe kaymasını sağla */
    .category-children tr td:first-child {
        padding-left: 40px !important;
    }
    tr[data-level="1"] td:first-child { padding-left: 60px !important; }
    tr[data-level="2"] td:first-child { padding-left: 80px !important; }
    tr[data-level="3"] td:first-child { padding-left: 100px !important; }
    tr[data-level="4"] td:first-child { padding-left: 120px !important; }

    /* Açma/Kapama butonu */
    .toggle-category {
        font-size: 18px;
        cursor: pointer;
        transition: transform 0.2s;
        display: inline-block;
        width: 24px;
        text-align: center;
    }
    .toggle-category.open i {
        transform: rotate(180deg);
    }
    td img {
    border-radius: 6px;
    transition: 0.3s ease;
}
td img:hover {
    transform: scale(1.05);
}

</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kategori Listesi</h5>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Yeni Kategori Ekle
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kategori</th> <!-- artık hem görsel hem ad var -->
                        <th>Sıra</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($categories as $category)
                        @include('admin.category.partials.category_row', ['category' => $category, 'level' => 0])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.category-row').click(function () {
            let target = $(this).data('target');
            $('#' + target).toggle();
            $(this).find('.toggle-category').toggleClass('open');
        });
    });
</script>
@endsection
