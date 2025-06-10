<html>
    <?php
    require_once(__DIR__ . '/../db.php');


    $id =  $_GET["id"];
    $sql = "SELECT * from items WHERE id = $id";

    if ($conn->query($sql) !== FALSE) {
        $result = $conn->query($sql);
        echo "Item retrieved successfully! <br>";
        while ($row = $result->fetch_assoc()) {
            echo "Item ID: " . htmlspecialchars($row['id']) . "<br>";
            echo "Name: " . htmlspecialchars($row['name']) . "<br>";
            echo "Category: " . htmlspecialchars($row['category']) . "<br>";
            echo "Expiration: " . htmlspecialchars($row['expiration']) . "<br>";
            echo "Image: " . htmlspecialchars($row['image_url']) . "<br>";
        }         
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
