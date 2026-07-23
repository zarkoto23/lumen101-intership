<?php

require "../config.php";
require "../nav.php";


$stmt = $pdo->query(
    "SELECT *
     FROM membership_plans"
);


$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<h1>Membership Plans</h1>


<a href="create.php">
    Add plan
</a>


<br><br>


<?php foreach ($plans as $plan): ?>


    <p>

        <strong>
            <?= $plan['name'] ?>
        </strong>

        <br>

        Duration:
        <?= $plan['duration_days'] ?> days

        <br>

        Price:
        <?= $plan['price'] ?>

        <br>

        Visits:
        <?= $plan['visits_limit'] ?>

    </p>


    <hr>


<?php endforeach; ?>