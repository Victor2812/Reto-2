/*
    --------------------- SMALL POST ----------------------
*/

function mockupSmallPost(data, container) {
    let post = document.createElement('div');
    post.classList.add('small-post');

    post.innerHTML = `
    <div class="flex-container">
        <img src="img/user-default-image.svg" class="author-icon">
        <div class="flex-container-column">
            <h3><a href="/post.php?post=${data.id}">${data.title}</a></h3>
            <p class="data">por
                <a href="/user.php?user=${data.author_id}">${data.author}</a>
                en <a href="#">${data.category}</a></span>
                <span>${data.date}</span>
            </p>
            <div class="flex-container">
                <span><img src="img/favourite-stroke.svg" class="little-icon"> ${data.favs}</span>
                <span><img  src="img/comment-stroke.svg" class="little-icon"> ${data.comments}</span>
            </div>
        </div>
    </div>`;

    container.appendChild(post);
}

async function loadSmallPosts(offset, container, userId = null) {
    let posts = [];

    // comprobar si se quieren obtener los Posts de un usuario o en general
    if (userId) {
        posts = await getLastUserPostsData(offset, userId);
    } else {
        posts = await getLastPostsData(offset);
    }

    if (posts.error) {
        console.error(posts.error);
        return 0;
    }

    posts.forEach(data => {
        mockupSmallPost(data, container)
    });

    return posts.length;
}
