<?php
$conn = new mysqli('localhost', 'root', '', 'flower_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Orders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f3f3f3;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td img {
            max-width: 80px;
            max-height: 80px;
            display: block;
            margin: auto;
        }
        .no-flowers {
            text-align: center;
            font-style: italic;
            color: #888;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div id="content">
        <h2>Review Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Flower</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT cf.commande_id, f.name AS flower_name, 
                        cf.quantity, f.price AS unit_price, 
                        c.total_price AS total_price
                        FROM commande_flowers cf 
                        JOIN flowers f ON cf.flower_id = f.id
                        JOIN commande c ON cf.commande_id = c.id
                        ORDER BY cf.commande_id";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    $current_order_id = null;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        if ($current_order_id != $row["commande_id"]) {
                            echo "<td rowspan='2'>" . $row["commande_id"] . "</td>";
                            $current_order_id = $row["commande_id"];
                        }
                        echo "<td>" . $row["flower_name"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>$" . $row["unit_price"] . "</td>";
                        if (!isset($total_price_displayed[$row["commande_id"]])) {
                            echo "<td rowspan='2'>Total : $" . $row["total_price"] . "</td>";
                            $total_price_displayed[$row["commande_id"]] = true;
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
