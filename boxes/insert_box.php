<html>
    <?php
    require_once('../db.php');
    
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
    
    $name = $_POST["name"];
    $category = $_POST["category"];
    $image_url = $_POST["image_url"];
    $expiration = $_POST["expiration"];
    $box_number =  $_POST["box_number"];
    $cabinet_number = $_POST["cabinet_number"];

    $cabinet_id_sql = "SELECT id FROM cabinets WHERE number = '$cabinet_number'";
    $result = $conn->query($cabinet_id_sql);
    if ($result->num_rows <= 0) {
        echo "Cabinet number does not exist. Please create a cabinet first.";
        echo "<form action ='../cabinets/insert_cabinet.php' method = 'post'>
                Cabinet Number: <input type='text' name='cabinet_number'><br>
                <input type='hidden' name='name' value='$name'>
                <input type='hidden' name='category' value='$category'>
                <input type='hidden' name='image_url' value='$image_url'>
                <input type='hidden' name='expiration' value='$expiration'>
                <input type='hidden' name='box_number' value='$box_number'>
                <button type = 'submit'>Create Cabinet</button>
              </form>";
        echo "<form action ='../items/inventory.php' method = 'get'>
              <button type = 'submit'>Return to Inventory</button>
              </form>";
        $conn->close();
        exit();
    } else {
        $row = $result->fetch_assoc();
        $cabinet_id = $row['id'];
        $box = $conn->query("SELECT * from boxes WHERE box_number='$box_number'");
    
        if ($box->num_rows > 0) {
            echo "That box already exists";
            echo "<form action ='../items/inventory.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
                </form>";
        }
        else {
            $sql = "INSERT INTO boxes (number, cabinet_id) VALUES ('$box_number', '$cabinet_id')";
            if ($conn->query($sql) === TRUE) {
                echo "New box created successfully <br>";
            } else {
                echo "Error: " . $conn->error;
            }
            $id = $conn->insert_id;
            echo "<form action='../items/insert_item.php' method='POST'>
                    <input type='hidden' name='name' value='$name'>
                    <input type='hidden' name='category' value='$category'>
                    <input type='hidden' name='image_url' value='$image_url'>
                    <input type='hidden' name='expiration' value='$expiration'>
                    <input type='hidden' name='box_number' value='$box_number'>
                    <input type='hidden' name='box_id' value='$id'>
                    <button type = 'submit'>Continue to Add Item</button>
                    </form>";

            $conn->close();
        }
    }

    ?>
</html>
