<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

if (get_method() == 'POST') {

    // comprobar si los datos existen para evitar posibles errores
    if (!isset($_POST['login_user']) || !isset($_POST['login_pass'])) {
        redirect(current_file());
    }

    $username = $_POST['login_user'];
    $password = $_POST['login_pass'];

    // obtener usuario del repositorio y comprobar su contraseña
    if ($user = UserRepository::getUserByUsername($username)) {
        if ($user->checkPassword($password)) {
            $session->authenticate($user);
            redirect('/index.php'); // redirigir al index
        }
    }

    // si el usuario no existe o la contraseña es incorrecta redirigir al login
    redirect(current_file());
    
} else {
    include_views([
        "views/login.view.php"
    ]);
}
