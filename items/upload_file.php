<?php
// DOC:
// https://www.php.net/manual/en/features.file-upload.post-method.php


// $src_file: Client file path.
// $$target_dir: Server destination folder. - full path.
// $file_type: type of files being uploaded. Default is image files.


function upload_file($src_file , $target_dir, $file_type = 'image') { 

  // initialize expected values based on file types.
  // for now, support images only. can expand in future.
  $expected_extensions = array();
  if ($file_type === 'image') {
    $expected_extensions = array("jpg" , "png" , "jpeg","gif");
  }

  // get actual file attributes.
    $uploadOk = 1;
    $file_name = basename($_FILES[$src_file]["name"]);
    $target_file = $target_dir . '/' . $file_name;
    $FileExt = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));    //echo 'in upload_file:' . $_FILES[$src_file]['name']. '<br>';
    //echo 'target dir: ' . $target_dir . '<br>';
    //echo 'target file: ' . $target_file . '<br>';

    
// Check file size
if ($_FILES[$src_file]["size"] > 500000) {
  echo "Sorry, your file {$file_name} is too large.<br>";
  $uploadOk = 0;
}

// Validate file extensions certain file formats
if (!in_array($FileExt , $expected_extensions)) {
  echo "Sorry, your file {$file_name} doesn't have expected extension.<br>";
  $uploadOk = 0;
}

// For image files, check if image file is a actual image or fake image
if ($file_type === 'image') {
  $check = getimagesize($_FILES[$src_file]["tmp_name"]);
  if($check === false) {
    echo "Sorry, your file {$file_name} is not an image.<br>" ;
    $uploadOk = 0;
  }
}
  
// Check if file already exists
// TODO: if it exists, skip, and return success.
//if (file_exists($target_file)) {
//  echo "Sorry, file already exists.";
// $uploadOk = 0;
//22}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file {$file_name} was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES[$src_file]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars($file_name) . " has been uploaded successfully.<br>";
    return htmlspecialchars("/inventory-catalog/images/" . $file_name) ; 
    //todo: remove hardcoded appName, but need relative path. 
  } else {
    echo "Sorry, there was an error uploading your file {$file_name}.<br>";
    return FALSE;
  }
}
}




  
?>