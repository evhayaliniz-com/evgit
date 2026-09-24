<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Kullanıcı Kaydı</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4; padding:20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff; border-radius:8px; overflow:hidden;">

                <!-- Logo -->
                <tr>
                    <td style="padding:20px; text-align:center;">
                        <img src="{{url('/')}}/{{\App\Models\Setting::first()?->logo}}" alt="Logo" style="max-width:150px; height:auto;">
                    </td>
                </tr>

                <!-- İçerik -->
                <tr>
                    <td style="padding:10px 30px 30px 30px; color:#333; font-size:16px; line-height:1.5;">
                        <h2 style="color:#0062ff; margin-top:0;">{{ $newUser->user_type === 'company' ? 'Yeni Firma Kayıt' : 'Bireysel Üye Kayıt' }}</h2>
                        <p>Sisteme yeni bir {{ $newUser->user_type === 'company' ? 'firma' : 'bireysel üye' }} kaydı yapıldı:</p>

                        <table style="width:100%; margin:20px 0; border-collapse: collapse;">
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold; width:40%;">Kullanıcı Tipi:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ $userType }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">İsim:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ $userName }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">E-posta:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ $newUser->email }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">Kayıt Tarihi:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ $newUser->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            @if($newUser->user_type === 'company' && $newUser->company)
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">İl:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ optional($newUser->company->province)->name ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">İlçe:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ optional($newUser->company->district)->name ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">Kategori:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ optional($newUser->company->category)->name ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; background-color:#f9f9f9; border:1px solid #eee; font-weight:bold;">Alt Kategori:</td>
                                <td style="padding:10px; border:1px solid #eee;">{{ optional($newUser->company->subCategory)->name ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            @endif
                        </table>

                        @if($newUser->user_type === 'company')
                        <p style="margin-top:20px; text-align:center;">
                            <a href="{{ url('/admin/companies') }}"
                               style="display:inline-block; padding:12px 24px; background-color:#0062ff; color:#fff; text-decoration:none; border-radius:5px;">
                                Firmayı Görüntüle
                            </a>
                        </p>
                        @else
                        <p style="margin-top:20px; text-align:center;">
                            <a href="{{ url('/admin/users') }}"
                               style="display:inline-block; padding:12px 24px; background-color:#0062ff; color:#fff; text-decoration:none; border-radius:5px;">
                                Kullanıcıyı Görüntüle
                            </a>
                        </p>
                        @endif
                    </td>
                </tr>

                <!-- Footer -->
                <tr style="background-color:#f4f4f4;">
                    <td style="padding:20px 30px; font-size:12px; color:#999; text-align:center;">
                        Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayınız.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
