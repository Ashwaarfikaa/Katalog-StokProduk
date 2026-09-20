<?php
// PROCESSING LAYER: logika bisnis dan fungsi bantu

const BATAS_STOK_KRITIS = 3; // stok di bawah angka ini dianggap kritis

// Menghitung total nilai aset gudang (harga x stok, dijumlahkan)
function hitungTotalNilaiStok(array $products): int
{
    $total = 0;
    foreach ($products as $produk) {
        $total += $produk["harga"] * $produk["stok"];
    }
    return $total;
}

// Menghitung jumlah produk dengan stok kritis
function hitungProdukKritis(array $products): int
{
    $jumlah = 0;
    foreach ($products as $produk) {
        if ($produk["stok"] < BATAS_STOK_KRITIS) {
            $jumlah++;
        }
    }
    return $jumlah;
}

// Logika kondisional: menentukan kelas CSS baris tabel
function kelasBarisStok(int $stok): string
{
    if ($stok < BATAS_STOK_KRITIS) {
        return "stok-kritis";
    }
    return "";
}

// Label teks status agar tidak hanya bergantung pada warna
function labelStatusStok(int $stok): string
{
    if ($stok < BATAS_STOK_KRITIS) {
        return "Kritis";
    }
    return "Aman";
}

function formatRupiah(int $angka): string
{
    return "Rp " . number_format($angka, 0, ",", ".");
}

// Mengamankan teks sebelum dicetak ke HTML
function e(string $teks): string
{
    return htmlspecialchars($teks, ENT_QUOTES, "UTF-8");
}
