<?php
session_start();
$error        = $_SESSION['error_login'] ?? null;
$msg          = $_SESSION['msg'] ?? null;
$openRegistro = $_SESSION['open_registro'] ?? null; // reabrir modal si falló el registro
unset($_SESSION['error_login'], $_SESSION['msg'], $_SESSION['open_registro']);

$correoRecordado = $_COOKIE['cliente_recordado'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión - Cliente</title>
  <link rel="stylesheet" href="../assets/css/estilo_cliente.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* ===== Modal ===== */
    dialog.modal{
      position: fixed; top:50%; left:50%; transform: translate(-50%,-50%);
      border: none; padding: 0; margin: 0;
      width: min(92vw, 980px); max-height: 90vh;
      border-radius: 18px; overflow: hidden;
      box-shadow: 0 30px 80px rgba(0,0,0,.35);
      background: transparent;
    }
    dialog.modal::backdrop{
      background: rgba(0,0,0,.45);
      backdrop-filter: blur(4px);
    }
    .modal-head{ position:absolute; right:10px; top:10px; z-index:2; }
    .modal-close{
      border: 0; background: #0f2418; color: #fff; opacity:.9;
      width:36px; height:36px; border-radius:10px; cursor:pointer;
    }
    .modal-iframe{
      display:block; width:100%; border:0; background:#fff; /* altura se ajusta por JS */
    }
    /* Bloquea scroll del fondo en navegadores que soportan :has */
    html:has(dialog[open]){ overflow:hidden; }
    @media (max-width:768px){
      /* no fijes height aquí; si acaso limita el máximo */
      .modal-iframe{ max-height: 85vh; }
    }
  </style>
</head>
<body>
<div class="container">
  <div class="left-panel">
    <img src="../assets/img/logo.png" class="logo" alt="Logo">

    <div class="form-content">
      <h2>Ingresa sesión</h2>
      <p>Por favor ingresa tus credenciales</p>

      <?php if ($error): ?>
        <div class="error-msg" id="error-msg"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <?php if ($msg): ?>
        <div class="success-msg" id="general-msg"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <a href="google_login.php" class="google-btn">
        <img src="../assets/img/google.png" alt="Google icon">
        <span>Regístrate con Google</span>
      </a>

      <div class="separator"><span>O</span></div>

      <form method="POST" action="../rutas/procesar_login_cliente.php">
        <input type="email" name="correo" placeholder="Email address" value="<?= htmlspecialchars($correoRecordado) ?>" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>

        <div class="extras">
          <label><input type="checkbox" name="recordar"> Recuérdame por 30 días</label>
          <a href="olvide_contraseña.php">Olvidé mi contraseña</a>
        </div>

        <button type="submit" class="submit-btn">Ingresar</button>
      </form>

      <p class="bottom-link">¿No tienes una cuenta?
        <a href="#" id="openRegistroBtn">Regístrate aquí</a>
      </p>
    </div>
  </div>

  <div class="right-panel">
    <video autoplay muted loop playsinline>
      <source src="../assets/video/video.mp4" type="video/mp4">
      Tu navegador no soporta el video.
    </video>
  </div>
</div>

<!-- ===== Modal (iframe con la página de registro) ===== -->
<dialog id="registroModal" class="modal" aria-label="Registro de cliente">
  <div class="modal-head">
    <button type="button" class="modal-close" id="closeRegistroBtn" aria-label="Cerrar">✕</button>
  </div>
  <iframe
    id="registroIframe"
    class="modal-iframe"
    src="registro_cliente.php?embed=1"
    style="height: 600px;"  <!-- fallback visible, el JS lo ajusta -->
  ></iframe>
</dialog>

<script>
(function(){
  const openBtn  = document.getElementById('openRegistroBtn');
  const closeBtn = document.getElementById('closeRegistroBtn');
  const modal    = document.getElementById('registroModal');

  function openModal(e){
    if (e) e.preventDefault();
    // Fallback para navegadores sin :has
    document.documentElement.style.overflow = 'hidden';
    modal.showModal();
  }
  function closeModal(){
    modal.close();
    document.documentElement.style.overflow = ''; // quita bloqueo de scroll
  }

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);

  // Cerrar con clic fuera del cuadro
  modal?.addEventListener('click', (e)=>{
    const rect = modal.getBoundingClientRect();
    const inDialog = (
      e.clientX >= rect.left && e.clientX <= rect.right &&
      e.clientY >= rect.top  && e.clientY <= rect.bottom
    );
    if (!inDialog) closeModal();
  });

  // Reabrir modal SOLO si hubo error de registro
  <?php if ($openRegistro): ?>
    window.addEventListener('load', () => openModal());
  <?php endif; ?>
})();
</script>

<!-- ===== Auto-ajuste de altura del iframe (elimina el hueco inferior) ===== -->
<script>
(function(){
  const iframe = document.getElementById('registroIframe');
  const MAX = () => Math.floor(window.innerHeight * 0.90);

  function fitByReadingChild(){
    if (!iframe) return;
    try {
      const doc  = iframe.contentDocument || iframe.contentWindow.document;
      if (!doc) return;
      const body = doc.body, html = doc.documentElement;
      const h = Math.max(
        body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight
      );
      iframe.style.height = Math.min(h, MAX()) + 'px';
    } catch(e){ /* mismo origen: debería funcionar sin errores */ }
  }

  // Recibe altura enviada por el hijo (registro_cliente.php)
  window.addEventListener('message', (ev)=>{
    if (ev.origin !== window.location.origin) return;
    if (ev.data && ev.data.type === 'registro-size') {
      const h = parseInt(ev.data.height, 10) || 600;
      iframe.style.height = Math.min(h, MAX()) + 'px';
    }
  });

  // Al cargar el iframe, mide y pide medida al hijo
  iframe?.addEventListener('load', ()=>{
    fitByReadingChild();
    try {
      iframe.contentWindow.postMessage({type:'get-size'}, window.location.origin);
    } catch(e){}
    setTimeout(fitByReadingChild, 50);
    setTimeout(fitByReadingChild, 200);
  });

  // Reajusta al redimensionar
  window.addEventListener('resize', fitByReadingChild);
})();
</script>
</body>
</html>
