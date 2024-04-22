<?php
session_start();

if(isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    if(isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}
?>
