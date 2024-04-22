<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Store</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f3f3f3;
        }
        #sidebar {
            width: 200px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            height: 88vh; 
            overflow-y: auto;
        }
        #sidebar a {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        #sidebar a:hover {
            background-color: #f2f2f2;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <a href="index.php?page=review_flowers">All Flowers</a>
        <a href="index.php?page=add_flower">Add Flower</a>
        <a href="index.php?page=update_flower">Update Flower</a>
        <a href="index.php?page=gerer_inscription">Gerer Inscription</a>
        <a href="index.php?page=review_commands">Review Commands</a>
    </div>
    <div id="content">
        <h2>Flower Store</h2>
        <?php
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
                if($page == 'add_flower') {
                    include 'add_flower.php'; 
                } elseif($page == 'review_flowers') {
                    include 'review_flowers.php'; 
                } elseif($page == 'update_flower') {
                    include 'update_flower.php'; 
                }elseif($page == 'gerer_inscription') {
                    include 'gerer_inscription.php'; 
                }elseif($page == 'review_commands') {
                    include 'review_commands.php'; 
                } else {
                    echo "Page not found";
                }
            } else {
               
                include 'review_flowers.php';
            }
        ?>
    </div>
</body>
</html>
