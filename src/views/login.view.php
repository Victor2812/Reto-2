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
                <div class="login">
                    <label for=""><img src="../images/user-blue.svg" alt="svg_user" class="icon"></label>
                    <div class="in">
                        <input type="text" placeholder="Usuario" id="log_user">
                    </div>
                    <div class="icon">
                        <?php include "images/uncheck.svg"; ?>
                    </div>
                </div>
                <div class="login">
                    <label for=""><img src="../images/password-blue.svg" alt="svg_pass" class="icon"></label>
                    <div class="in">
                        <input type="text" placeholder="Password" id="log_pass">
                    </div>
                    <object data="../images/uncheck.svg" class="icon" id="log_pass_ck"></object>
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
    <script>
        //document.getElementById("enviar").addEventListener('click', validar);

        let nom = document.getElementById("log_user");
        let pass = document.getElementById("log_pass");
        let num_ck = document.getElementById("log_user_ck");
        let pass_ck = document.getElementById("log_pass_ck");

        //validations
        let regExNom = new RegExp("^[A-Z]{1}[a-z]+$");
        let regExPass = new RegExp("[A-Za-z0-9]+$");

        //fuction activates when lost focus on the inputs of the form
        nom.addEventListener('onBlur', validar);



    </script>
</body>
</html>

<?php

    //echo "View del login<br/>";

?>