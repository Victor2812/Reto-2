<div class="content-new-post">
    <main>
        <div class="new-post">
            <form action="<?php echo current_file(); ?>" class="new-post-form" method="POST" enctype="multipart/form-data">
                <label for="new-post-category">Categoría</label>
                <div class="select-category">
                    <select name="category" id="new-post-category">
                        <?php 
                            $categorias = CategoryRepository::getAllCategories();

                            foreach($categorias as $cat) {
                                echo '<option value="' . $cat->getId() . '">' . $cat->getName() . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <label for="new-post-title">Título *</label>
                <input type="text" name="title" id="new-post-title" required>
                <label for="new-post-tags">Tags</label>
                <input type="text" name="tags" id="new-post-tags" placeholder="tag1, tag2 ...">
                <textarea name="text" cols="30" rows="10" placeholder="Escribe aqui" required></textarea>
                <div class="button-box">
                    <label for="new-post-upload">
                        <?php include "img/upload.svg"; ?>
                        Añadir adjunto
                    </label>
                    <input type="file" id="new-post-upload" name="upload">
                    <input class="button-blue" type="submit" value="Publicar">
                </div>
            </form>
        </div>
    </main>
    <?php include "partials/sidebar_right.php"; ?>
</div>
