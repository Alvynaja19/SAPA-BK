<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dokumen Belum Tersedia : SAPA BK</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      background: #F8FAF8;
      color: #0F1D13;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 24px;
      text-align: center;
    }
    .box {
      background: #FFFFFF;
      border: 1px solid #E2E8DF;
      border-radius: 16px;
      padding: 40px 28px;
      max-width: 480px;
      box-shadow: 0 4px 16px rgba(15,29,19,0.06);
    }
    .icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      border-radius: 50%;
      background: #FEF3C7;
      color: #B45309;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    h2 {
      font-size: 20px;
      font-weight: 600;
      color: #0F1D13;
      margin-bottom: 8px;
    }
    p {
      font-size: 14px;
      color: #526658;
      line-height: 1.6;
      margin-bottom: 20px;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      min-height: 44px;
      padding: 10px 20px;
      border-radius: 8px;
      background: #15803D;
      color: #FFFFFF;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      border: none;
      cursor: pointer;
    }
    .btn:hover {
      background: #166534;
    }
  </style>
</head>
<body>
  <div class="box">
    <div class="icon">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="12" y1="18" x2="12" y2="12"/>
        <line x1="12" y1="9" x2="12.01" y2="9"/>
      </svg>
    </div>
    <h2>Berkas Modul Belum Tersedia</h2>
    <p>
      Dokumen <strong>"{{ $ebook->title ?? 'Modul Bimbingan' }}"</strong> belum diunggah secara fisik atau sedang diperbarui di server oleh Tim Guru BK SMAN 4 Jember.
    </p>
    <a href="{{ route('siswa.chat') }}" target="_top" class="btn">
      Hubungi Guru BK via Chat
    </a>
  </div>
</body>
</html>
