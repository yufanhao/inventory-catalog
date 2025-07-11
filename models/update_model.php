<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');

    $id =  $_POST["id"];
    $name = $_POST["name"];
    $submitted = $_POST['submitted'];
    $part_number = $_POST['part_number'];
    $category = $_POST['category'];
    $image = $_FILES['image'];

    $model_sql = "SELECT * FROM models WHERE id = $id";
    $model_result = $conn->query($model_sql);
    
    if (isset($_POST['submitted']) && $model_result && $model_result->num_rows > 0) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // If a new image is uploaded, handle the file upload
            $image_type = $_FILES['image']['type'];
            $image_data = $conn->real_escape_string(file_get_contents($_FILES['image']['tmp_name']));
            $sql = "UPDATE models SET name = '$name', part_number = '$part_number', category = '$category', image = '$image_data', image_type = '$image_type' WHERE id = $id";

        } else {
            // If no new image is uploaded, keep the existing image URL
            $model = $model_result->fetch_assoc();
            $image = $model['image'];
            $sql = "UPDATE models SET name = '$name', part_number = '$part_number', category = '$category' WHERE id = $id";
        }
        if ($conn->query($sql) === TRUE) {
            echo "Model updated successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
        echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button>
              </form>";
    }
    else if ($model_result && $model_result->num_rows > 0) {
        $model = $model_result->fetch_assoc();
        echo "<form method='POST' action='update_model.php' enctype='multipart/form-data'>";
        echo "Model ID: " . htmlspecialchars($model['id']) . "<br>";
        echo "Model Name: <input type='text' name='name' value='" . htmlspecialchars($model['name']) . "'><br>";
        echo "Part Number: <input type='text' name='part_number' value='" . htmlspecialchars($model['part_number']) . "'><br>";
        echo "Category: <input type='text' name='category' value='" . htmlspecialchars($model['category']) . "'><br>";
        echo "Image: <br>";
        echo '<img src="get_image.php?id=' . $model['id'] . '" width="75" height="75"><br>';
        echo "New Image: <input type='file' name='image' width='50' height='50'><br>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($model['id']) . "'>";
        echo "<input type='hidden' name='submitted' value='true'><br>";
        echo "<input type='submit' value='Update Model'></form>";
        echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
              </form>";
    }
    else {
        echo "Model with ID $id does not exist.";
        echo "<form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Cancel and Return to Inventory</button>
              </form>";
        exit();
    }

    $conn->close();
    ?>
</html>
