<?php
require_once '../config/database.php';

session_start();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $stmt->fetchAll();

$flashMessage = '';
$flashType = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    $flashType = $_SESSION['flash_type'] ?? 'success';
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}

$basePath = '../';
?>
<?php include '../includes/header.php'; ?>

<?php if ($flashMessage): ?>
    <div class="alert alert-<?= $flashType ?>"><?= htmlspecialchars($flashMessage) ?></div>
<?php endif; ?>

<div class="table-container">
    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
        <h2>📂 Категории</h2>
        <a href="create.php" class="btn btn-success">➕ Добави категория</a>
    </div>

    <?php if (count($categories) === 0): ?>
        <p style="text-align: center; padding: 40px; color: #666;">Няма създадени категории.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Име</th>
                    <th>Описание</th>
                    <th>Създадена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= htmlspecialchars($category['description'] ?? '') ?></td>
                        <td><?= date('d.m.Y', strtotime($category['created_at'])) ?></td>
                        <td>
                            <form method="POST" action="delete.php" style="display: inline-block;"
                                onsubmit="return confirm('Сигурни ли сте, че искате да изтриете тази категория?');">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>