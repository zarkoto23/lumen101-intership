<?php
class PhysicalProduct extends Product
{
    private float $weight;
    private float $shippingCost;

    public function __construct(int $id, string $name, string $description, float $price, int $quantity, Category $category, float $weight, float $shippingCost)
    {
        parent::__construct($id, $name, $description, $price, $quantity, $category);
        $this->setWeight($weight);
        $this->setShippingCost($shippingCost);
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        if ($weight < 0) {
            throw new InvalidArgumentException('Теглото не може да бъде отрицателно.');
        }
        $this->weight = $weight;
    }

    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    public function setShippingCost(float $shippingCost): void
    {
        if ($shippingCost < 0) {
            throw new InvalidArgumentException('Цената за доставка не може да бъде отрицателна.');
        }
        $this->shippingCost = $shippingCost;
    }

    public function calculateTotalWithShipping(int $quantity): float
    {
        return $this->calculateTotal($quantity) + $this->shippingCost;
    }

    public function getType(): string
    {
        return 'Физически продукт';
    }

    public function getSpecificData(): array
    {
        return [
            'Тегло' => $this->weight . ' кг',
            'Цена за доставка' => number_format($this->shippingCost, 2) . ' €'
        ];
    }

    public function calculateDiscountedPrice(): float
    {
        return $this->getPrice() * 0.95;
    }
}