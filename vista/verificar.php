<?php
require_once '../modelo/ModeloCliente.php';
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $modelo = new ModeloCliente();
    $exito = $modelo->verificarCuenta($token);

    if ($exito) {
        $_SESSION['msg'] = "✅ ¡Tu cuenta ha sido verificada con éxito! Ya puedes iniciar sesión.";
    } else {
        $_SESSION['msg'] = "❌ Token inválido o la cuenta ya fue verificada.";
    }
} else {
    $_SESSION['msg'] = "⚠️ No se proporcionó ningún token.";
}

header("Location: login_cliente.php");
exit();
