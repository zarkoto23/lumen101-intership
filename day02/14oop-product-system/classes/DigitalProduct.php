<?php
class DigitalProduct extends Product
{
    private float $fileSize;
    private string $downloadLink;

    public function __construct(int $id, string $name, string $description, float $price, int $quantity, Category $category, float $fileSize, string $downloadLink)
    {
        parent::__construct($id, $name, $description, $price, $quantity, $category);
        $this->setFileSize($fileSize);
        $this->setDownloadLink($downloadLink);
    }

    public function getFileSize(): float
    {
        return $this->fileSize;
    }

    public function setFileSize(float $fileSize): void
    {
        if ($fileSize < 0) {
            throw new InvalidArgumentException('Размерът на файла не може да бъде отрицателен.');
        }
        $this->fileSize = $fileSize;
    }

    public function getDownloadLink(): string
    {
        return $this->downloadLink;
    }

    public function setDownloadLink(string $downloadLink): void
    {
        $this->downloadLink = $downloadLink;
    }

    public function getType(): string
    {
        return 'Дигитален продукт';
    }

    public function getSpecificData(): array
    {
        return [
            'Размер на файла' => $this->fileSize . ' MB',
            'Линк за изтегляне' => $this->downloadLink
        ];
    }

    public function calculateDiscountedPrice(): float
    {
        return $this->getPrice() * 0.8;
    }

    public function calculateTotalWithShipping(int $quantity): float
    {
        return $this->calculateTotal($quantity);
    }
}