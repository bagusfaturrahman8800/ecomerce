<?php
include 'auth.php'; // Check Login
cekLogin();
?>
<?php
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Koneksi database
$host = "localhost";
$username = "root";
$password = "";
$database = "db_tirta";
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$role = $_SESSION['role'];
$is_admin = $role === 'admin';
$is_user = $role === 'user';

// PROSES SIMPAN DATA JIKA FORM DISUBMIT
if (isset($_POST['tambah_data'])) {
    $jenis = $_POST['jenis_mobil'];
    $tipe = $_POST['tipe_mobil'];
    $harga = $_POST['harga'];

    $stmt = $conn->prepare("INSERT INTO price_list (jenis_mobil, tipe_mobil, harga) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $jenis, $tipe, $harga);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='price_list.php';</script>";
    } else {
        echo "Gagal menyimpan data: " . $conn->error;
    }
}

// Ambil semua data, urut berdasarkan jenis_mobil dan tipe_mobil
$sql = "SELECT * FROM price_list ORDER BY jenis_mobil, tipe_mobil";
$result = $conn->query($sql);

// Kelompokkan data ke dalam array
$mobilData = [];
while ($row = $result->fetch_assoc()) {
    $jenis = $row['jenis_mobil'];
    if (!isset($mobilData[$jenis])) {
        $mobilData[$jenis] = [];
    }
    $mobilData[$jenis][] = $row;
}

// Ambil opsi filter unik
$jenisOptions = $conn->query("SELECT DISTINCT jenis_mobil FROM price_list ORDER BY jenis_mobil");
$tipeOptions = $conn->query("SELECT DISTINCT tipe_mobil FROM price_list ORDER BY tipe_mobil");

// Ambil filter dari URL (GET)
$filterJenis = isset($_GET['jenis_mobil']) ? mysqli_real_escape_string($conn, $_GET['jenis_mobil']) : '';
$filterTipe  = isset($_GET['tipe_mobil']) ? mysqli_real_escape_string($conn, $_GET['tipe_mobil']) : '';
$filterSort  = (isset($_GET['sort']) && $_GET['sort'] === 'desc') ? 'DESC' : 'ASC';

// Build query
$filterQuery = "SELECT * FROM price_list WHERE 1=1";
if (!empty($filterJenis)) {
    $filterQuery .= " AND jenis_mobil = '$filterJenis'";
}
if (!empty($filterTipe)) {
    $filterQuery .= " AND tipe_mobil = '$filterTipe'";
}
$filterQuery .= " ORDER BY harga $filterSort";

// Debug query
// echo "<pre>$filterQuery</pre>";

$result = $conn->query($filterQuery);
if (!$result) {
    die("Query Error: " . $conn->error);
}

// Kelompokkan data
$cards = [];
while ($row = $result->fetch_assoc()) {
    $cards[$row['jenis_mobil']][] = $row;
}


// Nomor WA
$wa = "6285658656709";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Price List - Tiyiti Hindi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5f5f5;
    }
    
    /* ==== NAVBAR ==== */
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
    .admin-buttons {
    margin: 20px 30px 0;
    text-align: left;
  }
   /* ==== BTN ADMIN ==== */
    .admin-buttons {
    margin: 20px 30px;
    }

    .btn-admin {
    padding: 10px 20px;
    background-color: #014db5;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    }

    .btn-admin:hover {
    background-color: #003e94;
    }

    .admin-actions {
    margin-top: 15px;
    }

    .admin-actions a {
    margin-right: 10px;
    padding: 6px 12px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 500;
    }

    .btn-edit {
    background-color: #f0ad4e;
    color: white;
    }

    .btn-edit:hover {
    background-color: #ec971f;
    }

    .btn-delete {
    background-color: #d9534f;
    color: white;
    }

    .btn-delete:hover {
    background-color: #c9302c;
    }
   /* ==== End ==== */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.9);
      justify-content: center;
      align-items: center;
    }

    /* ==== FILTER FORM ==== */
    .filter-box {
      padding: 20px 30px;
      background: #fff;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      border-bottom: 1px solid #ccc;
    }
    .filter-box select {
      padding: 10px;
      font-size: 14px;
    }

    .filter-box button {
      padding: 10px 20px;
      background: #01118b;
      color: white;
      border: none;
      cursor: pointer;
    }

    /* Modal background */
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
    }

    /* Modal content box */
    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px 25px;
        border-radius: 12px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    /* Close button */
    .modal-content .close {
        position: absolute;
        top: 12px;
        right: 16px;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
    }

    /* Form styling */
    .modal-content form {
        display: flex;
        flex-direction: column;
        gap: 8px; /* Lebih rapat */
    }

    .modal-content label {
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .modal-content input[type="text"],
    .modal-content input[type="number"] {
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
        margin-bottom: 12px; /* Rapat tapi tetap ada jarak antar input */
    }

    /* Tombol submit */
    .modal-content button[type="submit"] {
        background-color: #0047AB;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .modal-content button[type="submit"]:hover {
        background-color: #003b91;
    }

    /* ==== CARD MOBIL ==== */
    .container-price-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
    }

    .card-mobil {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 20px;
        width: 300px;
        transition: transform 0.2s ease;
    }

    .card-mobil:hover {
        transform: translateY(-5px);
    }

    .card-mobil h2 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #003366;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
    }

    .card-mobil ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .card-mobil li {
      margin-bottom: 15px;
      font-size: 16px;
      color: #333;
    }

    .button-group {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
      margin-top: 5px;
    }

    .button-group .btn {
      padding: 6px 10px;
      font-size: 14px;
      border-radius: 4px;
      text-decoration: none;
      color: #fff;
      text-align: center;
      white-space: nowrap;
    }

    .btn-warning {
      background-color: #f0ad4e;
    }

    .btn-danger {
      background-color: #d9534f;
    }

    .btn-success {
      background-color: #25D366;
    }

    .btn-warning:hover {
      background-color: #ec971f;
    }

    .btn-danger:hover {
      background-color: #c9302c;
    }

    .btn-success:hover {
      background-color: #1ebe5b;
    }


    /* Tombol Edit */
    .btn-warning {
        background-color: #FFC107;
        color: #000;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    /* Tombol Hapus */
    .btn-danger {
        background-color: #DC3545;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
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
    
    html {
      scroll-behavior: smooth;
    }

    /* Container keseluruhan */
    #hasil-filter {
      margin-top: 2rem;
      padding: 1rem;
    }

    /* Judul jenis mobil */
    #hasil-filter h2 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #333;
      border-bottom: 2px solid #e0e0e0;
      padding-bottom: 0.5rem;
    }

    /* Grid card */
    #hasil-filter ul {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1rem;
      list-style: none;
      padding: 0;
    }

    #hasil-filter li {
      background: #f9f9f9;
      border: 1px solid #ddd;
      padding: 1rem;
      border-radius: 8px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
    }

    #hasil-filter li:hover {
      transform: translateY(-3px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Teks mobil */
    #hasil-filter li span {
      font-weight: bold;
      color: #555;
    }

    /* Harga */
    #hasil-filter li .harga {
      display: block;
      margin-top: 0.5rem;
      color: #d32f2f;
      font-weight: bold;
    }

    /* Responsif */
    @media (max-width: 600px) {
      #hasil-filter ul {
        grid-template-columns: 1fr;
      }
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

    <!-- Filter Form -->
      <form method="GET" class="filter-box">
        <select name="jenis_mobil">
          <option value="">Semua Jenis Mobil</option>
          <?php
          $jenisOpts = $conn->query("SELECT DISTINCT jenis_mobil FROM price_list ORDER BY jenis_mobil");
          while ($row = $jenisOpts->fetch_assoc()): ?>
            <option value="<?= $row['jenis_mobil'] ?>" <?= ($filterJenis == $row['jenis_mobil']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($row['jenis_mobil']) ?>
            </option>
          <?php endwhile; ?>
        </select>

        <select name="tipe_mobil">
          <option value="">Semua Tipe</option>
          <?php
          $tipeOpts = $conn->query("SELECT DISTINCT tipe_mobil FROM price_list ORDER BY tipe_mobil");
          while ($row = $tipeOpts->fetch_assoc()): ?>
            <option value="<?= $row['tipe_mobil'] ?>" <?= ($filterTipe == $row['tipe_mobil']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($row['tipe_mobil']) ?>
            </option>
          <?php endwhile; ?>
        </select>

        <select name="sort">
          <option value="asc" <?= ($filterSort == 'ASC') ? 'selected' : '' ?>>Harga Termurah</option>
          <option value="desc" <?= ($filterSort == 'DESC') ? 'selected' : '' ?>>Harga Termahal</option>
        </select>

        <button type="submit">Filter</button>
      </form>
      <p>
         <!-- Tombol Tambah Data Price List -->
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <div class="admin-buttons">
                  <button onclick="openModal()" class="btn-admin">+ Tambah Data</button>
              </div>
      </p>

      <!-- Hasil Filter -->
      <div id="hasil-filter">
        <?php if (empty($cards)): ?>
          <p>Tidak ada data ditemukan.</p>
        <?php else: ?>
          <?php foreach ($cards as $jenis => $mobilList): ?>
            <h2><?= htmlspecialchars($jenis) ?></h2>
            <ul>
              <?php foreach ($mobilList as $mobil): ?>
                <li>
                  <span><?= htmlspecialchars($mobil['tipe_mobil']) ?></span>
                  <div class="harga">Rp<?= number_format($mobil['harga'], 0, ',', '.') ?></div>

                  <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'user'])): ?>
                    <div class="button-group" style="margin-top: 5px; display: flex; gap: 5px; flex-wrap: wrap;">
                      <?php if ($_SESSION['role'] == 'admin'): ?>
                        <a class='btn btn-warning btn-sm' href='edit_price.php?id=<?= $mobil['id'] ?>'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='delete_price.php?id=<?= $mobil['id'] ?>' onclick='return confirm("Yakin ingin menghapus data ini?")'>Hapus</a>
                      <?php endif; ?>
                      <a class='btn btn-success btn-sm' 
                        href='https://wa.me/6285658656709?text=Tertarik%20dengan%20<?= urlencode($mobil['tipe_mobil']) ?>,%20bisa%20info%20lebih%20lanjut?' 
                        target='_blank'>WA</a>
                    </div>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>




    <!-- Modal Form -->
    <div id="modalForm" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form method="POST">
                <label>Jenis Mobil:</label>
                <input type="text" name="jenis_mobil" required><br>

                <label>Tipe Mobil:</label>
                <input type="text" name="tipe_mobil" required><br>

                <label>Harga:</label>
                <input type="number" name="harga" required><br>

                <button type="submit" name="tambah_data">Simpan</button>
            </form>
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

    <script>
        function toggleForm() {
            const form = document.getElementById("formTambah");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
    <script>
      function openModal() {
          document.getElementById("modalForm").style.display = "block";
      }

      function closeModal() {
          document.getElementById("modalForm").style.display = "none";
      }

      // Tutup jika klik di luar modal
      window.onclick = function(event) {
          const modal = document.getElementById("modalForm");
          if (event.target == modal) {
              modal.style.display = "none";
          }
      }
    </script>
</body>
</html>
