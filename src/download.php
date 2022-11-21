<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

// comprueba los parámetros
if (!isset($_GET['file'])) {
    echo 'Archivo no encontrado.';
    die();
}

// obtiene el archivo de base de datos
if ($file = FileRepository::getFileById(abs(intval($_GET['file'])))) {
    // cabeceras para informar de la descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file->getName() . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file->getPath()));

    // limpiar salida de PHP y descargar archivo
    flush();
    readfile($file->getPath());

} else {
    echo 'Archivo no encontrado';
}