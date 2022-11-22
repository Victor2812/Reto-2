<div id="user-banner-container">
    <div id="user-banner">
        <div class="user-info">
            <img src="img/user-default-image.svg" alt="Imágen del usuario">
            <div class="user-data">
                <h2><?php echo $GLOBALS['session']->getCurrentUser()->getUsername() ?></h2>
                <div id="user-editable">
                </div>
                <p class="user-date">
                    <?php 
                        $date = $GLOBALS['session']->getCurrentUser()->getCreationDate();
                        echo 'Te uniste el día ' . $date->format('j \d\e F \d\e\l Y');
                    ?>
                </p>
            </div>
        </div>
        <ul class="user-actions">
            <li><a href="/logout.php">Cerrar sesión</a></a></li>
            <li><a href="" id="useredit">Editar perfil</button></a></li>
            <li><a href="/user.php">Mis posts</a></li>
        </ul>
    </div>
</div>
<script src="js/views/partials/userbanner.js"></script>