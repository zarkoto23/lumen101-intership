<?php

require_once "../includes/header.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Невалидна заявка.");
}



$ticket_type_id = $_POST['ticket_type_id'] ?? null;
$quantity = (int) ($_POST['quantity'] ?? 0);


if (!$ticket_type_id || $quantity <= 0) {
    die("Невалидни данни.");
}

if (!isset($_SESSION['user_id'])) {
    die("Трябва да сте влезли в профила си.");
}

$user_id = $_SESSION['user_id'];





try {


    $pdo->beginTransaction();




    $stmt = $pdo->prepare("
        SELECT *
        FROM ticket_types
        WHERE id = ?
        FOR UPDATE
    ");



    $stmt->execute([$ticket_type_id]);



    $ticket = $stmt->fetch();



    if (!$ticket) {
        throw new Exception("Билетът не съществува.");
    }




    if ($ticket['quantity'] <= 0 || $ticket['quantity'] < $quantity) {
        throw new Exception("Недостатъчна наличност.");
    }





    $total_price = $ticket['price'] * $quantity;






    $order_number = "ORDER-" . strtoupper(bin2hex(random_bytes(3)));






    $stmt = $pdo->prepare("
        INSERT INTO orders
        (order_number, user_id, total_price, status)
        VALUES (?, ?, ?, ?)
    ");



    $stmt->execute([
        $order_number,
        $user_id,
        $total_price,
        "Нова"
    ]);



    $order_id = $pdo->lastInsertId();






    $stmt = $pdo->prepare("
        UPDATE ticket_types
        SET quantity = quantity - ?
        WHERE id = ?
    ");



    $stmt->execute([
        $quantity,
        $ticket_type_id
    ]);








    $stmt = $pdo->prepare("
        INSERT INTO tickets
        (order_id, ticket_type_id, ticket_code)
        VALUES (?, ?, ?)
    ");




    for ($i = 0; $i < $quantity; $i++) {



        $code = "TICKET-" . strtoupper(bin2hex(random_bytes(5)));



        $stmt->execute([
            $order_id,
            $ticket_type_id,
            $code
        ]);

    }





    $pdo->commit();




    echo "Успешна покупка. Номер на поръчка: " . htmlspecialchars($order_number);





} catch (Exception $e) {



    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }



    die($e->getMessage());

}