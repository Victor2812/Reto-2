<div id="user-banner-container">
    <div id="user-banner">
        <div class="user-info">
            <img src="img/user-default-image.svg" alt="Imágen del usuario">
            <div class="flex-container-column">
                <h2><?php echo $GLOBALS['session']->getCurrentUser()->getUsername() ?></h2>
                <p class="data">
                    <?php 
                        $date = $GLOBALS['session']->getCurrentUser()->getCreationDate();
                        echo 'Te uniste el día ' . $date->format('j \d\e F \d\e\l Y');
                    ?>
                </p>
                <a href="/user.php">Mis posts</a>
                <div id="user-editable">
                </div>
            </div>
        </div>
        <ul class="flex-container-column">
            <li><a href="/logout.php">Cerrar sesión</a></li>
            <li><a href="" id="useredit">Editar perfil</a></li>
        </ul>
    </div>
</div>
<script src="js/views/partials/userbanner.js"></script>
