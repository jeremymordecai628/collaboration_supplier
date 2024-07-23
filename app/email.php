<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader for PHPMailer

// SMTP server configuration
$smtp_server = "smtp.example.com";
$smtp_port = 587;
$smtp_user = "your_email@example.com";
$smtp_password = "your_password";

// Email content
$subject = "Test Email";
$body = "This is a test email sent to multiple recipients.";

// List of recipients
$recipients = ["recipient1@example.com", "recipient2@example.com", "recipient3@example.com"];

// Create the email
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = $smtp_server;                           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $smtp_user;                             // SMTP username
    $mail->Password   = $smtp_password;                         // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = $smtp_port;                             // TCP port to connect to

    // Sender
    $mail->setFrom($smtp_user);

    // Recipients
    foreach ($recipients as $recipient) {
        $mail->addAddress($recipient);                          // Add a recipient
    }

    // Content
    $mail->isHTML(false);                                       // Set email format to plain text
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Send the email
    $mail->send();
    echo "Emails sent successfully!";
} catch (Exception $e) {
    echo "Failed to send email: {$mail->ErrorInfo}";
}
?>
