<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../session/login.php");
    exit;
}

$games = file("../data/games.txt", FILE_IGNORE_NEW_LINES);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_game'])) {
        $_SESSION['selected_game'] = $_POST['selected_game'];
    } elseif (isset($_POST['reset_game'])) {
        unset($_SESSION['selected_game']);
    }
    header("Location: dashboard.php");
    exit;
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/style.css">

<div class="dashboard-container">
    <div class="user-greeting">
        <h2>Halo, <?= htmlspecialchars($_SESSION['username']) ?>! 👋</h2>
        <p class="subtitle">Apa yang ingin kamu lakukan hari ini?</p>
    </div>

    <?php if (!isset($_SESSION['selected_game'])): ?>
        <div class="game-selection-section">
            <h3>Pilih Game Favoritmu</h3>
            <p class="instruction">Klik pada gambar game untuk memulai</p>
            <form method="POST" id="game-form">
                <div class="game-selection-grid">
                    <?php foreach ($games as $game): ?>
                        <div class="game-card" onclick="selectGame('<?= $game ?>')">
                            <div class="game-image">
                                <img src="../assets/images/<?= strtolower($game) ?>.jpg" alt="<?= $game ?>">
                            </div>
                            <div class="game-title"><?= $game ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="selected-game-banner">
            <div class="game-info">
                <h3>Game Aktif: <span><?= htmlspecialchars($_SESSION['selected_game']) ?></span></h3>
                <form method="POST">
                    <button type="submit" name="reset_game" class="btn-change">Ganti Game</button>
                </form>
            </div>
        </div>

        <div class="dashboard-actions">
            <div class="action-card" onclick="window.location.href='ajakan_form.php'">
                <div class="action-icon">
                    <img src="../assets/images/1.png" alt="Mabar" width="60">
                </div>
                <h4>Buat Ajakan</h4>
                <p>Buat sesi mabar dan undang teman-temanmu</p>
                <div class="action-btn">Mulai</div>
            </div>
            
            <div class="action-card" onclick="window.location.href='jadwal.php'">
                <div class="action-icon">
                    <img src="../assets/images/2.png" alt="Jadwal" width="60">
                </div>
                <h4>Lihat Jadwal</h4>
                <p>Cari sesi mabar yang tersedia</p>
                <div class="action-btn">Lihat</div>
            </div>
            
            <div class="action-card" onclick="window.location.href='../session/logout.php'">
                <div class="action-icon">
                    <img src="../assets/images/3.png" alt="Logout" width="60">
                </div>
                <h4>Logout</h4>
                <p>Keluar dari akun Anda</p>
                <div class="action-btn">Keluar</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>

<script>
    function selectGame(game) {
        var form = document.getElementById("game-form");
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "selected_game";
        input.value = game;
        form.appendChild(input);
        form.submit();
    }
</script>   