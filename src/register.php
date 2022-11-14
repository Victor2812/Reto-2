<?php 
//Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)

require_once "app/__include.inc.php";

if (get_method() == 'POST'){

    //Comprobar la existencia de los datos
    if (!isset($_POST['reg_username']) || !isset($_POST['reg_name'])
        || !isset($_POST['reg_pass']) || !isset($_POST['reg_rp_pass'])) {
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

    //Crear nuevo usuario
    $user = UserRepository::createNewUser($username, $name, null, null, $password);
    
}

?>