<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";


if (!isset($_SESSION['user_id'])) {
    die("Трябва да сте влезли в профила си.");
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    SELECT 
        tickets.*,
        ticket_types.name AS ticket_name,
        ticket_types.price,
        events.name AS event_name,
        events.start_date,
        orders.order_date

    FROM tickets


    JOIN ticket_types
        ON tickets.ticket_type_id = ticket_types.id


    JOIN events
        ON ticket_types.event_id = events.id


    JOIN orders
        ON tickets.order_id = orders.id


    WHERE orders.user_id = ?

    ORDER BY tickets.created_at DESC
");



$stmt->execute([$user_id]);



$tickets = $stmt->fetchAll();

?>


<main>


    <h1>
        Моите билети
    </h1>

    <a href="orders.php">
        Моите поръчки
    </a>



    <?php if (count($tickets) > 0): ?>



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
                    Купен на:
                    <?= htmlspecialchars($ticket['order_date']) ?>
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



    <?php else: ?>


        <p>
            Нямате закупени билети.
        </p>



    <?php endif; ?>



</main>



<?php
require_once "../includes/footer.php";
?>