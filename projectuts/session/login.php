<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../pages/dashboard.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if both fields are not empty
    if ($username === '' || $password === '') {
        $error = "Username dan password tidak boleh kosong!";
    } else {
        // Read users from file
        $users = file('../data/users.txt', FILE_IGNORE_NEW_LINES);
        $found = false;

        // Search for the username and validate password
        foreach ($users as $user) {
            list($stored_user, $stored_pass) = explode('|', $user);
            if ($stored_user === $username && password_verify($password, $stored_pass)) {
                $_SESSION['username'] = $username;
                $found = true;
                break;
            }
        }

        if ($found) {
            header("Location: ../pages/dashboard.php");
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="container">
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required><br><br>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" required><br><br>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    <p>Belum punya akun? <a href="../session/register.php">Daftar di sini</a></p>
</div>

<?php include "../includes/footer.php"; ?>
