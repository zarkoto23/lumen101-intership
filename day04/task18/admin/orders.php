<?php

require_once "../includes/header.php";
require_once "../includes/admin_check.php";
require_once "../includes/nav.php";



$stmt = $pdo->query("
    SELECT
        orders.*,
        users.username,
        users.email

    FROM orders

    JOIN users
        ON orders.user_id = users.id

    ORDER BY orders.order_date DESC
");


$orders = $stmt->fetchAll();

?>

<main>

    <h1>
        Поръчки
    </h1>


    <?php foreach ($orders as $order): ?>


        <div>


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



            <a href="order_details.php?id=<?= $order['id'] ?>">
                Детайли
            </a>



            <form method="POST" action="order_status.php">


                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">



                <select name="status">


                    <option value="Нова" <?= $order['status'] === "Нова" ? "selected" : "" ?>>
                        Нова
                    </option>


                    <option value="Платена" <?= $order['status'] === "Платена" ? "selected" : "" ?>>
                        Платена
                    </option>


                    <option value="Отказана" <?= $order['status'] === "Отказана" ? "selected" : "" ?>>
                        Отказана
                    </option>


                    <option value="Завършена" <?= $order['status'] === "Завършена" ? "selected" : "" ?>>
                        Завършена
                    </option>


                </select>


                <button type="submit">
                    Запази
                </button>


            </form>


            <hr>


        </div>


    <?php endforeach; ?>


</main>


<?php

require_once "../includes/footer.php";

?>