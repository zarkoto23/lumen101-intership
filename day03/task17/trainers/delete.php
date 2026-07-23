<?php
require "../config.php";
require "../nav.php";



$id = $_GET['id'];


$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM workouts WHERE trainer_id = ?"
);

$stmt->execute([$id]);

$workoutsCount = $stmt->fetchColumn();


if ($workoutsCount > 0) {

    echo "
    <script>
        if(confirm('Внимание! Това действие ще изтрие треньора заедно с всички негови тренировки и записи. Продължавате ли?')) {
            window.location.href='delete_confirm.php?id=$id';
        } else {
            window.location.href='index.php';
        }
    </script>
    ";
    exit;

} else {

    $stmt = $pdo->prepare(
        "DELETE FROM trainers WHERE id = ?"
    );

    $stmt->execute([$id]);

}


header("Location: index.php");
exit;