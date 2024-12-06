<?php
include("config/connect.php"); 
$conn = new mysqli($config['servername'],$config['username'],$config['password'],$config['dbname']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ... tu código que usa la conexión a la base de datos ...

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $postId = $data['postId'];
    $userId = $data['userId'];
    $liked = $data['liked'];

    // Verifica si el usuario ya dio like
    $stmt = $conn->prepare("SELECT * FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param('ii', $postId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si existe, actualiza el like
        $stmt = $conn->prepare("UPDATE likes SET liked = ? WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param('iii', $liked, $postId, $userId);
    } else {
        // Si no existe, inserta un nuevo like
        $stmt = $conn->prepare("INSERT INTO likes (user_id, post_id, liked) VALUES (?, ?, ?)");
        $stmt->bind_param('iii', $userId, $postId, $liked);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
