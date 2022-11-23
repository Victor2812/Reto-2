window.addEventListener('load', async () => {
    // offset para la API
    let offsets = {
        small_posts: 0
    };

    // contenedor de small-posts
    let container = document.querySelector('main .post-container');

    async function loadMorePosts() {
        offsets.small_posts += await loadSmallPosts(offsets.small_posts, container);
    }

    // detectar que el scroll ha llegado hasta el final
    window.addEventListener('scroll', async () => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            await loadMorePosts();
        }
    })

    // primera carga de posts
    await loadMorePosts();
});