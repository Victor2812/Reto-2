<?php

// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";


echo "Hola mundo<br/>";

include "views/login.view.php";

if (!$session->isAuthenticated()) {
    echo 'No estas autenticado';
    $session->authenticate(UserRepository::getUserById(6));
} else {
    echo 'Ya estás autenticado';
    $session->authenticate(null);
}