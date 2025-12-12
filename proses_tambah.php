<?php
session_start();

include 'koneksi.php'; // Pastikan ini file koneksi yang kamu pakai

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='index.php';</script>";
    exit;
}


$nama_mobil = $_POST['nama_mobil'];
$slug = strtolower(str_replace(' ', '-', $nama_mobil)); // simple slug
$gambar_nama = [];

foreach ($_FILES['gambar']['tmp_name'] as $key => $tmp_name) {
    $nama_file = $_FILES['gambar']['name'][$key];
    $target_dir = "Assets/img/katalog";
    move_uploaded_file($tmp_name, $target_dir . $nama_file);
    $gambar_nama[] = $nama_file;
}

$gambar_string = implode(',', $gambar_nama);

$query = "INSERT INTO mobil (nama_mobil, gambar, slug, created_at)
          VALUES ('$nama_mobil', '$gambar_string', '$slug', NOW())";

mysqli_query($conn, $query);

header("Location: mobil.php");
?>
