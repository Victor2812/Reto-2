const LAST_POST_URL = '/post_api.php';

window.addEventListener('load', async () => {
    let cantidadCargada = 0;

    function getCurrentPostId() {
        let queryString = location.search;
        let params = new URLSearchParams(queryString);
        return parseInt(params.get("post"));
    }

    async function getLastCommentData() {
        let res = await fetch(LAST_POST_URL + `?method=comments&post=${getCurrentPostId()}&offset=${cantidadCargada}`);
        if (res.ok) {
            try {
                return res.json();
            } catch {}
        }
        return [];
    }

    function mockupComment(author, author_url, creation_date, text, favs, subcomment_num) {
        let comment = document.createElement('div');
        comment.classList.add('comment');

        comment.innerHTML = `
        <div class="comment-head">
            <img src="img/user-default-image.svg" class="author-image">
            <div class="comment-info">
                <p><a class="author" href="${author_url}">${author}</a></p>
                <p class="comment-date">${creation_date}</p>
            </div>
        </div>
        <div class="comment-body">
            <p>${text}</p>
        </div>
        <div class="comment-controls">
            <button class="button-white">
                <img src="img/comment-stroke.svg">
                Añadir comentario
            </button>
            <button  class="button-blue">
                <img src="img/like-white.svg">
                Me gusta
            </button>
        </div>`;

        let content = document.querySelector('main .box-comment');
        content.appendChild(comment);
    }


    async function addComment() {
        let datos = await getLastCommentData();

        datos.forEach(comment => {
            mockupComment( comment.author, comment.author_url, comment.date, comment.text, comment.favs, comment.subcomment_num);
            cantidadCargada += 1;
        });
    }

    //primera ejecucion
    addComment();


});