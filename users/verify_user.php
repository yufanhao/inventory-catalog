<html>
    <?php
    $conn = new mysqli("localhost", "root", "Poopcorn2005$","first_project_db");

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    $username =  $_GET["username"];
    $password = $_GET["password"];
    $sql = "SELECT * from users WHERE name = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            echo "Login successful! <br>";
            echo "<form action ='users.php' method = 'get'>
              <button type = 'submit'>Users list</button>
              </form>";
        }
        else { 
            echo "Incorrect password";

        }
         
    } else {
        echo "Username does not exist" . $conn->error;
    }

    $conn->close();
    ?>
</html>
