<?php
include 'auth.php'; // Check Login
cekLogin();
?>
<?php
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

$role = $_SESSION['role'];
$is_admin = $role === 'admin';
$is_user = $role === 'user';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>About - Tiyiti Hindi</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 0;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(1, 10, 85, 0.97);
      color: white;
      padding: 15px 30px;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.9);
    }

    .navbar h1 {
      margin: 0;
    }

    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
    }
        .nav-center {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 25px;
    }
    .nav-center a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      font-size: 15px;
      transition: 0.3s;
    }
    .nav-center a:hover { color: #ffcc00; }

    .about-container {
      max-width: 900px;
      margin: 50px auto;
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .about-container h2 {
      color: #010a55;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .about-container p {
      font-size: 16px;
      line-height: 1.7;
      color: #333;
    }
    .feature-tabs {
    display: flex;
    justify-content: center;
    background-color:rgba(1, 10, 85, 0.97);
    padding: 15px 0;
    flex-wrap: wrap;
    }

    .tab {
    color: #fff;
    text-align: center;
    padding: 10px 20px;
    margin: 0 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-bottom: 3px solid transparent;
    }

    .tab i {
    font-size: 20px;
    margin-bottom: 5px;
    }

    .tab.active {
    background-color: #000;
    border-radius: 4px;
    color: #fff;
    }


    .footer {
      background: rgba(1, 10, 85, 0.97);
      color: white;
      padding: 40px 20px;
      text-align: center;
      border-top: 1px solid rgba(1, 10, 85, 0.97);
      box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.9);
    }

    .footer h3 {
      margin-bottom: 10px;
      font-size: 20px;
      font-weight: 600;
    }

    .footer p {
      font-size: 14px;
      font-weight: 400;
      opacity: 0.8;
    }

    .footer .social-icons a {
      margin: 0 10px;
      color: white;
      text-decoration: none;
      font-size: 20px;
      transition: 0.3s;
    }

    .footer .social-icons a:hover {
      color: #ffcc00;
    }
  </style>
</head>
<body>

<div class="navbar">
  <h1>TIYITI HINDI</h1>
  <div class="nav-center">
    <a href="index.php">Beranda</a>
    <a href="mobil.php">Katalog</a>
    <a href="about.php">About</a>
    <a href="price_list.php">Price</a>
    <a href="galery.php">Galery</a>
    <a href="contact.php">Contact</a>

    
  </div>
</div>
<div class="about-container">
  <h2>Tentang Kami</h2>
  <p>
    <strong>Tiyiti Hindi</strong> adalah perusahaan yang bergerak di bidang penjualan mobil Toyota secara daring dengan komitmen untuk memberikan kemudahan, kenyamanan, dan kepercayaan kepada setiap pelanggan. Kami percaya bahwa memiliki mobil impian tidak harus rumit. Oleh karena itu, kami hadir dengan sistem belanja yang modern, proses pemesanan yang cepat, dan pelayanan pelanggan yang profesional.
  </p>
  <p>
    Melalui platform ini, kami menyediakan berbagai tipe dan varian mobil Toyota terbaru dengan informasi yang lengkap dan transparan. Tiyiti Hindi didirikan untuk menjadi solusi terpercaya bagi masyarakat Indonesia, khususnya mereka yang menginginkan pengalaman membeli mobil tanpa repot dan penuh pertimbangan.
  </p>
  <p>
    Dengan dukungan tim yang berpengalaman dan sistem teknologi yang kami kembangkan secara mandiri, Tiyiti Hindi siap menjadi mitra terbaik Anda dalam memilih kendaraan impian.
  </p>
</div>

<div class="footer">
  <h3>Tiyiti Hindi</h3>
  <p>Solusi mobil impian Anda dengan pelayanan terbaik dan proses mudah.</p>
  <p><i class="fas fa-phone"></i> +62 856-5865-6709 | <i class="fas fa-envelope"></i> Tirta@TiyitiHindi.com</p>
  <p>© 2025 Tirta Adjie. All rights reserved.</p>
</div>

</body>
</html>
