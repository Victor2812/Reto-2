<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

// Eliminar autenticación
$session->authenticate(null);
?>

<script>
    // limpiar el local storage
    localStorage.clear();

    // redirigir al usuario
    window.location.replace("<?php echo LOGIN_ROUTE; ?>");   
</script>