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
            echo "Email: " . htmlspecialchars($row['email']) . "<br><br>";

            echo "<form action ='users.php' method = 'get'>
                 <button type = 'submit'>Return to Users</button>
                 </form>";
        }         
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
