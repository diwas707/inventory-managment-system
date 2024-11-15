<?php

require_once('includes/session.php');
$msg = $session->msg();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $query = $_POST['query'];

    // Validate and sanitize input (you may add more validation)
    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $contact = preg_replace("/[^0-9]/", "", $contact); // Remove non-numeric characters
    $query = htmlspecialchars($query);

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory_system";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind statement to insert data
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, contact, inquiry) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $contact, $query);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        // Success message
        $session->msg("s", "Inquiry is submitted");
    } else {
        // Error message
        $session->msg("d", "Error: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Redirect back to the form page
header("Location: query.php");
exit();
?>
