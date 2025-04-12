@extends('admin.layouts.master')

@section('title', 'Komisyon Düzenle')

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
            <h2>Komisyon Düzenle
                <small class="text-muted">Komisyon Bilgilerini Düzenle</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.commissions.index') }}">Komisyonlar</a></li>
                <li class="breadcrumb-item active">Komisyon Düzenle</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="color: #2196F3; font-weight: 600;">Komisyon Düzenle</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.commissions.update', $commission) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="consultant_id">Danışman</label>
                            <select name="consultant_id" id="consultant_id" class="form-control show-tick @error('consultant_id') is-invalid @enderror" required>
                                <option value="">Danışman Seçin</option>
                                @foreach($consultants as $consultant)
                                    <option value="{{ $consultant->id }}" {{ old('consultant_id', $commission->consultant_id) == $consultant->id ? 'selected' : '' }}>
                                        {{ $consultant->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('consultant_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Fiyat</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $commission->price) }}" required>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="percentage">Yüzde</label>
                            <input type="number" step="0.01" name="percentage" id="percentage" class="form-control @error('percentage') is-invalid @enderror" value="{{ old('percentage', $commission->percentage) }}" required>
                            @error('percentage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Güncelle
                            </button>
                            <a href="{{ route('admin.commissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Geri Dön
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 