<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $age = $_POST["age"];
    $city = $_POST["city"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $profession = $_POST["profession"];

?>

<div class="card">

    <h2><?= $firstName . " " . $lastName ?></h2>

    <p><strong>Професия:</strong> <?= $profession ?></p>
    <p><strong>Възраст:</strong> <?= $age ?> години</p>
    <p><strong>Град:</strong> <?= $city ?></p>
    <p><strong>Телефон:</strong> <?= $phone ?></p>
    <p><strong>Email:</strong> <?= $email ?></p>

    <div class="photo">
        Снимка
    </div>

</div>


<?php

} else {

?>

<form method="POST">

    Име:
    <input type="text" name="firstName">
    <br><br>

    Фамилия:
    <input type="text" name="lastName">
    <br><br>

    Възраст:
    <input type="number" name="age">
    <br><br>

    Град:
    <input type="text" name="city">
    <br><br>

    Телефон:
    <input type="text" name="phone">
    <br><br>

    Имейл:
    <input type="TEXT" name="email">
    <br><br>

    Професия:
    <input type="text" name="profession">
    <br><br>

    <div class="photo-upload">
    <div class="photo-box">
        Снимка
    </div>

    <button type="button">
        Качи
    </button>
    </div>
    <br><br>


    <button type="submit">
        Създай профил
    </button>

</form>


<?php

}

?>

<style>

    .card {
    width: 350px;
    padding: 25px;
    margin: 30px auto;
    border-radius: 15px;
    background: #f4f4f4;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    font-family: Arial, sans-serif;
    text-align: center;
}

.card h2 {
    color: #2c3e50;
}

.card p {
    text-align: left;
    padding: 5px;
}

.photo-upload {
    margin: 15px 0px;
}
.photo-upload button{
    margin-top: 20px
}

.photo-box {
    width: 80px;
    height: 80px;
    background: #ddd;
    border: 1px solid #aaa;
    font-size: 16px;
}

.photo{
    width: 80px;
    height: 80px;
    background: #ddd;
    border: 1px solid #aaa;
    font-size: 16px;

}



</style>
