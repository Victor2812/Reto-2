<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

include_views([
    "views/header.view.php",
    "views/small-post.html",
    "views/comentario.html"
]);
?>