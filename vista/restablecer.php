<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$token = $_GET['token'] ?? null;
if (!$token) {
    header("Location: login_cliente.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>
    <link rel="stylesheet" href="../assets/css/estilo_cliente.css">
    <style>
        .reset-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            font-family: 'Inter', sans-serif;
        }

        .reset-container h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .reset-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .reset-container button {
            width: 100%;
            padding: 12px;
            background: black;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .msg {
            color: #d60000;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="reset-container">
    <h2>Restablecer contraseña</h2>
    <form action="guardar_nueva_contraseña.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="password" name="nueva_contraseña" placeholder="Nueva contraseña" required>
        <input type="password" name="confirmar_contraseña" placeholder="Confirmar contraseña" required>
        <button type="submit">Guardar nueva contraseña</button>
    </form>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="msg"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>
</div>
</body>
</html>
