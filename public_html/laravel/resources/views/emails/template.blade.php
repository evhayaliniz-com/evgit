<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mail</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f4; padding:20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff; border-radius:8px; overflow:hidden;">

                <!-- Logo -->
{{--                style="background-color:#0062ff;"--}}
                <tr>
                    <td style="padding:20px; text-align:center;">
                        <img src="{{url('/')}}/{{\App\Models\Setting::first()?->logo}}" alt="Logo" style="max-width:150px; height:auto;">
                    </td>
                </tr>
                <!-- İçerik -->
                <tr>
                    <td style="padding:10px 30px 30px 30px; color:#333; font-size:16px; line-height:1.5;">
                        <p>{{$msg}}</p>
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
