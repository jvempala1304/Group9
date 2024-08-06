<?php
session_start();
$pageTitle = 'Home'; 
include '../templates/header.php';

// Database configuration
$host = 'localhost';  
$username = 'root';   
$password = '';       

// Create a connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists
$db_check = $conn->query("SHOW DATABASES LIKE 'auto_parts_store'");
if ($db_check->num_rows == 0) {
    // Create database if it doesn't exist
    $conn->query("CREATE DATABASE auto_parts_store");
    $conn->select_db('auto_parts_store');

    // Create tables
    $conn->query("CREATE TABLE Users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(50),
        last_name VARCHAR(50),
        address TEXT,
        phone VARCHAR(15),
        registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

}

?>

<?php
include '../templates/footer.php';
?>