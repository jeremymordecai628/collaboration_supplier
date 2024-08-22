<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to the HTML file in the specified path
header("Location: /collaboration_supplier/app/frontend/index.html");
exit();
?>
