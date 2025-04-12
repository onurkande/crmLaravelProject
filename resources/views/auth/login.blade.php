@extends('auth.layouts.app')

@section('title', 'Giriş Yap')

@section('navbar')
    <a class="nav-link btn btn-primary btn-round" href="{{ route('register') }}">Kayıt Ol</a>
@endsection

@section('content')
@php
    $settings = \App\Models\SiteSetting::first();
@endphp
<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="header">
                    <div class="logo-container">
                        @if ($settings && $settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="">
                        @else
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                        @endif
                    </div>
                    <h5>Giriş Yap</h5>
                </div>
                <div class="content">                                                
                    <div class="input-group input-lg">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="E-posta Adresi" value="{{ old('email') }}" required>
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-email"></i>
                        </span>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group input-lg">
                        <input type="password" name="password" placeholder="Şifre" 
                               class="form-control @error('password') is-invalid @enderror" required />
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-lock"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="checkbox">
                        <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Beni Hatırla</label>
                    </div>
                </div>
                <div class="footer text-center">
                    <button type="submit" class="btn l-cyan btn-round btn-lg btn-block waves-effect waves-light">Giriş Yap</button>
                    <h6 class="m-t-20"><a href="#" class="link">Şifremi Unuttum?</a></h6>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
