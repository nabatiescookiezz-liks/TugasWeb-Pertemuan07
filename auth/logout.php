<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;