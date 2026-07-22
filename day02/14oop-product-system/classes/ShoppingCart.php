<?php
class ShoppingCart
{
    private array $items = [];

    public function addProduct(Product $product, int $quantity = 1): void
    {
        if (!$product->isAvailable()) {
            throw new InvalidArgumentException('Продуктът не е наличен.');
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException('Количеството трябва да е по-голямо от 0.');
        }

        $productId = $product->getId();
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity'] += $quantity;
        } else {
            $this->items[$productId] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    public function removeProduct(int $productId, int $quantity = null): void
    {
        if (!isset($this->items[$productId])) {
            throw new InvalidArgumentException('Продуктът не е в количката.');
        }

        if ($quantity === null || $quantity >= $this->items[$productId]['quantity']) {
            unset($this->items[$productId]);
        } else {
            $this->items[$productId]['quantity'] -= $quantity;
        }
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->calculateTotal($item['quantity']);
            if ($item['product'] instanceof PhysicalProduct) {
                $total += $item['product']->getShippingCost();
            }
        }
        return $total;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function __toString(): string
    {
        if (empty($this->items)) {
            return "Количката е празна.";
        }

        $output = "Количка:\n";
        foreach ($this->items as $item) {
            $product = $item['product'];
            $output .= sprintf(
                "- %s: %d x %.2f € = %.2f €\n",
                $product->getName(),
                $item['quantity'],
                $product->getPrice(),
                $product->calculateTotal($item['quantity'])
            );
        }
        $output .= sprintf("Общо: %.2f €", $this->getTotal());
        return $output;
    }
}