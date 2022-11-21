
<div class="login-screen">
    <main>
        <div class="login-container">
            <input type="checkbox" id="chk" aria-hidden="true">
            <img src="./img/aerbide-logo.svg" alt="logo-aerbide">
            <div class="signup">
                <form action="<?php echo current_file(); ?>" method="POST">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="text" name="txt" placeholder="Usuario" required>
                    <input type="password" name="pass" placeholder="Contraseña" required>
                    <input type="password" name="pass-repeat" placeholder="Repite Contraseña" required>
                    <button class="button-blue">Sign up</button>
                </form>
            </div>
            <div class="login">
                <form action="<?php echo current_file(); ?>" method="POST">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="text" name="txt" placeholder="Usuario" required>
                    <input type="password" name="pass" placeholder="Contraseña" required>
                    <button class="button-blue">Login</button>
                </form>        
            </div>
        </div>
    </main>
</div>


