<!DOCTYPE html>
<html>
<head>
    <title>Product Buy Records</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Product Buy Records</h2>

    <?php
    // Include the config.php file
    require_once '../config.php';

    // Retrieve all records from the "productBuy" table
    $sql = "SELECT * FROM productBuy";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        '<table>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Product</th>
                    <th>Company Name</th>
                    <th>Quantity</th>
                    <th>Paid Cash</th>
                    <th>Credit</th>
                    <th>Narration</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
         '<tr>
                    <td>' . $row['productBuyId'] . '</td>
                    <td>' . $row['productBuyDate'] . '</td>
                    <td>' . $row['productBuyVendoreName'] . '</td>
                    <td>' . $row['productBuyProductName'] . '</td>
                    <td>' . $row['productBuyProductCompanyName'] . '</td>
                    <td>' . $row['productBuyQuantity'] . '</td>
                    <td>' . $row['productBuyHardCash'] . '</td>
                    <td>' . $row['productBuyCredit'] . '</td>
                    <td>' . $row['productBuyNarration'] . '</td>
                </tr>';
        }

        // echo '</table>';

        // Calculate total paid cash and credit amount
        $sqlPayment = "SELECT SUM(productBuyHardCash) AS totalCash, SUM(productBuyCredit) AS totalCredit FROM productBuy";
        $resultPayment = $conn->query($sqlPayment);

        if ($resultPayment->num_rows > 0) {
            $rowPayment = $resultPayment->fetch_assoc();
            $totalCash = $rowPayment['totalCash'];
            $totalCredit = $rowPayment['totalCredit'];
            $buyAmmount = $totalCash + $totalCredit;

            echo '<h3>Total Payment</h3>';
            echo '<p>Total Buy Amount: ' . $buyAmmount . '</p>';
            echo '<p>Total Paid Cash: ' . $totalCash . '</p>';
            echo '<p>Total Credit Amount: ' . $totalCredit . '</p>';
            
        } else {
            echo '<h3>Total Payment</h3>';
            echo 'No payment data available.';
        }
    } else {
        echo '<p>No records found.</p>';
    }

    // Retrieve product-wise totals
    $sqlProductTotals = "SELECT productBuyProductName, SUM(productBuyQuantity) AS productTotalQuantity, SUM(productBuyHardCash) AS productTotalCash, SUM(productBuyCredit) AS productTotalCredit, (SUM(productBuyHardCash) + SUM(productBuyCredit)) AS productTotalPayment FROM productBuy GROUP BY productBuyProductName";
    $resultProductTotals = $conn->query($sqlProductTotals);

    if ($resultProductTotals->num_rows > 0) {
        // echo '<h3>Product-wise Total Payment</h3>';
         '<table>
                <tr>
                    <th>Product Name</th>
                    <th>Total Quantity</th>
                    <th>Total Paid Cash</th>
                    <th>Total Credit Amount</th>
                    <th>Total Payment</th>
                </tr>';

        while ($rowProductTotal = $resultProductTotals->fetch_assoc()) {
            $productName = $rowProductTotal['productBuyProductName'];
            $productTotalQuantity = $rowProductTotal['productTotalQuantity'];
            $productTotalCash = $rowProductTotal['productTotalCash'];
            $productTotalCredit = $rowProductTotal['productTotalCredit'];
            $productTotalPayment = $rowProductTotal['productTotalPayment'];

             '<tr>
                    <td>' . $productName . '</td>
                    <td>' . $productTotalQuantity . '</td>
                    <td>' . $productTotalCash . '</td>
                    <td>' . $productTotalCredit . '</td>
                    <td>' . $productTotalPayment . '</td>
                </tr>';
        }

        // echo '</table>';

        // Calculate total product payment
        $sqlProductPayment = "SELECT SUM(productBuyHardCash) + SUM(productBuyCredit) AS totalProductPayment FROM productBuy";
        $resultProductPayment = $conn->query($sqlProductPayment);

        if ($resultProductPayment->num_rows > 0) {
            $rowProductPayment = $resultProductPayment->fetch_assoc();
            // $totalProductPayment = $rowProductPayment['totalProductPayment'];

            // echo '<h3>Total Product Payment</h3>';
            // echo '<p>Total Payment: ' . $totalProductPayment . '</p>';
        } else {
            echo '<h3>Total Product Payment</h3>';
            echo 'No product payment data available.';
        }
    } else {
        echo '<h3>Product-wise Total Payment</h3>';
        echo 'No product-wise payment data available.';
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
