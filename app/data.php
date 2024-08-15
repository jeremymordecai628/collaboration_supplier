<?php
session_start(); // Start the session to access session data

// Check if user session exists
if (isset($_SESSION['user'])) {
    // Set the content type to JSON
    header('Content-Type: application/json');
    
    // Output session data as JSON
    echo json_encode($_SESSION['user']);
} else {
    // If no user session, send an empty JSON object
    echo json_encode([]);
}
?>
