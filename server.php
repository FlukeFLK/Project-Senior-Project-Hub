<?php
// Database configuration
// $host = 'localhost';
// $username = 'sudigite_sn085'; // Your actual database username
// $password = 'senior085'; // Your actual database password
// $dbName = 'sudigite_sn085'; // Your database name


$host = 'localhost';
$username = 'root'; // Your actual database username
$password = ''; // Your actual database password
$dbName = 'sph_db'; // Your database name

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbName);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
