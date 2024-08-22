<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Supplier_Collaboration";

// For debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    while ($row = $result_vendor->fetch_assoc()) {
        $company_names_vendor[] = $row["company_name"];
    }
}

// Query to fetch device details from organization_assets table
$sql_assets = "SELECT device_type, brand, model, warranty FROM organization_assets";
$result_assets = $conn->query($sql_assets);

$device_details = array();
if ($result_assets->num_rows > 0) {
    while ($row = $result_assets->fetch_assoc()) {
        $device_details[] = array(
            "device_type" => $row["device_type"],
            "brand" => $row["brand"],
            "model" => $row["model"],
            "warranty" => $row["warranty"]
        );
    }
}

// Query to fetch user names where user_position is 'procurement employee'
$sql_users = "SELECT user_name FROM USERS WHERE user_position = 'procurement employee'";
$result_users = $conn->query($sql_users);

$procurement_employees = array();
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $procurement_employees[] = $row["user_name"];
    }
}

// Query to fetch site, quantity, company, and Procurement_employee from Approved_Tickets table
$sql_Approve = "SELECT site, quantity, company, Procurement_employee, approved, Delivered FROM Approved_Tickets";
$result_approve = $conn->query($sql_Approve);

$records = array();
if ($result_approve->num_rows > 0) {
    while ($row = $result_approve->fetch_assoc()) {
        $records[] = array(
            "site" => $row["site"],
            "quantity" => $row["quantity"],
            "company" => $row["company"],
            "Procurement_employee" => $row["Procurement_employee"],
            "approved" => $row["approved"],
            "Delivered" => $row["Delivered"]
        );
    }
}

// Close connection
$conn->close();

// Combine all results into a single array
$response = array(
    "company_names" => $company_names_vendor,
    "device_details" => $device_details,
    "procurement_employees" => $procurement_employees,
    "approved_tickets" => $records
);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

