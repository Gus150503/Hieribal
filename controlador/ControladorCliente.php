<?php
// controlador/ControladorCliente.php
declare(strict_types=1);

require_once __DIR__ . '/ControladorBase.php';
require_once __DIR__ . '/../modelo/ModeloCliente.php';
require_once __DIR__ . '/../servicios/ServicioCorreo.php';

class ControladorCliente extends ControladorBase
{
    private ModeloCliente $modelo;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->modelo = new ModeloCliente();
    }

    /** Registro manual de cliente */
    public function registrar(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->redirigir('../vista/logincliente.php');
        }

        $cedula   = trim($_POST['cedula']        ?? '');
        $nombres  = trim($_POST['nombres']       ?? '');
        $apellidos= trim($_POST['apellidos']     ?? '');
        $telefono = trim($_POST['telefono']      ?? '');
        $correo   = trim($_POST['correo']        ?? '');
        $plainPwd =        $_POST['contraseña']  ?? '';

        // Validaciones mínimas
        if ($cedula === '' || $nombres === '' || $correo === '' || $plainPwd === '') {
            $this->setSesion('error_login', 'Completa los campos obligatorios.');
            $this->redirigir('../vista/registro_cliente.php');
        }

        // Duplicados
        if ($this->modelo->cedulaExiste($cedula)) {
            $this->setSesion('error_login', '⚠️ Ya existe un cliente con esa cédula.');
            $this->redirigir('../vista/registro_cliente.php');
        }
        if ($this->modelo->correoExiste($correo)) {
            $this->setSesion('error_login', '⚠️ Ya existe un cliente con ese correo.');
            $this->redirigir('../vista/registro_cliente.php');
        }

        $token    = bin2hex(random_bytes(32));
        $password = password_hash($plainPwd, PASSWORD_DEFAULT);

        $datos = [
            'cedula'     => $cedula,
            'nombres'    => $nombres,
            'apellidos'  => $apellidos,
            'telefono'   => $telefono,
            'correo'     => $correo,
            'contraseña' => $password,   // ya hasheada
            'token'      => $token,
        ];

        $registrado = $this->modelo->registrarCliente($datos);

        if ($registrado) {
            // Envío de verificación
            ServicioCorreo::enviarVerificacion($correo, $nombres, $token);
            $this->setSesion('msg', '✅ Registro exitoso. Revisa tu correo para activar tu cuenta.');
            $this->redirigir('../vista/logincliente.php');
        } else {
            $this->setSesion('msg', '❌ Error al registrar el cliente.');
            $this->redirigir('../vista/registro_cliente.php');
        }
    }

    /** Login de cliente */
    public function login(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->redirigir('../vista/logincliente.php');
        }

        $correo   = trim($_POST['correo']       ?? '');
        $password =      $_POST['contraseña']   ?? '';
        $recordar = isset($_POST['recordar']);

        if ($correo === '' || $password === '') {
            $this->setSesion('error_login', 'Correo y contraseña son obligatorios.');
            $this->redirigir('../vista/logincliente.php');
        }

        try {
            $cliente = $this->modelo->loginCliente($correo, $password); // array|false

            if (!$cliente) {
                $this->setSesion('error_login', '❌ Correo o contraseña incorrectos.');
                $this->redirigir('../vista/logincliente.php');
            }

            if (($cliente['verificado'] ?? 0) == 0) {
                $this->setSesion('error_login', '⚠️ Debes verificar tu cuenta primero.');
                $this->redirigir('../vista/logincliente.php');
            }

            // Asegura que NO quede sesión de usuario (evita que el router te mande al dashboard)
            unset($_SESSION['usuario']);

            // Guarda sesión de cliente
            $this->setSesion('cliente', [
                'id'      => $cliente['id']      ?? null,
                'nombres' => $cliente['nombres'] ?? '',
                'correo'  => $cliente['correo']  ?? $correo,
            ]);

            // Recuérdame (solo correo)
            if ($recordar) {
                setcookie('cliente_recordado', $cliente['correo'] ?? $correo, [
                    'expires'  => time() + 60 * 60 * 24 * 30,
                    'path'     => '/',
                    'secure'   => !empty($_SERVER['HTTPS']),
                    'httponly' => false, // pon true si NO la lees con JS
                    'samesite' => 'Lax',
                ]);
            } else {
                setcookie('cliente_recordado', '', time() - 3600, '/');
            }

            // Ir a zona de cliente (router)
            $this->redirigir('../app.php?ruta=inicio'); // en app.php -> vista/clientes.php
        } catch (Throwable $e) {
            $this->setSesion('error_login', 'Ocurrió un problema al iniciar sesión.');
            $this->redirigir('../vista/logincliente.php');
        }
    }

    /** Logout de cliente */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Solo limpia cliente; por si usas el mismo navegador para un usuario luego
        unset($_SESSION['cliente']);
        setcookie('cliente_recordado', '', time() - 3600, '/');
        $this->redirigir('../vista/logincliente.php');
    }

    /** Login automático por cookie (si existe y es válido) */
    public function loginAutomaticoPorCookie(string $correo): void
    {
        $correo = trim($correo);
        if ($correo === '') {
            $this->redirigir('../vista/logincliente.php');
        }

        $cliente = $this->modelo->buscarPorCorreo($correo); // ?array
        if ($cliente !== null) {
            // Evita conflicto con sesión de usuario
            unset($_SESSION['usuario']);

            $this->setSesion('cliente', [
                'id'      => $cliente['id']      ?? null,
                'nombres' => $cliente['nombres'] ?? '',
                'correo'  => $cliente['correo']  ?? $correo,
            ]);
            $this->redirigir('../app.php?ruta=inicio'); // clientes
        } else {
            // Cookie inválida → fuera
            setcookie('cliente_recordado', '', time() - 3600, '/');
            $this->redirigir('../vista/logincliente.php');
        }
    }
}
