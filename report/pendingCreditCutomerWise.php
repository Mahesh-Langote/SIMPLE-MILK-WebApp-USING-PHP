<!DOCTYPE html>
<html>
<head>
    <title>Pending Credit Records</title>
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

    <div class="container">
        <h2>Pending Credit Records (customer Wise)</h2>

        <?php
        // Include the config.php file
        require_once '../config.php';

        // Retrieve the distinct customer names from the "pendingsellcredit" table
        $sqlCustomer = "SELECT DISTINCT pendingSellCreditCustomerName FROM pendingsellcredit";
        $resultCustomer = $conn->query($sqlCustomer);

        if ($resultCustomer->num_rows > 0) {
            while ($rowCustomer = $resultCustomer->fetch_assoc()) {
                $customerName = $rowCustomer['pendingSellCreditCustomerName'];
                echo '<h3>' . $customerName . '</h3>';

                // Retrieve the records for the specific customer
                $sqlRecords = "SELECT * FROM pendingsellcredit WHERE pendingSellCreditCustomerName = '$customerName'";
                $resultRecords = $conn->query($sqlRecords);

                if ($resultRecords->num_rows > 0) {
                    echo '<table>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Credit</th>
                                <th>Narration</th>
                            </tr>';

                    while ($row = $resultRecords->fetch_assoc()) {
                        echo '<tr>
                                <td>' . $row['pendingSellCreditId'] . '</td>
                                <td>' . $row['pendingSellCreditDate'] . '</td>
                                <td>' . $row['pendingSellCreditCustomerName'] . '</td>
                                <td>' . $row['pendingSellCreditProductName'] . '</td>
                                <td>' . $row['pendingSellCreditAmmount'] . '</td>
                                <td>' . $row['pendingSellCreditNarration'] . '</td>
                            </tr>';
                    }

                    echo '</table>';

                    // Calculate the total credit for the specific customer
                    $sqlTotalCredit = "SELECT SUM(pendingSellCreditAmmount) AS totalCredit FROM pendingsellcredit WHERE pendingSellCreditCustomerName = '$customerName'";
                    $resultTotalCredit = $conn->query($sqlTotalCredit);
                    $rowTotalCredit = $resultTotalCredit->fetch_assoc();
                    $totalCredit = $rowTotalCredit['totalCredit'];

                    echo '<div class="total-section">
                            <p class="total-label"><i class="fas fa-hand-holding-usd"></i> Total Credit:</p>
                            <p class="total-amount"><i class="fas fa-coins"></i> ₹' . $totalCredit . '</p>
                        </div>';
                } else {
                    echo "No records found for this customer.";
                }
            }
        } else {
            echo "No customers found.";
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
