<?php

require "../config.php";
require "../nav.php";


$error = "";


$stmt = $pdo->query(
    "SELECT id, first_name, last_name 
     FROM trainers"
);


$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $trainer_id = $_POST['trainer_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $workout_date = $_POST['workout_date'];
    $start_time = $_POST['start_time'];
    $duration = $_POST['duration'];
    $max_members = $_POST['max_members'];



    if (
        empty($trainer_id) ||
        empty($name) ||
        empty($workout_date) ||
        empty($start_time)
    ) {

        $error = "Please fill all required fields.";


    } elseif ($duration <= 0) {

        $error = "Duration must be greater than 0.";


    } elseif ($max_members <= 0) {

        $error = "Maximum members must be greater than 0.";


    } else {


        $stmt = $pdo->prepare(
            "INSERT INTO workouts
            (
                trainer_id,
                name,
                description,
                workout_date,
                start_time,
                duration,
                max_members
            )

            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );


        $stmt->execute([
            $trainer_id,
            $name,
            $description,
            $workout_date,
            $start_time,
            $duration,
            $max_members
        ]);


        header("Location: index.php");
        exit;

    }

}

?>



<h1>Create workout</h1>



<?php if ($error): ?>

    <p>
        <?= $error ?>
    </p>

<?php endif; ?>



<form method="POST">


    <label>
        Workout name:
    </label>

    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>">

    <br><br>



    <label>
        Description:
    </label>

    <textarea name="description"><?= $_POST['description'] ?? '' ?></textarea>

    <br><br>



    <label>
        Date:
    </label>

    <input type="date" name="workout_date" value="<?= $_POST['workout_date'] ?? '' ?>">

    <br><br>



    <label>
        Start time:
    </label>

    <input type="time" name="start_time" value="<?= $_POST['start_time'] ?? '' ?>">

    <br><br>



    <label>
        Duration (minutes):
    </label>

    <input type="number" name="duration" value="<?= $_POST['duration'] ?? '' ?>">

    <br><br>



    <label>
        Max members:
    </label>

    <input type="number" name="max_members" value="<?= $_POST['max_members'] ?? '' ?>">

    <br><br>



    <label>
        Trainer:
    </label>


    <select name="trainer_id">


        <option value="">
            Select trainer
        </option>


        <?php foreach ($trainers as $trainer): ?>


            <option value="<?= $trainer['id'] ?>" <?= isset($_POST['trainer_id']) && $_POST['trainer_id'] == $trainer['id'] ? 'selected' : '' ?>>


                <?= $trainer['first_name'] ?>
                <?= $trainer['last_name'] ?>


            </option>


        <?php endforeach; ?>


    </select>



    <br><br>



    <button type="submit">
        Create workout
    </button>


</form>