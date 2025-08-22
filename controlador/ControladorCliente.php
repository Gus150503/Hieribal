<?php
require_once __DIR__ . '/ControladorBase.php';
require_once __DIR__ . '/../modelo/ModeloCliente.php';
require_once __DIR__ . '/../servicios/ServicioCorreo.php';

class ControladorCliente extends ControladorBase {
    private $modelo;

    public function __construct() {
        $this->modelo = new ModeloCliente();
    }

    public function registrar() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $this->redirigir("../vista/login_cliente.php");
    }

    $cedula   = $_POST['cedula'];
    $correo   = $_POST['correo'];

    // Validar duplicados antes de intentar registrar
    if ($this->modelo->cedulaExiste($cedula)) {
        $this->setSesion('error_login', "⚠️ Ya existe un cliente con esa cédula.");
        $this->redirigir("../vista/registro_cliente.php");
    }

    if ($this->modelo->correoExiste($correo)) {
        $this->setSesion('error_login', "⚠️ Ya existe un cliente con ese correo.");
        $this->redirigir("../vista/registro_cliente.php");
    }

    $token    = bin2hex(random_bytes(32));
    $password = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    $datos = [
        'cedula'     => $cedula,
        'nombres'    => $_POST['nombres'],
        'apellidos'  => $_POST['apellidos'],
        'telefono'   => $_POST['telefono'],
        'correo'     => $correo,
        'contraseña' => $password,
        'token'      => $token
    ];

    $registrado = $this->modelo->registrarCliente($datos);

    if ($registrado) {
        ServicioCorreo::enviarVerificacion($correo, $datos['nombres'], $token);
        $this->setSesion('msg', "✅ Registro exitoso. Revisa tu correo para activar tu cuenta.");
        $this->redirigir("../vista/login_cliente.php");
    } else {
        $this->setSesion('msg', "❌ Error al registrar el cliente.");
        $this->redirigir("../vista/registro_cliente.php");
    }
}


    public function login() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redirigir("../vista/login_cliente.php");
        }

        $correo = $_POST['correo'];
        $password = $_POST['contraseña'];

        $cliente = $this->modelo->loginCliente($correo, $password);

        if (!$cliente) {
            $this->setSesion('error_login', "❌ Correo o contraseña incorrectos.");
            $this->redirigir("../vista/login_cliente.php");
        }

        if ($cliente['verificado'] == 0) {
            $this->setSesion('error_login', "⚠️ Debes verificar tu cuenta primero.");
            $this->redirigir("../vista/login_cliente.php");
        }

        $this->setSesion('cliente', $cliente);
if (isset($_POST['recordar'])) {
    setcookie('cliente_recordado', $correo, [
        'expires'  => time() + 86400*30,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']), // true si usas HTTPS
        'httponly' => false,                     // pon true si NO la lees con JS
        'samesite' => 'Lax',
    ]);
}


        $this->redirigir("../app.php?ruta=inicio");
    }

 public function logout() {
    $this->destruirSesion();
    setcookie('cliente_recordado', '', time() - 3600, "/");
    $this->redirigir("../index.php"); // mejor a la portada
}


    

    public function loginAutomaticoPorCookie($correo) {
    $cliente = $this->modelo->buscarPorCorreo($correo);
    if ($cliente) {
        $this->setSesion('cliente', $cliente);
       $this->redirigir("../app.php?ruta=inicio");
    }
}


}
