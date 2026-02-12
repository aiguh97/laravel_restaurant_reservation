<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Restoguh</title>
    <style>
        body, table, td, a { text-decoration: none !important; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #f4f7f6; }
        table { border-collapse: collapse !important; }

        @media screen and (max-width: 600px) {
            .content-table { width: 95% !important; }
            .otp-code { font-size: 32px !important; letter-spacing: 6px !important; }
            .logo-img { width: 130px !important; }
        }
    </style>
</head>
<body style="font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f7f6; padding: 40px 0;">
        <tr>
            <td align="center">

                <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 35px;">
                    <tr>
                        <td align="center">
                            <img src="https://ik.imagekit.io/8wuwjawgk/casdd__1_-removebg-preview.png"
                                 alt="Restoguh Logo"
                                 width="160"
                                 class="logo-img"
                                 style="display: block; margin: 0 auto; border: none; outline: none;">
                        </td>
                    </tr>
                </table>

                <table class="content-table" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px; background-color: #ffffff; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    <tr>
                        <td style="padding: 45px 40px;">
                            <h2 style="color: #1e293b; margin: 0 0 15px 0; font-size: 24px; font-weight: 800; text-align: center; letter-spacing: -0.5px;">Verifikasi Kode OTP</h2>

                            <p style="color: #64748b; font-size: 16px; line-height: 1.6; text-align: center; margin-bottom: 35px;">
                                Halo, kami menerima permintaan login untuk akun Anda. Gunakan kode rahasia di bawah ini untuk melanjutkan:
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px dashed #cbd5e1; border-radius: 12px; background-color: #fcfdfe;">
                                <tr>
                                    <td style="padding: 35px 20px; text-align: center;">
                                        <div style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 15px;">KODE RAHASIA ANDA</div>
                                        <div class="otp-code" style="font-size: 42px; font-weight: 800; color: #0d6b5e; letter-spacing: 12px; font-family: 'Courier New', Courier, monospace;">
                                            {{ $otp }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin-top: 35px; text-align: center;">
                                <p style="color: #64748b; font-size: 14px; line-height: 1.5;">
                                    Kode ini berlaku selama <strong style="color: #1e293b;">10 menit</strong>.<br>
                                    Jangan berikan kode ini kepada siapapun termasuk pihak Restoguh.
                                </p>
                            </div>

                            <div style="margin-top: 40px; border-top: 1px solid #f1f5f9; padding-top: 25px; text-align: center;">
                                <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                                    Email ini dikirim secara otomatis oleh sistem <strong>Restoguh POS</strong>.
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px; margin-top: 30px;">
                    <tr>
                        <td align="center">
                            <p style="color: #94a3b8; font-size: 13px; margin: 0;">
                                &copy; 2024 <strong>Restoguh.</strong> &bull; <a href="#" style="color: #0d9488; font-weight: 600;">Kebijakan Privasi</a>
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>
