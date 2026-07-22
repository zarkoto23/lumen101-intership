<?php
require_once 'includes/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['theme'])) {
    $theme = $_POST['theme'] === 'dark' ? 'dark' : 'light';
    setcookie('theme', $theme, time() + (30 * 24 * 60 * 60), '/');
    header('Location: settings.php');
    exit;
}

$currentTheme = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>⚙️ Настройки</h1>
        
        <div class="settings-card">
            <h3>Избор на тема</h3>
            
            <form method="POST" action="">
                <div class="theme-options">
                    <label class="theme-option <?= $currentTheme === 'light' ? 'selected' : '' ?>">
                        <input type="radio" name="theme" value="light" 
                               <?= $currentTheme === 'light' ? 'checked' : '' ?>>
                        ☀️ Светла тема
                    </label>
                    
                    <label class="theme-option <?= $currentTheme === 'dark' ? 'selected' : '' ?>">
                        <input type="radio" name="theme" value="dark" 
                               <?= $currentTheme === 'dark' ? 'checked' : '' ?>>
                        🌙 Тъмна тема
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Запази настройките</button>
            </form>
        </div>
        
        <div class="settings-card">
            <h3>Информация за сесията</h3>
            <p><strong>Сесия ID:</strong> <?= session_id() ?></p>
            <p><strong>Влязъл като:</strong> <?= htmlspecialchars($_SESSION['name']) ?></p>
            <p><strong>Роля:</strong> <?= $_SESSION['role'] === 'administrator' ? 'Администратор' : 'Редактор' ?></p>
        </div>
        
        <div class="settings-actions">
            <a href="dashboard.php" class="btn">← Назад към табло</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>