<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'flower_shop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM flowers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Flower Store</title>
    <style>
       .product-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            overflow: hidden;
            margin-bottom: 20px;
            max-width: 300px; 
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 200px; 
            object-fit: cover; 
            display: block;
            border-bottom: 1px solid #ddd; 
        }

        .product-card .product-details {
            padding: 10px;
        }

        .product-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
        }

        .product-card p {
            margin: 0;
            font-size: 1em;
            color: #333;
        }

        .product-card button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: auto;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .product-card button:hover {
            background-color: #45a049;
        }

    </style>
    <link rel="stylesheet" href="assets/css/styles.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="nav-img">
        <img
          class="logo"
          src="assets/images/logo/logo.png"
          alt="logo"
        />
        <h4 class="logo-text">BOUQUET LIVRE</h4>
      </div>
      <div>
        <ul class="nav-items">
          <li><a class="active">Home</a></li>
          <li><a href="#store">Shop</a></li>
          <li><a href="php/cart.php">Cart</a></li>
          <li><a>Contact</a></li>
          <li><a href="/flowers_store/connexion">Login</a></li>
        </ul>
      </div>
    </nav>
    <header class="slideshow-container">    
      <div class="mySlides fade">      
        <img  class="img-slide" src="assets/images/slideshow/slide1.jpg" >       
      </div>     
      <div class="mySlides fade">        
        <img  class="img-slide" src="assets/images/slideshow/slide2.jpg" >    
      </div>      
      <div class="mySlides fade">
        <img  class="img-slide" src="assets/images/slideshow/slide3.jpg" >
      </div>
    </br>
      <div style="text-align:center">
        <span class="dot"></span> 
        <span class="dot"></span> 
        <span class="dot"></span> 
      </div>
      
    </header>

    <div class="container">
      <div class="content">
        <div></div>
        <h1>Welcome to Our Flower Store</h1>
        <p>Discover a wide variety of beautiful flowers for all occasions.</p>
        <h2>Featured Products</h2>
      </div>
 
      <div id="store" class="featured-products">
      
        <?php
    
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product-card'>";
                    echo "<img src='uploads/" . $row["image"] . "' alt='Flower' />";
                    echo "<div class='product-details'>";
                    echo "<h3>" . $row["name"] . "</h3>";
                    echo "<p>$" . $row["price"] . "</p>";
                    echo "<button onclick='addToCart(" . $row["id"] . ")'>Add to Cart</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No flowers found";
            }
        ?>
      </div>
      <footer>
      <p>&copy; 2024 BOUQUET LIVRE. All rights reserved.</p>
    </footer>
    <script src="assets/js/script.js"></script>
    <script>
      function addToCart(productId) {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "php/addToCart.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  alert(this.responseText);
              }
          };
          xhr.send("productId=" + productId);
      }
    </script>
  </body>
</html>
