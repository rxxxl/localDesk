<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "./vendor/autoload.php";

class EmailSender
{
    public static function sendEmail($recipient, $subject, $body, $attachmentPath = null, $imagePath = null)
    {
        $mail = new PHPMailer(true); // Utiliza 'true' para habilitar excepciones

        try {
            // Configuración del servidor SMTP y otros detalles
            $mail->SMTPDebug = 2; // Activa la salida de depuración detallada
            $mail->isSMTP(); // Envía utilizando SMTP
            $mail->Host = 'mail.ddm1078.com.mx'; // Servidor SMTP para enviar a través de
            $mail->SMTPAuth = true; // Habilita la autenticación SMTP
            $mail->Username = 'localdesk@ddm1078.com.mx'; // Nombre de usuario SMTP
            $mail->Password = 'Tolucacampeon.2023'; // Contraseña SMTP
            $mail->SMTPSecure = 'ssl'; // Habilita la encriptación implícita TLS
            $mail->Port = 465; // Puerto TCP al que conectarse
            $mail->setLanguage('es'); // Establece el idioma de los mensajes de error

            // Configuración del mensaje
            $mail->setFrom('localdesk@ddm1078.com.mx', 'Local Desk');

            $mail->addAddress($recipient);

            $mail->isHTML(true); // Establece el formato del correo electrónico a HTML
            $mail->Subject = $subject;
            $mail->Body = utf8_decode($body);

            // Adjuntar archivo (si se proporciona)
            if ($attachmentPath !== null) {
                $mail->addAttachment($attachmentPath);
            }

            if ($imagePath !== null) {
                $cid = $mail->addEmbeddedImage($imagePath, 'img');
                $mail->Body .= "<img src='cid:$cid' alt='Ticket Image'>";
            }
            // Intenta enviar el correo
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Manejar errores
            return false;
        }
    }

}


?>