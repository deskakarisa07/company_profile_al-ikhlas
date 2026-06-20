# Company Profile Yayasan Al Ikhlas

Website Company Profile berbasis Laravel 13 dengan frontend publik dan halaman administrator.

## Fitur

- Login/logout admin manual menggunakan session Laravel.
- Dashboard ringkasan data.
- CRUD Artikel/Berita, Profil Yayasan, Unit Pendidikan, dan Galeri.
- Inbox pesan dari form Contact.
- Upload gambar melalui public storage.
- Export laporan artikel ke PDF.
- Frontend dinamis tanpa mengubah konsep desain awal.

## Instalasi

Pastikan PHP 8.3+, Composer, MySQL, dan database `db_company01` tersedia.

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database pada `.env`, kemudian:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Buka website di `http://127.0.0.1:8000` dan halaman admin di
`http://127.0.0.1:8000/admin/login`.

## Login Admin Default

- Email: `admin@alikhlas.sch.id`
- Password: `admin12345`

Ganti password seed/default sebelum aplikasi digunakan pada lingkungan produksi.

## Export PDF

Login sebagai admin, buka menu **Artikel/Berita**, lalu tekan tombol **Export PDF**.
Laporan berisi judul, tanggal cetak, tabel artikel, dan ringkasan status.

## Pengujian

```bash
php artisan test
```

Upload gambar menerima JPEG, JPG, PNG, atau WebP dengan ukuran maksimal 2 MB.
