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

    $cabinet_sql = "SELECT * FROM cabinets WHERE number = '$cabinet_number'";
    $result = $conn->query($cabinet_sql);
    if ($result->num_rows > 0) {
        echo "That cabinet already exists";
            echo "<form action ='../items/inventory.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
                </form>";
        $conn->close();
        exit();
    } 
    else {
        $sql = "INSERT INTO cabinets (number) VALUES ('$cabinet_number')";
        if ($conn->query($sql) === TRUE) {
            echo "New cabinet created successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
        $cabinet_id = $conn->insert_id;
        $id = $conn->insert_id;
        echo "<form action='../boxes/insert_box.php' method='POST'>
                <input type='hidden' name='name' value='$name'>
                <input type='hidden' name='category' value='$category'>
                <input type='hidden' name='image_url' value='$image_url'>
                <input type='hidden' name='expiration' value='$expiration'>
                <input type='hidden' name='box_number' value='$box_number'>
                <input type='hidden' name='cabinet_number' value='$cabinet_number'>
                <button type = 'submit'>Continue to Add Box</button>
                </form>";
        $conn->close();
    }

    ?>
</html>
