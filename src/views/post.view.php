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
                    <button class="button-blue" id="postfavbtn">
                        <?php include "img/favourite-stroke.svg"; ?>
                        <span></span>
                    </button>
                    <p>
                        <span id="postbookmarkcount"></span> favoritos
                    </p>
                </div>

                <div class="text">
                    <?php echo $post->getText();?>
                </div>

                <?php if ($post->getFile()): ?>
                    <div class="flex-container files">
                        <a class="file" href="/download.php?file=<? echo $post->getFile()->getId(); ?>" target="_blank"><?php echo $post->getFile()->getName(); ?></a>
                    </div>
                <?php endif; ?>

                <div class="flex-container">
                    <button class="button-blue" id="postcommentbtn">
                        <?php include "img/comment-stroke.svg"; ?>
                        Comentar
                    </button>
                </div>
            </div>
            <div class="add-comment-form"></div>
        </div>

        <h3><?php echo CommentRepository::getPostCommentNum($post); ?> comentarios</h3>

        <div class="box-comment">
        </div>
    </main>
    <?php include "partials/sidebar_right.php"; ?>
</div>
<script src="js/postview.js"></script>
