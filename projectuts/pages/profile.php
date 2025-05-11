<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: ../session/login.php");
    exit;
}

$userDataFile = "../data/users.txt";
$users = file_exists($userDataFile) ? file($userDataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

$currentUser = null;
$currentIndex = null;

foreach ($users as $index => $line) {
    list($username, $hashedPassword) = explode('|', $line);
    if ($username === $_SESSION['username']) {
        $currentUser = [
            'username' => $username,
            'password' => $hashedPassword
        ];
        $currentIndex = $index;
        break;
    }
}

if ($currentUser === null) {
    echo "User tidak ditemukan.";
    exit;
}

// Proses form update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    $newPassword = trim($_POST['password']);

    // Gunakan password lama jika tidak diisi
    $hashedPassword = !empty($newPassword) ? password_hash($newPassword, PASSWORD_DEFAULT) : $currentUser['password'];

    // Simpan perubahan
    $users[$currentIndex] = $newUsername . '|' . $hashedPassword;
    file_put_contents($userDataFile, implode("\n", $users));

    // Update session jika username berubah
    $_SESSION['username'] = $newUsername;

    header("Location: profile.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="container">
    <h2>Profile - <?= htmlspecialchars($_SESSION['username']) ?></h2>
    
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($currentUser['username']) ?>" required>
        </div>

        <div class="form-group">
            <label for="password">New Password (optional):</label>
            <input type="password" id="password" name="password" placeholder="Leave blank if you don't want to change">
        </div>

        <button type="submit" class="btn">Update Profile</button>
    </form>

    <a href="dashboard.php" class="btn" style="margin-top: 20px;">Back to Dashboard</a>
</div>

<?php include "../includes/footer.php"; ?>
