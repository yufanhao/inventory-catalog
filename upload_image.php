<html>
    <!-- The data encoding type, enctype, MUST be specified as below -->
     <form enctype="multipart/form-data" action="__URL__" method="POST">
        <!-- MAX_FILE_SIZE must precede the file input field -->
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <!-- Name of input element determines name in $_FILES array -->
        Send this file: <input name="userfile" type="file" />
        <input type="submit" value="Send File" />
    </form>
    
    <?php
    $uploaddir = '/var/www/uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    
    echo '<pre>';
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Possible file upload attack!\n";
    }
    
    echo 'Here is some more debugging info:';
    print_r($_FILES);
    print "</pre>";

?>
<html>