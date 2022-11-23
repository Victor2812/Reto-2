<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

include_views([
    "views/header.view.php",
    "views/ranking.view.php",
    "views/footer.view.php"
]);