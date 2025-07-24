<html>
    <?php
    require_once('../db.php');
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
    if (!isset($_POST['type'])) {
        echo "<form method='POST'>";
        echo "Location Type: <select name='type'>";
        echo "<option value='box'>Box</option>";
        echo "<option value='cabinet'>Cabinet</option>";
        echo "<option value='shelf'>Shelf</option>";
        echo "<option value='floor'>Floor</option>";
        echo "<option value='cubicle'>Cubicle</option>";
        echo "<option value='customer'>Customer</option>";
        echo "<option value='building'>Building</option>";
        echo "<option value='other'>Other</option></select><br>";
        echo "<button type='submit'>Next</button>";
        echo "</form>";
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && !isset($_POST['step'])) {
        $type = $_POST["type"];
        echo "<form method='POST'>";
        echo "<input type='hidden' name='type' value='$type'>";
        echo "<input type='hidden' name='step' value='details'>";
        if ($type == "box") {
            echo "Box Number: <input type='text' name='name'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Cabinet Number: <input type='text' name='parent_number'><br>
                    <input type='hidden' name='parent_type' value='cabinet'>
                    <button type = 'submit'>Create Box</button>
                </form>";
        } else if ($type == "cabinet") {
            echo "Cabinet Number: <input type='text' name='name'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <input type='hidden' name='parent_type' value='floor'>
                    <button type = 'submit'>Create Cabinet</button>
                </form>";
        } else if ($type == "shelf") {
            echo "Shelf Number: <input type='text' name='name'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <input type='hidden' name='parent_type' value='floor'>
                    <button type = 'submit'>Create Shelf</button>
                </form>";
        } else if ($type == "floor") {
            echo "Floor Number: <select name='name'>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                        </select><br>
                    Description/Notes: <input type='text' name='description'><br>
                    <input type='hidden' name='parent_type' value='building'>
                    <button type = 'submit'>Create Floor</button>
                </form>";
        } else if ($type == "cubicle") {
            echo "Cubicle: <input type='text' name='name'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <input type='hidden' name='parent_type' value='floor'>
                    <button type = 'submit'>Create Cubicle</button>
                </form>";
        } else if ($type == "customer") {
            echo "Customer: <input type='text' name='name'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <input type='hidden' name='parent_type' value='building'>
                    <button type = 'submit'>Create Customer</button>
                </form>";
        } else if ($type == "building") {
            echo "Building Name: <input type='text' name='name'><br>
                    Description/Notes: <input type='text' name='description'><br>
                    <input type='hidden' name='parent_type' value='ancestor'>
                    <button type = 'submit'>Create Building</button>
                </form>";
        }
        else if ($type == "other") {
            echo "Other Location Type: <input type='text' name='other_type'><br>
                    Description/Notes<input type='text' name='description'><br>
                    Floor Number: <input type='text' name='parent_number'><br>
                    <input type='hidden' name='parent_type' value='floor'>
                    <button type = 'submit'>Create Other Location</button>
                </form>";
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['step'] === 'details') {
        $type = $_POST["type"];
        $parent_type = $_POST["parent_type"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $parent_number = $_POST["parent_number"];
        if ($parent_type == "ancestor") {
            $parent_number = 0;
        }

        check_location_exists($conn, $name, $type);

        if ($parent_number != 0) {
            $parent_id = get_parent_id($conn, $parent_number, $parent_type);
            if ($parent_id == null) {
                echo "<form action ='../locations/insert_location.php' method = 'get'>
                    <button type = 'submit'>Create Location</button>
                    </form>";
                echo "<form action ='../models/view_models.php' method = 'get'>
                    <button type = 'submit'>Cancel and Return to Inventory</button>
                    </form>";
                $conn->close();
                exit();
            }
        } else {
            $parent_id = 0; // Default parent ID of the ancestor location if there is no logical parent (i.e., for floor)
        }

        $sql = "INSERT INTO locations (name, type, description, parent_id) VALUES ('$name', '$type', '$description', '$parent_id')";
        if ($conn->query($sql) === TRUE) {
            echo "New location created successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
        echo "<form action='../models/view_models.php' method='get'>
        <button type = 'submit'>Return to Inventory</button>
            </form>";
        $conn->close();
    }

    function check_location_exists($conn, $name, $type) {
        $sql = "SELECT * FROM locations WHERE number = '$name' AND type = '$type'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "That location already exists";
            echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
                </form>";
            $conn->close();
            exit();
        }
    }

    function get_parent_id($conn, $parent_number, $parent_type) {
        $sql = "SELECT id FROM locations WHERE number = '$parent_number' AND type = '$parent_type'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            echo "Parent location does not exist. Please create it first.";
            return null;
        }
    }
    ?>
</html