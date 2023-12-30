<!DOCTYPE html>
<html>
<head>
    <title>Pending Credit Records</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body{
            padding: 100px;
        }
        table {
            border-collapse: collapse;
            width: 20%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .sort-link {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }

        .sort-buttons {
            margin-bottom: 10px;
        }
    </style>
    <script>
        function sortTable(columnIndex) {
            const table = document.getElementById("creditTable");
            const rows = Array.from(table.getElementsByTagName("tr"));
            const headerRow = rows.shift(); // Remove header row from sorting

            rows.sort((a, b) => {
                const cellA = a.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                const cellB = b.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                return cellA.localeCompare(cellB);
            });

            // Clear existing table rows
            while (table.rows.length > 0) {
                table.deleteRow(0);
            }

            // Re-add header row
            table.appendChild(headerRow);

            // Re-add sorted rows
            rows.forEach(row => table.appendChild(row));
        }
    </script>
</head>
<body>
    <h2>Pending Credit Records</h2>

    <div class="sort-buttons">
        <button onclick="sortTable(1)">Sort by Date</button>
        <button onclick="sortTable(2)">Sort by Customer</button>
        <button onclick="sortTable(4)">Sort by Credit</button>
    </div>

    <?php
    // Include the config.php file
    require_once '../config.php';

    // Retrieve the distinct customer names from the "pendingsellcredit" table
    $sqlCustomer = "SELECT DISTINCT pendingSellCreditCustomerName FROM pendingsellcredit";
    $resultCustomer = $conn->query($sqlCustomer);

    if ($resultCustomer->num_rows > 0) {
        echo '<table id="creditTable">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Credit</th>
                    <th>Narration</th>
                </tr>';

        $totalCredit = 0;

        while ($rowCustomer = $resultCustomer->fetch_assoc()) {
            $customerName = $rowCustomer['pendingSellCreditCustomerName'];
            $sqlRecords = "SELECT * FROM pendingsellcredit WHERE pendingSellCreditCustomerName = '$customerName'";
            $resultRecords = $conn->query($sqlRecords);

            if ($resultRecords->num_rows > 0) {
                while ($row = $resultRecords->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row['pendingSellCreditId'] . '</td>
                            <td>' . $row['pendingSellCreditDate'] . '</td>
                            <td>' . $row['pendingSellCreditCustomerName'] . '</td>
                            <td>' . $row['pendingSellCreditProductName'] . '</td>
                            <td>' . $row['pendingSellCreditAmmount'] . '</td>
                            <td>' . $row['pendingSellCreditNarration'] . '</td>
                        </tr>';

                    $totalCredit += (float)$row['pendingSellCreditAmmount'];
                }
            }
        }

        echo '</table>';

        // Display the total credit value
        echo '<p>Total Credit: ' . $totalCredit . '</p>';
    } else {
        echo "No customers found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
