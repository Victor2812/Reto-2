window.addEventListener('load', async () => {
    let params = new URLSearchParams(window.location.search);
    let currentPostId = params.get('post');

    // se guarda como objeto ya que queremos poder modificar
    // su valor dentro de las funciones
    let offsets = {
        comments: 0,
        subcomments: {} // id del comentario: offset   ej. 0: 21
    };

    let postBookmarkBtn = document.querySelector('#postfavbtn');
    let postCommentBtn = document.querySelector('#postcommentbtn');

    let postBookmarkCount = document.querySelector('#postbookmarkcount');

    let commentContainer = document.querySelector('main .box-comment');
    
    /*
        --------------------- BOOKMARKS ----------------------
    */

    async function updateBookmarkData() {
        let data = await getBookmarkData('getBookmark', currentPostId);
    
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
        let data = await getBookmarkData('toggleBookmark', currentPostId);
        if (data.error) {
            console.error(data.error);
        } else {
            updateBookmarkData();
        }
    });

    postCommentBtn.addEventListener('click', async (e) => {
        let formContainer = document.querySelector('.box-post .add-comment-form');
        let form = mockupNewCommentForm(formContainer);
        
        // si el form no se ha destruido, añadir funcionalidad
        form?.addEventListener('submit', async (e) => await uploadCommentFormSubmit(e, 'post', currentPostId, commentContainer, offsets));
    });

    /*
        --------------------- COMENTARIOS ----------------------
    */

    async function loadComments() {
        loadMorePostComments(offsets, commentContainer, currentPostId);
    }

    // detectar que el scroll ha llegado hasta el final
    window.addEventListener('scroll', async () => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            await loadComments();
        }
    })

    // Entrada
    updateBookmarkData();
    loadComments();
});