<!DOCTYPE html>
<html>
<head>
    <title>Product Buy Records</title>
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

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-right: 5px;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
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

        tr:last-child td {
            border-bottom: none;
        }

        .edit-input {
            width: 100%;
            border: none;
            background-color: transparent;
            padding: 5px;
            font-size: 16px;
        }

        .total-section {
            margin-top: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
            text-align: right;
        }

        .total-label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
            text-align: left;
        }

        .total-amount {
            font-weight: bold;
            color: #00a000;
        }

        .save-button {
            padding: 8px 16px;
            font-size: 16px;
            background-color: #00cc00;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .save-button:hover {
            background-color: #009900;
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

        .logo {
            width: 49px;
            height: 29px;
            margin-left: 11px;
        }

        .navbar-links {
            margin-left: auto;
        }

        .navbar a {
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar a:hover {
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

    <h2>Edit Buying Product Details</h2>
    <h5>Change credit amount or stock details for buying</h5>

    <form action="" method="GET">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" placeholder="Search by product name">
        <input type="submit" value="Search">
    </form>

    <?php
    // Include the config.php file
    require_once '../config.php';

    // Function to render the table cell with editable input field
    function renderEditableCell($fieldName, $value, $inputType, $productId)
    {
        echo '<td><input type="' . $inputType . '" name="' . $fieldName . '[' . $productId . ']" value="' . $value . '" class="edit-input"></td>';
    }

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Iterate through the submitted fields
        foreach ($_POST['productBuyId'] as $productId => $productBuyId) {
            $productBuyVendoreName = $_POST['productBuyVendoreName'][$productId];
            $productBuyProductName = $_POST['productBuyProductName'][$productId];
            $productBuyProductCompanyName = $_POST['productBuyProductCompanyName'][$productId];
            $productBuyQuantity = $_POST['productBuyQuantity'][$productId];
            $productBuyHardCash = $_POST['productBuyHardCash'][$productId];
            $productBuyCredit = $_POST['productBuyCredit'][$productId];
            $productBuyNarration = $_POST['productBuyNarration'][$productId];

            // Update the database record with the new values
            $sqlUpdate = "UPDATE productBuy SET
                productBuyVendoreName = '$productBuyVendoreName',
                productBuyProductName = '$productBuyProductName',
                productBuyProductCompanyName = '$productBuyProductCompanyName',
                productBuyQuantity = '$productBuyQuantity',
                productBuyHardCash = '$productBuyHardCash',
                productBuyCredit = '$productBuyCredit',
                productBuyNarration = '$productBuyNarration'
                WHERE productBuyId = $productBuyId";
            $conn->query($sqlUpdate);
        }

        // Redirect back to the page after saving the changes
        // header('Location: index.html');
        echo '<script>window.location.href = "editProductBuy.php";</script>';
        exit();
    }

    // Retrieve search query from GET request
    $searchQuery = $_GET['search'] ?? '';

    // Construct the SQL query based on the search query
    $sql = "SELECT * FROM productBuy";
    if (!empty($searchQuery)) {
        $sql .= " WHERE productBuyProductName LIKE '%$searchQuery%'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form action="" method="POST">';
        echo '<table>
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
                    <th>Action</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td style="color: #00cc00;">' . $row['productBuyId'] . '<input type="hidden" name="productBuyId[' . $row['productBuyId'] . ']" value="' . $row['productBuyId'] . '"></td>';
            echo '<td>' . $row['productBuyDate'] . '</td>';

            // Render editable cells for Supplier, Product, Company Name, Quantity, Paid Cash, Credit, Narration fields
            renderEditableCell('productBuyVendoreName', $row['productBuyVendoreName'], 'text', $row['productBuyId']);
            renderEditableCell('productBuyProductName', $row['productBuyProductName'], 'text', $row['productBuyId']);
            renderEditableCell('productBuyProductCompanyName', $row['productBuyProductCompanyName'], 'text', $row['productBuyId']);
            renderEditableCell('productBuyQuantity', $row['productBuyQuantity'], 'number', $row['productBuyId']);
            renderEditableCell('productBuyHardCash', $row['productBuyHardCash'], 'text', $row['productBuyId']);
            renderEditableCell('productBuyCredit', $row['productBuyCredit'], 'text', $row['productBuyId']);
            renderEditableCell('productBuyNarration', $row['productBuyNarration'], 'text', $row['productBuyId']);

            // Add the Save button
            echo '<td><input type="submit" value="Save" class="save-button"></td>';

            echo '</tr>';
        }

        echo '</table>';
        echo '</form>';

        // Calculate total paid cash and credit amount
        $sqlPayment = "SELECT SUM(productBuyHardCash) AS totalCash, SUM(productBuyCredit) AS totalCredit FROM productBuy";
        $resultPayment = $conn->query($sqlPayment);

        if ($resultPayment->num_rows > 0) {
            $rowPayment = $resultPayment->fetch_assoc();
            $totalCash = $rowPayment['totalCash'];
            $totalCredit = $rowPayment['totalCredit'];

            echo '<div class="total-section">';
            echo '<div class="total-label">Total Paid Cash: <span class="total-amount">₹' . $totalCash . '</span></div>';
            echo '<div class="total-label">Total Credit Amount: <span class="total-amount">₹' . $totalCredit . '</span></div>';
            echo '</div>';
        } else {
            echo '<div class="total-section">';
            echo '<p>No payment data available.</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No records found.</p>';
    }

    // Close the database connection
    $conn->close();
    ?>

    <div class="footer">
        <div class="footer-nav">
            <a href="#"><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="fas fa-envelope"></i> Contact</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> Address</a>
        </div>
        <div class="footer-content">
            <p>Contact: mahesh@example.com</p>
            <p>Address: 1234 Street, City, Country</p>
        </div>
        <p>&copy; 2023 Developed By Mahesh ❤. All rights reserved.</p>
    </div>
</body>
</html>
