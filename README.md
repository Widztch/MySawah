# MySawah 🌿

MySawah adalah platform yang dirancang untuk meningkatkan produktivitas pertanian melalui integrasi teknologi AI dan Agri-Commerce. Dibangun menggunakan Jetpack Compose, platform ini menghadirkan arsitektur yang rapi dan reaktif untuk memberikan pengalaman pengguna yang lancar.

## Fitur Unggulan (Soon)

### AI Crop Recommendation
Sistem cerdas yang merekomendasikan tanaman terbaik untuk lahan Anda. Sebagai implementasi dari machine learning, fitur ini dirancang untuk memberikan hasil yang akurat berdasarkan data lingkungan.
* Menggunakan model **Random Forest Classifier**.
* Menganalisis 7 parameter tanah: Nitrogen (N), Fosfor (P), Kalium (K), Suhu, Kelembaban, pH, dan Curah Hujan.
* Interface berbasis chat yang interaktif.

### Smart Marketplace & Cart
* **Real-time Sync:** Keranjang belanja tersinkronisasi langsung dengan database server (Laravel).
* **Pending Order System:** Barang yang dimasukkan ke keranjang tersimpan aman meskipun aplikasi ditutup.
* **Stock Validation:** Pengurangan stok otomatis saat transaksi berhasil (Status PAID).

### Transaction History
* Riwayat pesanan mendetail untuk memantau pengeluaran dan kebutuhan tani.
* Status transaksi transparan (Pending/Paid).
* Format mata uang Rupiah otomatis.

### Profile Management
* **Update Profile:** Ubah Nama, No. HP, dan Alamat dengan sistem Dialog yang intuitif.
* **Smart Photo Upload:** Ambil foto langsung dari Kamera atau Galeri.
* **Auto Compression:** Mengecilkan ukuran foto secara otomatis sebelum diunggah untuk menghemat kuota dan mempercepat proses.
* **Cache Busting:** Foto profil diperbarui secara instan di layar tanpa perlu refresh manual.
