<?php
// vista/plantilla.php
$PAGE_TITLE = $PAGE_TITLE ?? 'HIERIBAL';
$VIEW_FILE  = $VIEW_FILE  ?? __DIR__ . '/404.php';

$HEADER  = __DIR__ . '/partials/header.php';
$SIDEBAR = __DIR__ . '/partials/sidebar.php';
$FOOTER  = __DIR__ . '/partials/footer.php';

// Ajusta BASE a tu carpeta en XAMPP (p.ej. /Hieribal). Si está en raíz, usa ''.
$BASE = '/Hieribal';
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($PAGE_TITLE) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= $BASE ?>/assets/css/index.css">
</head>
<body>

  <?php if (is_file($HEADER))  include $HEADER; ?>
  <?php if (is_file($SIDEBAR)) include $SIDEBAR; ?>

  <main class="content-wrapper" style="padding:16px;">
    <?php include (is_file($VIEW_FILE) ? $VIEW_FILE : __DIR__.'/404.php'); ?>
  </main>

  <?php if (is_file($FOOTER)) include $FOOTER; ?>

</body>
</html>
