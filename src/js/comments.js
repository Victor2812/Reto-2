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
        <div class="flex-container buttons">
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
    <div class="add-comment-form"></div>
    <a class="load-subcomments" href="#">Cargar más subcomentarios</a>
    <div class="subcomments"></div>
    `;

    return comment;
}

// Maquetación adicional para los comentarios padre
function mockupParentComment(comment, data, offsets, container) {
    // Contenedor del formulario de añadir subcomentario
    let formContainer = comment.querySelector('div.add-comment-form');

    // Contenedor de subcomentarios
    let subcommentsContainer = comment.querySelector('div.subcomments');

    // Botón de añadir subcomentario
    let addSubcommentBtn = document.createElement('button');
    addSubcommentBtn.className = 'button-white comment-subcomment-btn';
    addSubcommentBtn.innerText = "Comentar";

    // Funcionalidad del comentario de añadir subcomentarios
    addSubcommentBtn.addEventListener('click', async (e) => {
        let form = mockupNewCommentForm(formContainer);

        // si el comentario es hijo de otro comentario, el id será el comentario padre
        id = data.parent_comment || data.id;

        // si el form no se ha destruido, añadir funcionalidad
        form?.addEventListener('submit', async (e) => {
            await uploadCommentFormSubmit(e, 'comment', id, container, offsets);
        } );
    });

    // Botón de cargar subcomentarios
    let loadSubcommentsButton = comment.querySelector('.load-subcomments')
    if (data.subcomments_num > 0) {
        loadSubcommentsButton.classList.add('shown');
    }
    // funcionalidad
    loadSubcommentsButton.addEventListener('click', async (e) => {
        e.preventDefault();

        loadMoreCommentSubcomments(data.id, offsets, subcommentsContainer);
    });

    // maquetar botón de cargar subcomentarios
    comment.appendChild(loadSubcommentsButton);

    // maquetar botón al principio de los botones
    comment.querySelector('.buttons')?.prepend(addSubcommentBtn);
}

// Maquetar un comentario completo
function mockupSingleComment(data, addToTop, container, offsets) {
    let comment = mockupBasicComment(data);

    // comprobar que el comentario no sea subcomentario
    if (data.parent_post) {
        mockupParentComment(comment, data, offsets, container);
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
        mockupSingleComment(c, false, container, offsets);
    });
}

/*
    --------------------- FUNCIONES ----------------------
*/

// Actualizar un comentario de un contenedor
async function updateComment(id, container) {
    data = await getCommentData(id, 'getCommentData');

    let comment = container.querySelector(`.comment[data-comment='${id}']`);

    let button = comment.querySelector(`.comment-like-btn`);
    if (data.is_voted) {
        setButtonText(button, 'Ya no me gusta');
    } else {
        setButtonText(button, 'Me gusta');
    }

    let likes = comment.querySelector(`.likes`);
    likes.innerText = data.votes;
    
    let loadSubcommentsButton = comment.querySelector('.load-subcomments');
    if (data.subcomments_num > 0 && !loadSubcommentsButton.classList.contains('shown')) {
        loadSubcommentsButton.classList.add('shown');
    }
}

// Cargar y maquetar más comentarios de un post
async function loadMorePostComments(offsets, container, postId) {
    // busca y añade los comentarios a la página
    let comments = await getLastCommentsData('post', postId, offsets.comments);

    if (comments.error) {
        console.error(comments.error);
    } else {
        mockupComments(comments, container, offsets);
        // actualizar el offset para la siguiente pedida de datos
        offsets.comments += comments.length;
    }
}

// Cargar y maquetar más subcomentarios de un comentario
async function loadMoreCommentSubcomments(commentId, offsets, container) {
    if (!offsets?.subcomments[commentId]) {
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
async function uploadCommentFormSubmit(e, type, id, container, offsets) {
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
            mockupSingleComment(r, true, container, offsets);
        } 
        
        else if (r.parent_comment) {
            // el subcomentario no se maqueta para evitar duplicados cuando se pulsa el botón de cargar más comentarios
            /*if (container) {
                // maquetar subcomentario al final
                mockupSingleComment(r, false, container);
            }*/

            // actualizar el comentario padre
            updateComment(r.parent_comment, container);
        }
    }
}