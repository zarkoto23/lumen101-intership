<?php

require "../config.php";
require "../nav.php";


$trainers = $pdo->query(
    "SELECT id, first_name, last_name
     FROM trainers"
)->fetchAll(PDO::FETCH_ASSOC);


$trainerId = $_GET['trainer_id'] ?? '';
$date = $_GET['date'] ?? '';



$sql =
    "SELECT 
    workouts.*,
    CONCAT(trainers.first_name, ' ', trainers.last_name) AS trainer_name,
    COUNT(workout_members.id) AS registered_members

FROM workouts

JOIN trainers
ON workouts.trainer_id = trainers.id

LEFT JOIN workout_members
ON workouts.id = workout_members.workout_id";



$params = [];

$where = [];



if ($trainerId != '') {

    $where[] = "workouts.trainer_id = ?";
    $params[] = $trainerId;

}



if ($date != '') {

    $where[] = "workouts.workout_date = ?";
    $params[] = $date;

}



if (count($where) > 0) {

    $sql .= " WHERE " . implode(" AND ", $where);

}



$sql .= "
GROUP BY workouts.id";



$stmt = $pdo->prepare($sql);

$stmt->execute($params);


$workouts = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<form method="GET">


    <label>
        Trainer:
    </label>


    <select name="trainer_id">


        <option value="">
            All trainers
        </option>


        <?php foreach ($trainers as $trainer): ?>


            <option value="<?= $trainer['id'] ?>" <?= ($trainerId == $trainer['id']) ? 'selected' : '' ?>>

                <?= $trainer['first_name'] ?>
                <?= $trainer['last_name'] ?>

            </option>


        <?php endforeach; ?>


    </select>


    <br><br>


    <label>
        Date:
    </label>


    <input type="date" name="date" value="<?= $date ?>">


    <button>
        Filter
    </button>


</form>



<h1>Workouts</h1>


<a href="create.php">
    Create workout
</a>



<?php foreach ($workouts as $workout): ?>


    <div>


        <h3>
            <?= $workout['name'] ?>
        </h3>



        <p>
            Trainer:
            <?= $workout['trainer_name'] ?>
        </p>



        <p>
            Date:
            <?= $workout['workout_date'] ?>
        </p>



        <p>
            Time:
            <?= $workout['start_time'] ?>
        </p>



        <p>
            Duration:
            <?= $workout['duration'] ?> minutes
        </p>



        <p>
            Max members:
            <?= $workout['max_members'] ?>
        </p>



        <p>
            Participants:

            <?= $workout['registered_members'] ?>

            /

            <?= $workout['max_members'] ?>

        </p>



        <p>
            Free places:

            <?= $workout['max_members'] - $workout['registered_members'] ?>

        </p>



        <a href="delete.php?id=<?= $workout['id'] ?>">
            Delete
        </a>


        <br>


        <a href="members.php?id=<?= $workout['id'] ?>">
            View participants
        </a>


        <br>


        <a href="register.php?id=<?= $workout['id'] ?>">
            Register member
        </a>



    </div>


    <hr>



<?php endforeach; ?>