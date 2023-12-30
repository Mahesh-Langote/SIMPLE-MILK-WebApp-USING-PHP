<!DOCTYPE html>
<html>
<head>
    <title>Product Buy Records</title>
    <link rel="stylesheet" href="../style.css">
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

        .table-container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .table-container h3 {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 10px;
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
            font-size: 14px;
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

        .rupee-icon {
            margin-right: 5px;
        }

        .total-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* margin-top: 20px; */
        }

        .total-label {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #555;
        }

        .total-amount {
            font-size: 18px;
            color: #00a000;
            font-weight: bold;
        }

        .total-label i, .total-amount i {
            margin-right: 5px;
        }

        /* Updated Navigation bar styles */
        .navbar {
            background-color: #333;
            overflow: hidden;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
        }

        .navbar-logo {
            margin-right: auto;
        }

        .navbar-logo img {
            width: 49px;
            height: 29px;
            margin-left: 11px;
        }

        .navbar-links {
            margin-left: auto;
        }

        .navbar-links a {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar-links a:hover {
            background-color: #007bff;
        }

        /* Updated Footer styles */
        .footer {
            background-color: #333;
            padding: 20px;
            font-size: 14px;
            color: #fff;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-nav {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .footer-nav a {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
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
            <img src="../logo.png" alt="Cow Logo" class="logo">
        </div>
        <div class="navbar-links">
        <a href="../index.html"><i class="fas fa-home"></i> Home</a>
            <a href="../entry.html"><i class="fas fa-envelope"></i> Entry From</a>
            <a href="index.html"><i class="fas fa-map-marker-alt"></i> Report</a>
        </div>
    </div>

    <h2>Product Buy Records (Cash and Credit Details)</h2>

    <?php
    // Include the config.php file
    require_once '../config.php';

    // Retrieve all records from the "productBuy" table
    $sql = "SELECT * FROM productBuy";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="table-container">
                <h3>Product Buy Records</h3>
                <table>
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
            echo '<tr>
                    <td>' . $row['productBuyId'] . '</td>
                    <td>' . $row['productBuyDate'] . '</td>
                    <td>' . $row['productBuyVendoreName'] . '</td>
                    <td>' . $row['productBuyProductName'] . '</td>
                    <td>' . $row['productBuyProductCompanyName'] . '</td>
                    <td>' . $row['productBuyQuantity'] . '</td>
                    <td><i class="rupee-icon">₹</i>' . $row['productBuyHardCash'] . '</td>
                    <td><i class="rupee-icon">₹</i>' . $row['productBuyCredit'] . '</td>
                    <td>' . $row['productBuyNarration'] . '</td>
                </tr>';
        }

        echo '</table>';

        // Calculate total paid cash and credit amount
        $sqlPayment = "SELECT SUM(productBuyHardCash) AS totalCash, SUM(productBuyCredit) AS totalCredit FROM productBuy";
        $resultPayment = $conn->query($sqlPayment);

        if ($resultPayment->num_rows > 0) {
            $rowPayment = $resultPayment->fetch_assoc();
            $totalCash = $rowPayment['totalCash'];
            $totalCredit = $rowPayment['totalCredit'];
            $buyAmount = $totalCash + $totalCredit;

            echo '<div class="table-container">
                    <h3>Total Payment</h3>
                    <div class="total-section">
                        <p class="total-label"><i class="rupee-icon">₹</i>Total Buy Amount:</p>
                        <p class="total-amount"><i class="rupee-icon">₹</i>' . $buyAmount . '</p>
                    </div>
                    <div class="total-section">
                        <p class="total-label"><i class="rupee-icon">₹</i>Total Paid Cash:</p>
                        <p class="total-amount"><i class="rupee-icon">₹</i>' . $totalCash . '</p>
                    </div>
                    <div class="total-section">
                        <p class="total-label"><i class="rupee-icon">₹</i>Total Credit Amount:</p>
                        <p class="total-amount"><i class="rupee-icon">₹</i>' . $totalCredit . '</p>
                    </div>
                </div>';
        } else {
            echo '<div class="table-container">
                    <h3>Total Payment</h3>
                    <p>No payment data available.</p>
                </div>';
        }
    } else {
        echo '<p>No records found.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>

    <div class="footer">
        <div class="footer-nav">
        <a href="../index.html"><i class="fas fa-home"></i> Home</a>
            <a href="../entry.html"><i class="fas fa-envelope"></i> Entry From</a>
            <a href="index.html"><i class="fas fa-map-marker-alt"></i> Report</a>
        </div>
        <div class="footer-content">
            <p>Contact: mahesh@example.com</p>
            <p>Address: 1234 Street, City, Country</p>
            <p>&copy; 2023 Developed By Mahesh ❤. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
