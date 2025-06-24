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
    // format: DATE("year-month-day")
    $serial_number = $row[0];
    $expiration = DATE(substr($row[1], 0, 11)); // pick only 10digits that represent the date.
    $model_id = $row[2];

    $sql = "INSERT INTO items (serial_number, expiration, model_id) VALUES ('$serial_number', '$expiration', '$model_id')";
    if ($conn->query($sql) === TRUE ) {
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
}


fclose($fileHandle);
echo "<form action ='../models/view_models.php' method = 'get'> <button type = 'submit'>Inventory list</button></form>";

?>
</html>