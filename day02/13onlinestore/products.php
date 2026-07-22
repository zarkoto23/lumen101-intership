<?php
require_once 'includes/header.php';
require_once 'functions/product-functions.php';
require_once 'includes/navigation.php';
require_once __DIR__ . '/data/products.php';

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';

$filteredProducts = $products;

if ($search) {
    $filteredProducts = searchByName($filteredProducts, $search);
}

if ($category) {
    $filteredProducts = filterByCategory($filteredProducts, $category);
}

if ($sort === 'asc' || $sort === 'desc') {
    $filteredProducts = sortByPrice($filteredProducts, $sort);
}

$categories = array_unique(array_column($products, 'category'));
?>

<main>
    <h1>Всички продукти</h1>

    <div class="filters">
        <form method="GET" action="index.php">
            <input type="hidden" name="page" value="products">
            <input type="text" name="search" placeholder="Търси по име..." value="<?php echo $search; ?>">

            <select name="category">
                <option value="">Всички категории</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat; ?>" <?php echo $category === $cat ? 'selected' : ''; ?>>
                        <?php echo $cat; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="sort">
                <option value="">Подреди по</option>
                <option value="asc" <?php echo $sort === 'asc' ? 'selected' : ''; ?>>Цена ↑</option>
                <option value="desc" <?php echo $sort === 'desc' ? 'selected' : ''; ?>>Цена ↓</option>
            </select>

            <button type="submit">Филтрирай</button>
            <a href="index.php?page=products">Изчисти</a>
        </form>
    </div>

    <?php if (empty($filteredProducts)): ?>
        <p>Няма налични продукти с това имe и категория</p>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($filteredProducts as $product): ?>
                <?php echo generateProductCard($product); ?>
            <?php endforeach; ?>
        </div>

        <div class="stats">
            <h2>Статистика</h2>
            <p>Общ брой продукти: <?php echo getTotalProducts($filteredProducts); ?></p>
            <p>Средна цена: <?php echo formatPrice(calculateProductsAveragePrice($filteredProducts)); ?></p>
            <p>Най-ниска цена: <?php echo formatPrice(getMinPrice($filteredProducts)); ?></p>
            <p>Най-висока цена: <?php echo formatPrice(getMaxPrice($filteredProducts)); ?></p>
            <p>Налични продукти: <?php echo getAvailableCount($filteredProducts); ?></p>
            <p>Изчерпани продукти: <?php echo getOutOfStockCount($filteredProducts); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php require_once 'includes/footer.php'; ?>