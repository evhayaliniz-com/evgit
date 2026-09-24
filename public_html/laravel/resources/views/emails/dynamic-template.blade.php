<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectText }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
<div style="max-width: 650px; margin: auto; background: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/images/settings/1745669004_logo.svg" alt="Ev Hayaliniz" style="max-width: 180px;">
    </div>

    <!-- Başlık -->
    <h2 style="text-align: center; color: #333;">{{ $subjectText }}</h2>

    <hr style="margin: 20px 0;">

    <!-- İçerik -->
    <div style="font-size: 16px; color: #444;">
        {!! $content !!}
    </div>

    <hr style="margin: 30px 0;">

    <!-- Footer -->
    <p style="font-size: 14px; color: #777;">
        📨 Tüm sorularınız için bize ulaşmaktan çekinmeyin.<br>
        💬 Biz sadece bir emlak platformu değil, <strong>çözüm ortağınız</strong>ız.<br><br>
        Başarılı ve huzurlu bir ev yolculuğu dileriz.<br>
        <strong>Ev Hayaliniz Ekibi</strong>
    </p>
</div>
</body>
</html>
