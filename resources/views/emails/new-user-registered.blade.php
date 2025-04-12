<!DOCTYPE html>
<html>
<head>
    <title>Yeni Kullanıcı Kaydı</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2196F3;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .user-info {
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .user-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-info td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .user-info td:first-child {
            font-weight: bold;
            width: 140px;
        }
        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 10px auto;
            display: block;
            border: 3px solid #2196F3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Yeni Kullanıcı Kaydı!</h2>
    </div>
    
    <div class="content">
        <p>Merhaba,</p>
        <p>Sisteme yeni bir kullanıcı kaydı yapıldı. Kullanıcı detayları aşağıdadır:</p>
        
        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profil Fotoğrafı" class="profile-image">
        @else
            <img src="{{ asset('assets/images/default-avatar.png') }}" alt="Varsayılan Profil Fotoğrafı" class="profile-image">
        @endif

        <div class="user-info">
            <table>
                <tr>
                    <td>Ad Soyad:</td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td>E-posta:</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Olmak istediği rol:</td>
                    <td>
                        @php
                            $userType = $user->userType;
                        @endphp
                        {{ $userType ? $userType->display_role : 'Belirtilmemiş' }}
                    </td>
                </tr>
                <tr>
                    <td>Kayıt Tarihi:</td>
                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                </tr>
                <tr>
                    <td>IP Adresi:</td>
                    <td>{{ request()->ip() }}</td>
                </tr>
            </table>
        </div>

        <p style="margin-top: 20px;">
            Kullanıcı hesabını incelemek ve gerekli işlemleri yapmak için admin panelini kullanabilirsiniz.
        </p>
    </div>

    <div class="footer">
        <p>Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayınız.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tüm hakları saklıdır.</p>
    </div>
</body>
</html> 