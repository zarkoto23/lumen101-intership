<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $age = $_POST["age"];
    $city = $_POST["city"];
    $profession = $_POST["profession"];
    $hobby = $_POST["hobby"];

    echo "Здравейте!<br>";
    echo "Казвам се $firstName $lastName.<br>";
    echo "На $age години съм.<br>";
    echo "Живея в $city.<br>";
    echo "Работя като $profession.<br>";
    echo "В свободното си време обичам $hobby.<br>";

    if($age<18){
        echo ("Потребителят е непълнолетен!");
    }

} else {

?>

<form method="POST">

    Име:
    <input type="text" name="firstName">
    <br>

    Фамилия:
    <input type="text" name="lastName">
    <br>

    Възраст:
    <input type="number" name="age">
    <br>

    Град:
    <input type="text" name="city">
    <br>

    Професия:
    <input type="text" name="profession">
    <br>

    Хоби:
    <input type="text" name="hobby">
    <br>

    <button type="submit">Изпрати</button>

</form>

<?php
}
?>