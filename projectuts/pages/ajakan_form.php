<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['selected_game'])) {
    header("Location: ../session/login.php");
    exit;
}

$game = $_SESSION['selected_game'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $waktu = $_POST['waktu'];

    if (empty($judul) || empty($waktu)) {
        $error = "Semua field wajib diisi.";
    } else {
        $slot = ($game === 'ML' || $game === 'Valorant') ? 5 : 4;

        $data = [
            'host' => $_SESSION['username'],
            'game' => $game,
            'judul' => $judul,
            'waktu' => $waktu,
            'slot' => $slot,
            'joined' => 1
        ];
        file_put_contents("../data/ajakan.txt", json_encode($data) . "\n", FILE_APPEND);
        header("Location: jadwal.php");
        exit;
    }
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<main class="container">
    <h2>Buat Ajakan Mabar - Game: <?= htmlspecialchars($game) ?></h2>

    <?php if ($error): ?>
        <p style="color: #ff6f00;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" class="form-ajakan" style="max-width: 400px; margin: auto; text-align: left;">
        <div class="form-group">
            <label for="judul">Judul Room:</label>
            <input type="text" name="judul" id="judul" required>
        </div>

        <div class="form-group">
            <label for="waktu">Tanggal & Jam Main:</label>
            <input type="datetime-local" name="waktu" id="waktu" required>
        </div>

        <button type="submit" class="btn" style="width: 100%;">Buat Ajakan</button>
    </form>
</main>

<?php include "../includes/footer.php"; ?>
