<?php

$idPost = intval($_GET['post']);
$post = PostRepository::getPostById($idPost);

if (!$post) {
    redirect('/index.php');
}

?>

<div class="content-new-post">
    <aside class="sidebar-left">

    </aside>
    <main>

        <div class="box-post">
            <div class="post-head">
                <p><a href="#" class="category"><?php echo $post->getCategory()->getName(); ?></a></p>
                <h2><?php echo $post->getTitle(); ?></h2>
                <p>
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
                <div class="box-add-favourites">
                    <button class="button-blue">
                        <?php include "img/favourite-stroke.svg"; ?>
                        Añadir a favoritos
                    </button>
                    <p>
                        <?php //contadorfavoritos ?> favoritos
                    </p>
                </div>
            </div>
            <div class="post-body">
                <?php echo $post->getText();?>
            </div>
        </div>

        <h3><?php echo CommentRepository::getPostCommentNum($post); ?> comentarios</h3>

        <div class="box-comment">

        </div>
        
        <div class="new-comment">
            <form action="<?php echo current_file(); ?>" class="new-comment-form" method="POST" enctype="multipart/form-data">
                <div class="new-comment-author">
                    <img src="img/user-default-image.svg" class="post-author-icon">
                    <p>Añade un comentario</p>
                </div>
                <textarea name="text" cols="30" rows="10" placeholder="Escribe aqui" required></textarea>
                <div class="button-box">
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
    <aside class="sidebar-right">

    </aside>
</div>
<script src="js/comments.js"></script>