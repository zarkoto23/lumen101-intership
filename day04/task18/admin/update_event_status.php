<?php

require_once "../includes/header.php";
require_once "../includes/admin_check.php";


$stmt = $pdo->query("
    SELECT id, start_date, end_date
    FROM events
");


$events = $stmt->fetchAll();



foreach ($events as $event) {


    $now = date("Y-m-d H:i:s");


    if ($now < $event['start_date']) {

        $status = "Предстоящо";

    } elseif ($now >= $event['start_date'] && $now <= $event['end_date']) {

        $status = "Провежда се";

    } else {

        $status = "Приключило";

    }



    $update = $pdo->prepare("
        UPDATE events
        SET status = ?
        WHERE id = ?
    ");


    $update->execute([
        $status,
        $event['id']
    ]);

}



echo "Статусите са обновени.";