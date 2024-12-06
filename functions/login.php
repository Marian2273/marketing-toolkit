<?php
include("../config/connect1.php");
error_reporting(0);

$email=$_POST['email'];
$password=$_POST['password'];
//$recaptcha=$_POST['recaptcha_response'];
$token = $_POST['token'];
$action = $_POST['action'];

$curlData = array(
	'secret'	=> $config['SECRET_API_KEY_ReCaptchGoogle'],
	'response'	=> $token
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$curlResponse = curl_exec($ch);

$captchaResponse = json_decode($curlResponse, true);

if($captchaResponse['success'] == '1' 
	&& $captchaResponse['action'] == $action 
	&& $captchaResponse['score'] >= 0.5 
	&& $captchaResponse['hostname'] ==  $_SERVER['SERVER_NAME'])
{
  $options = array("cost"=>4);
  $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
  $sql = "select * from usuarios where email Like '$email' AND id_activo LIKE 1";
  $rs = mysqli_query($mysqli,$sql);
  $numRows = mysqli_num_rows($rs);
    
    if($numRows  == 1){
      $row = mysqli_fetch_assoc($rs);
      if(password_verify($password,$row['password'])){
        // Configuración de la cookie de sesión para duración prolongada
    session_set_cookie_params([
      'lifetime' => 31536000, // 1 año en segundos
      'path' => '/',
      'secure' => true, // Solo para HTTPS, asegúrate de que tu sitio esté en HTTPS
      'httponly' => true, // Previene accesos de JavaScript para mayor seguridad
      'samesite' => 'Strict' // Evita que se envíe en solicitudes externas
  ]);

  // Iniciar la sesión después de configurar los parámetros
  session_start();

  // Guardar la información del usuario en la sesión
  $_SESSION["user_toolkit"] = $row['id'];
  $user_toolkit = $_SESSION["user_toolkit"];

  // Regenerar el ID de sesión para mayor seguridad
  session_regenerate_id();

  echo 'true';
}
else{
echo 'La clave es incorrecta';

//header("location:../index.php?error=La clave es Incorrecta.&$variables");
}
}
else{
echo ' El usuario es incorrecto o todavía no validó su email';
//header("location:../index.php?error=El Usuario es incorrecto.&$variables");
}   
} else {
echo 'Posible Spamm, refresque la página y vuelva a intentar';
}
?>