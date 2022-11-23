<?php
    $list = UserRepository::getUserRanking();
?>

<div class="content noleft">
    <main>
        <div class="ranking-content">
            <h2>Ranking de Usuarios</h2>
            <ol class="ranking">
                <?php for ($i=0; $i < count($list); $i++): ?>
                    <li class="<?php 
                            if ($GLOBALS['session']->getCurrentUser()->getId() == $list[$i]->getId()) {
                                echo 'current';
                            }
                        ?>">
                        <div class="flex-container">
                            <span class="pos"><?php echo $i + 1; ?></span>
                            <img class="author-icon" src="img/user-default-image.svg" alt="Imágen del usuario">
                            <h2><a href="user.php?user=<?php echo $list[$i]->getId(); ?>"><?php echo $list[$i]->getUsername(); ?></a></h2>
                            <span><?php echo $list[$i]->getPoints(); ?> puntos</span>
                        </div>
                    </li>
                <?php endfor; ?>
            </ol>
        </div>
    </main>

    <?php include 'partials/sidebar_right.php'?>
</div>