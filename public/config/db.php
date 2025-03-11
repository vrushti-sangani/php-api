<?php
$host = "your-database-host";
$user = "your-username";
$password = "your-password";
$dbname = "your-database-name";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
