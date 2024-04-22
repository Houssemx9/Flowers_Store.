<?php
$conn = new mysqli('localhost', 'root', '', 'flower_shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected'])) {
    if (isset($_POST['selected_flowers']) && !empty($_POST['selected_flowers'])) {
        $selected_flowers = implode(',', $_POST['selected_flowers']);
        $sql = "DELETE FROM flowers WHERE id IN ($selected_flowers)";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Selected flowers deleted successfully');</script>";
        } else {
            echo "Error deleting flowers: " . $conn->error;
        }
    } else {
        echo "<script>alert('Please select flowers to delete');</script>";
    }
}

$sql = "SELECT * FROM flowers";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Store</title>
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
<body id="content">
    <h2>All Flowers</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>$" . $row["price"] . "</td>";
                        echo "<td><img src='" . $row["image"] . "' alt='Flower Image' style='width:100px;height:100px;'></td>";
                        echo "<td><input type='checkbox' name='selected_flowers[]' value='" . $row["id"] . "'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='no-flowers'>No flowers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="delete-btn" name="delete_selected">Delete Selected</button>
    </form>
</body>
</html>
