<?php

require "../config.php";
require "../nav.php";


$id = $_GET['id'];


$stmt = $pdo->prepare(
    "DELETE FROM trainers WHERE id = ?"
);


$stmt->execute([$id]);


header("Location: index.php");
exit;