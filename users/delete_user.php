<html>
    <?php
    require_once('../db.php');

    $id =  $_GET["id"];
    $sql = "DELETE from users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";

        echo "<form action ='users.php' method = 'get'>
              <button type = 'submit'>Return to Users</button>
              </form>";
        
        echo "<form action ='../welcome_page.php' method = 'get'>
              <button type = 'submit'>Return to Welcome Page</button>
              </form>";

    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
