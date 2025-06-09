<html>
    <?php
    $conn = new mysqli("localhost", "root", "Poopcorn2005$","inventory_db");

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $name =  $_POST["name"];
    $category = $_POST["category"];
    $image_url = $_POST["image_url"];
    $expiration = $_POST["expiration"];

    $sql = "INSERT INTO items (name, category, image_url, expiration) VALUES ('$name', '$category', '$image_url', '$expiration')";

    if ($conn->query($sql) === TRUE) {
        echo "New item entered successfully <br>";
    } else {
        echo "Error: " . $conn->error;
    }
    echo "<form action ='inventory.php' method = 'get'>
            <button type = 'submit'>Inventory list</button>
            </form>";

    $conn->close();
    ?>
    
</html>
