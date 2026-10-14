<?php
// ============================================
// LAPORAN BUKU MASUK PER PERIODE
// Filter berdasarkan rentang tanggal, langsung bisa dicetak
// ============================================

if (!isset($koneksi) || !$koneksi) {
    die('<div style="padding:20px;background:#fee2e2;border:1px solid #ef4444;color:#991b1b;border-radius:8px;">
        <strong>Error:</strong> Koneksi database ($koneksi) tidak tersedia.
    </div>');
}

$dari   = isset($_GET['dari']) ? trim($_GET['dari']) : '';
$sampai = isset($_GET['sampai']) ? trim($_GET['sampai']) : '';
$sudah_filter = ($dari !== '' && $sampai !== '');

$result = null;
$query_error = '';
$total_transaksi = 0;
$total_buku_keseluruhan = 0;

if ($sudah_filter) {
    $query = "SELECT bm.buku_masuk_id, bm.tgl_masuk, p.penerbit_nama AS nama_penerbit,
                     COALESCE(SUM(bmd.jumlah), 0) AS total_buku
              FROM buku_masuk bm
              LEFT JOIN penerbit p ON bm.penerbit_id = p.penerbit_id
              LEFT JOIN buku_masuk_detail bmd ON bm.buku_masuk_id = bmd.buku_masuk_id
              WHERE bm.tgl_masuk BETWEEN ? AND ?
              GROUP BY bm.buku_masuk_id, bm.tgl_masuk, p.penerbit_nama
              ORDER BY bm.tgl_masuk ASC";

    $stmt = mysqli_prepare($koneksi, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $dari, $sampai);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $query_error = mysqli_error($koneksi);
    }
}
?>

<div style="padding:24px;" class="area-laporan">

    <div style="margin-bottom:24px;" class="hide-print">
        <h2 style="margin:0 0 8px 0;font-size:24px;color:#1a1a2e;">
            <i class="fa-solid fa-calendar-days" style="color:#3a86ff;"></i>
            Laporan Buku Masuk Per Periode
        </h2>
        <p style="margin:0;color:#6e7681;font-size:14px;">Cetak laporan buku masuk berdasarkan rentang tanggal transaksi</p>
    </div>

    <!-- FORM FILTER -->
    <div class="hide-print" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;margin-bottom:24px;">
        <div style="padding:14px 20px;background:#1a1a2e;">
            <h3 style="margin:0;font-size:16px;color:#fff;font-weight:700;">Cetak Per Periode Tanggal</h3>
        </div>
        <form method="GET" action="indeks.php" style="padding:20px;display:flex;flex-wrap:wrap;gap:16px;align-items:flex-end;">
            <input type="hidden" name="page" value="laporan">
            <input type="hidden" name="sub" value="per_periode">
            <div style="flex:1;min-width:180px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#6e7681;margin-bottom:6px;">Dari Tanggal</label>
                <input type="date" name="dari" value="<?= htmlspecialchars($dari) ?>" required
                       style="width:100%;padding:10px 14px;border:1px solid #d0d7de;border-radius:10px;font-size:14px;background:#f6f8fa;">
            </div>
            <div style="flex:1;min-width:180px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#6e7681;margin-bottom:6px;">Sampai Tanggal</label>
                <input type="date" name="sampai" value="<?= htmlspecialchars($sampai) ?>" required
                       style="width:100%;padding:10px 14px;border:1px solid #d0d7de;border-radius:10px;font-size:14px;background:#f6f8fa;">
            </div>
            <div>
                <button type="submit" style="padding:10px 24px;background:#10b981;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;">
                    <i class="fa-solid fa-print"></i> Cetak Laporan
                </button>
            </div>
        </form>
    </div>

    <?php if (!empty($query_error)) : ?>
        <div style="padding:16px;background:#fef3c7;border:1px solid #f59e0b;color:#92400e;border-radius:8px;margin-bottom:16px;">
            <strong>Query Error:</strong> <?= htmlspecialchars($query_error) ?>
        </div>
    <?php endif; ?>

    <?php if ($sudah_filter) : ?>

        <!-- ============ AREA YANG DICETAK ============ -->
        <div class="area-cetak">

        <!-- KOP CETAK -->
        <div class="kop-cetak" style="display:none;text-align:center;margin-bottom:16px;">
            <h3 style="margin:0;">LAPORAN BUKU MASUK</h3>
            <p style="margin:0;">Periode: <?= date('Y-m-d', strtotime($dari)) ?> s/d <?= date('Y-m-d', strtotime($sampai)) ?></p>
        </div>

        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="background:#f6f8fa;">
                        <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">No</th>
                        <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">ID Transaksi</th>
                        <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">Tanggal</th>
                        <th style="padding:12px;text-align:left;border-bottom:2px solid #e1e4e8;">Penerbit</th>
                        <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">Total Buku</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0) : $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) :
                            $total_transaksi++;
                            $total_buku_keseluruhan += (int)$row['total_buku'];
                        ?>
                            <tr style="border-bottom:1px solid #e1e4e8;">
                                <td style="padding:10px 12px;text-align:center;"><?= $no++ ?></td>
                                <td style="padding:10px 12px;text-align:center;font-weight:700;color:#3a86ff;"><?= htmlspecialchars($row['buku_masuk_id']) ?></td>
                                <td style="padding:10px 12px;text-align:center;"><?= date('d-m-Y', strtotime($row['tgl_masuk'])) ?></td>
                                <td style="padding:10px 12px;"><?= htmlspecialchars($row['nama_penerbit'] ?? '-') ?></td>
                                <td style="padding:10px 12px;text-align:center;"><?= (int)$row['total_buku'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr><td colspan="5" style="padding:32px;text-align:center;color:#8b949e;">Tidak ada transaksi pada periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
                <?php if ($total_transaksi > 0) : ?>
                <tfoot>
                    <tr style="background:#f6f8fa;font-weight:700;">
                        <td colspan="4" style="padding:12px;text-align:right;">Total Keseluruhan</td>
                        <td style="padding:12px;text-align:center;"><?= $total_buku_keseluruhan ?></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>

        <div class="ttd-cetak" style="display:none;text-align:right;margin-top:40px;font-size:14px;">
            <p style="margin:0;">Banda Aceh, <?= date('d-m-Y') ?></p>
            <p style="margin:60px 0 0 0;font-weight:700;text-decoration:underline;">Kepala Perpustakaan</p>
        </div>

        </div>
        <!-- ============ AKHIR AREA YANG DICETAK ============ -->

        <div class="hide-print" style="margin-top:20px;">
            <button type="button" onclick="window.print()" style="padding:10px 20px;background:#10b981;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;">
                <i class="fa-solid fa-print"></i> Cetak
            </button>
        </div>

    <?php endif; ?>
</div>

<style>
    @media print {
        /* Sembunyikan SEMUA isi halaman (sidebar, header, tab menu, form filter, dsb) */
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
