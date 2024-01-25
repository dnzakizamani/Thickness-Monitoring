# Thickness Monitoring

## Deskripsi Proyek

Thickness Monitoring adalah sistem berbasis web yang dikembangkan menggunakan Angular (front-end) dan Laravel (back-end) untuk memantau dan merekam ketebalan dengan mudah. Sistem ini memanfaatkan formulir input ketebalan yang terhubung dengan perangkat ketebalan melalui Bluetooth. Fitur utama proyek ini adalah memungkinkan pengguna untuk melakukan pengukuran ketebalan dengan cepat dan mudah. Pengguna hanya perlu mengukur benda dan mengklik tombol yang ada di alat, maka data ketebalan akan otomatis terisi pada formulir input.

## Fitur Utama

1. **Pengukuran Ketebalan Mudah:**
   - Pengguna hanya perlu mengukur benda dan mengklik tombol pada perangkat.
   - Data ketebalan akan otomatis terisi pada formulir input.

2. **Penyimpanan Data:**
   - Setelah data diinput, sistem secara otomatis menyimpannya ke database.

3. **Diagram Normal (Bell Curve):**
   - Menampilkan diagram normal untuk memvisualisasikan distribusi ketebalan.
   - Memudahkan pengguna untuk melihat sebaran data dan menilai kualitas.

4. **Batas Spesifikasi:**
   - Menampilkan batas spesifikasi LSL dan USL pada diagram normal.
   - Memudahkan pengguna untuk memahami apakah data berada dalam batas spesifikasi atau tidak.

## Komponen Proyek

### Front-end (Angular)
- HTML, CSS, TypeScript untuk antarmuka pengguna
- Chart.js untuk membuat diagram normal

### Back-end (Laravel)
- PHP sebagai bahasa pemrograman server-side
- Database (misalnya MySQL) untuk menyimpan data ketebalan
- Logika bisnis untuk menyimpan dan mengambil data dari database

### Perangkat Keras
- Perangkat ketebalan yang mendukung koneksi Bluetooth

## Cara Kerja

1. **Pengukuran Ketebalan:**
   - Pengguna mengukur benda dengan perangkat dan mengklik tombol pada alat.
   - Data ketebalan otomatis terisi pada formulir input.

2. **Penyimpanan dan Visualisasi Data:**
   - Data ketebalan disimpan ke database secara otomatis setelah pengguna melakukan pengukuran.
   - Sistem menampilkan diagram normal dengan batas spesifikasi untuk memvisualisasikan kualitas ketebalan.

## Keuntungan

- **Pemantauan Real-time:** Pengguna dapat melihat dan memahami kualitas ketebalan secara real-time.
- **Sederhana dan Cepat:** Proses pengukuran ketebalan menjadi lebih cepat dan mudah.
- **Visualisasi yang Jelas:** Diagram normal dan batas spesifikasi memberikan pandangan visual yang jelas tentang kualitas ketebalan.
