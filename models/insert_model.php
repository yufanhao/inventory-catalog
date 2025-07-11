<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');
echo '<pre>';
print_r($_FILES);
echo '</pre>';
    $name =  $_POST["name"];
    $part_number =  $_POST["part_number"];
    $category = $_POST["category"];
    $image_type = $_FILES['image']['type'];
    $image_data = $conn->real_escape_string(file_get_contents($_FILES['image']['tmp_name']));
    
    $sql = "INSERT INTO models (name, category, part_number, image, image_type)
            VALUES ('$name', '$category', '$part_number', '$image_data', '$image_type')";

    if ($conn->query($sql) === TRUE) {
        echo "New model entered successfully <br>";
    } else {
        echo "Error: " . $conn->error;
    }

    echo "<form action ='view_models.php' method = 'get'>
            <button type = 'submit'>Inventory</button>
            </form>";  
    ?>
</html>
