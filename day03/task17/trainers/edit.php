<?php

require "../config.php";
require "../nav.php";


$id = $_GET['id'];


$stmt = $pdo->prepare(
    "SELECT * FROM trainers WHERE id = ?"
);

$stmt->execute([$id]);


$trainer = $stmt->fetch(PDO::FETCH_ASSOC);



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $stmt = $pdo->prepare(
        "UPDATE trainers SET
        first_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        specialization = ?
        WHERE id = ?"
    );


    $stmt->execute([
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['specialization'],
        $id
    ]);


    header("Location: index.php");
    exit;

}


?>


<h1>Edit trainer</h1>


<form method="POST">


    <label>
        First name:
    </label>

    <input type="text" name="first_name" value="<?= $trainer['first_name'] ?>">


    <br>


    <label>
        Last name:
    </label>

    <input type="text" name="last_name" value="<?= $trainer['last_name'] ?>">


    <br>


    <label>
        Email:
    </label>

    <input type="email" name="email" value="<?= $trainer['email'] ?>">


    <br>


    <label>
        Phone:
    </label>

    <input type="text" name="phone" value="<?= $trainer['phone'] ?>">


    <br>


    <label>
        Specialization:
    </label>

    <input type="text" name="specialization" value="<?= $trainer['specialization'] ?>">


    <br>


    <button>
        Save changes
    </button>


</form>