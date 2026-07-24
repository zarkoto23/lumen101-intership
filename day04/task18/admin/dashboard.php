<?php

require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM users
");

$total_users = $stmt->fetchColumn();

$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM events
");

$total_events = $stmt->fetchColumn();


$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM tickets
");

$total_tickets = $stmt->fetchColumn();


$stmt = $pdo->query("
    SELECT SUM(total_price)
    FROM orders
    WHERE status != 'Отказана'
");

$total_income = $stmt->fetchColumn();

$total_income = $total_income ?? 0;



$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM events
    WHERE start_date > NOW()
");

$stmt->execute();

$upcoming_events = $stmt->fetchColumn();






$stmt = $pdo->query("
    SELECT
        events.name,
        COUNT(tickets.id) AS sold_count

    FROM events

    JOIN ticket_types
        ON events.id = ticket_types.event_id

    JOIN tickets
        ON ticket_types.id = tickets.ticket_type_id

    GROUP BY events.id

    ORDER BY sold_count DESC

    LIMIT 1
");


$popular_event = $stmt->fetch();






$stmt = $pdo->query("
    SELECT
        events.name

    FROM events

    JOIN ticket_types
        ON events.id = ticket_types.event_id

    GROUP BY events.id

    HAVING SUM(ticket_types.quantity) = 0
");


$sold_out_events = $stmt->fetchAll();






$stmt = $pdo->query("
    SELECT COUNT(*)
    FROM orders
    WHERE status = 'Отказана'
");


$cancelled_orders = $stmt->fetchColumn();



?>


<main>


    <h1>
        Dashboard
    </h1>




    <div>


        <h3>
            Потребители:
            <?= $total_users ?>
        </h3>



        <h3>
            Общо събития:
            <?= $total_events ?>
        </h3>



        <h3>
            Продадени билети:
            <?= $total_tickets ?>
        </h3>



        <h3>
            Общи приходи:
            <?= number_format($total_income, 2) ?> лв.
        </h3>



        <h3>
            Предстоящи събития:
            <?= $upcoming_events ?>
        </h3>



        <h3>
            Отказани поръчки:
            <?= $cancelled_orders ?>
        </h3>



        <h3>
            Най-популярно събитие:

            <?php if ($popular_event): ?>

                <?= htmlspecialchars($popular_event['name']) ?>

                (
                <?= $popular_event['sold_count'] ?>
                билета
                )

            <?php else: ?>

                Няма продажби

            <?php endif; ?>

        </h3>




        <h3>
            Изчерпани събития:
        </h3>



        <?php if ($sold_out_events): ?>


            <ul>

                <?php foreach ($sold_out_events as $event): ?>

                    <li>
                        <?= htmlspecialchars($event['name']) ?>
                    </li>

                <?php endforeach; ?>

            </ul>



        <?php else: ?>


            <p>
                Няма изчерпани събития.
            </p>


        <?php endif; ?>


    </div>


</main>



<?php

require_once "../includes/footer.php";

?>