<?php
require 'vendor/autoload.php'; // Cargar PHPMailer usando Composer

define('BASE_PATH', __DIR__); // Define la ruta base al directorio del script actual

// Cargar las clases de PHPMailer
require BASE_PATH . '/PHPMailer/src/Exception.php';
require BASE_PATH . '/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'marianabelgrano@gmail.com';
    $mail->Password = 'aqfi xuid rlfn dsmv'; // Usa la contraseña de aplicación aquí
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom('marketing@itpatagonia.com');
    $mail->addAddress('marianabelgrano@gmail.com');

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Contenido HTML del correo';
    $mail->AltBody = 'Contenido en texto plano del correo';

    // Enviar correo
    $mail->send();
    echo 'El correo ha sido enviado.';
} catch (Exception $e) {
    echo "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
}
