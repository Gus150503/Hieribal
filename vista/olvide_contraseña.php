<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../assets/css/estilo_cliente.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .recover-container {
            max-width: 400px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            font-family: 'Inter', sans-serif;
        }

        .recover-container h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .recover-container p {
            font-size: 14px;
            color: #555;
        }

        .recover-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .recover-container button {
            width: 100%;
            padding: 12px;
            background: black;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .recover-container .msg {
            margin-top: 15px;
            font-size: 14px;
            color: #d60000;
            text-align: center;
        }

        .recover-container a {
            font-size: 13px;
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="recover-container">
    <h2>Recuperar contraseña</h2>
    <p>Introduce tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

    <form action="enviar_token.php" method="POST">
        <input type="email" name="correo" placeholder="Correo registrado" required>
        <button type="submit">Enviar enlace</button>
    </form>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="msg"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <a href="login_cliente.php">← Volver al inicio de sesión</a>
</div>
</body>
</html>
