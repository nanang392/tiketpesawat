# ✈️ Pendaftaran Rute Penerbangan

Aplikasi web sederhana untuk mengelola tiket pesawat dengan fitur CRUD (Create, Read, Update, Delete) menggunakan PHP Native dan MySQL.

## ✨ Fitur Utama

| Fitur | Keterangan |
|-------|-------------|
| ➕ **Create** | Menambah data rute penerbangan baru |
| 📖 **Read** | Menampilkan daftar rute penerbangan |
| ✏️ **Update** | Mengedit data rute yang sudah ada |
| 🗑️ **Delete** | Menghapus data rute tertentu |
| 🔄 **Reset All** | Menghapus semua data sekaligus |
| 💰 **Auto Calculate** | Menghitung pajak dan total harga secara otomatis |

## 🗂️ Struktur Database

### Tabel `tbl_rute`
| Kolom | Tipe | Keterangan |
|-------|------|-------------|
| id | INT(11) | Primary Key, Auto Increment |
| maskapai | VARCHAR(100) | Nama maskapai penerbangan |
| bandara_asal | VARCHAR(100) | Bandara keberangkatan |
| bandara_tujuan | VARCHAR(100) | Bandara tujuan |
| harga | INT(11) | Harga tiket |
| pajak | INT(11) | Total pajak (asal + tujuan) |
| total | INT(11) | Total harga (harga + pajak) |
| created_at | TIMESTAMP | Waktu input data |

### Tabel `tbl_pajak_asal`
| Kolom | Tipe | Keterangan |
|-------|------|-------------|
| id | INT(11) | Primary Key |
| bandara | VARCHAR(100) | Nama bandara |
| pajak | INT(11) | Biaya pajak keberangkatan |

### Tabel `tbl_pajak_tujuan`
| Kolom | Tipe | Keterangan |
|-------|------|-------------|
| id | INT(11) | Primary Key |
| bandara | VARCHAR(100) | Nama bandara |
| pajak | INT(11) | Biaya pajak kedatangan |

## 💻 Persyaratan Sistem

| Komponen | Minimal |
|----------|---------|
| **Web Server** | Apache (XAMPP / Laragon / WAMP) |
| **PHP** | Versi 7.4 atau lebih tinggi |
| **MySQL** | Versi 5.7 atau lebih tinggi |
| **Browser** | Chrome, Firefox, Edge, Opera (modern) |

##📝 Data Pajak Bandara
Pajak Keberangkatan (Asal)
Bandara	Kode	Pajak
Soekarno-Hatta	CGK	Rp 50.000
Husein Sastranegara	BDO	Rp 30.000
Abdul Rachman Saleh	MLG	Rp 40.000
Juanda	SUB	Rp 40.000
Kualanamu	KNO	Rp 45.000
Sultan Hasanuddin	UPG	Rp 60.000
Pajak Kedatangan (Tujuan)
Bandara	Kode	Pajak
Ngurah Rai	DPS	Rp 80.000
Hasanuddin	UPG	Rp 70.000
Inanwatan	INX	Rp 90.000
Sultan Iskandarmuda	BTJ	Rp 70.000
Juanda	SUB	Rp 65.000
Soekarno-Hatta	CGK	Rp 75.000
