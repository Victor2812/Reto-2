<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

// Un usuario autenticado no puede acceder a esta página
if ($session->isAuthenticated()) {
    redirect('/index.php');
}

$register_errors = [];
$login_errors = [];

function render() {
    include_views([
        "views/login.view.php"
    ]);
    die();
}

if (get_method() == 'POST') {

    // la acción por defecto será de inicio de sesión
    $action = isset($_GET['action'])
        ? $_GET['action']
        : 'login';

    if ($action == 'login') {
        // comprobar si los datos existen para evitar posibles errores
        if (!check_post_data(['login_user', 'login_pass'])) {
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
        
        // Si el usuario no existe o la contraseña no existe
        $login_errors[] = 'El usuario o contraseña no es válido';
        render();

    } else if ($action == 'register') {
        // comprobar si los datos existen para evitar posibles errores
        if (!check_post_data(['reg_username', 'reg_name', 'reg_pass', 'reg_rp_pass'])) {
            redirect(current_file());
        }

        $username = $_POST['reg_username'];
        $name = $_POST['reg_name'];
        $password = $_POST['reg_pass'];
        $password2 = $_POST['reg_rp_pass'];

        if ($password != $password2) {
            $register_errors[] = 'Las contraseñas no coinciden';
            render();
        }

        // comprobar si el usuairo ya existe
        if (UserRepository::getUserByUsername($username)) {
            $register_errors[] = 'El usuario ya existe';
            render();
        }

        // crear usuario
        if ($user = UserRepository::createNewUser($username, $name, null, null, $password)) {
            $session->authenticate($user);
            redirect('/index.php'); // redirigir al index
        } else {
            $register_errors[] = 'No se ha podido crear el usuario';
            render();
        }
    }

    // si el usuario no existe o la contraseña es incorrecta redirigir al login
    redirect(current_file());
    
} else {
    render();
}
