<?php
require_once 'includes/header.php';
require_once 'includes/navigation.php';

$page = $_GET['page'] ?? 'index';

switch ($page) {
    case 'index':
        ?>
        <main>
            <h1>Онлайн Магазин</h1>
            <p>Добре дошли!</p>
        </main>
        <?php
        break;

    case 'products':
        include 'products.php';
        break;

    case 'product-details':
        include 'product-details.php';
        break;

    case 'contacts':
        include 'contacts.php';
        break;

    default:
        include '404.php';
        break;
}

require_once 'includes/footer.php';
?>