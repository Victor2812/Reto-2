<?php

/*
    Este archivo incluy todos los archivos PHP que gestionan los datos
    de la base de datos.
*/


// Variable global de la base de datos para entidades y repositorios
$db = new PDO("mysql:host=". DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
// Cuando ocurra un error lanzar una excepción
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Incluir entidades
require_once "entities/user_entity.inc.php";
require_once "entities/tag_entity.inc.php";
require_once "entities/category_entity.inc.php";
require_once "entities/file_entity.inc.php";
require_once "entities/post_entity.inc.php";
require_once "entities/comment_entity.inc.php";


// Incluir repositorios
require_once "repositories/user_repo.inc.php";
require_once "repositories/tag_repo.inc.php";
require_once "repositories/category_repo.inc.php";
require_once "repositories/file_repo.inc.php";
require_once "repositories/post_repo.inc.php";
require_once "repositories/comment_repo.inc.php";

/*
En algunos repositorios sería una buena idea utilizar alguna forma de memoización
para obtimizar el pedido de datos a la BBDD y no crear demasiadas solicitudes duplicadas
*/