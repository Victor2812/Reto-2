<?php

    $user = $GLOBALS['user'];

?>

<div class="content">
    <?php include 'partials/sidebar_left.php' ?>

    <main>
        <div class="user-panel">
            <div class="flex-container user-pannel">
                <div class="flex-container">
                    <img src="img/user-default-image.svg" alt="" class="author-icon-big">
                    <div class="flex-container-column">
                        <h2><?php echo $user->getUsername() ?></h2>
                        <div>
                            <p><?php echo $user->getName() . ' ' . $user->getSurname(); ?></p>
                            <?php
                                if ($job = $user->getJob()) {
                                    echo '<p>' . $job . '</p>';
                                }
                            ?>
                            <p class="data">
                                <?php 
                                    $date = $user->getCreationDate();
                                    echo 'Se unió el día ' . $date->format('j \d\e F \d\e\l Y');
                                ?>
                            </p>
                        </div>
                        <div class="no-se-como-arreglar-esto-de-una-manera-mejor">
                            <button class="button-blue" id="userfollowbtn">Seguir</button>
                            <p id="folllowdata"></p>
                        </div>
                    </div>
                </div>
                
                <div class="flex-container-column userpoints">
                    <p class="points"><?php echo $user->getPoints() ?></p>
                    <p>puntos</p>
                </div>
            </div>
        </div>

        <div class="post-container" data-user="<?php echo $user->getId(); ?>">
        </div>
    </main>

    <?php include 'partials/sidebar_right.php'?>
</div>
<script src="js/views/user.view.js"></script>