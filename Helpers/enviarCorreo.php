<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php'; // Si usas Composer

function enviarCorreoRecuperacion($destinatario, $enlace) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'killbryanmauricio@gmail.com';  // TU CORREO GMAIL
        $mail->Password   = 'iwce lleo vrua ysoq';  // CONTRASEÑA DE APLICACIÓN, NO TU CLAVE NORMAL
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('killbryanmauricio@gmail.com', 'Colhumus');
        $mail->addAddress($destinatario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Recupera tu contraseña';
        $mail->Body    = "Haz clic aquí para recuperar tu contraseña: <a href='$enlace'>$enlace</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error al enviar correo: {$mail->ErrorInfo}");
        return false;
    }
}
