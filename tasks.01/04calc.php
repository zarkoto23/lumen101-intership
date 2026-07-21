<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $productName = $_POST["productName"];
    $onePrice = $_POST["onePrice"];
    $quantity = $_POST["quantity"];
    $delivery = $_POST["delivery"];
    $discount = $_POST["discount"];

 
    $totalPrice=$quantity*$onePrice;

    if($quantity>=5){
        $discount+=5;
    }

    $discountValue=$totalPrice*$discount/100;

    $totalAfterDiscount=$totalPrice-$discountValue;

    $finalPrice=$totalAfterDiscount+$delivery;

    echo "---------------------------<br>";

    echo "Продукт:<br>";
    echo "$productName<br>";
    echo "<br>";

    echo "Цена:<br>";
    echo "$onePrice<br>";
    echo "<br>";

    echo "Количество:<br>";
    echo "$quantity<br>";
    echo "<br>";

    echo "Отстръпка:<br>";
    echo $discount."%<br>";
    echo "<br>";

    echo "Доставка:<br>";
    echo "$delivery<br>";
    echo "<br>";

    echo "Крайна цена с приложена отстъпка:<br>";
    echo "$finalPrice<br>";

    echo "---------------------------<br>";







   
} else {

?>

<form method="POST">

    Име на продукт:
    <input type="text" name="productName">
    <br>

    Единична цена:
    <input type="text" name="onePrice">
    <br>

    Количество:
    <input type="number" name="quantity">
    <br>

    Цена на доставка:
    <input type="text" name="delivery">
    <br>

    Отстъпка %:
    <input type="text" name="discount">
    <br>

    <button type="submit">Изпрати</button>

</form>

<?php
}
?>