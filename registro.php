<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
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

<body class="registro">
<header>
        <nav>
            <div class="info">
             <img src="img/logo-ITP_blanco.png" id="logo" />
               
          </div>
        </nav> 
    </header>

<main>
        <div class="categories section-wrapper" >
            <div class="w3l-form-info" >
                <div class="w3_info">
                <i class="las la-user iconos" aria-hidden="true"></i> <h2>Registro</h2>
                <form id="formulario-registro"  action="#"  method="post" >
                        <div class="form-group input-group  has-success">
                    
					<input type="text" placeholder="Nombre"  name="nombre" id="nombre" >
					<span id="error" class="help-block"></span>
						</div>
				<div class="form-group input-group has-success"> 
             
				<input type="text" placeholder="Apellido" name="apellido"  id="apellido" >
				<span id="error" class="help-block"></span>
                			</div>

				<div class="form-group input-group has-success"> 
               
					<input type="email" placeholder="Email" name="email"  id="email" >
				<span id="error" class="help-block"></span>
                			</div>	

				<div class="form-group input-group has-success"> 	
              
					<input type="password" placeholder="Password" name="password"  id="password" >
					<span id="error" class="help-block"></span>
                			</div>
				
                            <div class="form-group input-group has-success"> 	
					<input type="password" placeholder="Confirmar Password "  name="cpassword"  >
					<span id="error" class="help-block"></span>
                		</div>
                         
                       
                 <input class="btn btn-primary btn-block" type="submit" value="Registrarme">
                       
                    </form>
                    
                    <div id="add_err"></div>
                   
                    <p class="account">Ya tengo usuario <a href="login.php">Login</a></p>
                </div>
            </div>
              
            </div>
           

            
     
    </main>
    
    

     <script src="js/jquery.form.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/validador-registro.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdUIGEqAAAAAH3_-snIpcPZuPEwNOE7ZWP5xYIm"></script>
</body>
</html>