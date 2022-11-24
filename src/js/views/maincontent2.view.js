window.addEventListener('load', async () => {
    const DB_NAME = 'search-data';

    // obtener los filtros
    let filterList = [];
    let categories = [];
    let tags = [];

    // contenedor de small-posts
    let container = document.querySelector('main .post-container');
    let searchInput = document.querySelector('#searchtext');

    // obtener lista de filtros
    document.querySelectorAll('header .navigation nav ul a').forEach((element) => {
        filterList.push(element);
        element.addEventListener('click', (e) => {
            setCurrentFilter(e.target.getAttribute('data-name'));
            updateFilter();
        })
    });

    // obtener lista de categorias
    document.querySelectorAll('.sidebar-left button.aside-category').forEach((element) => {
        categories.push(element);
        element.addEventListener('click', (e) => {
            for (cat of categories) {
                if (cat === e.target && !cat.classList.contains('selected')) {
                    cat.classList.add('selected');
                } else {
                    cat.classList.remove('selected');
                }
            }
            updateFilter();
        });
    });

    // obtener lista de tags
    document.querySelectorAll('.sidebar-left button.tag').forEach((element) => {
        tags.push(element);
        element.addEventListener('click', (e) => {
            for (tag of tags) {
                if (tag === e.target && !tag.classList.contains('selected')) {
                    tag.classList.add('selected');
                } else {
                    tag.classList.remove('selected');
                }
            }
            updateFilter();
        });
    });

    searchInput.addEventListener('keydown', (e) => {
        if (e.key == 'Enter') {
            e.preventDefault();
            updateFilter();
        }
    });

    function getCurrentFilter() {
        for (let element of filterList) {
            let name = element.getAttribute('data-name');
            if (element.classList.contains('selected')) {
                return name;
            }
        }
        return undefined;
    }

    function setCurrentFilter(name) {
        for (let element of filterList) {
            let eName = element.getAttribute('data-name');
            element.className = eName === name
                ? 'selected'
                : 'unselected';
        }
    }

    function getCategory() {
        for (cat of categories) {
            if (cat.classList.contains('selected')) {
                return cat;
            }
        }
        return undefined;
    }

    function getTag() {
        for (let tag of tags) {
            if (tag.classList.contains('selected')) {
                return tag;
            }
        }
        return undefined;
    }

    async function loadMorePosts(filterName, offset, onsuccess) {
        let data = await getLastPostsData(offset, filterName);
        if (!data.error) {
            // Guardar los posts
            let transaction = database.transaction("posts", "readwrite");
            let storage = transaction.objectStore('posts');

            let postIDs = [];
            for (let post of data) {
                storage.add(post);
                postIDs.push(post.id);
            }

            transaction.commit();

            // Actualiar el offset del filtro, reutilizando nombres de variable
            getFromDatabase('filters', 'readonly', filterName, (e) => {
                let filter = e.target.result;
                // relacionar posts cargados con el filtro
                filter.posts = [...new Set([...filter.posts ,...data.map((p) => p.id)])];
                // actualizar offset
                filter.offset = filter.posts.length;

                // actualizar filtro en IndexedDB
                let transaction = database.transaction("filters", "readwrite");
                let storage = transaction.objectStore('filters');
                storage.put(filter);
                transaction.commit();

                // llamar al callback
                onsuccess(e);
            });
        } else {
            console.error(data.error);
        }
    }

    function getPosts(filterName, category, tag, strings, loadMore = false, reload = true) {
        getFromDatabase('filters', 'readonly', filterName, async (e) => {
            let {posts, offset} = e.target.result;

            if ((posts.length == 0 && reload) || loadMore) {
                // cargar más posts
                await loadMorePosts(filterName, offset, (e) => {
                    // maquetar los posts
                    getPosts(filterName, category, tag, strings, reload = false);
                });
                return;
            }

            // limpiar posts mostrados
            container.innerHTML = '';

            // obtener los posts necesarios con una única transacción
            let transaction = database.transaction("posts", "readonly");
            let storage = transaction.objectStore('posts');
            for (let postId of posts) {
                storage.get(postId).onsuccess = (e) => {
                    let post = e.target.result;

                    // si filtramos por categoría y/o tag, aplicar los filtros
                    if ((category && post.category != category) ||
                        (tag && !post.tags.includes(tag))) {
                            return;
                        }

                    // comprobar textos en los títulos
                    let valid = false;
                    for (let i = 0; i < strings?.length && !valid; i++) {
                        if (post.title.toLowerCase().includes(strings[i].toLowerCase())) {
                            valid = true;
                        }
                    }
                    if (strings?.length > 0 && !valid) {
                        return;
                    }
                    
                    // maquetar post
                    mockupSmallPost(post, container);
                };
            }
            transaction.commit();
        });

        return 'a';
    }

    function updateFilter(loadMore = false) {
        // comprobar que haya conexión con la base de datos
        if (!database) {
            console.error('No se ha podido conectar con IndexedDB');
            return;
        }

        let filter = getCurrentFilter();
        let category = getCategory()?.innerText;
        let tag = getTag()?.innerText;

        // obtener strings desde el input
        let strings = [];
        (text = searchInput?.value?.trim()) && (strings = text.split(' '));

        getPosts(filter, category, tag, strings, loadMore = loadMore);
    }

    function getFromDatabase(storeName, mode, key, onsuccess) {
        // abrir transacción y selector de objetos
        let transaction = database.transaction(storeName, mode);
        let store = transaction.objectStore(storeName);

        // hacer búsqueda
        let request = store.get(key);
        request.onerror = (e) => {
            console.error(e.error);
        }
        request.onsuccess = onsuccess;

        // cerrar transacción
        transaction.commit();
    }


    // Eliminar datos (si existen)
    await indexedDB.deleteDatabase(DB_NAME);

    // Crear datos
    let database;
    let openRequest = indexedDB.open(DB_NAME, 1);

    openRequest.onerror = () => {
        console.error(openRequest.error);
    }

    // Creamos las estructuras de datos
    // Solo se ejecuta si la base de datos no existe
    openRequest.onupgradeneeded = async () => {
        let db = openRequest.result;

        // Estructura para los posts cargados
        db.createObjectStore('posts', {
            keyPath: 'id'
        });

        // datos para los filtros principales (recientes, mas votados, etc...)
        db.createObjectStore('filters', {
            keyPath: 'name'
        });
    }

    // Se ejecuta 
    openRequest.onsuccess = () => {
        database = openRequest.result;

        // Insertar datos
        let transaction = database.transaction("filters", "readwrite");
        let filters = transaction.objectStore('filters');
        for (let filter of filterList) {
            filters.add({
                name: filter.getAttribute('data-name'),
                offset: 0,
                posts: []
            });
        }
        // finalizar transacción
        transaction.commit();

        updateFilter();
    }

    // cargar más posts cuando el scroll desciende al fondo
    window.addEventListener('scroll', async () => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            updateFilter(loadMore = true);
        }
    })
});