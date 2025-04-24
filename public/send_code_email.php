<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

function sendVerificationCode($email, $code) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.yahoo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dani_moncerro@yahoo.com';
        $mail->Password = 'PetraCristiana3'; // Înlocuiește cu parola sau folosește o aplicație dedicată
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinatar
        $mail->setFrom('dani_moncerro@yahoo.com', 'Sistem Autentificare');
        $mail->addAddress($email);

        // Conținut
        $mail->isHTML(true);
        $mail->Subject = 'Codul tău de autentificare';
        $mail->Body    = "<h3>Salut!</h3><p>Codul tău de autentificare este: <strong>$code</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>