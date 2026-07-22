<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rePass = $_POST["rePass"];

 

  if (
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($rePass)
    ) {
        echo "Моля попълнете всички полета!";
        exit;
    }

        if ($password !== $rePass) {
        echo "Паролите не съвпадат!";
        exit;
    }

        if (!str_contains($email, "@")) {
        echo "Невалиден имейл!";
        exit;
    }

        if (strlen($password) < 8) {
        echo "Паролата трябва да е поне 8 символа!";
        exit;
    }
    echo "---------------------------<br>";

    echo "Регистрирахте се успешно!<br>";

    echo "---------------------------<br>";

   
} else {

?>

<form method="POST">

    Потребителско име:
    <input type="text" name="username">
    <br>

    Имейл:
    <input type="text" name="email">
    <br>

    Парола:
    <input type="text" name="password">
    <br>

    Повтори парола:
    <input type="text" name="rePass">
    <br>

    <button type="submit">Изпрати</button>

</form>

<?php
}
?>