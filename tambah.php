<?php
session_start();
// Jika bukan admin, tendang balik ke index
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
include_once 'koneksi.php';

if (isset($_POST['submit'])) {
    $merk = mysqli_real_escape_string($conn, $_POST['merk']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $tahun = (int)$_POST['tahun'];
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];

    $nama_file = $_FILES['gambar']['name'];
    $sumber_file = $_FILES['gambar']['tmp_name'];
    $folder_tujuan = "gambar/";

    if (!empty($nama_file)) {
        move_uploaded_file($sumber_file, $folder_tujuan . $nama_file);
    }

    $sql = "INSERT INTO mobil (merk, model, tahun, harga, stok, gambar) 
            VALUES ('$merk', '$model', '$tahun', '$harga', '$stok', '$nama_file')";
    
    if (mysqli_query($conn, $sql)) {
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>AutoPremium | Tambah Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white p-3">
                        <h5 class="mb-0">Form Tambah Unit Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Merk Mobil</label>
                                <input type="text" name="merk" class="form-control" placeholder="Toyota, Honda, BMW..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Model / Seri</label>
                                <input type="text" name="model" class="form-control" placeholder="Civic, Avanza, M4..." required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <input type="number" name="tahun" class="form-control" value="2024">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Stok</label>
                                    <input type="number" name="stok" class="form-control" value="1">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" placeholder="0">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Foto Unit</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary">Simpan Database</button>
                                <a href="index.php" class="btn btn-light">Kembali ke Katalog</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>