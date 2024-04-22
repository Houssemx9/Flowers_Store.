<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'flower_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $dateAffectation = date('Y-m-d');
    $totalPrice = 0;
    foreach($_SESSION['cart'] as $productId => $quantity) {
        $sql = "SELECT price FROM flowers WHERE id = $productId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalPrice += $row['price'] * $quantity;
        }
    }

    $sqlInsertCommande = "INSERT INTO commande (date_affectation, total_price) VALUES ('$dateAffectation', '$totalPrice')";
    if ($conn->query($sqlInsertCommande) === TRUE) {
        $lastOrderId = $conn->insert_id;
        foreach($_SESSION['cart'] as $productId => $quantity) {
            $sqlInsertCommandeFlowers = "INSERT INTO commande_flowers (commande_id, flower_id, quantity) VALUES ('$lastOrderId', '$productId', '$quantity')";
            $conn->query($sqlInsertCommandeFlowers);
        }
        unset($_SESSION['cart']);
        echo "Order placed successfully!";
    } else {
        echo "Error placing order: " . $conn->error;
    }
} else {
    echo "Your cart is empty!";
}

$conn->close();
?>
