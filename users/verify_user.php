<html>
    <?php
    require_once('../db.php');

    $username =  $_GET["username"];
    $password = $_GET["password"];
    $sql = "SELECT * from users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            echo "Login successful! <br>";
             echo "<form action ='../welcome_page.php' method = 'get'>
              <button type = 'submit'>Continue to Main Page</button>
              </form>";
        }
        else { 
            echo "Incorrect password";
            echo "<form action ='../log_in.php' method = 'get'>
              <button type = 'submit'>Return to sign in</button>
              </form>";
        }
         
    } else {
        echo "Username does not exist" . $conn->error;
    }

    $conn->close();
    ?>
</html>
