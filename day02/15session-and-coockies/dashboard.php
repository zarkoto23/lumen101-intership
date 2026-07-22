<?php
require_once 'includes/auth-check.php';
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Табло - Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>📊 Табло (Dashboard)</h1>
        
        <div class="dashboard-welcome">
            <h2>Здравей, <?= htmlspecialchars($_SESSION['name']) ?>! 👋</h2>
            
            <div class="user-info">
                <p><strong>Потребителско име:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                <p><strong>Роля:</strong> 
                    <span class="role-badge <?= $_SESSION['role'] === 'administrator' ? 'role-admin' : 'role-editor' ?>">
                        <?= $_SESSION['role'] === 'administrator' ? 'Администратор' : 'Редактор' ?>
                    </span>
                </p>
                <p><strong>Влязъл на:</strong> <?= htmlspecialchars($_SESSION['login_time']) ?></p>
            </div>
        </div>
        
        <div class="dashboard-links">
            <h3>Навигация</h3>
            <ul>
                <li><a href="profile.php">👤 Моят профил</a></li>
                <li><a href="settings.php">⚙️ Настройки</a></li>
                <?php if ($_SESSION['role'] === 'administrator'): ?>
                    <li><a href="admin.php">🔧 Администраторски панел</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="btn-logout">🚪 Изход</a></li>
            </ul>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>