<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_tirta");

// REGISTER
if (isset($_POST['register'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // default role

    // cek username apakah sudah digunakan
    $cek = mysqli_query($conn, "SELECT * FROM akun WHERE username='$username'");
    if (mysqli_num_rows($cek) == 0) {
        // perhatikan nama kolom 'nama_lengkap'
        $simpan = mysqli_query($conn, "INSERT INTO akun (nama_lengkap, username, password, role) VALUES ('$nama','$username','$password', '$role')");
        if ($simpan) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.');</script>";
        } else {
            echo "<script>alert('Gagal mendaftar.');</script>";
        }
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
            $_SESSION['nama'] = $row['nama_lengkap']; // perhatikan nama kolom
            $_SESSION['role'] = $row['role'];

            // redirect berdasarkan role
            if ($row['role'] == 'admin') {
                echo "<script>window.location.href='index.php';</script>";
            } else {
                echo "<script>window.location.href='index.php';</script>";
            }
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
  <title>TIYITI HINDI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    /* CSS tetap sama seperti sebelumnya */
    body { margin: 0; font-family: 'Segoe UI', sans-serif; background:rgb(218, 216, 216); }
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
    /* Modal background */
    .modal {
      display: none; /* Hidden by default */
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background: rgba(0, 0, 0, 0.6); /* Semi-transparent */
      backdrop-filter: blur(4px);
    }

    /* Modal content box */
    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 30px 40px;
      border-radius: 10px;
      max-width: 400px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.3s ease-in-out;
      font-family: 'Segoe UI', sans-serif;
    }

    /* Fade in animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Close button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .close:hover {
      color: #333;
    }

    /* Heading */
    .modal-content h2 {
      margin-top: 0;
      margin-bottom: 20px;
      text-align: center;
      color: #333;
    }

    /* Input fields */
    .modal-content input[type="text"],
    .modal-content input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    /* Submit button */
    .modal-content button[name="login"] {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .modal-content button[name="login"]:hover {
      background-color: #0056b3;
    }

    .close {
      position: absolute;
      right: 15px;
      top: 10px;
      font-size: 20px;
      cursor: pointer;
    }
    .auth-btns {
    display: flex;
    gap: 10px;
    margin-left: auto;
    padding-right: 20px;
    }

    .auth-btns button {
    padding: 8px 16px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .auth-btns button:first-child {
    background-color:rgb(255, 160, 0); /* Biru untuk Login */
    color: white;
    }

    .auth-btns button:last-child {
    background-color: #28a745; /* Hijau untuk Register */
    color: white;
    }

    .auth-btns button:hover {
    opacity: 0.9;
    transform: scale(1.03);
    }

    .banner {
      height: 300px;
      overflow: hidden;
      position: relative;
    }
    .banner .slides {
      display: flex;
      width: 300vw;
      animation: slide 9s ease-in-out infinite;
    }
    .banner img {
      width: 100vw;
      height: 300px;
      object-fit: cover;
    }
    @keyframes slide {
      0%, 20% { transform: translateX(0); }
      33%, 53% { transform: translateX(-100vw); }
      66%, 86% { transform: translateX(-200vw); }
      100% { transform: translateX(0); }
    }
    .card-hover {
      transition: all 0.3s ease;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    .card-hover:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .card-hover .gallery_img img {
      transition: transform 0.3s ease;
      width: 100%;
      height: auto;
    }

    .card-hover:hover .gallery_img img {
      transform: scale(1.05);
    }

    .content {
      padding: 60px 40px;
      text-align: center;
      background: white;
      margin: 40px auto;
      width: 80%;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .car-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      overflow: hidden;
      transition: 0.3s;
    }
    .car-card:hover {
      transform: translateY(-5px);
    }

    .car-img {
      position: relative;
      background: #f4f4f4;
      text-align: center;
      padding: 20px;
    }
    .car-img img {
      width: 100%;
      height: auto;
    }
    .diskon-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background: red;
      color: #fff;
      font-size: 10px;
      padding: 5px;
      border-radius: 4px;
      text-align: center;
      font-weight: bold;
    }

    .car-info {
      padding: 20px;
    }

    .harga {
      background: #cc0000;
      color: #fff;
      padding: 8px;
      font-weight: bold;
      border-radius: 999px;
      text-align: center;
      margin-bottom: 15px;
    }

    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      font-size: 15px;
      font-weight: 500;
    }

    .cta-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .label-btn {
      padding: 6px 15px;
      border-radius: 20px;
      font-size: 13px;
      border: none;
      cursor: default;
    }
    .label-btn.blue {
      background: #1976d2;
      color: white;
    }
    .label-btn.orange {
      background:rgb(255, 160, 0);
      color: white;
    }

    .arrow-btn {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 34px;
      height: 34px;
      border-radius: 50%;
      border: 1px solid #ccc;
      color: #cc0000;
      text-decoration: none;
      font-size: 14px;
    }
    .arrow-btn:hover {
      background: #cc0000;
      color: white;
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

  <?php if (!isset($_SESSION['username'])): ?>
  <div class="auth-btns">
    <button onclick="openModal('login')">Login</button>
    <button onclick="openModal('register')">Register</button>
  </div>
  <?php else: ?>
  <div class="auth-btns">
    <span style="margin-right: 15px;">Halo, <?= $_SESSION['nama'] ?> (<?= $_SESSION['role'] ?>)</span>
    <a href="?logout=true" style="color: #ffcc00;">Logout</a>
  </div>
  <?php endif; ?>
</div>

<!-- Banner -->
  <div id="banner_slider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="Assets/img/baner/baner1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h1><span style="color:rgb(0, 0, 0);">Providing a car</span><span style="color: #ffcc00;">For You</span></h1>
            <p><span style="color:rgb(0, 0, 0);">Temukan mobil impian Anda bersama Tiyiti Hindi</span></p>
          <a href="about.php" class="btn btn-light">Read More</a>
          <a href="contact.php" class="btn btn-warning">Contact Us</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="Assets/img/baner/baner2.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h1 style><span style="color:rgba(0, 0, 0, 0.76);">Explore</span><span style="color:rgba(255, 2, 15, 0.76);">Luxury</span></h1>
          <p><span style="color:rgba(0, 0, 0, 0.76);">Jelajahi kenyamanan bersama kendaraan terbaik</span></p>
        </div>
      </div>
      <!-- Add more slides -->
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#banner_slider" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#banner_slider" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
 
  <!-- Konten Shop & About jika sudah login -->
  <?php if (isset($_SESSION['username'])): ?>
  <!-- gallery section start -->
  <div class="content" id="shop">
    <div class="gallery_section layout_padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="gallery_taital">Our Best Offers</h1>
          </div>
         </div>

      <div class="row g-4">
        <!-- 1 Card -->
        <div class="col-md-4">
          <div class="car-card">
            <div class="car-img">
              <img src="assets/img/raize/raize-turquoise-mm-black.png" alt="Toyota Raize">
              <div class="diskon-badge">DISKON<br>DARI WEBSITE</div>
            </div>
            <div class="car-info">
              <div class="harga">Rp 252.300.000</div>
              <div class="detail-row">
                <span class="nama">Toyota Raize</span>
                <span class="tipe">5 Type</span>
              </div>
                <div class="cta-row">
                  <a href="https://wa.me/6285658656709?text=Halo%20saya%20tertarik%20dengan%20promo%20Toyota%20Raize" target="_blank" class="label-btn orange">Promo</a>
                  <a href="mobil.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
          </div>
        </div>

        <!-- Duplikat dan sesuaikan isi card lainnya -->
        <div class="col-md-4">
          <div class="car-card">
            <div class="car-img">
              <img src="assets/img/inova/inova-Gray-Metallic.png" alt="Inova Zenix">
              <div class="diskon-badge">DISKON<br>DARI WEBSITE</div>
            </div>
            <div class="car-info">
              <div class="harga">Rp 429.700.000</div>
              <div class="detail-row">
                <span class="nama">Inova Zenix</span>
                <span class="tipe">6 Type</span>
              </div>
                <div class="cta-row">
                  <a href="https://wa.me/6285658656709?text=Halo%20saya%20tertarik%20dengan%20promo%20promo%20Inova%20Zenix" target="_blank" class="label-btn orange">Promo</a>
                  <a href="mobil.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="car-card">
            <div class="car-img">
              <img src="assets/img/alphard/alphard-platinum-white.png" alt="Toyota Alphard">
              <div class="diskon-badge">DISKON<br>DARI WEBSITE</div>
            </div>
            <div class="car-info">
              <div class="harga">Rp 1.385.600.000</div>
              <div class="detail-row">
                <span class="nama">Toyota Alphard</span>
                <span class="tipe">3 Type</span>
              </div>
                <div class="cta-row">
                  <a href="https://wa.me/6285658656709?text=Halo%20saya%20tertarik%20dengan%20promo%20Toyota%20Alphardnya" target="_blank" class="label-btn orange">Promo</a>
                  <a href="mobil.php" class="arrow-btn"><i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
          </div>
        </div>

        <!-- Lanjutkan card lainnya sesuai gambar yang kamu kirim -->
      </div>
    </div>
  </div>
</div>
<!-- gallery section end -->


  <div class="content" id="about">
    <div class="about_section layout_padding">
         <div class="container">
            <div class="about_section_2">
               <div class="row">
                  <div class="col-md-6">
                    <div class="video-container">
                      <iframe src="https://www.youtube.com/embed/cLvyzRWFMx0" 
                        width="100%" height="315" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                      </iframe>
                    </div>
                  </div>
                  <div class="col-md-6"> 
                     <div class="about_taital_box">
                        <h1 class="about_taital">About <span style="color:rgba(1, 10, 85, 0.97);">Us</span></h1>
                        <p class="about_text">Tiyiti Hindi adalah perusahaan terpercaya yang bergerak di bidang penjualan kendaraan Toyota, berkomitmen untuk menghadirkan pengalaman pembelian mobil yang mudah, nyaman, dan terpercaya bagi masyarakat Indonesia.</p>
                        <div class="readmore_btn"><a href="about.php">Read More</a></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
  </div>
<?php endif; ?>

<!-- Footer -->
<div class="footer">
  <h3>Tiyiti Hindi</h3>
  <p>Solusi mobil impian Anda dengan pelayanan terbaik dan proses mudah.</p>
  <p><i class="fas fa-phone"></i> +62 856-5865-6709 | <i class="fas fa-envelope"></i> Tirta@TiyitiHindi.com</p>
  <p>© 2025 Tirta Adjie. All rights reserved.</p>
</div>

<!-- Modals -->
<div class="modal" id="login-modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('login')">&times;</span>
    <h2>Login</h2>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />
      <button name="login">Login</button>
    </form>
  </div>
</div>

<!-- Modal Register -->
<div class="modal" id="register-modal" style="display: none; position: fixed; justify-content: center; align-items: center; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
  <div class="modal-content" style="background: #fff; padding: 20px; border-radius: 8px; width: 300px; position: relative;">
    <span class="close" onclick="closeModal('register')" style="position: absolute; top: 10px; right: 15px; cursor: pointer;">&times;</span>
    <h2>Register</h2>
    <form method="post">
      <input type="text" name="nama" placeholder="Nama Lengkap" required style="width: 100%; padding: 10px; margin-bottom: 10px;" />
      <input type="text" name="username" placeholder="Username" required style="width: 100%; padding: 10px; margin-bottom: 10px;" />
      <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 10px; margin-bottom: 10px;" />
      <button name="register" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none;">Daftar</button>
    </form>
  </div>
</div>

<script>
  function openModal(type) {
    const modal = document.getElementById(`${type}-modal`);
    if (modal) modal.style.display = 'flex';
  }

  function closeModal(type) {
    const modal = document.getElementById(`${type}-modal`);
    if (modal) modal.style.display = 'none';
  }

  window.onclick = function (event) {
    ['register', 'login'].forEach(type => {
      const modal = document.getElementById(`${type}-modal`);
      if (modal && event.target === modal) {
        modal.style.display = 'none';
      }
    });
  };
</script>

</body>
</html>