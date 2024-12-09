<?php
session_start();
include("config/connect.php"); 

$host = $config['servername'];
$user = $config['username'];
$password = $config['password'];
$dbname = $config['dbname'];

$url = $config['url'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica si `id_categoria` existe en GET y si `userId` está en la sesión
    if (isset($_GET['id_categoria']) && isset($_SESSION["user_toolkit"])) {
        $idCategoria = $_GET['id_categoria'];
        $userId = $_SESSION["user_toolkit"];

        // Consulta con `LEFT JOIN` para incluir los likes
        $stmt = $pdo->prepare("
            SELECT a.*, 
                   IFNULL(l.liked, 0) AS liked
            FROM archivos a
            LEFT JOIN likes l ON a.id = l.post_id AND l.user_id = :userId
            WHERE a.id_categoria LIKE :idCategoria
        ");
        $stmt->execute([
            ':userId' => $userId,
            ':idCategoria' => "%$idCategoria%"
        ]);

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Genera la salida
        if ($resultados) {
            foreach ($resultados as $fila) {
                $archivo_id = htmlspecialchars($fila['id'], ENT_QUOTES, 'UTF-8');
                $nombre = htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8');
                $link = htmlspecialchars($fila['link'], ENT_QUOTES, 'UTF-8');
                $imagen = htmlspecialchars($fila['imagen'], ENT_QUOTES, 'UTF-8');
                $liked = (int)$fila['liked'];

             
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
                    <button class="like-btn" data-postid="' . $archivo_id . '" data-userid="' . $userId . '">
                        <span class="heart las la-heart ' . ($liked === 1 ? 'liked' : '') . '"></span>
                    </button>
                </div>
            </div>
        </div>';
            }
        } else {
            echo "<p>No se encontraron resultados.</p>";
        }
    } else {
        echo "<p>Faltan los parámetros id_categoria o userId.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error al conectar a la base de datos: " . $e->getMessage() . "</p>";
}
?>
<script>
   // Selecciona todos los botones de "like" en la página
        document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
        const heart = this.querySelector('.heart');
        const postId = this.getAttribute('data-postid');
        const userId = this.getAttribute('data-userid');

        // Cambia el estado visual del like
        heart.classList.toggle('liked');

        // Define el estado de "liked" (1 si está liked, 0 si no)
        const liked = heart.classList.contains('liked') ? 1 : 0;

        // Envía la información al servidor
        fetch('like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId, userId, liked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(`Like actualizado para post ${postId}`);
            } else {
                console.error('Error al actualizar el like');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

</script>  