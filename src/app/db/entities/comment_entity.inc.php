<?php


class CommentEntity {
    private $id;

    private $text;

    private $author;

    private $post;

    private $comment;

    private $date;

    public function __construct(int $id, string $text, UserEntity $author,
        PostEntity|null $post, CommentEntity|null $comment, int $date) {

            // el unico tipo en común es null, por lo tanto
            // se comprueba que los dos sean nulos
            // además, se comprueba que los dos tengan datos (no sean nulos)
            if ($post == $comment || (!$post && !$comment) ) {
                throw new Exception("Es necesario especificar un post o un comentario", 1);
            }

            $this->id = $id;
            $this->text = $text;
            $this->author = $author;
            $this->post = $post;
            $this->comment = $comment;

            $this->date = new DateTime();
            $this->date->setTimeStamp($date);
    }

    public function getId(): int {
        return $this->id;
    }

    public function getText(): string {
        return $this->text;
    }

    public function setText(string $text) {
        $this->text = $text;
    }

    public function getAuthor(): UserEntity {
        return $this->author;
    }

    public function getPost(): PostEntity|null {
        return $this->post;
    }

    public function getComment(): CommentEntity|null {
        return $this->comment;
    }

    public function getCreationDate(): DateTime {
        return $this->date;
    }
}

 