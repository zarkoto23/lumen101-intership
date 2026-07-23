<?php

require "../config.php";
require "../nav.php";


$id = $_GET['id'];

$stmt = $pdo->prepare(
    "SELECT 
        members.first_name,
        members.last_name,
        members.email
    FROM workout_members
    JOIN members
    ON workout_members.member_id = members.id
    WHERE workout_members.workout_id = ?"
);


$stmt->execute([$id]);


$members = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<h1>Workout participants</h1>


<?php if (count($members) > 0): ?>

    <?php foreach ($members as $member): ?>

        <p>
            <?= $member['first_name'] ?>
            <?= $member['last_name'] ?>
            -
            <?= $member['email'] ?>
        </p>

    <?php endforeach; ?>

<?php else: ?>

    <p>
        No participants yet.
    </p>

<?php endif; ?>