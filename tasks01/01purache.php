<?php

$productName = readline("Име на продукт: ");
$priceForOne = (float) readline("Цена за брой: ");
$quantity = (int) readline("Количество: ");
$deliveryPrice = 5.99;

$productsPrice = $priceForOne * $quantity;


if ($productsPrice > 150) {
    $deliveryPrice = 0;
}

if ($productsPrice > 200) {
    $productsPrice *= 0.9;
}

echo "---------------------------------\n";
echo "Продукт: $productName\n";
echo "Единична цена: " . number_format($priceForOne, 2) . "\n";
echo "Количество: $quantity\n";
echo "Стойност на продуктите: " . number_format($productsPrice, 2) . "\n";
echo "Доставка: " . number_format($deliveryPrice, 2) . "\n";
echo "---------------------------------\n";
echo "Крайна цена: " . number_format($productsPrice + $deliveryPrice, 2) . "\n";
echo "---------------------------------\n";
