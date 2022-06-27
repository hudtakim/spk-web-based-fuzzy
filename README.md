# spk-web-based-fuzzy
Sebuah proyek sistem pendukung keputusan berbasis web dengan metode Fuzzy Tahani yang menerapkan kombinasi logika AND dan OR. Dimana penerapan logika AND akan diprioritaskan, sedangkan logika OR akan diterapkan apabila firestrength dari logika AND semuanya bernilai nol.

# spk-fuzzy-dynamic
Versi dinamis dan dapat dicustom untuk SPK pada kasus apapun.

Instalasi:
1. Pastikan Mysql dan PHP sudah terinstal di perangkat anda.
2. Buat database bernama 'wisata_tegal_db' pada PhpMyAdmin, kemudian import file database pada repository ini pada database tersebut.
3. Pastikan XAMPP sudah berjalan untuk menjalankan MYSQL dan Apache
4. Taruh Folder wisataweb pada folder htdoc di sistem anda.
5. Jalankan di browser dengan alamat: 'localhost/wisataweb'
6. Agar tampilan tidak acak-acakan, pastikan perangkat anda terkoneksi internet dikarenakan aplikasi ini menggunakan CDN bootstrap.

User Guide:
1. Isikan seluruh kriteria wisata yang diinginkan.
2. User dapat menghapus kriteria yang tidak ingin digunakan.
3. Klik tombol submit untuk melihat hasil rekomendasi.

Cara Kerja Aplikasi:
1. Menerima input kriteria wisata dari user.
2. Mengambil bobot kriteria dari database sesuai dengan kriteria yang diinputkan.
3. Menghitung fire strength setiap pasangan kriteria.
4. Memanggil data wisata yang memiliki fire strength > 0, dan menyimpannya pada database sementara.
6. Menampilkan data wisata dari data base sementara pada tampilan web sebagai tempat wisata yang direkomendasikan.
7. Menghapus data wisata pada database sementara.

Admin Guide:
1. Sudah tersedia laman khus admin web (update 7 September 2021).
2. Previlege admin: 
   - Menambah data lokasi wisata
   - Menghapus data lokasi wisata
   - Menambah data kriteria
   - Menghapus data kriteria
   - Mengaktifkan atau menonaktifkan kriteria pada tampilan user.
   - Mengatur tampilan web (Deskripsi Web, gambar banner, dan warna latar belakang)

Perhatian: 
1. Projek ini dibuat sebagai latihan/pembelajaran saja.
2. Data lokasi wisata yang digunakan untuk uji coba aplikasi web ini saya ambil dari salah satu paper penelitian di internet.
3. Dilarang diperjualbelikan.
4. Untuk mencoba aplikasi ini secara langsung silahkan menuju link berikut: http://hudtakim.byethost12.com/spkwisata  <--- (Last Update 13 Sept 2021)
