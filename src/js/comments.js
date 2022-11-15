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

   // TODO: maquetar comentarios
});