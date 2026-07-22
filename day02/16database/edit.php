<?php
require_once 'config/database.php';

session_start();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['flash_message'] = 'Невалиден ID на продукт!';
    $_SESSION['flash_type'] = 'danger';
    header('Location: index.php');
    exit;
}

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $_SESSION['flash_message'] = 'Продуктът не съществува!';
    $_SESSION['flash_type'] = 'danger';
    header('Location: index.php');
    exit;
}

$categoriesStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $categoriesStmt->fetchAll();

$name = $product['name'];
$description = $product['description'];
$category_id = $product['category_id'];
$price = $product['price'];
$quantity = $product['quantity'];
$image = $product['image'];
$is_available = $product['is_available'];

$flashMessage = '';
$flashType = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    $flashType = $_SESSION['flash_type'] ?? 'success';
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}
?>
<?php include 'includes/header.php'; ?>

<div class="form-container">
    <h2>✏️ Редактиране на продукт</h2>

    <?php if ($flashMessage): ?>
        <div class="alert alert-<?= $flashType ?>"><?= htmlspecialchars($flashMessage) ?></div>
    <?php endif; ?>

    <form method="POST" action="update.php">
        <input type="hidden" name="id" value="<?= $id ?>">

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
            <button type="submit" class="btn btn-success">💾 Запази промените</button>
            <a href="index.php" class="btn btn-secondary">Отказ</a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>