<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['website'])) {
        die("Spam detected.");
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.johnstepssafaris.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@johnstepssafaris.com';
        $mail->Password   = 'Johnstepssafaris@2030';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('info@johnstepssafaris.com', 'Johnsteps Safaris');
        $mail->addAddress('info@johnstepssafaris.com'); 

        $mail->isHTML(true);
        $mail->Subject = strip_tags($_POST['subject']);
        $mail->Body    = "<b>Name:</b> {$_POST['name']}<br><b>Email:</b> {$_POST['email']}<br><br>" . nl2br($_POST['message']);

        $mail->send();
        echo "OK";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>