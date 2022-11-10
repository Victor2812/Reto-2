<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
    <title>Aerbide|Home</title>
</head>
<body>
    <header>
        <img class="logo" src="img/aerbide-logo.svg" alt="logo-aerbide">
        <div class="navigation">
            <nav>
                <ul>
                    <li class="selected"><a href="#">Recientes</a></li>
                    <li><a href="#">Más comentados</a></li>
                    <li><a href="#">Más valorados</a></li>
                </ul>
            </nav>
            <div class="rightnav">
                <div class="search">
                    <form action="">
                        <label>Buscar <input type="text" placeholder="Texto o #tag"></label>
                    </form>
                </div>
                <div class="user">
                    <button id="notifbtn">
                        <?php include "img/notification-white-stroke.svg"; ?>
                    </button><button id="userbtn">
                        <?php include "img/user-default-image.svg"; ?>
                    </button>
                </div>
            </div>
        </div>
    </header>
</body>
</html>