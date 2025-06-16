<html>
    <form action="" method="POST">
        Storage Unit Type: 
        <select name="type">
            <option value="cabinet">Cabinet</option>
            <option value="box">Box</option>
            <option value="shelf">Shelf</option>
            <option value="floor">Floor</option>
            <option value="other">Other</option></select><br>
        <button type="submit">Next</button>
    </form>

    <?php
    require_once('../db.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type'])) {

        if ($conn->connect_error) {
            die("Connection failed: ". $conn->connect_error);
        }
        
        $type = $_POST["type"];

        if ($type == "box") {
            echo "<form action='' method='POST'>
                    Box Number: <input type='text' name='number'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Cabinet Number: <input type='text' name='parent_number'><br>
                    <button type = 'submit'>Create Box</button>
                </form>";
            $parent_type = "cabinet";
        } else if ($type == "cabinet") {
            echo "<form action='' method='POST'>
                    Cabinet Number: <input type='text' name='number'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <button type = 'submit'>Create Cabinet</button>
                </form>";
            $parent_type = "floor";
        } else if ($type == "shelf") {
            echo "<form action='' method='POST'>
                    Shelf Number: <input type='text' name='number'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <button type = 'submit'>Create Shelf</button>
                </form>";
            $parent_type = "floor";
        } else if ($type == "floor") {
            echo "<form action='' method='POST'>
                    Floor Number: <select name='number'>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                    Description/Notes<input type='text' name='description'><br>
                    <button type = 'submit'>Create Floor</button>
                </form>";
            $parent_number = 0;
            $parent_type = "ancestor"; // Assuming ancestor is the top-level location
        } else if ($type == "other") {
            echo "<form action='' method='POST'>
                    Other Location Type: <input type='text' name='other_type'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='floor_number'><br>
                    <button type = 'submit'>Create Other Location</button>
                </form>";
            $parent_type = "floor";
        }
        
        if (isset($_POST["number"]) && isset($_POST["description"]) && isset($_POST["parent_number"])) {
            $number = $_POST["number"];
            $description = $_POST["description"];
            if ($parent_number != 0) {
                $parent_number = $_POST["parent_number"];
            }
            
            echo "number: $number <br>";
            echo "description: $description <br>";
            echo "parent_number: $parent_number <br>";

            location_exists($conn, $number, $type);

            if ($parent_number != 0) {
                $parent_id = get_parent_id($conn, $parent_number, $parent_type);
                if ($parent_id != null) {
                    echo "Parent location does not exist. Please create a $parent_type first.";
                    echo "<form action ='../locations/insert_location.php' method = 'get'>
                        <button type = 'submit'>Create Location</button>
                        </form>";
                    echo "<form action ='../items/inventory.php' method = 'get'>
                        <button type = 'submit'>Cancel and Return to Inventory</button>
                        </form>";
                    $conn->close();
                    exit();
                }
            } else {
                $parent_id = 1; // Default parent ID of the ancestor location if there is no logical parent (i.e., for floor)
            }

            $sql = "INSERT INTO locations (number, type, description, parent_id) VALUES ('$number', '$type', '$description', '$parent_id')";
            if ($conn->query($sql) === TRUE) {
                echo "New location created successfully <br>";
            } else {
                echo "Error: " . $conn->error;
            }
            echo "<form action='../items/inventory.php' method='get'>
                    <button type = 'submit'>Return to Inventory</button>
                </form>";
            $conn->close();
        }
        echo "ran";
    }

    function location_exists($conn, $number, $type) {
        $sql = "SELECT * FROM locations WHERE number = '$number' AND type = '$type'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "That location already exists";
            echo "<form action ='../items/inventory.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
                </form>";
            $conn->close();
            exit();
        }
        else {
            return false;    
        }
    }

    function get_parent_id($conn, $parent_number, $parent_type) {
        $sql = "SELECT id FROM locations WHERE number = '$parent_number' AND type = '$parent_type'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            return null;
        }
    }
    ?>
    
</html>
