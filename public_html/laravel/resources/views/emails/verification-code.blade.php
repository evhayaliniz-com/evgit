<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>E-posta Doğrulama Kodu</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
<div style="max-width: 650px; margin: auto; background: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/images/settings/1745669004_logo.svg" alt="Ev Hayaliniz" style="max-width: 180px;">
    </div>

    <!-- Başlık -->
    <h2 style="text-align: center; color: #333;">E-posta Doğrulama Kodu 🔐</h2>

    <p style="font-size: 16px; color: #444;">
        Merhaba,
    </p>

    <p style="font-size: 16px; color: #444;">
        <strong>Ev Hayaliniz</strong> platformuna kayıt olmak için e-posta doğrulama kodunuz aşağıdadır:
    </p>

    <!-- Kod Kutusu -->
    <div style="text-align: center; margin: 40px 0;">
        <div style="display: inline-block; background-color: #f0f8ff; border: 2px dashed #2196f3; border-radius: 8px; padding: 20px 40px;">
            <span style="font-size: 32px; font-weight: bold; color: #2196f3; letter-spacing: 8px;">{{ $code }}</span>
        </div>
    </div>

    <p style="font-size: 15px; color: #666; text-align: center;">
        ⏰ Bu kod <strong>10 dakika</strong> boyunca geçerlidir.
    </p>

    <hr style="margin: 30px 0;">

    <!-- Güvenlik Uyarısı -->
    <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0;">
        <p style="margin: 0; color: #856404; font-size: 14px;">
            ⚠️ <strong>Güvenlik Uyarısı:</strong> Bu kodu kimseyle paylaşmayın. Ev Hayaliniz ekibi sizden bu kodu asla istemez.
        </p>
    </div>

    <p style="font-size: 14px; color: #666;">
        Eğer bu kayıt işlemini siz yapmadıysanız, bu e-postayı görmezden gelebilirsiniz.
    </p>

    <!-- Footer -->
    <p style="font-size: 14px; color: #777; margin-top: 30px;">
        Başarılı bir kayıt dileriz,<br>
        <strong>Ev Hayaliniz Ekibi</strong>
    </p>
</div>
</body>
</html>
