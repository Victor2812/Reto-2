<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

include_views([
    "views/header.view.php",
    "views/content.view.php",
    "views/footer.view.php",
]);
?>