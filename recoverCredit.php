<!DOCTYPE html>
<html>
<head>
    <title>Collect Credit Amount</title>
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
        input[type="text"] {
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

    <h2>Collect Credit Amount</h2>
<h4 style="text-align: center;">Enter here Credit recover details by customer</h4>
    <form action="creditCollection.php" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">

        <label for="customer">Customer Name:</label>
        <select id="customer" name="customer" required>
            <option value="">Select customer</option>
            <?php
            // Include the config.php file
            require_once 'config.php';

            // Fetch and sort customer names from the pendingsellcredit table
            $sqlCustomer = "SELECT DISTINCT pendingSellCreditCustomerName FROM pendingsellcredit ORDER BY pendingSellCreditCustomerName";
            $resultCustomer = $conn->query($sqlCustomer);

            if ($resultCustomer->num_rows > 0) {
                while ($row = $resultCustomer->fetch_assoc()) {
                    echo '<option value="' . $row['pendingSellCreditCustomerName'] . '">' . $row['pendingSellCreditCustomerName'] . '</option>';
                }
            }
            ?>
        </select>

        <label for="creditAmount">Credit Amount:</label>
        <input type="text" id="creditAmount" name="creditAmount" required>

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
