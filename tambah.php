<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/perpustakaan/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../login.php");
    exit;
}

// 1. SESUAIKAN: Mengurutkan berdasarkan kolom asli 'buku_judul'
$buku_query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY buku_judul ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">Form Peminjaman Buku Baru</div>
        <div class="card-body p-4">
            <form action="proses.php?aksi=tambah" method="POST">
                
                <div class="mb-3">
                    <label for="nama_peminjam" class="form-label">Nama Lengkap Peminjam</label>
                    <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" required autocomplete="off" placeholder="Masukkan nama siswa/anggota">
                </div>

                <div class="mb-3">
                    <label for="id_buku" class="form-label">Buku yang Dipinjam</label>
                    <select name="id_buku" id="id_buku" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        <?php while($buku = mysqli_fetch_assoc($buku_query)) : ?>
                            <option value="<?= $buku['buku_id']; ?>">
                                <?= htmlspecialchars($buku['buku_judul']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="indeks.php" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" name="btn_simpan" class="btn btn-primary">Proses Pinjam</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>