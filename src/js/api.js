const POST_API_URL = "/post_api.php";
const USER_API_URL = "/user_api.php";

async function processApiResponse(r) {
    if (r.ok) {
        try {
            return r.json();
        } catch (ex) {
            return {error: 'Respuesta del servidor no válida'};
        }
    }
    return {error: 'No es posible obtener la información'};
}

/*
    --------------------- POST ----------------------
*/

async function getLastPostsData(offset) {
    let r = await fetch(POST_API_URL + `?method=lastPosts&offset=${offset}`);
    return processApiResponse(r);
}

async function getLastUserPostsData(offset, userId) {
    let r = await fetch(POST_API_URL + `?method=userPosts&offset=${offset}&user=${userId}`);
    return processApiResponse(r);
}

/*
    --------------------- BOOKMARK ----------------------
*/

async function getBookmarkData(func, postId) {
    // carga la información de los favoritos en los posts
    let r = await fetch(POST_API_URL + '?method=' + func + '&post=' + postId);
    return processApiResponse(r);
}

/*
    --------------------- COMMENT ----------------------
*/

async function getLastCommentsData(type, id, offset) {
    // carga los comentarios de forma paginada a partir del último comentario cargado
    let r = await fetch(POST_API_URL + `?method=getLastComments&${type}=${id}&offset=${offset}`);
    return processApiResponse(r);
}

async function getCommentData(id, func) {
    // carga los comentarios de forma paginada a partir del último comentario cargado
    let r = await fetch(POST_API_URL + `?method=${func}&comment=${id}`);
    return processApiResponse(r);
}

async function uploadComment(type, id, data) {
    // siendo type 'post' o 'comment' y el ID será el ID del elemento correspondiente
    let r = await fetch(POST_API_URL + `?method=newComment&${type}=${id}`, {
        method: 'POST',
        body: data
    });
    return processApiResponse(r);
}

/*
    --------------------- USER ----------------------
*/

async function getCurrentUserData() {
    let r = await fetch('/user_api.php?method=getUser');
    return processApiResponse(r);
}

async function setCurrentUserData(data) {
    let r = await fetch('/user_api.php?method=setUser', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: new Headers({
          'Content-Type': 'application/json'
        })
    });
    return processApiResponse(r);
}

/*
    --------------------- FUNCIONES ÚTILES ----------------------
*/

function setButtonText(button, text) {
    let span = button.querySelector('span');
    if (span) {
        span.innerText = text;
    } else {
        button.innerText = text;
    }
}