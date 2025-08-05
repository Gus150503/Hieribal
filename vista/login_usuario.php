<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Usuario - Hieribal</title>
    <link rel="stylesheet" href="../assets/css/estilo_usuario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="login-wrapper">
    <!-- Panel izquierdo -->
    <div class="left-panel">
        <img src="../assets/img/logo.png" alt="Logo Hieribal">
        <h1>Hieribal - Usuarios</h1>
        <p>Inicio de sesión para administradores, empleados y cajeros.</p>
    </div>

    <!-- Panel derecho con formulario -->
    <div class="right-panel">
        <form method="POST" action="../rutas/procesar_login_usuario.php" class="login-box">

            <h3 class="mb-4 text-center">Iniciar sesión</h3>

            <!-- Mensaje de error -->
            <?php if (isset($_SESSION['error_login'])): ?>
                <div class="error-msg" id="error-msg">
                    <?= $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
                </div>
            <?php endif; ?>

            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>

            <div class="position-relative">
                <input type="password" name="contraseña" id="password" class="form-control" placeholder="Contraseña" required>
                <i class="bi bi-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <div class="text-end mb-3">
                <a href="olvide_contraseña_usuario.php">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const icon = document.querySelector('.toggle-password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
}

// Ocultar mensaje de error automáticamente
window.addEventListener('DOMContentLoaded', () => {
    const errorMsg = document.getElementById('error-msg');
    if (errorMsg) {
        setTimeout(() => {
            errorMsg.style.opacity = '0';
            setTimeout(() => {
                errorMsg.remove();
            }, 1000);
        }, 5000);
    }
});
</script>
</body>
</html>


