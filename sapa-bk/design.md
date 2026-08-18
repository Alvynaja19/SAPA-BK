# Design & UI/UX Prompt — SAPA BK (SMA Negeri 4 Jember)

Kumpulan prompt siap-copy untuk **Stitch AI**, satu prompt per halaman, mengikuti struktur routing di SRS SAPA BK. Tema warna hijau-putih mengikuti identitas visual SMAN 4 Jember (lihat referensi navbar pill hijau, badge hijau solid, card dengan border kiri hijau, angka bulat hijau muda).

---

## 🎨 Design System Global

> Tempelkan blok ini di **awal setiap prompt** (atau simpan sebagai "style guide" di Stitch jika didukung), supaya semua halaman konsisten.

```
DESIGN SYSTEM:
Style: Clean, elegant, professional, modern educational/institutional web app.
Mood: Trustworthy, calm, supportive (BK/counseling context), tidak kaku, ramah untuk siswa SMA.

COLOR PALETTE:
- Primary Green: #059669 (emerald 600) — untuk tombol utama, ikon aktif, aksen
- Primary Green Dark: #047857 — hover state, teks judul penting
- Primary Green Light: #ECFDF5 — background section lembut, badge, highlight card
- Accent Mint: #10B981 — bullet number, icon circle, progress bar
- White: #FFFFFF — background utama & card
- Neutral Background: #F8FAFC — background halaman (bukan card)
- Text Dark: #0F172A — heading
- Text Body: #475569 — paragraf
- Border/Divider: #E2E8F0
- Success/Status Aktif: hijau; Warning: amber; Error: merah (dipakai minim, hanya untuk status)

TYPOGRAPHY:
- Font sans-serif modern (mis. Inter/Poppins)
- Heading: bold, tight letter-spacing, warna Text Dark
- Body: regular, warna Text Body, line-height nyaman dibaca

KOMPONEN KHAS:
- Navbar: pill-shaped rounded-full container warna abu terang, menu item hijau saat aktif, tombol CTA hijau solid rounded-full di kanan
- Card: rounded-2xl, shadow lembut, border kiri tebal hijau untuk card "highlight"
- Badge/Pill: background hijau muda (#ECFDF5) teks hijau tua, atau hijau solid untuk badge penting (mis. status "Aktif", "SPMB")
- Numbered list: angka dalam lingkaran kecil hijau muda
- Tombol utama: hijau solid, rounded-full/rounded-lg, teks putih, ada hover darken
- Tombol sekunder: outline hijau atau ghost
- Ikon: line icon minimalis, warna hijau untuk state aktif
- Ilustrasi/mascot opsional bergaya 3D ramah (seperti karakter guru di pojok kanan bawah landing page) — pakai hanya di halaman publik, TIDAK di dashboard admin/guru
- Layout: banyak white space, grid rapi, rounded corners konsisten di semua elemen

RESPONSIVE: mobile-first, navbar collapse jadi hamburger di mobile, card grid jadi 1 kolom.
BAHASA UI: Bahasa Indonesia.
```

---

## Cara Pakai

Setiap section di bawah adalah **satu prompt lengkap** (sudah include ringkasan design system) untuk satu halaman. Copy 1 blok kode → paste ke Stitch AI → generate. Urutkan sesuai prioritas tahap pengembangan di SRS (Tahap 2 → publik dulu, lalu siswa, guru BK, admin).

---

## A. Halaman Publik (Tamu, tanpa login)

### 1. Landing Page — `/`
```
Buatkan desain UI landing page portal BK sekolah "SAPA BK" untuk SMA Negeri 4 Jember.
Tema warna hijau-putih, elegan, profesional (emerald green #059669, white, light green #ECFDF5).

Section yang dibutuhkan (urut dari atas):
1. Navbar pill rounded, logo sekolah kiri, menu: Beranda, Tentang BK, E-book, Artikel, FAQ, tombol "Login" hijau solid di kanan
2. Hero section: headline besar tentang layanan BK digital + subheadline singkat + 2 tombol CTA ("Mulai Konsultasi" hijau solid, "Pelajari Lebih Lanjut" outline) + ilustrasi/mascot ramah di sisi kanan
3. Section "Layanan BK": grid 3-4 card ikon (konsultasi chatbot AI, e-book, artikel, tes psikologi), card rounded dengan border kiri hijau
4. Section "E-book Pilihan": carousel/grid 3-4 card cover e-book dengan judul & tombol "Baca"
5. Section "Artikel Terbaru": grid 3 card artikel (thumbnail, judul, ringkasan, tanggal)
6. Section FAQ singkat: accordion 4-5 pertanyaan populer, tombol "Lihat semua FAQ"
7. Chat widget bubble hijau melayang di pojok kanan bawah dengan icon chat, badge notifikasi kecil
8. Footer hijau tua/putih dengan info sekolah, link cepat, kontak

Style: rounded-2xl cards, shadow lembut, banyak white space, tidak kaku, terasa hangat dan suportif.
```

### 2. Tentang BK — `/tentang`
```
Desain UI halaman "Tentang BK" (informasi layanan Bimbingan & Konseling sekolah).
Tema hijau-putih elegan, konsisten dengan navbar pill hijau dan card rounded border kiri hijau.

Struktur:
- Navbar publik sama seperti landing page
- Hero kecil: judul "Tentang Layanan BK" + breadcrumb
- Section penjelasan visi/misi layanan BK (mirip pola "Visi & Misi": card kiri untuk visi dengan box motto hijau muda, card kanan list misi bernomor bulat hijau)
- Section "Tim Guru BK": grid card foto + nama + jabatan guru BK
- Section jam layanan / cara konsultasi (ikon + teks singkat, 3 kolom)
- CTA banner hijau solid full-width "Mulai konsultasi sekarang" dengan tombol putih
- Footer sama seperti landing page
```

### 3. Daftar E-book — `/ebook`
```
Desain UI halaman daftar e-book publik untuk portal BK sekolah.
Tema hijau-putih, clean, profesional.

Struktur:
- Navbar publik
- Header halaman: judul "E-book BK" + search bar rounded + filter kategori (pill button hijau outline, aktif jadi solid hijau)
- Grid card e-book (3-4 kolom desktop, 1 kolom mobile): cover buku rounded, judul, deskripsi singkat 1 baris, badge "Gratis"/"Publik" hijau muda, tombol "Baca" hijau solid
- Pagination rounded di bawah
- Footer
```

### 4. Daftar Artikel — `/artikel`
```
Desain UI halaman daftar artikel BK.
Tema hijau-putih elegan.

Struktur:
- Navbar publik
- Header: judul "Artikel & Informasi BK" + search bar
- Featured article besar di atas (thumbnail besar, judul, ringkasan, tanggal)
- Grid card artikel di bawahnya (thumbnail 16:9 rounded-xl, kategori badge hijau muda, judul, tanggal, ikon jam baca)
- Sidebar kanan (desktop): kategori populer, artikel terkait
- Pagination
- Footer
```

### 5. Detail Artikel — `/artikel/{slug}`
```
Desain UI halaman detail artikel BK (single article page).
Tema hijau-putih elegan, fokus keterbacaan.

Struktur:
- Navbar publik
- Breadcrumb: Beranda / Artikel / Judul Artikel
- Header artikel: judul besar, meta info (penulis, tanggal, kategori badge hijau)
- Gambar cover artikel full-width rounded-xl
- Body artikel: layout kolom nyaman baca (max-width terbatas), heading dalam artikel pakai warna hijau tua
- Section "Artikel Terkait" di bawah: 3 card kecil
- Tombol share sederhana (opsional)
- Footer
```

### 6. FAQ — `/faq`
```
Desain UI halaman FAQ layanan BK.
Tema hijau-putih elegan.

Struktur:
- Navbar publik
- Header: judul "Pertanyaan Umum" + subheading singkat
- List accordion FAQ (10-15 item), tiap item: pertanyaan bold + ikon chevron hijau, klik expand menampilkan jawaban dengan animasi smooth
- Boleh dikelompokkan per kategori dengan tab pill hijau di atas accordion
- Section akhir: card CTA "Tidak menemukan jawaban? Hubungi Guru BK / mulai chat" dengan tombol hijau
- Footer
```

### 7. Login — `/login`
```
Desain UI halaman login untuk portal SAPA BK.
Tema hijau-putih, elegan, profesional, minimalis.

Struktur:
- Layout split-screen: kiri illustrasi/mascot + tagline sekolah dengan background hijau muda (#ECFDF5) atau gradient hijau, kanan form login di card putih rounded-2xl dengan shadow
- Logo sekolah di atas form
- Field: Email, Password (dengan toggle show/hide), checkbox "Ingat saya"
- Tombol "Masuk" hijau solid full-width rounded-full
- Link "Lupa password?" dan "Belum punya akun? Daftar" di bawah
- Mobile: form saja, illustrasi disembunyikan/di atas
```

### 8. Register — `/register`
```
Desain UI halaman registrasi siswa untuk portal SAPA BK.
Tema hijau-putih, elegan, konsisten dengan halaman login (split-screen).

Struktur:
- Kiri: illustrasi/mascot + copy singkat manfaat mendaftar, background hijau muda
- Kanan: form card putih rounded-2xl: Nama Lengkap, Email, Password, Konfirmasi Password, checkbox setuju syarat & ketentuan
- Tombol "Daftar" hijau solid full-width
- Link "Sudah punya akun? Masuk"
- Validasi error state ditandai border merah tipis + teks error kecil
```

---

## B. Halaman Siswa (setelah login)

> Untuk semua halaman siswa: gunakan **sidebar kiri** rounded, background putih, dengan menu: Dashboard, Chat, Riwayat, E-book, Tes, Profil, Logout. Item aktif berwarna hijau dengan background hijau muda. Topbar atas menampilkan nama siswa + avatar + notifikasi.

### 9. Dashboard Siswa — `/dashboard`
```
Desain UI dashboard siswa untuk portal BK sekolah "SAPA BK".
Tema hijau-putih elegan, layout sidebar + topbar.

Struktur:
- Sidebar kiri: menu Dashboard (aktif), Chat, Riwayat Konsultasi, E-book, Tes, Profil
- Topbar: sapaan "Halo, [Nama]" + avatar + ikon notifikasi
- Section ringkasan: 3-4 card statistik ringkas (Total Konsultasi, E-book Dibaca, Tes Diikuti, Sesi Terakhir) — card putih rounded-2xl dengan ikon lingkaran hijau muda
- Section "Percakapan Terakhir": list 2-3 item dengan preview pesan terakhir + tombol "Lanjutkan"
- Section "E-book Rekomendasi": card carousel horizontal
- Section "Tes Terbaru": card status tes (badge "Selesai"/"Belum") dengan tombol lihat hasil
- CTA banner hijau "Mulai konsultasi baru" mengambang atau di akhir
```

### 10. Full Chatbot Page — `/chat`
```
Desain UI halaman chatbot penuh untuk siswa (portal BK).
Tema hijau-putih elegan, layout mirip aplikasi chat modern (ChatGPT-like tapi hijau).

Struktur:
- Sidebar kiri sempit: daftar riwayat sesi percakapan (list judul auto-generate, sesi aktif highlight hijau muda), tombol "+ Percakapan Baru" hijau solid di atas
- Area chat utama: header kecil judul sesi, area bubble pesan (bubble user rounded-2xl background hijau muda align kanan, bubble assistant background putih dengan border align kiri + avatar mascot kecil)
- Loading indicator: 3 dot animasi di bubble assistant saat memproses
- Rekomendasi e-book muncul sebagai card kecil di dalam bubble assistant jika relevan
- Input area bawah: text field rounded-full, tombol kirim ikon panah hijau solid
- Empty state (belum ada percakapan): ilustrasi mascot + teks sapaan + beberapa quick-prompt pill hijau outline yang bisa diklik
```

### 11. Sesi Percakapan Spesifik — `/chat/{session_id}`
```
Desain UI halaman chat untuk melihat/melanjutkan satu sesi percakapan spesifik.
Sama persis dengan Full Chatbot Page (`/chat`), tapi area chat langsung terisi riwayat pesan sesi tersebut ter-scroll ke bawah, sesi terkait di sidebar dalam kondisi highlight aktif hijau. Tema hijau-putih elegan, bubble user hijau muda kanan, bubble assistant putih kiri, input field tetap aktif untuk melanjutkan chat.
```

### 12. Riwayat Konsultasi — `/riwayat`
```
Desain UI halaman riwayat konsultasi siswa (daftar semua sesi chat sebelumnya).
Tema hijau-putih elegan, layout sidebar + topbar seperti dashboard.

Struktur:
- Header halaman: judul "Riwayat Konsultasi" + search bar
- List/table card per sesi: judul sesi, tanggal, cuplikan pesan terakhir, badge jumlah pesan, tombol "Buka" hijau outline
- Empty state jika belum ada riwayat: ilustrasi + teks + tombol "Mulai Konsultasi"
- Pagination di bawah
```

### 13. E-book (Akses Siswa) — `/ebook/akses`
```
Desain UI halaman akses e-book untuk siswa yang sudah login.
Tema hijau-putih elegan, layout sidebar + topbar.

Struktur:
- Header: judul "E-book Saya" + search + filter kategori pill hijau
- Grid card e-book: cover, judul, deskripsi singkat, tombol ganda "Baca" (hijau solid) dan ikon "Unduh" (outline)
- Tab/section "Terakhir Dibaca" di atas grid (card horizontal scroll)
- Pagination
```

### 14. Kuesioner / Tes (list) — `/tes`
```
Desain UI halaman daftar kuesioner/tes untuk siswa.
Tema hijau-putih elegan, layout sidebar + topbar.

Struktur:
- Header: judul "Kuesioner & Tes"
- Grid/list card tes: judul tes, deskripsi singkat, badge status ("Belum Dikerjakan" abu, "Selesai" hijau solid), tombol "Kerjakan" atau "Lihat Hasil" tergantung status
- Empty state jika belum ada tes tersedia
```

### 15. Isi Tes — `/tes/{id}`
```
Desain UI halaman form pengisian kuesioner/tes untuk siswa.
Tema hijau-putih elegan, fokus, minim distraksi.

Struktur:
- Header: judul tes + progress bar horizontal hijau menunjukkan kemajuan pengisian
- Satu pertanyaan per section card putih rounded-2xl, pilihan jawaban berupa radio/checkbox card yang berubah hijau muda saat dipilih
- Navigasi bawah: tombol "Sebelumnya" outline, "Selanjutnya"/"Selesai" hijau solid
- Nomor soal & total soal ditampilkan kecil di pojok
```

### 16. Hasil Tes — `/tes/{id}/hasil`
```
Desain UI halaman hasil tes/kuesioner untuk siswa.
Tema hijau-putih elegan.

Struktur:
- Header: judul tes + tanggal pengerjaan
- Card ringkasan skor besar di tengah atas (angka skor besar warna hijau tua, deskripsi kategori hasil)
- Section detail/breakdown jawaban per pertanyaan (list, expandable)
- Section rekomendasi/catatan dari sistem atau Guru BK (card hijau muda dengan ikon)
- Tombol "Unduh Hasil (PDF)" outline hijau, "Kembali ke Daftar Tes"
```

### 17. Profil Siswa — `/profil`
```
Desain UI halaman profil siswa (edit profil & ganti password).
Tema hijau-putih elegan, layout sidebar + topbar.

Struktur:
- Card profil di atas: foto avatar bulat besar dengan tombol edit kecil hijau, nama, kelas, email
- Tab "Informasi Akun" / "Ganti Password"
- Form informasi akun: Nama, Email, No. HP, Kelas — tombol "Simpan Perubahan" hijau solid
- Form ganti password: Password Lama, Password Baru, Konfirmasi — tombol "Ubah Password" hijau solid
```

---

## C. Halaman Guru BK

> Untuk semua halaman Guru BK: gunakan **sidebar admin-style** kiri (bukan mascot/ilustrasi playful), warna tetap hijau-putih tapi lebih formal/dense — cocok untuk manajemen data. Sidebar menu: Dashboard, Data Siswa, Percakapan, E-book, Artikel, Knowledge Base, Tes, Evaluasi Chatbot, FAQ, Logout.

### 18. Dashboard Guru BK — `/bk/dashboard`
```
Desain UI dashboard untuk Guru BK di sistem SAPA BK.
Tema hijau-putih, profesional, dense-data, gaya admin panel modern (bukan playful).

Struktur:
- Sidebar kiri gelap/putih dengan aksen hijau untuk menu aktif: Dashboard, Data Siswa, Percakapan, E-book, Artikel, Knowledge Base, Tes, Evaluasi, FAQ
- Topbar: judul halaman + avatar guru + notifikasi
- Row card statistik (4 card): Total Siswa, Total Percakapan, E-book Aktif, Tes Aktif — angka besar hijau tua, ikon lingkaran hijau muda
- Chart sederhana: grafik jumlah percakapan per minggu (line/bar chart warna hijau)
- Table/list "Percakapan Terbaru" ringkas dengan tombol "Lihat Semua"
- Section "Perlu Ditinjau": list jawaban chatbot yang belum dievaluasi, badge kuning/merah
```

### 19. Data Siswa — `/bk/siswa`
```
Desain UI halaman data siswa untuk Guru BK.
Tema hijau-putih, gaya admin table.

Struktur:
- Sidebar + topbar sama seperti dashboard Guru BK
- Header: judul "Data Siswa" + search bar + tombol filter
- Table rapi: Nama, Email, Kelas, Status Akun (badge hijau "Aktif"/abu "Nonaktif"), Terakhir Aktif, kolom aksi (ikon lihat/detail)
- Pagination + jumlah total data di footer table
```

### 20. Riwayat Percakapan Semua Siswa — `/bk/percakapan`
```
Desain UI halaman riwayat percakapan semua siswa untuk Guru BK memantau chatbot.
Tema hijau-putih, gaya admin table.

Struktur:
- Sidebar + topbar
- Header: judul + search + filter tanggal/siswa
- Table: Nama Siswa, Judul Sesi, Jumlah Pesan, Tanggal Terakhir, badge status evaluasi (belum/sudah dievaluasi), tombol "Lihat Detail" hijau outline
- Pagination
```

### 21. Detail Percakapan — `/bk/percakapan/{id}`
```
Desain UI halaman detail satu percakapan siswa untuk ditinjau Guru BK.
Tema hijau-putih, formal.

Struktur:
- Sidebar + topbar
- Header: info siswa (nama, kelas) + tanggal sesi
- Area chat read-only: bubble user (hijau muda kanan) dan bubble assistant (putih kiri) ditampilkan berurutan
- Di tiap bubble assistant: tombol kecil rating "👍 Baik" / "👎 Kurang Tepat" + field catatan opsional (mengacu fitur evaluasi chatbot)
- Sidebar kanan (opsional): sumber dokumen & e-book yang direkomendasikan pada sesi ini
```

### 22. Manajemen E-book — `/bk/ebook`
```
Desain UI halaman manajemen e-book (CRUD) untuk Guru BK.
Tema hijau-putih, gaya admin panel.

Struktur:
- Sidebar + topbar
- Header: judul "Manajemen E-book" + tombol "+ Tambah E-book" hijau solid di kanan
- Table/grid: cover thumbnail kecil, judul, status (badge "Publik"/"Privat"), tanggal upload, kolom aksi (edit/hapus ikon)
- Modal/drawer "Tambah/Edit E-book": upload cover, upload file PDF, judul, deskripsi, toggle "Tersedia untuk publik"
```

### 23. Manajemen Artikel — `/bk/artikel`
```
Desain UI halaman manajemen artikel (CRUD) untuk Guru BK.
Tema hijau-putih, gaya admin panel.

Struktur:
- Sidebar + topbar
- Header: judul + tombol "+ Tulis Artikel" hijau solid
- Table: thumbnail, judul, status (badge "Published" hijau / "Draft" abu), tanggal, aksi edit/hapus
- Halaman/editor tambah artikel: field judul, upload thumbnail, rich text editor untuk konten, toggle publish, tombol "Simpan"
```

### 24. Knowledge Base — `/bk/knowledge-base`
```
Desain UI halaman manajemen knowledge base (upload dokumen untuk RAG) untuk Guru BK.
Tema hijau-putih, gaya admin panel, sedikit teknikal tapi tetap rapi.

Struktur:
- Sidebar + topbar
- Header: judul "Knowledge Base" + tombol "+ Upload Dokumen" hijau solid
- Area drag-and-drop upload file (border dashed hijau, ikon upload)
- Table dokumen: nama file, ukuran, status indexing (badge "Pending" kuning, "Indexed" hijau, "Failed" merah), tanggal upload, tanggal indexed, aksi hapus/re-index
```

### 25. Manajemen Tes — `/bk/tes`
```
Desain UI halaman manajemen kuesioner/tes (CRUD) untuk Guru BK.
Tema hijau-putih, gaya admin panel.

Struktur:
- Sidebar + topbar
- Header: judul "Manajemen Tes" + tombol "+ Buat Tes Baru" hijau solid
- Table: judul tes, jumlah soal, status aktif (toggle switch hijau), jumlah pengisi, aksi edit/lihat hasil/hapus
- Halaman/editor buat tes: judul, deskripsi, builder pertanyaan dinamis (tambah/hapus soal, tipe pilihan ganda/skala)
```

### 26. Hasil Tes Siswa — `/bk/tes/{id}/hasil`
```
Desain UI halaman rekap hasil tes per tes tertentu untuk Guru BK.
Tema hijau-putih, gaya admin table + summary chart.

Struktur:
- Sidebar + topbar
- Header: judul tes + statistik ringkas (jumlah pengisi, rata-rata skor) dalam card kecil hijau
- Chart distribusi skor (bar chart hijau)
- Table hasil per siswa: nama, tanggal isi, skor, kategori hasil, tombol "Lihat Detail"
```

### 27. Evaluasi Chatbot — `/bk/evaluasi`
```
Desain UI halaman evaluasi jawaban chatbot untuk Guru BK.
Tema hijau-putih, gaya admin panel/review queue.

Struktur:
- Sidebar + topbar
- Header: judul "Evaluasi Chatbot" + filter (belum dievaluasi/sudah, tanggal)
- List card: pertanyaan siswa, jawaban chatbot (truncated), rating saat ini (badge hijau/merah jika sudah dinilai), tombol rating cepat "👍"/"👎" + field catatan, tombol "Lihat Percakapan Lengkap"
- Pagination
```

### 28. Manajemen FAQ — `/bk/faq`
```
Desain UI halaman manajemen FAQ (CRUD) untuk Guru BK.
Tema hijau-putih, gaya admin panel.

Struktur:
- Sidebar + topbar
- Header: judul "Manajemen FAQ" + tombol "+ Tambah FAQ" hijau solid
- List item FAQ dengan drag-handle untuk urutan, pertanyaan, toggle aktif/nonaktif, aksi edit/hapus
- Modal tambah/edit: field Pertanyaan, Jawaban (textarea), toggle aktif
```

---

## D. Halaman Administrator

> Untuk semua halaman Admin: gaya paling formal/dense di antara semua role, sidebar admin dengan menu: Dashboard, Manajemen User, Konfigurasi Sistem, System Log, Laporan & Statistik. Tetap pakai warna hijau sebagai aksen utama di atas dasar putih/abu.

### 29. Dashboard Admin — `/admin/dashboard`
```
Desain UI dashboard administrator untuk sistem SAPA BK (overview seluruh sistem).
Tema hijau-putih, formal, gaya admin panel enterprise.

Struktur:
- Sidebar kiri: Dashboard, Manajemen User, Konfigurasi Sistem, System Log, Laporan & Statistik
- Topbar: judul + avatar admin
- Row card statistik utama (Total User per role, Total Percakapan, Total E-book/Artikel, Status API Gemini "Aktif" badge hijau)
- Chart penggunaan sistem (line chart hijau, mis. jumlah chat per hari)
- Section "Aktivitas Terbaru" (log ringkas) + Section "Status Layanan" (Laravel, Python AI Service, ChromaDB — masing-masing badge status hijau/merah)
```

### 30. Manajemen User — `/admin/users`
```
Desain UI halaman manajemen user (CRUD semua user) untuk Admin.
Tema hijau-putih, gaya admin table.

Struktur:
- Sidebar + topbar
- Header: judul "Manajemen User" + tombol "+ Tambah User" hijau solid + filter role (pill: Semua/Siswa/Guru BK/Admin)
- Table: nama, email, role (badge warna beda tiap role, hijau untuk admin), status aktif (toggle), tanggal daftar, aksi (lihat detail/hapus)
- Pagination
```

### 31. Detail User — `/admin/users/{id}`
```
Desain UI halaman detail & edit user untuk Admin.
Tema hijau-putih, formal.

Struktur:
- Sidebar + topbar
- Card profil user di atas: avatar, nama, role badge, status aktif toggle
- Form edit: Nama, Email, Role (dropdown), Status Aktif — tombol "Simpan Perubahan" hijau solid
- Section aktivitas user (opsional): riwayat login/aktivitas terakhir dalam list ringkas
- Tombol destructive "Nonaktifkan/Hapus User" outline merah di area terpisah
```

### 32. Konfigurasi Sistem — `/admin/konfigurasi`
```
Desain UI halaman konfigurasi sistem (LLM & Vector DB) untuk Admin.
Tema hijau-putih, gaya settings page formal.

Struktur:
- Sidebar + topbar
- Layout tab/section: "Konfigurasi LLM" dan "Konfigurasi Vector DB"
- Form Konfigurasi LLM: field API Key (masked/password style), pilihan Model (dropdown), slider Temperature, tombol "Simpan & Test Koneksi" hijau solid, indikator status koneksi (badge hijau "Terhubung"/merah "Gagal")
- Form Konfigurasi Vector DB: field Path/Collection ChromaDB, tombol simpan
- Semua form dalam card putih rounded-2xl terpisah per section
```

### 33. System Log — `/admin/log`
```
Desain UI halaman system log untuk Admin.
Tema hijau-putih, gaya admin table/console.

Struktur:
- Sidebar + topbar
- Header: judul "System Log" + filter level (Info/Warning/Error, badge warna) + filter tanggal + search
- Table/list log: timestamp, level (badge warna: hijau info, kuning warning, merah error), pesan log, sumber (Laravel/Python Service)
- Auto-refresh indicator kecil di pojok atas
- Pagination / infinite scroll
```

### 34. Laporan & Statistik — `/admin/laporan`
```
Desain UI halaman laporan & statistik penggunaan sistem untuk Admin.
Tema hijau-putih, gaya dashboard analytics formal.

Struktur:
- Sidebar + topbar
- Filter rentang tanggal di atas (date range picker rounded)
- Grid card ringkasan (Total Percakapan, User Aktif, E-book Terunduh, Tes Diselesaikan) dengan tren naik/turun (panah hijau/merah kecil)
- Beberapa chart: line chart tren percakapan harian, bar chart penggunaan per role, pie chart topik pertanyaan terbanyak (semua chart dominan hijau dengan variasi shade)
- Tombol "Unduh Laporan (PDF/Excel)" hijau outline di pojok kanan atas
```

---

*Dokumen ini dibuat berdasarkan struktur halaman & fitur pada SRS SAPA BK v1.0.0 (10 Agustus 2026), dan referensi visual navbar/warna dari situs SMAN 4 Jember.*
