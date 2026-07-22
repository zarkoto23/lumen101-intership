<?php

$product = [
    "name" => "Gaming Laptop",
    "description" => "Лаптоп за игри",
    "price" => 1500,
    "quantity" => 5,
    "brand" => "Lenovo",
    "category" => "Electronics",
    "available" => true
];

$status = $product["available"] ? "В наличност" : "Изчерпан";

$statusClass = $product["available"] ? "available" : "not-available";

?>

<div class="card">

    <h2><?= $product["name"] ?></h2>

    <p>
        <strong>Описание:</strong>
        <?= $product["description"] ?>
    </p>

    <p>
        <strong>Марка:</strong>
        <?= $product["brand"] ?>
    </p>

    <p>
        <strong>Категория:</strong>
        <?= $product["category"] ?>
    </p>

    <p>
        <strong>Цена:</strong>
        <?= $product["price"] ?> лв.
    </p>

    <p>
        <strong>Количество:</strong>
        <?= $product["quantity"] ?>
    </p>

    <p>
        <strong>Статус:</strong>
        <span class="<?= $statusClass ?>">  
        <?= $status ?>
        </span>  

    </p>

</div>


<style>

.card {
    width: 350px;
    padding: 20px;
    border: 1px solid black;
    border-radius: 10px;
    background-color: #f5f5f5;
}

.card h2 {
    margin-top: 0;
}

.available{
    color:green
}

.not-available{
    color:red
}
</style>