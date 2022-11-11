<div class="login-wrapper">
    <div class="login-container">
        <div class="logo">
            <img src="../img/aerbide-logo.svg" alt="logo">
        </div>
        <form class="form-login" action="<?php echo current_file(); ?>" method="POST">
            <p>Inicia sesión con tu cuenta</p>
            <div class="login">
                <div class="icon">
                    <?php include "img/user.svg" ?>
                </div>
                <div class="in">
                    <input type="text" placeholder="Usuario" name="login_user">
                </div>
                <div class="icon">
                    <?php include "img/uncheck.svg"; ?>
                </div>
            </div>
            <div class="login">
                <div class="icon">
                    <?php include "img/password.svg" ?>
                </div>
                <div class="in">
                    <input type="password" placeholder="Password" name="login_pass">
                </div>
                <div class="icon">
                    <?php include "img/uncheck.svg"; ?>
                </div>
            </div>
            <div class="register">
                <a href="">¿No tienes cuenta?</a>
            </div>
            <div>
                <input type="submit" value="Iniciar sesión">
            </div>
        </form>
    </div>
</div>