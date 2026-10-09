<?php

require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $password === '') {
    die('Semua field wajib diisi.');
}

if (strlen($password) < 6) {
    die('Password minimal 6 karakter.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Format email tidak valid.');
}

$stmt = $pdo->prepare(
    "SELECT id FROM users WHERE email = :email"
);

$stmt->execute([
    ':email' => $email
]);

if ($stmt->fetch()){
    die('Email sudah terdaftar.');
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$stmt = $pdo->prepare(
    "INSERT INTO users (name, email, password)
    VALUES (:name, :email, :password)"
);

$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':password' => $hashedPassword
]);

header('Location: login.php?registered=1');
exit;
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Auth System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="container">
        <h1>Register</h1>

        <p>Buat akun baru untuk mulai menggunakan aplikasi.</p>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    autocomplete="name"
                >
            </div>

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
                    minlength="6"
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn btn-login">
                Buat Akun
            </button>
        </form>

        <p class="auth-link">
            Sudah punya akun?
            <a href="login.php">Login di sini</a>
        </p>

        <p class="auth-link">
            <a href="../index.php">Kembali ke Beranda</a>
        </p>
    </main>

</body>
</html>