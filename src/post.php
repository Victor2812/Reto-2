<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication(); //redirige al login si no estas autenticado

//comprobar que hay un post
if (!isset($_GET['post'])) {
    redirect('/index.php');
}

include_views([
    "views/partials/header.view.php",
    "views/post.view.php",
    "views/partials/footer.view.php"
]);