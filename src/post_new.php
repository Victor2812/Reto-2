<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

//necesita estar logeado para poder subir un post
needs_authentication();

include_views([
    "views/header.view.php",
    "views/post_new.view.php",
    "views/footer.view.php"
]);
?>