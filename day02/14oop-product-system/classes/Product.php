<?php
abstract class Product implements Discountable
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $quantity;
    private Category $category;

    private static int $createdCount = 0;

    public function __construct(int $id, string $name, string $description, float $price, int $quantity, Category $category)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setCategory($category);
        self::$createdCount++;
    }

    public function getId(): int
    {
        return $this->id;
    }

    private function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (trim($name) === '') {
            throw new InvalidArgumentException('Името не може да бъде празно.');
        }
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        if ($price < 0) {
            throw new InvalidArgumentException('Цената не може да бъде отрицателна.');
        }
        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException('Количеството не може да бъде отрицателно.');
        }
        $this->quantity = $quantity;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function isAvailable(): bool
    {
        return $this->quantity > 0;
    }

    public function calculateTotal(int $quantity): float
    {
        return $this->price * $quantity;
    }

    public function formatPrice(): string
    {
        return number_format($this->price, 2) . ' €';
    }

    public function reduceQuantity(int $quantity): bool
    {
        if ($quantity <= 0 || $this->quantity - $quantity < 0) {
            return false;
        }
        $this->quantity -= $quantity;
        return true;
    }

    public static function getCreatedProductsCount(): int
    {
        return self::$createdCount;
    }

    abstract public function getType(): string;
    abstract public function getSpecificData(): array;

    public function calculateDiscountedPrice(): float
    {
        return $this->price * 0.9;
    }

    public function __toString(): string
    {
        return sprintf(
            "ID: %d | %s | %.2f € | Наличност: %d | Категория: %s",
            $this->id,
            $this->name,
            $this->price,
            $this->quantity,
            $this->category->getName()
        );
    }
}