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
/**
 * Obtiene los Posts más recientes ordenados
 * @param int $offset Offset para la consulta
 */
function getLastPosts(int $offset): array {
    $output = [];
    $posts = PostRepository::getLastPosts($offset);

    foreach($posts as $post) {
        $output[] = [
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

    return $output;
}

/**
 * Convierte un comentario en un array de datos
 * @param CommentEntity $comment Comentario
 * @return array
 */
function parseCommentToOutput(CommentEntity $comment, UserEntity $user): array {
    $parentPost = $comment->getPost();
    $parentComment = $comment->getComment();
    return [
        'id' => $comment->getId(),
        'text' => $comment->getText(),
        'author' => $comment->getAuthor()->getUsername(),
        'author_id' => $comment->getAuthor()->getId(),
        'date' => $comment->getCreationDate()->format('Y-m-d H:i:s'),
        'votes' => CommentRepository::getCommentVotes($comment),
        'is_voted' => CommentRepository::isCommentVoted($comment, $user),
        'subcomments_num' => CommentRepository::getCommentSubcommentNum($comment),
        'parent_post' => $parentPost ? $parentPost->getId() : null,
        'parent_comment' => $parentComment ? $parentComment->getId() : null,
    ];
}

/**
 * Obtiene los comentarios más recientes ordenados
 * @param PostEntity|null $post Obtener los comentarios de este post
 * @param CommentEntity|null $comment Obtener los subcomentarios de este comentario
 * @param int $offset Offset para la consulta
 * @return array Lista de datos
 */
function getLastComments(PostEntity|null $post, CommentEntity|null $comment, int $offset): array {
    $u = $GLOBALS['session']->getCurrentUser();
    $comments = [];

    if ($post) {
        $comments = CommentRepository::getPostComments($post, $offset);
    } else if ($comment) {
        $comments = CommentRepository::getCommentSubcomments($comment, $offset);
    } else {
       return ['error' => 'Información no especificada'];
    }

    $output = [];
    foreach ($comments as $comment) {
        $output[] = parseCommentToOutput($comment, $u);
    }

    return $output;
}

/**
 * Obtiene la información de un comentario
 * @param CommentEntity|null $comment Comentario
 * @return array Lista de datos
 */
function getCommentData(CommentEntity|null $comment) {
    $u = $GLOBALS['session']->getCurrentUser();
    if ($comment) {
        return parseCommentToOutput($comment, $u);
    } else {
        return ['error' => 'No se ha encontrado el comentario'];
    }
}

/**
 * Publicar un nuevo comentario
 * @param PostEntity|null $post Comentrio de este post
 * @param CommentEntity|null $comment Subcomentario de este comentario
 * @return array Lista de datos
 */
function newComment(PostEntity|null $post, CommentEntity|null $comment) {
    $u = $GLOBALS['session']->getCurrentUser();

    if (check_post_data(['text'])) {
        $text = $_POST['text'];
        $new = null;
        if ($post) {
            $new = CommentRepository::createNewComment($text, $u, $post, null);
        } else if ($comment) {
            $new = CommentRepository::createNewComment($text, $u, null, $comment);
        }

        // TODO: comprobar archivo

        // si no se ha podido crear el comentario devolver un mensaje de error
        return $new
            ? parseCommentToOutput($new, $u)
            : ['error' => 'No se ha podido crear el comentario'];
    }
    return ['error' => 'No se ha podido añadir el comentario'];
}

/**
 * Actualizar el voto del usuario autenticado sobre el comentario
 * @param CommentEntity|null $comment Comentario
 * @return array Lista de datos
 */
function toggleCommentVote(CommentEntity|null $comment) {
    $u = $GLOBALS['session']->getCurrentUser();
    $output = [];

    if ($comment) {
        // comprobar si el comentario está votado
        $v = CommentRepository::isCommentVoted($comment, $u);

        // actualizar el voto
        if ($v) {
            CommentRepository::removeCommentVote($comment, $u);
        } else {
            CommentRepository::addCommentVote($comment, $u);
        }

        $output = ['is_voted' => !$v];
    } else {
        $output = ['error' => 'No se ha encontrado el comentario'];
    }

    return $output;
}

/**
 * Obtener la información de favoritos del post
 * @param PostEntity|null $post Post
 * @return array Lista de datos
 */
function getBookmarkData(PostEntity|null $post): array {
    $u = $GLOBALS['session']->getCurrentUser();
    $output = [];

    if ($post) {
        $b = PostRepository::isPostBookmarked($u, $post);
        $c = PostRepository::getPostBookmarkCount($post);

        $output = [
            'bookmarked' => $b,
            'count' => $c
        ];
    } else {
        $output = ['error' => 'No se ha encontrado el post'];
    }

    return $output;
}

/**
 * Actualizar el favorito del usuario autenticado sobre el Post
 * @param PostEntity|null $post Post
 * @return array Lista de datos
 */
function toggleBookmark(PostEntity|null $post) {
    $u = $GLOBALS['session']->getCurrentUser();
    $output = [];

    if ($post) {
        $b = PostRepository::isPostBookmarked($u, $post);
        if ($b) {
            PostRepository::removeBookmarkedPost($post, $u);
        } else {
            PostRepository::addPostToUserBookmark($post, $u);
        }
        $output = ['message' => 'ok'];
    } else {
        $output = ['error' => 'No se ha encontrado el post'];
    }

    return $output;
}


$output = [];

// Comprobar el metodo solicitado
switch ($method) {
    case 'lastPosts':
        $output = getLastPosts($offset);
        break;
    case 'getLastComments':
        $output = getLastComments($post, $comment, $offset);
        break;
    case 'getCommentData':
        $output = getCommentData($comment);
        break;
    case 'newComment':
        $output = newComment($post, $comment);
        break;
    case 'toggleCommentVote':
        $output = toggleCommentVote($comment);
        break;
    case 'getBookmark':
        $output = getBookmarkData($post);
        break;
    case 'toggleBookmark':
        $output = toggleBookmark($post);
        break;
    default:
        // en caso de fallo mostrar un array vacío
        break;
}

echo json_encode($output);
