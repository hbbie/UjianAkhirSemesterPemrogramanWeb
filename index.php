<?php
session_start();

// 1. Proteksi Halaman: Jika belum login, lempar ke login.php
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include_once 'koneksi.php'; 

// 2. Pengaturan Hak Akses
$isAdmin = ($_SESSION['role'] === 'admin');

// 3. Logika Pencarian
$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : ""; 
$sql_where = "";
if (!empty($q)) {
    $sql_where = " WHERE merk LIKE '%$q%' OR model LIKE '%$q%'"; 
}

// 4. Pagination (2 Data per Halaman)
$per_page = 2; 
$sql_count = "SELECT COUNT(*) FROM mobil" . $sql_where;
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_row($result_count);
$total_data = $row_count[0];

$num_page = ceil($total_data / $per_page);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $num_page && $num_page > 0) $page = $num_page;
$offset = ($page - 1) * $per_page;

// 5. Query Utama
$sql = "SELECT * FROM mobil" . $sql_where . " ORDER BY id DESC LIMIT {$offset}, {$per_page}";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoPremium | Bright Edition</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #007bff;
            --soft-blue: #e7f1ff;
            --bg-light: #f8fbff;
        }

        body { 
            background-color: var(--bg-light); 
            color: #333;
            font-family: 'Outfit', sans-serif;
        }

        .navbar {
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            border-bottom: 2px solid var(--soft-blue);
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue) !important;
            font-size: 1.5rem;
        }

        .car-card {
            background: #ffffff;
            border: none;
            border-radius: 20px;
            transition: 0.3s;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,123,255,0.05);
        }
        .car-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,123,255,0.12);
        }

        .price-tag {
            background: var(--primary-blue);
            color: white;
            padding: 8px 20px;
            border-radius: 50px 0 0 50px;
            font-weight: 600;
            position: absolute;
            bottom: 20px;
            right: 0;
            box-shadow: -5px 5px 15px rgba(0,123,255,0.3);
        }

        .img-wrapper {
            position: relative;
            height: 240px;
        }

        .btn-main {
            background: var(--primary-blue);
            color: white;
            border-radius: 12px;
            border: none;
            padding: 10px 25px;
        }
        .btn-main:hover { background: #0056b3; color: white; }

        .pagination .page-link {
            border: none;
            background: white;
            margin: 0 4px;
            border-radius: 10px;
            color: var(--primary-blue);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .pagination .active .page-link {
            background: var(--primary-blue);
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-bolt me-2"></i>AUTOPREMIUM</a>
        
        <div class="d-flex align-items-center">
            <span class="me-3 text-muted d-none d-md-block">Halo, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
            
            <?php if($isAdmin): ?>
                <a href="tambah.php" class="btn btn-main shadow-sm me-2">
                    <i class="fas fa-plus-circle"></i> <span class="d-none d-md-inline">Unit Baru</span>
                </a>
            <?php endif; ?>
            
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row mb-5 justify-content-between align-items-center">
        <div class="col-md-5">
            <h1 class="fw-bold text-dark">Katalog Mobil <span class="text-primary">Terbaru</span></h1>
            <p class="text-muted small">Role Anda: <span class="badge bg-primary rounded-pill"><?= strtoupper($_SESSION['role']) ?></span></p>
        </div>
        <div class="col-md-5">
            <form method="get" class="d-flex shadow-sm rounded-3 overflow-hidden">
                <input type="text" name="q" class="form-control border-0 p-3" placeholder="Cari merk atau tipe..." value="<?= htmlspecialchars($q) ?>">
                <button type="submit" class="btn btn-main rounded-0 px-4"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-6">
                <div class="car-card h-100">
                    <div class="img-wrapper">
                        <img src="gambar/<?= $row['gambar'] ?>" class="w-100 h-100 object-fit-cover" onerror="this.src='https://placehold.co/600x400/e7f1ff/007bff?text=Mobil+Keren'">
                        <div class="price-tag">Rp <?= number_format($row['harga'], 0, ',', '.') ?></div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <h5 class="text-primary text-uppercase fw-bold mb-1" style="letter-spacing: 1px;"><?= $row['merk'] ?></h5>
                        <h2 class="fw-bold mb-3"><?= $row['model'] ?></h2>
                        
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <span class="badge bg-light text-dark border p-2 px-3 rounded-pill">Tahun <?= $row['tahun'] ?></span>
                            <span class="badge <?= ($row['stok'] > 0) ? 'bg-success' : 'bg-danger' ?> p-2 px-3 rounded-pill shadow-sm text-white">
                                <?= ($row['stok'] > 0) ? 'Stok Ready' : 'Habis' ?>
                            </span>
                        </div>

                        <div class="d-flex justify-content-center border-top pt-3 gap-2">
                            <?php if($isAdmin): ?>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill px-4" onclick="return confirm('Hapus data ini?')">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </a>
                            <?php else: ?>
                                <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
                                    <i class="fab fa-whatsapp me-2"></i>Hubungi Sales
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h4 class="text-secondary">Ups! Mobil yang Anda cari tidak ada.</h4>
            </div>
        <?php endif; ?>
    </div>

    <nav class="mt-5 pb-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link shadow-sm" href="?page=<?= $page - 1 ?>&q=<?= urlencode($q) ?>">Prev</a>
            </li>
            <?php for($i=1; $i<=$num_page; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link shadow-sm" href="?page=<?= $i ?>&q=<?= urlencode($q) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($page >= $num_page) ? 'disabled' : '' ?>">
                <a class="page-link shadow-sm" href="?page=<?= $page + 1 ?>&q=<?= urlencode($q) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<footer class="text-center py-4 text-muted border-top bg-white mt-5">
    <small>&copy; 2026 <strong>AutoPremium</strong> - Solusi Mobil Impian Anda.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>