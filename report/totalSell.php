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
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 18px;
            color: #555;
        }

        .total-amount {
            font-size: 24px;
            color: #00a000;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 22px;
            }

            .container {
                padding: 10px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }

            .total-section {
                margin-top: 20px;
            }

            .total-label {
                font-size: 16px;
            }

            .total-amount {
                font-size: 20px;
            }
        }

        /* Navigation styles */
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

        /* Footer styles */
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
        <h2>Complete sales Report</h2>

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
            $sellAmount = 0;

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['productSellId'] . '</td>
                        <td>' . $row['productSellCustomerDate'] . '</td>
                        <td>' . $row['productSellCustomerName'] . '</td>
                        <td>' . $row['productSellProductName'] . '</td>
                        <td>' . $row['productSellQuntity'] . '</td>
                        <td>₹' . $row['productSellHardCash'] . '</td>
                        <td>₹' . $row['productSellCredit'] . '</td>
                        <td>' . $row['productSellNarration'] . '</td>
                    </tr>';

                $totalCredit += (float)$row['productSellCredit'];
                $totalCash += (float)$row['productSellHardCash'];
                $sellAmount += (float)$row['productSellHardCash'] + (float)$row['productSellCredit'];
            }

            echo '</table>';

            echo '<div class="total-section">
                    <span class="total-label">Remaining Total Credit Amount:</span>
                    <span class="total-amount">₹' . $totalCredit . '</span>
                </div>';

            echo '<div class="total-section">
                    <span class="total-label">Total Cash Amount:</span>
                    <span class="total-amount">₹' . $totalCash . '</span>
                </div>';

            echo '<div class="total-section">
                    <span class="total-label">Total Sell Amount:</span>
                    <span class="total-amount">₹' . $sellAmount . '</span>
                </div>';
        } else {
            echo "No records found.";
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
