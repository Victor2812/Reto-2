<?php

$idPost = intval($_GET['post']);
$post = PostRepository::getPostById($idPost);

if (!$post) {
    redirect('/index.php');
}

?>

<div class="content">
    <?php include "partials/sidebar_left.php"; ?>
    <main>

        <div class="box-post">
            <div class="flex-container-column">
                <p><a href="#" class="category"><?php echo $post->getCategory()->getName(); ?></a></p>
                <h2><?php echo $post->getTitle(); ?></h2>
                <p class="data">
                    <?php echo $post->getCreationDate()->format('Y-m-d H:i:s');?> por 
                    <a href="#"><?php echo $post->getAuthor()->getUsername();?></a> | 
                    <?php echo CommentRepository::getPostCommentNum($post); ?> comentarios 
                </p>
                <ul class="tags-list">
                    <?php
                        $tags = $post->getTags();
                        foreach ($tags as $tag) {
                            ?>
                            <li><a href="#" class="tag"><?php echo $tag->getName()?></a></li>
                            <?php
                        }
                    ?>
                </ul>
                <div class="flex-container">
                    <button class="button-blue">
                        <?php include "img/favourite-stroke.svg"; ?>
                        Añadir a favoritos
                    </button>
                    <p>
                        <?php //contadorfavoritos ?> favoritos
                    </p>
                </div>
                <div class="text">
                    <?php echo $post->getText();?>
                </div>
            </div>
        </div>

        <h3><?php echo CommentRepository::getPostCommentNum($post); ?> comentarios</h3>

        <div class="box-comment">

        </div>
        
        <div>
            <form action="<?php echo current_file(); ?>" method="POST" enctype="multipart/form-data">
                <div class="flex-container">
                    <img src="img/user-default-image.svg" class="author-icon">
                    <p>Añade un comentario</p>
                </div>
                <textarea name="text" cols="30" rows="10" placeholder="Escribe aqui" required></textarea>
                <div class="flex-container">
                    <label for="new-comment-upload">
                        <?php include "img/upload.svg"; ?>
                        Añadir adjunto
                    </label>
                    <input type="file" id="new-comment-upload" name="upload">
                    <input class="button-blue" type="submit" value="Publicar comentario">
                </div>
            </form>
        </div>
    </main>
    <?php include "partials/sidebar_right.php"; ?>
</div>
<script src="js/comments.js"></script>

mierda mierda mierda