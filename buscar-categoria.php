<?php
error_reporting(0);
include("config/connect.php"); 
$host=$config['servername'];
$user=$config['username'];
$password=$config['password'];
$dbname=$config['dbname'];

$url =$config['url'];
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica si se recibió id_categoria
    if (isset($_GET['id_categoria'])) {
        $idCategoria = $_GET['id_categoria'];

        // Consulta a la base de datos
        $stmt = $pdo->prepare("SELECT * FROM archivos WHERE id_categoria LIKE ?");
        $stmt->execute(["%$idCategoria%"]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Genera la salida
        if ($resultados) {
            foreach ($resultados as $fila) {
                
                echo ' 
                 <div class="promo-item" >
                  
                    <div class="promo-info">
                        <img src="'.$fila['imagen'] .'" class="img-responsive" />
                        <p>'. $fila['nombre'] .'</p>
                        <div class="seccion-compartir">
                    <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20'.$url.'/'.$fila['link'] .'" target="_blank">
                        <img src="img/whatsapp_icon.png" class="compartir" />
                    </a>
                     <a href="mailto:?subject=Te Comparto este Artículo&body=' . urlencode($url.'/'.$fila['link']) . '" target="_blank"><img src="img/envelope_email_icon.png" class="compartir" /></a>
                    <button class="like-btn" id="like-btn" data-postid="'. $fila['id'] .'" data-userid="'. $user_toolkit .'">
                    <span id="heart" class="heart las la-heart"> </span> <!-- Corazón vacío -->
                    </button>

                </div>
                    </div>
                </div>';
                
               
            }
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
    } else {
        echo "<p>Falta el parámetro id_categoria.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error al conectar a la base de datos: " . $e->getMessage() . "</p>";
}
?>
