<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');

    $id =  $_POST["id"];
    $name = $_POST["name"];
    $submitted = $_POST['submitted'];
    $part_number = $_POST['part_number'];
    $category = $_POST['category'];
    $image_url = "image_url"; // <-- this is empty

    $model_sql = "SELECT * FROM models WHERE id = $id";
    $model_result = $conn->query($model_sql);
    
    if (isset($_POST['submitted']) && $model_result && $model_result->num_rows > 0) {
        if ($image_url !== "") {
            if ($image_url['error'] == 'UPLOAD_ERR_NO_FILE') {
                // If no new image is uploaded, keep the existing image URL
                $model = $model_result->fetch_assoc();
                $image_url = $model['image_url'];
            } else {
                // If a new image is uploaded, handle the file upload
                $image_url = upload_file($image_url, $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images/' . $name . '.jpg');
                echo  $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images/' . $image_url . '.jpg';
            }
            $sql = "UPDATE models SET name = '$name', part_number = '$part_number', category = '$category', image_url = '$image_url' WHERE id = $id";
        }
        /*
        $sql = "UPDATE models SET ";
        if($name != "")
            $sql += ", name = '$name'";
        if($part_number != "")
            $sql += ", part_number = '$part_number'";
        if($category != "")
            $sql += ", category = '$category'";
        if($category != "")
            $sql += ", image_url = '$image'";
        $sql += " WHERE id = $id";
        */
    }
    else if ($model_result && $model_result->num_rows > 0) {
        $model = $model_result->fetch_assoc();
        echo "<form method='POST' action='update_model.php'>";
        echo "Model ID: " . htmlspecialchars($model['id']) . "<br>";
        echo "Model Name: <input type='text' name='name' value='" . htmlspecialchars($model['name']) . "'><br>";
        echo "Part Number: <input type='text' name='part_number' value='" . htmlspecialchars($model['part_number']) . "'><br>";
        echo "Category: <input type='text' name='category' value='" . htmlspecialchars($model['category']) . "'><br>";
        echo "Image: <br>";
        echo '<img src="get_image.php?id=' . $model['id'] . '" width="75" height="75"><br>';
        echo "New Image: <input type='file' id='fileInput' name='image_url' width='50' height='50' value='" . htmlspecialchars($model['image_url']) . "'><br>";
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
