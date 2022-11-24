<?php
    // seleccionar el idioma actual
    $currentLang = isset($_COOKIE[LANGUAGE_COOKIE])
        ? $_COOKIE[LANGUAGE_COOKIE]
        : 'ES';
?>

<header>
    <a href="/index.php"><img class="logo" src="img/aerbide-logo.svg" alt="logo-aerbide"></a>
    <div class="navigation">
        <nav>
            <ul>
                <li><a class="selected" data-name="newest" href="#">Recientes</a></li>
                <li><a class="unselected" data-name="mostCommented" href="#">Más comentados</a></li>
                <li><a class="unselected" data-name="mostLiked" href="#">Más valorados</a></li>
            </ul>
        </nav>
        <div class="rightnav">
            <div class="search">
                <form class="form-search" action="">
                    <input id="searchtext" type="text" placeholder="Buscar por palabras clave">
                </form>
            </div>
            <div class="user">
                <select id="langsel">
                    <?php foreach (LANGUAGES as $lang => $name): ?>
                        <option 
                            value="<?php echo $lang; ?>"
                            <?php if ($lang == $currentLang) { echo 'selected'; } ?>
                        ><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
                <button id="userbtn">
                    <?php include "img/user-default-image.svg"; ?>
                </button>
            </div>
        </div>
    </div>
</header>
<script src="js/views/partials/header.js"></script>
<?php include "partials/user_banner.php"; ?>