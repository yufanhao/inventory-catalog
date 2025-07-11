<?php
require_once('../db.php');

$id = intval($_GET['id']);
$sql = "SELECT image, image_type FROM models WHERE id = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    header("Content-Type: " . $row['image_type']);
    echo $row['image'];
} else {
    header("Content-Type: text/plain");
    echo "Image not found.";
}

$conn->close();
exit;
