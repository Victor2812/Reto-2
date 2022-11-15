<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

// Eliminar autenticación
$session->authenticate(null);

// Volver al login
redirect(LOGIN_ROUTE);