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

// Check if the request is a JSON POST request or a form submission
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Get the JSON data from the POST request
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Check if decoding was successful
    if ($data === null) {
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Invalid JSON data"]);
        exit();
    }
    //check for the first scenario 
    if (isset($data['date']) && isset($data['time'])) {
        // Prepare an SQL statement for inserting data into Approved_tickets
        $stmt = $conn->prepare("INSERT INTO Approved_tickets (id, time, date, site, Item, Quantity, Product_Specifications, company, Requester, Technician) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        if (!$stmt) {
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "Prepare failed: " . $conn->error]);
            exit();
        }
    
        // Assign data to variables that will be used in the prepared statement
        $id = $data['id'];
        $time = $data['time'];
        $date = $data['date'];
        $site = $data['site'];
        $item = $data['item'];
        $quantity = $data['quantity'];
        $productSpecifications = $data['Product_Specifications'];
        $company = $data['company'];
        $requester = $data['Requester'];
        $technician = $data['Technician'];
    
        // Bind parameters - 's' denotes string data type for each parameter
        $stmt->bind_param('ssssssssss', $id, $time, $date, $site, $item, $quantity, $productSpecifications, $company, $requester, $technician);
    
        // Execute the prepared statement
        if (!$stmt->execute()) {
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "Execute failed: " . $stmt->error]);
            exit();
        }
    
        $stmt->close();
        http_response_code(200); // OK
        echo json_encode(["message" => "Data submitted successfully to Approved_tickets"]);
    }
//Scenario 2: Check if 'procurement employee' is part of the received data
else if (isset($data['procurement_employee'])) {
        $procurement_employee = $data['procurement_employee'];
        $approved_data = $data['approved_data'];

       // Scenario 2: Update 'Approved_tickets' table with 'procurement_employee' and 'Approved' data

// Extract the 'procurement_employee' and 'Approved' from the received data
$procurement_employee = $data['procurement_employee'];
$approved = $data['approved'];

// Search for a matching record in Approved_tickets where procurement_employee is NULL
$stmt = $conn->prepare("SELECT id FROM Approved_tickets WHERE procurement_employee IS NULL");

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["message" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the first matching row's ID
    $row = $result->fetch_assoc();
    $id = $row['id'];

    // Update the 'procurement_employee' and 'Approved' in the row with the retrieved ID
    $update_stmt = $conn->prepare("UPDATE Approved_tickets SET procurement_employee = ?, Approved = ? WHERE id = ?");
    
    if (!$update_stmt) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    // Bind parameters
    $update_stmt->bind_param('ssi', $procurement_employee, $approved, $id);

    if ($update_stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(["message" => "Record updated successfully"]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Execute failed: " . $update_stmt->error]);
    }

    $update_stmt->close();
} else {
    // No matching records found
    http_response_code(404); // Not Found
    echo json_encode(["message" => "No matching record found to update"]);
}

$stmt->close();
    }
    // Third scenario: Update the 'rate' table if the data is for a vendor
else {
    $vendor = $data['vendor'];
    $total_points = $data['total_points'];

    // Search for the existing total_points for the provided vendor
    $stmt = $conn->prepare("SELECT total_points FROM rate WHERE vendor = ?");
    if (!$stmt) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param('s', $vendor);

    if (!$stmt->execute()) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Execute failed: " . $stmt->error]);
        exit();
    }

    // Fetch the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Vendor exists, update the total_points
        $row = $result->fetch_assoc();
        $current_total_points = $row['total_points'];
        
        // Calculate the new total points
        $new_total_points = $current_total_points + $total_points;

        // Update the rate table with the new total points
        $update_stmt = $conn->prepare("UPDATE rate SET total_points = ? WHERE vendor = ?");
        if (!$update_stmt) {
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "Prepare failed: " . $conn->error]);
            exit();
        }

        $update_stmt->bind_param('is', $new_total_points, $vendor);

        if (!$update_stmt->execute()) {
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "Execute failed: " . $update_stmt->error]);
            exit();
        }

        $update_stmt->close();
        http_response_code(200); // OK
        echo json_encode(["message" => "Total points updated successfully for vendor: $vendor"]);
    } else {
        // Vendor not found, handle this case (e.g., insert a new row, error message, etc.)
        http_response_code(404); // Not Found
        echo json_encode(["message" => "Vendor not found"]);
    }

    $stmt->close();
}

} else {
    // Invalid request
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"]);
}

$conn->close();
?>
