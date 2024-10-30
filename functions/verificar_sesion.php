<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_toolkit']) || $_SESSION['user_toolkit'] !== true) {
    // Redirige al login si no está logueado
    header("Location: index.php");
    exit();
}
?>
