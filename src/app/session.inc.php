<?php

/*
    Este archivo contiene una clase para manejar las sesiones
    de forma segura.
*/

// Inicializar la sesión
class SessionManager {
    /**
     * EL tiempo que tarda una sesión en cambiar de ID
     * @var integer
     */
    const RENEW_TIME =  60 * 60; // 1 hora(s)

    /**
     * @var UserEntity|null
    */
    private $currentUser;

    public function __construct() {
        session_start();

        // comprobar expiración de la sesión
        $this->check_destroyed();
        $this->check_session_gc();
        $this->get_current_user();
    }

    private function check_destroyed() {
        if (isset($_SESSION['_destroyed'])) {
            // Eliminar sesión sin actividad
            if ($_SESSION['_destroyed'] < time() - 60) {
                session_destroy();
                session_start();
            }
            // Prevenir cookie perdida por fallo de conexión
            else if (isset($_SESSION['_new_session'])) {
                session_commit();

                session_id($_SESSION['_new_session']);
                session_start();
            }
            // Ni es MUY antigua ni ha sido sustituída, simplemente ha expirado
            else if ($_SESSION['_destroyed'] <= time()) {
                session_regenerate_id();
                $_SESSION['_destroyed'] = time() + self::RENEW_TIME;
            }
        } else {
            $_SESSION['_destroyed'] = time() + self::RENEW_TIME;
        }
    }

    private function check_session_gc() {
        // Código de https://www.php.net/manual/en/function.session-gc.php
        $gc_time = '/tmp/php_session_last_gc';
        $gc_period = 0;
    
        if (file_exists($gc_time)) {
            if (filemtime($gc_time) < time() - $gc_period) {
                session_gc();
                touch($gc_time);
            }
        } else {
            touch($gc_time);
        }
    }

    private function get_current_user() {
        $id = $this->get('_uid'); // User ID
        if (is_int($id)) {
            $this->currentUser = UserRepository::getUserById($id);
        }
    }

    /**
     * Obtiene una variable de la sesión
     * @param string $key El nombre de la variable
     * @return mixed El valor de la variable
     */

    public function get(string $key): mixed {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : null;
    }

    /**
     * Establece una variable dentro de la sesión. Si la variable es crítica regenera la sesión.
     * @param string $key El nombre de la variable
     * @param mixed $value El valor de la variable
     */
    public function set(string $key, mixed $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Elimina una variable de la sesión
     * @param string $key El nombre de la variable
     */
    public function del(string $key) {
        unset($_SESSION[$key]);
    }

    /**
     * Obtiene el usuario actual
     * @return UserEntity|null Usuario actual
     */
    public function getCurrentUser(): UserEntity|null {
        return $this->currentUser;
    }

    /**
     * Establece el usuario actual
     * @param UserEntity|null $user Usuario actual
     */
    public function authenticate(UserEntity|null $user) {
        if ($user != null && is_int($user->getId())) {
            $this->set('_uid', $user->getId()); // debería ser crítico, pero está bug
            $this->currentUser = $user;
        } else {
            $this->del('_uid');                 // debería ser crítico, pero está bug
        }
    }

    /**
     * Comprueba si el usuario está autenticado
     * @return bool Si el usuario está autenticado o no
     */
    public function isAuthenticated(): bool {
        return $this->currentUser != null;
    }
}


// Variable global de sesión
$session = new SessionManager();
