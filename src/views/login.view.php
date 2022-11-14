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
                    <p>Inicia sesión con tu cuenta</p>
                </div>
                <div class="login">
                    <div class="icon">
                        <?php include "img/user.svg" ?>
                    </div>
                    <div class="in">
                        <input type="text" placeholder="Usuario" id="log_user">
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
                        <input type="text" placeholder="Password" id="log_pass">
                    </div>
                    <div class="icon">
                        <?php include "img/uncheck.svg"; ?>
                    </div>
                </div>
                <div class="registrarse">
                    <a href="">¿No tienes cuenta?</a>
                </div>
                <div>
                    <input type="submit" value="Iniciar sesión" id="enviar">
                </div>
            </form>
        </div>
    </div>
</body>
</html>