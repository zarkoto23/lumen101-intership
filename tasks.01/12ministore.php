<?php

$products = [

[
    "img"=>"https://vikiwat.com/userfiles/productimages/38429/product_large_84808.jpg",
    "name" => "USB Cable",
    "description" => "For charging any devices and whatever",
    "price" => 15,
    "category" => "Cables",
],

[
    "img"=>"https://www.lemokey.com/cdn/shop/files/Lemokey-G1-wireless-mouse-black.jpg?v=1721803330&width=1946",
    "name" => "Wireless Mouse",
    "description" => "Comfortable mouse for everyday use",
    "price" => 45,
    "category" => "Accessories",
],

[
    "img"=>"https://media.wired.com/photos/6928c534e7dd69f52e08eeb0/master/w_1600%2Cc_limit/Tecware%2520Spectre75-2%2520source%2520henri%2520robbins.png",
    "name" => "Mechanical Keyboard",
    "description" => "Gaming keyboard with RGB lighting",
    "price" => 120,
    "category" => "Accessories",
],

[
    "img"=>"https://www.portronics.com/cdn/shop/files/1_7aa58f65-2156-4eba-bb9d-4cb6b2ba5961.jpg?v=1711450802",
    "name" => "Laptop Stand",
    "description" => "Adjustable stand for better posture",
    "price" => 60,
    "category" => "Accessories",
],

[
    "img"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrs1Svcz5R-pctLF5Nnhsi0nQcgg2mUksfvQ&s",
    "name" => "HD Monitor",
    "description" => "24 inch monitor for work and gaming",
    "price" => 220,
    "category" => "Electronics",
],

[
    "img"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkzm330_QXVLpQJnT6jKW3ixSYYI9Vka9t6Q&s",
    "name" => "Bluetooth Speaker",
    "description" => "Portable speaker with wireless connection",
    "price" => 80,
    "category" => "Electronics",
],

[
    "img"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR_bK9Nkxn2RwrGPEe_H15bwnyv1gbLn9ZTww&s",
    "name" => "HDMI Cable",
    "description" => "High quality cable for video transmission",
    "price" => 20,
    "category" => "Cables",
],

[
    "img"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQj9dEgSjaGg1rljvGxl17ISWpMUhPwx8UHA&s",
    "name" => "Web Camera",
    "description" => "Camera for online meetings and streaming",
    "price" => 75,
    "category" => "Electronics",
],

[
    "img"=>"https://m.media-amazon.com/images/I/71rwPzXKDGL._AC_SL1500_.jpg",
    "name" => "Gaming Headset",
    "description" => "Headset with microphone for gamers",
    "price" => 150,
    "category" => "Accessories",
],

[
    "img"=>"https://cdn.4camping.bg/files/photos/1600/6/61e3f404-vanshno-zaryadno-ustroystvo-swissten-power-bank-30000-mah-cheren-srebaren.jpg",
    "name" => "Power Bank",
    "description" => "Portable battery for charging devices",
    "price" => 50,
    "category" => "Electronics",
]
];

$selectedCategory = $_GET["category"] ?? "all";

$totalPrice = 0;

foreach ($products as $product) {
    $totalPrice += $product["price"];
}

$averagePrice = $totalPrice / count($products);

$mostExpensive = $products[0];

foreach ($products as $product) {

    if ($product["price"] > $mostExpensive["price"]) {
        $mostExpensive = $product;
    }

}

$mostCheap = $products[0];

foreach ($products as $product) {

    if ($product["price"] < $mostCheap["price"]) {
        $mostCheap = $product;
    }
}

?>

<form method="GET">

    <select name="category">

        <option value="all">Всички</option>
        <option value="Electronics">Electronics</option>
        <option value="Accessories">Accessories</option>
        <option value="Cables">Cables</option>

    </select>

    <button type="submit">Филтрирай</button>

</form>

<?php

foreach ($products as $product) {

    if ($selectedCategory !== "all" && $product["category"] !== $selectedCategory) {
        continue;
    }

?>

<div class="card">
    
    <h2><?= $product["name"] ?></h2>
    
    <img class="product-img" src="<?= $product["img"] ?>">

    <p>
        Описание: <?= $product["description"] ?>
    </p>
    <p>
        Цена: <?= $product["price"] ?> 
    </p>
    <p>
        Категория: <?= $product["category"] ?>
    </p>
    
    <button> Купи </button>    

</div>

<?php

}

?>

<div class="general">

    <p>
        Oбщ брой: <?= count($products) ?>
    </p>
    <p>
        Средна цена: <?= $averagePrice ?>
    </p>
     <p>
        Най-скъп продукт: <?= $mostExpensive["name"]." - ". $mostExpensive["price"]?> 
    </p>
     <p>
        Най-евтин продукт: <?= $mostCheap["name"]." - ". $mostCheap["price"] ?> 
    </p>

</div>

<style>

.card {
    width: 250px;
    padding: 10px;
    margin: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    display: inline-block;
}

button {
    padding: 10px;
    cursor: pointer;
}

.product-img {
    width: 200px;
    height: 170px;
    object-fit: cover;
    display: block;
    margin: 15px auto;
    border-radius: 10px;
}

</style>