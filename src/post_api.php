<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

//obtener parametros del GET
$method = isset($_GET['method']) ? $_GET['method'] : '';
// minimo 0 maximo x
$offset = isset($_GET['offset']) ? abs(intval($_GET['offset'])) : 0;
$postId = isset($_GET['post']) ? abs(intval($_GET['post'])) : null;

// Funciones
function getLastPosts(int $offset): array {
    $salida = [];
    $posts = PostRepository::getLastPosts($offset);

    foreach($posts as $post) {
        $salida[] = [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'category' => $post->getCategory()->getName(),
            'author' => $post->getAuthor()->getUsername(),
            'author_id' => $post->getAuthor()->getId(),
            'date' => $post->getCreationDate()->format('Y-m-d H:i:s'),
            'favs' => PostRepository::getPostBookmarkCount($post),
            'comments' => CommentRepository::getPostCommentNum($post)
        ];
    }

    return $salida;
}

function getLastComments(int $postId, int $offset): array {
    $salida = [];

    if ($post = PostRepository::getPostById($postId)) {
        $comments = CommentRepository::getPostComments($post, $offset);

        foreach ($comments as $comment) {
            $salida[] = [
                'id' => $comment->getId(),
                'author' => $comment->getAuthor()->getUsername(),
                'author_id' => $comment->getAuthor()->getId(),
                'date' => $comment->getCreationDate()->format('Y-m-d H:i:s'),
                'favs' => CommentRepository::getCommentVotes($comment),
                'subcomments_num' => CommentRepository::getCommentSubcommentNum($comment)
            ];
        }
    }

    return $salida;
}

$salida = [];

// Comprobar el metodo solicitado
switch ($method) {
    case 'lastPosts':
        $salida = getLastPosts($offset);
        break;
    case 'comments':
        $salida = getLastComments($postId, $offset);
        break;
    default:
        // en caso de fallo mostrar un array vacío
        break;
}

echo json_encode($salida);


