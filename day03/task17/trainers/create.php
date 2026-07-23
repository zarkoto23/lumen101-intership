<?php

require "../config.php";
require "../nav.php";


$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $specialization = trim($_POST['specialization']);



    if (
        empty($first_name) ||
        empty($last_name) ||
        empty($email)
    ) {


        $error = "Please fill all required fields.";



    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {


        $error = "Invalid email.";



    } else {


        try {


            $stmt = $pdo->prepare(
                "INSERT INTO trainers
                (
                    first_name,
                    last_name,
                    email,
                    phone,
                    specialization
                )

                VALUES (?, ?, ?, ?, ?)"
            );



            $stmt->execute([
                $first_name,
                $last_name,
                $email,
                $phone,
                $specialization
            ]);



            header("Location: index.php");
            exit;



        } catch (PDOException $e) {


            $error = "Email already exists.";


        }

    }

}


?>



<h1>Add trainer</h1>



<?php if ($error): ?>

    <p>
        <?= $error ?>
    </p>

<?php endif; ?>



<form method="POST">



    <label>
        First name:
    </label>

    <input type="text" name="first_name" value="<?= $_POST['first_name'] ?? '' ?>" required>


    <br><br>



    <label>
        Last name:
    </label>

    <input type="text" name="last_name" value="<?= $_POST['last_name'] ?? '' ?>" required>


    <br><br>



    <label>
        Email:
    </label>

    <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>


    <br><br>



    <label>
        Phone:
    </label>

    <input type="text" name="phone" value="<?= $_POST['phone'] ?? '' ?>">


    <br><br>



    <label>
        Specialization:
    </label>

    <input type="text" name="specialization" value="<?= $_POST['specialization'] ?? '' ?>">


    <br><br>



    <button type="submit">
        Save
    </button>



</form>