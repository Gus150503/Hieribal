<?php
require_once 'google_config.php';
require_once '../modelo/ModeloCliente.php'; // Ajusta el path si es diferente

if (isset($_GET['code'])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);

        // Obtener perfil de usuario
        $google_oauth = new Google_Service_Oauth2($google_client);
        $info = $google_oauth->userinfo->get();

        $correo = $info->email;
        $nombre = $info->name;

        // Buscar o registrar cliente
        $modelo = new ModeloCliente();
        $cliente = $modelo->buscarPorCorreo($correo);

        if (!$cliente) {
            // Registrar nuevo cliente sin contraseña
            $modelo->registrarClienteGoogle($nombre, $correo);
            $cliente = $modelo->buscarPorCorreo($correo);
        }

        // Iniciar sesión
        session_start();
        $_SESSION['cliente'] = $cliente;

        header('Location: clientes.php');
        exit();
    }
}

header('Location: login_cliente.php');
exit();
