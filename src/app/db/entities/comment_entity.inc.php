<?php


class CommentEntity {
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var UserEntity
     */
    private $author;

    /**
     * @var PostEntity|null
     */
    private $post;

    /**
     * @var CommentEntity|null
     */
    private $comment;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var FileEntity|null
     */
    private $file;

    public function __construct(int $id, string $text, UserEntity $author,
        PostEntity|null $post, CommentEntity|null $comment, int $date, FileEntity|null $file) {

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

            $this->file = $file;
    }

    /**
     * Obtiene el ID del comentario
     * @return int ID
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Obtiene el texto del comentario
     * @return string texto
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * Establece el texto del comentario
     * @param string $text Texto
     */
    public function setText(string $text) {
        $this->text = $text;
    }

    /**
     * Obtiene el autor del comentario
     * @return UserEntity Usuario
     */
    public function getAuthor(): UserEntity {
        return $this->author;
    }

    /**
     * Obtiene el Post padre del comentario
     * @return PostEntity|null Post padre del comentario
     */
    public function getPost(): PostEntity|null {
        return $this->post;
    }

    /**
     * Obtiene el Comentario padre del comentario
     * @return CommentEntity|null Comentario padre del comentario
     */
    public function getComment(): CommentEntity|null {
        return $this->comment;
    }

    /**
     * Obtiene el la fecha del comentario
     * @return DateTime Fecha
     */
    public function getCreationDate(): DateTime {
        return $this->date;
    }

    /**
     * Obtiene el archivo subido con el comentario
     * @return FileEntity|null Archivo
     */
    public function getFile(): FileEntity|null {
        return $this->file;
    }
}

 