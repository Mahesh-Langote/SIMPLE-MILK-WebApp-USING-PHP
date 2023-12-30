<?php
// Include the config.php file
require_once 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $customerName = $_POST['customerName'];
    $village = $_POST['village'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];

    // Prepare the SQL statement
    $sql = "INSERT INTO customer (customerName, customerVillage, customerMobailNumber, customerMail)
            VALUES ('$customerName', '$village', '$mobileNumber', '$email')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Record saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection only if it's still open
if ($conn) {
    $conn->close();
}
?>
