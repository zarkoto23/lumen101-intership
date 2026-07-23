<?php

require "../config.php";
require "../nav.php";


$id = $_GET['id'];


$stmt = $pdo->prepare(
    "SELECT * FROM members WHERE id = ?"
);

$stmt->execute([$id]);

$member = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $pdo->prepare(
        "UPDATE members SET
        first_name = ?,
        last_name = ?,
        email = ?,
        phone = ?,
        birth_date = ?
        WHERE id = ?"
    );


    $stmt->execute([
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['birth_date'],
        $id
    ]);


    header("Location: index.php");
    exit;
}

?>


<h1>Edit client</h1>


<form method="POST">

    <input type="text" name="first_name" value="<?= $member['first_name'] ?>">


    <input type="text" name="last_name" value="<?= $member['last_name'] ?>">


    <input type="email" name="email" value="<?= $member['email'] ?>">


    <input type="text" name="phone" value="<?= $member['phone'] ?>">


    <input type="date" name="birth_date" value="<?= $member['birth_date'] ?>">


    <button>
        Save changes
    </button>

</form>