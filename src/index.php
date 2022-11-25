<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

include_views([
    "views/partials/header.view.php",
    "views/main_content.view.php",
    "views/partials/footer.view.php"
]);
?>