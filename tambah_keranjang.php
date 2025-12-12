<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$id_produk = $_GET['id'];
$qty = 1;

// Ambil data produk dari database
$stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: shop.php?error=notfound");
    exit;
}

$produk = $result->fetch_assoc();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Cek apakah produk sudah ada di keranjang (berdasarkan id_produk)
$found = false;
foreach ($_SESSION['keranjang'] as &$item) {
    if ($item['id_produk'] == $id_produk) {
        $item['qty'] += $qty;
        $found = true;
        break;
    }
}
unset($item); // untuk menghindari reference bug

if (!$found) {
    $_SESSION['keranjang'][] = [
        'id_produk' => $produk['id_produk'],
        'mobil' => $produk['nama'],
        'warna' => $produk['warna'] ?? '-',
        'qty' => $qty,
        'harga' => $produk['harga'],
        'gambar' => $produk['gambar']
    ];
}

header("Location: keranjang.php");
exit;
?>
