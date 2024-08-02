<?php
session_start(); // Start a session to handle user login state

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$db_username = "root"; // Changed variable name to avoid conflict with POST data
$db_password = "";
$dbname = "Supplier_Collaboration"; // Ensure this is set to your database name

// Create a connection function
function get_db_connection() {
    global $servername, $db_username, $db_password, $dbname;
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Handle the login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Establish a database connection
    $conn = get_db_connection();
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM USERS WHERE User_name=?");
    $stmt->bind_param("s", $username); // Corrected the parameter type to "s"
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debugging: Check if the query returned any result
    if (!$user) {
        die("No user found with that username.");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Check if user exists and password is correct
    if ($user && $password == $user['User_credetials']) {
        // Store user information in session
        $_SESSION['user'] = $user;
        // Redirect to the main system page
        header('Location: frontend/frontpage.html'); // Corrected the file path and fixed the typo in the file extension
        exit();
    } else {
        // Set a login error message
        echo "Invalid credentials.";
    }
}
?>
