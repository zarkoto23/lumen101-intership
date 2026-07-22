<?php
require_once 'config/database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$category_id = $_POST['category_id'] ?? '';
$price = $_POST['price'] ?? '';
$quantity = $_POST['quantity'] ?? 0;
$image = trim($_POST['image'] ?? '');
$is_available = isset($_POST['is_available']) ? 1 : 0;

$errors = [];


if ($id <= 0) {
    $_SESSION['flash_message'] = 'Невалиден ID на продукт!';
    $_SESSION['flash_type'] = 'danger';
    header('Location: index.php');
    exit;
}

if (empty($name)) {
    $errors[] = 'Името на продукта е задължително.';
}

if (empty($category_id)) {
    $errors[] = 'Моля, изберете категория.';
}

if ($price === '' || $price === null) {
    $errors[] = 'Цената е задължителна.';
} elseif (!is_numeric($price) || $price < 0) {
    $errors[] = 'Цената трябва да бъде положително число.';
}

if (!is_numeric($quantity) || $quantity < 0 || floor($quantity) != $quantity) {
    $errors[] = 'Количеството трябва да бъде цяло неотрицателно число.';
}

if (!empty($errors)) {
    $_SESSION['flash_message'] = implode(' ', $errors);
    $_SESSION['flash_type'] = 'danger';
    header('Location: edit.php?id=' . $id);
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

    $sql = "UPDATE products 
            SET category_id = ?, 
                name = ?, 
                description = ?, 
                price = ?, 
                quantity = ?, 
                image = ?, 
                is_available = ? 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $category_id,
        $name,
        $description,
        $price,
        $quantity,
        $image,
        $is_available,
        $id
    ]);

    $_SESSION['flash_message'] = 'Продуктът беше редактиран успешно!';
    $_SESSION['flash_type'] = 'success';

} catch (PDOException $e) {
    $_SESSION['flash_message'] = 'Грешка при запис: ' . $e->getMessage();
    $_SESSION['flash_type'] = 'danger';
}

header('Location: index.php');
exit;