<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";




$pdo->query("
    UPDATE events
    SET status =
    CASE
        WHEN NOW() > end_date THEN 'Приключило'
        WHEN NOW() BETWEEN start_date AND end_date THEN 'Провежда се'
        ELSE 'Предстоящо'
    END
");



$categories = $pdo->query("
    SELECT *
    FROM categories
")->fetchAll();



$sql = "
    SELECT 
        events.*,
        categories.name AS category_name,
        MIN(ticket_types.price) AS min_price

    FROM events

    JOIN categories 
        ON events.category_id = categories.id

    LEFT JOIN ticket_types
        ON ticket_types.event_id = events.id
";



$where = [];
$having = [];
$params = [];



if (!empty($_GET['search'])) {

    $where[] = "events.name LIKE ?";

    $params[] = "%" . $_GET['search'] . "%";

}



if (!empty($_GET['category'])) {

    $where[] = "events.category_id = ?";

    $params[] = $_GET['category'];

}



if (!empty($_GET['date_from'])) {

    $where[] = "events.start_date >= ?";

    $params[] = $_GET['date_from'];

}



if (!empty($_GET['date_to'])) {

    $where[] = "events.start_date <= ?";

    $params[] = $_GET['date_to'];

}



if (!empty($_GET['min_price'])) {

    $having[] = "MIN(ticket_types.price) >= ?";

    $params[] = $_GET['min_price'];

}



if (!empty($_GET['max_price'])) {

    $having[] = "MIN(ticket_types.price) <= ?";

    $params[] = $_GET['max_price'];

}



if (!empty($where)) {

    $sql .= " WHERE " . implode(" AND ", $where);

}



$sql .= "
    GROUP BY events.id
";



if (!empty($having)) {

    $sql .= " HAVING " . implode(" AND ", $having);

}



if (!empty($_GET['sort'])) {


    if ($_GET['sort'] === "date") {

        $sql .= " ORDER BY events.start_date ASC";

    }


    if ($_GET['sort'] === "price") {

        $sql .= " ORDER BY min_price ASC";

    }


} else {

    $sql .= " ORDER BY events.start_date ASC";

}



$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$events = $stmt->fetchAll();

?>

<main>


    <h1>
        Събития
    </h1>




    <form method="GET">



        <input type="text" name="search" placeholder="Търсене по име"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">




        <select name="category">


            <option value="">
                Всички категории
            </option>



            <?php foreach ($categories as $category): ?>


                <option value="<?= $category['id'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? "selected" : "" ?>>

                    <?= htmlspecialchars($category['name']) ?>

                </option>


            <?php endforeach; ?>


        </select>




        <br><br>



        <label>
            От дата:
        </label>


        <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">



        <label>
            До дата:
        </label>


        <input type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">




        <br><br>



        <input type="number" name="min_price" placeholder="Минимална цена"
            value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">




        <input type="number" name="max_price" placeholder="Максимална цена"
            value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">




        <select name="sort">


            <option value="">
                Сортиране
            </option>



            <option value="date" <?= ($_GET['sort'] ?? '') === "date" ? "selected" : "" ?>>
                По дата
            </option>



            <option value="price" <?= ($_GET['sort'] ?? '') === "price" ? "selected" : "" ?>>
                По цена
            </option>



        </select>




        <button type="submit">
            Филтрирай
        </button>



    </form>



    <hr>





    <?php foreach ($events as $event): ?>


        <div>



            <h2>
                <?= htmlspecialchars($event['name']) ?>
            </h2>




            <?php if (!empty($event['image'])): ?>


                <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" width="200">


            <?php endif; ?>




            <p>
                Категория:
                <?= htmlspecialchars($event['category_name']) ?>
            </p>




            <p>
                Описание:
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




            <p>
                Статус:
                <?= htmlspecialchars($event['status']) ?>
            </p>




            <p>
                Минимална цена:
                <?= htmlspecialchars($event['min_price'] ?? 'Няма билети') ?>
                лв.
            </p>




            <a href="event.php?id=<?= $event['id'] ?>">
                Детайли
            </a>



        </div>



        <hr>



    <?php endforeach; ?>



</main>



<?php
require_once "../includes/footer.php";
?>