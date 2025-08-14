<?php
session_start();
$success = $_SESSION['msg'] ?? null;
$error   = $_SESSION['error_login'] ?? null;
unset($_SESSION['msg'], $_SESSION['error_login']);

$isEmbed = isset($_GET['embed']); // modo embed dentro del modal
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Hieribal · Registro de Cliente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/registro_cliente.css">
  <!-- Overrides suaves para cuando va embebido en el modal -->
<style>
  <?php if ($isEmbed): ?>
  /* 🔧 resetear alturas heredadas */
  html, body { height:auto !important; min-height:0 !important; }
  body{
    background:transparent !important;
    padding:0 !important;
    margin:0 !important;
    display:block !important;        /* nada de grid/centrado */
  }
  .shell{
    width:100% !important;
    border:none !important;
    border-radius:0 !important;
    box-shadow:none !important;
    margin:0 !important;
  }
  .badge{ display:none !important; }
  .art{ padding:24px !important; min-height:auto !important; }
  .panel{ padding:24px !important; }
  @media (max-width:860px){
    .shell{ grid-template-columns:1fr !important; }
  }
  <?php endif; ?>
</style>

</head>
<body class="<?= $isEmbed ? 'is-embed' : '' ?>">
  <main class="shell" role="main">
    <!-- Ilustración / marca -->
    <aside class="art" aria-hidden="true">
      <div class="leaves">
        <div class="leaf leaf1"></div><div class="leaf leaf2"></div><div class="leaf leaf3"></div>
      </div>
      <div class="art-illustration">
        <div style="text-align:center">
          <span>Bienestar que florece</span><br>
          <small>Únete a la familia Hieribal <br>donde encontrarás todos los productos que necesites</small>
        </div>
      </div>
    </aside>

    <!-- Formulario -->
    <section class="panel">
      <div class="header">
        <div class="title">
          <h1>Crea tu cuenta</h1>
          <p>Completa tus datos para comenzar con Hieribal.</p>
        </div>
      </div>

      <?php if ($success): ?>
        <div class="toast success" id="toast">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>
          <span><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="toast error" id="toast">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11 7h2v6h-2V7zm0 8h2v2h-2v-2z"/><path d="M1 21h22L12 2 1 21z"/></svg>
          <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      <?php endif; ?>

      <!-- IMPORTANTE: target="_top" para romper el iframe y cerrar el modal al terminar -->
      <form method="POST" action="../rutas/procesar_registro_cliente.php" target="_top" novalidate>
        <div class="row two">
          <div class="field">
            <input class="input" type="text" name="cedula" id="cedula" placeholder=" " inputmode="numeric" pattern="[0-9]{5,}" required aria-required="true" autocomplete="off">
            <label for="cedula">Cédula</label>
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 5h18a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2zm2 4h6v2H5V9zm0 4h10v2H5v-2z"/></svg>
          </div>
          <div class="field">
            <input class="input" type="text" name="telefono" id="telefono" placeholder=" " inputmode="tel" pattern="[0-9+\s()-]{7,}" autocomplete="tel">
            <label for="telefono">Teléfono</label>
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
          </div>
        </div>

        <div class="row two">
          <div class="field">
            <input class="input" type="text" name="nombres" id="nombres" placeholder=" " required autocomplete="given-name">
            <label for="nombres">Nombres</label>
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm0 2c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5z"/></svg>
          </div>
          <div class="field">
            <input class="input" type="text" name="apellidos" id="apellidos" placeholder=" " required autocomplete="family-name">
            <label for="apellidos">Apellidos</label>
            <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4zM8 13a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm8 2c-2.7 0-8 1.3-8 4v1h16v-1c0-2.7-5.3-4-8-4zM8 15c-2.7 0-8 1.3-8 4v1h8"/></svg>
          </div>
        </div>

        <div class="field">
          <input class="input" type="email" name="correo" id="correo" placeholder=" " required autocomplete="email">
          <label for="correo">Correo</label>
          <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v1.2l10 5.8 10-5.8V6a2 2 0 0 0-2-2zm0 6.5-8 4.6-8-4.6V18a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2z"/></svg>
          <div class="helper" id="correoHelp" aria-live="polite"></div>
        </div>

        <div class="field">
          <input class="input" type="password" name="contraseña" id="password" placeholder=" " minlength="6" required aria-required="true" autocomplete="new-password">
          <label for="password">Contraseña</label>
          <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17 8V6a5 5 0 0 0-10 0v2H5v14h14V8zm-8 0V6a3 3 0 0 1 6 0v2z"/></svg>
          <button type="button" class="pw-toggle" aria-label="Mostrar u ocultar contraseña" title="Mostrar/Ocultar" id="togglePw">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 5c-7 0-11 7-11 7s4 7 11 7 11-7 11-7-4-7-11-7zm0 12a5 5 0 1 1 5-5 5 5 0 0 1-5 5z"/></svg>
          </button>
        </div>

        <button class="submit" type="submit">Crear cuenta</button>
      </form>
    </section>
  </main>

  <script>
    // Auto-hide toast
    const toast = document.getElementById('toast');
    if (toast){
      setTimeout(()=>{ toast.style.transition='opacity 500ms ease'; toast.style.opacity='0';
        setTimeout(()=> toast.remove(), 520);
      }, 3500);
    }

    // Ayuda formato correo
    const correo = document.getElementById('correo');
    const correoHelp = document.getElementById('correoHelp');
    if (correo){
      correo.addEventListener('input', ()=>{
        if (!correo.value) { correoHelp.textContent = ''; return; }
        correoHelp.textContent = correo.validity.valid ? 'Formato de correo válido.' : 'Revisa el formato: nombre@dominio.com';
      });
    }

    // Mostrar/ocultar contraseña
    const pw = document.getElementById('password');
    const toggle = document.getElementById('togglePw');
    if (toggle && pw){
      toggle.addEventListener('click', ()=>{
        const isPwd = pw.type === 'password';
        pw.type = isPwd ? 'text' : 'password';
        toggle.setAttribute('aria-pressed', isPwd ? 'true' : 'false');
      });
    }

    // Evitar Enter en campos intermedios
    document.querySelectorAll('input').forEach((inp, idx, arr)=>{
      inp.addEventListener('keydown', e=>{
        if (e.key === 'Enter' && idx < arr.length-1){ e.preventDefault(); }
      });
    });

    // Labels flotantes: marcar llenos (autofill/servidor)
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.field .input').forEach(i => {
        const f = i.closest('.field');
        const set = () => f.classList.toggle('filled', i.value.trim() !== '');
        set(); i.addEventListener('input', set); i.addEventListener('blur', set);
      });
    });
  </script>

  <!-- Reporta altura al padre para ajustar el iframe (sin duplicados) -->
<script>
(function(){
  function getContentHeight(){
    const root = document.querySelector('.shell');
    if (root) return Math.ceil(root.getBoundingClientRect().height);
    // fallback
    return Math.max(
      document.body.scrollHeight, document.body.offsetHeight,
      document.documentElement.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight
    );
  }
  function sendSize(){
    const h = getContentHeight();
    window.parent.postMessage({type:'registro-size', height: h}, window.location.origin);
  }
  window.addEventListener('load', () => { sendSize(); setTimeout(sendSize,50); setTimeout(sendSize,200); });
  window.addEventListener('resize', sendSize);
  new MutationObserver(sendSize).observe(document.body, {subtree:true, childList:true, attributes:true});
  window.addEventListener('message', (ev)=>{
    if (ev.origin !== window.location.origin) return;
    if (ev.data && ev.data.type === 'get-size') sendSize();
  });
})();
</script>

</body>
</html>
