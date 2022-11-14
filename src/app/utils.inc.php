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