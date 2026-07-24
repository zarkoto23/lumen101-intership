<?php

require_once "../includes/header.php";
require_once "../includes/admin_check.php";
require_once "../includes/nav.php";



if (!isset($_GET['id'])) {

    die("Липсва ID на поръчката.");

}



$order_id = $_GET['id'];





$stmt = $pdo->prepare("

    SELECT

        orders.*,
        users.username,
        users.email

    FROM orders

    JOIN users
        ON orders.user_id = users.id

    WHERE orders.id = ?

");



$stmt->execute([$order_id]);



$order = $stmt->fetch();



if (!$order) {

    die("Поръчката не съществува.");

}






$stmt = $pdo->prepare("

    SELECT

        tickets.*,

        ticket_types.name AS ticket_name,

        ticket_types.price,

        events.name AS event_name,
        events.start_date


    FROM tickets


    JOIN ticket_types
        ON tickets.ticket_type_id = ticket_types.id


    JOIN events
        ON ticket_types.event_id = events.id


    WHERE tickets.order_id = ?

");



$stmt->execute([$order_id]);



$tickets = $stmt->fetchAll();



?>



<main>


<h1>
    Детайли на поръчка
</h1>




<h2>
    <?= htmlspecialchars($order['order_number']) ?>
</h2>



<p>
    Потребител:
    <?= htmlspecialchars($order['username']) ?>
</p>



<p>
    Email:
    <?= htmlspecialchars($order['email']) ?>
</p>



<p>
    Дата:
    <?= htmlspecialchars($order['order_date']) ?>
</p>



<p>
    Обща цена:
    <?= htmlspecialchars($order['total_price']) ?> лв.
</p>



<p>
    Статус:
    <?= htmlspecialchars($order['status']) ?>
</p>



<hr>



<h2>
    Билети
</h2>





<?php foreach ($tickets as $ticket): ?>



<div>



<h3>
    <?= htmlspecialchars($ticket['event_name']) ?>
</h3>



<p>
    Вид билет:
    <?= htmlspecialchars($ticket['ticket_name']) ?>
</p>



<p>
    Цена:
    <?= htmlspecialchars($ticket['price']) ?> лв.
</p>



<p>
    Дата на събитието:
    <?= htmlspecialchars($ticket['start_date']) ?>
</p>



<p>
    Код:
    <?= htmlspecialchars($ticket['ticket_code']) ?>
</p>



<p>
    Статус:

    <?= $ticket['is_used'] 
        ? "Използван" 
        : "Валиден" 
    ?>

</p>



</div>



<hr>



<?php endforeach; ?>



<a href="orders.php">
    Назад към поръчките
</a>



</main>



<?php

require_once "../includes/footer.php";

?>