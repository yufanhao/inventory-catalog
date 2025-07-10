<html>
    <?php
    require_once('../db.php');

    $username =  $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $user = $conn->query("SELECT * from users WHERE name='$username'");
    $role = 'user'; // Default role for new users
    if ($user && $user->num_rows > 0) {
        echo "That username already exists";
        echo "<form action ='../sign_up.php' method = 'get'>
              <button type = 'submit'>Return to sign up</button>
              </form>";
    }
    else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
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
