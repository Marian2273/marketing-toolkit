<?php
header("X-XSS-Protection: 1"); 
error_reporting(0);
// Sanitizador 
use voku\helper\AntiXSS;
require_once __DIR__ . '/vendor/autoload.php'; // example path
$antiXss = new AntiXSS();
include("../config/connect1.php"); 



/*
print_r($_POST);
die();
*/
$nombre=addslashes($antiXss->xss_clean($_POST['nombre']));
$apellido=addslashes($antiXss->xss_clean($_POST['apellido']));
$email=addslashes($antiXss->xss_clean($_POST['email']));
$password=addslashes($antiXss->xss_clean($_POST['password']));
$id_update=addslashes($antiXss->xss_clean($_POST['id_update']));
$password1=addslashes($antiXss->xss_clean($_POST['password1']));




if($id_update == 1){
if($password1 == ''){
    $sql="UPDATE usuarios SET nombre = '$nombre', apellido='$apellido' WHERE id LIKE '$user_dg' ";
    mysqli_query($mysqli,$sql);
    echo '<p class="green"> Sus datos se actualizaron exitosamente</p>';
}else{
    $sec_code = substr(md5(rand()), 0, 20);
    $options = array("cost"=>4);
    $hashPassword = password_hash($password1,PASSWORD_BCRYPT,$options);  
    $sql="UPDATE usuarios SET nombre = '$nombre', apellido='$apellido', password = '$hashPassword' WHERE id LIKE '$user_dg' ";
    mysqli_query($mysqli,$sql);
    echo '<p> Sus datos se actualizaron exitosamente</p>';
}


}else{  

//Recaptcha
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
$curlResponse = curl_exec($ch);

$captchaResponse = json_decode($curlResponse, true);

// Users repeat 
$sql_all="SELECT email FROM usuarios WHERE email LIKE '$email' ";
$result_all = mysqli_query($mysqli,$sql_all);
$total_all= mysqli_num_rows($result_all);
if($total_all > 0){
echo 'Este email ya se encuentra registrado en nuestra base de datos';
}
else if($captchaResponse['success'] == '1' 
	&& $captchaResponse['action'] == $action 
	&& $captchaResponse['score'] >= 0.5 
	&& $captchaResponse['hostname'] ==  $_SERVER['SERVER_NAME'])
{


                $sec_code = substr(md5(rand()), 0, 20);
                $options = array("cost"=>4);
                $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);  
                $sql="INSERT INTO usuarios (nombre, apellido, email, password ,id_activo, sec_code)
                VALUES (
                '$nombre' ,
                '$apellido',
                '$email',
                '$hashPassword',
                '1',
                '$sec_code'
                )";
                mysqli_query($mysqli,$sql);
                
                

                //print_r($mysqli->error_list);
                //send Mail Validate
                /*
                $id_user = $mysqli->insert_id;
              
                           
                $mail_tem ='mails/email-confirmation.html';
                $sec_code = get_user_info($id_user, 'sec_code');
                $subject = 'Confirmación de correo electrónico';
                $smtp = $config['host'];
                $userName =$config['user'];
                $pass =$config['pass'];
                $port=$config['port'];
                $url=$config['url'];
              */
               //send_notification($id_user, $mail_tem, $sec_code, $subject, $smtp, $userName,$pass, $port, $url);
               echo "true";
                }
                else {
                 echo '<p> You are a Spammer! Refresh the page and try again </p>';
}


}
?>