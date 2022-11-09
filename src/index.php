<?php

// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";


echo "Hola mundo<br/>";

include "views/login.view.php";

if ($user = UserRepository::getUserByUsername('gaizkx')) {
    if (!$session->isAuthenticated()) {
        $session->authenticate($user);
    }
    echo 'Estás autenticado';
} else {
    UserRepository::createNewUser('gaizkx', 'Gaizka', 'Guerrero', null, 'Jm12345');
}