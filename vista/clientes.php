<?php
session_start();
$cliente = $_SESSION['cliente'] ?? null;

if (!$cliente) {
    header("Location: login_cliente.php");
    exit;
}

// 1) Contenido de la página (solo HTML del body)
ob_start();
?>
<div class="panel-cliente container py-4">
  <h2>Bienvenido, <?= htmlspecialchars($cliente['nombres'], ENT_QUOTES, 'UTF-8') ?>!</h2>
  <p>Tu correo es: <?= htmlspecialchars($cliente['correo'], ENT_QUOTES, 'UTF-8') ?></p>

  <a class="btn btn-outline-danger mt-3" href="logout_cliente.php">
    Cerrar sesión
  </a>
</div>
<?php
$content   = ob_get_clean();

// 2) Identificadores para la plantilla
$title     = 'Panel de Cliente';
$bodyClass = 'page-clientes';
$pageKey   = 'clientes'; // <-- usará los CSS/JS que registraste para 'clientes' en plantilla.php

// (opcional) Datos para JS por si luego necesitas algo
$pageData = [];

// 3) Renderizar con la plantilla (ella imprime <link> y <script>)
include __DIR__ . '/../vista/plantilla.php';
