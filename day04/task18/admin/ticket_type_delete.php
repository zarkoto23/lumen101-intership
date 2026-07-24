<?php

require_once "../includes/functions.php";
require_once "../includes/admin_check.php";


if (!isset($_GET['id']) || !isset($_GET['event_id'])) {
    die("Липсват данни.");
}


$id = $_GET['id'];
$event_id = $_GET['event_id'];


$stmt = $pdo->prepare("
    DELETE FROM ticket_types
    WHERE id = ?
");


$stmt->execute([$id]);


header("Location: ticket_types.php?event_id=" . $event_id);
exit;