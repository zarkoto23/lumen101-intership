<?php
require "../config.php";
require "../nav.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $birth_date = $_POST['birth_date'];

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
                "INSERT INTO members 
                (first_name, last_name, email, phone, birth_date)
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->execute([
                $first_name,
                $last_name,
                $email,
                $phone,
                $birth_date
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {

            $error = "Email already exists.";

        }
    }
}

?>


<h1>Add client</h1>
<?php if ($error): ?>

    <p>
        <?= $error ?>
    </p>

<?php endif; ?>

<form method="POST">

    <label>First name:</label>
    <input type="text" name="first_name" required>
    <br>

    <label>Last name:</label>
    <input type="text" name="last_name" required>
    <br>

    <label>Email:</label>
    <input type="email" name="email" required>
    <br>

    <label>Phone:</label>
    <input type="text" name="phone">
    <br>

    <label>Birth date:</label>
    <input type="date" name="birth_date">
    <br>

    <button type="submit">
        Save
    </button>

</form>