<html>
    <?php

    require_once('db.php');
    require_once('functions.php');
    $name =  $_POST["name"];
    
    $sql = "INSERT INTO categories (name)
            VALUES ('$name')";

    if ($conn->query($sql) === TRUE) {
        echo "New category entered successfully <br>";
    } else {
        echo "Error: " . $conn->error;
    }

    echo "<form action ='models/view_models.php' method = 'get'>
            <button type = 'submit'>Inventory</button>
            </form>";  
    ?>

</html>
