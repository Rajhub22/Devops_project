<?php
$host = 'localhost'; // Database host
$username = 'root'; // Database username (use your own credentials)
$password = ''; // Database password (use your own credentials)
$dbname = 'aura_amour'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
