@extends('auth.layouts.app')

@section('title', 'Kayıt Ol')

@section('navbar')
    <a class="nav-link btn btn-primary btn-round" href="{{ route('login') }}">Giriş Yap</a>
@endsection

@section('content')
@php
    $settings = \App\Models\SiteSetting::first();
@endphp
<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">
            <form class="form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="header">
                    <div class="logo-container">
                        @if ($settings && $settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="">
                        @else
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                        @endif
                    </div>
                    <h5>Kayıt Ol</h5>
                    <span>Yeni bir üye kayıt olun</span>
                </div>
                <div class="content">                                                
                    <div class="input-group">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Ad Soyad" value="{{ old('name') }}" required>
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-account-circle"></i>
                        </span>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="E-posta Adresi" value="{{ old('email') }}" required>
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-email"></i>
                        </span>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Şifre" 
                               class="form-control @error('password') is-invalid @enderror" required />
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" placeholder="Şifre Tekrar" 
                               class="form-control" required />
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="desired_role">Kullanıcı Tipi</label>
                        <select name="desired_role" id="desired_role" class="form-control @error('desired_role') is-invalid @enderror" style="color: #495057; background-color: #fff;" required>
                            <option value="" style="color: #495057;">Seçiniz</option>
                            <option value="sales_consultant" {{ old('desired_role') == 'sales_consultant' ? 'selected' : '' }} style="color: #495057;">Satış Danışmanı</option>
                            <option value="agency" {{ old('desired_role') == 'agency' ? 'selected' : '' }} style="color: #495057;">Acente</option>
                        </select>
                        @error('desired_role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <input type="file" name="profile_image" class="form-control @error('profile_image') is-invalid @enderror">
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-image"></i>
                        </span>
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="checkbox">
                    <input id="terms" name="terms" type="checkbox">
                    <label for="terms">
                        Kullanım Sözleşmesini okudum ve kabul ediyorum <a href="javascript:void(0);" data-toggle="modal" data-target="#termsModal">Kullanım Sözleşmesi</a>
                    </label>
                    @error('terms')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="footer text-center">
                    <button type="submit" class="btn l-cyan btn-round btn-lg btn-block waves-effect waves-light">Kayıt Ol</button>
                    <h6 class="m-t-20"><a class="link" href="{{ route('login') }}">Zaten bir üye misiniz?</a></h6>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Terms of Use Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Kullanım Sözleşmesi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: initial;">
                @if($settings && $settings->terms_of_use)
                    {!! $settings->terms_of_use !!}
                @else
                    <p>Kullanım sözleşmesi henüz tanımlanmamış.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
@endsection


