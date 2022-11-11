<?php


class PostEntity {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * TODO
     * @var CategoryEntity
     */
    private $category;

    /**
     * @var DateTime
     */
    private $creation_date;

    /**
     * @var UserEntity
     */
    private $author;

    /**
     * @var array
     */
    private $tags;

    public function __construct(int $id, string $title, string $text, CategoryEntity $category,
        int $date, UserEntity $author, array $tags) {

            $this->id = $id;
            $this->title = $title;
            $this->text = $text;
            $this->category = $category;

            $this->date = new DateTime();
            $this->date->setTimeStamp($date);

            $this->author = $author;
            $this->tags = $tags;
    }

    /**
     * Obtiene el ID del post
     * @return int ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Obtiene el título del post
     * @return string Título
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * Establece el título del post
     * @param string $title Título
     */
    public function setTitle(string $title) {
        $this->title = $title;
    }

    /**
     * Obtiene el texto del post
     * @return string Texto
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * Establece el texto del post
     * @param string $text Texto
     */
    public function setText(string $text) {
        $this->text = $text;
    }

    /**
     * Obtiene la categoría del post
     * @return CategoryEntity Categoría
     */
    public function getCategory(): CategoryEntity {
        return $this->categroy;
    }

    /**
     * Establece la categoría del post
     * @param CategoryEntity $category Categoría
     */
    public function setCategory(CategoryEntity $category) {
        $this->category = $category;
    }

    /**
     * Obtiene la fecha de creación del post
     * @return DateTime Fecha
     */
    public function getCreationDate(): DateTime {
        return $this->date;
    }

    /**
     * Obtiene el autor del post
     * @return UserEntity Usuario
     */
    public function getAuthor(): UserEntity {
        return $this->author;
    }

    /**
     * Obtiene las tags de la entidad
     * @return array
     */
    public function getTags(): array {
        return $this->tags;
    }

    /**
     * Establece las tags del post
     * @param array $tags Tags
     */
    public function setTags(array $tags) {
        $this->tags = $tags;
    }
}

