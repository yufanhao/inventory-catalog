<html>
    <?php
    require_once('../db.php');

    $id =  $_GET["id"];
    $sql = "DELETE from users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
