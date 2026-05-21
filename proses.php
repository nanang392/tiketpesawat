<?php
require_once 'koneksi.php';

// Ambil data pajak dari database
function getPajakAsal($conn, $bandara) {
    $query = "SELECT pajak FROM tbl_pajak_asal WHERE bandara = '$bandara'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['pajak'];
    }
    return 0;
}

function getPajakTujuan($conn, $bandara) {
    $query = "SELECT pajak FROM tbl_pajak_tujuan WHERE bandara = '$bandara'";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['pajak'];
    }
    return 0;
}

// Fungsi hitung total
function hitungTotalHarga($harga, $pajakAsal, $pajakTujuan) {
    return $harga + $pajakAsal + $pajakTujuan;
}

// ========== PROSES TAMBAH DATA ==========
if (isset($_POST['simpan'])) {
    $maskapai = mysqli_real_escape_string($conn, $_POST['nama']);
    $bandara_asal = mysqli_real_escape_string($conn, $_POST['bandaraAsal']);
    $bandara_tujuan = mysqli_real_escape_string($conn, $_POST['bandaraTujuan']);
    $harga = (int)$_POST['harga'];
    
    // Hitung pajak
    $pajak_asal = getPajakAsal($conn, $bandara_asal);
    $pajak_tujuan = getPajakTujuan($conn, $bandara_tujuan);
    $total_pajak = $pajak_asal + $pajak_tujuan;
    $total_harga = hitungTotalHarga($harga, $pajak_asal, $pajak_tujuan);
    
    $query = "INSERT INTO tbl_rute (maskapai, bandara_asal, bandara_tujuan, harga, pajak, total) 
              VALUES ('$maskapai', '$bandara_asal', '$bandara_tujuan', $harga, $total_pajak, $total_harga)";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Data berhasil ditambahkan!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menambahkan data: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: index.php");
    exit();
}

// ========== PROSES UPDATE DATA ==========
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $maskapai = mysqli_real_escape_string($conn, $_POST['nama']);
    $bandara_asal = mysqli_real_escape_string($conn, $_POST['bandaraAsal']);
    $bandara_tujuan = mysqli_real_escape_string($conn, $_POST['bandaraTujuan']);
    $harga = (int)$_POST['harga'];
    
    // Hitung pajak
    $pajak_asal = getPajakAsal($conn, $bandara_asal);
    $pajak_tujuan = getPajakTujuan($conn, $bandara_tujuan);
    $total_pajak = $pajak_asal + $pajak_tujuan;
    $total_harga = hitungTotalHarga($harga, $pajak_asal, $pajak_tujuan);
    
    $query = "UPDATE tbl_rute SET 
              maskapai = '$maskapai',
              bandara_asal = '$bandara_asal',
              bandara_tujuan = '$bandara_tujuan',
              harga = $harga,
              pajak = $total_pajak,
              total = $total_harga
              WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Data berhasil diupdate!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal mengupdate data: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: index.php");
    exit();
}

// ========== PROSES HAPUS DATA ==========
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    
    $query = "DELETE FROM tbl_rute WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Data berhasil dihapus!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menghapus data: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: index.php");
    exit();
}

// ========== PROSES RESET SEMUA DATA ==========
if (isset($_GET['reset'])) {
    $query = "TRUNCATE TABLE tbl_rute";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Semua data berhasil direset!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal mereset data: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: index.php");
    exit();
}

// Jika tidak ada action
header("Location: index.php");
exit();
?>