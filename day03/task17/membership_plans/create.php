<?php

require "../config.php";
require "../nav.php";


$error = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $name = trim($_POST['name']);
    $duration_days = $_POST['duration_days'];
    $price = $_POST['price'];
    $visits_limit = $_POST['visits_limit'];



    if (empty($name)) {


        $error = "Plan name is required.";



    } elseif ($duration_days <= 0) {


        $error = "Duration must be greater than 0.";



    } elseif ($price < 0) {


        $error = "Price cannot be negative.";



    } elseif ($visits_limit <= 0) {


        $error = "Visits limit must be greater than 0.";



    } else {


        $stmt = $pdo->prepare(
            "INSERT INTO membership_plans
            (
                name,
                duration_days,
                price,
                visits_limit
            )

            VALUES (?, ?, ?, ?)"
        );



        $stmt->execute([
            $name,
            $duration_days,
            $price,
            $visits_limit
        ]);



        header("Location: index.php");
        exit;

    }

}


?>



<h1>Create Membership Plan</h1>



<?php if ($error): ?>

    <p>
        <?= $error ?>
    </p>

<?php endif; ?>



<form method="POST">



    <label>
        Name:
    </label>


    <input type="text" name="name" value="<?= $_POST['name'] ?? '' ?>">


    <br><br>



    <label>
        Duration days:
    </label>


    <input type="number" name="duration_days" value="<?= $_POST['duration_days'] ?? '' ?>">


    <br><br>



    <label>
        Price:
    </label>

    <input type="number" step="0.01" name="price" value="<?= $_POST['price'] ?? '' ?>">


    <br><br>



    <label>
        Visits limit:
    </label>


    <input type="number" name="visits_limit" value="<?= $_POST['visits_limit'] ?? '' ?>">


    <br><br>



    <button type="submit">
        Create
    </button>



</form>