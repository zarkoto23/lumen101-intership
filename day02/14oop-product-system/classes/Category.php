<?php
class Category
{
    private int $id;
    private string $name;
    private string $description;

    public function __construct(int $id, string $name, string $description = '')
    {
        $this->setId($id);
        $this->setName($name);
        $this->setDescription($description);
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
            throw new InvalidArgumentException('Името на категорията не може да бъде празно.');
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

    public function __toString(): string
    {
        return $this->name;
    }
}