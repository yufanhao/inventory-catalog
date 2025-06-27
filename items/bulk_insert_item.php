<html>
<?php
require_once('../db.php');
$filename = $_POST["table_file"]; 

$fileHandle =fopen($filename,'r');

if ($fileHandle === false) {
    throw new Exception('Error opening the file.');
}

// skip headers line
fgetcsv($fileHandle); 
while (($row = fgetcsv($fileHandle)) !== false) {
    $serial_number = $row[0];
    
        //$expiration = date('Y-m-d', strtotime(substr($row[1], 1, 10))); // pick only 10digits that represent the date.
    $expiration = date('Y-m-d', strtotime($row[1]));
    $model_id = $row[2];
    $location_id = $row[3];
    //TODO: XLS should use model_name and location_number instead of IDs.

    echo $row[3].'<br>';

    $sql = "INSERT INTO items (serial_number, expiration, model_id, location_id) 
    VALUES ('$serial_number', '$expiration', '$model_id', '$location_id')";
    if ($conn->query($sql) !== FALSE ) {
        $item_id = $conn->insert_id;

        //TODO: move to new add_location() function?
        // if new box, add it to boxes table.
        $sql = "SELECT id FROM locations ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result = $result->fetch_assoc()) {
            $box_id = $row['id'];
        }

        if ($sql !== FALSE) {
            echo "New item entered successfully <br>";
        }
        else {
            echo "Error: " . $conn->error;
        }
    }
    else {
        echo "Insert ROWError: " . $conn->error;
    }
}


fclose($fileHandle);
echo "<form action ='../models/view_models.php' method = 'get'> <button type = 'submit'>Inventory list</button></form>";

?>
</html>