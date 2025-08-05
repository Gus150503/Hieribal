<?php
session_start();
$success = $_SESSION['msg'] ?? null;
$error = $_SESSION['error_login'] ?? null;
unset($_SESSION['msg'], $_SESSION['error_login']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Estilos igual que antes */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .registro-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #111;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
        }

        .msg {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            opacity: 1;
            transition: opacity 1s ease;
        }

        .success-msg {
            background-color: #e6f9ec;
            color: #027a48;
            border: 1px solid #22c55e;
        }

        .error-msg {
            background-color: #ffe6e6;
            color: #d60000;
            border: 1px solid #d60000;
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <h2>Registro de Cliente</h2>

        <?php if ($success): ?>
            <div class="msg success-msg" id="auto-hide"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="msg error-msg" id="auto-hide"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="../rutas/procesar_registro_cliente.php">
            <input type="text" name="cedula" placeholder="Cédula" required>
            <input type="text" name="nombres" placeholder="Nombres" required>
            <input type="text" name="apellidos" placeholder="Apellidos" required>
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">Registrar</button>
        </form>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const msg = document.getElementById('auto-hide');
            if (msg) {
                setTimeout(() => {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 1000);
                }, 3000);
            }
        });
    </script>
</body>
</html>
