const POST_API_URL = "/post_api.php";
const USER_API_URL = "/user_api.php";

const CACHE_LIFETIME = 5 * 60 * 1000; // 5 minutos en milisegundos

function processApiResponse(r) {
    if (r.ok) {
        try {
            return r.json();
        } catch (ex) {
            return {error: 'Respuesta del servidor no válida'};
        }
    }
    return {error: 'No es posible obtener la información'};
}

function getDataFromLocalStorage(prefix = '') {
    let data = {};
    for (const key in localStorage) {
        if (localStorage.hasOwnProperty(key) && key.startsWith(prefix)) {
            // obtener la llave original y su valor
            let k = key.replace(prefix, '');
            let v = localStorage.getItem(key);
            
            // convertir los números y valores especiales (ej. null)
            try {
                data[k] = JSON.parse(v);
            } catch {
                data[k] = v;
            }
        }
    }
    return data;
}

function setDataToLocalStorage(data, prefix = '') {
    for (const [key, value] of Object.entries(data)) {
        // establecer el prefijo
        localStorage.setItem(prefix + key, value);
    }
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

async function updateUserDataFromAPI(force = false) {
    let now = Date.now();
    let before = getDataFromLocalStorage('_userdata_')?.time || null; // undefined no nos vale, así que usaremos null en ese caso

    // jugamos con que si before es nulo, el resultado de la operación sería como (N - null = N) (ej. 7 - null = 7)
    // por lo tanto, si los datos no están almacenados la condición siempre se cumplirá
    if (now - before > CACHE_LIFETIME || force) {
        // obtener la información desde la API
        let r = await fetch('/user_api.php?method=getUser');
        let data = await processApiResponse(r);

        if (!data.error) {
            data['_userdata_time'] = Date.now();
            // establecer los datos
            setDataToLocalStorage(data, 'userdata_');

            // establecer el tiempo de vida de la caché
            setDataToLocalStorage({_userdata_time: Date.now()});
        } else {
            // hay un error
            localStorage.clear();
            return data;
        }
    }
}

async function getCurrentUserData() {
    await updateUserDataFromAPI();
    let data = getDataFromLocalStorage('userdata_');
    return data;
}

async function setCurrentUserData(data) {
    let r = await fetch('/user_api.php?method=setUser', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: new Headers({
          'Content-Type': 'application/json'
        })
    });

    // forzar actualización de la caché
    await updateUserDataFromAPI(true);

    return processApiResponse(r);
}

async function checkFollowingUser(userId) {
    let r = await fetch(USER_API_URL + `?method=isFollowing&user=${userId}`);
    return processApiResponse(r);
}

async function toggleFollowingUser(userId) {
    let r = await fetch(USER_API_URL + `?method=toggleFollowing&user=${userId}`);
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