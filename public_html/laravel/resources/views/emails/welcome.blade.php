<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hoş Geldiniz</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
<div style="max-width: 650px; margin: auto; background: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}/site/images/settings/1745669004_logo.svg" alt="Ev Hayaliniz" style="max-width: 180px;">
    </div>

    <!-- Başlık -->
    <h2 style="text-align: center; color: #333;">Hoş Geldiniz, {{ $user->name }} 👋</h2>

    <p style="font-size: 16px; color: #444;">
        🏡 <strong>Ev Hayaliniz</strong> ailesine katıldığınız için teşekkür ederiz.
        Hayalinizdeki eve giden yolda artık yalnız değilsiniz. Tüm ihtiyaçlarınızı tek çatı altında toplayan yepyeni bir deneyime adım attınız.
    </p>

    <hr style="margin: 30px 0;">

    <!-- Hakkımızda -->
    <h3 style="color: #2196f3;">🌍 Hakkımızda</h3>
    <p style="font-size: 15px; color: #555;">
        <strong>Ev Hayaliniz</strong>, alanında uzman ve onaylı çözüm ortaklarıyla, hayalinizdeki yaşam alanını oluşturmanız için gereken her hizmeti tek platformda sunar.
        Emlaktan tadilata, dekordan arsa danışmanlığına kadar tüm ihtiyaçlarınıza yanıt verir.
    </p>
    <blockquote style="border-left: 4px solid #2196f3; padding-left: 15px; color: #777; font-style: italic;">
        “Hayalinizdeki eve ulaşmanın en kolay yolu: <strong>EvHayaliniz.com</strong>”
    </blockquote>

    <!-- Neler Sunuyoruz -->
    <h3 style="color: #2196f3; margin-top: 30px;">🛠 Size Neler Sunuyoruz?</h3>
    <ul style="line-height: 1.8; color: #333;">
        <li>✅ Onaylı ve güvenilir emlak ofisleri</li>
        <li>✅ Satılık ve kiralık geniş portföy</li>
        <li>✅ Tadilat, dekorasyon ve ekspertiz hizmetleri</li>
        <li>✅ Arsa ve yatırım danışmanlığı</li>
        <li>✅ Profesyonel destek ve 7/24 iletişim</li>
    </ul>

    <!-- Vizyon & Misyon -->
    <h3 style="color: #2196f3; margin-top: 30px;">🎯 Vizyon & Misyonumuz</h3>
    <p style="color: #444;">
        <strong>Vizyonumuz:</strong> Müşterilerimize hayallerindeki evleri tasarlamak ve inşa etmek için ileri teknolojilerle, estetik ve işlevsel çözümler sunmak.<br><br>
        <strong>Misyonumuz:</strong> En son teknolojileri kullanarak, alanında uzman çözüm ortaklarımızla ihtiyaçlarınıza eksiksiz ve sorunsuz ulaşmanızı sağlamak.
    </p>

    <!-- Buton -->
    <div style="text-align: center; margin: 40px 0;">
        <a href="https://{{str_replace(['http://', 'https://'], '', env('APP_URL'))}}" style="background-color: #2196f3; color: #fff; padding: 14px 28px; border-radius: 6px; text-decoration: none; font-weight: bold;">
            🔑 Hemen Keşfet
        </a>
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
