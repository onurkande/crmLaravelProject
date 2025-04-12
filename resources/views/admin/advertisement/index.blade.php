@extends('admin.layouts.master')

@section('title', 'İlanlar')

@section('styles')
    <style>
        .content nav {
            background: #fff;
            padding: 10px;
            border-radius: 50px;
            box-shadow: 0 0 20px 0 rgba(0,0,0,0.1);
            display: inline-block;
        }

        .content .pagination {
            margin: 0;
            display: flex;
            gap: 5px;
        }

        .content .page-item {
            margin: 0 2px;
        }

        .content .page-item .page-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            font-weight: 600;
            font-size: 14px;
            color: #666;
            background: transparent;
            border: none;
            transition: all 0.3s ease;
        }

        .content .page-item .page-link:hover {
            background: #f0f0f0;
            color: #2196F3;
        }

        .content .page-item.active .page-link {
            background: #2196F3;
            color: white;
        }

        .content .page-item.disabled .page-link {
            background: transparent;
            color: #ccc;
            cursor: not-allowed;
        }

        .content .page-item:first-child .page-link,
        .content .page-item:last-child .page-link {
            background: #f8f9fa;
        }

        .content .page-item:first-child .page-link:hover,
        .content .page-item:last-child .page-link:hover {
            background: #e9ecef;
        }

        .content .zmdi {
            font-size: 18px;
        }

        /* Mobil cihazlar için responsive tasarım */
        @media (max-width: 576px) {
            .content nav {
                padding: 5px;
                border-radius: 25px;
            }

            .content .page-item .page-link {
                width: 35px;
                height: 35px;
                font-size: 12px;
            }

            .content .zmdi {
                font-size: 16px;
            }
        }

        #selectedRoomTypes .badge {
            display: inline-flex;
            align-items: center;
            background-color: #f0f0f0;
            color: #666;
            transition: all 0.3s ease;
        }

        #selectedRoomTypes .badge:hover {
            background-color: #2196F3;
            color: white;
        }

        #selectedRoomTypes .badge .zmdi-close {
            margin-left: 5px;
            font-size: 16px;
        }

        #selectedRoomTypes .badge .zmdi-close:hover {
            color: #ff4444;
        }

        .text-info.m-t-5 {
            font-size: 0.9rem;
            color: #2196F3 !important;
            display: flex;
            align-items: center;
            background: rgba(33, 150, 243, 0.1);
            padding: 5px 10px;
            border-radius: 4px;
            width: fit-content;
        }

        .text-info.m-t-5 .zmdi-money-box {
            font-size: 1.1rem;
            margin-right: 5px;
            color: #2196F3;
        }

        /* Mobil cihazlar için responsive tasarım */
        @media (max-width: 576px) {
            .text-info.m-t-5 {
                font-size: 0.8rem;
                padding: 4px 8px;
            }
        }

        /* İlan kartları için sabit yükseklik */
        .property_list {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .property_list .body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .property_list .property-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .property_list .property-action {
            margin-top: auto;
        }

        .advert{
            margin-bottom: 30px
        }

        /* Komisyon bilgisi için minimum yükseklik */
        .text-info.m-t-5 {
            min-height: 40px;
            display: flex;
            align-items: center;
        }

        /* Mobil cihazlar için responsive tasarım */
        @media (max-width: 576px) {
            .text-info.m-t-5 {
                min-height: 35px;
            }
        }
    </style>
@endsection 
@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        </script>
    @endif
    @if(session()->has('deleted'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('deleted') }}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        </script>
    @endif
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>İlanlar
                <small class="text-muted">İlanlar</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">  
                @if(Auth::user()->user_type == 'admin')              
                    <a href="{{ route('admin.advertisements.create') }}" class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10 d-flex align-items-center justify-content-center" type="button">
                        <i class="zmdi zmdi-plus"></i>
                    </a>
                @endif
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}">İlanlar</a></li>
                </ul>                
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Filtreleme</h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-3">
                                <select class="form-control show-tick" id="saleStatusFilter">
                                    <option value="">Satış Durumu</option>
                                    <option value="Satıldı">Satıldı</option>
                                    <option value="Satılmadı">Satılmadı</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control show-tick" id="reserveStatusFilter">
                                    <option value="">Rezerve Durumu</option>
                                    <option value="Rezerve Edildi">Rezerve Edildi</option>
                                    <option value="Rezerve Edilmedi">Rezerve Edilmedi</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control show-tick" id="depositStatusFilter">
                                    <option value="">Depozito Durumu</option>
                                    <option value="Ödendi">Ödendi</option>
                                    <option value="Ödenmedi">Ödenmedi</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control show-tick" id="roomTypeFilter" multiple data-live-search="true">
                                    <option value="1+1">1+1</option>
                                    <option value="2+1">2+1</option>
                                    <option value="3+1">3+1</option>
                                    <option value="Studio">Studio</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Penthouse">Penthouse</option>
                                </select>
                                <div id="selectedRoomTypes" class="mt-2"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-t-5">
                                    <input type="text" id="searchInput" class="form-control" placeholder="İlan Adı veya Açıklama Ara...">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-t-5">
                                    <input type="number" id="minPrice" class="form-control" placeholder="Min Fiyat">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-t-5">
                                    <input type="number" id="maxPrice" class="form-control" placeholder="Max Fiyat">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control show-tick" id="priceSort">
                                    <option value="">Fiyat Sıralama</option>
                                    <option value="asc">En Düşükten En Yükseğe</option>
                                    <option value="desc">En Yüksekten En Düşüğe</option>
                                </select>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-sm-12 mt-3">
                                <button type="button" id="filterButton" class="btn btn-primary">
                                    <i class="zmdi zmdi-filter-list"></i> Filtrele
                                </button>
                                <button type="button" id="clearFiltersButton" class="btn btn-secondary ml-2">
                                    <i class="zmdi zmdi-close"></i> Filtreleri Temizle
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            @if($advertisements->isEmpty())
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <h4>Henüz İlan eklenmemiş.</h4>
                        </div>
                    </div>
                </div>
            @else
                @foreach($advertisements as $advertisement)
                    <div class="col-lg-4 col-md-12 advert">
                        <div class="card property_list">
                            <div class="property_image">
                                <a href="{{ route('admin.advertisements.show', $advertisement->id) }}">
                                    <img class="img-thumbnail img-fluid" src="{{ asset('storage/' . $advertisement->cover_image_thumb) }}" 
                                         alt="img" style="max-height: 400px; min-height: 400px; object-fit: cover;">
                                </a>
                                @if($advertisement->sale_status == 'Satıldı')
                                    <span class="badge badge-success" style="position: absolute; top: 10px; right: 10px; background-color: #28a745; color: white;">Satıldı</span>
                                @elseif($advertisement->sale_status == 'Satılmadı')
                                    <span class="badge badge-warning" style="position: absolute; top: 10px; right: 10px; background-color: #ffc107; color: white;">Satılmadı</span>
                                @endif
                                @if($advertisement->reserve_status == 'Rezerve Edildi') 
                                    <span class="badge badge-warning" style="position: absolute; top: 40px; right: 10px; background-color: #ffc107; color: white;">Rezerve Edildi</span>
                                @elseif($advertisement->reserve_status == 'Rezerve Edilmedi')
                                    <span class="badge badge-warning" style="position: absolute; top: 40px; right: 10px; background-color: #ffc107; color: white;">Rezerve Edilmedi</span>
                                @endif
                                @if($advertisement->deposit_status == 'Ödendi')
                                    <span class="badge badge-danger" style="position: absolute; top: 70px; right: 10px; background-color: #dc3545; color: white;">Depozito Ödendi</span>
                                @elseif($advertisement->deposit_status == 'Ödenmedi')
                                    <span class="badge badge-warning" style="position: absolute; top: 70px; right: 10px; background-color: #ffc107; color: white;">Depozito Ödenmedi</span>
                                @endif
                            </div>
                            <div class="body">
                                <div class="property-content">
                                    <div class="detail">
                                        <h5 class="text-success m-t-0 m-b-0">{{ $advertisement->formatted_price }}</h5>
                                        @if((Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'sales_consultant') && $advertisement->commission)
                                            <h6 class="text-info m-t-5 m-b-10">
                                                <i class="zmdi zmdi-money-box m-r-5"></i>
                                                Komisyon: {{ number_format($advertisement->commission, 0, ',', '.') }} £
                                            </h6>
                                        @endif
                                        <h4 class="m-t-0"><a href="{{ route('admin.advertisements.show', $advertisement->id) }}" class="col-blue-grey" style="font-size: 1.2rem; font-weight: 600; color: #37474f !important;">{{ $advertisement->name }}</a></h4>
                                        @if($advertisement->city)
                                            <p class="text-muted"><i class="zmdi zmdi-pin m-r-5"></i>{{ $advertisement->city }}</p>
                                        @endif
                                        @if(Auth::user()->user_type == 'admin')
                                            <p class="text-muted">
                                                <i class="zmdi zmdi-account m-r-5"></i>
                                                Ekleyen: {{ $advertisement->creator->name }}
                                            </p>
                                        @endif
                                        <p class="text-muted m-b-0">{{ Str::limit($advertisement->description, 100) }}</p>
                                    </div>
                                    <div class="property-action m-t-15">
                                        <a href="#" title="Square Feet"><i class="zmdi zmdi-view-dashboard"></i><span>{{$advertisement->square_meters}} m²</span></a>
                                        <a href="#" title="Bedroom"><i class="zmdi zmdi-hotel"></i><span>{{$advertisement->room_type}}</span></a>
                                        @if(Auth::user()->user_type != 'agency')
                                            <a href="#" title="Garages"><i class="zmdi zmdi-home"></i><span>{{$advertisement->apartment_number}}</span></a>
                                        @endif
                                    </div>
                                    @if(Auth::user()->user_type == 'admin')
                                    <div class="d-flex justify-content-between mt-3">
                                        <a href="{{ route('admin.advertisements.edit', $advertisement) }}" class="btn btn-info btn-sm">
                                            <i class="zmdi zmdi-edit"></i> Düzenle
                                        </a>
                                        <form action="{{ route('admin.advertisements.destroy', $advertisement) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bu ilanı silmek istediğinizden emin misiniz?')">
                                                <i class="zmdi zmdi-delete"></i> Sil
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if($advertisements->total() > 10)
            <div class="mt-4 mb-4" style="display: flex; justify-content: center;">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        {{-- Önceki sayfa linki --}}
                        @if ($advertisements->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="zmdi zmdi-arrow-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $advertisements->previousPageUrl() }}" rel="prev">
                                    <i class="zmdi zmdi-arrow-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Sayfa numaraları --}}
                        @php
                            $currentPage = $advertisements->currentPage();
                            $lastPage = $advertisements->lastPage();
                            $delta = 2; // Aktif sayfanın her iki yanında kaç sayfa gösterileceği
                        @endphp

                        {{-- İlk sayfa --}}
                        @if($currentPage > ($delta + 1))
                            <li class="page-item">
                                <a class="page-link" href="{{ $advertisements->url(1) }}">1</a>
                            </li>
                            @if($currentPage > ($delta + 2))
                                <li class="page-item disabled">
                                    <span class="page-link" style="font-weight: bold; letter-spacing: 2px;">•••</span>
                                </li>
                            @endif
                        @endif

                        {{-- Sayfa numaraları --}}
                        @foreach(range(max(1, $currentPage - $delta), min($lastPage, $currentPage + $delta)) as $page)
                            <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ $advertisements->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Son sayfa --}}
                        @if($currentPage < ($lastPage - $delta))
                            @if($currentPage < ($lastPage - $delta - 1))
                                <li class="page-item disabled">
                                    <span class="page-link" style="font-weight: bold; letter-spacing: 2px;">•••</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $advertisements->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Sonraki sayfa linki --}}
                        @if ($advertisements->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $advertisements->nextPageUrl() }}" rel="next">
                                    <i class="zmdi zmdi-arrow-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="zmdi zmdi-arrow-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Bootstrap-select'i başlat
            $('.form-control.show-tick').selectpicker();
            
            // Form elementlerini seçelim
            const searchInput = $('#searchInput');
            const saleStatusFilter = $('#saleStatusFilter');
            const reserveStatusFilter = $('#reserveStatusFilter');
            const depositStatusFilter = $('#depositStatusFilter');
            const roomTypeFilter = $('#roomTypeFilter');
            const selectedRoomTypes = $('#selectedRoomTypes');
            const minPrice = $('#minPrice');
            const maxPrice = $('#maxPrice');
            const priceSort = $('#priceSort');
            const filterButton = $('#filterButton');
            const clearFiltersButton = $('#clearFiltersButton');

            // URL'den parametreleri al ve form elementlerine doldur
            const urlParams = new URLSearchParams(window.location.search);
            searchInput.val(urlParams.get('search'));
            saleStatusFilter.val(urlParams.get('sale_status'));
            reserveStatusFilter.val(urlParams.get('reserve_status'));
            depositStatusFilter.val(urlParams.get('deposit_status'));
            minPrice.val(urlParams.get('min_price'));
            maxPrice.val(urlParams.get('max_price'));
            priceSort.val(urlParams.get('price_sort'));
            
            if (urlParams.has('room_types')) {
                const roomTypes = urlParams.get('room_types').split(',');
                roomTypeFilter.val(roomTypes);
            }
            
            // Bootstrap-select'i güncelle
            $('.form-control.show-tick').selectpicker('refresh');
            updateSelectedRoomTypes();

            // Oda tipi seçimlerini yönetme
            roomTypeFilter.on('changed.bs.select', function (e) {
                updateSelectedRoomTypes();
            });

            function updateSelectedRoomTypes() {
                selectedRoomTypes.empty();
                const selected = roomTypeFilter.val() || [];
                
                selected.forEach(function(type) {
                    const badge = $(`<span class="badge badge-primary mr-2 mb-2" style="font-size: 14px; padding: 5px 10px;">
                        ${type}
                        <i class="zmdi zmdi-close ml-1" style="cursor: pointer;" data-type="${type}"></i>
                    </span>`);
                    
                    badge.find('.zmdi-close').on('click', function() {
                        const typeToRemove = $(this).data('type');
                        const currentSelections = roomTypeFilter.val().filter(t => t !== typeToRemove);
                        roomTypeFilter.val(currentSelections);
                        roomTypeFilter.selectpicker('refresh');
                        updateSelectedRoomTypes();
                    });
                    
                    selectedRoomTypes.append(badge);
                });
            }

            // Filtreleme fonksiyonu
            function applyFilters() {
                const params = new URLSearchParams();
                
                // Tüm filtreleri URL parametrelerine ekle
                if (searchInput.val()) params.append('search', searchInput.val());
                if (saleStatusFilter.val()) params.append('sale_status', saleStatusFilter.val());
                if (reserveStatusFilter.val()) params.append('reserve_status', reserveStatusFilter.val());
                if (depositStatusFilter.val()) params.append('deposit_status', depositStatusFilter.val());
                if (minPrice.val()) params.append('min_price', minPrice.val());
                if (maxPrice.val()) params.append('max_price', maxPrice.val());
                if (priceSort.val()) params.append('price_sort', priceSort.val());
                
                const selectedRoomTypes = roomTypeFilter.val();
                if (selectedRoomTypes && selectedRoomTypes.length > 0) {
                    params.append('room_types', selectedRoomTypes.join(','));
                }

                // Sayfayı yeni parametrelerle yükle
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            }

            // Filtreleri temizleme fonksiyonu
            function clearFilters() {
                window.location.href = window.location.pathname;
            }

            // Event listener'ları ekleyelim
            filterButton.on('click', function(e) {
                e.preventDefault();
                applyFilters();
            });
            
            clearFiltersButton.on('click', function(e) {
                e.preventDefault();
                clearFilters();
            });
        });
    </script>
@endsection