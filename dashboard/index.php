
<?php

session_start();

require_once '../includes/auth_check.php';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Auth System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <main class="container">
        <h1>Dashboard</h1>

        <p>
            Selamat datang,
            <strong><?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?></strong>!
        </p>

        <p>
            Kamu berhasil login ke aplikasi autentikasi.
        </p>

        <div class="user-info">
            <p>
                <strong>Email:</strong>
                <?php echo htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8'); ?>
            </p>
        </div>

        <form action="../auth/logout.php" method="POST">
            <button type="submit" class="btn btn-login">
                Logout
            </button>
        </form>
    </main>

</body>
</html>