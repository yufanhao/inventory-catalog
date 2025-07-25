<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');
    //require_once('insert_model.php');
    
    $filename = $_POST["table_file"]; 

    $fileHandle = fopen($filename,'r');

    if ($fileHandle === false) {
            throw new Exception('Error opening the file.');
        }

    // skip headers line
    fgetcsv($fileHandle); //keep if want xls to have headers.

    while (($row = fgetcsv($fileHandle)) !== false) {
        $name =  $row[0];
        $part_number = $row[1];
        $category = $row[2];
        $image_url = $row[3];

        $image_type = $_FILES['image']['type'];
        $image_data = $conn->real_escape_string($image_url);
        
        //echo ('hello' .$name . $part_number . $category . $image_url . '<br>');
        // insert_model_row($conn, $name, $part_number, $category, $image_url);
        
        // upload image file before trying to store it into tables.
        $uploaded_image = upload_file($image_url, 
                    $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images' . $image_url);
        
        echo $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images' . $image_url;
                    
        /*
        $image_type = $_FILES['image']['type'];
        $image_data = $conn->real_escape_string(file_get_contents($_FILES['image']['tmp_name']));
        */

        $sql = "INSERT INTO models (name, category_id, part_number, image, image_type)
        VALUES ('$name', '$category', '$part_number', '$image_data', '$image_type')";

        // TODO: either make category field a select or check for inconsistency.
        //$sql = "INSERT INTO models (name, part_number, category)
        //            VALUES ('$name', '$part_number', '$category' )"; //image_url
                    // , '$uploaded_image')";

        if ($conn->query($sql) === TRUE ) {
            echo "New model entered successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
                
    }
    fclose($fileHandle);
    echo "<form action ='view_models.php' method = 'get'> <button type = 'submit'>Inventory List</button></form>";

?>
</html>