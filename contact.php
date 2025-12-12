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
  <title>Contact - Tiyiti Hindi</title>
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
  <h2>TIYITI HINDI CONTACT</h2>
  <p>
    <strong>Dealer Tiyiti Hindi Lubeg Padang</strong>
  </p>
      <p>Tiyiti Hindi Padang, dapatkan Promo Menarik dan Hadiah Spesial Aksesoris bulan ini, termasuk informasi minimal DP setiap Unit & Perhitungan Kredit yang direkomendasikan sesuai dengan kemampuan Anda. Didukung Oleh Sales Amanah & Terpercaya Membantu Anda.</p>
    <p>Mengapa beli dan service disini? Pelayanan Respons cepat, pelayanan terbaik dan dapat diandalkan.</p> 
    <p>Informasi Kredit dengan DP Murah, Angsuran Ringan, Bunga Mulai 0%</p>
    <b><p>- DP Mulai 10%</p></b>
    <b><p>- Angsuran Murah</p></b>
    <b><p>- Tenor Sampai 7 Tahun</p></b>
    <b><p>- Merchandise Tiyiti</p></b>
    <b><p>- Free Kaca Film & Promo Jasa Service 7x atau 3 tahun.</p></b>
    <p><p></p></p>
    <div style="margin-top: 20px; text-align: center;">
      <small style="color: #333; font-weight: 600;">Reservasi Sekarang Juga</small><br>
        <a href="https://wa.me/6285658656709?text=Halo%20Bapak%20Tirta,%20saya%20tertarik%20dengan%20promo%20mobil%20Tiyiti%20Hindi" 
          target="_blank" 
          style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #25D366; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
          <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
        </a>
      </div>
    </div>
  </div>

<!-- choose section start -->
<div class="feature-tabs" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
  <div class="tab active" onclick="gantiVideo('mesin')">
      <i class="fas fa-tachometer-alt"></i>
      <span>GIIAS 2024</span>
  </div>
  <div class="tab" onclick="gantiVideo('interior')">
      <i class="fas fa-chair"></i>
      <span>Parts</span>
  </div>
  <div class="tab" onclick="gantiVideo('eksterior')">
      <i class="fas fa-car-side"></i>
      <span>Story</span>
  </div>
  <div class="tab" onclick="gantiVideo('dimensi')">
      <i class="fas fa-ruler-combined"></i>
      <span>Safe Driving</span>
  </div>
  <div class="tab" onclick="gantiVideo('fasilitas')">
      <i class="fas fa-cogs"></i>
      <span>Trip Driving</span>
  </div>
  <div class="tab" onclick="gantiVideo('keamanan')">
      <i class="fas fa-shield-alt"></i>
      <span>Safe Tiyiti</span>
  </div>
  <div class="tab" onclick="gantiVideo('sasis')">
      <i class="fas fa-dot-circle"></i>
      <span>Film</span>
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
    mesin: "https://www.youtube.com/embed/4WcNOLRakAM",
    interior: "https://www.youtube.com/embed/rdxqeJHaJsE", 
    eksterior: "https://www.youtube.com/embed/82ss7F3BXaE", 
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

<div class="footer">
  <h3>Tiyiti Hindi</h3>
  <p>Solusi mobil impian Anda dengan pelayanan terbaik dan proses mudah.</p>
  <p><i class="fas fa-phone"></i> +62 856-5865-6709 | <i class="fas fa-envelope"></i> Tirta@TiyitiHindi.com</p>
  <p>© 2025 Tirta Adjie. All rights reserved.</p>
</div>

</body>
</html>
