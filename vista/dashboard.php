<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login_usuario.php");
    exit;
}
$usuario = $_SESSION['usuario'];

require_once '../modelo/ModeloUsuario.php';
$modelo = new ModeloUsuario();

$totalUsuarios = $modelo->contarUsuarios();
$totalActivos = $modelo->contarUsuariosPorEstado('Activo');
$totalAdmins = $modelo->contarUsuariosPorRol('admin');
$totalEmpleados = $modelo->contarUsuariosPorRol('empleado');
$totalCajeros = $modelo->contarUsuariosPorRol('cajero');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Hieribal</title>
    <link rel="stylesheet" href="../assets/css/estilo_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="dashboard-layout">
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="logo">
            <img src="../assets/img/logo.png" alt="Logo Hieribal">
        </div>
        <a href="dashboard.php"><i class="bi bi-house-door"></i> Inicio</a>

        <a href="#"><i class="bi bi-box-seam"></i> Inventario</a>
        <a href="#"><i class="bi bi-basket3"></i> Productos</a>
        <a href="?modulo=usuarios"><i class="bi bi-people"></i> Usuarios</a>
        <a href="#"><i class="bi bi-gear"></i> Configuración</a>
    </nav>

    <!-- Contenido principal -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center p-3 border-bottom bg-white">
            <div class="d-flex align-items-center gap-2">
                <button class="menu-toggle d-md-none btn btn-outline-success" onclick="toggleSidebar()">☰</button>
                <strong>Panel de inicio</strong>
            </div>
            <div class="dropdown">
                <span class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> <?= htmlspecialchars($usuario['nombres']) ?>
                </span>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Mi cuenta</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-sliders"></i> Preferencias</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../rutas/logout_usuario.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                </ul>
            </div>
        </div>


<main class="p-4">
<?php
if (isset($_GET['modulo'])) {
    $modulo = $_GET['modulo'];
    if ($modulo === 'usuarios') {
        include 'usuarios.php'; // Asegúrate de tener este archivo
    } else {
        echo "<h4>Módulo no encontrado</h4>";
    }
} else {
?>
    <h4>Bienvenido, <?= htmlspecialchars($usuario['nombres']); ?></h4>
    <p>Accede a tus módulos desde el menú lateral.</p>

    <!-- Tarjetas -->
    <div class="row mt-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="card bg-primary text-white text-center p-3">
                <h5>Total Usuarios</h5>
                <h2><?= $totalUsuarios ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card bg-success text-white text-center p-3">
                <h5>Usuarios Activos</h5>
                <h2><?= $totalActivos ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card bg-warning text-dark text-center p-3">
                <h5>Administradores</h5>
                <h2><?= $totalAdmins ?></h2>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card bg-info text-white text-center p-3">
                <h5>Empleados</h5>
                <h2><?= $totalEmpleados ?></h2>
            </div>
        </div>
    </div>

    <!-- Gráfico -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-4 chart-container">
                <h5 class="text-center">Distribución de usuarios por rol</h5>
                <canvas id="graficoRoles" width="300" height="300"></canvas>
            </div>
        </div>
    </div>
<?php } ?>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const ctx = document.getElementById('graficoRoles').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Administradores', 'Empleados', 'Cajeros'],
        datasets: [{
            label: 'Usuarios',
            data: [<?= $totalAdmins ?>, <?= $totalEmpleados ?>, <?= $totalCajeros ?>],
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
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}
</script>

</body>
</html>