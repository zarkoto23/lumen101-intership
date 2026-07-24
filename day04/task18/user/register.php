<?php
require_once "../includes/header.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);



    $stmt = $pdo->prepare("
        INSERT INTO users
        (username, email, password)
        VALUES (?, ?, ?)
    ");



    $stmt->execute([
        $username,
        $email,
        $password
    ]);



    header("Location: login.php");
    exit;

}

?>


<main>

    <h1>
        Регистрация
    </h1>


    <form method="POST">


        <input type="text" name="username" placeholder="Потребителско име" required>


        <input type="email" name="email" placeholder="Email" required>


        <input type="password" name="password" placeholder="Парола" required>


        <button>
            Регистрация
        </button>


    </form>


</main>


<?php
require_once "../includes/footer.php";
?>