<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedor_login">
        <div class="logo">
            <img src="../img/aerbide-logo.svg" alt="logo">
        </div>
        <div class="form_login">
            <form action="" method="post">
                    <div class="txt">
                        <p>Crea tu cuenta</p>
                    </div>
                    <div class="login">
                        <div class="icon">
                            <?php include "img/user.svg" ?>
                        </div>
                        <div class="in">
                            <input type="text" placeholder="Usuario" id="log_user">
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
                            <input type="password" placeholder="Password" id="log_pass">
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
                            <input type="password" placeholder="Repeat password" id="re_log_pass">
                        </div>
                        <div class="icon">
                            <?php include "img/uncheck.svg" ?>
                        </div>
                    </div>
                    <div class="check_accept">
                        <div>
                            <input type="checkbox" name="ck_condition" class="checkbox">
                        </div>                      
                        <div>
                            <label for="">Acepto que mis datos sean incluidos en la base de datos</label>
                        </div>
                    </div>
                    <div class="register">
                        <input type="submit" class="checkbox" name="register" value="Regístrate">
                    </div>
                    <div class="init_sesion">
                        <button class="iniciar">Iniciar sesión</button>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>