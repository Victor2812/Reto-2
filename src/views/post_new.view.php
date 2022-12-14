
<div class="content noleft">
    <main>
        <div>
            <form action="<?php echo current_file(); ?>" method="POST" enctype="multipart/form-data">
                <div class="errors">
                    <?php
                    
                        if (isset($GLOBALS['form_errors'])) {
                            foreach($GLOBALS['form_errors'] as $error) {
                                echo "<p>$error</p>";
                            }
                        }
                    
                    ?>
                </div>

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
                <div class="flex-container buttons">
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
