<?php
require_once 'config/database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    $_SESSION['flash_message'] = 'Невалиден ID на продукт!';
    $_SESSION['flash_type'] = 'danger';
    header('Location: index.php');
    exit;
}

try {
    $checkStmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
    $checkStmt->execute([$id]);

    if (!$checkStmt->fetch()) {
        $_SESSION['flash_message'] = 'Продуктът не съществува!';
        $_SESSION['flash_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    $deleteStmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $deleteStmt->execute([$id]);

    $_SESSION['flash_message'] = 'Продуктът беше изтрит успешно!';
    $_SESSION['flash_type'] = 'success';

} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Грешка при изтриване: ' . $e->getMessage();
    $_SESSION['flash_type'] = 'danger';
}

header('Location: index.php');
exit;