<?php
require_once 'includes/auth-check.php';
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моят профил</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="container">
        <h1>👤 Моят профил</h1>
        
        <div class="profile-card">
            <div class="profile-info">
                <p><strong>Потребителско име:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                <p><strong>Име:</strong> <?= htmlspecialchars($_SESSION['name']) ?></p>
                <p><strong>Роля:</strong> 
                    <span class="role-badge <?= $_SESSION['role'] === 'administrator' ? 'role-admin' : 'role-editor' ?>">
                        <?= $_SESSION['role'] === 'administrator' ? 'Администратор' : 'Редактор' ?>
                    </span>
                </p>
                <p><strong>Влязъл на:</strong> <?= htmlspecialchars($_SESSION['login_time']) ?></p>
                <p><strong>Сесия ID:</strong> <?= session_id() ?></p>
            </div>
            
            <div class="profile-actions">
                <a href="dashboard.php" class="btn">← Назад към табло</a>
                <a href="logout.php" class="btn btn-danger">🚪 Изход</a>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>