<?php

/*
    Este archivo contiene funciones útiles para la aplicación
*/


/**
 * Redirigir al usuario a otra página
 * @param string $route La ruta a la que se redirige al usuario
 * @param bool $permanent SI la redirección es permanente o no
 */
function redirect(string $route, bool $permanent = true) {
    header('Location: ' . $route, true, $permanent ? 301 : 302);
    exit();
}

/**
 * Redirigir al usuario a la página de inicio de sesión si el usuario no está registrado
 */
function needs_authentication() {
    global $session;

    if (!$session->isAuthenticated()) {
        redirect(LOGIN_ROUTE);
    }
}

/**
 * Incluye las views a la página
 * @param array $views Lista de views a incluir
 */
function include_views(array $views) {
    echo '<!DOCTYPE html><html lang="es"><head>';
    include "views/partials/meta.html";
    echo '</head><body>';

    foreach ($views as $view) {
        include $view;
    }

    echo '</body></html>';
}

/**
 * Obtiene el archivo de entrada
 */
function current_file() {
    return $_SERVER['SCRIPT_NAME'];
}

/**
 * Obtiene el método HTTP usado
 */
function get_method(): string {
    return $_SERVER['REQUEST_METHOD'];
}

/**
 * Comprueba que los nombres de los parámetros estén en el post
 * @param array $names Nombres
 */
function check_post_data(array $names, $post = null) {
    if (!$post) {
        $post = $_POST;
    }

    foreach ($names as $name) {
        if (!isset($post[$name])) {
            return false;
        }
    }
    return true;
}

/**
 * Obtiene un elemento de los datos envíados a través de POST
 * @param string $key Clave
 * @param mixed $default Valor por defecto
 * @param array $post Lista de la que obtener los datos (null es $_POST)
 * @return mixed Datos
 */
function get_post(string $key, mixed $default = null, array $post = null): mixed {
    if (!$post) {
        $post = $_POST;
    }
    return isset($post[$key]) ? $post[$key] : $default;
}

/**
 * Sube un archivo y lo guarda en base de datos
 * @param array $file Los datos del archivo de $_FILE
 * @return FileEntity|null Archivo
 */
function upload_file(array $file): FileEntity|null {
    // obtener los datos del archiv
    $name = $file['name'];
    $tmp_name = $file['tmp_name'];
    $new_name = uniqid(more_entropy: true);

    // mover y comprobar que el archivo se ha movido correctamente
    if (move_uploaded_file($tmp_name, UPLOADS_FOLDER . '/' . $new_name)) {
        return FileRepository::createNewFile($name, $new_name);
    }

    return null;
}