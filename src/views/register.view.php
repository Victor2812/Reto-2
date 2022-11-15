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
                    <div class="text">
                        <p>Crea tu cuenta</p>
                    </div>
                    <div class="login">
                        <label for=""><img src="../images/user-blue.svg" alt="svg_user" class="icon"></label>
                        <div class="in">
                            <input type="text" placeholder="Usuario" id="log_user">
                        </div>
                        <img src="../images/uncheck.svg" alt="uncheck" class="icon" id="log_user_ck">
                    </div>
                    <div class="login">
                        <label for=""><img src="../images/password-blue.svg" alt="svg_pass" class="icon"></label>
                        <div class="in">
                            <input type="text" placeholder="Password" id="log_pass">
                        </div>
                        <object data="../images/uncheck.svg" class="icon" id="log_pass_ck"></object>
                    </div>
                    <div class="login">
                        <label for=""><img src="../images/password-blue.svg" alt="svg_pass" class="icon"></label>
                        <div class="in">
                            <input type="text" placeholder="Password" id="log_pass">
                        </div>
                        <object data="../images/uncheck.svg" class="icon" id="log_pass_ck"></object>
                    </div>
                    <div class="check_accept">
                        <input type="checkbox" class="accept">
                        <label for="">Acepto que mis datos sean incluidos en la base de datos</label>
                    </div>
                    <div class="register">
                        <input type="submit" value="Regístrate">
                    </div>
                    <div class="init_session">
                        <button class="iniciar">Iniciar sesión</button>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>