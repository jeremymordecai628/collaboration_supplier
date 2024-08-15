<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start(); // Start the session

// Check if user session exists
if (!isset($_SESSION['user'])) {
    echo "User session does not exist!";
    exit; // Exit if the session does not exist
}

// Retrieve user email and credentials from session
$user_email = $_SESSION['user']['User_email'];
$user_password = $_SESSION['user']['User_credetials']; // Assuming password is stored in the session

require 'vendor/autoload.php'; // Load Composer's autoloader for PHPMailer

// SMTP server configuration
$smtp_server = "google.com"; // Your SMTP server
$smtp_port = 587;                 // SMTP port

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
    $mail->Username   = $user_email;                            // SMTP username from session
    $mail->Password   = $user_password;                         // SMTP password from session
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = $smtp_port;                             // TCP port to connect to

    // Sender
    $mail->setFrom($user_email);                                // Set the sender's email

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
