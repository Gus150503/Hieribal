<?php
session_start();

// Elimina todos los datos de sesión
session_unset();
session_destroy();

// Borra la cookie de "recordarme"
setcookie('cliente_recordado', '', time() - 3600, "/");

// Redirige al login del cliente
header("Location: login_cliente.php");
exit();
