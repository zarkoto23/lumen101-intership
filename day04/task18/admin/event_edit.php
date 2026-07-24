<?php
require_once "../includes/header.php";
require_once "../includes/nav.php";
require_once "../includes/admin_check.php";


if (!isset($_GET['id'])) {
    die("Липсва ID на събитието.");
}


$id = $_GET['id'];



$stmt = $pdo->prepare("
    SELECT *
    FROM events
    WHERE id = ?
");

$stmt->execute([$id]);

$event = $stmt->fetch();


if (!$event) {
    die("Събитието не съществува.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $category_id = $_POST["category_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $location = trim($_POST["location"]);
    $status = $_POST["status"];



    if ($end_date < $start_date) {
        die("Крайната дата не може да бъде преди началната.");
    }



    $image = $event['image'];



    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {


        $allowedExtensions = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];


        $extension = strtolower(
            pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION)
        );



        if (!in_array($extension, $allowedExtensions)) {
            die("Невалидно разширение.");
        }



        if ($_FILES["image"]["size"] > 2 * 1024 * 1024) {
            die("Файлът е прекалено голям.");
        }



        if (!getimagesize($_FILES["image"]["tmp_name"])) {
            die("Файлът не е изображение.");
        }



        $image = uniqid() . "." . $extension;



        move_uploaded_file(
            $_FILES["image"]["tmp_name"],
            "../uploads/" . $image
        );

    }




    $stmt = $pdo->prepare("
        UPDATE events
        SET 
            name = ?,
            description = ?,
            category_id = ?,
            start_date = ?,
            end_date = ?,
            location = ?,
            image = ?,
            status = ?
        WHERE id = ?
    ");



    $stmt->execute([
        $name,
        $description,
        $category_id,
        $start_date,
        $end_date,
        $location,
        $image,
        $status,
        $id
    ]);



    header("Location: events.php");
    exit;

}



$categories = $pdo->query("
    SELECT *
    FROM categories
")->fetchAll();

?>

<main>

    <h1>
        Редакция на събитие
    </h1>



    <form method="POST" enctype="multipart/form-data">


        <label>
            Име:

            <input type="text" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>

        </label>


        <br><br>



        <label>
            Описание:

            <textarea name="description"><?= htmlspecialchars($event['description']) ?></textarea>

        </label>


        <br><br>



        <label>
            Категория:


            <select name="category_id" required>


                <?php foreach ($categories as $category): ?>


                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $event['category_id'] ? "selected" : "" ?>>

                        <?= htmlspecialchars($category['name']) ?>

                    </option>


                <?php endforeach; ?>


            </select>


        </label>


        <br><br>



        <label>
            Начална дата:


            <input type="datetime-local" name="start_date"
                value="<?= date('Y-m-d\TH:i', strtotime($event['start_date'])) ?>" required>


        </label>


        <br><br>



        <label>
            Крайна дата:


            <input type="datetime-local" name="end_date"
                value="<?= date('Y-m-d\TH:i', strtotime($event['end_date'])) ?>" required>


        </label>


        <br><br>



        <label>
            Място:


            <input type="text" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>


        </label>


        <br><br>



        <label>

            Статус:


            <select name="status">


                <option value="Предстоящо" <?= $event['status'] === "Предстоящо" ? "selected" : "" ?>>
                    Предстоящо
                </option>



                <option value="Провежда се" <?= $event['status'] === "Провежда се" ? "selected" : "" ?>>
                    Провежда се
                </option>



                <option value="Приключило" <?= $event['status'] === "Приключило" ? "selected" : "" ?>>
                    Приключило
                </option>


            </select>


        </label>


        <br><br>



        <label>
            Ново изображение:


            <input type="file" name="image" accept="image/*">


        </label>



        <br>



        <?php if (!empty($event['image'])): ?>


            <p>
                Текущо изображение:
            </p>


            <img src="../uploads/<?= htmlspecialchars($event['image']) ?>" width="200">


        <?php endif; ?>



        <br><br>



        <button type="submit">
            Запази
        </button>


    </form>


</main>



<?php
require_once "../includes/footer.php";
?>