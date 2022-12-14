<?php
use Vtiful\Kernel\Excel;
// Esta sentencia es obligatoria en cada archivo PHP de entrada (no views)
require_once "app/__include.inc.php";

needs_authentication();

//obtener parametros del GET
$method = isset($_GET['method']) ? $_GET['method'] : '';

// obtener usuario específico si se necesita
$user = isset($_GET['user'])
    ? UserRepository::getUserById(abs(intval($_GET['user'])))
    : null;

// Funciones
/**
 * Obtiene la información necesaria para el banner de usuario
 */
function getUserInfo(): array {
    $user = $GLOBALS['session']->getCurrentUser();

    return [
        'username' => $user->getUsername(),
        'name' => $user->getName(),
        'surname' => $user->getSurname(),
        'job' => $user->getJob()
    ];
}


function setUserInfo(): array {
    $json = file_get_contents('php://input');

    if (strtolower(get_method()) != 'post' || !$json) {
        return ['error' => 'Server: no data'];
    }

    // convertir a array
    $json = json_decode($json, true);

    if (!check_post_data(['name'], $json)) {
        return ['error' => 'No se ha especificado un nombre'];
    }

    $name = $json['name'];
    $surname = get_post('surname', post: $json);
    $job = get_post('job', post: $json);
    $passwd = get_post('passwd', post: $json);
    $passwd2 = get_post('passwd2', post: $json);

    $s = $GLOBALS['session'];

    // las contraseñas no coinciden y el usuario ha intentado cambiarla
    if ($passwd && $passwd != $passwd2) {
        return ['error' => 'Las contraseñas no coinciden'];
    } else if ($passwd) {
       $s->getCurrentUser()->setPassword($passwd);
    }

    $s->getCurrentUser()->setName($name);
    $s->getCurrentUser()->setSurname($surname);
    $s->getCurrentUser()->setJob($job);

    try {
        UserRepository::update($s->getCurrentUser());
    } catch (Exception $ex) {
        return ['error' => 'Server: ' . $ex->getMessage()];
    }

    return ['ok' => 'ok'];
}

function checkFollowingUser(UserEntity $destination): array {
    if (!$destination) {
        return ['error' => 'Usuario no encontrado'];
    }
    $user = $GLOBALS['session']->getCurrentUser();

    return [
        'following' => UserRepository::isUserFollowingUser($user, $destination),
    ];
}

function toggleFollowingUser(UserEntity $destination): array {
    if (!$destination) {
        return ['error' => 'Usuario no encontrado'];
    }
    $user = $GLOBALS['session']->getCurrentUser();

    if (UserRepository::isUserFollowingUser($user, $destination)) {
        UserRepository::removeUserFollow($user, $destination);
    } else {
        UserRepository::addUserFollow($user, $destination);
    }

    return checkFollowingUser($destination);
}

$salida = [];

// Comprobar el metodo solicitado
switch ($method) {
    case 'getUser':
        $salida = getUserInfo();
        break;
    case 'setUser':
        $salida = setUserInfo();
        break;
    case 'isFollowing':
        $salida = checkFollowingUser($user);
        break;
    case 'toggleFollowing':
        $salida = toggleFollowingUser($user);
        break;
    default:
        // en caso de fallo mostrar un array vacío
        break;
}

echo json_encode($salida);