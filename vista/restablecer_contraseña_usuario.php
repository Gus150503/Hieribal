<?php
session_start();
require_once '../modelo/ModeloUsuario.php';

// Verificar que haya token
$token = $_GET['token'] ?? null;

if (!$token) {
    $_SESSION['msg'] = "⚠️ Token inválido o expirado.";
    header("Location: olvide_contraseña_usuario.php");
    exit();
}

$modelo = new ModeloUsuario();
$usuario = $modelo->verificarToken($token);

if (!$usuario) {
    $_SESSION['msg'] = "⚠️ Token no válido o ya usado.";
    header("Location: olvide_contraseña_usuario.php");
    exit();
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = $_POST['nueva'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (empty($nueva) || empty($confirmar)) {
        $error = "❌ Todos los campos son obligatorios.";
    } elseif ($nueva !== $confirmar) {
        $error = "❌ Las contraseñas no coinciden.";
    } else {
        // Guardar nueva contraseña
        $modelo->actualizarContraseñaConToken($token, $nueva);
        $_SESSION['msg'] = "✅ Contraseña actualizada. Inicia sesión.";
        header("Location: login_usuario.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../assets/css/estilo_usuario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">
    <div class="left-panel">
        <img src="../assets/img/logo.png" alt="Logo Hieribal">
        <h1>Restablece tu contraseña</h1>
        <p>Ingresa y confirma tu nueva contraseña.</p>
    </div>

    <div class="right-panel">
        <form method="POST" class="login-box">
            <h3 class="mb-4 text-center">Nueva contraseña</h3>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>

            <input type="password" name="nueva" class="form-control mb-3" placeholder="Nueva contraseña" required>
            <input type="password" name="confirmar" class="form-control mb-3" placeholder="Confirmar contraseña" required>

            <button type="submit" class="btn btn-primary w-100">Actualizar contraseña</button>

            <div class="text-center mt-3">
                <a href="login_usuario.php">Volver al inicio de sesión</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
