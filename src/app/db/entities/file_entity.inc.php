<?php


class FileEntity {
    private $id;
    
    private $name;

    private $path;

    public function __construct(int $id, string $name, string $path) {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPath(): string {
        return $this->path;
    }
}