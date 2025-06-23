<html>
    <?php
    require_once('../db.php');
    require_once('upload_file.php');

    $sn =  $_POST["sn"];
    $name =  $_POST["name"];
    $expiration =  $_POST["expiration"];
    $location_type =  $_POST["location_type"];
    $location_number =  $_POST["number"];

    // ensure valid model id
    $model_check_sql = "SELECT id FROM models WHERE name = '$name'";
    $model_check_result = $conn->query($model_check_sql);
    if ($model_check_result->num_rows <= 0) {
        echo "Model $name does not exist. Please create that model first.";
        echo "<form action ='../models/add_new_model.php' method = 'get'>
                <button type = 'submit'>Create Model</button> 
                </form>";
        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
                </form>";
        exit();
    }
    
    // ensure valid location id
    $location_sql = "SELECT * FROM locations WHERE number = $location_number && type = '$location_type'";
    $location_check_sql = $location_sql;

    $location_check_result = $conn->query($location_check_sql);
    if ($location_check_result->num_rows <= 0) {
        echo "Location $location_type $location_number does not exist. Please create that location first.";
        echo "<form action ='../locations/insert_location.php' method = 'get'>
                <button type = 'submit'>Create Location</button> 
                </form>";
        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
                </form>";
        exit();
    }


    $location = $location_check_result->fetch_assoc();
    $location_id = $location["id"];

    $model_id = $model_check_result->fetch_assoc();
    $model_id = $model_id['id'];

    $sql = "INSERT INTO items (serial_number, expiration, model_id, location_id) 
           VALUES ('$sn', '$expiration', '$model_id', '$location_id')";
   
        if ($conn->query($sql) === TRUE ) {
            echo "New item entered successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }

        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Inventory</button>
                </form>";
 
    ?>
</html>
