<!DOCTYPE html>
<html>
<head>
    <title>Product Sell Records</title>
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
        
        .total-credit, .total-cash {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Product Sell Records</h2>
  
    <?php
    // Include the config.php file
    require_once '../config.php';

    // Retrieve all records from the "productSell" table
    $sql = "SELECT * FROM productSell";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Hard Cash</th>
                    <th>Credit</th>
                    <th>Narration</th>
                </tr>';
        
        $totalCredit = 0;
        $totalCash = 0;
        $sellAmmount=0 ;
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['productSellId'] . '</td>
                    <td>' . $row['productSellCustomerDate'] . '</td>
                    <td>' . $row['productSellCustomerName'] . '</td>
                    <td>' . $row['productSellProductName'] . '</td>
                    <td>' . $row['productSellQuntity'] . '</td>
                    <td>' . $row['productSellHardCash'] . '</td>
                    <td>' . $row['productSellCredit'] . '</td>
                    <td>' . $row['productSellNarration'] . '</td>
                </tr>';
            
            $totalCredit += (float)$row['productSellCredit'];
            $totalCash += (float)$row['productSellHardCash'];
            $sellAmmount +=(float)$row['productSellHardCash'] + (float)$row['productSellCredit'];
        }
        
        '</table>';
        
        echo '<p class="total-credit">Remaining Total Credit Amount: ' . $totalCredit . '</p>';
        echo '<p class="total-cash">Total Cash Amount: ' . $totalCash . '</p>';
        echo '<p class="total-cash">Total Sell Amount: ' . $sellAmmount . '</p>';
    } else {
        echo "No records found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
