<?php
require_once __DIR__ . '/ControladorBase.php';
require_once __DIR__ . '/../modelo/ModeloUsuario.php';

class ControladorUsuario extends ControladorBase {
    private $modelo;

    public function __construct() {
        $this->modelo = new ModeloUsuario();
    }

    public function login(): void {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirigir("../vista/login_usuario.php");
        }

        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        $user = $this->modelo->loginUsuario($usuario, $password);

        if (!$user) {
            $this->setSesion('error_login', "❌ Usuario o contraseña incorrectos.");
            $this->redirigir("../vista/login_usuario.php");
        }

        if ($user['estado'] !== 'Activo') {
            $this->setSesion('error_login', "⚠️ Tu cuenta está inactiva. Contacta al administrador.");
            $this->redirigir("../vista/login_usuario.php");
        }

        $this->setSesion('usuario', $user);
        $this->redirigir("../vista/dashboard.php");
    }
}
