<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "db_tirta");

// Cek login admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: price_list.php");
    exit;
}

// Validasi id dari GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}
$id = intval($_GET['id']);

// Ambil data dari database
$result = mysqli_query($conn, "SELECT * FROM price_list WHERE id = $id");
if (!$result || mysqli_num_rows($result) === 0) {
    die("Data tidak ditemukan.");
}
$data = mysqli_fetch_assoc($result);

// Proses jika form disubmit
if (isset($_POST['submit'])) {
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis_mobil']);
    $tipe = mysqli_real_escape_string($conn, $_POST['tipe_mobil']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);

    $update = mysqli_query($conn, "UPDATE price_list SET 
        jenis_mobil = '$jenis', 
        tipe_mobil = '$tipe', 
        harga = '$harga' 
        WHERE id = $id");

    if ($update) {
        header("Location: price_list.php?edit=success");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Harga Mobil</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f1f3f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-container input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .form-container button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Data Harga Mobil</h2>
            <form method="POST">
                <label>Jenis Mobil:</label>
                <input type="text" name="jenis_mobil" value="<?= htmlspecialchars($data['jenis_mobil']); ?>" required>

                <label>Tipe Mobil:</label>
                <input type="text" name="tipe_mobil" value="<?= htmlspecialchars($data['tipe_mobil']); ?>" required>

                <label>Harga:</label>
                <input type="text" name="harga" value="<?= htmlspecialchars($data['harga']); ?>" required>

                <button type="submit" name="submit">Simpan</button>
            </form>
    </div>
</body>
</html>
