<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/perpustakaan/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../login.php");
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$query = mysqli_query($koneksi, "SELECT * FROM penulis WHERE id_penulis = '$id'");
$row = mysqli_fetch_assoc($query);

if (mysqli_num_rows($query) < 1) {
    header("Location: indeks.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Penulis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold">Ubah Data Penulis</div>
        <div class="card-body p-4">
            <form action="proses.php?aksi=edit" method="POST">
                <input type="hidden" name="id_penulis" value="<?= $row['id_penulis']; ?>">
                <div class="mb-3">
                    <label for="nama_penulis" class="form-label">Nama Penulis</label>
                    <input type="text" name="nama_penulis" id="nama_penulis" class="form-control" value="<?= htmlspecialchars($row['nama_penulis']); ?>" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak / No. HP</label>
                    <input type="text" name="kontak" id="kontak" class="form-control" value="<?= htmlspecialchars($row['kontak']); ?>" autocomplete="off">
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="indeks.php" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" name="btn_ubah" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>