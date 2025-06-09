<html>
    <?php

    $conn = new mysqli("localhost", "root", "Poopcorn2005$","first_project_db");

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $id =  $_GET["id"];
    $sql = "SELECT * from users WHERE id = $id";

    if ($conn->query($sql) !== FALSE) {
        $result = $conn->query($sql);
        echo "User retrieved successfully! <br>";
        echo "User retrieved successfully! <br>";
        echo "User retrieved successfully! <br>";
        while ($row = $result->fetch_assoc()) {
            echo "User ID: " . htmlspecialchars($row['id']) . "<br>";
            echo "Username: " . htmlspecialchars($row['name']) . "<br>";
            echo "Email: " . htmlspecialchars($row['email']) . "<br>";
        }         
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
