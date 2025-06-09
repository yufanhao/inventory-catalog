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
    $box_number = $_POST["box_number"];

    $box_check_sql = "SELECT * FROM boxes WHERE number = '$box_number'";
    $box_check_result = $conn->query($box_check_sql);
    if ($box_check_result->num_rows <= 0) {
        echo "Box number $box_number does not exist. Please create a box first.";
        echo "<form action ='../boxes/insert_box.php' method = 'post'>
                Box Number: <input type='number' name='box_number'><br>
                Cabinet Number: <input type='text' name='cabinet_number'><br>
                <input type='hidden' name='name' value='$name'>
                <input type='hidden' name='category' value='$category'>
                <input type='hidden' name='image_url' value='$image_url'>
                <input type='hidden' name='expiration' value='$expiration'>
                <button type = 'submit'>Create Box</button> 
                </form>";

        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
                </form>";
        $conn->close();
        exit();
    }
    else {
        $item_id = $conn->insert_id;
        $box_id_sql = "SELECT id FROM boxes WHERE box_number = '$box_number'";
        $box_id = $conn->query($box_id_sql);
        $sql = "INSERT INTO items (name, category, image_url, expiration) VALUES ('$name', '$category', '$image_url', '$expiration')";
        $joinsql = "INSERT INTO item_box_join (item_id, box_id) VALUES ('$item_id', '$box_id')";
        if ($conn->query($sql) === TRUE && $conn->query($joinsql) === TRUE) {
            echo "New item entered successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }

        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Inventory list</button>
                </form>";
    }

    $conn->close();
    ?>
    
</html>
