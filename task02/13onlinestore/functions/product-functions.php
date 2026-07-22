<?php

function formatPrice(float $price): string
{
    return number_format($price, 2, '.', '') . ' €';
}

function calculateDiscount(float $price, float $discount): float
{
    return $price * ($discount / 100);
}

function calculateFinalPrice(float $price, float $discount): float
{
    return $price - calculateDiscount($price, $discount);
}

function isAvailable(int $quantity): bool
{
    return $quantity > 0;
}

function getAvailabilityText(int $quantity): string
{
    return $quantity > 0 ? 'В наличност' : 'Изчерпан';
}

function findProductById(array $products, int $id): ?array
{
    foreach ($products as $product) {
        if ($product['id'] === $id) {
            return $product;
        }
    }
    return null;
}

function getMinPrice(array $products): float
{
    $prices = [];
    foreach ($products as $product) {
        $prices[] = calculateFinalPrice($product['price'], $product['discount']);
    }
    return min($prices);
}

function getMaxPrice(array $products): float
{
    $prices = [];
    foreach ($products as $product) {
        $prices[] = calculateFinalPrice($product['price'], $product['discount']);
    }
    return max($prices);
}

function calculateProductsAveragePrice(array $products): float
{
    if (count($products) === 0) {
        return 0;
    }

    $total = 0;
    foreach ($products as $product) {
        $total += calculateFinalPrice($product['price'], $product['discount']);
    }
    return $total / count($products);
}

function getTotalProducts(array $products): int
{
    return count($products);
}

function getAvailableCount(array $products): int
{
    $count = 0;
    foreach ($products as $product) {
        if (isAvailable($product['quantity'])) {
            $count++;
        }
    }
    return $count;
}

function getOutOfStockCount(array $products): int
{
    $count = 0;
    foreach ($products as $product) {
        if (!isAvailable($product['quantity'])) {
            $count++;
        }
    }
    return $count;
}


function searchByName(array $products, string $search): array
{
    $search = mb_strtolower(trim($search), 'UTF-8');

    return array_filter($products, function ($product) use ($search) {
        return strpos(mb_strtolower($product['name'], 'UTF-8'), $search) !== false;
    });
}

function filterByCategory(array $products, string $category): array
{
    return array_filter($products, function ($product) use ($category) {
        return $product['category'] === $category;
    });
}

function sortByPrice(array $products, string $order = 'asc'): array
{
    usort($products, function ($a, $b) use ($order) {
        $priceA = calculateFinalPrice($a['price'], $a['discount']);
        $priceB = calculateFinalPrice($b['price'], $b['discount']);

        return $order === 'asc' ? $priceA - $priceB : $priceB - $priceA;
    });
    return $products;
}

function generateProductCard(array $product): string
{
    $discountAmount = calculateDiscount($product['price'], $product['discount']);
    $finalPrice = calculateFinalPrice($product['price'], $product['discount']);
    $status = getAvailabilityText($product['quantity']);

    $oldPriceHtml = $product['discount'] > 0
        ? '<span class="old-price">' . formatPrice($product['price']) . '</span>'
        : '';

    return '
    <div class="product-card">
        <img src="' . $product['image'] . '" alt="' . $product['name'] . '">
        <h3>' . $product['name'] . '</h3>
        <p>' . $product['description'] . '</p>
        <p>Категория: ' . $product['category'] . '</p>
        <div class="price">
            ' . $oldPriceHtml . '
            <span class="final-price">' . formatPrice($finalPrice) . '</span>
        </div>
        <p>' . $status . '</p>
        <a href="product-details.php?id=' . $product['id'] . '" class="btn-details">Виж детайли</a>
    </div>';
}