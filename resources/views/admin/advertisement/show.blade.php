@extends('admin.layouts.master')

@section('title', 'İlan Detayı')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<style>
.gallery-container {
    margin: 20px 0;
}

.gallery-title {
    font-size: 18px;
    color: #2196F3;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #eee;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.gallery-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-5px);
}

.gallery-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover .gallery-image {
    transform: scale(1.05);
}

/* Dark tema için */
body.theme-dark .gallery-title {
    color: #64b5f6;
    border-bottom-color: #333;
}

body.theme-dark .gallery-item {
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}
</style>
@endsection

@section('content')
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>İlan Detayı
                    <small class="text-muted">{{ $advertisement->name }}</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}">İlanlar</a></li>
                    <li class="breadcrumb-item active">İlan Detayı</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">İlan Detayı</h3>
                        <div class="card-options">
                            <a href="{{ route('admin.advertisements.pdf', $advertisement) }}" class="btn btn-info">
                                <i class="zmdi zmdi-file-text"></i> PDF Çıktı Al
                            </a>
                        </div>
                    </div>
                    <div class="body">
                        <!-- Kapak Fotoğrafı -->
                        <div class="mb-4">
                            <div class="property_image">
                                <img class="img-fluid" src="{{ asset('storage/' . $advertisement->cover_image_large) }}" alt="İlan Resmi">
                            </div>
                        </div>

                        <!-- Galeri Resimleri -->
                        <div class="gallery-container">
                            <h4 class="gallery-title">
                                <i class="zmdi zmdi-collection-image"></i> 
                                Galeri Resimleri
                            </h4>
                            <div class="gallery-grid">
                                @foreach($advertisement->images as $image)
                                    <div class="gallery-item">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" 
                                           data-lightbox="advertisement-gallery" 
                                           data-title="{{ $advertisement->name }} - Resim {{ $loop->iteration }}">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                 alt="Galeri Resmi {{ $loop->iteration }}" 
                                                 class="gallery-image">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- İlan Detayları -->
                        <div class="property-content">
                            <div class="detail">
                                <h5 class="text-success m-t-0 m-b-0">{{ $advertisement->formatted_price }}</h5>
                                <h4 class="m-t-0">{{ $advertisement->name }}</h4>
                                
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tr>
                                                <th>Depozito Durumu:</th>
                                                <td>
                                                    @if($advertisement->deposit_status)
                                                        <span class="badge {{ $advertisement->deposit_status == 'Ödendi' ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $advertisement->deposit_status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Satış Durumu:</th>
                                                <td>
                                                    @if($advertisement->sale_status)
                                                        <span class="badge {{ $advertisement->sale_status == 'Satıldı' ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $advertisement->sale_status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Rezerve Durumu:</th>
                                                <td>
                                                    @if($advertisement->reserve_status)
                                                        <span class="badge {{ $advertisement->reserve_status == 'Rezerve Edildi' ? 'badge-success' : 'badge-warning' }}">
                                                            {{ $advertisement->reserve_status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Fiyat:</th>
                                                <td>{{ $advertisement->formatted_price }}</td>
                                            </tr>
                                            @if(Auth::user()->user_type != 'agency')
                                            <tr>
                                                <th>Borç Durumu:</th>
                                                <td>{{ $advertisement->debt_amount ? $advertisement->debt_amount . ' £' : 'Borç Yok' }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tr>
                                                <th>M2:</th>
                                                <td>{{ $advertisement->square_meters }} m²</td>
                                            </tr>
                                            @if(Auth::user()->user_type != 'agency')
                                            <tr>
                                                <th>Daire No:</th>
                                                <td>{{ $advertisement->apartment_number }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th>Oda Tipi:</th>
                                                <td>{{ $advertisement->room_type }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h5>Açıklama</h5>
                                    <p>{{ $advertisement->description }}</p>
                                </div>

                                @if($advertisement->map_location)
                                    <div class="mt-4">
                                        <h5>Konum</h5>
                                        <div class="map-container">
                                            {!! $advertisement->map_location !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Özellikler</h2>
                    </div>
                    <div class="body">
                        <ul class="list-unstyled">
                            @if($advertisement->features->supermarket)
                                <li><i class="zmdi zmdi-check text-success"></i> Süpermarket</li>
                            @endif
                            @if($advertisement->features->spa_sauna_massage)
                                <li><i class="zmdi zmdi-check text-success"></i> Spa / Sauna / Masaj</li>
                            @endif
                            @if($advertisement->features->exchange_office)
                                <li><i class="zmdi zmdi-check text-success"></i> Döviz Bürosu</li>
                            @endif
                            @if($advertisement->features->cafe_bar)
                                <li><i class="zmdi zmdi-check text-success"></i> Kafe & Bar</li>
                            @endif
                            @if($advertisement->features->gift_shop)
                                <li><i class="zmdi zmdi-check text-success"></i> Hediyelik Eşya</li>
                            @endif
                            @if($advertisement->features->pharmacy)
                                <li><i class="zmdi zmdi-check text-success"></i> Eczane</li>
                            @endif
                            @if($advertisement->features->bank)
                                <li><i class="zmdi zmdi-check text-success"></i> Banka</li>
                            @endif
                            @if($advertisement->features->bicycle_path)
                                <li><i class="zmdi zmdi-check text-success"></i> Bisiklet Yolu</li>
                            @endif
                            @if($advertisement->features->green_areas)
                                <li><i class="zmdi zmdi-check text-success"></i> Yeşil Alanlar</li>
                            @endif
                            @if($advertisement->features->restaurant)
                                <li><i class="zmdi zmdi-check text-success"></i> Restoran</li>
                            @endif
                            @if($advertisement->features->playground)
                                <li><i class="zmdi zmdi-check text-success"></i> Oyun Parkı</li>
                            @endif
                            @if($advertisement->features->water_slides)
                                <li><i class="zmdi zmdi-check text-success"></i> Su Kaydırakları</li>
                            @endif
                            @if($advertisement->features->walking_track)
                                <li><i class="zmdi zmdi-check text-success"></i> Yürüyüş Parkuru</li>
                            @endif
                            @if($advertisement->features->fitness_gym)
                                <li><i class="zmdi zmdi-check text-success"></i> Fitness Salonu</li>
                            @endif
                            @if($advertisement->features->football_field)
                                <li><i class="zmdi zmdi-check text-success"></i> Futbol Sahası</li>
                            @endif
                            @if($advertisement->features->pool)
                                <li><i class="zmdi zmdi-check text-success"></i> Havuz</li>
                            @endif
                            @if($advertisement->features->security)
                                <li><i class="zmdi zmdi-check text-success"></i> Güvenlik</li>
                            @endif
                            @if($advertisement->features->parking)
                                <li><i class="zmdi zmdi-check text-success"></i> Otopark</li>
                            @endif
                            @if($advertisement->features->ev_charging)
                                <li><i class="zmdi zmdi-check text-success"></i> Elektrikli Araç Şarj</li>
                            @endif
                        </ul>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
@endsection 
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Resim %1 / %2',
        'fadeDuration': 300,
        'imageFadeDuration': 300,
        'positionFromTop': 100
    });
</script>
@endsection
