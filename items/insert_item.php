<html>
    <?php
    require_once('../db.php');

    $name =  $_POST["name"];
    $category = $_POST["category"];
    $image_url = $_POST["image_url"];
    $expiration = $_POST["expiration"];
    $box_number = $_POST["box_number"];
    $quantity = $_POST["quantity"];

    $box_check_sql = "SELECT * FROM boxes WHERE number = '$box_number'";
    $box_check_result = $conn->query($box_check_sql);
    
    /*
    $isNew = "SELECT * FROM items WHERE contains(name, '$name')";
    if ($isNew != FALSE) {
        $quantity++;
    }
    else 

    */
    if ($box_check_result->num_rows <= 0) {
        echo "Box location $box_number does not exist. Please create a box first.";
        echo "<form action ='../boxes/insert_box.php' method = 'post'>
                Box Location: <input type='number' name='box_number'><br>
                Cabinet Location: <input type='text' name='cabinet_number'><br>
                <input type='hidden' name='name' value='$name'>
                
                <input type='hidden' name='category' value='$category'>
                <input type='hidden' name='image_url' value='$image_url'>
                <input type='hidden' name='expiration' value='$expiration'>
                <input type='hidden' name='quantity' value='$quantity'>
                <button type = 'submit'>Create Box</button> 
                </form>";

        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
                </form>";
        
    }
    else {
        $sql = "INSERT INTO items (name, category, image_url, expiration) VALUES ('$name', '$category', '$image_url', '$expiration')";
        if ($conn->query($sql) === TRUE ) {
            $item_id = $conn->insert_id;
            $sql = "SELECT id FROM boxes ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                $box_id = $row['id'];
            }

            $joinsql = "INSERT INTO item_box_join (item_id, box_id) VALUES ('$item_id', '$box_id')";
            if ($conn->query($joinsql) === TRUE) {
                echo "New item entered successfully <br>";
            }
            else {
            echo "Error: " . $conn->error;
        }
        } else {
            echo "Error: " . $conn->error;
        }

        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Inventory list</button>
                </form>";

     }
 
    ?>
    
</html>
