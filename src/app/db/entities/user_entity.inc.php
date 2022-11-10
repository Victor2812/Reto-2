<?php


class UserEntity {
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;
    
    /**
     * @var string
     */
    private $image;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $points;

    /**
     * @var string
     */
    private $job;
    
    /**
     * @var string
     */
    private $passwd;

    public function __construct(int $id, string $username, string $name, string|null $surname, string|null $image,
        int $date, int $points, string|null $job, string $passwd) {
            $this->id = $id;
            $this->username = $username;
            $this->name = $name;
            $this->surname = $surname;
            $this->image = $image;

            $this->date = new DateTime();
            $this->date->setTimeStamp($date);

            $this->points = $points;
            $this->job = $job;
            $this->passwd = $passwd;
    }

    /**
     * Obtiene el ID del usuario
     * @return int Id del usuario
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Obtiene el nombre de usuario
     * @return string Nombre de usuario
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * Establece el nombre de usuario
     * @param string $newName Nombre de usuario
     */
    public function setUsername($newName) {
        $this->username = $newName;
    }

    /**
     * Obtiene el nombre del usuario
     * @return string Nombre del usuario
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Establece el nombre del usuario
     * @param string $newName Nombre
     */
    public function setName($newName) {
        $this->name = $newName;
    }

    /**
     * Obtiene el apellido del usuario
     * @return string Apelldio del usuario
     */
    public function getSurname(): string|null {
        return $this->surname;
    }

    /**
     * Establece el apellido del usuario
     * @param string $newSurname Apellido
     */
    public function setSurname(string|null $newSurname) {
        $this->name = $newSurname;
    }

    /**
     * Obtiene la imágen del perfil del usuario
     * @return string Imágen del usuario
     */
    public function getImagePath(): string|null {
        return $this->image;
    }

    /**
     * Establece la nueva imágen del perfil del usuario
     * @param string $newPath ruta de la imágen
     */
    public function setImagePath(string|null $newPath) {
        $this->image = $newPath;
    }

    /**
     * Obtiene la fecha de creación del usuario
     * @return DateTime Fecha de creación del usuario
     */
    public function getCreationDate(): DateTime {
        return $this->date;
    }

    /**
     * Obtiene los puntos del usuario
     * @return int Puntos del usuario
     */
    public function getPoints(): int {
        return $this->points;
    }

    /**
     * Establece los puntos del usuario
     * @return int $newPoints Puntos
     */
    public function setPoints(int $newPoints) {
        $this->points = $newPoints;
    }

    /**
     * Añade puntos al usuario
     * @return int $points Puntos a añadir
     */
    public function addPoints(int $points) {
        $this->points += $points;
    }

    /**
     * Obtiene el puesto de trabajo del usuario
     * @return string Puesto de trabajo del usuario
     */
    public function getJob(): string|null {
        return $this->job;
    }

    /**
     * Establece el nuevo puesto trabajo del usaurio
     * @param string $newJob Nuevo puesto de trabajo
     */
    public function setJob(string|null $newJob) {
        $this->job = $newJob;
    }

    /**
     * Comprueba la contraseña del usuario
     * @return bool Igualdad de la contraseña con la del usuario
     */
    public function checkPassword(string $passwd): bool {
        return $this->passwd === $passwd;
    }

    /**
     * Establece la nueva contraseña del usaurio
     * @param string $plain Contraseña en texto plano
     */
    public function setPassword(string $plain) {
        $this->passwd = $plain;
    }

    /**
     * Obtiene la contraseña del usuario
     * @return string Contraseña
     */
    public function getPasswd(): string {
        return $this->passwd;
    }
}