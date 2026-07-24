<?php
require_once "../includes/header.php";


$error = null;


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $email = trim($_POST['email']);
    $password = $_POST['password'];



    $stmt = $pdo->prepare("
        SELECT *
        FROM users
        WHERE email = ?
    ");



    $stmt->execute([$email]);



    $user = $stmt->fetch();



    if (!$user) {


        $error = "Не съществува потребител с този email.";


    } elseif (!password_verify($password, $user['password'])) {


        $error = "Грешна парола.";


    } else {



        session_regenerate_id(true);


        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];



        if ($user['role'] === "admin") {


            header("Location: ../admin/dashboard.php");
            exit;


        } else {


            header("Location: events.php");
            exit;


        }


    }

}

?>


<main>

    <h1>
        Вход
    </h1>



    <?php if ($error): ?>

        <p>
            <?= htmlspecialchars($error) ?>
        </p>

    <?php endif; ?>



    <form method="POST">


        <label>

            Email:

            <input type="email" name="email" required>

        </label>


        <br><br>


        <label>

            Парола:

            <input type="password" name="password" required>

        </label>


        <br><br>


        <button type="submit">
            Вход
        </button>


    </form>


</main>



<?php
require_once "../includes/footer.php";
?>