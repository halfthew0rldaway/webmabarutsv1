<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $error = "Username dan password tidak boleh kosong!";
    } else {
        $users = file('../data/users.txt', FILE_IGNORE_NEW_LINES);
        $exists = false;

        foreach ($users as $user) {
            list($stored_user, ) = explode('|', $user);
            if ($stored_user === $username) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            $error = "Username sudah terdaftar!";
        } else {
            file_put_contents('../data/users.txt', $username . '|' . password_hash($password, PASSWORD_DEFAULT) . "\n", FILE_APPEND);
            header("Location: ../session/login.php");
            exit;
        }
    }
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="container">
    <h2>Daftar Akun</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="../session/login.php">Login di sini</a></p>
</div>

<?php include "../includes/footer.php"; ?>
