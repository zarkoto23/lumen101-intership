<?php
$basePath = '';
if (strpos($_SERVER['REQUEST_URI'], '/categories/') !== false) {
    $basePath = '../';
}
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Shop</title>
    <link rel="stylesheet" href="<?= $basePath ?>assets/css/style.css">
</head>

<body>
    <header>
        <?php include 'navigation.php'; ?>
    </header>
    <main>
        <div class="container">