<?php
session_start();
$user_toolkit=$_SESSION["user_toolkit"];
error_reporting(0);
// Conexión a la base de datos
//$conexion = new mysqli("localhost", "root", "root", "toolkit");
$conexion = new mysqli('localhost', 'canisped_user_toolkit', 'Toolkit4ever!', 'canisped_toolkit');
//$url= 'http://localhost:8888/';
$url= 'https://freecanelo.com.ar/';

$actual_link = $_SERVER['PHP_SELF'];
$path = parse_url($actual_link , PHP_URL_PATH);
$filename = substr(strrchr($path, "/"), 1);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el término de búsqueda enviado desde el formulario
$query = $_POST['query'];

// Consulta SQL con protección contra inyecciones SQL
$stmt = $conexion->prepare("SELECT  id,nombre, link, imagen FROM archivos WHERE nombre LIKE ? OR link LIKE ?");
$busqueda = '%' . $query . '%';
$stmt->bind_param('ss', $busqueda, $busqueda);
$stmt->execute();
$resultado = $stmt->get_result();

// Mostrar resultados
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
     echo '    <div class="promo-item" >
                  
                    <div class="promo-info">
                        <img src="'.$fila['imagen'] .'" class="img-responsive" />
                        <p>'. $fila['nombre'] .'</p>
                        <div class="seccion-compartir">
                    <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20'.$url.'/marketing-toolkit/'.$fila['link'] .'" target="_blank">
                        <img src="img/whatsapp_icon.png" class="compartir" />
                    </a>
                     <a href="mailto:?subject=Te Comparto este Artículo&body=' . urlencode($url.'/marketing-toolkit/'. $fila['link']) . '" target="_blank"><img src="img/envelope_email_icon.png" class="compartir" /></a>
                    <button class="like-btn" id="like-btn" data-postid="'. $fila['id'] .'" data-userid="'. $user_toolkit .'">
                    <span id="heart" class="heart las la-heart"> </span> <!-- Corazón vacío -->
                    </button>

                </div>
                    </div>
                </div>';
       
    }
} else {
    echo "No se encontraron resultados.";
}

$stmt->close();
$conexion->close();
?>
