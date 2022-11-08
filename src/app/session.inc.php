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
    const RENEW_TIME =  15 * 60; // 15 mins

    public function __construct() {
        session_start();

        // comprobar expiración de la sesión
        $this->check_destroyed();
        $this->check_session_gc();
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


    // Se utiliza por motivos de seguridad sobre todo en el cambio de
    // privilegios dentro de la aplicación.
    /**
     * Cambia el ID de la sesión sin eliminar la antigua
     */
    function regenerate() {
        // Crear la sesión nueva
        $new_id = session_create_id();
        $this->set('_new_session', $new_id);

        // Establecer la hora de destrucción a ahora
        $this->set('_destroyed', time());

        // Guardar la sesión antigua
        session_commit();

        // Cambiar de sesión
        session_id($new_id);
        ini_set('session.use_strict_mode', 0);
        session_start();
        ini_set('session.use_strict_mode', 1);

        // Eliminar residuos de la sesión antigua
        $this->del('_new_session');
        $this->del('_destroyed');
    }

    /**
     * Obtiene una variable de la sesión
     * @param $key El nombre de la variable
     * @return mixed El valor de la variable
     */

    function get(string $key): mixed {
        return $_SESSION[$key];
    }

    /**
     * Establece una variable dentro de la sesión. Si la variable es crítica regenera la sesión.
     * @param string $key El nombre de la variable
     * @param mixed $value El valor de la variable
     * @param bool $critical Si la variable es crítica
     */
    function set(string $key, mixed $value, bool $critical = false) {
        // Si los datos son criticos, cambiar de sesión y actualizar los datos en la nueva
        if ($critical) $this->regenerate();
        $_SESSION[$key] = $value;
    }

    /**
     * Elimina una variable de la sesión
     * @param $key El nombre de la variable
     */
    function del(string $key) {
        unset($_SESSION[$key]);
    }
}


// Variable global de sesión
$session = new SessionManager();
