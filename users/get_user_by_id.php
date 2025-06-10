<html>
    <?php
    require_once('../db.php');


    $id =  $_GET["id"];
    $sql = "SELECT * from users WHERE id = $id";

    if ($conn->query($sql) !== FALSE) {
        $result = $conn->query($sql);
        echo "User retrieved successfully! <br>";
        while ($row = $result->fetch_assoc()) {
            echo "User ID: " . htmlspecialchars($row['id']) . "<br>";
            echo "Username: " . htmlspecialchars($row['username']) . "<br>";
            echo "Email: " . htmlspecialchars($row['email']) . "<br>";
        }         
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
