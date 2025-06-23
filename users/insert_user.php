<html>
    <?php
    require_once('../db.php');

    $username =  $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $user = $conn->query("SELECT * from users WHERE name='$username'");
    if ($user && $user->num_rows > 0) {
        echo "That username already exists";
        echo "<form action ='../sign_up.php' method = 'get'>
              <button type = 'submit'>Return to sign up</button>
              </form>";
    }
    else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New user created successfully <br>";
        } else {
            echo "Error: " . $conn->error;
        }
        echo "<form action ='../welcome_page.php' method = 'get'>
              <button type = 'submit'>See Welcome Page</button>
              </form>";

        $conn->close();
    }
    ?>
    <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>    
</html>
