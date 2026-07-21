<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $number = $_POST["number"];
    $date = $_POST["date"];
    $client = $_POST["client"];
    $product = $_POST["product"];
    $quantity = (int)$_POST["quantity"];
    $onePrice = (float)$_POST["onePrice"];
    $vat = (float)$_POST["vat"];



    $subTotal = $quantity * $onePrice;

    $totalVat = $subTotal * $vat / 100;

    $finalSum = $subTotal + $totalVat;

?>


<table class="invoice-table">

<tr>
    <th>Номер</th>
    <th>Дата</th>
    <th>Клиент</th>
    <th>Продукт</th>
    <th>Количество</th>
    <th>Единична цена</th>
    <th>ДДС</th>
    <th>Крайна сума</th>
</tr>


<tr>

    <td><?= $number ?></td>

    <td><?= $date ?></td>

    <td><?= $client ?></td>

    <td><?= $product ?></td>

    <td><?= $quantity ?></td>

    <td><?= $onePrice ?></td>

    <td><?= $vat ?>% (<?= $totalVat ?>)</td>

    <td><?= $finalSum ?></td>

</tr>


</table>


<?php

} else {

?>


<form method="POST">

    Номер на фактура:
    <input type="text" name="number">
    <br><br>


    Дата:
    <input type="date" name="date">
    <br><br>


    Клиент:
    <input type="text" name="client">
    <br><br>


    Продукт:
    <input type="text" name="product">
    <br><br>


    Количество:
    <input type="number" name="quantity">
    <br><br>


    Единична цена:
    <input type="number" step="0.01" name="onePrice">
    <br><br>


    ДДС (%):
    <input type="number" name="vat" value="20">
    <br><br>


    <button type="submit">
        Генерирай фактура
    </button>


</form>


<?php

}

?>

<style>

.invoice-table {
    border-collapse: collapse;
    width: 90%;
    margin: 20px auto;
    font-family: Arial, sans-serif;
    background-color: white;
}

.invoice-table th {
    background-color: #2c3e50;
    color: white;
    padding: 12px;
    text-align: center;
}

.invoice-table td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.invoice-table tr:nth-child(even) {
    background-color: #f5f5f5;
}



</style>
