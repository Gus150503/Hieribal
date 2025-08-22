<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) session_start();

$ruta = strtolower($_GET['ruta'] ?? 'inicio');

$esUsuario = isset($_SESSION['usuario']);
$esCliente = isset($_SESSION['cliente']);

// Si por error hay ambas sesiones, prioriza cliente (o la que prefieras)
if ($esUsuario && $esCliente) {
  // elige una estrategia:
  // unset($_SESSION['usuario']);  // priorizar cliente
  // o unset($_SESSION['cliente']); // priorizar usuario
  $esUsuario = isset($_SESSION['usuario']);
  $esCliente = isset($_SESSION['cliente']);
}

if (!$esUsuario && !$esCliente) {
  header('Location: vista/login_cliente.php');
  exit;
}

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

$view = $esUsuario
  ? ($routesUsuario[$ruta] ?? 'vista/404.php')
  : ($routesCliente[$ruta] ?? 'vista/404.php');

require $view;
