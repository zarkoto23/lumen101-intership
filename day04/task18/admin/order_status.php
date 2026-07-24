<?php

require_once "../includes/header.php";
require_once "../includes/admin_check.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    die("Невалидна заявка.");

}


$order_id = $_POST['order_id'];
$status = $_POST['status'];



$allowed = [
    "Нова",
    "Платена",
    "Отказана",
    "Завършена"
];


if (!in_array($status, $allowed)) {

    die("Невалиден статус.");

}



$stmt = $pdo->prepare("
    UPDATE orders
    SET status = ?
    WHERE id = ?
");



$stmt->execute([
    $status,
    $order_id
]);



header("Location: orders.php");
exit;