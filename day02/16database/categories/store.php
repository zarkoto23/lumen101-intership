<?php
require_once '../config/database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

$errors = [];


if (empty($name)) {
    $errors[] = 'Името на категорията е задължително.';
}

if (!empty($errors)) {
    $_SESSION['flash_message'] = implode(' ', $errors);
    $_SESSION['flash_type'] = 'danger';
    header('Location: create.php');
    exit;
}

try {
    $checkStmt = $pdo->prepare("SELECT id FROM categories WHERE name = ?");
    $checkStmt->execute([$name]);

    if ($checkStmt->fetch()) {
        $_SESSION['flash_message'] = 'Категория с това име вече съществува!';
        $_SESSION['flash_type'] = 'danger';
        header('Location: create.php');
        exit;
    }

    $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $description]);

    $_SESSION['flash_message'] = 'Категорията беше добавена успешно!';
    $_SESSION['flash_type'] = 'success';

} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Грешка при запис: ' . $e->getMessage();
    $_SESSION['flash_type'] = 'danger';
}

header('Location: index.php');
exit;