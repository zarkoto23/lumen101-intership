<?php
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/classes/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
});

$categoryClothing = new Category(1, 'Облекло', 'Облекло и аксесоари');
$categoryElectronics = new Category(2, 'Електроника', 'Електронни устройства');
$categoryBooks = new Category(3, 'Книги', 'Книги и e-книги');
$categorySoftware = new Category(4, 'Софтуер', 'Софтуерни продукти');

$products = [];

try {
    $products[] = new PhysicalProduct(
        1,
        "Дънки Levis 501",
        "Класически дънки с прав крачол, 100% памук",
        89.99,
        15,
        $categoryClothing,
        0.8,
        4.99
    );

    $products[] = new PhysicalProduct(
        2,
        "Смартфон Samsung Galaxy S24",
        "Мобилен телефон с 6.8\" Dynamic AMOLED дисплей",
        1299.99,
        8,
        $categoryElectronics,
        0.2,
        5.99
    );

    $products[] = new PhysicalProduct(
        3,
        "Хари Потър и Философският камък",
        "Първият том от емблематичната поредица",
        24.99,
        30,
        $categoryBooks,
        0.5,
        3.50
    );


    $products[] = new DigitalProduct(
        4,
        "E-book - PHP за начинаещи",
        "Пълен курс по PHP от основи до напреднало ниво",
        29.99,
        100,
        $categoryBooks,
        12.5,
        "https://example.com/php-beginners.pdf"
    );

    $products[] = new DigitalProduct(
        5,
        "Video Editor Pro",
        "Професионален софтуер за монтаж на видео с AI функции",
        199.00,
        50,
        $categorySoftware,
        450,
        "https://example.com/video-editor-setup.exe"
    );

} catch (InvalidArgumentException $e) {
    die("Грешка: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Система за управление на продукти</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h1>📦 Система за управление на продукти</h1>

    <div class="product-grid">
        <?php foreach ($products as $product):
            $isAvailable = $product->isAvailable();
            $specificData = $product->getSpecificData();
            $type = $product->getType();
            $typeClass = strpos($type, 'Дигитален') !== false ? 'digital' : '';
            ?>
            <div class="product-card <?= $typeClass ?>">
                <span class="type"><?= htmlspecialchars($type) ?></span>
                <h2><?= htmlspecialchars($product->getName()) ?></h2>
                <div class="description"><?= htmlspecialchars($product->getDescription()) ?></div>
                <div class="price"><?= $product->formatPrice() ?></div>
                <div class="availability <?= $isAvailable ? 'available' : 'unavailable' ?>">
                    <?= $isAvailable ? '✅ Наличен' : '❌ Не е наличен' ?>
                </div>
                <div class="category">Категория: <?= htmlspecialchars($product->getCategory()->getName()) ?></div>

                <div class="details">
                    <strong>Специфични данни:</strong>
                    <?php foreach ($specificData as $key => $value): ?>
                        <div class="detail-item">
                            <span class="detail-label"><?= htmlspecialchars($key) ?>:</span>
                            <span class="detail-value"><?= htmlspecialchars($value) ?></span>
                        </div>
                    <?php endforeach; ?>
                    <div class="detail-item">
                        <span class="detail-label">Наличност:</span>
                        <span class="detail-value"><?= $product->getQuantity() ?> бр.</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Цена с отстъпка:</span>
                        <span class="detail-value"><?= number_format($product->calculateDiscountedPrice(), 2) ?> €</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="stats-section">
        <h3>📊 Статистика</h3>
        <p>Общ брой създадени продукти: <strong><?= Product::getCreatedProductsCount() ?></strong></p>
        <p>Физически продукти:
            <strong><?= count(array_filter($products, fn($p) => $p instanceof PhysicalProduct)) ?></strong>
        </p>
        <p>Дигитални продукти:
            <strong><?= count(array_filter($products, fn($p) => $p instanceof DigitalProduct)) ?></strong>
        </p>
    </div>

    <?php
    $cart = new ShoppingCart();
    try {
        $cart->addProduct($products[0], 2);
        $cart->addProduct($products[3], 1);
    } catch (InvalidArgumentException $e) {
    }
    ?>
    <div class="demo-section">
        <h3>🛒 Демонстрация на количка</h3>
        <pre><?= htmlspecialchars($cart) ?></pre>
    </div>

    <div class="demo-section">
        <h3>🔄 Демонстрация на полиморфизъм</h3>
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <strong><?= htmlspecialchars($product->getName()) ?></strong>:
                    <?= number_format($product->calculateDiscountedPrice(), 2) ?> €
                    <span class="discount-badge">
                        (<?= $product instanceof PhysicalProduct ? 'физически - 5%' : 'дигитален - 20%' ?>)
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>