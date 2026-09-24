<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Fikir Paylaşıldı</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4; padding:20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
                <tr>
                    <td style="padding:24px 32px;">
                        <h2 style="margin:0 0 16px; color:#1f2933;">Yeni Fikir Paylaşıldı</h2>
                        <p style="margin:0 0 12px; color:#334155;">
                            Kullanıcılardan biri yeni bir fikir paylaştı. İçeriğin özeti aşağıdadır.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:20px 0; border-collapse:collapse;">
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold; width:40%;">Paylaşan Kullanıcı</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">
                                    {{ $creator->name ?? 'Anonim' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">E-posta</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">
                                    {{ $creator->email }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">Paylaşım Tarihi</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">
                                    {{ optional($idea->created_at)->format('d.m.Y H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">Kategori</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">
                                    {{ optional($idea->category)->name ?? 'Belirtilmemiş' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px; border:1px solid #e2e8f0; background:#f8fafc; font-weight:bold;">Alt Kategori</td>
                                <td style="padding:10px; border:1px solid #e2e8f0;">
                                    {{ optional($idea->subCategory)->name ?? 'Belirtilmemiş' }}
                                </td>
                            </tr>
                        </table>

                        <div style="margin:20px 0; padding:16px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; color:#475569;">
                            {{ \Illuminate\Support\Str::limit(strip_tags(data_get($idea, 'content', '')), 220) }}
                        </div>

                        @php
                            $images = [];
                            if ($idea->path) {
                                $decoded = json_decode($idea->path);
                                if (is_array($decoded)) {
                                    $images = $decoded;
                                }
                            }
                        @endphp

                        @if(count($images) > 0)
                        <div style="margin:20px 0;">
                            <h3 style="margin:0 0 12px; color:#1f2933; font-size:16px;">Görseller</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    @foreach($images as $index => $image)
                                        @if($index < 3)
                                        <td style="padding:5px;" align="center">
                                            <img src="{{ url($image) }}" alt="Fikir Görseli {{ $index + 1 }}"
                                                 style="max-width:180px; height:auto; border-radius:6px; border:1px solid #e2e8f0;">
                                        </td>
                                        @endif
                                    @endforeach
                                </tr>
                            </table>
                            @if(count($images) > 3)
                            <p style="margin:8px 0 0; font-size:12px; color:#64748b;">
                                ve {{ count($images) - 3 }} görsel daha...
                            </p>
                            @endif
                        </div>
                        @endif

                        <p style="margin:24px 0;">
                            <a href="{{ url('/idea/' . $idea->slug) }}"
                               style="display:inline-block; padding:12px 24px; background-color:#2563eb; color:#ffffff; text-decoration:none; border-radius:6px;">
                                Fikri Görüntüle
                            </a>
                        </p>

                        <p style="margin:0; font-size:12px; color:#64748b;">
                            Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayınız.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
