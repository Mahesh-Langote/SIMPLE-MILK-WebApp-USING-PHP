<?php
// Include the config.php file
require_once 'config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $date=$_POST['date'];
    $customer = $_POST['customer'];
    $creditAmount = $_POST['creditAmount'] * -1; // Multiply by -1 to store as a negative value
    $narration = $_POST['narration'];

    // Insert the credit record into the table
    $sql = "INSERT INTO pendingsellcredit (pendingSellCreditDate,pendingSellCreditCustomerName, pendingSellCreditAmmount, pendingSellCreditNarration) VALUES ('$date','$customer', $creditAmount, '$narration')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
    alert('Record saved successfully');
    window.location.href = 'recoverCredit.php';
  </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
