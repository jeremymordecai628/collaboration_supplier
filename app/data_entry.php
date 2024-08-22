<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Supplier_Collaboration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the POST request
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if decoding was successful
if ($data === null) {
    http_response_code(400); // Bad Request
    echo json_encode(["message" => "Invalid JSON data"]);
    exit();
}

// Extract the employee and data from the received data
$employee = $data['employee'];
$entries = $data['data'];

// Prepare an SQL statement for inserting data
$stmt = $conn->prepare("INSERT INTO Approved_tickets (employee, key_text, value_text) VALUES (?, ?, ?)");

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["message" => "Prepare failed: " . $conn->error]);
    exit();
}

// Bind parameters
$stmt->bind_param('sss', $employee, $key, $value);

// Insert each entry into the database
foreach ($entries as $entry) {
    $key = $entry['key'];
    $value = $entry['value'];

    if (!$stmt->execute()) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Execute failed: " . $stmt->error]);
        exit();
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Respond with success
http_response_code(200); // OK
echo json_encode(["message" => "Data submitted successfully"]);
?>
