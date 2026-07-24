<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";


if (!isset($_GET['id']) || !isset($_GET['event_id'])) {
    die("Липсват данни.");
}


$id = $_GET['id'];
$event_id = $_GET['event_id'];


$stmt = $pdo->prepare("
    SELECT *
    FROM ticket_types
    WHERE id = ?
");


$stmt->execute([$id]);

$ticket = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];


    if ($price < 0) {
        die("Цената не може да бъде отрицателна.");
    }


    if ($quantity < 0) {
        die("Количеството не може да бъде отрицателно.");
    }


    $stmt = $pdo->prepare("
        UPDATE ticket_types
        SET
            name = ?,
            price = ?,
            quantity = ?
        WHERE id = ?
    ");


    $stmt->execute([
        $name,
        $price,
        $quantity,
        $id
    ]);


    header("Location: ticket_types.php?event_id=" . $event_id);
    exit;
}


if (!$ticket) {
    die("Билетът не съществува.");
}

?>


<main>

<h1>Редакция на билет</h1>


<form method="POST">


    <label>
        Име:

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($ticket['name']) ?>"
            required
        >

    </label>


    <br>


    <label>
        Цена:

        <input
            type="number"
            name="price"
            step="0.01"
            value="<?= htmlspecialchars($ticket['price']) ?>"
            required
        >

    </label>


    <br>


    <label>
        Количество:

        <input
            type="number"
            name="quantity"
            value="<?= htmlspecialchars($ticket['quantity']) ?>"
            required
        >

    </label>


    <br><br>


    <button type="submit">
        Запази
    </button>


</form>


</main>


<?php
require_once "../includes/footer.php";
?>