<?php
// vista/clientes.php  (nombre sugerido según tu router)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cliente = $_SESSION['cliente'] ?? null;
if (!$cliente) {
    // ojo con la ruta: estamos en /vista/
    header('Location: ' . __DIR__ . '/logincliente.php'); // si usas logincliente.php en /vista/
    exit;
}

// 1) Contenido de la página (solo HTML del body)
ob_start();
?>
<div class="panel-cliente container py-4">
  <h2>Bienvenido, <?= htmlspecialchars($cliente['nombres'] ?? '', ENT_QUOTES, 'UTF-8') ?>!</h2>
  <p>Tu correo es: <?= htmlspecialchars($cliente['correo'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

  <!-- Usa el router para cerrar sesión del cliente -->
  <a class="btn btn-outline-danger mt-3" href="../app.php?ruta=logout">
    Cerrar sesión
  </a>
</div>
<?php
$content   = ob_get_clean();

/*
  2) Identificadores para la plantilla
  Tu app.php enruta 'inicio' -> vista/clientes.php (para clientes)
  Si la plantilla muestra 404 cuando $pageKey no está en su lista,
  usa el mismo key que espera la plantilla para esta vista.
*/
$title     = 'Panel de Cliente';
$bodyClass = 'page-clientes';

/* IMPORTANTE:
   Si tu plantilla espera 'inicio' para la página principal,
   usa 'inicio' aquí para que no muestre 404.
   Si tu plantilla sí tiene una entrada 'clientes', deja 'clientes'.
*/
$pageKey   = 'inicio';   // <-- cámbialo a 'clientes' si tu plantilla lo reconoce

// (opcional) Datos para JS
$pageData = [];

// 3) Renderizar con la plantilla
// Si plantilla.php está en la misma carpeta /vista/, la ruta correcta es:
require __DIR__ . '/plantilla.php';
