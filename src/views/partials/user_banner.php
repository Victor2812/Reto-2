<div id="user-banner">
    <div class="user-info">
        <img src="img/user-default-image.svg" alt="">
        <div class="user-data">
            <h2><?php echo $GLOBALS['session']->getCurrentUser()->getUsername(); ?></h2>
            <p>
                <?php echo $GLOBALS['session']->getCurrentUser()->getName(); ?> 
                <?php echo $GLOBALS['session']->getCurrentUser()->getSurname(); ?> 
            </p>
            <p><strong>
                <?php 
                    if ($dep = $GLOBALS['session']->getCurrentUser()->getJob()) {
                        echo $dep;
                    } else {
                        echo 'Sin departamento';
                    }
                ?>
            </strong></p>
            <p class="user-date">
                <?php 
                    $date = $GLOBALS['session']->getCurrentUser()->getCreationDate();
                    echo 'Te uniste el día ' . $date->format('j \d\e F \d\e\l Y');
                ?>
            </p>
        </div>
    </div>

    <ul class="user-actions">
        <li><a href="/logout.php">Cerrar sesión</a></a>
        <li><a href="#">Editar perfil</a></a>
    </ul>
</div>