<html>
    <?php

    $conn = new mysqli("localhost", "root", "Poopcorn2005$","inventory_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id =  $_GET["id"];
    $sql = "DELETE from items WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
        echo "<form action ='../items/inventory.php' method = 'get'>
              <button type = 'submit'>Return to Inventory</button>
              </form>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
