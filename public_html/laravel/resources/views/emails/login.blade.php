<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Bildirimi</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 40px;">
<div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/images/settings/1745669004_logo.svg" alt="Ev Hayaliniz" style="max-width: 180px;">
    </div>

    <!-- Başlık -->
    <h2 style="color: #333333;">🏠 Hesabınıza Yeni Bir Giriş Yapıldı</h2>

    <!-- İçerik -->
    <p>Merhaba <strong>{{ $user->name }}</strong>,</p>
    <p><strong>{{ now()->format('d.m.Y H:i') }}</strong> tarihinde hesabınıza bir giriş yapıldı.</p>
    <p>Bu giriş size ait değilse, lütfen hesabınızı güvene almak için hemen şifrenizi değiştirin.</p>

    <!-- Buton -->
    <div style="margin-top: 30px; text-align: center;">
        <a href="{{ route('user.dashboard') }}" style="display: inline-block; padding: 12px 24px; background-color: #2196f3; color: white; text-decoration: none; border-radius: 6px;">
            👤 Paneli Aç
        </a>
    </div>

    <!-- Alt Bilgi -->
    <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">

    <p style="color: #777777; font-size: 13px;">
        Bu e-posta güvenliğiniz için gönderilmiştir.<br>
        <strong>Ev Hayaliniz</strong> | <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}" style="color: #2196f3;">{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}</a>
    </p>
</div>
</body>
</html>
