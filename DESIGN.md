# Design Direction: SAPA BK SMA Negeri 4 Jember

> Dokumen acuan visual, arah desain, palet warna resmi, dan standar aksesibilitas kontras untuk seluruh antarmuka portal SAPA BK SMAN 4 Jember.

---

## 1. Identitas & Karakter Brand

- **Nama Brand:** SAPA BK (Sistem Aplikasi Pendampingan & Aspirasi Bimbingan Konseling)
- **Institusi:** SMA Negeri 4 Jember
- **Kepribadian Visual:**
  - **Empati & Kehangatan:** Memberikan rasa aman, ramah, dan tidak menghakimi bagi siswa remaja.
  - **Pertumbuhan & Edukasi:** Mewakili pendampingan masa depan, kesehatan mental, dan pencapaian prestasi belajar.
  - **Profesional & Terpercaya:** Tetap menjaga wibawa akademis bimbingan konseling dan tata kelola sekolah.
- **Antislop Dials:**
  - `ENERGY: 2` (Harmonis, elegan, tidak berlebihan dengan tren sesaat)
  - `RHYTHM: 2` (Variasi komposisi seksi yang teratur dan nyaman dibaca)
  - `MOTION: 1` (Transisi halus untuk interaksi mikro dan hover, tanpa looping yang mengganggu konsentrasi)

---

## 2. Palet Warna Resmi (Harmonis & Berkontras Tinggi)

### Primary Color: Forest & Emerald Green
Warna identitas pertumbuhan, kesehatan mental, dan kehormatan sekolah:
- `brand-25`: `#F4FBF6`
- `brand-50`: `#EDF9F0`
- `brand-100`: `#DCFCE7` (Latar aksen lembut)
- `brand-200`: `#BBF7D0` (Border aksen positif)
- `brand-300`: `#86EFAC`
- `brand-400`: `#4ADE80`
- `brand-500`: `#22C55E`
- `brand-600`: `#16A34A`
- `brand-700`: `#15803D` (Tombol utama & branding teks, rasio kontras 5.2:1 di atas putih)
- `brand-800`: `#166534` (Deep Forest untuk hover & aksen tebal)
- `brand-900`: `#14532D`
- `brand-950`: `#052E16`

### Accent Color: Warm Amber & Honey Gold
Aksen kehangatan, harapan, dan daya tarik interaktif:
- `accent-50`: `#FFFBEB`
- `accent-100`: `#FEF3C7` (Latar badge/pill)
- `accent-200`: `#FDE68A`
- `accent-300`: `#FCD34D`
- `accent-400`: `#FBBF24`
- `accent-500`: `#F59E0B`
- `accent-600`: `#D97706`
- `accent-700`: `#B45309` (Teks kontras tinggi pada badge aksen, rasio > 4.5:1)
- `accent-800`: `#92400E`
- `accent-900`: `#78350F` (Teks judul aksen, rasio 8.5:1 di atas `#FEF3C7`)

### Neutral & Canvas
Menggantikan warna latar belakang lama yang kekuningan/kusam (`#FBF8EA`) dengan latar bersih, modern, dan seimbang:
- **Canvas / Background Utama:**
  - Frontend & Portal Siswa: `#F8FAF8` (Ivory-pearl segar, bersahabat untuk mata)
  - Seksi Alternatif: `#EEF4ED` (Mint slate lembut)
  - Dashboard TailAdmin: `#F8FAFC` (Slate neutral terang) / `#0B0F19` (Dark mode)
- **Kartu & Surface:** `#FFFFFF` murni (Mode terang) / `#111827` (Mode gelap)
- **Garis & Border:** `#E2E8DF` (Frontend) / `#E2E8F0` (Dashboard) / `#1F2937` (Dark mode)
- **Teks (Ink):**
  - Utama: `#0F1D13` (Frontend) / `#0F172A` (Dashboard) — Rasio kontras > 14:1
  - Sekunder (Muted): `#2D4033` / `#334155` — Rasio kontras > 7:1
  - Lembut (Faint): `#526658` / `#475569` — Rasio kontras > 4.6:1 (Lulus WCAG AA)

---

## 3. Standar Aksesibilitas (WCAG AA Compliance)

- Seluruh teks body berukuran normal (14px–16px) wajib memiliki rasio kontras terhadap latar belakangnya minimal **4.5:1**.
- Teks besar / tebal (18px+ atau bold 14px+) wajib memiliki rasio kontras minimal **3.0:1**.
- Tombol dan target interaktif memiliki area sentuh minimum **44px x 44px**.
- State `:focus-visible` memiliki ring kontras jelas untuk navigasi keyboard.
