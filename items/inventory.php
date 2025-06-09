<!DOCTYPE html>
<html>
    <body>
        <h1>
            Inventory
        </h1>

        <a href="insert_item.php"><button>Add new item</button></a>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM items");

        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Image</th><th>Expiration</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['id']) .'</a></td>';
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) .'</a></td>';
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['category']) .'</a></td>';
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['image_url']) .'</a></td>';
            echo "<td><a href='get_user_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['expiration']) .'</a></td>';
            echo "<td>" . htmlspecialchars($row['email']) .'</td>';
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>