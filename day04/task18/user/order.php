<?php

require_once "../includes/header.php";
require_once "../includes/nav.php";


$user_id = $_SESSION['user_id'] ?? 1;



if (!isset($_GET['id'])) {

    die("Липсва поръчка.");

}



$order_id = $_GET['id'];



$stmt = $pdo->prepare("
    SELECT *
    FROM orders
    WHERE id = ?
    AND user_id = ?
");


$stmt->execute([
    $order_id,
    $user_id
]);


$order = $stmt->fetch();



if (!$order) {

    die("Поръчката не съществува.");

}





$stmt = $pdo->prepare("
    SELECT
        tickets.*,
        ticket_types.name AS ticket_name,
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
        Поръчка <?= htmlspecialchars($order['order_number']) ?>
    </h1>



    <p>
        Дата:
        <?= htmlspecialchars($order['order_date']) ?>
    </p>



    <p>
        Статус:
        <?= htmlspecialchars($order['status']) ?>
    </p>



    <p>
        Обща цена:
        <?= htmlspecialchars($order['total_price']) ?> лв.
    </p>



    <h2>
        Билети
    </h2>




    <?php foreach ($tickets as $ticket): ?>


        <div>


            <h3>
                <?= htmlspecialchars($ticket['event_name']) ?>
            </h3>


            <p>
                Вид:
                <?= htmlspecialchars($ticket['ticket_name']) ?>
            </p>


            <p>
                Дата:
                <?= htmlspecialchars($ticket['start_date']) ?>
            </p>

            <p>
                Код:
                <?= htmlspecialchars($ticket['ticket_code']) ?>
            </p>


            <p>
                Статус:
                <?= $ticket['is_used'] ? "Използван" : "Валиден" ?>
            </p>



        </div>


        <hr>


    <?php endforeach; ?>


</main>



<?php
require_once "../includes/footer.php";
?>