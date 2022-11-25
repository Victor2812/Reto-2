<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

//necesita estar logeado para poder subir un post
needs_authentication();

// variables para la view
$form_errors = [];

function render() {
    include_views([
        "views/partials/header.view.php",
        "views/post_new.view.php",
        "views/partials/footer.view.php"
    ]);

    die();
}

if (get_method() == 'POST') {

    if (!check_post_data(['title', 'text', 'category'])) {
        redirect(current_file());
    }

    $title = $_POST['title'];
    $text = $_POST['text'];
    $category = abs(intval($_POST['category'])); // siempre será un numero no negativo
    $tags = trim($_POST['tags']);
    $upload = isset($_POST['upload']) ? $_POST['upload'] : null;

    //obtener objetos de la base de datos
    $category = CategoryRepository::getCategoryById($category);

    if ($tags) {
        //procesar los tags si hay
        $tags = explode(',', $tags);

        if (count($tags) > MAX_TAGS_PER_POST) {
            $form_errors[] = 'Demasiados tags';
            render();
        }

        $tags = array_filter(array_map(function ($tag) {
            // obtiene el nombre sin espacioes
            $name = str_replace(' ', '_', trim($tag));

            if (strlen($name) > 0) {
                //obtiene la tag de base de datos y si no existe la crea
                if ($tag = TagRepository::getTagByName($name)) {
                    return $tag;
                } else {
                    return TagRepository::createNewTag($name);
                }
            }
        }, $tags), function ($tag) {
            // filtra los tags por si no se han añadido a base de datos
            return $tag != null;
        });
    } else {
        $tags = [];
    }

    // intentar subir el archivo
    $file = null;
    if (isset($_FILES['upload']) && $_FILES['upload']['size'] > 0) {
        $file = upload_file($_FILES['upload']);
        if (!$file) {
            $form_errors[] = 'No se ha podido subir el archivo';
            render();
        }
    }

    // comproabr si el post se ha creado correctamente, sino mostrar un error
    if (($post = PostRepository::createNewPost($title, $text, $category, $session->getCurrentUser(), $tags, $file))) {
        $id = $post->getId();
        redirect("/post.php?post=$id");
    } else {
        $form_errors[] = 'No se ha podido crear el post';
    }
    
}

render();
?>