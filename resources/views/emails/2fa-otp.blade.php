<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi 2FA</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 40px 0 30px 0;" align="center">
                <div style="background-color: #4f46e5; width: 60px; height: 60px; line-height: 60px; border-radius: 50%; color: #ffffff; font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);">
                    {{ substr(config('app.name'), 0, 1) }}
                </div>
                <h2 style="color: #1f2937; margin: 0;">{{ config('app.name') }}</h2>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 0 20px 40px 20px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding: 40px; text-align: left;">
                            <h3 style="color: #111827; margin-top: 0; font-size: 20px;">Halo,</h3>
                            <p style="color: #4b5563; font-size: 16px; line-height: 24px; margin-bottom: 30px;">
                                Kami menerima permintaan untuk masuk ke akun Anda. Gunakan kode verifikasi di bawah ini untuk melanjutkan:
                            </p>

                            <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 30px;">
                                <span style="display: block; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Kode Verifikasi Anda</span>
                                <span style="font-size: 32px; font-weight: 800; color: #4f46e5; letter-spacing: 5px;">{{ $otp }}</span>
                            </div>

                            <p style="color: #6b7280; font-size: 14px; line-height: 22px;">
                                Kode ini akan **kedaluwarsa dalam 10 menit**. Jika Anda tidak merasa melakukan permintaan ini, harap abaikan email ini dan segera amankan akun Anda.
                            </p>

                            <hr style="border: 0; border-top: 1px solid #f3f4f6; margin: 30px 0;">

                            <p style="color: #9ca3af; font-size: 12px; text-align: center; margin: 0;">
                                Pesan ini dikirim secara otomatis, mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-bottom: 40px;">
                <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
