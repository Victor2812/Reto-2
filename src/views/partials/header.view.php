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
                <li><a class="selected" data-name="newest" href="/index.php">Recientes</a></li>
                <li><a class="unselected" data-name="mostCommented" href="/index.php">Más comentados</a></li>
                <li><a class="unselected" data-name="mostLiked" href="/index.php">Más valorados</a></li>
            </ul>
        </nav>
        <div class="rightnav">
            <div class="search">
                <form class="form-search">
                    <input id="searchtext" type="text" placeholder="Buscar por palabras clave">
                </form>
            </div>
            <div class="flex-container">
                <button id="userbtn">
                    <img src="img/user-default-image.svg" alt="usuario activo" class="author-icon">
                </button>
                <select id="langsel" class="select-category">
                    <?php foreach (LANGUAGES as $lang): ?>
                        <option 
                            value="<?php echo $lang; ?>"
                            <?php if ($lang == $currentLang) { echo 'selected'; } ?>
                        ><?php echo $lang; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</header>
<script src="js/views/partials/header.js"></script>
<?php include "user_banner.php"; ?>