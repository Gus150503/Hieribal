<?php
require_once '../modelo/ModeloUsuario.php';
$modelo = new ModeloUsuario();

if (
    isset($_POST['usuario'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['rol'], $_POST['password'])
) {
    $datos = [
        'usuario'   => trim($_POST['usuario']),
        'nombres'   => trim($_POST['nombres']),
        'apellidos' => trim($_POST['apellidos']),
        'correo'    => trim($_POST['correo']),
        'rol'       => trim($_POST['rol']),
        'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'estado'    => 'Activo'
    ];

    // Validar duplicados
    if ($modelo->usuarioExiste($datos['usuario'])) {
        echo 'usuario_duplicado';
        exit;
    }

    if ($modelo->correoExiste($datos['correo'])) {
        echo 'correo_duplicado';
        exit;
    }

    $exito = $modelo->crearUsuario($datos);
    echo $exito ? 'ok' : 'error';
} else {
    echo 'faltan_datos - DEBUG: ';
    var_dump($_POST); // 👈 esto mostrará qué datos llegan realmente
}
