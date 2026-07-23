<?php

require "../config.php";
require "../nav.php";


$workout_id = $_GET['id'];

$stmt = $pdo->query(
    "SELECT id, first_name, last_name 
     FROM members"
);


$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $stmt = $pdo->prepare(
        "SELECT COUNT(*) 
         FROM workout_members
         WHERE member_id = ? 
         AND workout_id = ?"
    );


    $stmt->execute([
        $_POST['member_id'],
        $workout_id
    ]);


    $alreadyRegistered = $stmt->fetchColumn();


    if ($alreadyRegistered > 0) {

        echo "This member is already registered.";

        exit;

    }

    $stmt = $pdo->prepare(
        "SELECT max_members 
     FROM workouts
     WHERE id = ?"
    );

    $stmt->execute([$workout_id]);

    $maxMembers = $stmt->fetchColumn();



    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
     FROM workout_members
     WHERE workout_id = ?"
    );

    $stmt->execute([$workout_id]);

    $currentMembers = $stmt->fetchColumn();



    if ($currentMembers >= $maxMembers) {

        echo "Workout is full.";

        exit;

    }

    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
     FROM memberships
     WHERE member_id = ?
     AND status = 'active'
     AND end_date >= CURDATE()
     AND remaining_visits > 0"
    );


    $stmt->execute([
        $_POST['member_id']
    ]);


    $hasMembership = $stmt->fetchColumn();



    if ($hasMembership == 0) {

        echo "Member has no active membership.";

        exit;

    }

    $stmt = $pdo->prepare(
        "INSERT INTO workout_members
    (member_id, workout_id)
    VALUES (?, ?)"
    );


    $stmt->execute([
        $_POST['member_id'],
        $workout_id
    ]);

    $stmt = $pdo->prepare(
        "UPDATE memberships
     SET remaining_visits = remaining_visits - 1
     WHERE member_id = ?
     AND status = 'active'
     AND end_date >= CURDATE()
     AND remaining_visits > 0"
    );


    $stmt->execute([
        $_POST['member_id']
    ]);


    header("Location: members.php?id=$workout_id");
    exit;

}


?>


<h1>Register member for workout</h1>

<form method="POST">


    <label>
        Choose member:
    </label>


    <select name="member_id">


        <?php foreach ($members as $member): ?>


            <option value="<?= $member['id'] ?>">

                <?= $member['first_name'] ?>
                <?= $member['last_name'] ?>

            </option>


        <?php endforeach; ?>


    </select>


    <br>


    <button>
        Register
    </button>


</form>