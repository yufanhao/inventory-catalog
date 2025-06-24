<html>
    <?php
    if ($_POST["ui_call"] !== FALSE) {
    require_once('../db.php');
    require_once('upload_file.php');

    $name =  $_POST["name"];
    $serial_number =  $_POST["sn"];
    $category = $_POST["category"];
    $image_url = $_POST["image_url"];
 
    insert_model_row($conn, $name, $serial_number, $category, $image_url);
    }

    function insert_model_row($conn, $name, $serial_number, $category, $image_url) {
    // upload image file before trying to store it into tables.
    echo 'debug in insert_model_row<br>';
    $uploaded_image = upload_file("image_url", 
                    $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images');

    // TODO: either make category field a select or check for inconsistency.
    $sql = "INSERT INTO models (name, serial_number, category, image_url)
                VALUES ('$name', '$serial_number', '$category', '$uploaded_image')";

        if ($conn->query($sql) === TRUE ) {
            echo "New model entered successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

        echo "<form action ='view_models.php' method = 'get'>
                <button type = 'submit'>Inventory</button>
                </form>"; 
 
    ?>
</html>
