window.addEventListener('load', async (e) => {
    const API_URL = '/post_api.php';

    // Variables
    let params = new URLSearchParams(window.location.search);
    let currentPostId = params.get('post');
    let offsets = {
        comments: 0
    };

    // Elementos
    let postBookmarkBtn = document.querySelector('#postfavbtn');
    let postBookmarkCount = document.querySelector('#postbookmarkcount');
    let commentContainer = document.querySelector('main .box-comment');

    function setButtonText(button, text) {
        let span = button.querySelector('span');
        span.innerText = text;
    }


    /*
        --------------------- API ----------------------
    */

    async function processApiResponse(r) {
        if (r.ok) {
            try {
                return r.json();
            } catch (ex) {
                console.error(ex);
            }
        }
        return {error: 'No es posible obtener la información'};
    }

    async function getBookmarkData(func) {
        // carga la información de los favoritos en los posts
        let r = await fetch(API_URL + '?method=' + func + '&post=' + currentPostId);
        return processApiResponse(r);
    }

    async function getLastCommentsData() {
        // carga los comentarios de forma paginada a partir del último comentario cargado
        let r = await fetch(API_URL + `?method=getLastComments&post=${currentPostId}&offset=${offsets.comments}`);
        return processApiResponse(r);
    }

    async function getCommentData(id, func) {
        // carga los comentarios de forma paginada a partir del último comentario cargado
        let r = await fetch(API_URL + `?method=${func}&comment=${id}`);
        return processApiResponse(r);
    }


    /*
        --------------------- BOOKMARKS ----------------------
    */

    // Funcionalidad del botón de favoritos

    async function updateBookmarkData() {
        let data = await getBookmarkData('getBookmark');

        if (data.error) {
            console.error(data.error);
        } else {
            postBookmarkCount.innerText = data.count;
            if (data.bookmarked) {
                setButtonText(postBookmarkBtn, 'Quitar de favoritos');
            } else {
                setButtonText(postBookmarkBtn, 'Añadir a favoritos');
            }
        }
    }

    postBookmarkBtn.addEventListener('click', async (e) => {
        let data = await getBookmarkData('toggleBookmark');
        if (data.error) {
            console.error(data.error);
        } else {
            updateBookmarkData();
        }
    });


    /*
        --------------------- COMENTARIOS ----------------------
    */

    async function updateComment(id, is_voted = null) {
        // si no se lo pasamos por parámetro se lo pregunt a ala API
        if (is_voted === null) {
            data = await getCommentData(id, 'getCommentData');
            is_voted = data.is_voted || false;
        }

        let button = commentContainer.querySelector(`.comment[data-comment='${id}'] .comment-controls .comment-like-btn`);

        if (is_voted) {
            setButtonText(button, 'Quitar voto');
        } else {
            setButtonText(button, 'Votar');
        }
    }

    function mockupComment(params) {
        let comment = document.createElement('div');
        comment.classList.add('comment');
        comment.setAttribute('data-comment', params.id); // establecer el ID del comentario

        // se maqueta el contenido directamente dentro de la raiz del comentario
        comment.innerHTML = `
        <div class="comment-head">
            <img src="img/user-default-image.svg" class="author-image">
            <div class="comment-info">
                <p><a class="author" href="/user.php?user=${params.author_id}">${params.author}</a></p>
                <p class="comment-date">${params.date}</p>
            </div>
        </div>
        <div class="comment-body">
            <p>${params.text}</p>
        </div>
        <div class="comment-controls">
            <button class="button-white">
                <img src="img/comment-stroke.svg">
                Añadir comentario
            </button>
            <button class="button-blue comment-like-btn">
                <img src="img/like-white.svg">
                <span></span>
            </button>
        </div>
        `;

        // maquetar comentario en el contenedor de comentarios
        commentContainer.appendChild(comment);

        // añadir funcionalidad al botón de comentar
        let button = comment.querySelector('.comment-controls .comment-like-btn');
        updateComment(params.id, params.is_voted);
        
        button.addEventListener('click', async (e) => {
            // se alterna entre votado y no votado
            voted = await getCommentData(params.id, 'toggleCommentVote');
            // se actualiza el comentario
            await updateComment(params.id, voted.is_voted);
        });
    }

    async function addComments() {
        // busca y añade los comentarios a la página
        let comments = await getLastCommentsData();
        console.log(comments);
        comments.forEach(comment => {
            // maquetar cada comentario
            mockupComment(comment);
        });
        // actualizar el offset para la siguiente pedida de datos
        offsets.comments += comments.length;
    }
   

    /*
        --------------------- INICIO ----------------------
    */

    // Entrada del programa
    updateBookmarkData();
    addComments();
});