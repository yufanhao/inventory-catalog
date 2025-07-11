<?php 
// commonly used functions
function get_location($conn, $location_id) {
    $flag = FALSE;
    $location_sql = "SELECT * FROM locations WHERE id = $location_id";
    $location = $conn->query($location_sql)->fetch_assoc();
    $location_type = $location["type"];
    $location_array = array(
        'box' => "",
        'cabinet' => "",
        'shelf' => "",
        'floor' => ""
    );

    // Traverse up the location hierarchy to get all location types and numbers
    while ($location_type != 'building' AND $flag == FALSE) {
        if (!$location) {
            //echo "Location not found for item. Please check the database.";
            //echo "$location_type" . " asdhkfhksdjhf ";
            $flag = TRUE;
            break;
        }
        $location_number = $location['number'];
        $location_array[$location_type] = $location_number;

        $parent_id = $location['parent_id'];
        $parent_sql = "SELECT * FROM locations WHERE id = $parent_id";
        $parent = $conn->query($parent_sql)->fetch_assoc();
        $location = $parent;
        $location_type = $location["type"];
        // echo $location_type . " asdhkfhksdjhf ";
    }
    return $location_array;
}

function fetch_row_data($conn, $table, $id, $column) {
    $sql = "SELECT $column FROM $table WHERE id = $id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row[$column];
    } else {
        return null;
    }
}

function upload_file($src_file , $target_dir, $file_type = 'image') { 

  // initialize expected values based on file types.
  // for now, support images only. can expand in future.

    $expected_extensions = array();
    if ($file_type === 'image') {
        $expected_extensions = array("jpg" , "png" , "jpeg", "gif");
    }
  // get actual file attributes.
    $uploadOk = true;
    $file_name = basename($_FILES[$src_file]["name"]);
    $target_file = $target_dir . '/' . $file_name;
    $FileExt = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));    //echo 'in upload_file:' . $_FILES[$src_file]['name']. '<br>';
    //echo 'target dir: ' . $target_dir . '<br>';
    //echo 'target file: ' . $target_file . '<br>';

    if ($src_file != "") {
    // Check file size
        if ($_FILES[$src_file]["size"] > 500000) {
        echo "Sorry, your file {$file_name} is too large.<br>";
        $uploadOk = false;
        }

    // Validate file extensions certain file formats
        if (!in_array($FileExt , $expected_extensions)) {
        echo "Sorry, your file {$file_name} doesn't have expected extension.<br>";
        $uploadOk = false;
        }

    // For image files, check if image file is a actual image or fake image
        if ($file_type === 'image') {
            $check = getimagesize($_FILES[$src_file]["tmp_name"]);
            if($check === false) {
                echo "Sorry, your file {$file_name} is not an image.<br>" ;
                $uploadOk = false;
            }
        }
    // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == false) {
            echo "Sorry, your file {$file_name} was not uploaded.<br>";
    // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$src_file]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars($file_name) . " has been uploaded successfully.<br>";
                return htmlspecialchars('/inventory-catalog/images/' . $file_name); 
            //todo: remove hardcoded appName, but need relative path. 
            } else {
                echo "Sorry, there was an error uploading your file {$file_name}.<br>";
                return FALSE;
            }
        }
    }
    else {
        echo "No file was uploaded.<br>";
        return FALSE;
    }


  // Check if file already exists
  // TODO: if it exists, skip, and return success.
  //if (file_exists($target_file)) {
  //  echo "Sorry, file already exists.";
  // $uploadOk = 0;
  //22}

  
}
?>