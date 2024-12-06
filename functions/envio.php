<?php
error_reporting(0);

global $id_user_mail;
global $url;

//Get User Info
if (!function_exists('get_user_info')) {
    function get_user_info($id, $name) {
        global $mysqli;
        $id=$id;
        $name=$name;
            $query="SELECT * FROM usuarios WHERE id LIKE $id";
            $result = mysqli_query($mysqli,$query) ;
            while ($row = mysqli_fetch_assoc($result)) {
              
                if ($name == $name) {
                    return $row[$name];
                }
            }
   
    }
}
// Verificar que $id_user_mail tenga un valor
if (empty($id_user_mail)) {
    die("Error: ID de usuario no especificado");
}

// Obtener la información del usuario
$email = get_user_info($id_user_mail, 'email');
if (empty($email)) {
    die("Error: No se pudo obtener el email del usuario");
}
$name = get_user_info($id_user_mail,'nombre'). ' ' .get_user_info($id_user_mail,'apellido') ;
$date = get_user_info($id_user_mail,'date');


//PHPMailer
require 'vendor/autoload.php'; // Cargar PHPMailer usando Composer

define('BASE_PATH', __DIR__); // Define la ruta base al directorio del script actual

// Cargar las clases de PHPMailer
require BASE_PATH . '/PHPMailer/src/Exception.php';
require BASE_PATH . '/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


try {
    // Primer correo
    $mail = new PHPMailer(true);
    
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username = 'web@itpatagonia.com';
    $mail->Password =  'cvyc boch tyjw bxjr';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('web@itpatagonia.com', 'Marketing Toolkit');
    $mail->addAddress('marianabelgrano@gmail.com', 'Mariana Belgrano');
    $mail->CharSet = 'UTF-8';
    
    $mail->isHTML(true);
    $mail->Subject = '¡Registro Exitoso en App Marketing Digital!';
    $mail->Body = $body; // Mensaje a enviar
    
 $body =file_get_contents('mails/base.html');
 //$body = preg_replace("[\]",'',$body);
 
 //setup vars to replace
 $vars = array('{name}','{email}','{date}','{id}','{url}');
 $values = array($name, $email , $date, $id_user_mail,$url);
 
 //replace vars
 $body = str_replace($vars,$values,$body);
 
 //add the html tot the body
 $mail->MsgHTML($body);
 
 
  $mail->Body = $body; // Mensaje a enviar
    
    $mail->send();
    
    // Segundo correo
    /*
    $mail2 = new PHPMailer(true);
    
    // Configuración del servidor SMTP para el segundo correo
    $mail2->isSMTP();
    $mail2->Host = 'smtp.gmail.com';
    $mail2->SMTPAuth = true;
    $mail2->Username = 'web@itpatagonia.com';
    $mail2->Password = 'cvyc boch tyjw bxjr';
    $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail2->Port = 587;
    
    $mail2->setFrom('web@itpatagonia.com', 'Marketing Toolkit');
    $mail2->addAddress('marianabelgrano@gmail.com', 'Otro Destinatario'); // Cambia esta dirección
    $mail2->CharSet = 'UTF-8';
    
    $mail2->isHTML(true);
    $mail2->Subject = 'Nuevo Registro de Usuario para Activación';
    $mail2->Body    = '<p>Se ha registrado un nuevo usuario en la App de Marketing Digital. Por favor, proceder con la activación de la cuenta.</p>';
    $mail2->AltBody = 'Detalles del usuario:<br>

         Nombre: '.$email .'
        Correo electrónico: '.$email .'
        Fecha de registro: '.$email;
    
    $mail2->send();
    */
    echo '¡Gracias por registrarte! <br>
    Estamos procesando tu solicitud, y en breve procederemos a activar tu cuenta.';
} catch (Exception $e) {
    echo "No se puedo enviar el correo. Error: {$mail->ErrorInfo}";
}
?>
