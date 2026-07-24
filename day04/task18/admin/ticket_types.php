<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";

if (!isset($_GET['event_id'])) {
    die("Липсва събитие.");
}

$event_id = $_GET['event_id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM events
    WHERE id = ?
");

$stmt->execute([$event_id]);

$event = $stmt->fetch();

if (!$event) {
    die("Събитието не съществува.");
}


$stmt = $pdo->prepare("
    SELECT *
    FROM ticket_types
    WHERE event_id = ?
");

$stmt->execute([$event_id]);

$tickets = $stmt->fetchAll();
?>

<main>

<h1>
    Билети за:
    <?= htmlspecialchars($event['name']) ?>
</h1>


<a href="ticket_type_create.php?event_id=<?= $event_id ?>">
    Добави вид билет
</a>


<hr>


<?php foreach ($tickets as $ticket): ?>

    <div>

        <h3>
            <?= htmlspecialchars($ticket['name']) ?>
        </h3>

        <p>
            Цена:
            <?= htmlspecialchars($ticket['price']) ?> лв.
        </p>

        <p>
            Наличност:
            <?= htmlspecialchars($ticket['quantity']) ?>
        </p>

        <a href="ticket_type_edit.php?id=<?= $ticket['id'] ?>&event_id=<?= $event_id ?>">
    Редакция
</a>

        <a href="ticket_type_delete.php?id=<?= $ticket['id'] ?>&event_id=<?= $event_id ?>">
    Изтрий
</a>

    </div>

    <hr>

<?php endforeach; ?>


</main>


<?php
require_once "../includes/footer.php";
?>