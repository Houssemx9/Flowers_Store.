<?php
$conn = new mysqli('localhost', 'root', '', 'flower_shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $sql = "INSERT INTO flowers (name, description, price, image) VALUES ('$name', '$description', '$price', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "New flower added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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
            
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            width: 50%;
            margin: 0 auto; 
            background-color: #fff; 
            padding: 20px;
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body id="content">
    <div class="container">
        <h2>Add Flower</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea><br>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required><br>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required><br>
            <input type="submit" value="Add Flower" name="submit">
        </form>
    </div>
</body>
</html>
