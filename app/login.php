<?php
session_start(); // Start a session to handle user login state

// Database connection details
$servername = "your_db_host";
$username = "your_db_user";
$password = "your_db_password";
$dbname = "your_db_name";

// Create a connection function
function get_db_connection() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Handle the login request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Get username and password from POST request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Establish a database connection
    $conn = get_db_connection();
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Check if user exists
    if ($user) {
        // Store user information in session
        $_SESSION['user'] = $user;
        // Redirect to the main system page
        header('Location: system.php');
        exit();
    } else {
        // Set a login error message
        $login_error = "Invalid credentials.";
    }
}

// Serve the login page
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/') {
    // Specify the path to your static files and templates
    $template_folder = __DIR__ . '/templates';

    // Serve the login.html file from the templates folder
    $login_file = $template_folder . '/login.html';
    if (file_exists($login_file)) {
        // Output the contents of the login.html file
        echo file_get_contents($login_file);
    } else {
        // If the file doesn't exist, send a 404 response
        http_response_code(404);
        echo "404 Not Found";
    }
    exit();
}

// If the requested URI does not match any route, send a 404 response
http_response_code(404);
echo "404 Not Found";
?>
