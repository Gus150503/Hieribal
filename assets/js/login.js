// assets/js/login.js
(function(){
  const openBtn  = document.getElementById('openRegistroBtn');
  const closeBtn = document.getElementById('closeRegistroBtn');
  const modal    = document.getElementById('registroModal');

  function openModal(e){
    if (e) e.preventDefault();
    document.documentElement.style.overflow = 'hidden'; // fallback si no hay :has
    modal?.showModal();
  }
  function closeModal(){
    modal?.close();
    document.documentElement.style.overflow = '';
  }

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);

  // Cerrar clickeando fuera
  modal?.addEventListener('click', (e)=>{
    const rect = modal.getBoundingClientRect();
    const inDialog = (
      e.clientX >= rect.left && e.clientX <= rect.right &&
      e.clientY >= rect.top  && e.clientY <= rect.bottom
    );
    if (!inDialog) closeModal();
  });

  // Reabrir modal si el servidor dejó la bandera (PHP imprime un script inline mínimo)
  // (lo insertamos desde PHP para no depender de una variable global)
})();
