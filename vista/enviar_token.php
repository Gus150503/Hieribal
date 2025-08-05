<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once '../modelo/ModeloCliente.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];

    $modelo = new ModeloCliente();
    $cliente = $modelo->buscarPorCorreo($correo);

    if ($cliente) {
        // ✅ Generar token único
        $token = bin2hex(random_bytes(32));

        // Guardar token en DB
        $modelo->guardarTokenRecuperacion($correo, $token);

        // ✅ Preparar correo
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP con Gmail
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gustavoalexiscuevas@gmail.com'; // <- TU CORREO GMAIL
            $mail->Password = 'zxqi mzjg mmos hhxa';            // <- CLAVE DE APLICACIÓN
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('gustavoalexiscuevas@gmail.com', 'Mi Hieribal'); // ✅ CORREGIDO
            $mail->addAddress($correo, $cliente['nombres']);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body = '
                <p>Hola <strong>' . htmlspecialchars($cliente['nombres']) . '</strong>,</p>
                <p>Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el siguiente enlace:</p>
                <p><a href="http://localhost/Hieribal/vista/restablecer.php?token=' . $token . '">Restablecer contraseña</a></p>
                <p>Si no solicitaste esto, puedes ignorar este mensaje.</p>';

            $mail->send();
            $_SESSION['msg'] = "✅ Revisa tu correo para restablecer tu contraseña.";
        } catch (Exception $e) {
            $_SESSION['msg'] = "❌ Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['msg'] = "❌ No se encontró ninguna cuenta con ese correo.";
    }

    header("Location: olvide_contraseña.php");
    exit();
}
