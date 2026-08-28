# Software Requirements Specification (SRS)
## SAPA BK — Sistem Asisten Pendamping Akademik & BK
**SMA Negeri 4 Jember**

---

| Atribut       | Detail                                      |
|---------------|---------------------------------------------|
| Versi         | 1.0.0                                       |
| Tanggal       | 10 Agustus 2026                             |
| Status        | Draft                                       |
| Dibuat oleh   | Tim Pengembang                              |

---

## Daftar Isi

1. [Pendahuluan](#1-pendahuluan)
2. [Deskripsi Umum Sistem](#2-deskripsi-umum-sistem)
3. [Aktor & Role](#3-aktor--role)
4. [Fitur & Kebutuhan Fungsional](#4-fitur--kebutuhan-fungsional)
5. [Kebutuhan Non-Fungsional](#5-kebutuhan-non-fungsional)
6. [Arsitektur Sistem](#6-arsitektur-sistem)
7. [Struktur Halaman & Routing](#7-struktur-halaman--routing)
8. [Database Overview](#8-database-overview)
9. [Integrasi AI (RAG Pipeline)](#9-integrasi-ai-rag-pipeline)
10. [Batasan & Asumsi](#10-batasan--asumsi)
11. [Tahapan Pengembangan](#11-tahapan-pengembangan)

---

## 1. Pendahuluan

### 1.1 Tujuan Dokumen

Dokumen ini mendefinisikan kebutuhan perangkat lunak untuk sistem **SAPA BK**, sebuah portal layanan Bimbingan dan Konseling (BK) digital berbasis web untuk SMA Negeri 4 Jember. Dokumen ini menjadi acuan utama bagi pengembang agar proses development tidak keluar dari jalur yang telah ditetapkan.

### 1.2 Ruang Lingkup

SAPA BK adalah aplikasi web yang menyediakan:

- Portal informasi layanan BK secara publik
- Chatbot asisten BK berbasis AI (RAG) untuk siswa
- Akses e-book dan artikel BK
- Dashboard manajemen untuk Guru BK dan Administrator

### 1.3 Definisi & Singkatan

| Istilah     | Keterangan                                                    |
|-------------|---------------------------------------------------------------|
| BK          | Bimbingan dan Konseling                                       |
| RAG         | Retrieval-Augmented Generation                                |
| LLM         | Large Language Model                                          |
| Vector DB   | Database vektor untuk penyimpanan embedding dokumen           |
| RBAC        | Role-Based Access Control                                     |
| Blade       | Template engine bawaan Laravel                                |
| ChromaDB    | Vector database yang digunakan untuk menyimpan embedding      |
| Gemini      | Model LLM dari Google (Gemini 2.0 Flash)                      |

### 1.4 Teknologi yang Digunakan

| Komponen        | Teknologi                        |
|-----------------|----------------------------------|
| Backend & Web   | Laravel (PHP)                    |
| Frontend        | Blade Template Engine            |
| AI Pipeline     | Python (LangChain, ChromaDB)     |
| LLM             | Google Gemini 2.0 Flash          |
| Vector Database | ChromaDB                         |
| Database        | MySQL                            |

---

## 2. Deskripsi Umum Sistem

### 2.1 Gambaran Sistem

SAPA BK adalah portal layanan BK digital yang terdiri dari dua lapisan utama:

**Lapisan 1 — Aplikasi Web (Laravel)**
Mengelola antarmuka pengguna, autentikasi, routing, manajemen konten, dan komunikasi antara pengguna dengan backend AI.

**Lapisan 2 — AI Pipeline (Python)**
Mengelola proses RAG: menerima pertanyaan dari Laravel, melakukan retrieval dari ChromaDB, dan menghasilkan jawaban melalui Gemini LLM.

### 2.2 Konteks Penggunaan

```
Pengguna (Browser)
       │
       ▼
  Laravel App
  ├── Landing Page (publik)
  ├── Chatbot UI (siswa)
  ├── Dashboard Siswa
  └── Dashboard Admin/Guru BK
       │
       ▼ (HTTP Request)
  Python API (RAG)
  ├── Retriever → ChromaDB
  └── Generator → Gemini LLM
```

> **Catatan untuk developer:** Pada tahap awal pengembangan, chatbot hanya berupa UI (dummy response). Koneksi ke RAG Pipeline dilakukan pada tahap akhir.

---

## 3. Aktor & Role

### 3.1 Daftar Aktor

| Role          | Deskripsi                                                                 |
|---------------|---------------------------------------------------------------------------|
| **Tamu**      | Pengunjung umum yang belum login. Dapat mengakses landing page dan chatbot widget (terbatas). |
| **Siswa**     | Pengguna terdaftar yang telah login. Dapat menggunakan seluruh fitur chatbot dan e-book. |
| **Guru BK**   | Staf BK sekolah. Mengelola konten, memantau percakapan, dan mengevaluasi chatbot. |
| **Administrator** | Superuser sistem. Mengelola seluruh konfigurasi, user, dan sistem.    |

### 3.2 Hak Akses per Role

| Fitur                        | Tamu | Siswa | Guru BK | Admin |
|------------------------------|:----:|:-----:|:-------:|:-----:|
| Landing page                 | ✅   | ✅    | ✅      | ✅    |
| Chatbot widget (terbatas)    | ✅   | ✅    | ✅      | ✅    |
| Full chatbot page            | ❌   | ✅    | ✅      | ✅    |
| Riwayat percakapan sendiri   | ❌   | ✅    | ✅      | ✅    |
| E-book & artikel             | ✅   | ✅    | ✅      | ✅    |
| Dashboard siswa              | ❌   | ✅    | ❌      | ❌    |
| Kuesioner / tes              | ❌   | ✅    | ❌      | ❌    |
| Dashboard Guru BK            | ❌   | ❌    | ✅      | ✅    |
| Lihat riwayat chat semua siswa | ❌ | ❌    | ✅      | ✅    |
| Upload e-book & dokumen      | ❌   | ❌    | ✅      | ✅    |
| Manajemen knowledge base     | ❌   | ❌    | ✅      | ✅    |
| Evaluasi chatbot             | ❌   | ❌    | ✅      | ✅    |
| Manajemen user               | ❌   | ❌    | ❌      | ✅    |
| Konfigurasi sistem & API     | ❌   | ❌    | ❌      | ✅    |
| System log                   | ❌   | ❌    | ❌      | ✅    |

---

## 4. Fitur & Kebutuhan Fungsional

### 4.1 Autentikasi & Manajemen Akun

| Kode  | Fitur                            | Aktor            | Deskripsi                                                                 |
|-------|----------------------------------|------------------|---------------------------------------------------------------------------|
| F-01  | Login                            | Semua role       | Login menggunakan email dan password.                                     |
| F-02  | Logout                           | Semua role       | Keluar dari sesi.                                                         |
| F-03  | Register siswa                   | Tamu             | Siswa mendaftarkan akun baru.                                             |
| F-04  | Manajemen akun sendiri           | Semua role       | Edit profil, ganti password.                                              |
| F-05  | Reset password                   | Semua role       | Reset password via email.                                                 |
| F-06  | Buat akun Guru BK                | Administrator    | Admin membuat akun Guru BK secara manual.                                 |

### 4.2 Landing Page (Publik)

| Kode  | Fitur                            | Aktor            | Deskripsi                                                                 |
|-------|----------------------------------|------------------|---------------------------------------------------------------------------|
| F-10  | Hero section                     | Tamu, Siswa      | Tampilan utama dengan CTA menuju chatbot.                                 |
| F-11  | Informasi layanan BK             | Tamu, Siswa      | Daftar layanan yang tersedia di portal.                                   |
| F-12  | Daftar e-book (preview)          | Tamu, Siswa      | Tampil sebagian e-book publik.                                            |
| F-13  | Artikel / informasi BK           | Tamu, Siswa      | Konten artikel yang dapat diakses tanpa login.                            |
| F-14  | FAQ                              | Tamu, Siswa      | Pertanyaan umum seputar layanan BK.                                       |
| F-15  | Chatbot widget                   | Tamu, Siswa      | Chat widget muncul di sudut kanan bawah. Tamu hanya dapat bertanya terbatas. |
| F-16  | Navbar publik                    | Tamu, Siswa      | Navigasi ke Beranda, Tentang BK, E-book, Artikel, Login.                 |

### 4.3 Chatbot

| Kode  | Fitur                            | Aktor            | Deskripsi                                                                 |
|-------|----------------------------------|------------------|---------------------------------------------------------------------------|
| F-20  | Chatbot widget                   | Tamu, Siswa      | Popup chat di landing page, bisa dibuka/tutup.                            |
| F-21  | Full chatbot page `/chat`        | Siswa            | Halaman chatbot penuh dengan riwayat percakapan.                          |
| F-22  | Kirim pesan                      | Siswa            | Input teks dan tombol kirim.                                              |
| F-23  | Tampil jawaban chatbot           | Siswa            | Bubble pesan jawaban dari chatbot (loading → jawaban).                    |
| F-24  | Loading indicator                | Siswa            | Animasi loading saat chatbot sedang memproses.                            |
| F-25  | Riwayat percakapan               | Siswa            | Percakapan tersimpan dan bisa dilihat kembali.                            |
| F-26  | Rekomendasi e-book dalam chat    | Siswa            | Chatbot dapat merekomendasikan e-book relevan sebagai bagian respons.     |
| F-27  | Empty state                      | Siswa            | Tampilan awal ketika belum ada percakapan.                                |
| F-28  | Sesi percakapan baru             | Siswa            | Tombol untuk memulai percakapan baru.                                     |
| F-29  | Request Live Chat Guru BK (PRD 4.2) | Siswa         | Siswa dapat meminta beralih dari Chatbot AI ke Live Chat Guru BK pada **Jam Operasional 08:00–15:00 WIB**. Identitas siswa (Nama, NISN, Kelas) **tetap ditampilkan** agar Guru BK dapat menindaklanjuti rekam medis/konseling. |
| F-29b | Indikator Jam Operasional & Status Offline | Siswa | Di luar jam 08:00–15:00 WIB atau saat Guru BK offline, sistem memberikan pemberitahuan dan menyarankan pesan tertunda atau konsultasi AI. |

> **Catatan developer:** F-22 hingga F-28 pada tahap awal menggunakan dummy response. Integrasi ke RAG pipeline dikerjakan pada tahap akhir (lihat bagian 11).

### 4.4 Dashboard Siswa

| Kode  | Fitur                            | Aktor   | Deskripsi                                                                 |
|-------|----------------------------------|---------|---------------------------------------------------------------------------|
| F-30  | Dashboard siswa                  | Siswa   | Ringkasan aktivitas: riwayat chat, e-book terakhir, tes terakhir.        |
| F-31  | Riwayat konsultasi               | Siswa   | Daftar sesi percakapan sebelumnya.                                        |
| F-32  | Akses e-book                     | Siswa   | Baca dan unduh e-book yang tersedia.                                      |
| F-33  | Kuesioner / tes                  | Siswa   | Mengisi tes psikologi/akademik yang disiapkan Guru BK.                   |
| F-34  | Hasil tes                        | Siswa   | Melihat hasil tes yang telah diisi.                                       |

### 4.5 Dashboard Guru BK

| Kode  | Fitur                            | Aktor     | Deskripsi                                                                 |
|-------|----------------------------------|-----------|---------------------------------------------------------------------------|
| F-40  | Dashboard Guru BK                | Guru BK   | Ringkasan: total siswa, total percakapan, e-book aktif.                  |
| F-41  | Daftar siswa                     | Guru BK   | Lihat data siswa terdaftar.                                               |
| F-42  | Riwayat percakapan semua siswa   | Guru BK   | Pantau seluruh percakapan chatbot.                                        |
| F-42b | Live Chat Konseling (PRD 4.2)    | Guru BK   | Halaman antrean dan balasan live chat siswa secara real-time. Identitas siswa ditampilkan lengkap. |
| F-43  | Upload e-book                    | Guru BK   | Tambah, edit, hapus e-book.                                               |
| F-44  | Manajemen artikel / informasi    | Guru BK   | Tambah, edit, hapus artikel BK.                                           |
| F-45  | Manajemen knowledge base         | Guru BK   | Upload dokumen sumber (PDF, dsb.) untuk RAG pipeline.                    |
| F-46  | Buat kuesioner / tes             | Guru BK   | Buat dan kelola tes untuk siswa.                                          |
| F-47  | Lihat hasil tes siswa            | Guru BK   | Pantau hasil pengisian tes per siswa.                                     |
| F-48  | Evaluasi chatbot                 | Guru BK   | Tandai jawaban chatbot sebagai baik/kurang tepat.                         |
| F-49  | FAQ management                   | Guru BK   | Tambah, edit, hapus FAQ di landing page.                                  |

### 4.6 Dashboard Administrator

| Kode  | Fitur                            | Aktor  | Deskripsi                                                                 |
|-------|----------------------------------|--------|---------------------------------------------------------------------------|
| F-50  | Dashboard Admin                  | Admin  | Overview seluruh sistem.                                                  |
| F-51  | Manajemen user                   | Admin  | CRUD akun siswa, Guru BK, dan admin lain.                                 |
| F-52  | Konfigurasi LLM                  | Admin  | Set API key Gemini, model yang digunakan, temperature, dsb.              |
| F-53  | Konfigurasi Vector DB            | Admin  | Pengaturan ChromaDB (path, collection, dsb.).                             |
| F-54  | System log                       | Admin  | Log aktivitas sistem dan error.                                           |
| F-55  | Laporan & statistik              | Admin  | Laporan penggunaan sistem.                                                |
| F-56  | Akses semua fitur Guru BK        | Admin  | Admin dapat melakukan semua yang bisa dilakukan Guru BK.                 |

---

## 5. Kebutuhan Non-Fungsional

| Kode   | Kategori        | Kebutuhan                                                                              |
|--------|-----------------|----------------------------------------------------------------------------------------|
| NF-01  | Keamanan        | Autentikasi menggunakan session Laravel + CSRF protection.                             |
| NF-02  | Keamanan        | Password disimpan menggunakan bcrypt.                                                  |
| NF-03  | Keamanan        | Akses halaman dikontrol menggunakan middleware RBAC.                                   |
| NF-04  | Keamanan        | API key LLM tidak boleh ter-expose di frontend.                                        |
| NF-05  | Performa        | Halaman landing page harus load dalam < 3 detik pada koneksi normal.                  |
| NF-06  | Performa        | Response chatbot ditampilkan dalam < 10 detik (termasuk proses RAG).                  |
| NF-07  | Usabilitas      | UI responsif (mobile-friendly).                                                        |
| NF-08  | Usabilitas      | Bahasa antarmuka: Bahasa Indonesia.                                                    |
| NF-09  | Maintainability | Kode mengikuti konvensi Laravel (MVC, service layer untuk AI communication).           |
| NF-10  | Maintainability | Setiap komunikasi ke Python AI API dilakukan melalui satu service class terpusat.      |
| NF-11  | Skalabilitas    | RAG pipeline Python berjalan sebagai service terpisah yang dapat di-scale mandiri.     |

---

## 6. Arsitektur Sistem

### 6.1 Diagram Komponen

```
┌────────────────────────────────────────────────────────┐
│                    BROWSER (User)                       │
└────────────────────────┬───────────────────────────────┘
                         │ HTTP
┌────────────────────────▼───────────────────────────────┐
│               LARAVEL APPLICATION                       │
│                                                         │
│  ┌──────────┐  ┌──────────┐  ┌───────────────────────┐ │
│  │  Routing │  │Controller│  │        Blade View      │ │
│  └──────────┘  └──────────┘  └───────────────────────┘ │
│                     │                                   │
│              ┌──────▼──────┐                            │
│              │   Service   │                            │
│              │   Layer     │                            │
│              └──────┬──────┘                            │
│                     │                                   │
│         ┌───────────┼──────────────┐                   │
│         │           │              │                   │
│    ┌────▼────┐ ┌────▼────┐  ┌─────▼────┐              │
│    │  MySQL  │ │  File   │  │ AI Client│              │
│    │   DB    │ │ Storage │  │ (HTTP)   │              │
│    └─────────┘ └─────────┘  └────┬─────┘              │
└─────────────────────────────────┼─────────────────────┘
                                   │ HTTP (Internal)
┌──────────────────────────────────▼─────────────────────┐
│               PYTHON AI SERVICE                         │
│                                                         │
│  ┌──────────┐    ┌──────────┐    ┌──────────────────┐  │
│  │   API    │───▶│Retriever │───▶│    ChromaDB      │  │
│  │(FastAPI) │    └──────────┘    └──────────────────┘  │
│  │          │───▶┌──────────┐                          │
│  └──────────┘    │Generator │───▶ Gemini LLM (Google)  │
│                  └──────────┘                          │
└────────────────────────────────────────────────────────┘
```

### 6.2 Catatan Arsitektur

- Laravel **tidak langsung** memanggil Gemini atau ChromaDB. Semua request AI diteruskan ke Python service.
- Python service berjalan di port terpisah (misal: `http://localhost:8000`).
- Komunikasi Laravel ↔ Python menggunakan HTTP REST (JSON).
- Pada tahap awal development, Python service dapat di-mock dengan response statis.

---

## 7. Struktur Halaman & Routing

### 7.1 Halaman Publik (tanpa login)

| URL              | Halaman              | Komponen Utama                                               |
|------------------|----------------------|--------------------------------------------------------------|
| `/`              | Landing Page         | Hero, Layanan, E-book preview, Artikel, FAQ, Chat widget    |
| `/tentang`       | Tentang BK           | Penjelasan layanan BK sekolah                               |
| `/ebook`         | Daftar E-book        | List e-book publik                                          |
| `/artikel`       | Daftar Artikel       | List artikel BK                                             |
| `/artikel/{slug}`| Detail Artikel       | Konten artikel lengkap                                      |
| `/faq`           | FAQ                  | Daftar FAQ                                                  |
| `/login`         | Login                | Form login                                                  |
| `/register`      | Register             | Form registrasi siswa                                       |

### 7.2 Halaman Siswa (setelah login)

| URL                    | Halaman                  | Deskripsi                                         |
|------------------------|--------------------------|---------------------------------------------------|
| `/dashboard`           | Dashboard Siswa          | Ringkasan aktivitas                               |
| `/chat`                | Full Chatbot Page        | Halaman chatbot lengkap                           |
| `/chat/{session_id}`   | Sesi Percakapan          | Percakapan spesifik                               |
| `/riwayat`             | Riwayat Konsultasi       | Semua sesi percakapan                             |
| `/ebook/akses`         | E-book (siswa)           | Baca / unduh e-book                               |
| `/tes`                 | Kuesioner / Tes          | Daftar tes yang tersedia                          |
| `/tes/{id}`            | Isi Tes                  | Form pengisian tes                                |
| `/tes/{id}/hasil`      | Hasil Tes                | Tampil hasil tes                                  |
| `/profil`              | Profil Siswa             | Edit profil dan password                          |

### 7.3 Halaman Guru BK

| URL                           | Halaman                     | Deskripsi                                      |
|-------------------------------|-----------------------------|------------------------------------------------|
| `/bk/dashboard`               | Dashboard Guru BK           | Overview aktivitas                             |
| `/bk/siswa`                   | Data Siswa                  | List siswa terdaftar                           |
| `/bk/percakapan`              | Riwayat Percakapan          | Semua percakapan siswa                         |
| `/bk/percakapan/{id}`         | Detail Percakapan           | Isi percakapan                                 |
| `/bk/live-chat`               | Live Chat Konseling         | Portal antrean & percakapan real-time Guru BK  |
| `/bk/ebook`                   | Manajemen E-book            | CRUD e-book                                    |
| `/bk/artikel`                 | Manajemen Artikel           | CRUD artikel                                   |
| `/bk/knowledge-base`          | Knowledge Base              | Upload dokumen RAG                             |
| `/bk/tes`                     | Manajemen Tes               | CRUD kuesioner                                 |
| `/bk/tes/{id}/hasil`          | Hasil Tes Siswa             | Rekap hasil per tes                            |
| `/bk/evaluasi`                | Evaluasi Chatbot            | Review dan rating jawaban chatbot              |
| `/bk/faq`                     | Manajemen FAQ               | CRUD FAQ                                       |

### 7.4 Halaman Administrator

| URL                        | Halaman                    | Deskripsi                                         |
|----------------------------|----------------------------|---------------------------------------------------|
| `/admin/dashboard`         | Dashboard Admin            | Overview sistem                                   |
| `/admin/users`             | Manajemen User             | CRUD semua user                                   |
| `/admin/users/{id}`        | Detail User                | Detail dan edit user                              |
| `/admin/konfigurasi`       | Konfigurasi Sistem         | Setting LLM, Vector DB                            |
| `/admin/log`               | System Log                 | Log aktivitas dan error                           |
| `/admin/laporan`           | Laporan & Statistik        | Laporan penggunaan                                |

### 7.5 API Routes (Internal)

| Method | URL                          | Deskripsi                                        |
|--------|------------------------------|--------------------------------------------------|
| POST   | `/api/chat`                  | Kirim pesan ke chatbot, dapatkan respons         |
| GET    | `/api/chat/history/{id}`     | Ambil riwayat sesi tertentu                      |
| POST   | `/api/chat/session`          | Buat sesi percakapan baru                        |

---

## 8. Database Overview

### 8.1 Tabel Utama

#### `users`
| Kolom         | Tipe         | Keterangan                          |
|---------------|--------------|-------------------------------------|
| id            | bigint PK    |                                     |
| name          | varchar      | Nama lengkap                        |
| email         | varchar      | Unique                              |
| password      | varchar      | Bcrypt                              |
| role          | enum         | `siswa`, `guru_bk`, `admin`         |
| is_active     | boolean      | Status akun                         |
| created_at    | timestamp    |                                     |
| updated_at    | timestamp    |                                     |

#### `chat_sessions`
| Kolom         | Tipe         | Keterangan                          |
|---------------|--------------|-------------------------------------|
| id            | bigint PK    |                                     |
| user_id       | bigint FK    | → users.id                          |
| title         | varchar      | Judul sesi (auto-generate)          |
| created_at    | timestamp    |                                     |
| updated_at    | timestamp    |                                     |

#### `chat_messages`
| Kolom         | Tipe         | Keterangan                                   |
|---------------|--------------|----------------------------------------------|
| id            | bigint PK    |                                              |
| session_id    | bigint FK    | → chat_sessions.id                           |
| role          | enum         | `user`, `assistant`                          |
| content       | text         | Isi pesan                                    |
| metadata      | json         | Opsional: sumber dokumen, e-book rekomendasi |
| created_at    | timestamp    |                                              |

#### `ebooks`
| Kolom         | Tipe         | Keterangan                          |
|---------------|--------------|-------------------------------------|
| id            | bigint PK    |                                     |
| title         | varchar      |                                     |
| description   | text         |                                     |
| file_path     | varchar      | Path file PDF                       |
| cover_path    | varchar      | Path gambar cover                   |
| is_public     | boolean      | Tersedia tanpa login                |
| uploaded_by   | bigint FK    | → users.id                          |
| created_at    | timestamp    |                                     |
| updated_at    | timestamp    |                                     |

#### `articles`
| Kolom         | Tipe         | Keterangan                          |
|---------------|--------------|-------------------------------------|
| id            | bigint PK    |                                     |
| title         | varchar      |                                     |
| slug          | varchar      | Unique, untuk URL                   |
| content       | longtext     |                                     |
| thumbnail     | varchar      |                                     |
| is_published  | boolean      |                                     |
| author_id     | bigint FK    | → users.id                          |
| created_at    | timestamp    |                                     |
| updated_at    | timestamp    |                                     |

#### `knowledge_documents`
| Kolom         | Tipe         | Keterangan                                    |
|---------------|--------------|-----------------------------------------------|
| id            | bigint PK    |                                               |
| title         | varchar      |                                               |
| file_path     | varchar      |                                               |
| status        | enum         | `pending`, `indexed`, `failed`                |
| indexed_at    | timestamp    | Waktu selesai diindeks ke ChromaDB            |
| uploaded_by   | bigint FK    | → users.id                                    |
| created_at    | timestamp    |                                               |

#### `questionnaires`
| Kolom         | Tipe         | Keterangan                          |
|---------------|--------------|-------------------------------------|
| id            | bigint PK    |                                     |
| title         | varchar      |                                     |
| description   | text         |                                     |
| created_by    | bigint FK    | → users.id                          |
| is_active     | boolean      |                                     |
| created_at    | timestamp    |                                     |

#### `questionnaire_results`
| Kolom            | Tipe      | Keterangan                     |
|------------------|-----------|--------------------------------|
| id               | bigint PK |                                |
| questionnaire_id | bigint FK | → questionnaires.id            |
| user_id          | bigint FK | → users.id                     |
| answers          | json      | Jawaban lengkap                |
| score            | int       | Skor akhir (jika ada)          |
| created_at       | timestamp |                                |

#### `chat_evaluations`
| Kolom         | Tipe         | Keterangan                                       |
|---------------|--------------|--------------------------------------------------|
| id            | bigint PK    |                                                  |
| message_id    | bigint FK    | → chat_messages.id (pesan dari assistant)        |
| evaluated_by  | bigint FK    | → users.id (Guru BK)                             |
| rating        | enum         | `good`, `bad`                                    |
| note          | text         | Catatan evaluasi opsional                        |
| created_at    | timestamp    |                                                  |

#### `faqs`
| Kolom         | Tipe         | Keterangan                          |
|---------------|--------------|-------------------------------------|
| id            | bigint PK    |                                     |
| question      | text         |                                     |
| answer        | text         |                                     |
| order         | int          | Urutan tampil                       |
| is_active     | boolean      |                                     |
| created_at    | timestamp    |                                     |

---

## 9. Integrasi AI (RAG Pipeline)

### 9.1 Alur Kerja RAG

```
Siswa kirim pesan
       │
       ▼
Laravel menerima request
       │
       ▼
ChatController → ChatService
       │
       ├── Simpan pesan user ke DB
       │
       └── Kirim POST ke Python AI Service
               │
               ▼
        Python FastAPI
               │
        ┌──────┴──────┐
        │  Retriever  │──▶ ChromaDB (similarity search)
        └──────┬──────┘         │
               │           Dokumen relevan
               ▼
        ┌──────┴──────┐
        │  Generator  │──▶ Gemini LLM
        └──────┬──────┘
               │
        Jawaban + metadata sumber
               │
               ▼
        Return JSON ke Laravel
               │
               ▼
Laravel simpan jawaban ke DB
       │
       ▼
Return response ke browser
```

### 9.2 Format Request Laravel → Python

```json
{
  "session_id": "uuid",
  "message": "Bagaimana cara mengatasi kesulitan belajar?",
  "user_id": 1
}
```

### 9.3 Format Response Python → Laravel

```json
{
  "answer": "Untuk mengatasi kesulitan belajar, ...",
  "sources": [
    {
      "document": "panduan-belajar.pdf",
      "page": 5
    }
  ],
  "recommended_ebooks": [
    {
      "id": 3,
      "title": "Strategi Belajar Efektif"
    }
  ]
}
```

### 9.4 Dummy Response (Tahap Awal)

Sebelum Python service siap, Laravel mengembalikan response statis:

```json
{
  "answer": "Halo! Saya masih dalam tahap pengembangan. Silakan hubungi Guru BK secara langsung.",
  "sources": [],
  "recommended_ebooks": []
}
```

---

## 10. Batasan & Asumsi

| No | Batasan / Asumsi                                                                          |
|----|-------------------------------------------------------------------------------------------|
| 1  | Sistem hanya digunakan oleh civitas SMA Negeri 4 Jember.                                 |
| 2  | Registrasi siswa dilakukan mandiri; akun Guru BK dibuat oleh Administrator.               |
| 3  | Chatbot hanya menjawab pertanyaan seputar BK dan akademik berdasarkan knowledge base.    |
| 4  | Dokumen knowledge base diupload secara manual oleh Guru BK (bukan auto-sync).            |
| 5  | Sistem membutuhkan koneksi internet untuk memanggil Gemini API.                           |
| 6  | File e-book hanya mendukung format PDF.                                                   |
| 7  | Bahasa antarmuka dan interaksi chatbot: Bahasa Indonesia.                                 |
| 8  | Python AI service berjalan di server yang sama dengan Laravel (dapat dikonfigurasi).      |

---

## 11. Tahapan Pengembangan

Pengembangan dilakukan bertahap agar tetap terstruktur dan tidak overscope.

### Tahap 1 — Fondasi Laravel

- [ ] Setup project Laravel
- [ ] Konfigurasi database MySQL
- [ ] Autentikasi (login, register, logout)
- [ ] RBAC middleware (siswa / guru_bk / admin)
- [ ] Layout dasar (navbar, sidebar admin)
- [ ] Routing struktur lengkap

### Tahap 2 — Landing Page & Konten Publik

- [ ] Hero section
- [ ] Informasi layanan BK
- [ ] Daftar e-book (preview publik)
- [ ] Artikel BK
- [ ] FAQ
- [ ] Halaman Tentang BK

### Tahap 3 — Chatbot Frontend (UI Only)

- [ ] Chat widget di landing page
- [ ] Full chatbot page `/chat`
- [ ] Bubble pesan user & assistant
- [ ] Loading indicator
- [ ] Riwayat percakapan (UI)
- [ ] Empty state
- [ ] Tombol sesi baru
- [ ] **Dummy response** dari Laravel (belum ke AI)

### Tahap 4 — Dashboard Siswa

- [ ] Dashboard siswa
- [ ] Riwayat konsultasi
- [ ] Akses e-book lengkap
- [ ] Kuesioner & hasil tes
- [ ] Profil siswa

### Tahap 5 — Dashboard Guru BK & Admin

- [ ] Dashboard Guru BK
- [ ] Manajemen siswa, e-book, artikel, FAQ
- [ ] Manajemen knowledge base (upload dokumen)
- [ ] Evaluasi chatbot
- [ ] Dashboard Admin
- [ ] Manajemen user
- [ ] Konfigurasi sistem

### Tahap 6 — Integrasi AI (RAG Pipeline)

- [ ] Setup Python FastAPI service
- [ ] Integrasi LangChain + ChromaDB
- [ ] Integrasi Gemini LLM
- [ ] Indexing dokumen knowledge base
- [ ] Koneksi Laravel → Python service
- [ ] Ganti dummy response dengan response AI nyata
- [ ] Testing end-to-end

---

*Dokumen ini bersifat living document — dapat diperbarui seiring perkembangan sistem.*
