<html>
<?php
require_once('../db.php');
$filename = $_POST["table_file"]; 

$fileHandle =fopen($filename,'r');

if ($fileHandle === false) {
    throw new Exception('Error opening the file.');
}

// skip headers line
fgetcsv($fileHandle); //keep if want xls to have headers.
while (($row = fgetcsv($fileHandle)) !== false) {
    /*
    $name =  $row[0];
    $category = $row[1];
    $image_url = $row[2]; 
    $expiration = $row[3];
    $box_number = $row[4]; 
    //$quantity = $row[5];
    // */

    // format: DATE("year-month-day")
    //$expiration = DATE("2017-06-15");
    //$model_id = $row[1];
    $name =  $row[0];
    $serial_number = $row[1];
    $category = $row[2];
    $image_url = $row[3]; 

    $sql = "INSERT INTO models (name, serial_number, category, image_url) 
    VALUES ('$name', '$serial_number', '$category', '$image_url')";

    if ($conn->query($sql) === TRUE ) {
        $item_id = $conn->insert_id;

        //TODO: move to new add_location() function?
        // if new box, add it to boxes table.
        $sql = "SELECT id FROM locations ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result = $result->fetch_assoc()) {
            $box_id = $row['id'];
        }

        //$modelsql = "INSERT INTO model (name, category, image) VALUES ('$name', '$category', '$image_url')";
        $joinsql = "INSERT INTO item_box_join (item_id, box_id) VALUES ('$item_id', '$box_id')";
         if ($joinsql !== FALSE) {
            echo "New item entered successfully <br>";
        }
        else {
            echo "Error: " . $conn->error;
        }
    }
}


fclose($fileHandle);
echo "<form action ='inventory.php' method = 'get'> <button type = 'submit'>Inventory list</button></form>";

?>
</html>