<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: pages/dashboard.php");
    exit;
}
?>

<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="assets/css/style.css">

<div class="container">
    <h1>Selamat datang di Web Mabar!</h1>
    <p>Temukan teman mabar dan buat ajakan game sekarang.</p>

    <div class="auth-buttons">
        <a href="session/register.php" class="btn">Daftar</a>
        <a href="session/login.php" class="btn">Login</a>
    </div>
</div>

<?php include "includes/footer.php"; ?>
