<?php
require_once '../modelo/ModeloCliente.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $nueva = $_POST['nueva_contraseña'];
    $confirmar = $_POST['confirmar_contraseña'];

    if ($nueva !== $confirmar) {
        $_SESSION['msg'] = "❌ Las contraseñas no coinciden.";
        header("Location: restablecer.php?token=$token");
        exit();
    }

    $modelo = new ModeloCliente();
    $cliente = $modelo->buscarPorToken($token);

    if ($cliente) {
        $hash = password_hash($nueva, PASSWORD_DEFAULT);
        $modelo->actualizarContraseña($cliente['correo'], $hash);

        // Limpiar token
        $modelo->guardarTokenRecuperacion($cliente['correo'], '');


        $_SESSION['msg'] = "✅ Tu contraseña fue actualizada. Inicia sesión.";
        header("Location: login_cliente.php");
        exit();
    } else {
        $_SESSION['msg'] = "❌ Token inválido o expirado.";
        header("Location: restablecer.php?token=$token");
        exit();
    }
}
