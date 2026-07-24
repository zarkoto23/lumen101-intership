<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";


$pdo->query("
    UPDATE events
    SET status =
    CASE
        WHEN NOW() > end_date THEN 'Приключило'
        WHEN NOW() BETWEEN start_date AND end_date THEN 'Провежда се'
        ELSE 'Предстоящо'
    END
");



$stmt = $pdo->query("
    SELECT 
        events.*,
        categories.name AS category_name

    FROM events

    JOIN categories 
        ON events.category_id = categories.id

    ORDER BY start_date ASC
");


$events = $stmt->fetchAll();

?>

<main>

<h1>
    Управление на събития
</h1>



<a href="event_create.php">
    Добави събитие
</a>



<hr>



<?php foreach ($events as $event): ?>


<div>


<h2>
    <?= htmlspecialchars($event['name']) ?>
</h2>



<?php if (!empty($event['image'])): ?>


<img
    src="../uploads/<?= htmlspecialchars($event['image']) ?>"
    width="200"
>


<?php endif; ?>



<p>
    Категория:
    <?= htmlspecialchars($event['category_name']) ?>
</p>



<p>
    Описание:
    <?= htmlspecialchars($event['description']) ?>
</p>



<p>
    Място:
    <?= htmlspecialchars($event['location']) ?>
</p>



<p>
    Начало:
    <?= htmlspecialchars($event['start_date']) ?>
</p>



<p>
    Край:
    <?= htmlspecialchars($event['end_date']) ?>
</p>



<p>
    Статус:
    <?= htmlspecialchars($event['status']) ?>
</p>



<a href="event_edit.php?id=<?= $event['id'] ?>">
    Редакция
</a>


|


<a href="event_delete.php?id=<?= $event['id'] ?>">
    Изтриване
</a>


|


<a href="ticket_types.php?event_id=<?= $event['id'] ?>">
    Билети
</a>



</div>


<hr>
//


<?php endforeach; ?>


</main>



<?php
require_once "../includes/footer.php";
?>