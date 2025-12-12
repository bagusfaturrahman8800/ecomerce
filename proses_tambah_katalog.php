<?php
$koneksi = new mysqli("localhost", "root", "", "db_tirta");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Cek jika form dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_katalog'];
    $created_at = date("Y-m-d H:i:s");

    // Cek apakah file gambar dikirim
    if (isset($_FILES['gambar_katalog']) && $_FILES['gambar_katalog']['error'] === UPLOAD_ERR_OK) {
        $gambar_name = $_FILES['gambar_katalog']['name'];
        $gambar_tmp = $_FILES['gambar_katalog']['tmp_name'];

        // Lokasi penyimpanan gambar
        $folder_tujuan = "Assets/img/katalog/";
        $gambar_path = $folder_tujuan . basename($gambar_name);

        // Pastikan folder ada
        if (!is_dir($folder_tujuan)) {
            mkdir($folder_tujuan, 0777, true);
        }

        // Pindahkan gambar ke folder tujuan
        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            // Simpan ke database
            $query = "INSERT INTO produk (nama_mobil, gambar, created_at) VALUES (?, ?, ?)";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("sss", $nama, $gambar_path, $created_at);

            if ($stmt->execute()) {
                echo "<script>alert('Katalog berhasil ditambahkan!'); window.location='mobil.php';</script>";
            } else {
                echo "Gagal menyimpan data ke database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Gagal mengupload gambar.";
        }
    } else {
        echo "Gambar katalog belum dipilih atau terjadi kesalahan saat upload.";
    }
} else {
    echo "Form tidak dikirim dengan metode POST.";
}

$koneksi->close();
?>
