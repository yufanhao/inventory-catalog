<html>
    <?php

    $conn = new mysqli("localhost", "root", "Poopcorn2005$","first_project_db");

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $id =  $_POST["id"];
    $sql = "DELETE from users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
