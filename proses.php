<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/perpustakaan/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../../login.php");
    exit;
}

// 1. PROSES TAMBAH DATA PENULIS
if (isset($_POST['btn_simpan'])) {
    $nama_penulis = mysqli_real_escape_string($koneksi, $_POST['nama_penulis']);

    $query_insert = mysqli_query($koneksi, "INSERT INTO penulis (nama_penulis) VALUES ('$nama_penulis')");

    if ($query_insert) {
        echo "<script>alert('Penulis berhasil ditambahkan!'); window.location.href='indeks.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah penulis!'); window.location.href='indeks.php';</script>";
    }
}

// 2. PROSES HAPUS DATA PENULIS
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id_penulis = mysqli_real_escape_string($koneksi, $_GET['id']);

    $query_delete = mysqli_query($koneksi, "DELETE FROM penulis WHERE id_penulis = '$id_penulis'");

    if ($query_delete) {
        echo "<script>alert('Data penulis berhasil dihapus!'); window.location.href='indeks.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data penulis!'); window.location.href='indeks.php';</script>";
    }
}
?>