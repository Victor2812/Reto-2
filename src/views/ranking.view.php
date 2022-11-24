<?php
    $list = UserRepository::getUserRanking();
?>

<div class="content noleft">
    <main>
        <div class="ranking-content">
            <h2  class="title">Ranking de Usuarios</h2>
            <div class="grid-container title">
                <p>Posicion</p>
                <p>Imagen</p>
                <p>Usuario</p>
                <p>Puntos</p>
            </div>
            <ol class="ranking">
                <?php for ($i=0; $i < count($list); $i++): ?>
                    <li class="<?php 
                            if ($GLOBALS['session']->getCurrentUser()->getId() == $list[$i]->getId()) {
                                echo 'current';
                            }
                        ?>">
                        <div class="grid-container">
                            <span class="pos"><?php echo $i + 1; ?></span>
                            <img class="author-icon" src="img/user-default-image.svg" alt="Imágen del usuario">
                            <p><a href="user.php?user=<?php echo $list[$i]->getId(); ?>"><?php echo $list[$i]->getUsername(); ?></a></p>
                            <span><?php echo $list[$i]->getPoints(); ?> puntos</span>
                        </div>
                           
                    </li>
                <?php endfor; ?>
            </ol>
        </div>
    </main>

    <?php include 'partials/sidebar_right.php'?>
</div>