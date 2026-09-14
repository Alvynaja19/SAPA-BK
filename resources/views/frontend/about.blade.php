@extends('layouts.guest')

@section('title', 'Tentang Layanan BK : SAPA BK SMAN 4 Jember')

@section('content')
<section class="page-section">
  <div class="wrap">
    
    <!-- Page Header -->
    <div class="page-header">
      <div class="badge-pill">Profil Layanan Konseling</div>
      <h1 class="page-title">Bimbingan &amp; Konseling SMAN 4 Jember</h1>
      <p class="page-lede">
        Berkomitmen mendampingi peserta didik SMA Negeri 4 Jember mencapai kematangan pribadi, keharmonisan sosial, prestasi akademik, serta kesiapan karir masa depan secara holistik.
      </p>
    </div>

    <!-- Visi & Misi Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; margin-bottom: 40px;">
      <!-- Visi -->
      <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 32px; box-shadow: var(--shadow-card);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--bg-alt); color: var(--primary); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <circle cx="12" cy="12" r="6"/>
            <circle cx="12" cy="12" r="2"/>
          </svg>
        </div>
        <h2 style="font-size: 22px; margin-bottom: 12px;">Visi Layanan BK</h2>
        <p style="font-size: 15px; color: var(--ink-soft); line-height: 1.7;">
          Terwujudnya layanan bimbingan dan konseling yang memandirikan peserta didik SMA Negeri 4 Jember agar berkembang secara optimal dalam aspek pribadi, sosial, belajar, dan karir berlandaskan Profil Pelajar Pancasila.
        </p>
      </div>

      <!-- Misi -->
      <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 32px; box-shadow: var(--shadow-card);">
        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--bg-alt); color: var(--primary); display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m9 11 3 3L22 4"/>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
          </svg>
        </div>
        <h2 style="font-size: 22px; margin-bottom: 12px;">Misi Layanan BK</h2>
        <ul style="font-size: 14.5px; color: var(--ink-soft); line-height: 1.7; display: flex; flex-direction: column; gap: 10px; list-style: disc; padding-left: 20px;">
          <li>Memfasilitasi pemahaman diri dan eksplorasi bakat serta potensi akademik peserta didik.</li>
          <li>Mengembangkan iklim pergaulan sosial yang empatik, toleran, dan bebas dari perundungan (anti-bullying).</li>
          <li>Menyediakan pendampingan studi lanjut perguruan tinggi (SNBP, SNBT, Kedinasan) yang terarah.</li>
          <li>Mengintegrasikan inovasi teknologi informasi cerdas melalui portal digital SAPA BK.</li>
        </ul>
      </div>
    </div>

    <!-- 4 Bidang Layanan Bimbingan -->
    <div style="margin-bottom: 48px;">
      <h2 style="font-size: 24px; text-align: center; margin-bottom: 24px;">4 Bidang Bimbingan Utama</h2>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 24px;">
          <div style="font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 6px;">Bidang 01</div>
          <h3 style="font-size: 18px; margin-bottom: 8px;">Bimbingan Pribadi</h3>
          <p style="font-size: 13.5px; color: var(--ink-soft); line-height: 1.6;">
            Pengembangan kedewasaan diri, pengelolaan emosi, pemahaman karakter, dan penguatan kesehatan mental remaja.
          </p>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 24px;">
          <div style="font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 6px;">Bidang 02</div>
          <h3 style="font-size: 18px; margin-bottom: 8px;">Bimbingan Sosial</h3>
          <p style="font-size: 13.5px; color: var(--ink-soft); line-height: 1.6;">
            Keterampilan komunikasi asertif, hubungan harmonis antarsebaya, kepedulian lingkungan, dan pencegahan konflik.
          </p>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 24px;">
          <div style="font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 6px;">Bidang 03</div>
          <h3 style="font-size: 18px; margin-bottom: 8px;">Bimbingan Belajar</h3>
          <p style="font-size: 13.5px; color: var(--ink-soft); line-height: 1.6;">
            Strategi belajar efektif, manajemen waktu sekolah, motivasi berprestasi, dan cara mengatasi kejenuhan belajar.
          </p>
        </div>
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 24px;">
          <div style="font-weight: 700; color: var(--primary); font-size: 14px; margin-bottom: 6px;">Bidang 04</div>
          <h3 style="font-size: 18px; margin-bottom: 8px;">Bimbingan Karir</h3>
          <p style="font-size: 13.5px; color: var(--ink-soft); line-height: 1.6;">
            Pemetaan minat bakat, analisis peluang jurusan kuliah (SNBP/SNBT), karir profesional, dan studi kedinasan.
          </p>
        </div>
      </div>
    </div>

    <!-- Asas Kerahasiaan ABKIN Banner -->
    <div style="background: var(--ink); color: #FFFFFF; border-radius: var(--radius-l); padding: clamp(28px, 4vw, 44px); margin-bottom: 52px; display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">
      <div style="width: 56px; height: 56px; border-radius: 14px; background: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
      </div>
      <div style="flex: 1; min-width: 260px;">
        <h2 style="color: #FFFFFF; font-size: 22px; margin-bottom: 8px;">Komitmen Asas Kerahasiaan Konseling</h2>
        <p style="font-size: 14.5px; color: #D2E4D6; line-height: 1.7;">
          Setiap sesi curhat, catatan asesmen, dan data pribadi siswa dijamin kerahasiaannya sesuai Kode Etik Asosiasi Bimbingan dan Konseling Indonesia (ABKIN). Ruang konseling SAPA BK adalah ruang aman tanpa rasa cemas dihakimi.
        </p>
      </div>
    </div>

    <!-- Tim Guru BK SMAN 4 Jember -->
    <div>
      <div class="page-header" style="margin-bottom: 36px;">
        <div class="badge-pill">Konselor Sekolah</div>
        <h2 class="page-title" style="font-size: 28px;">Tim Guru BK SMA Negeri 4 Jember</h2>
        <p class="page-lede" style="font-size: 15px;">
          Guru bimbingan konseling profesional yang siap membersamai perjalanan belajar dan pertumbuhan mental setiap siswa.
        </p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
        <!-- Guru 1 -->
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 28px; text-align: center; box-shadow: var(--shadow-card);">
          <div style="width: 72px; height: 72px; border-radius: 50%; background: var(--bg-alt); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; font-family: 'Fraunces', serif; margin: 0 auto 16px;">
            SR
          </div>
          <h3 style="font-size: 17px; margin-bottom: 4px;">Dra. Hj. Siti Rahayu, M.Pd.</h3>
          <div style="font-size: 13px; font-weight: 600; color: var(--primary); margin-bottom: 12px;">Koordinator Guru BK</div>
          <p style="font-size: 13px; color: var(--ink-soft); line-height: 1.5;">
            Fokus: Konseling Karir, Analisis Nilai SNBP, serta Peminatan Perguruan Tinggi Negeri.
          </p>
        </div>

        <!-- Guru 2 -->
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 28px; text-align: center; box-shadow: var(--shadow-card);">
          <div style="width: 72px; height: 72px; border-radius: 50%; background: var(--blue-soft); color: var(--blue); display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; font-family: 'Fraunces', serif; margin: 0 auto 16px;">
            BW
          </div>
          <h3 style="font-size: 17px; margin-bottom: 4px;">Bambang Wijaya, S.Pd., Kons.</h3>
          <div style="font-size: 13px; font-weight: 600; color: var(--blue); margin-bottom: 12px;">Guru BK Fase F (Kelas XI - XII)</div>
          <p style="font-size: 13px; color: var(--ink-soft); line-height: 1.5;">
            Fokus: Bimbingan Belajar, Tes Minat Bakat, Penanganan Burnout, dan Regulasi Stres.
          </p>
        </div>

        <!-- Guru 3 -->
        <div style="background: var(--surface); border: 1px solid var(--line); border-radius: var(--radius-m); padding: 28px; text-align: center; box-shadow: var(--shadow-card);">
          <div style="width: 72px; height: 72px; border-radius: 50%; background: var(--accent-soft); color: var(--accent-ink); display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; font-family: 'Fraunces', serif; margin: 0 auto 16px;">
            NA
          </div>
          <h3 style="font-size: 17px; margin-bottom: 4px;">Nur Aini, S.Pd.</h3>
          <div style="font-size: 13px; font-weight: 600; color: var(--accent-ink); margin-bottom: 12px;">Guru BK Fase E (Kelas X)</div>
          <p style="font-size: 13px; color: var(--ink-soft); line-height: 1.5;">
            Fokus: Adaptasi Lingkungan Sekolah Baru, Keterampilan Sosial, dan Relasi Sebaya.
          </p>
        </div>
      </div>
    </div>

    <!-- Help Banner -->
    <div class="help-banner" style="margin-top: 56px;">
      <h3>Ingin Berkonsultasi dengan Tim Guru BK?</h3>
      <p>
        Silakan gunakan layanan konsultasi online atau buat janji temu tatap muka di ruang BK SMAN 4 Jember.
      </p>
      <a href="{{ auth()->check() ? route('siswa.chat') : route('login') }}" class="btn btn-primary">
        Mulai Konsultasi Siswa
      </a>
    </div>

  </div>
</section>
@endsection
