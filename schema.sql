-- =========================================================
-- Skema Database Website Sekolah
-- Import file ini melalui phpMyAdmin / mysql CLI:
--   mysql -u root -p < schema.sql
-- =========================================================

CREATE DATABASE IF NOT EXISTS db_sekolah CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_sekolah;

-- ---------------------------------------------------------
-- Tabel admin (untuk login halaman admin/CMS sederhana)
-- ---------------------------------------------------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- disimpan dengan password_hash()
    nama_lengkap VARCHAR(100) NOT NULL,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun admin default -> username: admin / password: admin123
-- (hash valid untuk 'admin123', sudah diverifikasi)
INSERT INTO admin (username, password, nama_lengkap) VALUES
('admin', '$2y$10$WTEhx2JC9O4W7p3gIrWG7O.0A5wEzGaoDhRe9hx6nMmttEUd0UY1q', 'Admin Sekolah');

-- ---------------------------------------------------------
-- Tabel kategori artikel/berita
-- ---------------------------------------------------------
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

INSERT INTO kategori (nama_kategori) VALUES ('Berita'), ('Kegiatan'), ('Pengumuman');

-- ---------------------------------------------------------
-- Tabel artikel & blog (Berita Sekolah)
-- ---------------------------------------------------------
CREATE TABLE artikel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT DEFAULT NULL,
    judul VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    ringkasan VARCHAR(300) DEFAULT NULL,
    konten TEXT NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL, -- nama file di folder /uploads, kosongkan jika belum ada
    penulis VARCHAR(100) DEFAULT 'Admin Sekolah',
    dilihat INT DEFAULT 0,
    tanggal_terbit DATE NOT NULL,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Data contoh sesuai desain (gambar sengaja dikosongkan / NULL, akan tampil placeholder)
INSERT INTO artikel (kategori_id, judul, slug, ringkasan, konten, gambar, penulis, dilihat, tanggal_terbit) VALUES
(2, 'Kegiatan Class Meeting Meriahkan Akhir Semester',
 'kegiatan-class-meeting-meriahkan-akhir-semester',
 'Seluruh siswa mengikuti kegiatan Class Meeting sebagai bentuk apresiasi kerja keras selama satu semester.',
 'Setelah menyelesaikan rangkaian kegiatan pembelajaran selama satu semester, seluruh siswa mengikuti kegiatan Class Meeting yang diselenggarakan sebagai bentuk apresiasi atas kerja keras dan semangat belajar selama ini. Kegiatan ini menjadi momen yang paling dinantikan karena memberikan kesempatan kepada seluruh siswa untuk bersantai, berkompetisi secara sehat, dan mempererat kebersamaan dengan teman-teman dari berbagai kelas.\n\nBerbagai perlombaan menarik diselenggarakan, mulai dari pertandingan olahraga, permainan tradisional, hingga lomba yang mengasah kreativitas dan kekompakan. Setiap kelas menunjukkan semangat juang, kerja sama, dan sportivitas yang tinggi dalam setiap pertandingan. Sorak sorai para pendukung serta antusiasme peserta menciptakan suasana sekolah yang hidup, penuh keceriaan, dan semangat positif.',
 NULL, 'Admin Sekolah', 427, '2026-07-13'),
(1, 'Momen Kembali ke Sekolah pada 13 July 2026',
 'momen-kembali-ke-sekolah-pada-13-july-2026',
 'Yang menandakan awal semangat baru dalam belajar.',
 'Yang menandakan awal semangat baru dalam belajar. Seluruh siswa kembali memasuki lingkungan sekolah dengan penuh semangat setelah masa libur, siap menyambut rangkaian kegiatan belajar mengajar semester baru.',
 NULL, 'Admin Sekolah', 427, '2026-07-13'),
(2, 'Suasana Belajar yang Menunjukan Hubungan Baik',
 'suasana-belajar-yang-menunjukan-hubungan-baik',
 'Antara siswa/siswi, dengan sikap saling menghargai, bekerja sama, dan menciptakan lingkungan kelas yang nyaman.',
 'Antara siswa/siswi, dengan sikap saling menghargai, bekerja sama, dan menciptakan lingkungan kelas yang nyaman. Suasana belajar yang positif ini menjadi fondasi penting bagi tumbuhnya prestasi akademik maupun non-akademik di sekolah.',
 NULL, 'Admin Sekolah', 338, '2026-07-20');

-- ---------------------------------------------------------
-- Tabel prestasi sekolah
-- ---------------------------------------------------------
CREATE TABLE prestasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    keterangan VARCHAR(255) DEFAULT NULL,
    peringkat TINYINT DEFAULT 1, -- 1 = juara 1, 2 = juara 2, dst
    tanggal DATE DEFAULT NULL
) ENGINE=InnoDB;

INSERT INTO prestasi (judul, keterangan, peringkat, tanggal) VALUES
('Juara 1 Lomba Futsal Kabupaten', 'Tim siswa berhasil meraih juara pertama kompetisi tingkat kabupaten.', 1, '2026-05-10'),
('Juara 2 Cerdas Cermat Tingkat Kota', 'Tim siswa berhasil meraih juara kedua pada kompetisi yang diikuti oleh berbagai sekolah.', 2, '2026-04-02'),
('Juara 3 Olimpiade Matematika', 'Perwakilan sekolah menunjukan kemampuan terbaiknya hingga memperoleh juara ketiga tingkat provinsi.', 3, '2026-03-15');

-- ---------------------------------------------------------
-- Tabel fasilitas sekolah
-- ---------------------------------------------------------
CREATE TABLE fasilitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    deskripsi VARCHAR(255) DEFAULT NULL,
    icon VARCHAR(50) DEFAULT NULL -- nama ikon (dipetakan di front-end)
) ENGINE=InnoDB;

INSERT INTO fasilitas (nama, deskripsi, icon) VALUES
('Laboratorium Komputer', 'Mendukung pembelajaran teknologi dan keterampilan digital siswa', 'computer'),
('Ruangan Perpustakaan', 'Menyediakan berbagai buku dan sumber belajar', 'book'),
('Ruang Kelas Yang Nyaman', 'Lingkungan belajar yang kondusif dan tertata', 'classroom'),
('Lapangan Olahraga', 'Mendukung kegiatan olahraga dan pengembangan bakat siswa', 'field');

-- ---------------------------------------------------------
-- Tabel galeri kegiatan (opsional, untuk halaman Galeri Kegiatan)
-- ---------------------------------------------------------
CREATE TABLE galeri (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL,
    tanggal DATE DEFAULT NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel pesan kontak (dari form Kontak Kami)
-- ---------------------------------------------------------
CREATE TABLE pesan_kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pesan TEXT NOT NULL,
    dibaca TINYINT(1) DEFAULT 0,
    dikirim_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabel identitas sekolah (agar mudah diubah dari admin)
-- ---------------------------------------------------------
CREATE TABLE identitas_sekolah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_sekolah VARCHAR(150) NOT NULL,
    alamat VARCHAR(255) DEFAULT NULL,
    telepon VARCHAR(50) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    whatsapp VARCHAR(50) DEFAULT NULL,
    instagram VARCHAR(100) DEFAULT NULL,
    logo VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

INSERT INTO identitas_sekolah (nama_sekolah, alamat, telepon, email, whatsapp, instagram, logo) VALUES
('SMK Wiri Handayani', 'Jl. [Jalan Dummy], Indonesia', '(0251) xxx-xxxx', 'sekolahdummy@gmail.com', '0831-1064-0474', '@sekolah_dummy', NULL);
