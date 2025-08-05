<?php
session_start();
$cliente = $_SESSION['cliente'] ?? null;

if (!$cliente) {
    header("Location: login_cliente.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="../assets/css/estilo_cliente.css">
</head>
<body>
    <div class="panel-cliente">
        <h2>Bienvenido, <?= htmlspecialchars($cliente['nombres']) ?>!</h2>
        <p>Tu correo es: <?= htmlspecialchars($cliente['correo']) ?></p>

        <a href="logout_cliente.php">Cerrar sesión</a>
    </div>
</body>
</html>
