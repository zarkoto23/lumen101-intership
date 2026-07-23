<?php

require "../config.php";
require "../nav.php";

$stmt = $pdo->query(
"SELECT 
    memberships.*,
    CONCAT(members.first_name, ' ', members.last_name) AS member_name,
    membership_plans.name AS plan_name

FROM memberships

JOIN members
ON memberships.member_id = members.id

JOIN membership_plans
ON memberships.membership_plan_id = membership_plans.id"
);


$memberships = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<h1>Memberships</h1>


<?php foreach($memberships as $membership): ?>


<p>

Member:
<?= $membership['member_name'] ?>

<br>

Plan:
<?= $membership['plan_name'] ?>

<br>

Start:
<?= $membership['start_date'] ?>

<br>

End:
<?= $membership['end_date'] ?>

<br>

Remaining visits:
<?= $membership['remaining_visits'] ?>

<br>

Status:
<?= $membership['status'] ?>

</p>

<hr>


<?php endforeach; ?>