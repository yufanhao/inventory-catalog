<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');

    if ($_POST["ui_call"] !== FALSE) {
        $name =  $_POST["name"];
        $part_number =  $_POST["serial_number"];
        $category = $_POST["category"];
        $image_url = $_POST["image_url"];
    
        insert_model_row($conn, $name, $part_number, $category, $image_url);
    }

    function insert_model_row($conn, $name, $part_number, $category, $image_url) {
        // upload image file before trying to store it into tables.
        echo 'debug in insert_model_row<br>';
        $uploaded_image = upload_file($image_url, 
                        $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images');

        // TODO: either make category field a select or check for inconsistency.
        $sql = "INSERT INTO models (name, serial_number, category, image_url)
                    VALUES ('$name', '$part_number', '$category', '$uploaded_image')";

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
