<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();


//obtener parametros del GET
$method = isset($_GET['method']) ? $_GET['method'] : '';

// minimo 0 maximo x
$offset = isset($_GET['offset']) ? abs(intval($_GET['offset'])) : 0;

// obtener el Post si se necesita
$post = isset($_GET['post'])
    ? PostRepository::getPostById(abs(intval($_GET['post'])))
    : null;

// obtener comentario si se necesita
$comment = isset($_GET['comment'])
    ? CommentRepository::getCommentById(abs(intval($_GET['comment'])))
    : null;


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

/**
 * Convierte un comentario en un array de datos
 * @param CommentEntity $comment Comentario
 * @return array
 */
function parseCommentToOutput(CommentEntity $comment, UserEntity $user): array {
    return [
        'id' => $comment->getId(),
        'text' => $comment->getText(),
        'author' => $comment->getAuthor()->getUsername(),
        'author_id' => $comment->getAuthor()->getId(),
        'date' => $comment->getCreationDate()->format('Y-m-d H:i:s'),
        'votes' => CommentRepository::getCommentVotes($comment),
        'is_voted' => CommentRepository::isCommentVoted($comment, $user),
        'subcomments_num' => CommentRepository::getCommentSubcommentNum($comment)
    ];
}

function getLastComments(PostEntity|null $post, int $offset): array {
    $u = $GLOBALS['session']->getCurrentUser();
    $salida = [];

    if ($post) {
        $comments = CommentRepository::getPostComments($post, $offset);

        foreach ($comments as $comment) {
            $salida[] = parseCommentToOutput($comment, $u);
        }
    } else {
        $salida = ['error' => 'No se ha encontrado el post'];
    }

    return $salida;
}

function getCommentData(CommentEntity|null $comment) {
    $u = $GLOBALS['session']->getCurrentUser();
    if ($comment) {
        return parseCommentToOutput($comment, $u);
    } else {
        return ['error' => 'No se ha encontrado el comentario'];
    }
}

function toggleCommentVote(CommentEntity|null $comment) {
    $u = $GLOBALS['session']->getCurrentUser();
    $salida = [];

    if ($comment) {
        // comprobar si el comentario está votado
        $v = CommentRepository::isCommentVoted($comment, $u);

        // actualizar el voto
        if ($v) {
            CommentRepository::removeCommentVote($comment, $u);
        } else {
            CommentRepository::addCommentVote($comment, $u);
        }

        $salida = ['is_voted' => !$v];
    } else {
        $salida = ['error' => 'No se ha encontrado el comentario'];
    }

    return $salida;
}

function getBookmarkData(PostEntity|null $post): array {
    $u = $GLOBALS['session']->getCurrentUser();
    $salida = [];

    if ($post) {
        $b = PostRepository::isPostBookmarked($u, $post);
        $c = PostRepository::getPostBookmarkCount($post);

        $salida = [
            'bookmarked' => $b,
            'count' => $c
        ];
    } else {
        $salida = ['error' => 'No se ha encontrado el post'];
    }

    return $salida;
}

function toggleBookmark(PostEntity|null $post) {
    $u = $GLOBALS['session']->getCurrentUser();
    $salida = [];

    if ($post) {
        $b = PostRepository::isPostBookmarked($u, $post);
        if ($b) {
            PostRepository::removeBookmarkedPost($post, $u);
        } else {
            PostRepository::addPostToUserBookmark($post, $u);
        }
        $salida = ['message' => 'ok'];
    } else {
        $salida = ['error' => 'No se ha encontrado el post'];
    }

    return $salida;
}


$salida = [];

// Comprobar el metodo solicitado
switch ($method) {
    case 'lastPosts':
        $salida = getLastPosts($offset);
        break;
    case 'getLastComments':
        $salida = getLastComments($post, $offset);
        break;
    case 'getCommentData':
        $salida = getCommentData($comment);
        break;
    case 'toggleCommentVote':
        $salida = toggleCommentVote($comment);
        break;
    case 'getBookmark':
        $salida = getBookmarkData($post);
        break;
    case 'toggleBookmark':
        $salida = toggleBookmark($post);
        break;
    default:
        // en caso de fallo mostrar un array vacío
        break;
}

echo json_encode($salida);
