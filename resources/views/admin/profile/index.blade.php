@extends('admin.layouts.master')

@section('title', 'Profil Düzenle')

@section('content')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>Profil Düzenle
                <small class="text-muted">Profil Bilgilerinizi Güncelleyin</small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                <li class="breadcrumb-item active">Profil Düzenle</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Profil</strong> Bilgileri</h2>
                </div>
                <div class="body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Profil Fotoğrafı -->
                            <div class="col-md-12 mb-4">
                                <div class="text-center">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                             alt="Profil Fotoğrafı" 
                                             class="rounded-circle mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/images/default-avatar.png') }}" 
                                             alt="Varsayılan Profil Fotoğrafı"
                                             class="rounded-circle mb-3"
                                             style="width: 150px; height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="form-group">
                                        <input type="file" name="profile_image" class="form-control-file">
                                        <small class="text-muted">Maksimum 2MB, JPG veya PNG</small>
                                        @error('profile_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- İsim -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>İsim</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- E-posta -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>E-posta</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kullanıcı Tipi (Sadece görüntüleme) -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kullanıcı Tipi</label>
                                    <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $user->user_type)) }}" readonly>
                                    <small class="text-muted">Kullanıcı tipi değiştirilemez</small>
                                </div>
                            </div>

                            <!-- Şifre -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Yeni Şifre</label>
                                    <input type="password" name="password" class="form-control">
                                    <small class="text-muted">Şifrenizi değiştirmek istemiyorsanız boş bırakın</small>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Şifre Onayı -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Yeni Şifre Onayı</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="zmdi zmdi-save"></i> Değişiklikleri Kaydet
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 