<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

//obtener parametros del GET
$method = isset($_GET['method']) ? $_GET['method'] : '';
// minimo 0 maximo x
$offset = isset($_GET['offset']) ? abs(intval($_GET['offset'])) : 0;

// Funciones
function getLastPosts(int $offset) {
    $salida = [];
    $posts = PostRepository::getLastPosts($offset);
    foreach($posts as $post) {
        $salida[] = [
            'title' => $post->getTitle(),
            'category' => $post->getCategory()->getName(),
            'author' => $post->getAuthor()->getUsername(),
            'author_url' => '#',
            'date' => $post->getCreationDate()->format('Y-m-d H:i:s'),
            'favs' => 0,
            'comments' => 0
        ];
    }
    echo json_encode($salida);
}

// Comprobar el metodo solicitado
switch ($method) {
    case 'lastPosts':
        getLastPosts($offset);
        break;
    default:
        // en caso de fallo mostrar un array vacío
        echo '[]';
        break;
}