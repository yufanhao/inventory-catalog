<html>
    <?php
    require_once('../db.php');

    $serial_number =  $_POST["serial_number"];
    $model_name =  $_POST["model_name"];
    $expiration =  $_POST["expiration"];
    $location_type =  $_POST["location_type"];
    $location_name =  $_POST["name"];
    if (isset($_POST['quantity'])) {
        $quantity =  $_POST["quantity"];
    } else {
        $quantity = 1;
    }

    // ensure valid model id
    if (isset($_POST['model_id'])) {
        $model_id = $_POST['model_id'];
    } else {
        $model_check_sql = "SELECT id FROM models WHERE name = '$model_name'";
        $model_check_result = $conn->query($model_check_sql);
        $model = $model_check_result->fetch_assoc();
        if ($model_check_result->num_rows <= 0) {
            echo "Model $model_name does not exist. Please create that model first.";
            echo "<form action ='../models/add_new_model.php' method = 'get'>
                    <button type = 'submit'>Create Model</button> 
                    </form>";
            echo "<form action ='../models/view_models.php' method = 'get'>
                    <button type = 'submit'>Cancel and Return to Inventory</button>
                    </form>";
            exit();
        }
        $model_id = $model['id'];
    }
    
    // ensure valid location id
    if (isset($_POST['location_id'])) {
        $location_id = $_POST['location_id'];
    } else {
        $location_name_escaped = $conn->real_escape_string($location_name);
        $location_type_escaped = $conn->real_escape_string($location_type);

        $location_check_sql = "SELECT * FROM locations WHERE name = '$location_name_escaped' AND type = '$location_type_escaped'";
        $location_check_result = $conn->query($location_check_sql);

        if ($location_check_result->num_rows <= 0) {
            echo "Location $location_type $location_name does not exist. Please create that location first.";
            echo "<form action ='../locations/insert_location.php' method = 'get'>
                    <button type = 'submit'>Create Location</button> 
                    </form>";
            echo "<form action ='../models/view_models.php' method = 'get'>
                    <button type = 'submit'>Cancel and Return to Inventory</button>
                    </form>";
            exit();
        }
        $location = $location_check_result->fetch_assoc();
        $location_id = $location["id"];
    }

    $sql = "INSERT INTO items (serial_number, expiration, model_id, location_id) 
           VALUES ('$serial_number', '$expiration', '$model_id', '$location_id')";
    for ($i = 0; $i < $quantity; $i++) {
        if ($conn->query($sql) !== TRUE ) {
            echo "Error: " . $conn->error;
            exit();
        }
    }

    echo "$quantity new item(s) entered successfully <br>";
    echo "<form action ='../models/view_models.php' method = 'get'>
            <button type = 'submit'>Inventory</button>
            </form>"; 
    ?>
</html>
