<html>
    <?php
    $conn = new mysqli("localhost", "root", "Poopcorn2005$","inventory_db");

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

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
        echo "<form action ='../items/inventory.php' method = 'get'>
              <button type = 'submit'>See Inventory</button>
              </form>";

        $conn->close();
    }
    ?>
    
</html>
