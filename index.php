<?php
// PRESENTATION LAYER: merangkai data dan fungsi, lalu merender HTML
require_once 'products.php';
require_once 'functions.php';

$totalNilai   = hitungTotalNilaiStok($products);
$jumlahProduk = count($products);
$jumlahKritis = hitungProdukKritis($products);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Information System</title>
    <style>
        :root {
            --paper: #f4f7f6;
            --surface: #ffffff;
            --ink: #14302a;
            --muted: #5c706b;
            --line: #d3dedb;
            --accent: #0f6b5c;
            --crit-bg: #fdeae4;
            --crit-ink: #a3241a;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
            line-height: 1.5;
        }
        .wrap { max-width: 1040px; margin: 0 auto; padding: 48px 20px 64px; }
        h1 { margin: 0 0 4px; font-size: 1.75rem; letter-spacing: -0.01em; }
        .sub { margin: 0 0 32px; color: var(--muted); }

        .summary {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            border: 1px solid var(--line);
            background: var(--surface);
            margin-bottom: 32px;
        }
        .summary div { padding: 20px 24px; }
        .summary div + div { border-left: 1px solid var(--line); }
        .summary dt { margin: 0; color: var(--muted); font-size: .9rem; }
        .summary dd { margin: 4px 0 0; font-size: 1.5rem; font-weight: 600; font-variant-numeric: tabular-nums; }
        .summary .total dd { font-size: 2.25rem; color: var(--accent); }
        .summary .warn dd { color: var(--crit-ink); }

        .table-scroll { overflow-x: auto; border: 1px solid var(--line); background: var(--surface); }
        table { width: 100%; border-collapse: collapse; min-width: 760px; }
        th, td { padding: 12px 16px; text-align: left; vertical-align: top; border-bottom: 1px solid var(--line); }
        th { background: var(--ink); color: #fff; font-weight: 600; font-size: .9rem; white-space: nowrap; }
        tbody tr:last-child td { border-bottom: 0; }
        td.num { text-align: right; font-variant-numeric: tabular-nums; white-space: nowrap; }
        th.num { text-align: right; }
        td.desc { color: var(--muted); font-size: .92rem; }

        tr.stok-kritis td { background: var(--crit-bg); }
        tr.stok-kritis td:first-child { box-shadow: inset 4px 0 0 var(--crit-ink); }
        .status { font-weight: 600; font-size: .85rem; }
        .stok-kritis .status { color: var(--crit-ink); }
        .stok-kritis .status::before { content: "\26A0\FE0F\00a0"; }
        tr:not(.stok-kritis) .status { color: var(--accent); }

        .note { margin-top: 16px; color: var(--muted); font-size: .9rem; }

        @media (max-width: 640px) {
            .summary { grid-template-columns: 1fr; }
            .summary div + div { border-left: 0; border-top: 1px solid var(--line); }
        }
    </style>
</head>
<body>
<main class="wrap">
    <h1>Product Information System</h1>
    <p class="sub">Data stok gudang dan nilai persediaan saat ini.</p>

    <dl class="summary">
        <div class="total">
            <dt>Total nilai stok</dt>
            <dd><?= e(formatRupiah($totalNilai)) ?></dd>
        </div>
        <div>
            <dt>Jumlah produk</dt>
            <dd><?= $jumlahProduk ?></dd>
        </div>
        <div class="warn">
            <dt>Stok kritis</dt>
            <dd><?= $jumlahKritis ?></dd>
        </div>
    </dl>

    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th class="num">Harga</th>
                    <th class="num">Stok</th>
                    <th>Status</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $produk): ?>
                <tr class="<?= kelasBarisStok($produk["stok"]) ?>">
                    <td><?= $produk["id"] ?></td>
                    <td><?= e($produk["nama"]) ?></td>
                    <td><?= e($produk["kategori"]) ?></td>
                    <td class="num"><?= e(formatRupiah($produk["harga"])) ?></td>
                    <td class="num"><?= $produk["stok"] ?></td>
                    <td><span class="status"><?= labelStatusStok($produk["stok"]) ?></span></td>
                    <td class="desc"><?= e($produk["deskripsi"]) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <p class="note">Stok di bawah <?= BATAS_STOK_KRITIS ?> unit ditandai kritis.</p>
</main>
</body>
</html>
