<nav>

    <a href="/day04/task18/index.php">
        Начало
    </a>


    <?php if (isset($_SESSION['user_id'])): ?>


        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>


            <a href="/day04/task18/admin/events.php">
                Събития
            </a>


            <a href="/day04/task18/admin/dashboard.php">
                Админ
            </a>


            <a href="/day04/task18/admin/users.php">
                Потребители
            </a>


            <a href="/day04/task18/admin/orders.php">
                Поръчки
            </a>


            <a href="/day04/task18/admin/check_ticket.php">
                Проверка билет
            </a>



        <?php else: ?>


            <a href="/day04/task18/user/events.php">
                Събития
            </a>


            <a href="/day04/task18/user/my_tickets.php">
                Моите билети
            </a>


            <a href="/day04/task18/user/orders.php">
                Моите поръчки
            </a>


        <?php endif; ?>



        <a href="/day04/task18/user/logout.php">
            Изход
        </a>



    <?php else: ?>


        <a href="/day04/task18/user/login.php">
            Вход
        </a>


        <a href="/day04/task18/user/register.php">
            Регистрация
        </a>



    <?php endif; ?>


</nav>