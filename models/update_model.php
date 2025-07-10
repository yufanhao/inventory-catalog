<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');

    $id =  $_POST["id"];
    $name = $_POST["name"];
    $submitted = $_POST['submitted'];
    $part_number = $_POST['part_number'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    $model_sql = "SELECT * FROM models WHERE id = $id";
    $model_result = $conn->query($model_sql);
    if (isset($_POST['submitted']) && $model_result && $model_result->num_rows > 0) {
        upload_file($image_url, $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images');
        $sql = "UPDATE models SET name = '$name', part_number = '$part_number', category = '$category', image_url = '$image_url' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo "Model updated successfully! <br>";
            echo "<form action ='../models/view_models.php' method = 'get'>
                    <button type = 'submit'>Inventory</button>
                  </form>";
        } else {
            echo "Error updating model: " . $conn->error;
        }
    }
    else if ($model_result && $model_result->num_rows > 0) {
        $model = $model_result->fetch_assoc();
        echo "<form method='POST' action='update_model.php'>";
        echo "Model ID: " . htmlspecialchars($model['id']) . "<br>";
        echo "Model Name: <input type='text' name='name' value='" . htmlspecialchars($model['name']) . "'><br>";
        echo "Part Number: <input type='text' name='part_number' value='" . htmlspecialchars($model['part_number']) . "'><br>";
        echo "Category: <input type='text' name='category' value='" . htmlspecialchars($model['category']) . "'><br>";
        echo "Image: <br>";
        echo '<img src="' . htmlspecialchars($model['image_url']) . '" width="75" height="75"><br>';
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
