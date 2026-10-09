<?php

session_start();

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$email =  trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    die('Email dan password wajib diisi.');
}

$stmt = $pdo->prepare(
    "SELECT id, name, email, password FROM users WHERE email = :email"
);

$stmt->execute([
    ':email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Email atau password salah.');
}

if (!password_verify($password, $user['password'])) {
    die('Email atau password salah.');
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];

session_regenerate_id(true);
header('Location: ../dashboard/index.php');
exit;

}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Auth System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="container">
        <h1>Login</h1>

        <?php if (isset($_GET['registered']) && $_GET['registered'] === '1'): ?>
            <p class="success-message">
                Registrasi berhasil! Silahkan login menggunakan aku kamu.
        </p>
        <?php endif; ?>

        <p>Silakan masuk menggunakan akun yang sudah terdaftar.</p>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn btn-login">
                Login
            </button>
        </form>

        <p class="auth-link">
            Belum punya akun?
            <a href="register.php">Register di sini</a>
        </p>

        <p class="auth-link">
            <a href="../index.php">Kembali ke Beranda</a>
        </p>
    </main>

</body>
</html>