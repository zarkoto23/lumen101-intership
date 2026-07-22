<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

require_once 'users.php';

$error = '';
$username = '';

if (isset($_COOKIE['remember_username'])) {
    $username = $_COOKIE['remember_username'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (empty($username) || empty($password)) {
        $error = 'Моля, попълнете всички полета!';
    } else {
        $foundUser = null;
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $foundUser = $user;
                break;
            }
        }

        if ($foundUser === null) {
            $error = 'Невалидно потребителско име или парола!';
        } elseif ($password !== $foundUser['password']) {
            $error = 'Невалидно потребителско име или парола!';
        } else {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $foundUser['username'];
            $_SESSION['name'] = $foundUser['name'];
            $_SESSION['role'] = $foundUser['role'];
            $_SESSION['login_time'] = date('Y-m-d H:i:s');

            session_regenerate_id(true);

            if ($remember) {
                setcookie('remember_username', $username, time() + (7 * 24 * 60 * 60), '/');
            } else {
                setcookie('remember_username', '', time() - 3600, '/');
            }

            header('Location: dashboard.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в системата</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="login-container">
        <h2>🔐 Вход в системата</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Потребителско име:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Парола:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group checkbox">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Запомни ме</label>
            </div>

            <button type="submit" class="btn btn-primary">Вход</button>
        </form>

        <div class="demo-credentials">
            <p><strong>Демо потребители:</strong></p>
            <p>Админ: admin / admin123</p>
            <p>Редактор: editor / editor123</p>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>