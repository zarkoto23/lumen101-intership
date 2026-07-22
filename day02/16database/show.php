<?php
require_once 'config/database.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$sql = "SELECT 
            p.*,
            c.name AS category_name,
            c.description AS category_description
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    $error = 'Продуктът не съществува!';
}
?>
<?php include 'includes/header.php'; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <a href="index.php" class="btn btn-primary">← Назад към списъка</a>
<?php else: ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>📄 Преглед на продукт</h2>
        <div>
            <a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-warning">✏️ Редактирай</a>
            <form method="POST" action="delete.php" style="display: inline-block;"
                onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този продукт?');">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn btn-danger">🗑️ Изтрий</button>
            </form>
            <a href="index.php" class="btn btn-primary">← Назад</a>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 12px; font-weight: bold; width: 200px; border-bottom: 1px solid #eee;">ID</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= $product['id'] ?></td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Име</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= htmlspecialchars($product['name']) ?></td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Описание</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">
                    <?= htmlspecialchars($product['description'] ?? 'Няма описание') ?></td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Категория</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">
                    <?= htmlspecialchars($product['category_name'] ?? 'Без категория') ?>
                    <?php if ($product['category_description']): ?>
                        <br><small style="color: #666;"><?= htmlspecialchars($product['category_description']) ?></small>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Цена</td>
                <td
                    style="padding: 12px; border-bottom: 1px solid #eee; font-size: 1.4em; font-weight: bold; color: #e91e63;">
                    <?= number_format($product['price'], 2) ?> €
                </td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Количество</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= $product['quantity'] ?> бр.</td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Изображение</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">
                    <?php if ($product['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                    <?php else: ?>
                        <span style="color: #999;">Няма изображение</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Статус</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">
                    <?php if ($product['is_available'] && $product['quantity'] > 0): ?>
                        <span class="badge badge-success">✅ Наличен</span>
                    <?php else: ?>
                        <span class="badge badge-danger">❌ Не е наличен</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold; border-bottom: 1px solid #eee;">Създаден на</td>
                <td style="padding: 12px; border-bottom: 1px solid #eee;">
                    <?= date('d.m.Y H:i:s', strtotime($product['created_at'])) ?></td>
            </tr>
            <tr>
                <td style="padding: 12px; font-weight: bold;">Последно обновен</td>
                <td style="padding: 12px;"><?= date('d.m.Y H:i:s', strtotime($product['updated_at'])) ?></td>
            </tr>
        </table>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>