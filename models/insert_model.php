<html>
    <form action="../items/inventory.php" method="POST">
        Name: <input type="text" name="name"><br>
        Category: <input type="text" name="category"><br>
        Image: <input type="file" id="fileInput" name="image_url" width="50" height="50"><br>
        <!--Model Type:--> 
        <button type="submit">Submit</button>
    </form>

    <?php
    require_once('../db.php');
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
    
    /*if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type = $_POST["type"];
        echo "<form method='POST'>";
        echo "<input type='hidden' name='type' value='$type'>";
        echo "<input type='hidden' name='step' value='details'>";

        echo "<input type='text' name='name'><br>
              <input type='text' name='category'><br>
              <input type='file' id='fileInput' name='image_url' width='50' height='50'><br>
              <button type = 'submit'>Add New Model</button>
              </form>";
    }
    else*/ if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['step'] === 'details') {
        $name = $_POST["name"];
        $category = $_POST["category"];
        $image = $_POST["image_url"];

        check_location_exists($conn, $name, $category);

        $sql = "INSERT INTO model (name, category, image) VALUES ('$name', '$category', '$image')";
        if ($conn->query($sql) === TRUE) {
            echo "New model created successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
        echo "<form action='../items/inventory.php' method='get'>
                <button type = 'submit'>Return to Inventory</button>
            </form>";
        $conn->close();
    }

    function check_model_exists($conn, $name, $category) {
        $sql = "SELECT * FROM model WHERE name = '$name' AND category = '$category'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "That location already exists";
            echo "<form action ='../items/inventory.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
                </form>";
            $conn->close();
            exit();
        }
    }
/*
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
    }*/
    ?>
    
</html>
