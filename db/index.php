<?php
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SHOW DATABASES LIKE 'flower_shop'");
if ($result->num_rows == 0) {
    $sql_create_db = "CREATE DATABASE flower_shop";
    if ($conn->query($sql_create_db) === TRUE) {
        echo "Database created successfully<br>";
    } else {
        echo "Error creating database: " . $conn->error . "<br>";
    }
} else {
    echo "Database already exists<br>";
}

$conn->select_db('flower_shop');

$result = $conn->query("SHOW TABLES LIKE 'flowers'");
if ($result->num_rows == 0) {
    $sql_create_flowers_table = "CREATE TABLE flowers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description VARCHAR(200) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        image VARCHAR(255) NOT NULL
    )";
    if ($conn->query($sql_create_flowers_table) === TRUE) {
        echo "Flowers table created successfully<br>";
    } else {
        echo "Error creating flowers table: " . $conn->error . "<br>";
    }
} else {
    echo "Flowers table already exists<br>";
}

$result = $conn->query("SHOW TABLES LIKE 'customers'");
if ($result->num_rows == 0) {
    $sql_create_customers_table = "CREATE TABLE customers (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname name VARCHAR(50) NOT NULL,
        password VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL
    )";
    if ($conn->query($sql_create_customers_table) === TRUE) {
        echo "Customers table created successfully<br>";
    } else {
        echo "Error creating customers table: " . $conn->error . "<br>";
    }
} else {
    echo "Customers table already exists<br>";
}
$result = $conn->query("SHOW TABLES LIKE 'commande'");
if ($result->num_rows == 0) {
    $sql_create_commande_table = "CREATE TABLE commande (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        date_affectation DATE,
        total_price DECIMAL(10, 2)
    )";
    if ($conn->query($sql_create_commande_table) === TRUE) {
        echo "Commande table created successfully<br>";
    } else {
        echo "Error creating commande table: " . $conn->error . "<br>";
    }
} else {
    echo "Commande table already exists<br>";
}


$sql_create_commande_flowers_table = "CREATE TABLE commande_flowers (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    commande_id INT(6) UNSIGNED,
    flower_id INT(6) UNSIGNED,
    quantity INT(6) UNSIGNED,
    FOREIGN KEY (commande_id) REFERENCES commande(id),
    FOREIGN KEY (flower_id) REFERENCES flowers(id)
)";

if ($conn->query($sql_create_commande_flowers_table) === TRUE) {
    echo "Commande_Flowers table created successfully<br>";
} else {
    echo "Error creating commande_flowers table: " . $conn->error . "<br>";
}


$conn->close();
?>