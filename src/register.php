<?php 
//Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

if (get_method() == 'POST'){

    //Comprobar la existencia de los datos
    if (!check_post_data(['reg_username', 'reg_name', 'reg_pass', 'reg_rp_pass'])) {
        redirect(current_file());
    }

    $username = $_POST['reg_username'];
    $name = $_POST['reg_name'];
    $password = $_POST['reg_pass'];
    $rp_password = $_POST['reg_rp_pass'];

    //Comprobar que el campo "repeat password" es correcto
    if ($password != $rp_password){
        redirect(current_file());
    }

    //Crear nuevo usuario y autenticar
    if ($user = UserRepository::createNewUser($username, $name, null, null, $password)) {
        $session->authenticate($user);
        redirect('/index.php');
    }
    
    //Si no se puede crear el usuario redirigir a la pagina de registro
    redirect(current_file());
} else {
    include_views([
        "views/register.view.php"
    ]);
}

?>