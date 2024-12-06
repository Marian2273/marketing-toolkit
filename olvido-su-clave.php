<?php
error_reporting(0);
session_start();

if (isset($_SESSION['user_toolkit']) && !empty($_SESSION['user_toolkit'])) {
    header("Location: toolkit.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover"/>
    <meta name="mobile-web-app-capable" content="yes">
    <title>Marketing Toolkit</title>
    <link rel="manifest" crossorigin="use-credentials" href="manifest.json" />
    <link rel="stylesheet" href="dist/add-to-homescreen.min.css" />
    <script defer src="dist/add-to-homescreen_es.min.js"></script>
    <link rel="stylesheet" href="css/line-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="theme-color" content="#070713">
    <!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/jquery.min.js"></script>
<!-- //js -->
</head>

<body>
<header>
        <nav>
            <div class="info">
             <img src="img/logo-ITP_blanco.png" id="logo" />
               
          </div>
        </nav> 
    </header>

    <body class="login">
    <div class=" section-wrapper" >
            <div class="w3l-form-info" >
                <div class="w3_info">
               <h1>¡Hola!</h1>
                <h2>Resetear contraseña</h2>
                    <form   method="post" action="#" id="formularioolvido" >
                        <div class="form-group input-group  has-success">
                          
                           
                            <input type="email" placeholder="Email"  id="email" name="email">
                            <span id="error" class="help-block"></span>
                        </div>
                       
                        <div class="form-row bottom">
                           
                            
                        </div>
                        <input class="btn btn-primary btn-block" type="submit" value="Enviar">
                       
                    </form>
                    
                    <div id="add_err2"></div>
                    <p class="account blanco"> <a href="login.php"> Ya tengo usuario </a></p>
                    <p class="account"> <a href="registro.php"> No tengo usuario </a></p>

                    <p class="aclaracion"> Si tenés algún problema escribinos: <br> <a href="mailto:marketing@itpatagonia.com" target="_blank" >marketing@itpatagonia.com</a> </p>
                </div>
               
            </div>
            
            </div>
           

            
     

    

     <script src="js/jquery.form.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/validador-olvido.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdUIGEqAAAAAH3_-snIpcPZuPEwNOE7ZWP5xYIm"></script>
</body>
</html>