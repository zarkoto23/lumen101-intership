<?php

$name = readline("Име на служителя: ");

$hours = (float) readline("Часове работа: ");

$payPerHour = (float) readline("Заплащане на час: ");

$bonus = (float) readline("Бонус: ");

$taxes = (float) readline("Удръжки: ");



$basePay = $hours * $payPerHour;

$finalSalary = $basePay + $bonus - $taxes;



echo "\n--- Справка за заплата ---\n";

echo "Служител: $name\n";

echo "Отработени часове: $hours\n";

echo "Заплащане на час: $payPerHour\n";

echo "Основна заплата: $basePay\n";

echo "Бонус: $bonus\n";

echo "Удръжки: $taxes\n";

echo "Крайна заплата: $finalSalary\n";