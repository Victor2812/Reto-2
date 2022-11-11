<?php


class TagEntity {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $counter;

    public function __construct(int $id, string $name, int $counter) {
        $this->id = $id;
        $this->name = strtolower($name);
        $this->counter = $counter;
    }

    /**
     * Obtiene el ID de la etiqueta
     * @return int ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Obtiene el nombre de la etiqueta
     * @return string Nombre
     */
    public function getName(): string {
        return $this->title;
    }

    /**
     * Obtiene el contador de la etiqueta
     * @return int Categoría
     */
    public function getCounter(): int {
        return $this->counter;
    }

    /**
     * Establece el contador de la etiqueta
     * @param int $counter Contador
     */
    public function setCounter(int $counter) {
        $this->counter = $counter;
    }

    /**
     * Suma valor al contador de la etiqueta
     * @param int $counter Valor
     */
    public function addCounter(int $counter) {
        $this->counter += $counter;
    }
}