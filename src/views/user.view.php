<?php

    $user = $GLOBALS['user'];

?>

<div class="content">
    <?php include 'partials/sidebar_left.php' ?>

    <main>
        <div class="user-panel">
            <div class="flex-container">
                <img src="img/user-default-image.svg" alt="" class="author-icon-big">
                <div class="user-data">
                    <h2><?php echo $user->getUsername() ?></h2>
                    <div>
                        <p><?php echo $user->getName() . ' ' . $user->getSurname(); ?></p>
                        <?php
                            if ($job = $user->getJob()) {
                                echo '<p>' . $job . '</p>';
                            }
                        ?>
                        <p class="user-date">
                            <?php 
                                $date = $user->getCreationDate();
                                echo 'Se unió el día ' . $date->format('j \d\e F \d\e\l Y');
                            ?>
                        </p>
                    </div>
                    <div class="flex-container">
                        <button class="button-blue" id="userfollowbtn"><span></span></button>
                        <p id="folllowdata"></p>
                    </div>
                </div>
            </div>

            <div class="points">
                <p><?php echo $user->getPoints() ?></p>
                <h3>puntos</h3>
            </div>
        </div>

        <div class="post-container" data-user="<?php echo $user->getId(); ?>">
        </div>
    </main>

    <?php include 'partials/sidebar_right.php'?>
</div>
<script src="js/views/user.view.js"></script>