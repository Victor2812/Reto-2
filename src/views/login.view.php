
<div class="login-screen">
    <main>
        <div class="login-container">
            <input type="checkbox" id="chk" aria-hidden="true">
            <img src="./img/aerbide-logo.svg" alt="logo-aerbide">
            <div class="login">
                <form action="<?php echo current_file(); ?>" method="POST">
                    <input type="text" name="login_user" placeholder="Usuario" required>
                    <input type="password" name="login_pass" placeholder="Contraseña" required>
                    <input type="submit" class="button-blue" value="Iniciar sesión">
                    <label for="chk" aria-hidden="true">¿No tienes cuenta?</label>
                </form>        
            </div>
            <div class="signup">
                <form action="<?php echo current_file(); ?>" method="POST">
                    <input type="text" name="reg_username" placeholder="Usuario" required>
                    <input type="password" name="reg_pass" placeholder="Contraseña" required>
                    <input type="password" name="reg_rp_pass" placeholder="Repite Contraseña" required>
                    <input type="submit" class="button-blue" value="Regístrate">
                    <label for="chk" aria-hidden="true">Ya tengo cuenta</label>
                </form>
            </div>
        </div>
    </main>
</div>


