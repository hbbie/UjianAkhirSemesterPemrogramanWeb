<?php
session_start();
// Jika bukan admin, tendang balik ke index
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>
include_once 'koneksi.php'; //

// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk menghapus data
$sql = "DELETE FROM mobil WHERE id = '{$id}'";
$result = mysqli_query($conn, $sql);

// Redirect kembali ke halaman utama
header('location: index.php');
?>