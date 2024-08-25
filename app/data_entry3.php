<?php
$servername = "localhost";
$username = "username";
$password = "";
$dbname = "Supplier_Collaboration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$vendor = $_POST['vendor'];
$total_points = $_POST['total_points'];

// Prepare and bind
$stmt = $conn->prepare("SELECT total_points FROM rate WHERE vendor = ?");
$stmt->bind_param("s", $vendor);

// Execute the query
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($current_points);

if ($stmt->num_rows > 0) {
    // Vendor exists, update points
    $stmt->fetch();
    $new_points = $current_points + $total_points;
    $stmt->close();

    $update_stmt = $conn->prepare("UPDATE rate SET total_points = ? WHERE vendor = ?");
    $update_stmt->bind_param("is", $new_points, $vendor);
    $update_stmt->execute();
    $update_stmt->close();
    echo "Total points updated successfully.";
} else {
    // Vendor does not exist
    echo "Vendor not found.";
}

$conn->close();
?>
