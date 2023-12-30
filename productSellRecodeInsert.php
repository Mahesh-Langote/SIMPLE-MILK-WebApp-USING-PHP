<?php
// Include the config.php file
require_once 'config.php';

// Retrieve the form data
$date = $_POST['date'];
$customer = $_POST['customer'];
$product = $_POST['product'];
$quantity = $_POST['quantity'];
$hardCash = $_POST['hardCash'];
$credit = $_POST['credit'];
$narration = $_POST['narration'];

// Extract the product name from the selected product value
$productName = substr($product, 0, strpos($product, '(') - 1);

// Insert the record into the "productSell" table
$sql = "INSERT INTO productSell (productSellCustomerDate, productSellCustomerName, productSellProductName, productSellQuntity, productSellHardCash, productSellCredit, productSellNarration)
        VALUES ('$date', '$customer', '$product', $quantity, '$hardCash', '$credit', '$narration')";

if ($conn->query($sql) === TRUE) {
    // Check if credit amount is greater than 0
    if ($credit > 0) {
        // Insert the record into the "pendingCredit" table
        $pendingCreditSql = "INSERT INTO pendingSellCredit (pendingSellCreditDate, pendingSellCreditCustomerName, pendingSellCreditProductName, pendingSellCreditAmmount, pendingSellCreditNarration)
                             VALUES ('$date', '$customer', '$productName', '$credit', '$narration')";
        $conn->query($pendingCreditSql);
    }

    echo "<script>
    alert('Record saved successfully');
    window.location.href = 'sellProduct.php';
  </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>