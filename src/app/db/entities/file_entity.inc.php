<?php


class FileEntity {
    /**
     * @var int;
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $path;

    public function __construct(int $id, string $name, string $path) {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Obtiene el ID del archivo
     * @return int ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Obtiene el nombre del archivo
     * @return string nombre
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Obtiene la ruta absoluta del archivo en el sistema de archivos
     * @return string ruta absoluta
     */
    public function getPath(): string {
        return UPLOADS_FOLDER . '/' . $this->path;
    }

    /**
     * Obtiene la URL para descargar el archivo
     * @return string URL
     */
    public function getRoute(): string {
        return UPLOADS_ROUTE . '/' . $this->path;
    }
}