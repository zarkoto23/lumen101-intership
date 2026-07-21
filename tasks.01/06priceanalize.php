<?php

$prices=[5,6,7,8,9,10,11,12,13,14];

$sum=0;
foreach ($prices as $price) {
    $sum+=$price;

}

$avverage=$sum/count($prices);

$aboveAverage = [];

foreach ($prices as $price) {
    if ($price > $avverage) {
        $aboveAverage[] = $price;
    }
}

$underAverage = [];
foreach ($prices as $price) {
    if ($price < $avverage) {
        $underAverage[] = $price;
    }
}






echo "Всички цени: ";
echo implode(", ", $prices)."\n";

echo "Сбор на всички цени: ". $sum."\n";

echo "Средна цена: ". $avverage."\n";

echo "Най-ниска цена: ". min($prices)."\n";

echo "Най-висока цена: ". max($prices)."\n";

echo "Общ брой продукти: ". count($prices)."\n";

echo "Цени над средната: ".implode(", ", $aboveAverage)."\n";

echo "Цени под средната: ".implode(", ", $underAverage);





