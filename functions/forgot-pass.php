<?php
error_reporting(0);
include("../config/connect1.php"); 
//PHPMailer
require 'vendor/autoload.php'; // Cargar PHPMailer usando Composer

define('BASE_PATH', __DIR__); // Define la ruta base al directorio del script actual

// Cargar las clases de PHPMailer
require BASE_PATH . '/PHPMailer/src/Exception.php';
require BASE_PATH . '/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Sanitizador 
use voku\helper\AntiXSS;
require_once __DIR__ . '/vendor/autoload.php'; // example path
$antiXss = new AntiXSS();




/*
echo 'true';
echo "<pre>";
print_r($_POST);
echo "</pre>";
die();
*/



$email = $_POST['email'];

// Validadondo email Paciente
$sql_all="SELECT * FROM usuarios WHERE email LIKE '$email' ";

$result_all = mysqli_query($mysqli,$sql_all);
$total_all= mysqli_num_rows($result_all);
$row = mysqli_fetch_assoc($result_all);
$id_user = $row['id'];
$nombre =  $row['nombre'];
$apellido = $row['apellido'];


$name= $nombre .' '. $apellido;

if($total_all == '0'){
 echo '<span class="error">El correo electrónico ingresado no está registrado en nuestra base de datos. <br> 
 <br> Gracias.</span>';
} else if($email ==''){
echo '<span class="error"> Por favor, ingrese su email.</span>';

}else{

$password= substr(sha1(mt_rand()),17,8);
$options = array("cost"=>4);
$hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);  

$sql="UPDATE  usuarios SET  password ='$hashPassword'
WHERE email LIKE '$email' ";
mysqli_query($mysqli,$sql);


$subject = "Recuperación de contraseña - IT Patagonia ";
$text = '<h3> Su nueva contraseña es la siguiente:</h3>
<p> Usuario:  '. $email .' </p>
<p><strong> Nueva Clave:  '. $password.' </strong></p> ';

// Envío Notificación

 
 $mail = new PHPMailer();
 $mail->isSMTP();
 $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
 $mail->SMTPAuth = true;
 $mail->Username = 'marianabelgrano@gmail.com';
 $mail->Password =  'aqfi xuid rlfn dsmv';  // Contraseña
 
 $mail->Port = 587; // O 465 para SSL


 $mail->From = 'marketing@itpatagonia.com';  // Desde donde enviamos (Para mostrar)
 $mail->FromName = "Restablecer la contraseña - Marketing Toolkit";
 $mail->AddAddress($email); // Esta es la dirección a donde enviamos
 //$mail->AddCC("cuenta@dominio.com"); // Copia
 //$mail->AddBCC("marianabelgrano@hotmail.com"); // Copia oculta para esssaaabel
 $mail->CharSet = 'UTF-8';
 $mail->IsHTML(true); // El correo se envía como HTML
 $mail->Subject =$subject; // Este es el titulo del email.
 $body = $text;



 $body =file_get_contents('mails/password-reset.html');
//$body = preg_replace("[\]",'',$body);

//setup vars to replace
$vars = array('{name}','{email}','{password}','{url}');
$values = array($name,$email, $password, $url);

//replace vars
$body = str_replace($vars,$values,$body);

//add the html tot the body
$mail->MsgHTML($body);


 $mail->Body = $body; // Mensaje a enviar
// $mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
 //$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");
 $exito = $mail->Send(); // Envía el correo.

if($exito){
 echo '<span class="exito"> La nueva contraseña fue enviada a su correo electrónico.<br> Si no recibe el email en su bandeja de entrada, revise su correo no deseado o spam.</br>Gracias. </span>';

}else{ 
    echo 'Mailer Error: ' . $mail->ErrorInfo;
 //echo '<span class="error"> Se produjo un error al enviar el correo electrónico. Vuelva a intentarlo más tarde. <br> Gracias .</span>';

}
}

?>