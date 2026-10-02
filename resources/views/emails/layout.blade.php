<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $platformShortName }}</title>
</head>
<body bgcolor="#edf2f4" style="margin:0;background:#edf2f4;color:#25282d;font-family:Arial,Helvetica,sans-serif;-webkit-text-size-adjust:100%;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $preheader ?? $platformName }}</div>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;background:#edf2f4;">
        <tr>
            <td align="center" style="padding:28px 14px 42px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:640px;overflow:hidden;background:#ffffff;border:1px solid #dce5e8;border-radius:24px;box-shadow:0 18px 38px rgba(63,81,88,.14);">
                    <tr>
                        <td height="6" bgcolor="#655bd6" style="height:6px;background:#655bd6;font-size:0;line-height:0;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="padding:26px 32px 24px;background:#f8fafb;border-bottom:1px solid #e8eef0;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="center" valign="middle">
                                        <p style="margin:0;color:#655bd6;font-size:11px;font-weight:700;letter-spacing:1.8px;line-height:1.4;text-transform:uppercase;">{{ $platformShortName }}</p>
                                        <p style="margin:4px 0 0;color:#63737a;font-size:12px;line-height:1.5;">Ruang tumbuh untuk karya dan usaha mahasiswa</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:34px 32px 36px;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:22px 32px 26px;border-top:1px solid #e8eef0;background:#f8fafb;text-align:center;">
                            <p style="margin:0;color:#718088;font-size:12px;line-height:1.7;">
                                Email otomatis dari <strong style="color:#4f5d63;">{{ $platformName }}</strong>.<br>
                                Jika kamu tidak merasa melakukan permintaan ini, abaikan email ini.
                            </p>
                            <p style="margin:12px 0 0;color:#9aa8ad;font-size:11px;line-height:1.5;">© {{ date('Y') }} {{ $platformShortName }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
