<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');

    $id =  $_POST["id"];
    $expiration = $_POST["expiration"];
    $submitted = $_POST['submitted'];
    $serial_number = $_POST['serial_number'];
    $model = $_POST['model'];
    
    $item_sql = "SELECT i.id, i.expiration, i.serial_number, m.name as model
    FROM items i
    LEFT JOIN models m on m.id = i.model_id
    WHERE i.id = $id";
    
    $item_result = $conn->query($item_sql);


    if (isset($_POST['submitted']) && $item_result && $item_result->num_rows > 0) {
        $model_id = $conn->query("SELECT id from models where name = '$model'")->fetch_assoc();
        $m_id = $model_id['id'];
        //echo $m_id;

        $sql = "UPDATE items SET expiration = '$expiration', serial_number = '$serial_number', model_id = $m_id WHERE id = '$id'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Item updated successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
        echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
              </form>";
    }
    else if ($item_result && $item_result->num_rows > 0) {
        $item = $item_result->fetch_assoc();
    
        echo "<form method='POST' action='update_item.php' enctype='multipart/form-data'>";
        echo "Item ID: " . htmlspecialchars($item['id']) . "<br>";
        echo "Expiration: <input type='date' name='expiration' value='" . htmlspecialchars($item['expiration']) . "'><br>";
        echo "Serial Number: <input type='text' name='serial_number' value='" . htmlspecialchars($item['serial_number']) . "'><br>";
        echo "Model: <select name='model'>";
        $models = $conn->query("SELECT DISTINCT name FROM models");
        while ($row = $models->fetch_assoc()) {
            $name = htmlspecialchars($row['name']);
            $selected = ($row['name'] === $item['model']) ? 'selected' : '';
            echo "<option value='$name' $selected>$name</option>";
        }
        //echo '<input type="submit" formaction="../models/add_new_model.php" value="New"><br>';
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($item['id']) . "'>";
        echo "<input type='hidden' name='submitted' value='true'><br>";
        echo "<input type='submit' value='Update Item'></form>";
        echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
              </form>";
    }
    else {
        echo "Item with ID $id does not exist.";
        echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
              </form>";
        exit();
    }

    $conn->close();
    ?>
</html>
