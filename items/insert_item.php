<html>
    <?php
    require_once('../db.php');

    $name =  $_POST["name"];
    $category = $_POST["category"];
    $image_url = $_POST["image_url"];
    $expiration = $_POST["expiration"];
    $location_type = $_POST["location_type"];
    $location_number = $_POST["number"];
    // $quantity = $_POST["quantity"];

    $location_check_sql = "SELECT * FROM locations WHERE number = '$location_number' && type = '$location_type'";
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
    else {
        $location = $location_check_result->fetch_assoc();
        $location_id = $location["id"];
        $sql = "INSERT INTO items (name, category, image_url, expiration, location_id) VALUES ('$name', '$category', '$image_url', '$expiration', '$location_id')";
        if ($conn->query($sql) === TRUE ) {
            echo "New item entered successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }

        echo "<form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Inventory</button>
                </form>";
     }
 
    ?>
</html>
