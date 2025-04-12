@extends('admin.layouts.master')

@section('title', 'İlan Ekle')



@section('content')

    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>İlan Ekle
                <small class="text-muted">İlan Ekle</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">                
                
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}">İlanlar</a></li>
                    <li class="breadcrumb-item active">İlan Ekle</li>
                </ul>                
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="color: #2196F3; font-weight: 600;">Yeni İlan Ekle</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.advertisements.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">İlan Adı</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Fiyat</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" step="0.01">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="commission">Komisyon</label>
                                <input type="number" class="form-control @error('commission') is-invalid @enderror" id="commission" name="commission" value="{{ old('commission') }}" step="1">
                                @error('commission')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Açıklama</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deposit_status">Depozito Durumu</label>
                                <select class="form-control show-tick @error('deposit_status') is-invalid @enderror" id="deposit_status" name="deposit_status">
                                    <option value="">Seçiniz</option>
                                    <option value="">Boş Bırak</option>
                                    <option value="Ödendi">Ödendi</option>
                                    <option value="Ödenmedi">Ödenmedi</option>
                                </select>
                                @error('deposit_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sale_status">Satılık Durumu</label>
                                <select class="form-control show-tick @error('sale_status') is-invalid @enderror" id="sale_status" name="sale_status">
                                    <option value="">Seçiniz</option>
                                    <option value="">Boş Bırak</option>
                                    <option value="Satıldı">Satıldı</option>
                                    <option value="Satılmadı">Satılmadı</option>
                                </select>
                                @error('sale_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="reserve_status">Rezerve Durumu</label>
                                <select class="form-control show-tick @error('reserve_status') is-invalid @enderror" id="reserve_status" name="reserve_status">
                                    <option value="">Seçiniz</option>
                                    <option value="">Boş Bırak</option>
                                    <option value="Rezerve Edildi">Rezerve Edildi</option>
                                    <option value="Rezerve Edilmedi">Rezerve Edilmedi</option>
                                </select>
                                @error('reserve_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cover_image">Kapak Fotoğrafı</label>
                                <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" required>
                                @error('cover_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="images">Galeri Resimleri</label>
                                <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
                                @error('images')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="debt_amount">Borç Durumu</label>
                                <input type="number" class="form-control @error('debt_amount') is-invalid @enderror" id="debt_amount" name="debt_amount" value="{{ old('debt_amount') }}" step="0.01">
                                @error('debt_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="square_meters">M2</label>
                                <input type="number" class="form-control @error('square_meters') is-invalid @enderror" id="square_meters" name="square_meters" value="{{ old('square_meters') }}" required>
                                @error('square_meters')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="apartment_number">Daire No</label>
                                <input type="text" class="form-control @error('apartment_number') is-invalid @enderror" id="apartment_number" name="apartment_number" value="{{ old('apartment_number') }}" required>
                                @error('apartment_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="room_type">Oda Tipi (Villa, 1+0 vb.)</label>
                                <input type="text" class="form-control @error('room_type') is-invalid @enderror" id="room_type" name="room_type" value="{{ old('room_type') }}" required>
                                @error('room_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="city">Şehir( Eklemezseniz Boş Kalır! )</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="map_location">Harita Konumu( Sadece iFrame Kodu! )</label>
                                <textarea class="form-control @error('map_location') is-invalid @enderror" id="map_location" name="map_location" rows="3">{{ old('map_location') }}</textarea>
                                @error('map_location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <h4 class="mt-4">Özellikler</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="supermarket" type="checkbox" name="supermarket" {{ old('supermarket') ? 'checked' : '' }}>
                                        <label for="supermarket">Süpermarket</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="spa_sauna_massage" type="checkbox" name="spa_sauna_massage" {{ old('spa_sauna_massage') ? 'checked' : '' }}>
                                        <label for="spa_sauna_massage">Spa / Sauna / Masaj</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="exchange_office" type="checkbox" name="exchange_office" {{ old('exchange_office') ? 'checked' : '' }}>
                                        <label for="exchange_office">Döviz Bürosu</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="cafe_bar" type="checkbox" name="cafe_bar" {{ old('cafe_bar') ? 'checked' : '' }}>
                                        <label for="cafe_bar">Kafe & Bar</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="gift_shop" type="checkbox" name="gift_shop" {{ old('gift_shop') ? 'checked' : '' }}>
                                        <label for="gift_shop">Hediyelik Eşya</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="pharmacy" type="checkbox" name="pharmacy" {{ old('pharmacy') ? 'checked' : '' }}>
                                        <label for="pharmacy">Eczane</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="bank" type="checkbox" name="bank" {{ old('bank') ? 'checked' : '' }}>
                                        <label for="bank">Banka</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="bicycle_path" type="checkbox" name="bicycle_path" {{ old('bicycle_path') ? 'checked' : '' }}>
                                        <label for="bicycle_path">Bisiklet Yolu</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="green_areas" type="checkbox" name="green_areas" {{ old('green_areas') ? 'checked' : '' }}>
                                        <label for="green_areas">Yeşil Alanlar</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="restaurant" type="checkbox" name="restaurant" {{ old('restaurant') ? 'checked' : '' }}>
                                        <label for="restaurant">Restoran</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="playground" type="checkbox" name="playground" {{ old('playground') ? 'checked' : '' }}>
                                        <label for="playground">Oyun Parkı</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="water_slides" type="checkbox" name="water_slides" {{ old('water_slides') ? 'checked' : '' }}>
                                        <label for="water_slides">Su Kaydırakları</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="walking_track" type="checkbox" name="walking_track" {{ old('walking_track') ? 'checked' : '' }}>
                                        <label for="walking_track">Yürüyüş Parkuru</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="fitness_gym" type="checkbox" name="fitness_gym" {{ old('fitness_gym') ? 'checked' : '' }}>
                                        <label for="fitness_gym">Fitness Salonu</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="football_field" type="checkbox" name="football_field" {{ old('football_field') ? 'checked' : '' }}>
                                        <label for="football_field">Futbol Sahası</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="pool" type="checkbox" name="pool" {{ old('pool') ? 'checked' : '' }}>
                                        <label for="pool">Havuz</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="security" type="checkbox" name="security" {{ old('security') ? 'checked' : '' }}>
                                        <label for="security">Güvenlik</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="parking" type="checkbox" name="parking" {{ old('parking') ? 'checked' : '' }}>
                                        <label for="parking">Otopark</label>
                                    </div>
                                    <div class="checkbox inlineblock m-r-20">
                                        <input id="ev_charging" type="checkbox" name="ev_charging" {{ old('ev_charging') ? 'checked' : '' }}>
                                        <label for="ev_charging">Elektrikli Araç Şarj</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection