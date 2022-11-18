const LAST_POST_URL = '/post_api.php';

window.addEventListener('load', () => {
    let cantidadCargada = 0;

    async function getUserPosts() {
        let res = await fetch(LAST_POST_URL + `?method=userPosts&offset=${cantidadCargada}`);
        if (res.ok) {
            try {
                return res.json();
            } catch {}
        }
        return [];
    }

    function mockupSmallPost(id, title, user, userid, category, date, favs, comments) {
        let post = document.createElement('div');
        post.classList.add('small-post');

        post.innerHTML = `
        <div class="flex-container">
            <img src="img/user-default-image.svg" class="author-icon">
            <div class="flex-container-column">
                <h3><a href="/post.php?post=${id}">${title}</a></h3>
                <p class="data">por
                    <a href="/user.php?user=${userid}">${user}</a>
                    en <a href="#">${category}</a></span>
                    <span>${date}</span>
                </p>
                <div class="flex-container">
                    <span><img src="img/favourite-stroke.svg" class="little-icon"> ${favs}</span>
                    <span><img  src="img/comment-stroke.svg" class="little-icon"> ${comments}</span>
                </div>
            </div>
        </div>`;

        let content = document.querySelector('main .post-container');
        content.appendChild(post);
    }

    async function addUserPosts() {
        let datos = await getUserPosts();

        datos.forEach(post => {
            mockupSmallPost(post.id, post.title, post.author, post.author_id, post.category, post.date, post.favs, post.comments);
            cantidadCargada += 1;
        });
    }

    //primera ejecucion
    addUserPosts();
});