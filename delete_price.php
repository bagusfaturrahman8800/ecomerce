<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_tirta");

// Hanya admin yang boleh hapus
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: price_list.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $query = "DELETE FROM price_list WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: price_list.php?status=sukses_delete");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: price_list.php");
    exit;
}
?>
