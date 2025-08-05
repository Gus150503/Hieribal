<?php
require_once '../modelo/ModeloUsuario.php';
$modelo = new ModeloUsuario();

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    $resultado = $modelo->eliminarUsuario($id);
    echo $resultado ? 'ok' : 'error';
} else {
    echo 'faltan_datos';
}
