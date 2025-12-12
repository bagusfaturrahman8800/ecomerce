<?php
include 'auth.php'; // Check Login
cekLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Katalog - Tiyiti Hindi</title>
  <style>
    /* Navbar Styles */
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

    .nav-center a:hover {
      color: #ffcc00;
    }

    /* Galeri Styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f8f8f8;
      padding: 0;
    }
    .gallery-section {
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 20px;
    }

    .gallery-title {
      text-align: center;
      font-size: 2em;
      margin-bottom: 30px;
      color: #333;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 20px;
    }

    .card-link {
      text-decoration: none;
      color: inherit;
    }

    .gallery-card {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      text-align: center;
    }

    .gallery-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .gallery-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .gallery-card h3 {
      margin: 15px 0 5px;
    }

    .gallery-card p {
      margin-bottom: 15px;
      font-weight: bold;
      color: #555;
    }

    .card-info {
      padding: 15px;
    }

    .card-info h2 {
      margin-bottom: 10px;
      font-size: 18px;
      color: #333;
    }

    .card-info p {
      font-size: 14px;
      color: #666;
    }
    .footer {
      background: rgba(1, 10, 85, 0.97);
      color: white;
      padding: 40px 20px;
      text-align: center;
      border-top: 1px solid rgba(1, 10, 85, 0.97);
      box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.9);
    }
    .footer h3 { margin-bottom: 10px; font-size: 20px; font-weight: 600; }
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
    .footer .social-icons a:hover { color: #ffcc00; }
  </style>
</head>
<body>

  <!-- Navbar -->
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

 <section class="gallery-section">
  <h1 class="gallery-title">Katalog Mobil Tiyiti Hindi</h1>
  <div class="gallery-grid">
    <?php
      $galeri = [
        ['src' => 'Assets/img/katalog/1.png', 'title' => 'Agya', 'desc' => 'Rp.193.400.000'],
        ['src' => 'Assets/img/katalog/2.png', 'title' => 'Alphard', 'desc' => 'Rp.850.000.000'],
        ['src' => 'Assets/img/katalog/3.png', 'title' => 'Fortuner', 'desc' => 'Rp.560.000.000'],
        ['src' => 'Assets/img/katalog/4.png', 'title' => 'Hilux', 'desc' => 'Rp.450.000.000'],
        ['src' => 'Assets/img/katalog/5.png', 'title' => 'Raize', 'desc' => 'Rp.250.000.000'],
        ['src' => 'Assets/img/katalog/6.png', 'title' => 'Veloz', 'desc' => 'Rp.310.000.000'],
        ['src' => 'Assets/img/katalog/7.png', 'title' => 'Yaris', 'desc' => 'Rp.358.300.000'],
        ['src' => 'Assets/img/katalog/8.png', 'title' => 'Inova', 'desc' => 'Rp.429.700.000'],
      ];

      foreach ($galeri as $mobil) {
        $slug = strtolower(str_replace(' ', '-', $mobil['title']));
        echo '
          <a href="detail.php?mobil=' . $slug . '" class="card-link">
            <div class="gallery-card">
              <img src="' . $mobil['src'] . '" alt="' . $mobil['title'] . '">
              <h3>' . $mobil['title'] . '</h3>
              <p>' . $mobil['desc'] . '</p>
            </div>
          </a>
        ';
      }
    ?>
  </div>
</section>

</body>
    <!-- Footer -->
    <div class="footer">
        <h3>TIYITI HINDI</h3>
        <p>Solusi mobil impian Anda dengan pelayanan terbaik dan proses mudah.</p>
        <p><i class="fas fa-phone"></i> +62 856-5865-6709 | <i class="fas fa-envelope"></i> Tirta@TiyitiHindi.com</p>
        <p>© 2025 Tirta Adjie. All rights reserved.</p>
    </div>
</html>
