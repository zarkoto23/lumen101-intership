<?php

require "config.php";
require "nav.php";



$stmt = $pdo->query(
    "SELECT COUNT(*) FROM members"
);

$membersCount = $stmt->fetchColumn();



$stmt = $pdo->query(
    "SELECT COUNT(*)
     FROM memberships
     WHERE status = 'active'
     AND end_date >= CURDATE()"
);

$activeMemberships = $stmt->fetchColumn();



$stmt = $pdo->query(
    "SELECT COUNT(*) FROM trainers"
);

$trainersCount = $stmt->fetchColumn();



$stmt = $pdo->query(
    "SELECT COUNT(*) FROM workouts"
);

$workoutsCount = $stmt->fetchColumn();



$stmt = $pdo->query(
    "SELECT 
        workouts.name,
        COUNT(workout_members.id) AS participants

     FROM workouts

     LEFT JOIN workout_members
     ON workouts.id = workout_members.workout_id

     GROUP BY workouts.id

     ORDER BY participants DESC

     LIMIT 1"
);


$popularWorkout = $stmt->fetch(PDO::FETCH_ASSOC);


?>



<h1>Dashboard</h1>



<div class="dashboard-card">

    <h3>
        Clients
    </h3>

    <p>
        <?= $membersCount ?>
    </p>

</div>



<div class="dashboard-card">

    <h3>
        Active memberships
    </h3>

    <p>
        <?= $activeMemberships ?>
    </p>

</div>



<div class="dashboard-card">

    <h3>
        Trainers
    </h3>

    <p>
        <?= $trainersCount ?>
    </p>

</div>



<div class="dashboard-card">

    <h3>
        Workouts
    </h3>

    <p>
        <?= $workoutsCount ?>
    </p>

</div>




<h2>
    Most attended workout
</h2>



<?php if ($popularWorkout): ?>


    <div class="dashboard-card">


        <h3>
            <?= $popularWorkout['name'] ?>
        </h3>


        <p>

            <?= $popularWorkout['participants'] ?>

            participants

        </p>


    </div>



<?php else: ?>


    <div class="dashboard-card">

        <p>
            No workouts yet
        </p>

    </div>


<?php endif; ?>