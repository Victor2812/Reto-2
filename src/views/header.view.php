<header>
    <a href="/index.php"><img class="logo" src="img/aerbide-logo.svg" alt="logo-aerbide"></a>
    <div class="navigation">
        <nav>
            <ul>
                <li><a class="selected" href="#">Recientes</a></li>
                <li><a class="unselected" href="#">Más comentados</a></li>
                <li><a class="unselected" href="#">Más valorados</a></li>
            </ul>
        </nav>
        <div class="rightnav">
            <div class="search">
                <form action="">
                    <input type="text" placeholder="Buscar ej: consulta #tag">
                </form>
            </div>
            <div class="user">
                <button id="notifbtn">
                    <?php include "img/notification-white-stroke.svg"; ?>
                </button><button id="userbtn">
                    <?php include "img/user-default-image.svg"; ?>
                </button>
            </div>
        </div>
    </div>
</header>
<?php include "partials/user_banner.php"; ?>
<script src="js/userbanner.js"></script>