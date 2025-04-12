@extends('auth.layouts.app')

@section('title', 'Bakım Modu')

@section('content')
<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">
            <div class="header">
                <div class="logo-container">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                </div>
                <h5>Bakım Modu</h5>
            </div>
            <div class="content text-center">
                <div class="alert alert-warning">
                    <i class="zmdi zmdi-alert-triangle"></i>
                    <p>Sitemiz şu anda bakım modunda. Lütfen daha sonra tekrar deneyiniz.</p>
                </div>
                <p>Yakında tekrar hizmetinizdeyiz...</p>
            </div>
        </div>
    </div>
</div>
@endsection 