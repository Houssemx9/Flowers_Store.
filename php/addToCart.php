<?php
session_start();

if(isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    if(!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    
    echo "Product added to cart successfully!";
}
?>
