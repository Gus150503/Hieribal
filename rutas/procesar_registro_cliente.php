<?php
session_start();
// require_once __DIR__ . '/../modelo/ModeloCliente.php'; // <- tu modelo si lo usas

try {
  // Datos
  $cedula    = trim($_POST['cedula'] ?? '');
  $nombres   = trim($_POST['nombres'] ?? '');
  $apellidos = trim($_POST['apellidos'] ?? '');
  $telefono  = trim($_POST['telefono'] ?? '');
  $correo    = trim($_POST['correo'] ?? '');
  $pass      = $_POST['contraseña'] ?? '';

  // Validaciones mínimas
  if ($cedula==='' || $nombres==='' || $apellidos==='' || $correo==='' || $pass==='') {
    throw new Exception('Todos los campos obligatorios deben estar completos.');
  }
  if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    throw new Exception('El formato del correo no es válido.');
  }
  if (strlen($pass) < 6) {
    throw new Exception('La contraseña debe tener al menos 6 caracteres.');
  }

  // ----- Guarda en BD (ejemplo) -----
  // $modelo = new ModeloCliente();
  // if ($modelo->correoExiste($correo)) { throw new Exception('Este correo ya está registrado.'); }
  // $hash = password_hash($pass, PASSWORD_DEFAULT);
  // $ok = $modelo->crear([
  //   'cedula'=>$cedula,'nombres'=>$nombres,'apellidos'=>$apellidos,
  //   'telefono'=>$telefono,'correo'=>$correo,'hash'=>$hash
  // ]);
  // if (!$ok) throw new Exception('No se pudo crear la cuenta, intenta nuevamente.');

  // Si llegaste hasta aquí, simulemos OK si no usas modelo
  $ok = true;

  if ($ok) {
    $_SESSION['msg'] = '¡Registro exitoso! Revisa tu correo para activar tu cuenta.';
    // Redirige al login (fuera del iframe). El <form target="_top"> ya ayuda; este fallback fuerza el top.
    header('Location: ../vista/login_cliente.php');
    echo '<script>window.top.location.replace("../vista/login_cliente.php");</script>';
    exit;
  }

  // (en teoría no llega aquí)
  throw new Exception('No se pudo crear la cuenta, intenta nuevamente.');

} catch (Throwable $e) {
  $_SESSION['error_login'] = $e->getMessage();
  $_SESSION['open_registro'] = 1; // reabrir modal al volver
  header('Location: ../vista/login_cliente.php');
  exit;
}
