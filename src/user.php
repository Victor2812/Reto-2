<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

$user = $session->getCurrentUser();

// obtener el usuario del método GET (si existe)
if (isset($_GET['user'])) {
    $id = abs(intval($_GET['user']));
    if ($id != $user->getId() && ($u = UserRepository::getUserById($id))) {
        $user = $u;
    }
}

include_views([
    "views/header.view.php",
    "views/user.view.php",
    "views/footer.view.php"
])

?>