<?php


class FileEntity {
    private $id;
    
    private $name;

    private $path;

    private $comment;

    public function __construct(int $id, string $name, string $path, CommentEntity $comment) {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->comment = $comment;
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

    public function getComment(): CommentEntity {
        return $this->comment;
    }
}