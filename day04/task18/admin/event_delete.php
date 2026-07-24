<?php

require_once "../includes/functions.php";
require_once "../includes/admin_check.php";

if (!isset($_GET['id'])) {
    die("Липсва ID на събитието.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("
    DELETE FROM events
    WHERE id = ?
");

$stmt->execute([$id]);

header("Location: events.php");
exit;