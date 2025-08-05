<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ServicioCorreo {
    public static function enviarVerificacion($correo, $nombre, $token) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'gustavoalexiscuevas@gmail.com';
            $mail->Password   = 'zxqi mzjg mmos hhxa';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('gustavoalexiscuevas@gmail.com', 'Mi Hieribal');
            $mail->addAddress($correo, $nombre);
            $mail->isHTML(true);
            $mail->Subject = 'Verifica tu cuenta en Hieribal';
            $mail->Body    = "
                <p>Hola <strong>" . htmlspecialchars($nombre) . "</strong>,</p>
                <p>Gracias por registrarte. Verifica tu cuenta haciendo clic en el siguiente enlace:</p>
                <p><a href='http://localhost/Hieribal/vista/verificar.php?token=$token'>Verificar cuenta</a></p>
                <p>Si no fuiste tú, ignora este mensaje.</p>
            ";
            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $mail->ErrorInfo);
        }
    }
}
