<!DOCTYPE html>
<html>
<head>
    <title>Product Sell Records</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-xhFLIYkk5yzsXy8JsoJdQobS4KOHxgK5PlZU5P+uzUWmQF9tIUhIB1X1E57Mrg5yL7EJoX7Am3KExKTHO2u8PQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:nth-child(odd) {
            background-color: #ebebeb;
        }

        tr:last-child td {
            border-bottom: none;
        }

        p {
            margin-top: 10px;
            color: #555;
            font-weight: bold;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .total-label {
            display: flex;
            align-items: center;
            font-size: 18px;
            color: #555;
        }

        .total-amount {
            font-size: 24px;
            color: #00a000;
            font-weight: bold;
        }

        .total-label i, .total-amount i {
            margin-right: 5px;
        }

        /* Updated Navigation styles */
        .navbar {
            background-color: #333;
            padding: 20px;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .navbar-logo {
            margin-right: 10px;
        }

        .navbar-logo img {
            height: 30px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .navbar-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        .navbar-links a:hover {
            color: #007bff;
        }
        
        /* Updated Footer styles */
        .footer {
            background-color: #333;
            padding: 20px;
            font-size: 14px;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
        }

        .footer-nav {
            margin-top: 10px;
        }

        .footer-nav a {
            display: inline-block;
            margin: 0 10px;
            color: #fff;
            text-decoration: none;
        }

        .footer-nav a:hover {
            color: #007bff;
        }

        .footer-nav a i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-logo">
            <img src="../logo.png" alt="Logo">
        </div>
        <div class="navbar-links">
        <a href="../index.html"><i class="fas fa-home"></i> Home</a>
            <a href="../entry.html"><i class="fas fa-envelope"></i> Entry From</a>
            <a href="index.html"><i class="fas fa-map-marker-alt"></i> Report</a>
        </div>
    </div>

    <div class="container">
        <h2>Product wise Sales </h2>
  
        <?php
        // Include the config.php file
        require_once '../config.php';

        // Retrieve unique product names from the "productSell" table
        $sqlProducts = "SELECT DISTINCT productSellProductName FROM productSell";
        $resultProducts = $conn->query($sqlProducts);

        if ($resultProducts->num_rows > 0) {
            // Iterate through each product
            while ($rowProduct = $resultProducts->fetch_assoc()) {
                $productName = $rowProduct['productSellProductName'];

                // Retrieve the company name for the current product
                $sqlCompany = "SELECT productBuyProductCompanyName FROM productbuy WHERE productBuyProductName = '$productName'";
                $resultCompany = $conn->query($sqlCompany);
                $rowCompany = $resultCompany->fetch_assoc();
                $companyName = $rowCompany['productBuyProductCompanyName'];

                echo "<h3>$productName ($companyName)</h3>";

                // Retrieve records for the current product from the "productBuy" table
                $sqlBuyRecords = "SELECT * FROM productBuy WHERE productBuyProductName = '$productName'";
                $resultBuyRecords = $conn->query($sqlBuyRecords);

                // Retrieve records for the current product from the "productSell" table
                $sqlSellRecords = "SELECT * FROM productSell WHERE productSellProductName = '$productName'";
                $resultSellRecords = $conn->query($sqlSellRecords);

                if ($resultBuyRecords->num_rows > 0 || $resultSellRecords->num_rows > 0) {
                    echo '<table>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity Bought</th>
                                <th>Quantity Sold</th>
                                <th>Quantity Remaining</th> 
                            </tr>';

                    $totalQuantityBought = 0;
                    $totalQuantitySold = 0;

                    // Calculate the total quantity bought
                    while ($rowBuyRecord = $resultBuyRecords->fetch_assoc()) {
                        $quantityBought = intval($rowBuyRecord['productBuyQuantity']);
                        $totalQuantityBought += $quantityBought;

                        echo '<tr>
                                <td>' . $rowBuyRecord['productBuyId'] . '</td>
                                <td>' . $rowBuyRecord['productBuyDate'] . '</td>
                                <td>' . $rowBuyRecord['productBuyVendoreName'] . '</td>
                                <td>' . $rowBuyRecord['productBuyProductName'] . '</td>
                                <td>' . $quantityBought . '</td>
                                <td>0</td>
                                <td>' . $quantityBought . '</td> 
                            </tr>';
                    }

                    // Calculate the total quantity sold and remaining quantity
                    while ($rowSellRecord = $resultSellRecords->fetch_assoc()) {
                        $quantitySold = intval($rowSellRecord['productSellQuntity']);
                        $totalQuantitySold += $quantitySold;
                        $quantityRemaining = $totalQuantityBought - $totalQuantitySold;

                        echo '<tr>
                                <td>' . $rowSellRecord['productSellId'] . '</td>
                                <td>' . $rowSellRecord['productSellCustomerDate'] . '</td>
                                <td>' . $rowSellRecord['productSellCustomerName'] . '</td>
                                <td>' . $rowSellRecord['productSellProductName'] . '</td>
                                <td>0</td>
                                <td>' . $quantitySold . '</td>
                                <td>' . $quantityRemaining . '</td> 
                            </tr>';
                    }

                    echo '</table>';

                    // Display the total quantity bought and remaining quantity for the current product
                    echo '<div class="total-section">
                            <p class="total-label"><i class="fas fa-cubes"></i> Total Quantity Bought:</p>
                            <p class="total-amount"><i class="fas fa-plus"></i> ' . $totalQuantityBought . '</p>
                        </div>';

                    echo '<div class="total-section">
                            <p class="total-label"><i class="fas fa-cubes"></i> Total Quantity Remaining:</p>
                            <p class="total-amount"><i class="fas fa-equals"></i> ' . $quantityRemaining . '</p>
                        </div>';
                } else {
                    echo "No records found for $productName.";
                }
            }
        } else {
            echo "No products found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <div class="footer">
        <div class="footer-nav">
            <a href="#"><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="fas fa-envelope"></i> Contact</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Address</a>
        </div>
        <div class="footer-content">
            <p>Contact: mahesh@example.com</p>
            <p>Address: 1234 Street, City, Country</p>
            <p>&copy; 2023 Developed By Mahesh ❤. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
