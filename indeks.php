<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/perpustakaan/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['level'] !== 'admin') {
    header("Location: /perpustakaan/login.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sistem informasi perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
/* Paksa semua heading di area konten jadi warna gelap */
#main-content h1, #main-content h2, #main-content h3,
#main-content h4, #main-content h5, #main-content h6,
#main-content p { color: #212529 !important; }
</style>
</head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0d1117; margin: 0; padding: 0;">

<div style="display: flex; min-height: 100vh;">

    <div style="width: 280px; background: rgba(22, 27, 34, 0.95); border-right: 1px solid rgba(255,255,255,0.08); padding: 30px 20px; display: flex; flex-direction: column; justify-content: space-between; position: fixed; height: 100vh; box-shadow: 5px 0 25px rgba(0,0,0,0.5); z-index: 1000; overflow-y: auto;">
        <div>
            <div style="font-size: 20px; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 10px; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 1px;">
                <i class="fa-solid fa-book-open" style="color: #c97a3e;"></i> Perpus Modern
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <a href="indeks.php" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'dashboard' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-chart-pie" style="<?= $page == 'dashboard' ? 'color: #ffb703 !important;' : ''; ?>"></i> Dashboard
                </a>
                
                <div style="color: #6e7681; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin: 12px 0 4px 6px;">Master Data</div>

                <a href="indeks.php?page=kategori" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'kategori' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-tags" style="<?= $page == 'kategori' ? 'color: #ffb703 !important;' : ''; ?>"></i> Kelola Kategori
                </a>
                
                <a href="indeks.php?page=penulis" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'penulis' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-feather" style="<?= $page == 'penulis' ? 'color: #ffb703 !important;' : ''; ?>"></i> Kelola Penulis
                </a>
                
                <a href="indeks.php?page=penerbit" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'penerbit' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-building" style="<?= $page == 'penerbit' ? 'color: #ffb703 !important;' : ''; ?>"></i> Kelola Penerbit
                </a>
                
                <a href="indeks.php?page=buku" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'buku' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-book" style="<?= $page == 'buku' ? 'color: #ffb703 !important;' : ''; ?>"></i> Kelola Buku
                </a>

                <a href="indeks.php?page=anggota" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'anggota' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-users" style="<?= $page == 'anggota' ? 'color: #ffb703 !important;' : ''; ?>"></i> Kelola Anggota
                </a>

                <div style="color: #6e7681; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin: 12px 0 4px 6px;">Sirkulasi & Transaksi</div>

                <a href="indeks.php?page=buku_masuk" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'buku_masuk' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-file-import" style="<?= $page == 'buku_masuk' ? 'color: #ffb703 !important;' : ''; ?>"></i> Buku Masuk
                </a>

                <a href="indeks.php?page=peminjaman" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'peminjaman' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-book-open-reader" style="<?= $page == 'peminjaman' ? 'color: #ffb703 !important;' : ''; ?>"></i> Peminjaman Buku
                </a>

                <a href="indeks.php?page=pengembalian" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'pengembalian' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-clock-rotate-left" style="<?= $page == 'pengembalian' ? 'color: #ffb703 !important;' : ''; ?>"></i> Pengembalian Buku
                </a>

                <div style="color: #6e7681; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin: 12px 0 4px 6px;">Laporan</div>

                <a href="indeks.php?page=laporan" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; font-weight: 600; border-radius: 12px; transition: all 0.2s; 
                    <?= $page == 'laporan' ? 'background: #3a86ff !important; color: #ffffff !important; box-shadow: 0 8px 20px rgba(58,132,255,0.3);' : 'color: #8b949e;'; ?>">
                    <i class="fa-solid fa-file-chart-column" style="<?= $page == 'laporan' ? 'color: #ffb703 !important;' : ''; ?>"></i> Laporan Perpus
                </a>
            </div>
        </div>

        <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 15px; margin-top: 15px;">
            <a href="/perpustakaan/logout.php" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; color: #f85149; font-weight: 700; border-radius: 12px;">
                <i class="fa-solid fa-power-off"></i> Keluar Sistem
            </a>
        </div>
    </div>

    <div id="main-content" style="margin-left: 280px; flex-grow: 1; padding: 24px 32px; background-color: #f4f4f4; min-height: 100vh; overflow-x: hidden;">
        <?php
        switch ($page) {
            case 'kategori':
                include "modul/kategori/indeks.php";
                break;
            case 'penulis':
                include "modul/penulis/indeks.php";
                break;
            case 'penerbit':
                include "modul/penerbit/indeks.php";
                break;
            case 'buku':
                include "modul/buku/indeks.php";
                break;
            case 'anggota':
                include "modul/anggota/indeks.php";
                break;
            case 'buku_masuk':
                $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
                if ($aksi == 'detail') {
                    $detail_id = isset($_GET['id']) ? $_GET['id'] : '';
                echo "<script>window.location.href='/perpustakaan/admin/modul/buku_masuk/detail.php?id=" . $detail_id . "';</script>";
                exit;
                    exit;
                } else {
                    include "modul/buku_masuk/indeks.php";
                }
                break;
            case 'peminjaman':
                include "modul/peminjaman/indeks.php";
                break;
            case 'pengembalian':
                include "modul/pengembalian/indeks.php";
                break;
            case 'laporan':
                include "modul/laporan/indeks.php";
                break;
            case 'dashboard':
            default:
                // QUERY COUNTER
                $q_buku = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku");
                $d_buku = mysqli_fetch_assoc($q_buku);

                $q_penerbit = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM penerbit");
                $d_penerbit = mysqli_fetch_assoc($q_penerbit);

                $q_penulis = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pengarang");
                $d_penulis = mysqli_fetch_assoc($q_penulis);

                $q_kategori = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori");
                $d_kategori = mysqli_fetch_assoc($q_kategori);

                // ==========================================
                // DATA GRAFIK 1: JUMLAH BUKU PER KATEGORI
                // ==========================================
                $chart_kategori_label = [];
                $chart_kategori_data  = [];

                // Relasi buku-kategori memakai tabel penghubung link_buku_kategori
                $tabel_link_ada = false;
                $cek_tabel_link = mysqli_query($koneksi, "SHOW TABLES LIKE 'link_buku_kategori'");
                if ($cek_tabel_link && mysqli_num_rows($cek_tabel_link) > 0) {
                    $tabel_link_ada = true;
                }

                $col_check_nama = mysqli_query($koneksi, "SHOW COLUMNS FROM kategori LIKE 'kategori_nama'");
                $kolom_nama_kategori = (mysqli_num_rows($col_check_nama) > 0) ? 'kategori_nama' : 'nama_kategori';

                // Deteksi primary key kategori (dipakai khusus untuk query grafik dashboard)
                $pk_test = mysqli_query($koneksi, "SHOW KEYS FROM kategori WHERE Key_name = 'PRIMARY'");
                $pk_kategori_dash = 'kategori_id';
                if ($pk_test && mysqli_num_rows($pk_test) > 0) {
                    $pk_data_dash = mysqli_fetch_assoc($pk_test);
                    $pk_kategori_dash = $pk_data_dash['Column_name'];
                }

                if ($tabel_link_ada) {
                    try {
                        $sql_chart_kategori = "SELECT k.$kolom_nama_kategori AS nama, COUNT(l.buku_id) AS jumlah
                                               FROM kategori k
                                               LEFT JOIN link_buku_kategori l ON l.kategori_id = k.$pk_kategori_dash
                                               GROUP BY k.$pk_kategori_dash, k.$kolom_nama_kategori
                                               ORDER BY k.$kolom_nama_kategori";
                        $q_chart_kategori = mysqli_query($koneksi, $sql_chart_kategori);
                        if ($q_chart_kategori) {
                            while ($r = mysqli_fetch_assoc($q_chart_kategori)) {
                                $chart_kategori_label[] = $r['nama'];
                                $chart_kategori_data[]  = (int) $r['jumlah'];
                            }
                        }
                    } catch (mysqli_sql_exception $e) {
                        // Query gagal (nama kolom tidak cocok) - grafik ditampilkan kosong, tidak menghentikan halaman
                        $chart_kategori_label = [];
                        $chart_kategori_data  = [];
                    }
                }

                // ==========================================
                // DATA GRAFIK 2: PEMINJAMAN BUKU PER BULAN (TAHUN INI)
                // ==========================================
                $chart_pinjam_label = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                $chart_pinjam_data  = array_fill(0, 12, 0);

                // Deteksi otomatis nama kolom tanggal peminjaman
                // (mencari kolom apa saja yang namanya mengandung kata "tanggal" atau "tgl")
                $kolom_tgl_pinjam = null;
                $cols_peminjaman = mysqli_query($koneksi, "SHOW COLUMNS FROM peminjaman");
                if ($cols_peminjaman) {
                    while ($c = mysqli_fetch_assoc($cols_peminjaman)) {
                        $f = $c['Field'];
                        if (stripos($f, 'tanggal') !== false || stripos($f, 'tgl') !== false) {
                            // Prioritaskan kolom yang berkaitan dengan "pinjam"
                            if (stripos($f, 'pinjam') !== false) {
                                $kolom_tgl_pinjam = $f;
                                break;
                            }
                            if ($kolom_tgl_pinjam === null) {
                                $kolom_tgl_pinjam = $f;
                            }
                        }
                    }
                }

                if ($kolom_tgl_pinjam) {
                    try {
                        $sql_chart_pinjam = "SELECT MONTH($kolom_tgl_pinjam) AS bulan, COUNT(*) AS jumlah
                                             FROM peminjaman
                                             WHERE YEAR($kolom_tgl_pinjam) = YEAR(CURDATE())
                                             GROUP BY MONTH($kolom_tgl_pinjam)";
                        $q_chart_pinjam = mysqli_query($koneksi, $sql_chart_pinjam);
                        if ($q_chart_pinjam) {
                            while ($r = mysqli_fetch_assoc($q_chart_pinjam)) {
                                $idx = ((int) $r['bulan']) - 1;
                                if ($idx >= 0 && $idx < 12) {
                                    $chart_pinjam_data[$idx] = (int) $r['jumlah'];
                                }
                            }
                        }
                    } catch (mysqli_sql_exception $e) {
                        // Query gagal (nama kolom tidak cocok) - grafik ditampilkan kosong (0), tidak menghentikan halaman
                        $chart_pinjam_data = array_fill(0, 12, 0);
                    }
                }
                ?>
                
                <div style="margin-bottom: 35px;">
                    <h1 style="font-size: 28px; font-weight: 800; color: #212529; margin-bottom: 6px;">Dashboard Admin</h1>
                </div>
                
                <div class="row g-4">
                    <div class="col-xl-3 col-md-6">
                        <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            <div>
                                <span style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 700; letter-spacing: 0.5px;">Total Buku</span>
                                <h2 style="font-size: 36px; font-weight: 800; color: #212529 !important; margin-top: 5px; margin-bottom: 0;"><?= $d_buku['total'] ?? 0; ?></h2>
                            </div>
                            <div style="width: 50px; height: 50px; background: rgba(58,134,255,0.1); color: #3a86ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-book"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-6">
                        <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            <div>
                                <span style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 700; letter-spacing: 0.5px;">Total Penerbit</span>
                                <h2 style="font-size: 36px; font-weight: 800; color: #212529 !important; margin-top: 5px; margin-bottom: 0;"><?= $d_penerbit['total'] ?? 0; ?></h2>
                            </div>
                            <div style="width: 50px; height: 50px; background: rgba(201,122,62,0.1); color: #c97a3e; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-building"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            <div>
                                <span style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 700; letter-spacing: 0.5px;">Total Penulis</span>
                                <h2 style="font-size: 36px; font-weight: 800; color: #212529 !important; margin-top: 5px; margin-bottom: 0;"><?= $d_penulis['total'] ?? 0; ?></h2>
                            </div>
                            <div style="width: 50px; height: 50px; background: rgba(25,135,84,0.1); color: #198754; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                            <div>
                                <span style="font-size: 12px; text-transform: uppercase; color: #6c757d; font-weight: 700; letter-spacing: 0.5px;">Total Kategori</span>
                                <h2 style="font-size: 36px; font-weight: 800; color: #212529 !important; margin-top: 5px; margin-bottom: 0;"><?= $d_kategori['total'] ?? 0; ?></h2>
                            </div>
                            <div style="width: 50px; height: 50px; background: rgba(255,183,3,0.1); color: #ffb703; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4" style="margin-top: 4px;">
                    <div class="col-xl-6">
                        <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); height: 100%;">
                            <h3 style="font-size: 16px; font-weight: 800; color: #212529; margin-bottom: 18px;">Jumlah Buku per Kategori</h3>
                            <?php if (empty($chart_kategori_label)): ?>
                                <p style="color: #6c757d; font-size: 13px; margin: 0;">Data kategori belum tersedia untuk ditampilkan dalam grafik.</p>
                            <?php else: ?>
                                <canvas id="chartKategori" height="220"></canvas>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div style="background: #fff; border: 1px solid #dee2e6; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); height: 100%;">
                            <h3 style="font-size: 16px; font-weight: 800; color: #212529; margin-bottom: 18px;">Peminjaman Buku per Bulan (<?= date('Y'); ?>)</h3>
                            <?php if (!$kolom_tgl_pinjam): ?>
                                <p style="color: #6c757d; font-size: 13px; margin: 0;">Data peminjaman belum tersedia untuk ditampilkan dalam grafik.</p>
                            <?php else: ?>
                                <canvas id="chartPeminjaman" height="220"></canvas>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const ctxKategori = document.getElementById('chartKategori');
                    if (ctxKategori) {
                        new Chart(ctxKategori, {
                            type: 'bar',
                            data: {
                                labels: <?= json_encode($chart_kategori_label, JSON_UNESCAPED_UNICODE); ?>,
                                datasets: [{
                                    label: 'Jumlah Buku',
                                    data: <?= json_encode($chart_kategori_data); ?>,
                                    backgroundColor: '#3a86ff',
                                    borderRadius: 6,
                                    maxBarThickness: 40
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: { beginAtZero: true, ticks: { precision: 0 } }
                                }
                            }
                        });
                    }

                    const ctxPinjam = document.getElementById('chartPeminjaman');
                    if (ctxPinjam) {
                        new Chart(ctxPinjam, {
                            type: 'line',
                            data: {
                                labels: <?= json_encode($chart_pinjam_label); ?>,
                                datasets: [{
                                    label: 'Jumlah Peminjaman',
                                    data: <?= json_encode($chart_pinjam_data); ?>,
                                    borderColor: '#c97a3e',
                                    backgroundColor: 'rgba(201,122,62,0.12)',
                                    fill: true,
                                    tension: 0.35,
                                    pointBackgroundColor: '#c97a3e'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: { legend: { display: false } },
                                scales: {
                                    y: { beginAtZero: true, ticks: { precision: 0 } }
                                }
                            }
                        });
                    }
                });
                </script>
                <?php
                break;
        }
        ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bundle.min.js"></script>
</body>
</html>