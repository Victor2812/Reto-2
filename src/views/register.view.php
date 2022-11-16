<div class="login-wrapper">
        <div class="login-container">
            <div class="logo">
                <img src="../img/aerbide-logo.svg" alt="logo">
            </div>
            <div class="form-login">
                <form action="<?php echo current_file(); ?>" method="POST">
                        <div class="txt">
                            <p>Crea tu cuenta</p>
                        </div>
                        <div class="login">
                            <div class="icon">
                                <?php include "img/user.svg" ?>
                            </div>
                            <div class="in">
                                <input type="text" placeholder="Username" id="log_username" name="reg_username">
                            </div>
                            <div class="icon">
                                <?php include "img/uncheck.svg" ?>
                            </div>
                        </div>
                        <div class="login">
                            <div class="icon">
                                <?php include "img/user.svg" ?>
                            </div>
                            <div class="in">
                                <input type="text" placeholder="Name" id="log_user" name="reg_name">
                            </div>
                            <div class="icon">
                                <?php include "img/uncheck.svg" ?>
                            </div>
                        </div>
                        <div class="login">
                            <div class="icon">
                                <?php include "img/password.svg" ?>
                            </div>
                            <div class="in">
                                <input type="password" placeholder="Password" id="log_pass" name="reg_pass">
                            </div>
                            <div class="icon">
                                <?php include "img/uncheck.svg" ?>
                            </div>
                        </div>
                        <div class="login">
                            <div class="icon">
                                <?php include "img/password.svg" ?>
                            </div>
                            <div class="in">
                                <input type="password" placeholder="Repeat password" id="rp_log_pass" name="reg_rp_pass">
                            </div>
                            <div class="icon">
                                <?php include "img/uncheck.svg" ?>
                            </div>
                        </div>
                        <div class="check_accept">
                            <div class="checkbox">
                                <input type="checkbox" name="ck_condition" id="ck_registro" value="ck_reg">
                                <label for="ck_registro">Acepto que mis datos sean incluidos en la base de datos</label>
                            </div>
                        </div>
                        <div class="register">
                            <input type="submit" name="register" value="Regístrate">
                        </div>
                        <div class="init_sesion">
                            <button class="iniciar">Iniciar sesión</button>
                        </div>
                </form>
            </div>
        </div>
    </div>