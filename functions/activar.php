<?php     

include("../config/connect1.php"); 

$id = (int)$_GET['id'];

// Agregamos validación y prepared statement para mayor seguridad
if (!empty($id)) {
    $sql = "UPDATE usuarios SET id_activo = 1 WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header('Location: exito.php?data=activo');
        exit();
    } else {
        echo "Error en la actualización: " . $mysqli->error;
    }
} else {
    echo "ID no válido";
}