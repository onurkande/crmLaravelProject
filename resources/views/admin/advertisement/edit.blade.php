@extends('admin.layouts.master')

@section('title', 'İlan Düzenle')

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
                <h2>İlan Düzenle
                    <small class="text-muted">İlan Düzenle</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}">İlanlar</a></li>
                    <li class="breadcrumb-item active">İlan Düzenle</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="color: #2196F3; font-weight: 600;">İlan Düzenle</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.advertisements.update', $advertisement) }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label>İlan Adı</label>
                                <input type="text" name="name" class="form-control" value="{{ $advertisement->name }}" required>
                            </div>

                            <div class="form-group">
                                <label>Fiyat</label>
                                <input type="number" name="price" class="form-control" step="0.01" value="{{ $advertisement->price }}" required>
                            </div>

                            <div class="form-group">
                                <label for="commission">Komisyon</label>
                                <input type="number" class="form-control @error('commission') is-invalid @enderror" id="commission" name="commission" value="{{ old('commission', $advertisement->commission) }}" step="1">
                                @error('commission')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Açıklama</label>
                                <textarea name="description" class="form-control" rows="3" required>{{ $advertisement->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="deposit_status">Depozito Durumu</label>
                                <select class="form-control show-tick @error('deposit_status') is-invalid @enderror" id="deposit_status" name="deposit_status">
                                    <option value="">Seçiniz</option>
                                    <option value="" {{ $advertisement->deposit_status === null ? 'selected' : '' }}>Boş Bırak</option>
                                    <option value="Ödendi" {{ $advertisement->deposit_status === 'Ödendi' ? 'selected' : '' }}>Ödendi</option>
                                    <option value="Ödenmedi" {{ $advertisement->deposit_status === 'Ödenmedi' ? 'selected' : '' }}>Ödenmedi</option>
                                </select>
                                @error('deposit_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sale_status">Satılık Durumu</label>
                                <select class="form-control show-tick @error('sale_status') is-invalid @enderror" id="sale_status" name="sale_status">
                                    <option value="">Seçiniz</option>
                                    <option value="" {{ $advertisement->sale_status === null ? 'selected' : '' }}>Boş Bırak</option>
                                    <option value="Satıldı" {{ $advertisement->sale_status === 'Satıldı' ? 'selected' : '' }}>Satıldı</option>
                                    <option value="Satılmadı" {{ $advertisement->sale_status === 'Satılmadı' ? 'selected' : '' }}>Satılmadı</option>
                                </select>
                                @error('sale_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="reserve_status">Rezerve Durumu</label>
                                <select class="form-control show-tick @error('reserve_status') is-invalid @enderror" id="reserve_status" name="reserve_status">
                                    <option value="">Seçiniz</option>
                                    <option value="" {{ $advertisement->reserve_status === null ? 'selected' : '' }}>Boş Bırak</option>
                                    <option value="Rezerve Edildi" {{ $advertisement->reserve_status === 'Rezerve Edildi' ? 'selected' : '' }}>Rezerve Edildi</option>
                                    <option value="Rezerve Edilmedi" {{ $advertisement->reserve_status === 'Rezerve Edilmedi' ? 'selected' : '' }}>Rezerve Edilmedi</option>
                                </select>
                                @error('reserve_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Mevcut Kapak Fotoğrafı</label>
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $advertisement->cover_image) }}" alt="Kapak Resmi" style="max-width: 200px;">
                                </div>
                                <label>Yeni Kapak Fotoğrafı (Değiştirmek için seçin)</label>
                                <input type="file" name="cover_image" class="form-control">
                            </div>

                            <div class="form-group mt-4">
                                <label>Mevcut Galeri Resimleri</label>
                                <div class="row mb-2">
                                    @foreach($advertisement->images as $image)
                                        <div class="col-md-3 mb-2">
                                            <div class="card">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Galeri Resmi" class="card-img-top" style="max-width: 200px; max-height: 100px; object-fit: cover;">
                                                <div class="card-body" style="min-height: auto;">
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                               name="delete_images[]" 
                                                               value="{{ $image->id }}" 
                                                               class="form-check-input" 
                                                               id="delete_image_{{ $image->id }}">
                                                        <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                                            Bu resmi sil
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <label>Yeni Galeri Resimleri (Eklemek için seçin)</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>

                            <div class="form-group">
                                <label>Borç Durumu</label>
                                <input type="number" name="debt_amount" class="form-control" step="0.01" value="{{ $advertisement->debt_amount }}">
                            </div>

                            <div class="form-group">
                                <label>M2</label>
                                <input type="number" name="square_meters" class="form-control" value="{{ $advertisement->square_meters }}" required>
                            </div>

                            <div class="form-group">
                                <label>Daire No</label>
                                <input type="text" name="apartment_number" class="form-control" value="{{ $advertisement->apartment_number }}" required>
                            </div>

                            <div class="form-group">
                                <label>Oda Tipi (Villa, 1+0, 1+1 vb.)</label>
                                <input type="text" name="room_type" class="form-control" value="{{ $advertisement->room_type }}" required>
                            </div>

                            <div class="form-group">
                                <label>Şehir</label>
                                <input type="text" name="city" class="form-control" value="{{ $advertisement->city }}">
                            </div>

                            <div class="form-group">
                                <label>Harita Konumu (Sadece iFrame Kodu!)</label>
                                <textarea name="map_location" class="form-control" rows="3">{{ $advertisement->map_location }}</textarea>
                            </div>

                            <h4 class="mt-4">Özellikler</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="supermarket" type="checkbox" name="supermarket" {{ $advertisement->features->supermarket ? 'checked' : '' }}>
                                        <label for="supermarket">Süpermarket</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="spa_sauna_massage" type="checkbox" name="spa_sauna_massage" {{ $advertisement->features->spa_sauna_massage ? 'checked' : '' }}>
                                        <label for="spa_sauna_massage">Spa / Sauna / Masaj</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="exchange_office" type="checkbox" name="exchange_office" {{ $advertisement->features->exchange_office ? 'checked' : '' }}>
                                        <label for="exchange_office">Döviz Bürosu</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="cafe_bar" type="checkbox" name="cafe_bar" {{ $advertisement->features->cafe_bar ? 'checked' : '' }}>
                                        <label for="cafe_bar">Kafe & Bar</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="gift_shop" type="checkbox" name="gift_shop" {{ $advertisement->features->gift_shop ? 'checked' : '' }}>
                                        <label for="gift_shop">Hediyelik Eşya</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="pharmacy" type="checkbox" name="pharmacy" {{ $advertisement->features->pharmacy ? 'checked' : '' }}>
                                        <label for="pharmacy">Eczane</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="bank" type="checkbox" name="bank" {{ $advertisement->features->bank ? 'checked' : '' }}>
                                        <label for="bank">Banka</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="bicycle_path" type="checkbox" name="bicycle_path" {{ $advertisement->features->bicycle_path ? 'checked' : '' }}>
                                        <label for="bicycle_path">Bisiklet Yolu</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="green_areas" type="checkbox" name="green_areas" {{ $advertisement->features->green_areas ? 'checked' : '' }}>
                                        <label for="green_areas">Yeşil Alanlar</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="restaurant" type="checkbox" name="restaurant" {{ $advertisement->features->restaurant ? 'checked' : '' }}>
                                        <label for="restaurant">Restoran</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="playground" type="checkbox" name="playground" {{ $advertisement->features->playground ? 'checked' : '' }}>
                                        <label for="playground">Oyun Parkı</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="water_slides" type="checkbox" name="water_slides" {{ $advertisement->features->water_slides ? 'checked' : '' }}>
                                        <label for="water_slides">Su Kaydırakları</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="walking_track" type="checkbox" name="walking_track" {{ $advertisement->features->walking_track ? 'checked' : '' }}>
                                        <label for="walking_track">Yürüyüş Parkuru</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="fitness_gym" type="checkbox" name="fitness_gym" {{ $advertisement->features->fitness_gym ? 'checked' : '' }}>
                                        <label for="fitness_gym">Fitness Salonu</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="football_field" type="checkbox" name="football_field" {{ $advertisement->features->football_field ? 'checked' : '' }}>
                                        <label for="football_field">Futbol Sahası</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="pool" type="checkbox" name="pool" {{ $advertisement->features->pool ? 'checked' : '' }}>
                                        <label for="pool">Havuz</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="security" type="checkbox" name="security" {{ $advertisement->features->security ? 'checked' : '' }}>
                                        <label for="security">Güvenlik</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="parking" type="checkbox" name="parking" {{ $advertisement->features->parking ? 'checked' : '' }}>
                                        <label for="parking">Otopark</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="ev_charging" type="checkbox" name="ev_charging" {{ $advertisement->features->ev_charging ? 'checked' : '' }}>
                                        <label for="ev_charging">Elektrikli Araç Şarj</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection