<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start(); // Start the session

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if user session exists
if (!isset($_SESSION['user']) || !isset($_SESSION['User_email'])) {
    echo "User session does not exist!";
    exit; // Exit if the session does not exist
}

// Retrieve user email and credentials from session
$user_email = $_SESSION['user']['User_email'];
$user_password = $_SESSION['user']['User_credetials']; // Assuming password is stored in the session

// Placeholder for required variables
$smtp_server = 'smtp.gmail.com'; // Gmail SMTP server
$smtp_port = 587; // your SMTP port
$email = $; // recipient email

// Email content
$subject = "Approval of Purchase Request";
$body = "Dear Mr/Ms,\n\nWe were kindly requesting your approval of the request:\n\n";

// Add data to the email body
$selectedData = []; // Replace with actual data
foreach ($selectedData as $item) {
    $body .= "Key: " . htmlspecialchars($item['key']) . "\n";
    $body .= "Value: " . htmlspecialchars($item['value']) . "\n\n";
}

// Create the email
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                           // Send using SMTP
    $mail->Host       = $smtp_server;                          // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
    $mail->Username   = $user_email;                           // SMTP username from session
    $mail->Password   = $user_password;                        // SMTP password from session        
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        // Enable TLS encryption
    $mail->Port       = $smtp_port;                            // TCP port to connect to

    // Sender
    $mail->setFrom($user_email);                               // Set the sender's email

    // Recipient
    $mail->addAddress($email);                                 // Add recipient email

    // Content
    $mail->isHTML(false);                                      // Set email format to plain text
    $mail->Subject = $subject;
    $mail->Body    = $body;

    // Send the email
    $mail->send();
    echo "Emails sent successfully!";
} catch (Exception $e) {
    echo "Failed to send email: {$mail->ErrorInfo}";
}
?>
