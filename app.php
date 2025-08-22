<?php
// app.php
declare(strict_types=1);
session_start();

$ruta = strtolower($_GET['ruta'] ?? 'inicio');

$esUsuario = isset($_SESSION['usuario']); // admin/empleado
$esCliente = isset($_SESSION['cliente']); // cliente

// Si no hay sesión -> login de cliente (puedes cambiarlo a un selector)
if (!$esUsuario && !$esCliente) {
  header('Location: vista/login_cliente.php');
  exit;
}

// Listas blancas
$routesUsuario = [
  'inicio'   => 'vista/dashboard.php',
  'usuarios' => 'vista/usuarios.php',
  'clientes' => 'vista/clientes_admin.php',
  'logout'   => 'vista/logout.php',
];

$routesCliente = [
  'inicio'  => 'vista/clientes.php',
  'perfil'  => 'vista/registro_cliente.php',
  'carrito' => 'vista/carrito_compras.php',
  'logout'  => 'vista/logout_cliente.php',
];

// Resolver vista
$view = $esUsuario
  ? ($routesUsuario[$ruta] ?? 'vista/404.php')
  : ($routesCliente[$ruta] ?? 'vista/404.php');

require $view;
