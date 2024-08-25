<?php
// update_entry.php (for Scenario 2)
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

// Retrieve form data
$id = $_POST['id'];
$procurement_employee = $_POST['procurement_employee'];
$approved = $_POST['approved'];

// Prepare and bind
$stmt = $conn->prepare("UPDATE Approved_Tickets SET procurement_employee = ?, approved = ? WHERE id = ?");
$stmt->bind_param("ssi", $procurement_employee, $approved, $id);

// Execute
if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
