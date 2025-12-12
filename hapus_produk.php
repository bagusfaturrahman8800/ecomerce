<?php
session_start();

// Cek apakah user sudah login dan merupakan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak. Hanya admin yang bisa menghapus produk.'); window.location='mobil.php';</script>";
    exit;
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_tirta");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Validasi ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<script>alert('ID produk tidak valid.'); window.location='mobil.php';</script>";
    exit;
}

// Query untuk menghapus produk
$query = "DELETE FROM produk WHERE id = $id";
if (mysqli_query($conn, $query)) {
    echo "<script>alert('Produk berhasil dihapus.'); window.location='mobil.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk.'); window.location='mobil.php';</script>";
}

// Tutup koneksi
mysqli_close($conn);
?>
