<html>
    <?php
    require_once('../db.php');
    require_once('../items/upload_file.php');

    $name =  $_POST["name"];
    $serial_number =  $_POST["sn"];
    $category = $_POST["category"];
    $image_url = $_POST["image_url"];
 
    // upload image file before trying to store it into tables.
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

        echo "<form action ='view_models.php' method = 'get'>
                <button type = 'submit'>Inventory</button>
                </form>"; 
 
    ?>
</html>
