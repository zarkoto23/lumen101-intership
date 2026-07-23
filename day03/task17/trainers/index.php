<?php

require "../config.php";
require "../nav.php";


$stmt = $pdo->query(
    "SELECT * FROM trainers"
);


$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Trainers</h1>

<a href="create.php">
    Add trainer
</a>


<table border="1">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Specialization</th>
        <th>Actions</th>
    </tr>


    <?php foreach ($trainers as $trainer): ?>

        <tr>

            <td>
                <?= $trainer['id'] ?>
            </td>

            <td>
                <?= $trainer['first_name'] ?>
                <?= $trainer['last_name'] ?>
            </td>

            <td>
                <?= $trainer['email'] ?>
            </td>

            <td>
                <?= $trainer['phone'] ?>
            </td>

            <td>
                <?= $trainer['specialization'] ?>
            </td>


            <td>

                <a href="edit.php?id=<?= $trainer['id'] ?>">
                    Edit
                </a>


                <a href="delete.php?id=<?= $trainer['id'] ?>">
                    Delete
                </a>

            </td>

        </tr>


    <?php endforeach; ?>


</table>