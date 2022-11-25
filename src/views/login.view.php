<?php
    $login_errors = $GLOBALS['login_errors'];
    $register_errors = $GLOBALS['register_errors'];
?>

<div class="login-screen">
    <main>
        <!-- divs bg son para la animación del fondo -->
        <div class="bg"></div>
        <div class="bg bg2"></div>
        <div class="bg bg3"></div>

        <div class="login-container">
            <input type="checkbox" id="chk" aria-hidden="true">
            <img src="./img/aerbide-logo.svg" alt="logo-aerbide">
            <div class="login">
                <form action="<?php echo current_file(); ?>?action=login" method="POST">
                    <input type="text" name="login_user" placeholder="Usuario" required>
                    <input type="password" name="login_pass" placeholder="Contraseña" required>
                    <input type="submit" class="button-blue" value="Iniciar sesión">
                    <div class="errors">
                        <?php
                            if (isset($login_errors)) {
                                foreach ($login_errors as $error) {
                                    echo "<p>$error</p>";
                                }
                            }
                        ?>
                    </div>
                    <label for="chk" aria-hidden="true">¿No tienes cuenta?</label>
                </form>       
            </div>
            <div class="signup">
                <form action="<?php echo current_file(); ?>?action=register" method="POST">
                    <input type="text" name="reg_username" placeholder="Usuario" required>
                    <input type="text" name="reg_name" placeholder="Nombre" required>
                    <input type="password" name="reg_pass" placeholder="Contraseña" required>
                    <input type="password" name="reg_rp_pass" placeholder="Repite Contraseña" required>
                    <input type="submit" class="button-blue" value="Regístrate">
                    <div class="errors">
                        <?php
                            if (isset($register_errors)) {
                                foreach ($register_errors as $error) {
                                    echo "<p>$error</p>";
                                }
                            }
                        ?>
                    </div>
                    <label for="chk" aria-hidden="true">Ya tengo cuenta</label>
                </form>
            </div>
        </div>
    </main>
</div>


