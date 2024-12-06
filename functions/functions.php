<?php
session_start();
header("X-XSS-Protection: 1"); 
error_reporting(0);
/*
error_reporting(E_ERROR | E_PARSE);
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

include("config/connect.php"); 

$actual_link = $_SERVER['PHP_SELF'];
$path = parse_url($actual_link , PHP_URL_PATH);
$filename = substr(strrchr($path, "/"), 1);

//Usuario Session
$user_toolkit=$_SESSION["user_toolkit"];
$url= $config['url'];

//Proteger de los no logueados
if (!isset($_SESSION["user_toolkit"]) || $_SESSION["user_toolkit"] !== $user_toolkit) {
    // Si la sesión no está iniciada, redirige al index
    header("Location: index.php");
    exit();
}


//SMTP
$host = $config['host'];
$host_usuario= $config['user'];
$host_pass= $config['pass'];
$host_port= $config['port'];
$site_url= $config['url'];


// Sanitizador 
use voku\helper\AntiXSS;
require_once __DIR__ . '/vendor/autoload.php'; // example path
$antiXss = new AntiXSS();



// Determina la sección basada en la URL
$iconos = [
    'toolkit' => [
        'azul' => 'img/Iconos_Botonera-17.png',
        'blanco' => 'img/Iconos_Botonera-21.png',
         'link' => 'toolkit.php'
    ],
    
    'categorias' => [
        'azul' => 'img/Iconos_Botonera-19.png',
        'blanco' => 'img/Iconos_Botonera-23.png',
         'link' => 'categorias.php'
    ],
    'notas' => [
        'azul' => 'img/Iconos_Botonera-20.png',
        'blanco' => 'img/Iconos_Botonera-24.png',
         'link' => 'notas.php'
    ],
    'perfil' => [
        'azul' => 'img/Iconos_Botonera-18.png',
        'blanco' => 'img/Iconos_Botonera-22.png',
         'link' => 'functions/logout.php'
    ]
];

$seccion = 'toolkit'; // Default
if (strpos($_SERVER['REQUEST_URI'], 'categorias') !== false) {
    $seccion = 'categorias';
} elseif (strpos($_SERVER['REQUEST_URI'], 'perfil') !== false) {
    $seccion = 'perfil';
} elseif (strpos($_SERVER['REQUEST_URI'], 'notas') !== false) {
    $seccion = 'notas';
}




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
 // Funcion para desloguear al que paso de 1 a 0
 if (!function_exists('get_user_activo')) {
    function get_user_activo($id) {
        global $mysqli;
        $id=$id;
       
            $query="SELECT * FROM usuarios WHERE id LIKE $id ";
            $result = mysqli_query($mysqli,$query) ;
            while ($row = mysqli_fetch_assoc($result)) {
              
                if ($row['id_activo'] == 1) {
                    return $row['nombre'];
                }else if ($row['id_activo'] == 0){
                    header("Location:functions/logout.php");
                    exit();
                }
            }
    }
}

//Seccion Novedades
if (!function_exists('get_novedades')) {
    function get_novedades() {
        global $mysqli;
        global $url;
        $user_toolkit=$_SESSION["user_toolkit"];
       

        $query = "SELECT * FROM archivos  where id_novedades LIKE 1 ORDER BY id DESC";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '    <div class="promo-item" >
                  
            <div class="promo-info">
                <img src="'.$row['imagen'] .'" class="img-responsive" />
                <p>'. $row['nombre'] .'</p>
                <div class="seccion-compartir">
                    <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20'.$url.'/'.$row['link'] .'" target="_blank">
                        <img src="img/whatsapp_icon.png" class="compartir" />
                    </a>
                     <a href="mailto:?subject=Te Comparto este Artículo&body=' . urlencode($url.'/'.$row['link']) . '" target="_blank"><img src="img/envelope_email_icon.png" class="compartir" /></a>
                    <button class="like-btn" id="like-btn" data-postid="'. $row['id'] .'" data-userid="'. $user_toolkit .'">
                    <span id="heart" class="heart las la-heart"> </span> <!-- Corazón vacío -->
                    </button>

                </div>
            </div>
        </div>';

        }

    }
}

//Seccion favoritos
if (!function_exists('get_favoritos')) {
    function get_favoritos() {
        global $mysqli;
        global $url;
        $user_toolkit=$_SESSION["user_toolkit"];
       

        $query = "SELECT * FROM archivos";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '    <div class="promo-item" >
                  
            <div class="promo-info">
                <img src="'.$row['imagen'] .'" class="img-responsive" />
                <p>'. $row['nombre'] .'</p>
                <div class="seccion-compartir">
                    <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20'.$url.'/'.$row['link'] .'" target="_blank">
                        <img src="img/whatsapp_icon.png" class="compartir" />
                    </a>
                     <a href="mailto:?subject=Te Comparto este Artículo&body=' . urlencode($url.'/'.$row['link']) . '" target="_blank"><img src="img/envelope_email_icon.png" class="compartir" /></a>
                    <button class="like-btn" id="like-btn" data-postid="'. $row['id'] .'" data-userid="'. $user_toolkit .'">
                    <span id="heart" class="heart las la-heart"> </span> <!-- Corazón vacío -->
                    </button>

                </div>
            </div>
        </div>';

        }

    }
}
//Fetch de favoritos real
//Seccion favoritos
if (!function_exists('get_favoritos_real')) {
    function get_favoritos_real() {
        global $mysqli;
        global $url;

        if (!isset($_SESSION["user_toolkit"])) {
            echo "Usuario no autenticado.";
            return;
        }

        $user_toolkit = $_SESSION["user_toolkit"];

        // Consulta SQL preparada para evitar inyección
        $query = "
    SELECT a.*, l.liked
    FROM archivos a
    INNER JOIN likes l ON a.id = l.post_id
    WHERE l.liked = 1
      AND l.user_id = ?
";


        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $user_toolkit);
            $stmt->execute();
            $result = $stmt->get_result();

           while ($row = $result->fetch_assoc()) {
    // Escapar datos para seguridad
    $archivo_id = htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8');
    $nombre = htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8');
    $link = htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8');
    $imagen = htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8');
    $liked = (int)$row['liked']; // Asegúrate de que sea un valor entero

    // Generar el contenido HTML
    echo '<div class="promo-item">
            <div class="promo-info">
                <img src="' . $imagen . '" class="img-responsive" alt="' . $nombre . '" />
                <p>' . $nombre . '</p>
                <div class="seccion-compartir">
                    <a href="https://wa.me/?text=Mira%20este%20archivo:%20' . urlencode($url . '/' . $link) . '" target="_blank">
                        <img src="img/whatsapp_icon.png" class="compartir" alt="Compartir en WhatsApp" />
                    </a>
                    <a href="mailto:?subject=Te Comparto este Artículo&body=' . urlencode($url . '/' . $link) . '" target="_blank">
                        <img src="img/envelope_email_icon.png" class="compartir" alt="Compartir por correo" />
                    </a>
                    <button class="like-btn" data-postid="' . $archivo_id . '" data-userid="' . $user_toolkit . '">
                        <span class="heart las la-heart ' . ($liked === 1 ? 'liked' : '') . '"></span>
                    </button>
                </div>
            </div>
        </div>';
}


            $stmt->close();
        } else {
            echo "Error en la consulta: " . $mysqli->error;
        }
    }
}


//Seccion Notas Blog
if (!function_exists('get_notas')) {
    function get_notas() {
        global $mysqli;

        $query = "SELECT * FROM notas ORDER BY id DESC";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '    <div class="promo-item" >
                  
            <div class="promo-info">
                <img src="'.$row['imagen'] .'" class="nota-img" />
                <p>'. $row['nombre'] .'</p>
                <a href="'. $row['link'] .'" class="btn-nota"  target="_blank"> Leer más</a>
               
            </div>
        </div>';

        }

    }
}


//Seccion Notas Blog
if (!function_exists('get_tags')) {
    function get_tags() {
        global $mysqli;
        
      

        $query = "SELECT * FROM tags";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '   
               <div class="content-tags">
                <a href="" class="btn btn-primary btn-tags">#'. $row['nombre'] .'</a>
                    
            </div>';

        }

    }
}

//Fetch de favoritos real
//Seccion favoritos
if (!function_exists('get_favoritos_real')) {
    function get_favoritos_real() {
        global $mysqli;
        global $url;

        if (!isset($_SESSION["user_toolkit"])) {
            echo "Usuario no autenticado.";
            return;
        }

        $user_toolkit = $_SESSION["user_toolkit"];

        // Consulta SQL preparada para evitar inyección
        $query = "
            SELECT 
                a.id AS archivo_id,
                a.nombre,
                a.link,
                a.imagen,
                a.id_categoria,
                a.id_novedades,
                a.date,
                COALESCE(l.liked, 0) AS liked
            FROM archivos a
            LEFT JOIN likes l ON a.id = l.post_id AND l.user_id = ?
        ";

        if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('i', $user_toolkit);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                // Escapar datos para seguridad
                $archivo_id = htmlspecialchars($row['archivo_id'], ENT_QUOTES, 'UTF-8');
                $nombre = htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8');
                $link = htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8');
                $imagen = htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8');
                $liked = (int) $row['liked'];

                // Generar el contenido HTML
                echo '<div class="promo-item">
                        <div class="promo-info">
                            <img src="' . $imagen . '" class="img-responsive" alt="' . $nombre . '" />
                            <p>' . $nombre . '</p>
                            <div class="seccion-compartir">
                                <a href="https://wa.me/?text=Mira%20este%20archivo:%20' . urlencode($url . '/' . $link) . '" target="_blank">
                                    <img src="img/whatsapp_icon.png" class="compartir" alt="Compartir en WhatsApp" />
                                </a>
                                <a href="mailto:?subject=Te Comparto este Artículo&body=' . urlencode($url . '/' . $link) . '" target="_blank">
                                    <img src="img/envelope_email_icon.png" class="compartir" alt="Compartir por correo" />
                                </a>
                                <button class="like-btn" data-postid="' . $archivo_id . '" data-userid="' . $user_toolkit . '">
                                    <span class="heart las la-heart ' . ($liked ? 'liked' : '') . '"></span>
                                </button>
                            </div>
                        </div>
                    </div>';
            }

            $stmt->close();
        } else {
            echo "Error en la consulta: " . $mysqli->error;
        }
    }
}


if (!function_exists('buscar_archivos_por_tags')) {
    function buscar_archivos_por_tags($tags) {
        global $mysqli;

        // Verificar que hay tags para buscar
        if (empty($tags)) {
            return [];
        }

        // Crear un string de placeholders para la consulta preparada
        $placeholders = implode(',', array_fill(0, count($tags), '?'));

        // Preparar la consulta SQL
        $sql = "
            SELECT a.* FROM archivos a
            JOIN archivo_tag at ON a.id = at.archivo_id
            JOIN tags t ON at.tag_id = t.id
            WHERE t.nombre IN ($placeholders)
            GROUP BY a.id
            HAVING COUNT(DISTINCT t.id) = ?
        ";

        // Preparar la declaración
        $stmt = $mysqli->prepare($sql);

        // Verificar si la declaración fue preparada correctamente
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $mysqli->error);
        }

        // Crear los tipos y valores para bind_param
        $types = str_repeat('s', count($tags)) . 'i';
        $params = array_merge($tags, [count($tags)]);
        $stmt->bind_param($types, ...$params);

        // Ejecutar la declaración y verificar su éxito
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtener y retornar los resultados en un array asociativo
        $archivos = [];
        while ($row = $result->fetch_assoc()) {
            $archivos[] = $row;
        }

        // Cerrar la declaración y retornar los archivos encontrados
        $stmt->close();
        return $archivos;
    }
}


/*
//Send Notification
if (!function_exists('send_notification')) {
    function send_notification($id_user, $mail_tem, $sec_code, $subject, $smtp, $userName,$pass, $port, $url) {
        global $mysqli;

        $id_user= $id_user;
        $subject = $subject;
        $mail_tem= $mail_tem;
        $sec_code= $sec_code;
        //SMTP
        $smtp =$smtp;
        $userName = $userName;
        $pass= $pass;
        $port = $port;
        $url = $url;
        //Users
        $name =get_user_info($id_user, 'nombre');
        $lastname =get_user_info($id_user, 'apellido');
        $email =get_user_info($id_user, 'email');


        require("class.phpmailer.php");
        $mail = new PHPMailer();
        //Luego tenemos que iniciar la validación por SMTP:

        $mail -> IsSMTP();
        $mail -> SMTPAuth = true;
        $mail -> Host = $smtp; // SMTP a utilizar. Por ej. smtp.elserver.com
        $mail -> Username =   $userName; // Correo completo a utilizar
        $mail -> Password =$pass; // Contraseña
        $mail -> Port = $port; // Puerto a utilizar

        $mail -> From =   $userName; // Desde donde enviamos (Para mostrar)
        $mail -> FromName = "Notificaciones DG";
        $mail -> AddAddress($email); // Esta es la dirección a donde enviamos
        //$mail->AddCC("cuenta@dominio.com"); 
        // $mail->AddBCC("marianabelgrano@hotmail.com");  Copia oculta para esssaaabel
        $mail -> CharSet = 'UTF-8';
        $mail -> IsHTML(true); // El correo se envía como HTML
        $mail -> Subject = $subject; // Este es el titulo del email.
      

        $body = file_get_contents($mail_tem);
        //$body = preg_replace("[\]",'',$body); setup vars to replace
        $vars = array('{id_user}', '{name}', '{sec_code}', '{email}', '{url}');
        $values = array($id_user, $name.' '.$lastname, $sec_code, $email, $url);

     //replace vars
        $body = str_replace($vars,$values,$body);

        //add the html tot the body
        $mail->MsgHTML($body);

        $mail->Body = $body; // Mensaje a enviar
        $exito = $mail->Send(); // Envía el correo.
        $mail->ClearAddresses();  

        if ($exito) {
            echo "true";

        } else {
            echo  "Error: ".$mail->ErrorInfo;
        }
    }
} 

if (!function_exists('get_carrito')) {
    function get_carrito($totaly) {
        
        return $totaly;


    }
}
if (!function_exists('get_nav_categorias')) {
    function get_nav_categorias() {
        global $mysqli;
        
        $query = "SELECT * FROM categorias";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
        echo '<li><a href="productos.php?id='.$row['id'].'">'.$row['nombre'].'</a></li>  ';
        }
        
     
    }
}
if (!function_exists('get_files_url')) {
    function get_files_url($id) {
        global $mysqli;
        $id = $id;

        $query = "SELECT * FROM files WHERE id_producto LIKE '$id' AND id_posicion LIKE 1 ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {

            return $row['files'];
        }

    }
}

//Stock
if (!function_exists('get_stock')) {
    function get_stock($id) {
        global $mysqli;
        $id = $id;
      

        $query = "SELECT * FROM productos WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            if($row['id_status'] == 1 and $row['stock'] != 0 ){
                return '';

            }else  if($row['id_status'] == 0 ) {
                return '<span class="rojo btn btn-danger sin-stock"> SIN STOCK </span>';

            }else  if($row['stock'] == 0 ) {
                return '<span class="rojo btn btn-danger sin-stock"> SIN STOCK </span>';

            }

        }

    }
}
//Stock
if (!function_exists('get_stock_d')) {
    function get_stock_d($id) {
        global $mysqli;
        $id = $id;
      

        $query = "SELECT * FROM productos WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
        
                return '<span class="rojo btn btn-danger sin-stock-d"> SIN STOCK </span>';


         

          

        }

    }
}


// Productos ID
if (!function_exists('get_productos')) {
    function get_productos($id) {
        global $mysqli;
        $id=$id;
        $query = "SELECT * FROM productos WHERE id_categoria LIKE '$id' AND id_activo LIKE 1 ORDER BY id desc ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
                
            echo '			
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 new-collections-grid" style="margin-bottom: 2%;" >
            <div class="new-collections-grid1  unidad-producto" >
            <div class="new-collections-grid1-image">
                <a href="producto-individual.php?id_producto='.$row['id'].'" class="product-image">
                <img src="'.get_files_url($row['id']).'"    alt="'.$row['titulo'].'" class="img-responsive" />
                </a>
            <div class="new-collections-grid1-image-pos">
                <a href="producto-individual.php?id_producto='.$row['id'].'"> Ver Detalle </a>
            </div>
                
            </div>
                
                <h4 class="item_name"> <a href="producto-individual.php?id_producto='.$row['id'].'" >'.$row['titulo'].' </a> </h4>
                <p>'.$row['topico'].'</p>
                <div class="new-collections-grid1-left simpleCart_shelfItem">
                <p> <span class="item_price"> $ '.$row['precio'].'</span>  '.get_stock($row['id']) .'  </p>
               
                
                </div>
                </div>       
            </div>';
            
        }
        
     
    }
}

//Get Galeria de Producto Portada
if (!function_exists('get_files_one')) {
    function get_files_one($id) {
        global $mysqli;
        $id = $id;

        $query = "SELECT * FROM files WHERE id_producto LIKE '$id' AND id_posicion LIKE 1 ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)) {


            echo '<li data-thumb="'.$row['files'].'">
            <div class="thumb-image"> 
             <img src="'.$row['files'].'" data-imagezoom="true" class="img-responsive"> 
            </li> ';
        }

    }
}

//Cancelación de Compra Actualización del stock
if (!function_exists('actualizacion_stock')) {
    function actualizacion_stock($id) {
        global $mysqli;
        $id = $id;
        $sql1=" SELECT * FROM `cart`  WHERE `id_pedido` LIKE '$id' ";
        $result = mysqli_query($mysqli,$sql1);

        while ($row = mysqli_fetch_assoc($result)){
                 
            $stock= $row['itemQty'];
            $id_producto= $row['id_producto'];

            $sql=" SELECT * FROM `productos`  WHERE `id` LIKE '$id_producto' ";
            $result1 = mysqli_query($mysqli,$sql);
            while ($row = mysqli_fetch_assoc($result1)){

                $new_stock= $row['stock']+ $stock;

                $sql22="UPDATE  productos SET stock = '$new_stock'  WHERE `id` LIKE '$id_producto' ";
                mysqli_query($mysqli,$sql22);
                return ;
            }

        }
    }
}


//Cancelación de Compra
if (!function_exists('cancelar_pedido')) {
    function cancelar_pedido($id) {
        global $mysqli;
        $id = $id;
        $sql1=" DELETE FROM `cart`  WHERE `id_pedido` LIKE '$id' ";
         mysqli_query($mysqli,$sql1);

            return;
    }
}

//Get Galeria de Producto
if (!function_exists('get_files_id')) {
    function get_files_id($id) {
        global $mysqli;
        $id = $id;

        $query = "SELECT * FROM files WHERE id_producto LIKE '$id' AND id_posicion != 1 ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)) {


            echo ' <li data-thumb="'.$row['files'].'"><div class="'.$row['files'].'"> 
            <img src="'.$row['files'].'" data-imagezoom="true" class="img-responsive"> 
             </li>';
        }

    }
}
//Get Info Producto
if (!function_exists('get_producto_id')) {
    function get_producto_id($id,$name) {
        global $mysqli;
        $id = $id;
        $name= $name;

        $query = "SELECT * FROM productos WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            if($name ==  $name){
                return $row[$name];
                 }

        }

    }
}
if (!function_exists('get_categoria_id')) {
    function get_categoria_id($id,$name) {
        global $mysqli;
        $id = $id;
        $name= $name;

        $query = "SELECT * FROM categorias WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            if($name ==  $name){
                return $row[$name];
                 }

        }

    }
}
//Datos del Usuario
if (!function_exists('get_user_id')) {
    function get_user_id($id,$name) {
        global $mysqli;
        $id = $id;
        $name= $name;

        $query = "SELECT * FROM usuarios WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            if($name ==  $name){
                return $row[$name];
                 }

        }

    }
}


//Detalle del Pedido

if (!function_exists('get_detalle_pedido')) {
    function get_detalle_pedido($id) {
        global $mysqli;
        $id=$id;
        $returnArr = array();
        
        $query = "SELECT * FROM `cart` WHERE id_pedido LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          
            $returnArr[]= '
     
                
                <p>'.$row['itemName'].' :   $'.$row['itemPrice'].' ... </p>
               

              ';
    }
     return   $returnArr;
  }  
  } 
  //Total Pagado 
if (!function_exists('get_total')) {
    function get_total($id) {
        global $mysqli;
        $id=$id;
        
        $query = "SELECT * FROM `cart` WHERE id_pedido LIKE '$id'  order by id desc LIMIT 1";
        $result = mysqli_query($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          
         return '$'.$row['itemTotal'];
    }
  }  
  } 

  //Datos del Usuario
if (!function_exists('get_mercado_id')) {
    function get_mercado_id($id,$name) {
        global $mysqli;
        $id = $id;
        $name= $name;

        $query = "SELECT * FROM mercadopago WHERE id_pago LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            if($name ==  $name){
                return $row[$name];
                 }

        }

    }
}

//Send Notification MercadoPago
if (!function_exists('send_notification_mercadopago')) {
    function  send_notificacion_mercadopago($id_user, $id_pago, $subject, $cuerpo, $url, $link, $smtp, $userName,$pass, $port,$estado){ 
        global $mysqli;

        $id_user= $id_user;
        $id_pago =$id_pago; // Número de Referencia de Pedido
        $subject = $subject;
        $cuerpo= $cuerpo;
        $estado= $estado;
        //SMTP
        $smtp =$smtp;
        $userName = $userName;
        $pass= $pass;
        $port = $port;
        $url = $url;
        $link = $link;
        //Users
        $name =get_user_info($id_user, 'nombre');
        $lastname =get_user_info($id_user, 'apellido');
        $email =get_user_info($id_user, 'email');

        //Total
        $total= get_total($id_pago);
        foreach(get_detalle_pedido($id_pago) as $value){
            $detalle =$value;
        }
        $id_mercadopago=  get_mercado_id($id_pago,'merchant_order_id');
        //$detalle = get_detalle_pedido($id_pago);
        require("class.phpmailer.php");
        $mail = new PHPMailer();
        //Luego tenemos que iniciar la validación por SMTP:

        $mail -> IsSMTP();
        $mail -> SMTPAuth = true;
        $mail -> Host = $smtp; // SMTP a utilizar. Por ej. smtp.elserver.com
        $mail -> Username =   $userName; // Correo completo a utilizar
        $mail -> Password =$pass; // Contraseña
        $mail -> Port = $port; // Puerto a utilizar

        $mail -> From =   $userName; // Desde donde enviamos (Para mostrar)
        $mail -> FromName = "Notificaciones DG";
        $mail -> AddAddress($email); // Esta es la dirección a donde enviamos
        //$mail->AddCC("cuenta@dominio.com"); 
        // $mail->AddBCC("marianabelgrano@hotmail.com");  Copia oculta para esssaaabel
        $mail -> CharSet = 'UTF-8';
        $mail -> IsHTML(true); // El correo se envía como HTML
        $mail -> Subject = $subject; // Este es el titulo del email.
      

        $body = file_get_contents($cuerpo);
        //$body = preg_replace("[\]",'',$body); setup vars to replace
        $vars = array('{nombre}', '{apellido}', '{detalle}', '{total}', '{id_pago}','{id_mercadopago}','{estado}','{email}','{url}');
        $values = array($name, $lastname , $detalle, $total, $id_pago, $id_mercadopago,$estado ,$email ,$link);

     //replace vars
        $body = str_replace($vars,$values,$body);

        //add the html tot the body
        $mail->MsgHTML($body);

        $mail->Body = $body; // Mensaje a enviar
        $exito = $mail->Send(); // Envía el correo.
        $mail->ClearAddresses();  

        if ($exito) {
            header("Location:../checkout.php?mercadopago=ok");

        } else {
            echo  "Error: ".$mail->ErrorInfo;
        }
    }
} 

// Obtener Imagen de categoria

if (!function_exists('get_file_home')) {
    function get_file_home($id) {
        global $mysqli;
        
        $query = "SELECT * FROM files WHERE id_categoria LIKE '$id'  AND id_posicion LIKE 1";
        $result = mysqli_query($mysqli, $query);


        while ($row = mysqli_fetch_assoc($result)) {
            return $row['files'];
          
              
        }

    }
}
// Categorias home
if (!function_exists('get_categorias_home')) {
    function get_categorias_home() {
        global $mysqli;
      
        $query = "SELECT * FROM categorias ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            $imagen = $row['img_portada'];
            if($imagen == ''){
                $imagen ='productos/sin-imagen.jpg';
            }else{
                $imagen;
            }
           echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
           <div class="banner-bottom-grid-left-grid left1-grid grid-left-grid1" >
            <div class="banner-bottom-grid-left-grid1">
                 <img src="'.$imagen.'" alt="'.$row['nombre'].'" class="img-responsive" /> 
               </div>
                <a href="productos.php?id='.$row['id'].'">  <div class="banner-bottom-grid-left1-position"></div></a>
           </div>
           <div class="titulo-productos">
           <p> '.$row['nombre'].'  </p>
           </div>
           </div>';

        }

    }
}
  //Datos del Usuario
  if (!function_exists('get_id_producto')) {
    function get_id_producto($id,$name) {
        global $mysqli;
        $id = $id;
        $name= $name;

        $query = "SELECT * FROM productos WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            
            if($name ==  $name){
                return $row[$name];
                 }

        }

    }
}

/*
if (!function_exists('get_categorias_nav')) {
    function get_categorias_nav() {
        global $mysqli;
        
        $query = "SELECT * FROM categorias";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
        echo '<li><a href="productos.php?id='.$row['id'].'">'.$row['nombre'].'</a></li>  ';
        }
        

    }
}

//Get categorias Home
if (!function_exists('get_categorias_home')) {
    function get_categorias_home() {
        global $mysqli;
        
        $query = "SELECT * FROM categorias";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
        echo '
        <div class="col-lg-4 col-md-6 service_grid_btm_left">
        <div class="service_grid_btm_left1">
          <img src="'.$row['img_categoria'].'" alt=" " class="img-fluid" />
          <div class="service_grid_btm_left2">
                <h5>'.$row['nombre'].'</h5>
                <p>'.mb_strimwidth($row['copete'], 0, 79,'...').'</p>
                <a href="productos.php?id='.$row['id'].'" class="primary-btn-style btn-primary btn"> Ver Más </a>
                                          
              </div>
                               
        </div>
    </div>';
        }
        

    }
}

if (!function_exists('get_categorias_id')) {
    function get_categorias_id($id, $name) {
        global $mysqli;
        $id=$id;
        $name=$name;
        $query = "SELECT * FROM categorias WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
            if($name ==  $name){
                return $row[$name];
                 }
        }
        

    }
}

//Get Productos por Categoria

if (!function_exists('get_productos_id')) {
    function get_productos_id($id) {
        global $mysqli;
        $id=$id;
        if($id == ''){
            $query = "SELECT * FROM productos ";
        }else{
            $query = "SELECT * FROM productos WHERE id_categoria LIKE '$id' ";
        }
       
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
            echo '
            <div class="col-lg-4 col-md-6 col-sm-6 product-men women_two">
            <div class="product-toys-info">
               <div class="men-pro-item">
                  <div class="men-thumb-item">
                     <img src="'.$row['img_portada'].'" class="img-thumbnail" alt="'.$row['nombre'].'">
                     <div class="men-cart-pro">
                        <div class="inner-men-cart-pro">
                         <a href="producto-ind.php?id='.$row['id'].'" class="link-product-add-cart"> Ver Producto </a>
                        </div>
                     </div>
                 
                  </div>
                  <div class="item-info-product">
                     <div class="info-product-price">
                        <div class="grid_meta">
                           <div class="product_price">
                              <h4>
                               <a href="producto-ind.php">'.$row['nombre'].'</a>
                              </h4>
                              <div class="grid-price mt-2">
                               <span class="money ">$'.$row['precio'].'  Metro</span>
                              </div>
                           </div>
                         
                        </div>
                        <div class="toys single-item hvr-outline-out">
                          
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>';
        }
        

    }
}

//Get Galeria de Producto
if (!function_exists('get_files_id')) {
    function get_files_id($id) {
        global $mysqli;
        $id = $id;

        $query = "SELECT * FROM files WHERE id_producto LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)) {


            echo '  <li data-thumb="'.$row['file'].'">
            <div class="thumb-image"> <img src="'.$row['file'].'" data-imagezoom="true" class="img-fluid" alt=" "> </div>
            </li>';
        }

    }
}

if (!function_exists('get_info_id')) {
    function get_info_id($id, $name) {
        global $mysqli;
        $id=$id;
        $name=$name;
        $query = "SELECT * FROM productos WHERE id LIKE '$id' ";
        $result = mysqli_query($mysqli, $query);
        $total = mysqli_num_rows($mysqli, $query);
        while ($row = mysqli_fetch_assoc($result)){
            if($name ==  $name){
                return $row[$name];
                 }
        }
        

    }
}


// Formulario Presupuesto

if($filename =='presupuesto.php' or $filename =='contacto.php'){

    $captcha='<script src="https://www.google.com/recaptcha/api.js?render=6LdQKMQZAAAAAKAW2L71T3-YsHK3E5YlzPlbHjPq"></script>';
}
*/

?>
