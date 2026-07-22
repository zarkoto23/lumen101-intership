<?php
require_once 'config/database.php';

session_start();


$allowedSortColumns = ['p.name', 'p.price', 'p.created_at'];
$allowedSortDirections = ['ASC', 'DESC'];

$sort = $_GET['sort'] ?? 'p.created_at';
$direction = $_GET['direction'] ?? 'DESC';

if (!in_array($sort, $allowedSortColumns)) {
    $sort = 'p.created_at';
}

if (!in_array($direction, $allowedSortDirections)) {
    $direction = 'DESC';
}


$sql = "SELECT 
            p.*,
            c.name AS category_name
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE 1=1";

$params = [];

if (!empty($_GET['search'])) {
    $sql .= " AND p.name LIKE ?";
    $params[] = '%' . $_GET['search'] . '%';
}

if (!empty($_GET['category'])) {
    $sql .= " AND p.category_id = ?";
    $params[] = (int) $_GET['category'];
}

if (isset($_GET['available']) && $_GET['available'] === '1') {
    $sql .= " AND p.is_available = 1 AND p.quantity > 0";
}

if (!empty($_GET['min_price'])) {
    $sql .= " AND p.price >= ?";
    $params[] = (float) $_GET['min_price'];
}

if (!empty($_GET['max_price'])) {
    $sql .= " AND p.price <= ?";
    $params[] = (float) $_GET['max_price'];
}

$sql .= " ORDER BY $sort $direction";

$itemsPerPage = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1)
    $page = 1;
$offset = ($page - 1) * $itemsPerPage;

$countSql = "SELECT COUNT(*) as total FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
$countParams = [];

$whereClause = '';
if (!empty($_GET['search'])) {
    $whereClause .= " AND p.name LIKE ?";
    $countParams[] = '%' . $_GET['search'] . '%';
}
if (!empty($_GET['category'])) {
    $whereClause .= " AND p.category_id = ?";
    $countParams[] = (int) $_GET['category'];
}
if (isset($_GET['available']) && $_GET['available'] === '1') {
    $whereClause .= " AND p.is_available = 1 AND p.quantity > 0";
}
if (!empty($_GET['min_price'])) {
    $whereClause .= " AND p.price >= ?";
    $countParams[] = (float) $_GET['min_price'];
}
if (!empty($_GET['max_price'])) {
    $whereClause .= " AND p.price <= ?";
    $countParams[] = (float) $_GET['max_price'];
}

$countSql .= $whereClause;
$stmt = $pdo->prepare($countSql);
$stmt->execute($countParams);
$totalItems = $stmt->fetch()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

$sql .= " LIMIT " . (int) $itemsPerPage . " OFFSET " . (int) $offset;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$categoriesStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $categoriesStmt->fetchAll();

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

<?php if ($flashMessage): ?>
    <div class="alert alert-<?= $flashType ?>"><?= htmlspecialchars($flashMessage) ?></div>
<?php endif; ?>

<div class="filters">
    <form method="GET" action="">
        <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
            <div class="filter-group">
                <label>Търсене</label>
                <input type="text" name="search" placeholder="Търси продукт..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>

            <div class="filter-group">
                <label>Категория</label>
                <select name="category">
                    <option value="">Всички</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Мин. цена</label>
                <input type="number" name="min_price" step="0.01" min="0"
                    value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
            </div>

            <div class="filter-group">
                <label>Макс. цена</label>
                <input type="number" name="max_price" step="0.01" min="0"
                    value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
            </div>

            <div class="filter-group" style="flex-direction: row; align-items: center;">
                <input type="checkbox" name="available" value="1" id="available" <?= isset($_GET['available']) && $_GET['available'] === '1' ? 'checked' : '' ?>>
                <label for="available" style="margin: 0;">Само налични</label>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Филтрирай</button>
                <a href="index.php" class="btn btn-secondary">Изчисти</a>
            </div>
        </div>
    </form>
</div>

<div style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
    <span style="font-weight: bold;">Сортирай по:</span>
    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'p.name', 'direction' => 'ASC'])) ?>"
        class="btn btn-sm btn-info">Име (А-Я)</a>
    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'p.name', 'direction' => 'DESC'])) ?>"
        class="btn btn-sm btn-info">Име (Я-А)</a>
    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'p.price', 'direction' => 'ASC'])) ?>"
        class="btn btn-sm btn-info">Цена (ниска-висока)</a>
    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'p.price', 'direction' => 'DESC'])) ?>"
        class="btn btn-sm btn-info">Цена (висока-ниска)</a>
    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'p.created_at', 'direction' => 'DESC'])) ?>"
        class="btn btn-sm btn-info">Най-нови</a>
</div>

<div class="table-container">
    <div
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; flex-wrap: wrap;">
        <h2>📦 Продукти</h2>
        <a href="create.php" class="btn btn-success">➕ Добави продукт</a>
    </div>

    <?php if (count($products) === 0): ?>
        <p style="text-align: center; padding: 40px; color: #666;">Няма намерени продукти.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Име</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Статус</th>
                    <th>Създаден</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['category_name'] ?? 'Без категория') ?></td>
                        <td><?= number_format($product['price'], 2) ?> €</td>
                        <td><?= $product['quantity'] ?></td>
                        <td>
                            <?php if ($product['is_available'] && $product['quantity'] > 0): ?>
                                <span class="badge badge-success">Наличен</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Не е наличен</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d.m.Y', strtotime($product['created_at'])) ?></td>
                        <td>
                            <a href="show.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-info">Преглед</a>
                            <a href="edit.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Редактирай</a>
                            <form method="POST" action="delete.php" style="display: inline-block;"
                                onsubmit="return confirm('Сигурни ли сте, че искате да изтриете този продукт?');">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Изтрий</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <div style="display: flex; gap: 5px; justify-content: center; margin-top: 20px; flex-wrap: wrap;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                        class="btn btn-sm <?= $i == $page ? 'btn-primary' : 'btn-secondary' ?>"
                        style="<?= $i == $page ? 'background-color: #1a237e; color: white;' : 'background-color: #ddd;' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>