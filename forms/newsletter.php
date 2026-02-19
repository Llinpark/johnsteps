<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot check
    if (!empty($_POST['website'])) {
        die("Spam detected.");
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Log to CSV
    $file = fopen("subscribers.csv", "a");
    fputcsv($file, [$email, date('Y-m-d H:i:s')]);
    fclose($file);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.johnstepssafaris.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'newsletter@johnstepssafaris.com';
        $mail->Password   = 'newsletter@2030';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('newsletter@johnstepssafaris.com', 'Johnsteps Newsletter');
        $mail->addAddress('info@johnstepssafaris.com'); 

        $mail->isHTML(true);
        $mail->Subject = "New Newsletter Subscriber";
        $mail->Body    = "New subscriber: <b>$email</b> has been added to your CSV list.";

        $mail->send();
        echo "OK";
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
}
?>