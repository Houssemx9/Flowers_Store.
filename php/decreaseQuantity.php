<?php
session_start();

if(isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    if(isset($_SESSION['cart'][$productId]) && $_SESSION['cart'][$productId] > 1) {
        $_SESSION['cart'][$productId]--;
    }
}
?>
