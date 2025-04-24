<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Sau adaptează dacă nu folosești Composer

function trimiteCod($toEmail, $codVerificare) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.mail.yahoo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dani_moncerro@yahoo.com';
        $mail->Password = 'gyhhqsrrxiujeiqp'; // Înlocuiește cu parola ta de aplicație de la Yahoo
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->CharSet = 'UTF-8';
        $mail->setFrom('dani_moncerro@yahoo.com', 'DaHo Auth');
        $mail->addAddress($toEmail);
        $mail->Subject = 'Cod de verificare pentru autentificare';
        $mail->Body = "Salut! Codul tău de verificare este: " . $codVerificare;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Eroare PHPMailer: ' . $mail->ErrorInfo);
        return false;
    }
}
?>
