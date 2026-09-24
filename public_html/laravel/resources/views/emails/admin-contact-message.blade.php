<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni İletişim Mesajı</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f4f4; padding:20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                <tr>
                    <td style="padding:24px 32px;">
                        <h2 style="margin:0 0 16px; color:#1f2933;">Yeni İletişim Mesajı</h2>
                        <p style="margin:0 0 12px; color:#334155;">Site üzerinden yeni bir iletişim formu gönderildi.</p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; border-collapse:collapse;">
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold; width:35%;">İsim</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">{{ $contact->name ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">E-posta</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">{{ $contact->email ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">Telefon</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">{{ $contact->phone_number ?? 'Belirtilmemiş' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">Gönderim Tarihi</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">{{ optional($contact->created_at)->format('d.m.Y H:i') }}</td>
                            </tr>
                        </table>

                        <div style="margin:20px 0; padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; color:#475569;">
                            {{ $contact->message }}
                        </div>

                        <p style="margin:24px 0;">
                            <a href="{{ route('admin.contacts.index') }}"
                               style="display:inline-block; padding:12px 24px; background-color:#2563eb; color:#ffffff; text-decoration:none; border-radius:6px;">
                                Mesaj Yönetimi
                            </a>
                        </p>

                        <p style="margin:0; font-size:12px; color:#64748b;">Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayınız.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
