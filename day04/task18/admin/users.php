<?php

require_once "../includes/header.php";
require_once "../includes/admin_check.php";
require_once "../includes/nav.php";



$stmt = $pdo->query("

    SELECT 
        users.*,
        COUNT(orders.id) AS orders_count

    FROM users

    LEFT JOIN orders
        ON users.id = orders.user_id

    GROUP BY users.id

    ORDER BY users.id ASC

");



$users = $stmt->fetchAll();

?>



<main>


    <h1>
        Потребители
    </h1>




    <?php foreach ($users as $user): ?>



        <div>


            <h2>
                <?= htmlspecialchars($user['username']) ?>
            </h2>



            <p>
                Email:
                <?= htmlspecialchars($user['email']) ?>
            </p>



            <p>
                Роля:
                <?= htmlspecialchars($user['role']) ?>
            </p>



            <p>
                Брой поръчки:
                <?= htmlspecialchars($user['orders_count']) ?>
            </p>



            <p>
                Регистриран:
                <?= htmlspecialchars($user['created_at']) ?>
            </p>




            <form method="POST" action="user_role.php">



                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">




                <select name="role">



                    <option value="user" <?= $user['role'] === "user" ? "selected" : "" ?>>
                        User
                    </option>




                    <option value="admin" <?= $user['role'] === "admin" ? "selected" : "" ?>>
                        Admin
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