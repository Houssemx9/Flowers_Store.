<?php
session_start();
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
    <title>Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-items {
            margin-top: 20px;
        }

        .product {
            display: flex;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .product img {
            width: 100px;
            margin-right: 20px;
        }

        .product-details {
            flex: 1;
        }

        .product-details h3 {
            margin: 0;
        }

        .product-details p {
            margin: 5px 0;
        }

        .quantity {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .quantity button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            margin: 0 5px;
            cursor: pointer;
        }

        .quantity span {
            padding: 0 10px;
            font-size: 18px;
        }

        .remove-btn {
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #cc4c3b;
        }

        .empty-cart {
            text-align: center;
            font-size: 18px;
            margin-top: 50px;
        }

        .order-btn {
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            float: right;
        }

        .order-btn:hover {
            background-color: #005f6b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <div class="cart-items">
            <?php
            if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach($_SESSION['cart'] as $productId => $quantity) {
                    $sql = "SELECT * FROM flowers WHERE id = $productId";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<div class='product'>";
                        echo "<img src='../uploads/" . $row["image"] . "' alt='Flower' />";
                        echo "<div class='product-details'>";
                        echo "<h3>" . $row["name"] . "</h3>";
                        echo "<p>Price: $" . $row["price"] . "</p>";
                        echo "<div class='quantity'>";
                        echo "<button onclick='decreaseQuantity($productId)'>-</button>";
                        echo "<span>$quantity</span>";
                        echo "<button onclick='increaseQuantity($productId)'>+</button>";
                        echo "</div>";
                        echo "<button class='remove-btn' onclick='removeFromCart($productId)'>Remove from Cart</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                echo "<button class='order-btn' onclick='placeOrder()'>Passer commande</button>";
            } else {
                echo "<p class='empty-cart'>Your cart is empty</p>";
            }
            ?>
        </div>
    </div>

    <script>
        function removeFromCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "removeFromCart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhr.send("productId=" + productId);
        }

        function decreaseQuantity(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "decreaseQuantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhr.send("productId=" + productId);
        }

        function increaseQuantity(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "increaseQuantity.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    location.reload();
                }
            };
            xhr.send("productId=" + productId);
        }

        function placeOrder() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "placeOrder.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    window.location.href = "../index.php";
                }
            };
            xhr.send();
        }
    </script>
</body>
</html>
