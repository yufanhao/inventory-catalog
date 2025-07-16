<html>
    <?php
    require_once('../db.php');
    $name =  $_POST["name"];
    $desc =  $_POST["desc"];
    
    $sql = "INSERT INTO categories (name, description)
            VALUES ('$name', '$desc')";

    if ($conn->query($sql) === TRUE) {
        echo "New category entered successfully <br>";
    } else {
        echo "Error: " . $conn->error;
    }

    echo "<form action ='../models/view_models.php' method = 'get'>
            <button type = 'submit'>Inventory</button>
            </form>";  
    ?>

</html>
