<?php
session_start();
require_once '../modelo/ModeloUsuario.php';
require '../vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';

    if (empty($correo)) {
        $_SESSION['msg'] = "❌ El campo correo está vacío.";
        header('Location: ../vista/olvide_contraseña_usuario.php');
        exit();
    }

    $modelo = new ModeloUsuario();
    $usuario = $modelo->buscarPorCorreo($correo);

    if ($usuario) {
        $token = bin2hex(random_bytes(32));
        $modelo->guardarTokenRecuperacion($usuario['id_usuario'], $token);

        $enlace = "http://localhost/Hieribal/vista/restablecer_contraseña_usuario.php?token=$token";
        $asunto = "Recupera tu contraseña - Hieribal";
        $mensaje = "Hola {$usuario['nombres']},<br><br>
                    Haz clic en el siguiente enlace para restablecer tu contraseña:<br>
                    <a href='$enlace'>$enlace</a><br><br>
                    Si no solicitaste este cambio, puedes ignorar este mensaje.";

        // Enviar correo con PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'gustavoalexiscuevas@gmail.com'; // TU CORREO
            $mail->Password   = 'zxqi mzjg mmos hhxa';   // CONTRASEÑA DE APLICACIÓN
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Correo
            $mail->setFrom('gustavoalexiscuevas@gmail.com', 'Hieribal');
            $mail->addAddress($correo, $usuario['nombres']);
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
            $_SESSION['msg'] = "📩 Se ha enviado un enlace a tu correo.";
        } catch (Exception $e) {
            $_SESSION['msg'] = "❌ Error al enviar correo: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['msg'] = "❌ Correo no registrado.";
    }

    header('Location: ../vista/olvide_contraseña_usuario.php');
    exit();
}
