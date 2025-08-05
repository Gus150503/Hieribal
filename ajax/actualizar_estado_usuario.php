<?php
require_once '../modelo/ModeloUsuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';

    if ($id > 0 && in_array($estado, ['Activo', 'Inactivo'])) {
        $modelo = new ModeloUsuario();
        $exito = $modelo->actualizarEstado($id, $estado);

        echo $exito ? 'ok' : 'error';
    } else {
        echo 'error';
    }
}
?>
