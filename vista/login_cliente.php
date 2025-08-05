<?php
session_start();
$error = $_SESSION['error_login'] ?? null;
$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['error_login'], $_SESSION['msg']);
$correoRecordado = $_COOKIE['cliente_recordado'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Cliente</title>
    <link rel="stylesheet" href="../assets/css/estilo_cliente.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="left-panel">
        <img src="../assets/img/logo.png" class="logo" alt="Logo">

        <div class="form-content">
            <h2>Ingresa sesión</h2>
            <p>Por favor ingresa tus credenciales</p>

            <?php if ($error): ?>
                <div class="error-msg" id="error-msg"><?= $error ?></div>
            <?php endif; ?>

            <?php if ($msg): ?>
                <div class="success-msg" id="general-msg"><?= $msg ?></div>
            <?php endif; ?>

            <a href="google_login.php" class="google-btn">
                <img src="../assets/img/google.png" alt="Google icon">
                <span>Regístrate con Google</span>
            </a>

            <div class="separator"><span>O</span></div>

            <form method="POST" action="../rutas/procesar_login_cliente.php">
                <input type="email" name="correo" placeholder="Email address" value="<?= htmlspecialchars($correoRecordado) ?>" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>

                <div class="extras">
                    <label><input type="checkbox" name="recordar"> Recuérdame por 30 días</label>
                    <a href="olvide_contraseña.php">Olvidé mi contraseña</a>
                </div>

                <button type="submit" class="submit-btn">Ingresar</button>
            </form>

            <p class="bottom-link">¿No tienes una cuenta? <a href="registro_cliente.php">Regístrate aquí</a></p>
        </div>
    </div>

    <div class="right-panel">
        <video autoplay muted loop playsinline>
            <source src="../assets/video/video.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>
</div>

<!-- Tu script para animaciones sigue intacto -->
</body>
</html>
