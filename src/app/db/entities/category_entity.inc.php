<?php


class CategoryEntity {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Obtiene el ID de la categoría
     * @return int ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Obtiene el nombre de la categoría
     * @return string Nombre
     */
    public function getName(): string {
        return $this->name;
    }
}