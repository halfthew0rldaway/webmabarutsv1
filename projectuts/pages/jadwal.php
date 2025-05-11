<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['selected_game'])) {
    header("Location: ../session/login.php");
    exit;
}

$ajakan = file("../data/ajakan.txt", FILE_IGNORE_NEW_LINES);
$selected_game = $_SESSION['selected_game'];

$filtered = [];
foreach ($ajakan as $line) {
    $data = json_decode($line, true);
    if (isset($data['game']) && $data['game'] === $selected_game) {
        $filtered[] = $data;
    }
}

// Pesan untuk request bergabung
$request_sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_join'])) {
    $request_sent = true;
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<main class="container">
    <h2>Jadwal Mabar - Game: <?= htmlspecialchars($selected_game, ENT_QUOTES, 'UTF-8') ?></h2>

    <?php if (empty($filtered)): ?>
        <p>Belum ada ajakan mabar untuk game ini.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
        <table class="jadwal-table" style="width: 210%; max-width: 1000px; margin: 20px auto; border-collapse: collapse;">
                <thead style="background-color: #f4f4f4;">
                    <tr>
                        <th style="padding: 10px; border: 1px solid #ccc;">Judul Room</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Host</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Waktu</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Slot</th>
                        <th style="padding: 10px; border: 1px solid #ccc;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtered as $data): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($data['judul'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($data['host'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars(date("d M Y, H:i", strtotime($data['waktu'] ?? '')), ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($data['joined'] ?? '0', ENT_QUOTES, 'UTF-8') ?>/<?= htmlspecialchars($data['slot'] ?? '0', ENT_QUOTES, 'UTF-8') ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <?php if ($_SESSION['username'] !== ($data['host'] ?? '')): ?>
                                    <form method="POST" action="">
                                        <button class="btn" type="submit" name="request_join" value="<?= htmlspecialchars($data['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                            Request Bergabung
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: gray;">(Host)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if ($request_sent): ?>
        <p style="color: green; margin-top: 20px;">Request Bergabung telah terkirim!</p>
    <?php endif; ?>
</main>

<?php include "../includes/footer.php"; ?>
