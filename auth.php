<?php
function cekLogin() {
    session_start();
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Harap login terlebih dahulu untuk mengakses semua fitur'); window.location.href='index.php';</script>";
        exit;
    }
}
?>
