<?php
// Database connection details
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

// Query to fetch organization names from organization table
$sql_organization = "SELECT organization_name FROM organization";
$result_organization = $conn->query($sql_organization);

// Store organization names in an array
$organization_names = array();
if ($result_organization->num_rows > 0) {
    while($row = $result_organization->fetch_assoc()) {
        $organization_names[] = $row["organization_name"];
    }
}

// Query to fetch company names from vendor table
$sql_vendor = "SELECT company_name FROM vendor";
$result_vendor = $conn->query($sql_vendor);

// Store company names in an array
$company_names_vendor = array();
if ($result_vendor->num_rows > 0) {
    while($row = $result_vendor->fetch_assoc()) {
        $company_names_vendor[] = $row["company_name"];
    }
}

// Query to fetch device details from organization_assets table
$sql_assets = "SELECT device_type, brand, model, warranty FROM organization_assets";
$result_assets = $conn->query($sql_assets);

// Store device details in an array
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

// Combine results into a single array
$response = array(
    "organization_names" => $organization_names,
    "company_names" => $company_names_vendor,
    "device_details" => $device_details
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
