<?php
// data_entry.php (for Scenario 1)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$id = $_POST['id'];
$time = $_POST['time'];
$date = $_POST['date'];
$site = $_POST['site'];
$company = $_POST['company'];
$item = $_POST['item'];
$quantity = $_POST['quantity'];
$product_specification = $_POST['product_specification'];
$requester = $_POST['requester'];
$technician = $_POST['technician'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO Approved_Tickets (id, time, date, site, company, item, quantity, product_specification, Requester, Technician) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $id, $time, $date, $site, $company, $item, $quantity, $product_specification, $requester, $technician);

// Execute
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
