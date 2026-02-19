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

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.johnstepssafaris.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bookings@johnstepssafaris.com';
        $mail->Password   = 'Bookings@2030';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('bookings@johnstepssafaris.com', 'Johnsteps Bookings');
        $mail->addAddress('bookings@johnstepssafaris.com'); 

        $mail->isHTML(true);
        $mail->Subject = "New Tour Booking: " . strtoupper($_POST['destination']);
        
        // Structure the booking details for the email body
        $mail->Body    = "<h3>New Safari Booking Request</h3>" .
                         "<b>Destination:</b> " . $_POST['destination'] . "<br>" .
                         "<b>Tour Type:</b> " . $_POST['tour_type'] . "<br>" .
                         "<b>Departure:</b> " . $_POST['checkin'] . "<br>" .
                         "<b>Return:</b> " . $_POST['checkout'] . "<br>" .
                         "<b>Adults:</b> " . $_POST['adults'] . "<br>" .
                         "<b>Children:</b> " . $_POST['children'];

        $mail->send();
        echo "OK";
    } catch (Exception $e) {
        echo "Booking failed. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>