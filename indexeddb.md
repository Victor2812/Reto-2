IndexedDB en el buscador:
    1. Borrar datos actuales
    2. Cargar los datos mostrados en IndexedDB desde la API
        - Recientes
        - Más comentados
        - Más valorados
        {
            offset,
            [datos de los small-posts]
        }
    3. Aplicar filtros de tags y categorías sobre los datos mostrados
    4. Cuando se haga scroll hacia abajo añadir más datos



POST
    id, title, category, author, author_id, date, favs, comments