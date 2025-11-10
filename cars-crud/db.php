<?php
// db.php - FIXED VERSION FOR XAMPP (Windows + Morocco timezone)

$host = 'localhost';
$user = 'root';
$pass = '';          // default XAMPP password is empty
$dbname = 'car_db';

// Step 1: Connect WITHOUT selecting database
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

// Step 3: Now select the database
$conn->select_db($dbname);

// Step 4: Create table + all columns (with JSON for images)
$createTable = "
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(100),
    model VARCHAR(100),
    price DECIMAL(12,2) NOT NULL,
    fuel_type ENUM('Petrol', 'Diesel', 'Electric', 'Hybrid') DEFAULT 'Petrol',
    color VARCHAR(50),
    seats TINYINT DEFAULT 5,
    transmission ENUM('Manual', 'Automatic') DEFAULT 'Manual',
    horsepower INT,
    description TEXT,
    images JSON DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($conn->query($createTable) === TRUE) {
    // Table created or already exists
} else {
    die("Error creating table: " . $conn->error);
}

// Optional: Set Morocco timezone (Rabat/Casablanca)
$conn->query("SET time_zone = '+01:00'");

?>