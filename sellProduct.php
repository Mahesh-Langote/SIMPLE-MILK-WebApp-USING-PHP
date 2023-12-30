<!DOCTYPE html>
<html>
<head>
    <title>Entry Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 50px 0;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="date"],
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .no-results {
            color: red;
        }

        .negative-quantity {
            color: red;
        }

        #searchCustomer {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        #searchMessageCustomer {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        @media screen and (max-width: 600px) {
            form {
                max-width: 300px;
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
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        });

        function filterOptions() {
            const inputCustomer = document.getElementById('searchCustomer');
            const filterCustomer = inputCustomer.value.toUpperCase();
            const optionsCustomer = document.querySelectorAll('#customer option');
            let foundResultsCustomer = false;

            for (let i = 0; i < optionsCustomer.length; i++) {
                const text = optionsCustomer[i].text.toUpperCase();
                if (text.indexOf(filterCustomer) > -1) {
                    optionsCustomer[i].style.display = '';
                    optionsCustomer[i].selected = true;
                    foundResultsCustomer = true;
                } else {
                    optionsCustomer[i].style.display = 'none';
                }
            }

            const messageElementCustomer = document.getElementById('searchMessageCustomer');
            if (!foundResultsCustomer) {
                document.getElementById('customer').classList.add('no-results');
                messageElementCustomer.textContent = 'No matching results found.';
            } else {
                document.getElementById('customer').classList.remove('no-results');
                messageElementCustomer.textContent = '';
            }
        }
    </script>
</head>
<body>
    <div class="navbar">
        <div class="navbar-logo">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="navbar-links">
        <a href="index.html"><i class="fas fa-home"></i> Home</a>
            <a href="entry.html"><i class="fas fa-envelope"></i> Entry From</a>
            <a href="report/index.html"><i class="fas fa-map-marker-alt"></i> Report</a>
        </div>
    </div>

    <h2>Entry Form</h2>
<h4 style="text-align: center;">Enter Sales Details Here</h4>
    <form action="productSellRecodeInsert.php" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="searchCustomer">Customer Name:</label>
        <input type="text" id="searchCustomer" onkeyup="filterOptions()" placeholder="Search customer">
        <select id="customer" name="customer" required>
            <option value="">Select customer</option>
            <?php
            // Include the config.php file
            require_once 'config.php';

            // Fetch and sort customer names from the database
            $sqlCustomer = "SELECT customerName FROM customer ORDER BY customerName";
            $resultCustomer = $conn->query($sqlCustomer);

            if ($resultCustomer->num_rows > 0) {
                while ($row = $resultCustomer->fetch_assoc()) {
                    echo '<option value="' . $row['customerName'] . '">' . $row['customerName'] . '</option>';
                }
            }
            ?>
        </select>
        <div id="searchMessageCustomer"></div>

        <label for="product">Product:</label>
        <select id="product" name="product" required>
            <option value="">Select product</option>
            <?php
            // Fetch product names with their company names and remaining quantities from the database
            $sqlProduct = "SELECT pb.productBuyProductName, pb.productBuyProductCompanyName,
                COALESCE(pb.totalQuantityBought, 0) - COALESCE(ps.totalQuantitySold, 0) AS remainingQuantity
                FROM
                (
                    SELECT productBuyProductName, productBuyProductCompanyName, SUM(productBuyQuantity) AS totalQuantityBought
                    FROM productBuy
                    GROUP BY productBuyProductName, productBuyProductCompanyName
                ) AS pb
                LEFT JOIN
                (
                    SELECT productSellProductName, SUM(productSellQuntity) AS totalQuantitySold
                    FROM productSell
                    GROUP BY productSellProductName
                ) AS ps
                ON pb.productBuyProductName = ps.productSellProductName
                ORDER BY pb.productBuyProductName";
            $resultProduct = $conn->query($sqlProduct);

            if ($resultProduct->num_rows > 0) {
                while ($row = $resultProduct->fetch_assoc()) {
                    $productName = $row['productBuyProductName'];
                    $companyName = $row['productBuyProductCompanyName'];
                    $remainingQuantity = $row['remainingQuantity'];
                    $optionClass = ($remainingQuantity < 0) ? 'negative-quantity' : '';

                    echo '<option value="' . $productName . '" class="' . $optionClass . '">' . $productName . ' - ' . $companyName . ' (' . $remainingQuantity . ')</option>';
                }
            }
            ?>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="hardCash">Hard Cash:</label>
        <input type="text" id="hardCash" name="hardCash" required>

        <label for="credit">Credit:</label>
        <input type="text" id="credit" name="credit">

        <label for="narration">Narration:</label>
        <input type="text" id="narration" name="narration">

        <input type="submit" value="Submit">
    </form>

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
