<?php
// ============================================
// LAPORAN BUKU MASUK
// Menampilkan daftar seluruh transaksi buku masuk
// ============================================
//
// ASUMSI NAMA TABEL & KOLOM (sesuaikan jika berbeda dengan database anda):
//   buku_masuk        : buku_masuk_id, penerbit_id, tgl_masuk, keterangan, petugas_id
//   buku_masuk_detail : id, buku_masuk_id, buku_ISBN, jumlah
//   penerbit          : penerbit_id, penerbit_nama
//
// $koneksi (mysqli) harus sudah tersedia dari indeks.php sebelum file ini di-include.

if (!isset($koneksi) || !$koneksi) {
    die('<div style="padding:20px;background:#fee2e2;border:1px solid #ef4444;color:#991b1b;border-radius:8px;">
        <strong>Error:</strong> Koneksi database ($koneksi) tidak tersedia.
    </div>');
}

// --- QUERY: daftar transaksi buku masuk (agregat per transaksi) ---
$query = "SELECT bm.buku_masuk_id,
                 bm.tgl_masuk,
                 bm.keterangan,
                 p.penerbit_nama AS nama_penerbit,
                 COUNT(bmd.id) AS jumlah_judul,
                 COALESCE(SUM(bmd.jumlah), 0) AS total_buku
          FROM buku_masuk bm
          LEFT JOIN penerbit p ON bm.penerbit_id = p.penerbit_id
          LEFT JOIN buku_masuk_detail bmd ON bm.buku_masuk_id = bmd.buku_masuk_id
          GROUP BY bm.buku_masuk_id, bm.tgl_masuk, bm.keterangan, p.penerbit_nama
          ORDER BY bm.tgl_masuk DESC";

$result = mysqli_query($koneksi, $query);
$query_error = $result ? '' : mysqli_error($koneksi);
?>

<div style="padding:24px;">

    <!-- HEADER -->
    <div style="margin-bottom:24px;">
        <h2 style="margin:0 0 8px 0;font-size:24px;color:#1a1a2e;">
            <i class="fa-solid fa-file-lines" style="color:#3a86ff;"></i>
            Laporan Buku Masuk
        </h2>
        <p style="margin:0;color:#6e7681;font-size:14px;">
            Daftar seluruh transaksi buku masuk yang tercatat di sistem
        </p>
    </div>

    <?php if (!empty($query_error)) : ?>
        <div style="padding:16px;background:#fef3c7;border:1px solid #f59e0b;color:#92400e;border-radius:8px;margin-bottom:16px;">
            <strong>Query Error:</strong> <?= htmlspecialchars($query_error) ?>
        </div>
    <?php endif; ?>

    <!-- TABEL LAPORAN -->
    <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid #e1e4e8;">
        <div style="padding:14px 20px;background:#f59e0b;">
            <h3 style="margin:0;font-size:16px;color:#fff;font-weight:700;">
                <i class="fa-solid fa-table" style="margin-right:8px;"></i>Tabel Laporan Buku Masuk
            </h3>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="background:#f6f8fa;">
                        <th style="padding:14px 12px;text-align:center;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">No</th>
                        <th style="padding:14px 12px;text-align:center;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">ID Transaksi</th>
                        <th style="padding:14px 12px;text-align:left;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">Penerbit</th>
                        <th style="padding:14px 12px;text-align:center;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">Tanggal</th>
                        <th style="padding:14px 12px;text-align:center;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">Jumlah Judul</th>
                        <th style="padding:14px 12px;text-align:center;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">Total Buku Masuk</th>
                        <th style="padding:14px 12px;text-align:center;font-weight:700;color:#6e7681;font-size:12px;text-transform:uppercase;border-bottom:2px solid #e1e4e8;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; if ($result && mysqli_num_rows($result) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr style="border-bottom:1px solid #e1e4e8;">
                                <td style="padding:12px;text-align:center;color:#6e7681;font-weight:600;"><?= $no++ ?></td>
                                <td style="padding:12px;text-align:center;color:#3a86ff;font-weight:700;"><?= htmlspecialchars($row['buku_masuk_id']) ?></td>
                                <td style="padding:12px;color:#1a1a2e;"><?= htmlspecialchars($row['nama_penerbit'] ?? '-') ?></td>
                                <td style="padding:12px;text-align:center;color:#4a4a5a;white-space:nowrap;">
                                    <?= !empty($row['tgl_masuk']) ? date('d-m-Y', strtotime($row['tgl_masuk'])) : '-' ?>
                                </td>
                                <td style="padding:12px;text-align:center;color:#4a4a5a;"><?= (int)$row['jumlah_judul'] ?></td>
                                <td style="padding:12px;text-align:center;">
                                    <span style="display:inline-block;padding:4px 12px;background:#d1fae5;color:#065f46;border-radius:20px;font-weight:700;"><?= (int)$row['total_buku'] ?></span>
                                </td>
                                <td style="padding:12px;text-align:center;">
                                    <a href="indeks.php?page=laporan&sub=detail&id=<?= urlencode($row['buku_masuk_id']) ?>"
                                       style="display:inline-block;padding:6px 14px;background:#06b6d4;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" style="padding:40px;text-align:center;color:#8b949e;">
                                <i class="fa-solid fa-inbox" style="font-size:40px;display:block;margin-bottom:12px;color:#d0d7de;"></i>
                                Belum ada data transaksi buku masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
