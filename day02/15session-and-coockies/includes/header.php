<?php
$theme = $_COOKIE['theme'] ?? 'light';

if (!isset($_COOKIE['visits'])) {
    setcookie('visits', 1, time() + (30 * 24 * 60 * 60), '/');
    $visits = 1;
} else {
    $visits = $_COOKIE['visits'] + 1;
    setcookie('visits', $visits, time() + (30 * 24 * 60 * 60), '/');
}

$lastVisit = $_COOKIE['last_visit'] ?? 'Първо посещение';
setcookie('last_visit', date('Y-m-d H:i:s'), time() + (30 * 24 * 60 * 60), '/');
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система за вход</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= $theme ?>-theme">
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <a href="dashboard.php">📦 Система за вход</a>
            </div>
            
            <div class="nav-menu">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <span class="nav-user">👤 <?= htmlspecialchars($_SESSION['name']) ?></span>
                    <a href="dashboard.php" class="nav-link">Табло</a>
                    <a href="profile.php" class="nav-link">Профил</a>
                    <a href="settings.php" class="nav-link">Настройки</a>
                    <a href="logout.php" class="nav-link logout-btn">Изход</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Вход</a>
                <?php endif; ?>
            </div>
        </nav>
        
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <div class="visit-info">
                <span>📊 Посещения: <?= $visits ?></span>
                <span>🕐 Последно посещение: <?= $lastVisit ?></span>
            </div>
        <?php endif; ?>
    </header>
    <main>