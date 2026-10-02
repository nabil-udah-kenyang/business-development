@extends('emails.layout')

@section('content')
    <p style="margin:0;color:#655bd6;font-size:11px;font-weight:700;letter-spacing:1.8px;line-height:1.4;text-transform:uppercase;">Keamanan akun</p>
    <h1 style="margin:10px 0 0;color:#25282d;font-size:30px;font-weight:700;line-height:1.2;letter-spacing:-.4px;">Buat password baru</h1>
    <p style="margin:18px 0 0;color:#63737a;font-size:15px;line-height:1.75;">
        Kami menerima permintaan untuk mengganti password akun {{ $platformName }} kamu. Gunakan tombol di bawah untuk melanjutkan.
    </p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin:28px 0 24px;">
        <tr>
            <td align="left">
                <a href="{{ $actionUrl }}" style="display:inline-block;padding:14px 22px;border-radius:12px;background:#655bd6;color:#ffffff;font-size:14px;font-weight:700;line-height:1.2;text-decoration:none;box-shadow:0 8px 16px rgba(101,91,214,.24);">Buat password baru</a>
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td width="4" bgcolor="#655bd6" style="width:4px;border-radius:4px;background:#655bd6;font-size:0;">&nbsp;</td>
            <td style="padding:2px 0 2px 14px;color:#718088;font-size:13px;line-height:1.7;">
                Tautan ini berlaku selama <strong style="color:#4f5d63;">{{ $expiresIn }} menit</strong>. Jika kamu tidak meminta reset password, tidak ada tindakan yang perlu dilakukan.
            </td>
        </tr>
    </table>
@endsection
