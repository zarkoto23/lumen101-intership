<?php

require "../config.php";
require "../nav.php";



$id = $_GET['id'];


$stmt = $pdo->prepare(
    "SELECT 
    workouts.name,
    workouts.workout_date,
    workouts.start_time,
    workouts.duration,
    CONCAT(trainers.first_name, ' ', trainers.last_name) AS trainer_name

FROM workout_members

JOIN workouts
ON workout_members.workout_id = workouts.id

JOIN trainers
ON workouts.trainer_id = trainers.id

WHERE workout_members.member_id = ?"
);



$stmt->execute([$id]);


$workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<h1>Member workouts</h1>



<?php foreach ($workouts as $workout): ?>


    <p>

        Workout:
        <?= $workout['name'] ?>

        <br>

        Trainer:
        <?= $workout['trainer_name'] ?>

        <br>

        Date:
        <?= $workout['workout_date'] ?>

        <br>

        Time:
        <?= $workout['start_time'] ?>

        <br>

        Duration:
        <?= $workout['duration'] ?> minutes


    </p>


    <hr>


<?php endforeach; ?>