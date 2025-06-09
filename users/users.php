<!DOCTYPE html>
<html>
    <body>
        <h1>
            Users
        </h1>

        <?php
        $result = $conn->query("SELECT * FROM users");

        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['id']) .'</a></td>';
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) .'</a></td>';
            echo "<td>" . htmlspecialchars($row['email']) .'</td>';
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>