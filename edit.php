<?php
session_start();
// Jika bukan admin, tendang balik ke index
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
include_once 'koneksi.php'; //

$id = $_GET['id'];

// Ambil data lama berdasarkan ID
$sql = "SELECT * FROM mobil WHERE id = '{$id}'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

// Proses Update saat tombol Simpan ditekan
if (isset($_POST['submit'])) {
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Logika gambar (tetap gunakan gambar lama jika tidak upload baru)
    $gambar = $data['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "gambar/" . $gambar);
    }

    $sql_update = "UPDATE mobil SET 
                   merk='{$merk}', model='{$model}', tahun='{$tahun}', 
                   harga='{$harga}', stok='{$stok}', gambar='{$gambar}' 
                   WHERE id='{$id}'";
    
    if (mysqli_query($conn, $sql_update)) {
        header('location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Unit | AutoPremium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 600px;">
        <h3>Edit Data Mobil</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Merk</label>
                <input type="text" name="merk" class="form-control" value="<?= $data['merk'] ?>">
            </div>
            <div class="mb-3">
                <label>Model</label>
                <input type="text" name="model" class="form-control" value="<?= $data['model'] ?>">
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>">
            </div>
            <div class="mb-3">
                <label>Foto Saat Ini</label><br>
                <img src="gambar/<?= $data['gambar'] ?>" width="100" class="mb-2">
                <input type="file" name="gambar" class="form-control">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>