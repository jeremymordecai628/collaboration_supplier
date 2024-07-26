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

// Query to fetch company names from vendor table
$sql_vendor = "SELECT company_name FROM vendor";
$result_vendor = $conn->query($sql_vendor);

$company_names_vendor = array();
if ($result_vendor->num_rows > 0) {
    while($row = $result_vendor->fetch_assoc()) {
        $company_names_vendor[] = $row["company_name"];
    }
}

// Query to fetch device details from organization_assets table
$sql_assets = "SELECT device_type, brand, model, warranty FROM organization_assets";
$result_assets = $conn->query($sql_assets);

$device_details = array();
if ($result_assets->num_rows > 0) {
    while($row = $result_assets->fetch_assoc()) {
        $device_details[] = array(
            "device_type" => $row["device_type"],
            "brand" => $row["brand"],
            "model" => $row["model"],
            "warranty" => $row["warranty"]
        );
    }
}

// Close connection
$conn->close();

// Combine both results into a single array
$response = array(
    "company_names" => $company_names_vendor,
    "device_details" => $device_details
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>