<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    $to = "dani_moncerro@yahoo.com";
    $subject = "Mesaj nou de pe DaHo Tech Solutions";
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    $fullMessage = "Ai primit un mesaj nou de la: $name <$email>\n\n";
    $fullMessage .= "Mesaj:\n$message";

    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "<h2 style='font-family:sans-serif; color:green; text-align:center;'>Mesajul a fost trimis cu succes!</h2>";
    } else {
        echo "<h2 style='font-family:sans-serif; color:red; text-align:center;'>Eroare la trimiterea mesajului. Încearcă din nou.</h2>";
    }
} else {
    header("Location: index.php");
    exit;
}
?>
