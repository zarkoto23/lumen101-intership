<?php
include 'functions/product-functions.php';
include __DIR__ . '/data/products.php';

$id = $_GET['id'] ?? 0;
$product = findProductById($products, (int) $id);

if (!$product) {
    include '404.php';
} else {
    ?>
    <main>
        <h1><?php echo $product['name']; ?></h1>

        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">

        <p><?php echo $product['description']; ?></p>

        <p>Категория: <?php echo $product['category']; ?></p>

        <div class="price">
            <?php if ($product['discount'] > 0): ?>
                <span class="old-price"><?php echo formatPrice($product['price']); ?></span>
                <span
                    class="final-price"><?php echo formatPrice(calculateFinalPrice($product['price'], $product['discount'])); ?></span>
            <?php else: ?>
                <span class="final-price"><?php echo formatPrice($product['price']); ?></span>
            <?php endif; ?>
        </div>

        <p><?php echo getAvailabilityText($product['quantity']); ?></p>

        <a href="products.php">← Обратно към продуктите</a>
    </main>
    <?php
}

?>