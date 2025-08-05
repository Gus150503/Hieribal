<?php
require_once '../modelo/ModeloUsuario.php';
$modelo = new ModeloUsuario();

// Validar que se recibieron todos los datos necesarios
if (
    isset($_POST['id_usuario'], $_POST['usuario'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['rol'])
) {
    $datos = [
        'id_usuario' => (int) $_POST['id_usuario'],
        'usuario'    => trim($_POST['usuario']),
        'nombres'    => trim($_POST['nombres']),
        'apellidos'  => trim($_POST['apellidos']),
        'correo'     => trim($_POST['correo']),
        'rol'        => trim($_POST['rol'])
    ];

    // ✅ Verificar si el usuario ya existe (excluyendo el actual)
    if ($modelo->usuarioExisteEdit($datos['usuario'], $datos['id_usuario'])) {
        echo 'usuario_duplicado';
        exit;
    }

    $exito = $modelo->actualizarUsuario($datos);
    echo $exito ? 'ok' : 'error';
} else {
    echo 'faltan_datos';
}
