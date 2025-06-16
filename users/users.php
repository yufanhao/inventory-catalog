<!DOCTYPE html>
<html>
    <body>
        <h1>
            List of Users
        </h1>

        <h2>
            Change page directory:
        </h2>

        <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="../sign_up.php">
            <button>Add a new user</button>
        </a>

        <h2>
            Users:
        </h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM users");

        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['id']) .'</a></td>';
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['username']) .'</a></td>';
            echo "<td>" . htmlspecialchars($row['email']) .'</td>';
            echo "<td><a href='delete_user.php?id=" . $row['id'] . "'>Delete User</a></td>";
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>