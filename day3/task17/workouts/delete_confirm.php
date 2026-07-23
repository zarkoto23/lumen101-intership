<?php

require "../config.php";
require "../nav.php";


$id = $_GET['id'];


$stmt = $pdo->prepare(
    "DELETE FROM workouts WHERE id = ?"
);


$stmt->execute([$id]);


header("Location: index.php");
exit;