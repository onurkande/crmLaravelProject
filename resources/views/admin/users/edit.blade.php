@extends('admin.layouts.master')

@section('title', 'Kullanıcı Düzenle')

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
                <h2>Kullanıcı Düzenle
                    <small class="text-muted">Kullanıcı Bilgilerini Düzenle</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Kullanıcılar</a></li>
                    <li class="breadcrumb-item active">Kullanıcı Düzenle</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Kullanıcı</strong> Bilgileri</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Ad Soyad</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>E-posta</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Şifre (Değiştirmek istemiyorsanız boş bırakın)</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Şifre Tekrar</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Kullanıcı Tipi</label>
                                <select name="user_type" class="form-control show-tick @error('user_type') is-invalid @enderror" 
                                        {{ $isSelfEdit ? 'disabled' : 'required' }}>
                                    <option value="">Seçiniz</option>
                                    <option value="admin" {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="sales_consultant" {{ old('user_type', $user->user_type) == 'sales_consultant' ? 'selected' : '' }}>Satış Danışmanı</option>
                                    <option value="agency" {{ old('user_type', $user->user_type) == 'agency' ? 'selected' : '' }}>Acenta</option>
                                    <option value="user" {{ old('user_type', $user->user_type) == 'user' ? 'selected' : '' }}>Normal Kullanıcı</option>
                                </select>
                                @if($isSelfEdit)
                                    <small class="text-muted">Kendi kullanıcı tipinizi değiştiremezsiniz.</small>
                                @endif
                                @error('user_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Mevcut Profil Fotoğrafı</label>
                                @if($user->profile_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profil" style="max-width: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                                @error('profile_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 