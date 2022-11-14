<div class="content-new-post">
    <main>
        <div class="new-post">
            <form action="" class="new-post-form">
                <label for="new-post-category">Categoría</label>
                <div class="select-category">
                    <select name="new-post-category" id="new-post-category">
                        <option value="logisitca">Logística</option>
                        <option value="produccion">Producción</option>
                        <option value="ingenieria">Ingeniería</option>
                        <option value="calidad">Calidad</option>
                        <option value="financiero">Financiero</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>
                <label for="new-post-title">Título *</label>
                <input type="text" name="new-post-title" id="new-post-title" required>
                <label for="new-post-tags">Tags</label>
                <input type="text" name="new-post-tags" id="new-post-tags" placeholder="tag1, tag2 ...">
                <textarea name="new-post-text" id="new-post-text" cols="30" rows="10" placeholder="Escribe aqui"></textarea>
                <div class="new-post-buttons">
                    <label for="new-post-upload">
                        <?php include "img/upload.svg"; ?>
                        Añadir adjunto
                    </label>
                    <input type="file" id="new-post-upload" name="new-post-upload">
                    <input class="button-blue" type="submit" value="Publicar">
                </div>
            </form>
        </div>
    </main>
    <aside class="sidebar-right">

    </aside>
</div>
