<?php
// Include the config.php file
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $date = $_POST['date'];
    $vendorName = $_POST['vendorName'];
    $productName = $_POST['productName'];
    $companyName = $_POST['companyName'];
    $quantity = $_POST['quantity'];
    $cash = $_POST['cash'];
    $credit = $_POST['credit'];
    $narration = $_POST['narration'];

    // Prepare and execute the SQL query
    $sql = "INSERT INTO productBuy (productBuyDate, productBuyVendoreName, productBuyProductName, productBuyProductCompanyName, productBuyQuantity, productBuyHardCash, productBuyCredit, productBuyNarration) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssddds", $date, $vendorName, $productName, $companyName, $quantity, $cash, $credit, $narration);
    
    if ($stmt->execute()) {
        // Record inserted successfully
        echo "<script>
        alert('Record saved successfully');
        window.location.href = 'buyProduct.html';
      </script>";
    } else {
        // Error inserting record
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
