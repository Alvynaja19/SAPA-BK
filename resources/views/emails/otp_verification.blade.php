<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Akun SAPA BK</title>
</head>
<body style="margin:0; padding:0; background-color:#F4FBF6; font-family:'Segoe UI', Arial, sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4FBF6; padding:48px 0;">
    <tr>
      <td align="center">
        <table width="520" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 8px 32px rgba(21,128,61,0.08); border:1px solid #E2E8DF;">

          <!-- Header -->
          <tr>
            <td style="background:linear-gradient(135deg, #166534 0%, #15803D 60%, #16A34A 100%); padding:40px 40px 32px; text-align:center;">
              <div style="display:inline-block; background:rgba(255,255,255,0.18); border-radius:50%; width:64px; height:64px; line-height:64px; text-align:center; margin-bottom:16px;">
                <span style="font-size:30px;">✉️</span>
              </div>
              <p style="margin:0 0 6px; font-size:12px; color:rgba(255,255,255,0.8); letter-spacing:2px; font-weight:700; text-transform:uppercase;">Portal SAPA BK</p>
              <h1 style="margin:0; font-size:20px; color:#ffffff; font-weight:800; letter-spacing:0.5px;">SMA NEGERI 4 JEMBER</h1>
            </td>
          </tr>

          <!-- Badge Tujuan -->
          <tr>
            <td style="text-align:center; padding:0;">
              <span style="display:inline-block; margin-top:-14px; background:#ffffff; border:2px solid #15803D; color:#15803D; font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; padding:5px 18px; border-radius:20px;">
                @if($purpose === 'register')
                  Verifikasi Pendaftaran
                @else
                  Verifikasi Aktivasi Akun
                @endif
              </span>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:32px 40px 28px;">

              <p style="margin:0 0 8px; font-size:16px; color:#0F1D13; font-weight:700;">Halo, {{ $name }}! 👋</p>
              <p style="margin:0 0 24px; font-size:14px; color:#2D4033; line-height:1.7;">
                @if($purpose === 'register')
                  Terima kasih telah mendaftar di SAPA BK SMA Negeri 4 Jember. Gunakan kode verifikasi di bawah ini untuk menyelesaikan pendaftaran akun Anda.
                @else
                  Kami menerima permintaan aktivasi akun siswa Anda di portal SAPA BK SMA Negeri 4 Jember. Gunakan kode verifikasi 6 digit di bawah ini untuk mengaktifkan akun:
                @endif
              </p>

              <!-- OTP Box -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
                <tr>
                  <td align="center" style="background:#EDF9F0; border-radius:18px; border:2px dashed #86EFAC; padding:28px 20px;">
                    <p style="margin:0 0 10px; font-size:11px; color:#15803D; font-weight:700; letter-spacing:3px; text-transform:uppercase;">Kode Verifikasi OTP</p>
                    <p style="margin:0; font-size:46px; font-weight:900; letter-spacing:12px; color:#166534; font-family:'Courier New', Courier, monospace;">{{ $otp }}</p>
                    <p style="margin:12px 0 0; font-size:12px; color:#526658;">
                      ⏱ Berlaku selama <strong style="color:#15803D;">10 menit</strong>
                    </p>
                  </td>
                </tr>
              </table>

              <!-- Peringatan Keamanan -->
              <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr>
                  <td style="background:#FFFBEB; border-radius:12px; border-left:4px solid #F59E0B; padding:14px 16px;">
                    <p style="margin:0; font-size:13px; color:#92400E; line-height:1.6;">
                      🔒 <strong>Keamanan:</strong> Jangan berikan kode OTP ini kepada siapa pun, termasuk pihak sekolah atau guru.
                    </p>
                  </td>
                </tr>
              </table>

              <hr style="border:none; border-top:1px solid #E2E8DF; margin:0 0 20px;">

              <p style="margin:0; font-size:12px; color:#526658; line-height:1.7;">
                Jika Anda tidak merasa mengajukan aktivasi atau pendaftaran ini, silakan abaikan email ini atau segera laporkan ke Guru BK di ruang bimbingan konseling SMAN 4 Jember.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#F8FAF8; padding:20px 40px 24px; text-align:center; border-top:1px solid #E2E8DF;">
              <p style="margin:0 0 4px; font-size:13px; color:#2D4033; font-weight:600;">SAPA BK SMA Negeri 4 Jember</p>
              <p style="margin:0; font-size:11px; color:#526658;">Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
