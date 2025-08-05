<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña - Usuario</title>
    <link rel="stylesheet" href="../assets/css/estilo_usuario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">
    <!-- Panel izquierdo -->
    <div class="left-panel">
        <img src="../assets/img/logo.png" alt="Logo Hieribal">
        <h1>¿Olvidaste tu contraseña?</h1>
        <p>Ingresa tu correo registrado para recuperar el acceso.</p>
    </div>

    <!-- Panel derecho con formulario -->
    <div class="right-panel">
        <form method="POST" action="../rutas/enviar_token_usuario.php" class="login-box">
            <h3 class="mb-4 text-center">Recuperar contraseña</h3>

            <?php if (isset($_SESSION['msg'])): ?>
                <div class="alert alert-info text-center">
                    <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
                </div>
            <?php endif; ?>

            <input type="email" name="correo" class="form-control mb-3" placeholder="Correo electrónico" required>

            <button type="submit" class="btn btn-primary w-100">Enviar enlace</button>

            <div class="text-center mt-3">
                <a href="login_usuario.php">Volver al inicio de sesión</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
