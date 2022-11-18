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

        post.innerHTML = `<div class="post-head">
        <img src="img/user-default-image.svg" class="post-author-icon">
        <div class="post-info">
            <h3 class="post-title"><a href="/post.php?post=${id}">${title}</a></h3>
            <p class="post-data">por
                <a class="post-author" href="/user.php?user=${userid}">${user}</a>
                en <a class="post-category" href="#">${category}</a></span>
                <span class="post-date">${date}</span>
            </p>
            <div class="post-stats">
                <span class="post-likes"><img src="img/favourite-stroke.svg"> ${favs}</span>
                <span class="post-comments"><img  src="img/comment-stroke.svg"> ${comments}</span>
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