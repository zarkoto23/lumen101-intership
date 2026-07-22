<?php
require_once '../config/database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    $_SESSION['flash_message'] = 'Невалиден ID на категория!';
    $_SESSION['flash_type'] = 'danger';
    header('Location: index.php');
    exit;
}

try {
    $checkStmt = $pdo->prepare("SELECT id FROM categories WHERE id = ?");
    $checkStmt->execute([$id]);

    if (!$checkStmt->fetch()) {
        $_SESSION['flash_message'] = 'Категорията не съществува!';
        $_SESSION['flash_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    $productCheck = $pdo->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
    $productCheck->execute([$id]);
    $productCount = $productCheck->fetch()['count'];

    if ($productCount > 0) {
        $_SESSION['flash_message'] = 'Не може да изтриете категория, която съдържа продукти! Първо изтрийте или преместете продуктите.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: index.php');
        exit;
    }

    $deleteStmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $deleteStmt->execute([$id]);

    $_SESSION['flash_message'] = 'Категорията беше изтрита успешно!';
    $_SESSION['flash_type'] = 'success';

} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Грешка при изтриване: ' . $e->getMessage();
    $_SESSION['flash_type'] = 'danger';
}

header('Location: index.php');
exit;