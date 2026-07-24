<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";


if (!isset($_GET['id'])) {
    die("Липсва събитие.");
}


$id = $_GET['id'];



$stmt = $pdo->prepare("
    SELECT 
        events.*,
        categories.name AS category_name
    FROM events
    JOIN categories
        ON events.category_id = categories.id
    WHERE events.id = ?
");


$stmt->execute([$id]);

$event = $stmt->fetch();



if (!$event) {
    die("Събитието не съществува.");
}




$stmt = $pdo->prepare("
    SELECT *
    FROM ticket_types
    WHERE event_id = ?
");


$stmt->execute([$id]);

$tickets = $stmt->fetchAll();

?>

<main>


    <h1>
        <?= htmlspecialchars($event['name']) ?>
    </h1>



    <?php if (!empty($event['image'])): ?>

        <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" width="300">

    <?php endif; ?>



    <p>
        Категория:
        <?= htmlspecialchars($event['category_name']) ?>
    </p>



    <p>
        Статус:
        <?= htmlspecialchars($event['status']) ?>
    </p>



    <p>
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




    <h2>
        Билети
    </h2>



    <?php if (count($tickets) > 0): ?>



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
                    Налични:
                    <?= htmlspecialchars($ticket['quantity']) ?>
                </p>




                <?php if ($ticket['quantity'] > 0): ?>


                    <form method="POST" action="buy_ticket.php">


                        <input type="hidden" name="ticket_type_id" value="<?= htmlspecialchars($ticket['id']) ?>">



                        <label>

                            Количество:

                            <input type="number" name="quantity" min="1" max="<?= htmlspecialchars($ticket['quantity']) ?>"
                                value="1">

                        </label>



                        <button type="submit">
                            Купи билет
                        </button>


                    </form>



                <?php else: ?>


                    <p>
                        Изчерпани билети
                    </p>



                <?php endif; ?>


            </div>


            <hr>


        <?php endforeach; ?>



    <?php else: ?>


        <p>
            Няма налични билети за това събитие.
        </p>



    <?php endif; ?>



</main>



<?php
require_once "../includes/footer.php";
?>