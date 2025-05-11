<!-- header.php -->
<header class="main-header">
    <div class="container header-content">
        <div class="header-left">
            <a href="../pages/dashboard.php" class="logo">MABSKUY</a>
        </div>
        <div class="user-nav">
            <span class="username">
                <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?>
            </span>
            <a href="../session/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>