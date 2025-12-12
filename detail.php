<?php
$mobil = isset($_GET['mobil']) ? strtolower($_GET['mobil']) : '';

// Data mobil (bisa diperluas)
$dataMobil = [
  'agya' => [
    'nama' => 'Toyota Agya',
    'harga' => 'Rp.193.400.000',
    'gambar' => 'Assets/img/katalog/1.png',
    'deskripsi' => 'Mobil hemat BBM, cocok untuk anak muda dan penggunaan harian.'
  ],
  'alphard' => [
    'nama' => 'Toyota Alphard',
    'harga' => 'Rp.850.000.000',
    'gambar' => 'Assets/img/katalog/2.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
   'fortuner' => [
    'nama' => 'Toyota Fortuner',
    'harga' => 'Rp.850.000.000',
    'gambar' => 'Assets/img/katalog/3.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
   'hilux' => [
    'nama' => 'Toyota Hilux',
    'harga' => 'Rp.850.000.000',
    'gambar' => 'Assets/img/katalog/4.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
   'raize' => [
    'nama' => 'Toyota Raize',
    'harga' => 'Rp.850.000.000',
    'gambar' => 'Assets/img/katalog/5.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
  'veloz' => [
    'nama' => 'Avanza Veloz',
    'harga' => 'Rp.310.000.000',
    'gambar' => 'Assets/img/katalog/6.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
  'yaris' => [
    'nama' => 'Yaris Cross',
    'harga' => 'Rp.358.300.000',
    'gambar' => 'Assets/img/katalog/7.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
  'inova' => [
    'nama' => 'Inova Zenix',
    'harga' => 'Rp.429.700.000',
    'gambar' => 'Assets/img/katalog/8.png',
    'deskripsi' => 'MPV mewah dengan fitur premium dan kenyamanan luar biasa.'
  ],
];

$detail = isset($dataMobil[$mobil]) ? $dataMobil[$mobil] : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Mobil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
    }

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

    .detail-container {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      display: flex;
      gap: 30px;
    }

    .detail-container img {
      width: 400px;
      border-radius: 10px;
      object-fit: cover;
    }

    .detail-info {
      flex: 1;
    }

    .detail-info h2 {
      margin-top: 0;
      font-size: 28px;
      color: #010a55;
    }

    .detail-info p {
      font-size: 16px;
      color: #333;
      line-height: 1.6;
    }

    .harga {
      font-weight: bold;
      color: #d2232a;
      font-size: 20px;
      margin: 15px 0;
    }

    .back-link {
      display: inline-block;
      margin-top: 20px;
      color: #010a55;
      text-decoration: none;
      font-weight: bold;
    }

    .back-link:hover {
      text-decoration: underline;
    }

    @media(max-width: 768px) {
      .detail-container {
        flex-direction: column;
        align-items: center;
      }

      .detail-container img {
        width: 100%;
      }

      .detail-info {
        text-align: center;
      }
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

<?php if ($detail): ?>
  <div class="detail-container">
    <img src="<?= $detail['gambar']; ?>" alt="<?= $detail['nama']; ?>">
    <div class="detail-info">
      <h2><?= $detail['nama']; ?></h2>
      <p class="harga"><?= $detail['harga']; ?></p>
      <p><?= $detail['deskripsi']; ?></p>
      <a class="back-link" href="mobil.php">Katalog</a>
    </div>
  </div>
<?php else: ?>
  <div style="text-align:center; padding: 50px;">
    <h2>Mobil tidak ditemukan.</h2>
    <a class="back-link" href="mobil.php">Katalog</a>
  </div>
<?php endif; ?>


<!-- choose section start -->
<div class="feature-tabs" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
  <div class="tab active" onclick="gantiVideo('mesin')">
      <i class="fas fa-tachometer-alt"></i>
      <span>Toyota Raize</span>
  </div>
  <div class="tab" onclick="gantiVideo('interior')">
      <i class="fas fa-chair"></i>
      <span>Alphard New</span>
  </div>
  <div class="tab" onclick="gantiVideo('eksterior')">
      <i class="fas fa-car-side"></i>
      <span>Inova Zenix</span>
  </div>
</div>
<!-- choose section end -->
<!-- Video Card Start -->
<div style="max-width: 900px; margin: 30px auto;">
  <div style="position: relative; padding-top: 56.25%; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <iframe
      id="videoFrame"
      src="https://www.youtube.com/embed/ptB1j00C38g"
      title="Video Section"
      allow="autoplay; encrypted-media"
      allowfullscreen
      style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
    ></iframe>
  </div>
</div>
<!-- Video Card End -->
<!-- Script for Dynamic Video -->
<script>
  const videoUrls = {
    mesin: "https://www.youtube.com/embed/M-BCbZcfEX8",
    interior: "https://www.youtube.com/embed/pBffCRnK4wY", 
    eksterior: "https://www.youtube.com/embed/1D47G-Ruum4", 
    dimensi: "https://www.youtube.com/embed/FVh1qi2Slq8",
    fasilitas: "https://www.youtube.com/embed/Fcqu58FD77s",
    keamanan: "https://www.youtube.com/embed/syMCu_f2MKo",
    sasis: "https://www.youtube.com/embed/G_nGsZntUzg"
  };

  function gantiVideo(section) {
    const iframe = document.getElementById("videoFrame");
    iframe.src = videoUrls[section] + "?autoplay=1";

    // Optional: ganti tab aktif
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    event.currentTarget.classList.add('active');
  }
</script>


</body>
<!-- Footer -->
    <div class="footer">
        <h3>TIYITI HINDI</h3>
        <p>Solusi mobil impian Anda dengan pelayanan terbaik dan proses mudah.</p>
        <p><i class="fas fa-phone"></i> +62 856-5865-6709 | <i class="fas fa-envelope"></i> Tirta@TiyitiHindi.com</p>
        <p>© 2025 Tirta Adjie. All rights reserved.</p>
    </div>
</html>
