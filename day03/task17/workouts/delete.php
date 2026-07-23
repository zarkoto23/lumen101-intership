<?php

require "../config.php";
require "../nav.php";


$id = $_GET['id'];

$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM workout_members WHERE workout_id = ?"
);

$stmt->execute([$id]);

$membersCount = $stmt->fetchColumn();


if ($membersCount > 0) {

    echo "
    <script>
        if(confirm('Внимание! Тази тренировка има записани клиенти. Изтриването ще премахне и техните записи. Продължавате ли?')) {
            window.location.href='delete_confirm.php?id=$id';
        } else {
            window.location.href='index.php';
        }
    </script>
    ";

    exit;


} else {

    $stmt = $pdo->prepare(
        "DELETE FROM workouts WHERE id = ?"
    );

    $stmt->execute([$id]);

}


header("Location: index.php");
exit;