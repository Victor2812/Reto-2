window.addEventListener('load', async (e) => {
    const API_URL = '/post_api.php';

    // Variables
    let params = new URLSearchParams(window.location.search);
    let currentPostId = params.get('post');

    // Elementos
    let postBookmarkBtn = document.querySelector('#postfavbtn');
    let postBookmarkCount = document.querySelector('#postbookmarkcount');

    // funciones
    async function getBookmarkData(func) {
        let r = await fetch(API_URL + '?method=' + func + '&post=' + currentPostId);
        if (r.ok) {
            return r.json();
        }
        return {error: 'No es posible obtener la información'};
    }

    // Funcionalidad del botón de favoritos
    function setBookmarkButtonText(text) {
        let span = postBookmarkBtn.querySelector('span');
        span.innerText = text;
    }

    async function updateBookmarkData() {
        let data = await getBookmarkData('getBookmark');

        if (data.error) {
            console.error(data.error);
        } else {
            postBookmarkCount.innerText = data.count;
            if (data.bookmarked) {
                setBookmarkButtonText('Quitar de favoritos');
            } else {
                setBookmarkButtonText('Añadir a favoritos');
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

    updateBookmarkData();
});