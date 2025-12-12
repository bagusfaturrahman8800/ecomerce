<?php
$koneksi = new mysqli("localhost", "root", "", "db_tirta");

// Validasi form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_katalog'];
    $created_at = date("Y-m-d H:i:s");

    // Upload gambar
    $gambar_name = $_FILES['gambar_katalog']['name'];
    $gambar_tmp = $_FILES['gambar_katalog']['tmp_name'];
    $gambar_folder = "Assets/img/katalog/" . $gambar_name;

    // Pastikan folder ada
    if (!is_dir("Assets/img/katalog")) {
        mkdir("Assets/img/katalog", 0777, true);
    }

    // Pindah file dan simpan ke database
    if (move_uploaded_file($gambar_tmp, $gambar_folder)) {
        $query = "INSERT INTO produk (nama_mobil, gambar, created_at) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sss", $nama, $gambar_folder, $created_at);

        if ($stmt->execute()) {
            echo "<script>alert('Katalog berhasil ditambahkan!'); window.location='mobil.php';</script>";
        } else {
            echo "Gagal menyimpan ke database: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mengupload gambar.";
    }
} else {
    echo "Form tidak dikirim dengan benar.";
}

$koneksi->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Tambah Katalog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-katalog {
            background-color: #1976d2;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            transition: 0.3s ease;
        }

        .btn-katalog:hover {
            background-color: #0d47a1;
            color: white;
        }

        .card {
            margin: 50px auto;
            padding: 30px;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        label {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="card">
    <h3>Tambah Katalog Baru</h3>
    <form action="proses_tambah_katalog.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama_katalog">Nama Mobil:</label>
            <input type="text" class="form-control" name="nama_katalog" id="nama_katalog" required>
        </div>
        <div class="form-group">
            <label for="gambar_katalog">Gambar Katalog:</label>
            <input type="file" class="form-control-file" name="gambar_katalog" id="gambar_katalog" accept=".jpg,.jpeg,.png" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Katalog</button>
    </form>

</div>

</body>
</html>
