<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedor_login">
        <div class="logo">
            <img src="../images/aerbide-logo.svg" alt="logo">
        </div>
        <div class="form_login">
            <form action="" method="post">
                <div class="txt">
                    <p>Inicia sesión con tu cuenta</p>
                </div>
                <div class="log">
                    <label for=""><img src="../images/user-blue.svg" alt="svg_user" class="icon"></label>
                    <input type="text" placeholder="Usuario">
                </div>
                <div class="log">
                    <label for=""><img src="../images/password-blue.svg" alt="svg_pass" class="icon"></label>
                    <input type="text" placeholder="Password">
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

<?php

    //echo "View del login<br/>";

?>