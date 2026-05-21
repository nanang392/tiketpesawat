# ✈️ AeroTicket - Sistem Pemesanan Tiket Pesawat

Aplikasi web sederhana untuk memesan dan mengelola tiket pesawat dengan fitur CRUD (Create, Read, Update, Delete) menggunakan PHP Native dan MySQL.

## 🎨 Tema Warna
- Biru Tua: `#1A237E`
- Biru Muda: `#42A5F5`
- Putih: `#FFFFFF`

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

## 📁 Struktur File
