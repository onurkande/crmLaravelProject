@extends('auth.layouts.app')

@section('title', 'Kayıt Başarılı')

@section('content')
<div class="container">
    <div class="col-md-12 content-center">
        <div class="card-plain">
            <div class="header">
                <div class="logo-container">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                </div>
                <h5>Kayıt İşlemi Başarılı!</h5>
            </div>
            <div class="content text-center">
                <div class="alert alert-success">
                    <i class="zmdi zmdi-check-circle"></i>
                    <p>Kaydınız başarıyla oluşturuldu. En kısa sürede sizinle iletişime geçilecektir.</p>
                </div>
                <p>Login sayfasına yönlendiriliyorsunuz...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    setTimeout(function() {
        window.location.href = "{{ url('/login') }}";
    }, 5000);
</script>
@endsection 