window.addEventListener('load', async () => {
    const API_URL = '/post_api.php';

    let cantidadCargada = 0;

    function getCurrentPostId() {
        let queryString = location.search;
        let params = new URLSearchParams(queryString);
        return parseInt(params.get("post"));
    }

    async function getLastCommentData() {
        let res = await fetch(API_URL + `?method=comments&post=${getCurrentPostId()}&offset=${cantidadCargada}`);
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
        <div class="flex-container">
            <img src="img/user-default-image.svg" class="author-icon">
            <div>
                <p><a href="${author_url}">${author}</a></p>
                <p class="data">${creation_date}</p>
            </div>
        </div>
        <div>
            <p>${text}</p>
        </div>
        <div class="flex-container">
            <button class="button-white">
                Añadir comentario
            </button>
            <button  class="button-blue">
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