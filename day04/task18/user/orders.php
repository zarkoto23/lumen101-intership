<?php

require_once "../includes/header.php";
require_once "../includes/nav.php";


if (!isset($_SESSION['user_id'])) {

    die("Трябва да сте влезли в профила си.");

}


$user_id = $_SESSION['user_id'];



$stmt = $pdo->prepare("
    SELECT *
    FROM orders
    WHERE user_id = ?
    ORDER BY order_date DESC
");



$stmt->execute([$user_id]);



$orders = $stmt->fetchAll();

?>


<main>


    <h1>
        Моите поръчки
    </h1>



    <?php if (count($orders) > 0): ?>



        <?php foreach ($orders as $order): ?>


            <div>


                <h2>
                    <?= htmlspecialchars($order['order_number']) ?>
                </h2>



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



                <a href="order.php?id=<?= $order['id'] ?>">
                    Детайли
                </a>



            </div>



            <hr>


        <?php endforeach; ?>



    <?php else: ?>


        <p>
            Нямате направени поръчки.
        </p>



    <?php endif; ?>


</main>



<?php

require_once "../includes/footer.php";

?>