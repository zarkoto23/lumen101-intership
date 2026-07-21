<?php
echo "----------------------------------------------\n";

echo "Моля въведете валидни кодове на валути със 3 букви!\n";
$fromCurrency=strtoupper(readline("Начална валута за конвертиране: "));
$toCurrency=strtoupper(readline("Крайна валута за конвертиране: "));

$initValue=(float) readline("Въведете стойност за конвертиране: ");

$api_url = "https://v6.exchangerate-api.com/v6/f8c2e8e3fb198713217d0f62/latest/".$fromCurrency;

$response = file_get_contents($api_url);

if ($response === false) {
    echo "Грешка, опитайте пак!";
    exit;
}

$data = json_decode($response, true);


$convertetValue = $data["conversion_rates"][$toCurrency];

$finalValue=$initValue*$convertetValue;

echo "----------------------------------------------\n";

echo $initValue . " " . $fromCurrency . " = " . $finalValue . " " . $toCurrency;
