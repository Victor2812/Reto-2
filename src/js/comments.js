/*
    --------------------- MOCKUPS ----------------------
*/
   
function mockupNewCommentForm(container) {
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

// Maquetar base del comentario
function mockupBasicComment(data) {
    let comment = document.createElement('div');
    comment.classList.add('comment');
    comment.setAttribute('data-comment', data.id); // establecer el ID del comentario
    
    if (data.parent_comment) {
        comment.setAttribute('data-parent', data.parent_comment); // establecer el ID del comentario padre
    }

    // se maqueta el contenido directamente dentro de la raiz del comentario
    comment.innerHTML = `
    <div class="flex-container">
        <img src="img/user-default-image.svg" class="author-icon">
        <div>
            <p><a href="/user.php?user=${data.author_id}">${data.author}</a></p>
            <p class="data">${data.date}</p>
        </div>
    </div>
    <div>
        <p>${data.text}</p>
    </div>
    <div class="flex-container files">
    </div>
    <div class="flex-container buttons">
        <button class="button-blue comment-like-btn">
            <span>Me gusta</span>
        </button>
        <p><span class="likes">${data.votes}</span> likes</p>
    </div>
    `;

    return comment;
}

// Maquetación adicional para los comentarios padre
function mockupParentComment(comment, data, offsets) {
    // Contenedor del formulario de añadir subcomentario
    let formContainer = document.createElement('div');
    formContainer.className = 'add-comment-form';

    // Contenedor de subcomentarios
    let subcommentsContainer = document.createElement('div');
    subcommentsContainer.className = 'subcomments';

    // Botón de añadir subcomentario
    let addSubcommentBtn = document.createElement('button');
    addSubcommentBtn.className = 'button-white comment-subcomment-btn';
    addSubcommentBtn.innerText = "Añadir comentario";

    // Funcionalidad del comentario de añadir subcomentarios
    addSubcommentBtn.addEventListener('click', async (e) => {
        let form = mockupNewCommentForm(formContainer);

        // si el comentario es hijo de otro comentario, el id será el comentario padre
        id = data.parent_comment || data.id;

        // si el form no se ha destruido, añadir funcionalidad
        form?.addEventListener('submit', async (e) => await uploadCommentFormSubmit(e, 'comment', id, container));
    });

    // maquetar botón de cargar subcomentarios
    if (data.subcomments_num > 0) {
        // Botón de cargar subcomentarios
        let loadSubcommentsButton = document.createElement('a');
        loadSubcommentsButton.href = '#';
        loadSubcommentsButton.className = 'load-subcomments';
        loadSubcommentsButton.innerText = 'Cargar más subcomentarios';

        // maqueta dentro del comentario
        comment.appendChild(loadSubcommentsButton);

        // funcionalidad
        loadSubcommentsButton.addEventListener('click', async (e) => {
            e.preventDefault();

            loadMoreCommentSubcomments(data.id, offsets, subcommentsContainer);
        });
    }

    // maquetar contenedores
    comment.appendChild(formContainer);
    comment.appendChild(subcommentsContainer);

    // maquetar botón al principio de los botones
    comment.querySelector('.buttons')?.prepend(addSubcommentBtn);
}

// Maquetar un comentario completo
function mockupComment(data, addToTop, container, offsets) {
    let comment = mockupBasicComment(data);

    // comprobar que el comentario no sea subcomentario
    if (data.parent_post) {
        mockupParentComment(comment, data, offsets)
    }

    // comprobar si el comentario tiene archivos
    if (data.file) {
        let container = comment.querySelector('.files');
        let a = document.createElement('a');
        a.href = "/download.php?file=" + data.file;
        a.className = 'file';
        a.innerText = data.file_name;
        a.target = '_blank';
        container.appendChild(a);
    }

    // funcionalidad del botón de "me gusta"
    let likeBtn = comment.querySelector('.comment-like-btn');
    likeBtn.addEventListener('click', async (e) => {
        // se alterna entre votado y no votado
        await getCommentData(data.id, 'toggleCommentVote');
        // se actualiza el comentario
        await updateComment(data.id, container);
    });

    if (addToTop) {
        container.prepend(comment);
    } else {
        container.appendChild(comment);
    }

    // actualizar el comentario nada más maquetarlo
    updateComment(data.id, container);
}

// Maquetar los comentarios a partir de una lista de datos
function mockupComments(data, container, offsets) {
    data.forEach(c => {
        mockupComment(c, false, container, offsets);
    });
}

/*
    --------------------- FUNCIONES ----------------------
*/

// Actualizar un comentario de un contenedor
async function updateComment(id, container) {
    data = await getCommentData(id, 'getCommentData');

    // si no se lo pasamos por parámetro se lo pregunt a la API
    /*if (is_voted === null) {
        is_voted = data.is_voted || false;
    }*/

    let button = container.querySelector(`.comment[data-comment='${id}'] .comment-like-btn`);
    let likes = container.querySelector(`.comment[data-comment='${id}'] .likes`);

    if (data.is_voted) {
        setButtonText(button, 'Ya no me gusta');
    } else {
        setButtonText(button, 'Me gusta');
    }

    likes.innerText = data.votes;
}

// Cargar y maquetar más comentarios de un post
async function loadMorePostComments(offsets, container, postId) {
    // busca y añade los comentarios a la página
    let comments = await getLastCommentsData('post', postId, offsets.comments);

    if (comments.error) {
        console.log(comments.error);
    } else {
        mockupComments(comments, container, offsets);
        // actualizar el offset para la siguiente pedida de datos
        offsets.comments += comments.length;
    }
}

// Cargar y maquetar más subcomentarios de un comentario
async function loadMoreCommentSubcomments(commentId, offsets, container) {
    if (!offsets.subcomments[commentId]) {
        offsets.subcomments[commentId] = 0;
    }

    // cargar nuevos subcomentarios desde la API
    let subcomments = await getLastCommentsData('comment', commentId, offsets.subcomments[commentId]);

    if (subcomments.error) {
        console.error(subcomments.error);
        return 0;
    } else {
        mockupComments(subcomments, container);
        // actualizar el offset
        offsets.subcomments[commentId] += subcomments.length;
    }
}

// Procesar la información de un formulario de comentarios
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

// Procesar respuesta de la subida de un nuevo comentario
async function uploadCommentFormSubmit(e, type, id, container) {
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
            mockupComment(r, true, container);
        } else if (r.parent_comment) {
            // buscar contenedor de subcomentarios del comentario
            if (container) {
                // maquetar subcomentario al final
                mockupComment(r, false, container);
            }
        }
    }
}