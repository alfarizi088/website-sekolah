# Website Sekolah (HTML/CSS/JS + PHP + MySQL)

Struktur ini adalah implementasi dari desain Figma (halaman Beranda & halaman Detail Artikel).
Semua gambar sengaja **dikosongkan** dan diganti dengan **placeholder bertanda** (kotak garis putus-putus
bertuliskan "Gambar belum tersedia") sampai kamu mengunggah gambar aslinya.

## Struktur folder

```
sekolah/
├── admin/              -> Panel admin sederhana (CRUD artikel)
│   ├── login.php
│   ├── dashboard.php
│   ├── artikel_form.php
│   ├── auth.php
│   └── logout.php
├── config/
│   └── database.php     -> Koneksi database + helper placeholder gambar
├── css/
│   └── style.css
├── js/
│   └── script.js
├── includes/
│   ├── header.php
│   └── footer.php
├── uploads/              -> Tempat gambar artikel diunggah dari admin
├── database/
│   └── schema.sql        -> Struktur tabel + data contoh
├── index.php              -> Halaman Beranda
└── artikel.php             -> Halaman Detail Artikel (?slug=...)
```

## Cara instalasi (XAMPP / Laragon / server PHP+MySQL apa pun)

1. Salin folder `sekolah/` ke dalam folder `htdocs` (XAMPP) atau `www` (Laragon).
2. Buat database baru lewat phpMyAdmin, lalu **import** file `database/schema.sql`
   (atau jalankan lewat CLI: `mysql -u root -p < database/schema.sql`).
   File ini otomatis membuat database `db_sekolah` beserta seluruh tabel dan data contoh.
3. Buka `config/database.php`, sesuaikan `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`
   dengan konfigurasi server kamu (default cocok untuk XAMPP/Laragon: user `root`, password kosong).
4. Jalankan server (Apache) lalu akses:
   - Situs utama: `http://localhost/sekolah/index.php`
   - Panel admin: `http://localhost/sekolah/admin/login.php`
     - Username: `admin`
     - Password: `admin123`
     - **Segera ganti password ini setelah login pertama** (lewat phpMyAdmin, update kolom `password`
       di tabel `admin` dengan hasil `password_hash()` PHP yang baru).

## Mengganti gambar placeholder

- Lewat panel admin: buka menu **Artikel**, klik **Edit** atau **Tambah Artikel**, lalu unggah gambar
  pada kolom "Gambar Artikel". Gambar akan otomatis tersimpan di folder `uploads/`.
- Selama kolom gambar di database masih kosong (`NULL`), tampilan akan otomatis menampilkan
  kotak placeholder bergaris putus-putus bertuliskan "Gambar belum tersedia" — ini yang dimaksud
  "gambar dikosongkan tapi diberi tanda".

## Tabel database (ringkasan)

| Tabel               | Fungsi                                             |
|---------------------|-----------------------------------------------------|
| `admin`              | Akun login panel admin                              |
| `kategori`           | Kategori artikel (Berita, Kegiatan, Pengumuman)      |
| `artikel`            | Data artikel & blog beserta gambar, penulis, tanggal |
| `prestasi`           | Data prestasi sekolah (ditampilkan di sidebar)       |
| `fasilitas`          | Data fasilitas sekolah                                |
| `galeri`             | (opsional) galeri kegiatan                            |
| `pesan_kontak`       | (opsional) pesan dari form kontak                     |
| `identitas_sekolah`  | Alamat, telepon, email, dsb. yang tampil di footer   |

## Catatan keamanan singkat

- Password admin disimpan ter-hash (`password_hash`), bukan teks biasa.
- Query menggunakan **prepared statement** (`mysqli_prepare`) untuk mencegah SQL Injection.
- Semua output ke HTML dibungkus `htmlspecialchars()` untuk mencegah XSS.
- Upload gambar dibatasi hanya ekstensi `.jpg .jpeg .png .webp`.
