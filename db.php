<?php
$config = include('config.php');

$db_host = $config['HOSTNAME'];
$db_user = $config['USERNAME'];
$db_pass = $config['PASSWORD'];
$db_name = $config['DB'];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>