<html>
    <?php
    require_once('../db.php');
    require_once('../functions.php');
    require_once('insert_model.php');
    
    $filename = $_POST["table_file"]; 

    $fileHandle =fopen($filename,'r');

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

        // echo ('hello' .$name . $part_number . $category . $image_url . '<br>');
        insert_model_row($conn, $name, $part_number, $category, $image_url);
        /*
        // upload image file before trying to store it into tables.
        $uploaded_image = upload_file($row[3], 
                    $_SERVER['DOCUMENT_ROOT'] . '/inventory-catalog/images');

        // TODO: either make category field a select or check for inconsistency.
        $sql = "INSERT INTO models (name, part_number, category)
                    VALUES ('$name', '$part_number', '$category' )"; //image_url
                    // , '$uploaded_image')";

        if ($conn->query($sql) === TRUE ) {
            echo "New model entered successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
*/
        echo "<form action ='view_models.php' method = 'get'>
            <button type = 'submit'>Inventory</button>
                </form>"; 
                
    }
    fclose($fileHandle);
    echo "<form action ='inventory.php' method = 'get'> <button type = 'submit'>Inventory list</button></form>";

?>
</html>