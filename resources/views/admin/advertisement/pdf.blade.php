<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>İlan Detayı - {{ $advertisement->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2196F3;
            padding-bottom: 10px;
        }
        .title {
            color: #2196F3;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .cover-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #333;
            padding: 8px;
            width: 30%;
            background-color: #e9ecef;
        }
        .info-value {
            display: table-cell;
            color: #666;
            padding: 8px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: white;
        }
        .status-success {
            background-color: #28a745;
        }
        .status-warning {
            background-color: #ffc107;
            color: #000;
        }
        .description {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .map-container {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        .logo-image {
            max-width: 200px;
            max-height: 50px;
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">{{ $advertisement->name }}</h1>
    </div>

    <img src="{{$advertisementImageSrc}}" alt="Kapak Fotoğrafı" class="cover-image">

    <div class="info-section">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">İlan Numarası</div>
                <div class="info-value">{{ $advertisement->id }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fiyat</div>
                <div class="info-value">{{ $advertisement->formatted_price }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Metrekare</div>
                <div class="info-value">{{ $advertisement->square_meters }} m²</div>
            </div>
            <div class="info-row">
                <div class="info-label">Daire No</div>
                <div class="info-value">{{ $advertisement->apartment_number }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Oda Tipi</div>
                <div class="info-value">{{ $advertisement->room_type }}</div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Depozito Durumu</div>
                <div class="info-value">
                    <span class="status-badge {{ $advertisement->deposit_status == 'Ödendi' ? 'status-success' : 'status-warning' }}">
                        {{ $advertisement->deposit_status }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Satış Durumu</div>
                <div class="info-value">
                    <span class="status-badge {{ $advertisement->sale_status == 'Satıldı' ? 'status-success' : 'status-warning' }}">
                        {{ $advertisement->sale_status }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Rezerve Durumu</div>
                <div class="info-value">
                    <span class="status-badge {{ $advertisement->reserve_status == 'Rezerve Edildi' ? 'status-success' : 'status-warning' }}">
                        {{ $advertisement->reserve_status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="description">
        <h3 style="color: #2196F3; margin-bottom: 10px;">İlan Detayı</h3>
        <p>{{ $advertisement->description }}</p>
    </div>

    @if($advertisement->map_location)
        <div class="map-container">
            <h3 style="color: #2196F3; margin-bottom: 10px;">Konum Bilgisi</h3>
            {!! $advertisement->city !!}
        </div>
    @endif

    <div class="footer">
        @if($settings && $settings->logo)
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="{{ $imageSrc }}" alt="Noyanlar Invest Logo" class="logo-image">
            </div>
        @endif
        <p>Bu belge {{ now()->format('d.m.Y H:i') }} tarihinde oluşturulmuştur.</p>
        <p>© {{ date('Y') }} https://noyanlarinvestinfo.com/</p>
    </div>
</body>
</html> 