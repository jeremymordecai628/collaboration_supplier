<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if any POST data is received
    $postData = file_get_contents("php://input");
    if (!empty($postData)) {
        // Process the received data here
        echo "Data received successfully.";
    } else {
        // If no data is received, send an error message
        echo "Error: No data received.";
    }
} else {
    // If not a POST request, send an error message
    echo "Error: POST request expected.";
}

?>
