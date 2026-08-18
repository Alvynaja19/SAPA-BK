-- =====================================================================
-- DATABASE: chatbot_bk_sman4jember
-- Pengembangan Chatbot LLM dengan RAG untuk Konseling dan Rekomendasi
-- Belajar SMAN 4 Jember
-- Mohammad Alvyn Akbar - E41232243
-- Kompatibel dengan MySQL 8.x / Laragon, siap dipakai via Laravel migration
-- atau langsung di-import lewat phpMyAdmin/HeidiSQL.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS chatbot_bk_sman4jember
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE chatbot_bk_sman4jember;

SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================================
-- 1. AUTENTIKASI & PROFIL PENGGUNA
-- =====================================================================

-- Data akun untuk ketiga aktor sistem: siswa, guru BK, admin
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('siswa','guru_bk','admin') NOT NULL DEFAULT 'siswa',
  phone VARCHAR(20) NULL,
  avatar_path VARCHAR(255) NULL,
  email_verified_at TIMESTAMP NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Data tambahan khusus siswa (dipisah dari users agar tidak ada kolom
-- kosong pada akun guru_bk/admin)
CREATE TABLE student_profiles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL UNIQUE,
  nisn VARCHAR(20) NULL,
  kelas VARCHAR(20) NULL,
  jurusan VARCHAR(50) NULL,
  tahun_masuk YEAR NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_student_profiles_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Data tambahan khusus guru BK
CREATE TABLE counselor_profiles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL UNIQUE,
  nip VARCHAR(30) NULL,
  spesialisasi VARCHAR(100) NULL COMMENT 'mis. akademik, karier, psikososial',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_counselor_profiles_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 2. CHATBOT & PIPELINE RAG
-- =====================================================================

-- Satu sesi percakapan siswa dengan chatbot
CREATE TABLE conversations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(150) NULL,
  category ENUM('akademik','psikologis_emosional','sosial','karier','umum')
    NOT NULL DEFAULT 'umum'
    COMMENT 'empat dimensi BK sesuai BAB 1/2 laporan',
  status ENUM('active','closed') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_conversations_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_conversations_user (user_id)
) ENGINE=InnoDB;

-- Setiap pesan di dalam sebuah percakapan (dari siswa maupun bot)
CREATE TABLE messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  conversation_id BIGINT UNSIGNED NOT NULL,
  sender_type ENUM('user','bot') NOT NULL,
  message_text TEXT NOT NULL,
  retrieved_context TEXT NULL
    COMMENT 'potongan konteks yang diambil retriever RAG untuk pesan bot',
  response_time_ms INT UNSIGNED NULL COMMENT 'latensi respons generator LLM',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_messages_conversation
    FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
  INDEX idx_messages_conversation (conversation_id)
) ENGINE=InnoDB;

-- Penilaian siswa/guru BK terhadap kualitas jawaban bot (bahan evaluasi
-- program BK berkelanjutan sesuai manfaat praktis penelitian)
CREATE TABLE message_feedback (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,
  rating ENUM('helpful','not_helpful') NOT NULL,
  comment VARCHAR(255) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_feedback_message
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE,
  CONSTRAINT fk_feedback_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Dokumen sumber basis pengetahuan RAG (pedoman BK, aturan akademik,
-- info karier, dsb.) yang diunggah admin/guru BK
CREATE TABLE knowledge_bases (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uploaded_by BIGINT UNSIGNED NOT NULL,
  title VARCHAR(150) NOT NULL,
  category ENUM('pedoman_bk','aturan_akademik','program_studi','informasi_karier','lainnya')
    NOT NULL DEFAULT 'lainnya',
  file_path VARCHAR(255) NOT NULL,
  file_type VARCHAR(20) NULL COMMENT 'pdf, docx, txt, dll.',
  status ENUM('pending','processed','failed') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_kb_uploader
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Potongan (chunk) hasil pemecahan dokumen. Vektor embedding-nya sendiri
-- disimpan di vector database terpisah (pgvector/Chroma); kolom
-- vector_ref_id adalah kunci penghubung ke sana.
CREATE TABLE document_chunks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  knowledge_base_id BIGINT UNSIGNED NOT NULL,
  chunk_index INT UNSIGNED NOT NULL,
  content TEXT NOT NULL,
  token_count INT UNSIGNED NULL,
  vector_ref_id VARCHAR(100) NULL COMMENT 'id embedding pada vector database',
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_chunks_kb
    FOREIGN KEY (knowledge_base_id) REFERENCES knowledge_bases(id) ON DELETE CASCADE,
  INDEX idx_chunks_kb (knowledge_base_id)
) ENGINE=InnoDB;

-- =====================================================================
-- 3. FITUR REKOMENDASI E-BOOK (subbab 2.3.4)
-- =====================================================================

CREATE TABLE ebooks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  uploaded_by BIGINT UNSIGNED NOT NULL,
  subject VARCHAR(100) NOT NULL COMMENT 'mata pelajaran',
  title VARCHAR(150) NOT NULL,
  author VARCHAR(150) NULL,
  publisher VARCHAR(150) NULL,
  file_path VARCHAR(255) NULL,
  description TEXT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_ebooks_uploader
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Log setiap kali chatbot merekomendasikan e-book kepada siswa
CREATE TABLE ebook_recommendations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message_id BIGINT UNSIGNED NULL COMMENT 'pesan bot yang memicu rekomendasi ini',
  user_id BIGINT UNSIGNED NOT NULL,
  ebook_id BIGINT UNSIGNED NOT NULL,
  reason VARCHAR(255) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_ebookrec_message
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE SET NULL,
  CONSTRAINT fk_ebookrec_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_ebookrec_ebook
    FOREIGN KEY (ebook_id) REFERENCES ebooks(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 4. EVALUASI (tiga instrumen sesuai subbab 3.3.4 & kerangka konseptual)
-- =====================================================================

-- (a) System Usability Scale - 10 pernyataan baku skala Likert 1-5
CREATE TABLE sus_responses (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  respondent_role ENUM('siswa','guru_bk') NOT NULL,
  q1 TINYINT UNSIGNED NOT NULL, q2 TINYINT UNSIGNED NOT NULL,
  q3 TINYINT UNSIGNED NOT NULL, q4 TINYINT UNSIGNED NOT NULL,
  q5 TINYINT UNSIGNED NOT NULL, q6 TINYINT UNSIGNED NOT NULL,
  q7 TINYINT UNSIGNED NOT NULL, q8 TINYINT UNSIGNED NOT NULL,
  q9 TINYINT UNSIGNED NOT NULL, q10 TINYINT UNSIGNED NOT NULL,
  sus_score DECIMAL(5,2) NULL COMMENT 'dihitung: ((jumlah skor ganjil-5)+(20-jumlah skor genap))*2.5',
  submitted_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_sus_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- (b) Bank soal pre-test/post-test
CREATE TABLE pretest_posttest_questions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category ENUM('akademik','psikologis_emosional','sosial','karier') NOT NULL,
  question_text TEXT NOT NULL,
  options JSON NULL COMMENT 'pilihan jawaban, mis. {"a":"...","b":"...","c":"...","d":"..."}',
  correct_answer VARCHAR(10) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Jawaban siswa per butir soal, pada fase pre atau post
CREATE TABLE pretest_posttest_answers (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  question_id BIGINT UNSIGNED NOT NULL,
  test_phase ENUM('pre','post') NOT NULL,
  selected_answer VARCHAR(10) NOT NULL,
  is_correct BOOLEAN NOT NULL,
  answered_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_answers_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_answers_question
    FOREIGN KEY (question_id) REFERENCES pretest_posttest_questions(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Rekap skor pre-test/post-test per siswa (dipakai untuk BAB 4 analisis efektivitas)
CREATE TABLE evaluations (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  pre_test_score INT UNSIGNED NULL,
  post_test_score INT UNSIGNED NULL,
  test_date DATE NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_evaluations_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- (c) Dokumentasi Black Box Testing per skenario/fungsi sistem
CREATE TABLE blackbox_test_cases (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  module_name VARCHAR(100) NOT NULL COMMENT 'mis. login, chat RAG, upload knowledge base',
  test_scenario TEXT NOT NULL,
  test_steps TEXT NULL,
  expected_result TEXT NOT NULL,
  actual_result TEXT NULL,
  status ENUM('passed','failed','not_tested') NOT NULL DEFAULT 'not_tested',
  tested_by BIGINT UNSIGNED NULL,
  tested_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_blackbox_tester
    FOREIGN KEY (tested_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- 5. SISTEM / AUDIT
-- =====================================================================

CREATE TABLE activity_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  action VARCHAR(100) NOT NULL COMMENT 'mis. login, upload_kb, delete_user',
  description VARCHAR(255) NULL,
  ip_address VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_logs_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- CONTOH SEED DATA MINIMAL (opsional, hapus/ubah sesuai kebutuhan)
-- =====================================================================
INSERT INTO users (name, email, password, role) VALUES
  ('Admin Sistem', 'admin@sman4jember.sch.id', '$2y$10$replace_with_bcrypt_hash', 'admin'),
  ('Fatimatuzzahra, S.Kom., M.Kom', 'gurubk@sman4jember.sch.id', '$2y$10$replace_with_bcrypt_hash', 'guru_bk'),
  ('Contoh Siswa', 'siswa@sman4jember.sch.id', '$2y$10$replace_with_bcrypt_hash', 'siswa');

INSERT INTO counselor_profiles (user_id, nip, spesialisasi) VALUES
  (2, '197709292005011003', 'akademik & karier');

INSERT INTO student_profiles (user_id, nisn, kelas, jurusan) VALUES
  (3, '0012345678', 'XI', 'IPA');
