window.addEventListener('load', async (e) => {
    const API_URL = '/post_api.php';

    // Variables
    let params = new URLSearchParams(window.location.search);
    let currentPostId = params.get('post');

    // se guarda como objeto ya que queremos poder modificar
    // su valor dentro de las funciones
    let offsets = {
        comments: 0,
        subcomments: {}, // id del comentario: offset   ej. 0: 21
    };

    // Elementos
    let postBookmarkBtn = document.querySelector('#postfavbtn');
    let postCommentBtn = document.querySelector('#postcommentbtn');

    let postBookmarkCount = document.querySelector('#postbookmarkcount');
    let commentContainer = document.querySelector('main .box-comment');


    /*
        --------------------- FUNCIONES ÚTILES ----------------------
    */

    function setButtonText(button, text) {
        let span = button.querySelector('span');
        span.innerText = text;
    }

    function addErrorToForm(form, error) {
        let errors = form.querySelector('.errors');
        let p = document.createElement('p');
        p.innerText = error;
        // limpiar y añadir error
        errors.innerHTML = '';
        errors.appendChild(p);
    }

    function findCommentSubcommentContainer(commentId) {
        return commentContainer.querySelector(`.comment[data-comment='${commentId}'] .subcomments`);
    }


    /*
        --------------------- API ----------------------
    */

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

    async function getBookmarkData(func) {
        // carga la información de los favoritos en los posts
        let r = await fetch(API_URL + '?method=' + func + '&post=' + currentPostId);
        return processApiResponse(r);
    }

    async function getLastCommentsData(type, id, offset) {
        // carga los comentarios de forma paginada a partir del último comentario cargado
        let r = await fetch(API_URL + `?method=getLastComments&${type}=${id}&offset=${offset}`);
        return processApiResponse(r);
    }

    async function getCommentData(id, func) {
        // carga los comentarios de forma paginada a partir del último comentario cargado
        let r = await fetch(API_URL + `?method=${func}&comment=${id}`);
        return processApiResponse(r);
    }

    async function uploadComment(type, id, data) {
        // siendo type 'post' o 'comment' y el ID será el ID del elemento correspondiente
        let r = await fetch(API_URL + `?method=newComment&${type}=${id}`, {
            method: 'POST',
            body: data
        });
        return processApiResponse(r);
    }


    /*
        --------------------- BOOKMARKS ----------------------
    */

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

    // Funcionalidad del botón de favoritos
    postBookmarkBtn.addEventListener('click', async (e) => {
        let data = await getBookmarkData('toggleBookmark');
        if (data.error) {
            console.error(data.error);
        } else {
            updateBookmarkData();
        }
    });


    /*
        --------------------- COMENTAR ----------------------
    */

    async function processCommentForm(type, id, form) {
        // obtener el input file del form
        let textInput = form.querySelector('textarea[name="text"]');
        let fileInput = form.querySelector('input[name="upload"]');

        let data = new FormData();
        data.append('text', textInput.value);
        
        // si el usuario ha subido un archivo añadir a los datos del formulario
        if (fileInput.files.length > 0) {
            data.append('upload', fileInput.files[0]);
        }

        // subir comentario
        return await uploadComment(type, id, data);
    }

    // funcionalidad de cualquier form de subir comentario
    async function uploadCommentFormSubmit(e, type, id) {
        e.preventDefault();

        let r = await processCommentForm(type, id, e.target);
        
        // comprobar si ha ocurrido cualquier error
        if (r.error) {
            addErrorToForm(e.target, r.error);
        } else {
            // r será la información del nuevo comentario

            // eliminar formulario
            e.target.parentNode.removeChild(e.target);

            // maquetar nuevo comenatio
            if (r.parent_post) {
                // maquetar comentario del post al principio
                mockupComment(r, true);
            } else if (r.parent_comment) {
                // buscar contenedor de subcomentarios del comentario
                let container = findCommentSubcommentContainer(r.parent_comment);
                if (container) {
                    // maquetar subcomentario al final
                    mockupComment(r, false, container);
                }
            }
        }
    }

    // comentar el Post
    postCommentBtn.addEventListener('click', (e) => {
        let formContainer = document.querySelector('.box-post .add-comment-form');
        let form = mockupAddCommentForm(formContainer);
        
        // si el form no se ha destruido, añadir funcionalidad
        form?.addEventListener('submit', async (e) => await uploadCommentFormSubmit(e, 'post', currentPostId));
    });

    // la funcionalidad de comentar un comentario está dentro de la función
    // de maquetar el comentario (mockupComment)

    function mockupAddCommentForm(container) {
        // si el contenedor tiene un formulario limpiarlo
        if (container.querySelector('form')) {
            container.innerHTML = '';
            return undefined;
        }

        let form = document.createElement('form');
        form.action = '#';

        form.innerHTML = `
            <div class="flex-container">
                <img src="img/user-default-image.svg" class="author-icon">
                <p>Añade un comentario</p>
            </div>
            <div class="errors"></div>
            <textarea name="text" cols="30" rows="10" placeholder="Escribe aqui" required></textarea>
            <div class="flex-container">
                <label for="new-comment-upload">
                    <?php /*include "img/upload.svg";*/ ?>
                    Añadir adjunto
                </label>
                <input type="file" id="new-comment-upload" name="upload">
                <input class="button-blue" type="submit" value="Publicar comentario">
            </div>
        `;

        container.appendChild(form);

        return form;
    }


    /*
        --------------------- COMENTARIOS ----------------------
    */

    async function updateComment(id, is_voted = null) {
        data = await getCommentData(id, 'getCommentData');

        // si no se lo pasamos por parámetro se lo pregunt a ala API
        if (is_voted === null) {
            is_voted = data.is_voted || false;
        }

        let button = commentContainer.querySelector(`.comment[data-comment='${id}'] .comment-like-btn`);
        let likes = commentContainer.querySelector(`.comment[data-comment='${id}'] .likes`);

        if (is_voted) {
            setButtonText(button, 'Ya no me gusta');
        } else {
            setButtonText(button, 'Me gusta');
        }

        likes.innerText = data.votes;
    }

    function mockupComment(params, prepend = false, container = commentContainer) {
        let comment = document.createElement('div');
        comment.classList.add('comment');
        comment.setAttribute('data-comment', params.id); // establecer el ID del comentario
        if (params.parent_comment) {
            comment.setAttribute('data-parent', params.parent_comment); // establecer el ID del comentario padre
        }

        // se maqueta el contenido directamente dentro de la raiz del comentario
        comment.innerHTML = `
        <div class="flex-container">
            <img src="img/user-default-image.svg" class="author-icon">
            <div>
                <p><a href="/user.php?user=${params.author_id}">${params.author}</a></p>
                <p class="data">${params.date}</p>
            </div>
        </div>
        <div>
            <p>${params.text}</p>
        </div>
        <div class="flex-container files">
        </div>
        <div class="flex-container buttons">
            <button class="button-blue comment-like-btn">
                <span>Me gusta</span>
            </button>
            <p><span class="likes">${params.votes}</span> likes</p>
        </div>
        `;

        // comprobar si el comentario no es un subcomentario
        if (params.parent_post) {
            // Botón de cargar subcomentarios
            let loadSubcommentsButton = document.createElement('a');
            loadSubcommentsButton.href = '#';
            loadSubcommentsButton.className = 'load-subcomments';
            loadSubcommentsButton.innerText = 'Cargar más subcomentarios';

            // Contenedores
            let formContainer = document.createElement('div');
            formContainer.className = 'add-comment-form';

            let subcommentsContainer = document.createElement('div');
            subcommentsContainer.className = 'subcomments';

            // Botón de añadir comentario
            let b = document.createElement('button');
            b.className = 'button-white comment-subcomment-btn';
            b.innerText = "Añadir comentario";

            b.addEventListener('click', async (e) => {
                let form = mockupAddCommentForm(formContainer);
    
                // si el comentario es hijo de otro comentario, el id será el comentario padre
                id = params.parent_comment || params.id;
    
                // si el form no se ha destruido, añadir funcionalidad
                form?.addEventListener('submit', async (e) => await uploadCommentFormSubmit(e, 'comment', id));
            });

            // maquetar botón de cargar subcomentarios
            if (params.subcomments_num > 0) {
                comment.appendChild(loadSubcommentsButton);

                loadSubcommentsButton.addEventListener('click', async (e) => {
                    e.preventDefault();
                    await loadMoreCommentSubcomments(params.id);
                });
            }

            // maquetar contenedores
            comment.appendChild(formContainer);
            comment.appendChild(subcommentsContainer);

            // maquetar botón
            comment.querySelector('.buttons')?.prepend(b);
        }

        // comprobar si el comentario tiene archivos
        if (params.file) {
            let container = comment.querySelector('.files');
            let a = document.createElement('a');
            a.href = "/downloads.php?file=" + params.file;
            a.className = 'file';
            a.innerText = params.file_name;
            container.appendChild(a);
        }

        // añadir funcionalidad al botón de votar
        let likeBtn = comment.querySelector('.comment-like-btn');
        likeBtn.addEventListener('click', async (e) => {
            // se alterna entre votado y no votado
            voted = await getCommentData(params.id, 'toggleCommentVote');
            // se actualiza el comentario
            await updateComment(params.id, voted.is_voted);
        });

        // maquetar comentario en el contenedor de comentarios
        if (prepend) {
            // añadir comentario al principio
            container.prepend(comment);
        } else {
            // añadir comentario al final
            container.appendChild(comment);
        }

        // actualizar los datos del nuevo comentario
        updateComment(params.id, params.is_voted);
    }


    /*
        --------------------- CARGAR COMENTARIOS ----------------------
    */

    function addCommentDataToContainer(data, container) {
        data.forEach(c => {
            mockupComment(c, false, container);
        });
    }

    async function loadMoreCommentSubcomments(commentId) {
        // añadir offset del comentario actual si no existe
        if (!offsets.subcomments[commentId]) {
            offsets.subcomments[commentId] = 0;
        }

        // cargar nuevos subcomentarios desde la API
        let subcomments = await getLastCommentsData('comment', commentId, offsets.subcomments[commentId]);

        if (subcomments.error) {
            console.log(subcomments.error);
        } else {
            container = findCommentSubcommentContainer(commentId);
            addCommentDataToContainer(subcomments, container);
            // actualizar el offset
            offsets.subcomments[commentId] = subcomments.length;
        }
    }

    async function loadMorePostComments() {
        // busca y añade los comentarios a la página
        let comments = await getLastCommentsData('post', currentPostId, offsets.comments);

        if (comments.error) {
            console.log(comments.error);
        } else {
            addCommentDataToContainer(comments, commentContainer);
            // actualizar el offset para la siguiente pedida de datos
            offsets.comments += comments.length;
        }
    }


    /*
        --------------------- INICIO ----------------------
    */

    // Entrada del programa
    updateBookmarkData();
    loadMorePostComments();
});