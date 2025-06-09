<?php
$host = "localhost";
$username = "root";
$password = "Poopcorn2005$";
$database = "inventory_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>