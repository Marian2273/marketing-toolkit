<?php
session_start();

// Limpiar sesión y eliminar cookie al cerrar sesión
$_SESSION = [];
session_unset();
session_destroy();
setcookie(session_name(), '', time() - 3600, '/');

// Redirigir al login u otra página al cerrar sesión
header("Location: ../index.php");
exit();
?>
