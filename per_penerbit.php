<?php
// ============================================
// LAPORAN BUKU MASUK PER PENERBIT
// Pilih penerbit dari dropdown, tampilkan daftar transaksinya,
// lalu bisa lihat Detail dan Cetak per transaksi.
// ============================================

if (!isset($koneksi) || !$koneksi) {
    die('<div style="padding:20px;background:#fee2e2;border:1px solid #ef4444;color:#991b1b;border-radius:8px;">
        <strong>Error:</strong> Koneksi database ($koneksi) tidak tersedia.
    </div>');
}

// --- DROPDOWN PENERBIT (diurutkan dari ID terbesar ke terkecil, sesuai spesifikasi) ---
$daftar_penerbit = [];
$q_penerbit = mysqli_query($koneksi, "SELECT penerbit_id, penerbit_nama FROM penerbit ORDER BY penerbit_id DESC");
if ($q_penerbit) {
    while ($p = mysqli_fetch_assoc($q_penerbit)) {
        $daftar_penerbit[] = $p;
    }
}

$penerbit_id = isset($_GET['penerbit_id']) ? trim($_GET['penerbit_id']) : '';
$sudah_pilih = ($penerbit_id !== '');

$result = null;
$query_error = '';
$nama_penerbit_terpilih = '';

if ($sudah_pilih) {
    $stmt = mysqli_prepare($koneksi, "SELECT bm.buku_masuk_id, bm.tgl_masuk,
                                              COALESCE(SUM(bmd.jumlah), 0) AS total_buku
                                       FROM buku_masuk bm
                                       LEFT JOIN buku_masuk_detail bmd ON bm.buku_masuk_id = bmd.buku_masuk_id
                                       WHERE bm.penerbit_id = ?
                                       GROUP BY bm.buku_masuk_id, bm.tgl_masuk
                                       ORDER BY bm.tgl_masuk DESC");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $penerbit_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $query_error = mysqli_error($koneksi);
    }

    foreach ($daftar_penerbit as $p) {
        if ($p['penerbit_id'] == $penerbit_id) {
            $nama_penerbit_terpilih = $p['penerbit_nama'];
            break;
        }
    }
}
?>

<div style="padding:24px;">

    <div style="margin-bottom:24px;">
        <h2 style="margin:0 0 8px 0;font-size:24px;color:#1a1a2e;">
            <i class="fa-solid fa-building" style="color:#3a86ff;"></i>
            Laporan Buku Masuk Per Penerbit
        </h2>
        <p style="margin:0;color:#6e7681;font-size:14px;">Pilih penerbit untuk melihat riwayat transaksi buku masuk</p>
    </div>

    <!-- FORM PILIH PENERBIT -->
    <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;margin-bottom:24px;">
        <div style="padding:14px 20px;background:#1a1a2e;">
            <h3 style="margin:0;font-size:16px;color:#fff;font-weight:700;">Pilih Penerbit</h3>
        </div>
        <form method="GET" action="indeks.php" style="padding:20px;display:flex;flex-wrap:wrap;gap:16px;align-items:flex-end;">
            <input type="hidden" name="page" value="laporan">
            <input type="hidden" name="sub" value="per_penerbit">
            <div style="flex:1;min-width:220px;">
                <select name="penerbit_id" required
                        style="width:100%;padding:10px 14px;border:1px solid #d0d7de;border-radius:10px;font-size:14px;background:#f6f8fa;">
                    <option value="">-- Pilih Penerbit --</option>
                    <?php foreach ($daftar_penerbit as $p) : ?>
                        <option value="<?= htmlspecialchars($p['penerbit_id']) ?>" <?= ($penerbit_id == $p['penerbit_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['penerbit_id'] . ' - ' . $p['penerbit_nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <button type="submit" style="padding:10px 24px;background:#3a86ff;color:#fff;border:none;border-radius:10px;font-weight:600;cursor:pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                </button>
            </div>
            <div>
                <a href="indeks.php?page=laporan&sub=per_penerbit"
                   style="display:inline-block;padding:10px 20px;background:#6b7280;color:#fff;border-radius:10px;font-weight:600;text-decoration:none;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <?php if (!empty($query_error)) : ?>
        <div style="padding:16px;background:#fef3c7;border:1px solid #f59e0b;color:#92400e;border-radius:8px;margin-bottom:16px;">
            <strong>Query Error:</strong> <?= htmlspecialchars($query_error) ?>
        </div>
    <?php endif; ?>

    <?php if ($sudah_pilih) : ?>
        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;">
            <div style="padding:14px 20px;background:#f59e0b;">
                <h3 style="margin:0;font-size:16px;color:#fff;font-weight:700;">
                    Daftar Transaksi Buku Masuk — <?= htmlspecialchars($nama_penerbit_terpilih ?: $penerbit_id) ?>
                </h3>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="background:#f6f8fa;">
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">No</th>
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">ID Transaksi</th>
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">Tanggal</th>
                            <th style="padding:12px;text-align:left;border-bottom:2px solid #e1e4e8;">Penerbit</th>
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">Total Buku</th>
                            <th style="padding:12px;text-align:center;border-bottom:2px solid #e1e4e8;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0) : $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr style="border-bottom:1px solid #e1e4e8;">
                                    <td style="padding:10px 12px;text-align:center;"><?= $no++ ?></td>
                                    <td style="padding:10px 12px;text-align:center;font-weight:700;color:#3a86ff;"><?= htmlspecialchars($row['buku_masuk_id']) ?></td>
                                    <td style="padding:10px 12px;text-align:center;"><?= date('d-m-Y', strtotime($row['tgl_masuk'])) ?></td>
                                    <td style="padding:10px 12px;"><?= htmlspecialchars($nama_penerbit_terpilih) ?></td>
                                    <td style="padding:10px 12px;text-align:center;"><?= (int)$row['total_buku'] ?></td>
                                    <td style="padding:10px 12px;text-align:center;">
                                        <a href="indeks.php?page=laporan&sub=detail&id=<?= urlencode($row['buku_masuk_id']) ?>"
                                           style="display:inline-block;padding:6px 14px;background:#06b6d4;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr><td colspan="6" style="padding:32px;text-align:center;color:#8b949e;">Belum ada transaksi buku masuk untuk penerbit ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>
