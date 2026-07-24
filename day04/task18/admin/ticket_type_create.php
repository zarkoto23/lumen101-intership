<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";

if (!isset($_GET['event_id'])) {
    die("Липсва събитие.");
}

$event_id = $_GET['event_id'];

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
        INSERT INTO ticket_types
        (event_id, name, price, quantity)
        VALUES (?, ?, ?, ?)
    ");


    $stmt->execute([
        $event_id,
        $name,
        $price,
        $quantity
    ]);


    header("Location: ticket_types.php?event_id=" . $event_id);
    exit;
}
?>

<main>

<h1>Добавяне на вид билет</h1>


<form method="POST">

    <label>
        Име:
        <input 
            type="text" 
            name="name" 
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
            required
        >
    </label>

    <br>


    <label>
        Количество:
        <input 
            type="number" 
            name="quantity"
            required
        >
    </label>


    <br><br>


    <button type="submit">
        Добави
    </button>


</form>


</main>


<?php
require_once "../includes/footer.php";
?>