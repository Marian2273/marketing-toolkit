<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "root", "toolkit");
$actual_link = $_SERVER['PHP_SELF'];
$path = parse_url($actual_link , PHP_URL_PATH);
$filename = substr(strrchr($path, "/"), 1);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener el término de búsqueda enviado desde el formulario
$query = $_POST['query'];

// Consulta SQL con protección contra inyecciones SQL
$stmt = $conexion->prepare("SELECT nombre, link, imagen FROM archivos WHERE nombre LIKE ? OR link LIKE ?");
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
                            <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20http://localhost:8888/marketing-toolkit/'.$fila['link'] .'" target="_blank">
                                <img src="img/whatsapp_icon.png" class="compartir" />
                            </a>
                            <a href=""><img src="img/envelope_email_icon.png" class="compartir" /></a>
                            <a href=""><img src="img/fav-negro.png" class="compartir" /></a>
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
