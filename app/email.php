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

// Define sender email configuration
$sender_email = 'appmail@gmail.com'; // Fixed sender email
$sender_password = 'admin123';       // Fixed sender password or App password for 2-step verification

// Function to get database connection
function get_db_connection() {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "Supplier_Collaboration"; // Ensure this is set to your database name

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to get the recipient email based on procurement ID
function get_recipient_email($procurement_id) {
    $conn = get_db_connection();
    $recipient_email = '';

    // Prepare and execute the query to fetch recipient email based on procurement_id
    $query = "SELECT User_email FROM USERS WHERE User_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $procurement_id);
    $stmt->execute();
    $stmt->bind_result($recipient_email);
    $stmt->fetch();
    
    $stmt->close();
    $conn->close();

    return $recipient_email;
}

// Get procurement_id from POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['procurement_id'])) {
    $procurement_id = intval($_POST['procurement_id']); // Sanitize the input
    $email = get_recipient_email($procurement_id);

    if (!$email) {
        echo "Recipient email not found!";
        exit;
    }


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
        $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
        $mail->Username   = $sender_email;                           // SMTP username 
        $mail->Password   = $sender_password;                        // SMTP password        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port       = 587;                                  // TCP port to connect to

        // Sender
        $mail->setFrom($sender_email, 'Modecai Moringa');                  // Set the sender's email and name

        // Recipient
        $mail->addAddress($email);                                 // Add recipient email

        // Content
        $mail->isHTML(false);                                      // Set email format to plain text
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Send the email
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Failed to send email: {$mail->ErrorInfo}";
    }
} else {
    echo "No procurement ID provided!";
}
?>
