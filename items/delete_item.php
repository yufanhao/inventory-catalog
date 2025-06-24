<html>
    <?php
    require_once('../db.php');

    $id =  $_GET["id"];
    //$name =  $_GET["name"];
    $sql = "DELETE from items WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Item deleted successfully";
        echo "<form action ='../models/view_models.php' method = 'get'>
              <button type = 'submit'>Return to Inventory</button>
              </form>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
