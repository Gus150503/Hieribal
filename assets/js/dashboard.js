// assets/js/dashboard.js
(function(){
  // toggle sidebar
  const btn = document.getElementById('btnToggleSidebar');
  if (btn) {
    btn.addEventListener('click', function(){
      const sb = document.querySelector('.sidebar');
      if (sb) sb.classList.toggle('active');
    });
  }

  // chart
  const dataNode = document.getElementById('chart-data');
  const canvas   = document.getElementById('graficoRoles');
  if (dataNode && canvas && window.Chart) {
    const admins    = Number(dataNode.dataset.admins || 0);
    const empleados = Number(dataNode.dataset.empleados || 0);
    const cajeros   = Number(dataNode.dataset.cajeros || 0);

    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Administradores', 'Empleados', 'Cajeros'],
        datasets: [{
          label: 'Usuarios',
          data: [admins, empleados, cajeros],
          backgroundColor: [
            'rgba(255, 193, 7, 0.7)',
            'rgba(40, 167, 69, 0.7)',
            'rgba(23, 162, 184, 0.7)'
          ],
          borderColor: [
            'rgba(255, 193, 7, 1)',
            'rgba(40, 167, 69, 1)',
            'rgba(23, 162, 184, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
      }
    });
  }
})();
