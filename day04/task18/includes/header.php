<?php
require_once __DIR__ . "/functions.php";

session_start();

$pdo->query("
    UPDATE events
    SET status =
        CASE
            WHEN NOW() < start_date THEN 'Предстоящо'
            WHEN NOW() BETWEEN start_date AND end_date THEN 'Провежда се'
            WHEN NOW() > end_date THEN 'Приключило'
        END
");
?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event System</title>

    <link rel="stylesheet" href="/day04/task18/public/css/style.css">
</head>


<body>