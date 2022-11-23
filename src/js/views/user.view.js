window.addEventListener('load', async () => {
    // offset para la API
    let offsets = {
        small_posts: 0
    };

    // contenedor de small-posts
    let container = document.querySelector('main .post-container');
    let userId = container.getAttribute('data-user');
    let followBtn = document.querySelector('#userfollowbtn');

    async function loadMorePosts() {
        offsets.small_posts += await loadSmallPosts(offsets.small_posts, container, userId);
    }

    async function updateFollowButton() {
        let data = await checkFollowingUser(userId);
        if (!data.error) {
            setButtonText(followBtn, data.following
                ? 'Dejar de seguir'
                : 'Seguir');
        } else {
            console.error(data.error);
        }
    }

    followBtn.addEventListener('click', async () => {
        let data = await toggleFollowingUser(userId);
        if (!data.error) {
            await updateFollowButton();
        } else {
            console.error(data.error);
        }
    });

    // detectar que el scroll ha llegado hasta el final
    window.addEventListener('scroll', async () => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            await loadMorePosts();
        }
    })

    // primera carga de posts
    await loadMorePosts();
    await updateFollowButton();
});