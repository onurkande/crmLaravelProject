<div class="footer">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="footer-logo">
                    @if ($settings && $settings->logo)
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->app_name }}" height="40">
                    @else
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" height="40">
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="footer-content text-right">
                    @if ($settings && $settings->footer_content)
                        {!! $settings->footer_content !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.footer {
    background: #fff;
    padding: 20px 0;
    width: 100%;
    border-top: 1px solid rgba(0,0,0,0.1);
    z-index: 999;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    min-height: 80px; /* Footer için minimum yükseklik */
    margin-top: auto; /* Sayfanın altına yapıştırmak için */
}

/* Ana içerik alanı için wrapper */
.content {
    min-height: calc(100vh - 80px); /* Viewport height - footer height */
    display: flex;
    flex-direction: column;
}

.footer-logo {
    padding-left: 20px;
    display: flex;
    align-items: center;
}

.footer-logo img {
    max-height: 40px;
    width: auto;
}

.footer-content {
    padding-right: 20px;
    color: #666;
    font-size: 14px;
    line-height: 1.6;
}

.footer-content a {
    color: #2196F3;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-content a:hover {
    color: #0d47a1;
}

/* Mobil görünüm için responsive ayarlar */
@media (max-width: 1024px) {
    .footer {
        margin-left: 0;
        width: 100%;
        padding: 15px 0;
    }

    .footer-logo,
    .footer-content {
        text-align: center;
        padding: 10px 15px;
    }

    .footer-content.text-right {
        text-align: center !important;
    }

    .footer-logo {
        justify-content: center;
    }
}

/* Dark tema için */
body.theme-dark .footer {
    background: #222;
    border-top: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
}

body.theme-dark .footer-content {
    color: #999;
}

body.theme-dark .footer-content a {
    color: #64b5f6;
}

body.theme-dark .footer-content a:hover {
    color: #90caf9;
}
</style> 