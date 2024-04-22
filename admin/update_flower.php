<?php
$conn = new mysqli('localhost', 'root', '', 'flower_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        
        $stmt = $conn->prepare("UPDATE flowers SET name=?, description=?, price=? WHERE id=?");
        $stmt->bind_param("ssdi", $name, $description, $price, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Flower updated successfully'); window.location.href = '/flowers_store/admin';</script>";
        } else {
            echo "<script>alert('Error updating flower');</script>";
        }
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}

$sql = "SELECT * FROM flowers";
$result = $conn->query($sql);
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 1px solid #888;
            width: 50%; 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body id="content">
    <h2>All Flowers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Update</th> 
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
                    echo "<td><a href='javascript:void(0);' onclick='showUpdateForm(" . $row["id"] . ")'>Update</a></td>";
                    echo "</tr>";
                    echo "<tr class='modal' id='update-form-" . $row["id"] . "'>";
                    echo "<td colspan='6'>";
                    echo "<div class='modal-content'>";
                    echo "<span class='close' onclick='closeModal(" . $row["id"] . ")'>&times;</span>";
                    echo "<form method='post' action='update_flower.php'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<label for='name-" . $row["id"] . "'>Name:</label>";
                    echo "<input type='text' id='name-" . $row["id"] . "' name='name' value='" . $row["name"] . "' required>";
                    echo "<label for='description-" . $row["id"] . "'>Description:</label>";
                    echo "<textarea id='description-" . $row["id"] . "' name='description' rows='4' required>" . $row["description"] . "</textarea>";
                    echo "<label for='price-" . $row["id"] . "'>Price:</label>";
                    echo "<input type='text' id='price-" . $row["id"] . "' name='price' value='" . $row["price"] . "' required>";
                    echo "<input type='submit' value='Update Flower'>";
                    echo "</form>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-flowers'>No flowers found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function showUpdateForm(id) {
            var modal = document.getElementById('update-form-' + id);
            modal.style.display = 'block';
        }
        function closeModal(id) {
            var modal = document.getElementById('update-form-' + id);
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
