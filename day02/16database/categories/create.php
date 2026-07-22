<?php
require_once '../config/database.php';

session_start();

$name = '';
$description = '';

$flashMessage = '';
$flashType = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    $flashType = $_SESSION['flash_type'] ?? 'success';
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}
?>
<?php include '../includes/header.php'; ?>

<div class="form-container">
    <h2>➕ Добавяне на нова категория</h2>

    <?php if ($flashMessage): ?>
        <div class="alert alert-<?= $flashType ?>"><?= htmlspecialchars($flashMessage) ?></div>
    <?php endif; ?>

    <form method="POST" action="store.php">
        <div class="form-group">
            <label for="name">Име *</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">💾 Запази категорията</button>
            <a href="index.php" class="btn btn-secondary">Отказ</a>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>