@extends('site.inc.master')

@section('content')
<div class="main sidebar">
  <div class="col-lg-12 col-md-12 col-sm-12 pr-0 col-12 mobile-pl-0 pl-0" id="index-right-area">
    <div class="tum-hizmetler">
      <div class="tum-hizmetler-box index-right">
        <div class="tum-hizmetler-slider tum-hizmetler-top"></div>
        <div class="hizmetler-title-main">
          <h5>Hizmetlerim <span>({{ $services->total() }})</span></h5>
        </div>
        <div class="d-flex align-items-center justify-content-between">
          <div class="addnewhizmetflex">
            <div class="addnewhizmet">
              <a href="{{ route('company.services.create') }}">Hizmet Ekle</a>
            </div>
            <div class="hizmetler-title-right-search mobileshowflex">
              <input type="text" id="search-input-mobile" placeholder="Hizmet ara..." value="{{ request('search') }}">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
          </div>

          <div class="form-group d-flex gap-3 hizmetler-title-right justify-content-end" style="position:relative;">
            <div class="d-flex gap-2 flex-wrap align-items-center">
              <div class="hizmetler-title-right-search mobilehidden">
                <input type="text" id="search-input-desktop" placeholder="Hizmet ara..." value="{{ request('search') }}">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <select class="form-select" id="status-filter" style="width: auto; min-width: 120px;">
                <option value="">Tüm Durumlar</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="pasif" {{ request('status') == 'pasif' ? 'selected' : '' }}>Pasif</option>
              </select>
              <select id="per-page-filter" class="form-select" style="width: auto; min-width: 100px;">
                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Kayıt</option>
                <option value="20" {{ request('per_page') == '20' || !request('per_page') ? 'selected' : '' }}>20 Kayıt</option>
                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Kayıt</option>
                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Kayıt</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="">
        <div class="tum-hizmetler-box index-right">
          <div class="tum-hizmetler-inner thi-new">
            <div class="tumhizmetlernewtable table-responsive">
              <div class="table-wrapper">
                <!-- Table Header -->
                <div class="table-header">
                  <div class="header-table-container" id="headerTableContainer">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Resim</th>
                          <th scope="col">Hizmet Adı</th>
                          <th scope="col" class="sortable-header" data-sort="price" style="cursor: pointer;"> 
                            Fiyat 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="sort-icon">
                              <path fill="currentColor" d="M8 16H4l6 6V2H8zm6-11v17h2V8h4l-6-6z" />
                            </svg>
                          </th>
                          <th scope="col" class="sortable-header" data-sort="view_count" style="cursor: pointer;"> 
                            Görüntülenme 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="sort-icon">
                              <path fill="currentColor" d="M8 16H4l6 6V2H8zm6-11v17h2V8h4l-6-6z" />
                            </svg>
                          </th>
                          <th scope="col" class="sortable-header" data-sort="saved_count" style="cursor: pointer;"> 
                            Kaydetme 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="sort-icon">
                              <path fill="currentColor" d="M8 16H4l6 6V2H8zm6-11v17h2V8h4l-6-6z" />
                            </svg>
                          </th>
                          <th scope="col" class="sortable-header" data-sort="created_at" style="cursor: pointer;"> 
                            Tarih 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="sort-icon">
                              <path fill="currentColor" d="M8 16H4l6 6V2H8zm6-11v17h2V8h4l-6-6z" />
                            </svg>
                          </th>
                          <th scope="col">Durum</th>
                          <th scope="col">İşlemler</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <!-- Header altındaki scroll alanı -->
                <div class="header-scroll" id="headerScroll">
                  <div class="header-scroll-content" id="scrollContent"></div>
                </div>
                <!-- Table Body -->
                <div class="table-body" id="tableBody">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Hizmet Adı</th>
                        <th scope="col"></th>
                        <th scope="col">Fiyat</th>
                        <th scope="col">Görüntülenme</th>
                        <th scope="col">Kaydetme</th>
                        <th scope="col">Tarih</th>
                        <th scope="col">Durum</th>
                        <th scope="col">İşlemler</th>
                      </tr>
                    </thead>
                    <tbody id="services-table-body">
                      @include('site.services.partials.services-table', ['services' => $services])
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tumhizmetlerpagination mt-3" id="pagination-container">
              @if($services->hasPages())
                {{ $services->links() }}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
/* Search input styling fixes */
.hizmetler-title-right-search {
    position: relative;
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 200px;
    max-width: 300px;
}

.hizmetler-title-right-search input {
    width: 100% !important;
    min-width: 180px;
    padding-right: 35px !important;
    flex: 1;
}

.hizmetler-title-right-search i {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #6c757d;
    z-index: 2;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .hizmetler-title-right-search {
        min-width: 150px;
        max-width: 200px;
    }
    
    .hizmetler-title-right-search input {
        min-width: 140px;
    }
}

/* Large screens */
@media (min-width: 1200px) {
    .hizmetler-title-right-search {
        max-width: 350px;
    }
}

.form-group.d-flex.gap-3.hizmetler-title-right .d-flex.gap-3 {
    align-items: center;
    flex-wrap: wrap;
}

.form-group.d-flex.gap-3.hizmetler-title-right {
    flex-wrap: wrap;
    gap: 10px !important;
}

/* Ensure proper spacing on smaller screens */
@media (max-width: 992px) {
    .form-group.d-flex.gap-3.hizmetler-title-right .d-flex.gap-3 {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .hizmetler-title-right-search {
        max-width: 100%;
    }
}

/* Sorting styles */
.sortable-header {
    user-select: none;
    transition: background-color 0.2s;
}

.sortable-header:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.sortable-header .sort-icon {
    transition: transform 0.2s;
    opacity: 0.6;
}

.sortable-header:hover .sort-icon {
    opacity: 1;
}

.sortable-header.sort-asc .sort-icon {
    transform: rotate(180deg);
    opacity: 1;
}

.sortable-header.sort-desc .sort-icon {
    transform: rotate(0deg);
    opacity: 1;
}

/* Tooltip düzeltmeleri - butonlara tıklanabilir hale getir */
.tumhizmetler-islemlerbox.tooltipp .tooltiptext {
    position: absolute !important;
    z-index: 999 !important;
    bottom: 125% !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    background-color: #333 !important;
    color: white !important;
    padding: 4px 8px !important;
    border-radius: 4px !important;
    font-size: 11px !important;
    white-space: nowrap !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: opacity 0.3s, visibility 0.3s !important;
    pointer-events: none !important;
}

.tumhizmetler-islemlerbox.tooltipp:hover .tooltiptext {
    opacity: 1 !important;
    visibility: visible !important;
}

.tumhizmetler-islemlerbox.tooltipp .tooltiptext::after {
    content: "" !important;
    position: absolute !important;
    top: 100% !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    border: 0px solid transparent !important;
    border-top-color: #333 !important;
}

/* Butonların tıklanabilirliğini garanti et */
.tumhizmetler-islemlerbox {
    position: relative !important;
    z-index: 1 !important;
    overflow: visible !important;
}

.tumhizmetler-islemlerbox a {
    position: relative !important;
    z-index: 2 !important;
    pointer-events: auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
}

/* Altın/turuncu buton özel düzeltmesi */
.tumhizmetler-islemlerbox.status.inactive {
    background: #F89622 !important;
    box-sizing: border-box !important;
}

.tumhizmetler-islemlerbox.status.active {
    background: #4CC8F2 !important;
    box-sizing: border-box !important;
}

.tumhizmetler-islemlerbox.edit {
    background: #4162EE !important;
    box-sizing: border-box !important;
}

.tumhizmetler-islemlerbox.remove {
    background: #F72586 !important;
    box-sizing: border-box !important;
}

/* İçerik taşmasını önle ama tooltip'i göster */
.tumhizmetler-islemlerbox a,
.tumhizmetler-islemlerbox form {
    overflow: hidden !important;
}
</style>
@endpush

@push('scripts')
<script>
jQuery(document).ready(function($) {
    var searchTimeout;
    var currentPage = 1;
    
    // CSRF token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Current sort state
    var currentSort = {
        column: null,
        order: 'desc'
    };
    
    // Live search function
    function performSearch(page = 1) {
        var searchTerm = $('#search-input-desktop').val() || $('#search-input-mobile').val();
        var status = $('#status-filter').val();
        var perPage = $('#per-page-filter').val();
        
        $.ajax({
            url: '{{ route("company.services.search") }}',
            method: 'POST',
            data: {
                search: searchTerm,
                status: status,
                per_page: perPage,
                page: page,
                sort_by: currentSort.column,
                sort_order: currentSort.order
            },
            beforeSend: function() {
                $('#services-table-body').html('<tr><td colspan="9" class="text-center py-4"><i class="fa fa-spinner fa-spin"></i> Aranıyor...</td></tr>');
            },
            success: function(data) {
                if (data.success) {
                    $('#services-table-body').html(data.html);
                    $('#pagination-container').html(data.pagination);
                    
                    // Update service count in header
                    $('.hizmetler-title-main h5 span').text('(' + data.total + ')');
                    
                } else {
                    alert('Arama sırasında bir hata oluştu.');
                }
            },
            error: function() {
                alert('Arama sırasında bir hata oluştu.');
                $('#services-table-body').html('<tr><td colspan="9" class="text-center py-4">Bir hata oluştu.</td></tr>');
            }
        });
    }
    
    // Search input events (with debounce)
    $('#search-input-desktop, #search-input-mobile').on('input', function() {
        clearTimeout(searchTimeout);
        var otherInput = this.id === 'search-input-desktop' ? '#search-input-mobile' : '#search-input-desktop';
        $(otherInput).val($(this).val()); // Sync both inputs
        
        searchTimeout = setTimeout(function() {
            currentPage = 1;
            performSearch(currentPage);
        }, 500); // 500ms debounce
    });
    
    // Filter change events
    $('#status-filter, #per-page-filter').on('change', function() {
        currentPage = 1;
        performSearch(currentPage);
    });
    
    // Pagination click handler
    $(document).on('click', '#pagination-container .pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var page = url.split('page=')[1];
        if (page) {
            currentPage = page;
            performSearch(currentPage);
        }
    });
    
    // Price edit functionality
    $(document).on('click', '.tumhizmetlerfiyattrigger', function() {
        var editBox = $(this).siblings('.tumhizmetlerfiyatbox');
        editBox.show();
    });
    
    $(document).on('click', '.tumhizmetler-closed', function() {
        $(this).closest('.tumhizmetlerfiyatbox').hide();
    });
    
    $(document).on('click', '.tumhizmetler-update', function() {
        var button = $(this);
        var serviceId = button.data('service-id');
        var input = button.closest('.tumhizmetlerfiyatbox').find('input');
        var rawValue = input.val();
        // Remove thousand separators and convert to decimal
        var newPrice = removeThousandSeparators(rawValue);
        
        if (!newPrice || isNaN(newPrice) || parseFloat(newPrice) <= 0) {
            alert('Lütfen geçerli bir fiyat giriniz.');
            return;
        }
        
        // Loading state
        button.prop('disabled', true).text('Güncelleniyor...');
        
        var url = '{{ route("company.services.update-price", ":id") }}'.replace(':id', serviceId);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                price: parseFloat(newPrice)
            },
            success: function(data) {
                if (data.success) {
                    // Fiyatı güncelle
                    var trigger = $('.tumhizmetlerfiyattrigger[data-service-id="' + serviceId + '"]');
                    trigger.text(data.new_price + ' TL');
                    
                    // Edit box'ı kapat
                    button.closest('.tumhizmetlerfiyatbox').hide();
                } else {
                    alert('Hata: ' + (data.message || 'Bilinmeyen hata'));
                }
            },
            error: function(xhr, status, error) {
                alert('Fiyat güncellenirken bir hata oluştu.');
            },
            complete: function() {
                // Reset button
                button.prop('disabled', false).text('Güncelle');
            }
        });
    });
    
    // Number formatting function for input
    function formatNumberWithThousands(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    
    function removeThousandSeparators(str) {
        return str.replace(/\./g, '');
    }
    
    // Sorting functionality
    $('.sortable-header').on('click', function() {
        var column = $(this).data('sort');
        
        
        // Toggle sort order if same column, otherwise default to desc
        if (currentSort.column === column) {
            currentSort.order = currentSort.order === 'desc' ? 'asc' : 'desc';
        } else {
            currentSort.column = column;
            currentSort.order = 'desc';
        }
        
        // Update visual indicators
        $('.sortable-header').removeClass('sort-asc sort-desc');
        $(this).addClass('sort-' + currentSort.order);
        
        // Perform search with new sort
        performSearch(1);
    });
    
    // Price input formatting
    $(document).on('focus', '.price-input', function() {
        var $input = $(this);
        var value = $input.val();
        
        // Remove any existing formatting and add thousand separators
        var cleanValue = removeThousandSeparators(value);
        if (cleanValue && !isNaN(cleanValue)) {
            var formattedValue = formatNumberWithThousands(cleanValue);
            $input.val(formattedValue);
        }
    });
    
    $(document).on('blur', '.price-input', function() {
        var $input = $(this);
        var value = $input.val();
        
        // Remove thousand separators when losing focus (for form submission)
        var cleanValue = removeThousandSeparators(value);
        if (cleanValue && !isNaN(cleanValue)) {
            $input.val(cleanValue);
        }
    });
    
    // Handle input while typing (maintain formatting)
    $(document).on('input', '.price-input', function() {
        var $input = $(this);
        var value = $input.val();
        var cursorPos = $input[0].selectionStart;
        
        // Remove non-numeric characters except dots
        var cleanValue = value.replace(/[^\d.]/g, '');
        
        // Remove thousand separators for processing
        var numericValue = removeThousandSeparators(cleanValue);
        
        // Only allow digits
        numericValue = numericValue.replace(/[^\d]/g, '');
        
        if (numericValue) {
            var formattedValue = formatNumberWithThousands(numericValue);
            
            // Calculate new cursor position
            var dotsBefore = (value.substring(0, cursorPos).match(/\./g) || []).length;
            var dotsAfter = (formattedValue.match(/\./g) || []).length;
            var newCursorPos = cursorPos + (dotsAfter - dotsBefore);
            
            $input.val(formattedValue);
            
            // Restore cursor position
            if ($input[0].setSelectionRange) {
                $input[0].setSelectionRange(newCursorPos, newCursorPos);
            }
        }
    });
});
</script>
@endpush
@endsection