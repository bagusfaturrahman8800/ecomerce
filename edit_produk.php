<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_tirta");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil ID produk dari URL
$id = $_GET['id'];

// Update status produk menjadi sold out
$query = "UPDATE produk SET stock = 0 WHERE id = $id";
if (mysqli_query($conn, $query)) {
    echo "Produk berhasil ditandai sebagai sold out.";
} else {
    echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);

// Redirect ke halaman shop setelah update
header("Location: shop.php");
exit;
?>
