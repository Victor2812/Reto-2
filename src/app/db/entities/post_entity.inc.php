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
     * @var int
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

    public function __construct(int $id, string $title, string $text, int $category,
        int $date, UserEntity $author) {

            $this->id = $id;
            $this->title = $title;
            $this->text = $text;
            $this->category = $category;

            $this->date = new DateTime();
            $this->date->setTimeStamp($date);

            $this->author = $author;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setText(string $text) {
        $this->text = $text;
    }

    public function getCategory(): int {
        return $this->categroy;
    }

    public function setCategory(int $category) {
        $this->category = $category;
    }

    public function getCreationDate(): DateTime {
        return $this->date;
    }

    public function getAuthor(): UserEntity {
        return $this->author;
    }
}

