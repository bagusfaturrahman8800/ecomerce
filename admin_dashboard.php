<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_tirta");

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya bisa diakses oleh admin.'); window.location.href='index.php';</script>";
    exit;
}

// REGISTER
if (isset($_POST['register'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // default role adalah pembeli

    $cek = mysqli_query($conn, "SELECT * FROM akun WHERE username='$username'");
    if (mysqli_num_rows($cek) == 0) {
        $simpan = mysqli_query($conn, "INSERT INTO akun (nama, username, password, role) VALUES ('$nama','$username','$password', '$role')");
        echo $simpan
            ? "<script>alert('Pendaftaran berhasil! Silakan login.');</script>"
            : "<script>alert('Gagal mendaftar.');</script>";
    } else {
        echo "<script>alert('Username sudah digunakan!');</script>";
    }
}

// LOGIN
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM akun WHERE username='$username'");
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];
            echo "<script>window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!');</script>";
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tiyiti Hindi</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* --- CSS TETAP --- */
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background:rgb(218, 216, 216); }
    .navbar {
      display: flex; justify-content: space-between; align-items: center;
      background: rgba(1, 10, 85, 0.97); color: white; padding: 15px 30px;
      position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.9); backdrop-filter: blur(5px);
    }
    .navbar h1 { font-size: 24px; margin: 0; font-weight: 500; }
    .nav-center {
      position: absolute; left: 50%; transform: translateX(-50%);
      display: flex; gap: 25px;
    }
    .nav-center a {
      color: white; text-decoration: none; font-weight: 500; font-size: 15px;
    }
    .nav-center a:hover { color: #ffcc00; }
    .auth-btns button {
      margin-left: 10px; padding: 8px 16px;
      background: transparent; border: 1px solid #fff; color: white;
      cursor: pointer; border-radius: 4px; transition: 0.3s; font-size: 14px;
    }
    .auth-btns button:hover {
      background: white; color: black;
    }
    .modal {
      display: none; position: fixed; z-index: 1000;
      left: 0; top: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.9); justify-content: center; align-items: center;
    }
    .modal-content {
      background: white; padding: 30px; border-radius: 10px;
      width: 350px; position: relative;
    }
    .modal-content input, .modal-content button {
      width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px;
    }
    .modal-content button {
      background:rgb(0, 0, 0, 0.9); color: white; border: none;
    }
    .close {
      position: absolute; right: 15px; top: 10px; font-size: 20px; cursor: pointer;
    }
    .banner {
      height: 300px; overflow: hidden; position: relative;
    }
    .banner .slides {
      display: flex; width: 300vw;
      animation: slide 9s ease-in-out infinite;
    }
    .banner img {
      width: 100vw; height: 300px; object-fit: cover;
    }
    @keyframes slide {
