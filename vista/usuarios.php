<?php
require_once '../modelo/ModeloUsuario.php';
$modelo = new ModeloUsuario();
$usuarios = $modelo->listarUsuarios();
?>

<link rel="stylesheet" href="../assets/css/usuarios.css">


<!-- Encabezado con botón Crear -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Gestión de Usuarios</h4>
  
  <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
    <i class="bi bi-plus-lg"></i> Crear Usuario
  </button>
</div>

<!-- Tabla -->
<div class="table-responsive">
  <table id="tablaUsuarios" class="table table-bordered table-hover w-100">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Rol</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
      <tr>
        <td><?= $usuario['id_usuario'] ?></td>
        <td><?= $usuario['usuario'] ?></td>
        <td><?= ucfirst($usuario['rol']) ?></td>
        <td><?= $usuario['nombres'] ?></td>
        <td><?= $usuario['apellidos'] ?></td>
        <td><?= $usuario['correo'] ?></td>

        <!-- Estado visible y también en texto oculto para que lo indexe la búsqueda -->
        <td>
          <span style="display:none;"><?= $usuario['estado'] ?></span>
          <button 
            class="btn btn-sm <?= $usuario['estado'] === 'Activo' ? 'btn-success' : 'btn-secondary' ?> toggle-estado" 
            data-id="<?= $usuario['id_usuario'] ?>" 
            data-estado="<?= $usuario['estado'] ?>">
            <?= $usuario['estado'] ?>
          </button>
        </td>

        <td>
          <button 
            class="btn btn-sm btn-warning btn-editar"
            data-id="<?= $usuario['id_usuario'] ?>"
            data-usuario="<?= $usuario['usuario'] ?>"
            data-rol="<?= $usuario['rol'] ?>"
            data-nombres="<?= $usuario['nombres'] ?>"
            data-apellidos="<?= $usuario['apellidos'] ?>"
            data-correo="<?= $usuario['correo'] ?>"
          >
            Editar
          </button>
          <button class="btn btn-sm btn-danger btn-eliminar" data-id="<?= $usuario['id_usuario'] ?>">Eliminar</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarUsuario">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_usuario" id="edit_id_usuario">
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" class="form-control" id="edit_usuario" name="usuario" required pattern="^[a-zA-Z0-9_]{4,20}$">
          </div>
          <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" class="form-control" id="edit_nombres" name="nombres" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="edit_apellidos" name="apellidos" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" id="edit_correo" name="correo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Rol</label>
            <select class="form-select" id="edit_rol" name="rol" required>
              <option value="admin">Admin</option>
              <option value="empleado">Empleado</option>
              <option value="cajero">Cajero</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formCrearUsuario">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Crear Nuevo Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" class="form-control" id="nuevo_usuario" name="usuario" required pattern="^[a-zA-Z0-9_]{4,20}$">
          </div>
          <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nuevo_nombres" name="nombres" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="nuevo_apellidos" name="apellidos" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" class="form-control" id="nuevo_correo" name="correo" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Rol</label>
            <select class="form-select" id="nuevo_rol" name="rol" required>
              <option value="admin">Admin</option>
              <option value="empleado">Empleado</option>
              <option value="cajero">Cajero</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="nuevo_password" name="password" required minlength="6">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Crear Usuario</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- JavaScript y DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<script>
$(document).ready(function () {
  $('#tablaUsuarios').DataTable({
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    },
    pageLength: 1,
    searching: true,
    responsive: true,
    scrollX: true
  });
});
</script>

<script src="../assets/js/usuarios.js"></script>
