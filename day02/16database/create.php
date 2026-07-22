<?php
require_once 'config/database.php';

session_start();

$stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $stmt->fetchAll();

$errors = [];
$name = $description = $price = $quantity = $image = '';
$category_id = '';
$is_available = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = $_POST['category_id'] ?? '';
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? 0;
    $image = trim($_POST['image'] ?? '');
    $is_available = isset($_POST['is_available']) ? 1 : 0;


    if (empty($name)) {
        $errors[] = 'Името на продукта е задължително.';
    }

    if (empty($category_id)) {
        $errors[] = 'Моля, изберете категория.';
    }

    if ($price === '' || $price === null) {
        $errors[] = 'Цената е задължителна.';
    } elseif (!is_numeric($price) || $price < 0) {
        $errors[] = 'Цената трябва да бъде положително число.';
    }

    if (!is_numeric($quantity) || $quantity < 0 || floor($quantity) != $quantity) {
        $errors[] = 'Количеството трябва да бъде цяло неотрицателно число.';
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO products (category_id, name, description, price, quantity, image, is_available) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $category_id,
                $name,
                $description,
                $price,
                $quantity,
                $image,
                $is_available
            ]);

            $_SESSION['flash_message'] = 'Продуктът беше добавен успешно!';
            $_SESSION['flash_type'] = 'success';

            header('Location: index.php');
            exit;

        } catch (PDOException $e) {
            $errors[] = 'Грешка при запис в базата данни: ' . $e->getMessage();
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="form-container">
    <h2>➕ Добавяне на нов продукт</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Име *</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Категория *</label>
            <select id="category_id" name="category_id" required>
                <option value="">Изберете категория...</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $category_id == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Цена (€) *</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?= htmlspecialchars($price) ?>"
                required>
        </div>

        <div class="form-group">
            <label for="quantity">Количество *</label>
            <input type="number" id="quantity" name="quantity" min="0" value="<?= htmlspecialchars($quantity) ?>"
                required>
        </div>

        <div class="form-group">
            <label for="image">URL на изображение</label>
            <input type="text" id="image" name="image" value="<?= htmlspecialchars($image) ?>">
            <div class="help-text">Пример: product-image.jpg</div>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_available" value="1" <?= $is_available ? 'checked' : '' ?>>
                Продуктът е наличен
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">💾 Запази продукта</button>
            <a href="index.php" class="btn btn-secondary">Отказ</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>