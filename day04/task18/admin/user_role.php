<?php

require_once "../includes/header.php";
require_once "../includes/admin_check.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Невалидна заявка.");
}


$user_id = $_POST['user_id'];
$role = $_POST['role'];



if (!in_array($role, ['user', 'admin'])) {
    die("Невалидна роля.");
}




if ($user_id == $_SESSION['user_id'] && $role === "user") {

    die("Не можете да премахнете собствената си admin роля.");

}


$stmt = $pdo->prepare("
    UPDATE users
    SET role = ?
    WHERE id = ?
");


$stmt->execute([
    $role,
    $user_id
]);



header("Location: users.php");
exit;