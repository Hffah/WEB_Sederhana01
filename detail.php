<?php
// ============================================
// DETAIL LAPORAN BUKU MASUK (+ tombol Cetak)
// Dipakai oleh: buku_masuk.php dan per_penerbit.php (sub-halaman modul laporan)
// Akses: indeks.php?page=laporan&sub=detail&id=BM2601001
// ============================================

if (!isset($koneksi) || !$koneksi) {
    die('<div style="padding:20px;background:#fee2e2;border:1px solid #ef4444;color:#991b1b;border-radius:8px;">
        <strong>Error:</strong> Koneksi database ($koneksi) tidak tersedia.
    </div>');
}

$id_transaksi = isset($_GET['id']) ? $_GET['id'] : '';

// --- HEADER TRANSAKSI ---
$header = null;
if ($id_transaksi !== '') {
    // Catatan: tabel petugas belum ada di database, jadi petugas_id ditampilkan apa adanya
    $stmt = mysqli_prepare($koneksi, "SELECT bm.buku_masuk_id, bm.tgl_masuk, bm.keterangan,
                                              bm.penerbit_id, p.penerbit_nama AS nama_penerbit,
                                              bm.petugas_id
                                       FROM buku_masuk bm
                                       LEFT JOIN penerbit p ON bm.penerbit_id = p.penerbit_id
                                       WHERE bm.buku_masuk_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $id_transaksi);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $header = $res ? mysqli_fetch_assoc($res) : null;
    }
}

// --- DETAIL BUKU DALAM TRANSAKSI ---
$items = [];
$total_buku = 0;
if ($header) {
    $stmt2 = mysqli_prepare($koneksi, "SELECT bmd.buku_ISBN, b.buku_judul, bmd.jumlah
                                        FROM buku_masuk_detail bmd
                                        LEFT JOIN buku b ON bmd.buku_ISBN = b.buku_id
                                        WHERE bmd.buku_masuk_id = ?");
    if ($stmt2) {
        mysqli_stmt_bind_param($stmt2, "s", $id_transaksi);
        mysqli_stmt_execute($stmt2);
        $res2 = mysqli_stmt_get_result($stmt2);
        while ($r = mysqli_fetch_assoc($res2)) {
            $items[] = $r;
            $total_buku += (int)$r['jumlah'];
        }
    }
}
?>

<div style="padding:24px;" class="area-laporan">

    <div style="margin-bottom:24px;" class="hide-print">
        <h2 style="margin:0 0 8px 0;font-size:24px;color:#1a1a2e;">
            <i class="fa-solid fa-file-invoice" style="color:#3a86ff;"></i>
            Detail Laporan Buku Masuk
        </h2>
    </div>

    <?php if (!$header) : ?>
        <div style="padding:16px;background:#fee2e2;border:1px solid #ef4444;color:#991b1b;border-radius:8px;">
            Transaksi dengan ID <strong><?= htmlspecialchars($id_transaksi) ?></strong> tidak ditemukan.
        </div>
    <?php else : ?>

        <!-- ============ AREA YANG DICETAK ============ -->
        <div class="area-cetak">

        <!-- KOP CETAK (hanya tampil saat print) -->
        <div class="kop-cetak" style="display:none;text-align:center;margin-bottom:16px;">
            <h3 style="margin:0;">PUSTAKA UIN AR-RANIRY</h3>
            <p style="margin:0;font-weight:700;">LAPORAN BUKU MASUK</p>
        </div>

        <!-- INFO TRANSAKSI -->
        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;margin-bottom:20px;">
            <div style="padding:14px 20px;background:#06b6d4;">
                <h3 style="margin:0;font-size:16px;color:#fff;font-weight:700;">Detail Transaksi Buku Masuk</h3>
            </div>
            <div style="padding:18px 20px;display:grid;grid-template-columns:1fr 1fr;gap:8px 24px;font-size:14px;">
                <div><strong>ID Buku Masuk :</strong> <?= htmlspecialchars($header['buku_masuk_id']) ?></div>
                <div><strong>Petugas :</strong> <?= htmlspecialchars($header['petugas_id'] ?? '-') ?></div>
                <div><strong>Penerbit ID :</strong> <?= htmlspecialchars($header['penerbit_id']) ?></div>
                <div><strong>Keterangan :</strong> <?= htmlspecialchars($header['keterangan'] ?? '-') ?></div>
                <div><strong>Nama Penerbit :</strong> <?= htmlspecialchars($header['nama_penerbit'] ?? '-') ?></div>
                <div><strong>Tanggal :</strong> <?= !empty($header['tgl_masuk']) ? date('d-m-Y', strtotime($header['tgl_masuk'])) : '-' ?></div>
            </div>
        </div>

        <!-- DAFTAR BUKU DALAM TRANSAKSI -->
        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;">
            <div style="padding:14px 20px;background:#1a1a2e;">
                <h3 style="margin:0;font-size:16px;color:#fff;font-weight:700;">Daftar Buku Masuk</h3>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="background:#f6f8fa;">
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">No</th>
                            <th style="padding:12px;text-align:left;border-bottom:2px solid #e1e4e8;">ISBN Buku</th>
                            <th style="padding:12px;text-align:left;border-bottom:2px solid #e1e4e8;">Judul Buku</th>
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)) : $no = 1; foreach ($items as $it) : ?>
                            <tr style="border-bottom:1px solid #e1e4e8;">
                                <td style="padding:10px 12px;text-align:center;"><?= $no++ ?></td>
                                <td style="padding:10px 12px;"><?= htmlspecialchars($it['buku_ISBN']) ?></td>
                                <td style="padding:10px 12px;"><?= htmlspecialchars($it['buku_judul'] ?? '-') ?></td>
                                <td style="padding:10px 12px;text-align:center;"><?= (int)$it['jumlah'] ?></td>
                            </tr>
                        <?php endforeach; else : ?>
                            <tr><td colspan="4" style="padding:24px;text-align:center;color:#8b949e;">Tidak ada detail buku pada transaksi ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background:#f6f8fa;font-weight:700;">
                            <td colspan="3" style="padding:12px;text-align:right;">Total Buku Masuk</td>
                            <td style="padding:12px;text-align:center;"><?= $total_buku ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- TANDA TANGAN (hanya tampil saat print) -->
        <div class="ttd-cetak" style="display:none;text-align:right;margin-top:40px;font-size:14px;">
            <p style="margin:0;">Banda Aceh, <?= date('d-m-Y') ?></p>
            <p style="margin:60px 0 0 0;font-weight:700;text-decoration:underline;">Kepala Perpustakaan</p>
        </div>

        </div>
        <!-- ============ AKHIR AREA YANG DICETAK ============ -->

        <!-- TOMBOL AKSI -->
        <div class="hide-print" style="margin-top:20px;display:flex;gap:12px;">
            <a href="javascript:history.back()" style="padding:10px 20px;background:#374151;color:#fff;border-radius:10px;text-decoration:none;font-weight:600;">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button type="button" onclick="window.print()" style="padding:10px 20px;background:#10b981;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
        </div>

    <?php endif; ?>
</div>

<style>
    @media print {
        /* Sembunyikan SEMUA isi halaman (sidebar, header, tab menu, dsb) */
        body * { visibility: hidden; }

        /* Munculkan hanya area cetak beserta seluruh isinya */
        .area-cetak, .area-cetak * { visibility: visible; }

        .area-cetak {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px;
        }

        .kop-cetak, .ttd-cetak { display: block !important; }
        .hide-print { display: none !important; }
        body { background: #fff !important; }
    }
</style>
