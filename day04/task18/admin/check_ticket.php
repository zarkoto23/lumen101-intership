<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";


$ticket = null;
$message = null;



if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $code = trim($_POST['code'] ?? "");



    $stmt = $pdo->prepare("
        SELECT
            tickets.*,
            events.name AS event_name,
            events.start_date,
            ticket_types.name AS ticket_name

        FROM tickets

        JOIN ticket_types
            ON tickets.ticket_type_id = ticket_types.id

        JOIN events
            ON ticket_types.event_id = events.id

        WHERE tickets.ticket_code = ?
    ");



    $stmt->execute([$code]);

    $ticket = $stmt->fetch();



    if (!$ticket) {


        $message = "Невалиден код.";


    } else {



        if (isset($_POST['use_ticket'])) {



            if ($ticket['is_used']) {


                $message = "Този билет вече е използван.";


            } else {


                $stmt = $pdo->prepare("
                    UPDATE tickets
                    SET is_used = TRUE
                    WHERE id = ?
                ");



                $stmt->execute([
                    $ticket['id']
                ]);



                $message = "Билетът е отбелязан като използван.";


                $ticket['is_used'] = 1;

            }


        }


    }


}


?>

<main>


    <h1>
        Проверка на билет
    </h1>



    <form method="POST">


        <input type="text" name="code" placeholder="Код на билет" required>


        <button type="submit">
            Провери
        </button>


    </form>



    <?php if ($message): ?>


        <p>
            <?= htmlspecialchars($message) ?>
        </p>


    <?php endif; ?>




    <?php if ($ticket): ?>


        <hr>



        <h2>
            <?= htmlspecialchars($ticket['event_name']) ?>
        </h2>



        <p>
            Вид билет:
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




        <?php if (!$ticket['is_used']): ?>


            <form method="POST">


                <input type="hidden" name="code" value="<?= htmlspecialchars($ticket['ticket_code']) ?>">


                <button type="submit" name="use_ticket">
                    Използвай билет
                </button>


            </form>


        <?php endif; ?>



    <?php endif; ?>


</main>



<?php
require_once "../includes/footer.php";
?>