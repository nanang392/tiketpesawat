<?php
require_once 'koneksi.php';

// Ambil data pajak dari database untuk dropdown
$query_pajak_asal = "SELECT * FROM tbl_pajak_asal ORDER BY bandara";
$result_pajak_asal = mysqli_query($conn, $query_pajak_asal);

$query_pajak_tujuan = "SELECT * FROM tbl_pajak_tujuan ORDER BY bandara";
$result_pajak_tujuan = mysqli_query($conn, $query_pajak_tujuan);

// Ambil semua data rute dari database
$query_rute = "SELECT * FROM tbl_rute ORDER BY created_at DESC";
$result_rute = mysqli_query($conn, $query_rute);

// Hitung total keseluruhan
$query_total = "SELECT SUM(total) as total_semua FROM tbl_rute";
$result_total = mysqli_query($conn, $query_total);
$total_semua = mysqli_fetch_assoc($result_total);
$totalSemuaTiket = $total_semua['total_semua'] ?? 0;

// Cek apakah ada data yang akan diedit
$editData = null;
$editId = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $query_edit = "SELECT * FROM tbl_rute WHERE id = $editId";
    $result_edit = mysqli_query($conn, $query_edit);
    $editData = mysqli_fetch_assoc($result_edit);
}

// Tampilkan pesan session jika ada
$message = '';
$message_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

// Simpan data pajak ke array untuk ditampilkan di info card
$pajakBandaraAsal = array();
while ($row = mysqli_fetch_assoc($result_pajak_asal)) {
    $pajakBandaraAsal[$row['bandara']] = $row['pajak'];
}

$pajakBandaraTujuan = array();
while ($row = mysqli_fetch_assoc($result_pajak_tujuan)) {
    $pajakBandaraTujuan[$row['bandara']] = $row['pajak'];
}

// Reset pointer result untuk digunakan lagi di dropdown
mysqli_data_seek($result_pajak_asal, 0);
mysqli_data_seek($result_pajak_tujuan, 0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rute Penerbangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-4">
    <!-- Header -->
    <div class="main-header">
        <img src="gambar/pswt.png" alt="Icon Pesawat" width="200" class="me-2 pesawat-float">
        <h1>Pendaftaran Rute Penerbangan</h1>
    </div>

    <!-- Pesan Session -->
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <i class="fas fa-<?php echo ($message_type == 'success') ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- DUA KOLOM ATAS: Input Data & Informasi Pajak -->
    <div class="row">
        <!-- Kolom Kiri: Input Data Tiket -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit"></i> 
                    <?php echo ($editData != null) ? 'Edit Data Tiket' : 'Input Data Tiket'; ?>
                </div>
                <div class="card-body">
                    <form method="POST" action="proses.php">
                        <?php if ($editData != null): ?>
                            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                            <input type="hidden" name="update" value="1">
                        <?php else: ?>
                            <input type="hidden" name="simpan" value="1">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="fas fa-building"></i> Maskapai
                            </label>
                            <input type="text" id="nama" name="nama" class="form-control" 
                                   placeholder="Contoh: Garuda Indonesia, Lion Air, Batik Air" 
                                   value="<?php echo ($editData != null) ? htmlspecialchars($editData['maskapai']) : ''; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="bandaraAsal" class="form-label">
                                <i class="fas fa-plane-departure"></i> Bandara Asal
                            </label>
                            <select name="bandaraAsal" id="bandaraAsal" class="form-select" required>
                                <option value="">Pilih Bandara Asal</option>
                                <?php while($pajak = mysqli_fetch_assoc($result_pajak_asal)): ?>
                                    <option value="<?php echo $pajak['bandara']; ?>" 
                                        <?php echo ($editData != null && $editData['bandara_asal'] == $pajak['bandara']) ? 'selected' : ''; ?>>
                                        <?php echo $pajak['bandara']; ?> (Pajak Rp <?php echo number_format($pajak['pajak'], 0, ',', '.'); ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bandaraTujuan" class="form-label">
                                <i class="fas fa-plane-arrival"></i> Bandara Tujuan
                            </label>
                            <select name="bandaraTujuan" id="bandaraTujuan" class="form-select" required>
                                <option value="">Pilih Bandara Tujuan</option>
                                <?php while($pajak = mysqli_fetch_assoc($result_pajak_tujuan)): ?>
                                    <option value="<?php echo $pajak['bandara']; ?>"
                                        <?php echo ($editData != null && $editData['bandara_tujuan'] == $pajak['bandara']) ? 'selected' : ''; ?>>
                                        <?php echo $pajak['bandara']; ?> (Pajak Rp <?php echo number_format($pajak['pajak'], 0, ',', '.'); ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">
                                <i class="fas fa-money-bill-wave"></i> Harga Tiket
                            </label>
                            <input type="number" id="harga" name="harga" class="form-control" 
                                   placeholder="Masukkan harga tiket (Rp)" 
                                   value="<?php echo ($editData != null) ? $editData['harga'] : ''; ?>" required>
                        </div>

                        <div class="text-center">
                            <?php if($editData != null): ?>
                                <a href="index.php" class="btn btn-secondary px-4">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save"></i> <?php echo ($editData != null) ? 'Update Data' : 'Simpan Data'; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Informasi Pajak Bandara -->
        <div class="col-lg-6">
            <div class="card info-card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi Pajak Bandara
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h6><i class="fas fa-plane-departure"></i> Pajak Keberangkatan:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <?php foreach($pajakBandaraAsal as $bandara => $pajak): ?>
                                    <tr>
                                        <td><?php echo $bandara; ?></td>
                                        <td class="text-end">Rp <?php echo number_format($pajak, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6><i class="fas fa-plane-arrival"></i> Pajak Kedatangan:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <?php foreach($pajakBandaraTujuan as $bandara => $pajak): ?>
                                    <tr>
                                        <td><?php echo $bandara; ?></td>
                                        <td class="text-end">Rp <?php echo number_format($pajak, 0, ',', '.'); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-calculator"></i> <strong>Catatan:</strong> Pajak dihitung otomatis berdasarkan bandara asal dan tujuan.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DATA DI BAWAH (Full Width) -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-table"></i> Daftar Rute Penerbangan
                    <div class="float-end">
                        <a href="proses.php?reset=1" class="btn btn-sm btn-outline-danger" 
                           onclick="return confirm('Yakin ingin menghapus semua data?')">
                            <i class="fas fa-trash-alt"></i> Reset Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Maskapai</th>
                                    <th>Bandara Asal</th>
                                    <th>Tujuan</th>
                                    <th>Harga Tiket</th>
                                    <th>Pajak</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result_rute) == 0): ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block" style="color: #90CAF9;"></i>
                                            Belum ada data tiket. Silakan tambah data!
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php while($row = mysqli_fetch_assoc($result_rute)): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td>
                                                <i class="fas fa-plane" style="color: #42A5F5;"></i>
                                                <?php echo htmlspecialchars($row['maskapai']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['bandara_asal']); ?></td>
                                            <td><?php echo htmlspecialchars($row['bandara_tujuan']); ?></td>
                                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                            <td>Rp <?php echo number_format($row['pajak'], 0, ',', '.'); ?></td>
                                            <td>
                                                <strong style="color: #42A5F5;">
                                                    Rp <?php echo number_format($row['total'], 0, ',', '.'); ?>
                                                </strong>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="index.php?edit=<?php echo $row['id']; ?>" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <a href="proses.php?hapus=<?php echo $row['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Yakin hapus data <?php echo htmlspecialchars($row['maskapai']); ?>?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                            <?php if ($totalSemuaTiket > 0): ?>
                            <tfoot style="background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);">
                                <tr>
                                    <td colspan="6" class="text-end fw-bold">Total Keseluruhan:</td>
                                    <td class="fw-bold" style="color: #1A237E; font-size: 1.1rem;">
                                        Rp <?php echo number_format($totalSemuaTiket, 0, ',', '.'); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>