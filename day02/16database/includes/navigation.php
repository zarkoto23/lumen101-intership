<?php
$basePath = '';
if (strpos($_SERVER['REQUEST_URI'], '/categories/') !== false) {
    $basePath = '../';
}
?>
<nav class="navbar">
    <div class="nav-brand">
        <a href="<?= $basePath ?>index.php">🛒 PHP Shop</a>
    </div>
    <div class="nav-menu">
        <a href="<?= $basePath ?>index.php" class="nav-link">Продукти</a>
        <a href="<?= $basePath ?>create.php" class="nav-link">Добави продукт</a>
        <a href="<?= $basePath ?>categories/index.php" class="nav-link">Категории</a>
    </div>
</nav>