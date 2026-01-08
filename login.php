<?php
session_start();
include_once 'koneksi.php';

// Jika sudah login, langsung lempar ke index
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Di praktikum ini kita gunakan teks biasa

    // Query untuk mencari user
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Simpan data ke session
        $_SESSION['login'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; // admin atau user
        
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | AutoPremium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8fbff; font-family: 'Outfit', sans-serif; }
        .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { 
            width: 100%; max-width: 400px; padding: 40px; 
            background: white; border-radius: 20px; border: none;
            box-shadow: 0 10px 40px rgba(0,123,255,0.1);
        }
        .btn-login { background: #007bff; border: none; border-radius: 12px; padding: 12px; font-weight: bold; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #e7f1ff; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">AUTOPREMIUM</h2>
            <p class="text-muted small">Silakan masuk untuk akses katalog</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger py-2 small text-center">Username / Password salah!</div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-login w-100 shadow">Masuk Sekarang</button>
        </form>
        
        <div class="text-center mt-4">
            <small class="text-muted">Gunakan akun <b>admin</b> untuk fitur kelola data.</small>
        </div>
    </div>
</div>

</body>
</html>