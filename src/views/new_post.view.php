<div class="content-new-post">
    <main>
        <div class="new-post">
            <form action="" class="new-post-form">
                <label for="new-post-category">Categoría</label>
                <select name="new-post-category" id="">
                    <option value="Category 1">Category 1</option>
                    <option value="Category 2">Category 2</option>
                    <option value="Category 3">Category 3</option>
                    <option value="Category 4">Category 4</option>
                    <option value="Category 5">Category 5</option>
                </select>
                <label for="new-post-title">Título *</label>
                <input type="text" name="new-post-title" id="" required>
                <textarea name="new-post-text" id="" cols="30" rows="10" placeholder="Escribe aqui"></textarea>
                <label for="new-post-upload">
                    <?php include "img/upload.svg"; ?>
                    Añadir adjunto
                </label>
                <input type="file" name="new-post-upload" id="">
                <input class="button-blue" type="submit" value="Publicar">
            </form>
        </div>
    </main>
    <aside class="sidebar-right">

    </aside>
</div>
