<?php
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

//necesita estar logeado para poder subir un post
needs_authentication();

if (get_method() == 'POST') {

    /*
        array(4) {
                ["category"]=>
                string(1) "1"
                ["title"]=>
                string(3) "qwe"
                ["tags"]=>
                string(3) "qwe"
                ["text"]=>
                string(3) "qwe"
            }
        array(1) {
            ["upload"]=>
                array(5) {
                    ["name"]=>
                    string(11) "aerbide.sql"
                    ["type"]=>
                    string(24) "application/octet-stream"
                    ["tmp_name"]=>
                    string(14) "/tmp/phpXTNt4A"
                    ["error"]=>
                    int(0)
                    ["size"]=>
                    int(7815)
            }
        }
    */

    if (!check_post_data(['title', 'text', 'category'])) {
        redirect(current_file());
    }

    $title = $_POST['title'];
    $text = $_POST['text'];
    $category = abs(intval($_POST['category'])); // siempre será un numero no negativo
    $tags = $_POST['tags'];
    $upload = isset($_POST['upload']) ? $_POST['upload'] : null;

    //obtener objetos de la base de datos
    $category = CategoryRepository::getCategoryById($category);

    if ($tags) {
        //procesar los tags si hay
        $tags = explode(',', $tags);

        $tags = array_filter(array_map(function ($tag) {
            // obtiene el nombre sin espacioes
            $name = str_replace(' ', '_', trim($tag));

            //obtiene la tag de base de datos y si no existe la crea
            if ($tag = TagRepository::getTagByName($name)) {
                return $tag;
            } else {
                return TagRepository::createNewTag($name);
            }
        }, $tags), function ($tag) {
            // filtra los tags por si no se han añadido a base de datos
            return $tag != null;
        });
    }

    //TODO: implementar subida de arhcivos a Post


    $post = PostRepository::createNewPost($title, $text, $category, $session->getCurrentUser(), $tags);

    if ($post) {
        //TODO: redireccionar a la página para ver el POST
    } else {
        //mostrar un error
    }

    // quitar esto
    redirect('/index.php');
    
} else {
    include_views([
        "views/header.view.php",
        "views/post_new.view.php",
        "views/footer.view.php"
    ]);
}
?>