<?php

$products = [

    [
        "name" => "Laptop",
        "price" => 1500,
        "category" => "Electronics",
        "quantity" => 5,
        "available" => true
    ],

    [
        "name" => "Mouse",
        "price" => 50,
        "category" => "Accessories",
        "quantity" => 20,
        "available" => true
    ],

    [
        "name" => "Keyboard",
        "price" => 100,
        "category" => "Accessories",
        "quantity" => 0,
        "available" => false
    ],

    [
        "name" => "Monitor",
        "price" => 200,
        "category" => "Electronics",
        "quantity" => 8,
        "available" => true
    ],

    [
        "name" => "Cable",
        "price" => 10,
        "category" => "Cables",
        "quantity" => 0,
        "available" => false
    ]

];


foreach ($products as $product) {

?>

<div class="card">

    <h2><?= $product["name"] ?></h2>

    <p>
        Категория: <?= $product["category"] ?>
    </p>

    <p>
        Цена: <?= $product["price"] ?> лв.
    </p>

    <p>
        Количество: <?= $product["quantity"] ?>
    </p>


    <?php if ($product["available"]) { ?>

        <button>
            Добави в количката
        </button>

    <?php } else { ?>

        <p style="color:red;">
            Няма наличност
        </p>

    <?php } ?>


</div>

<?php

}

?>


<style>

.card {
    width: 250px;
    padding: 20px;
    margin: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    display: inline-block;
}

button {
    padding: 10px;
    cursor: pointer;
}

</style>