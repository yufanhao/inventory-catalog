<!DOCTYPE html>
<html>
    <body>
        <h1>
            Inventory
        </h1>
        
        <h2>Add new item:</h2>
        <form action="insert_item.php" method="POST">
            Name: <input type="text" name="name"><br>
            Category: <input type="text" name="category"><br>
            Image: <input type="text" name="image_url"><br>
            Expiration: <input type="text" name="expiration"><br>
            <input type="submit">
        <h2>Item list:</h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM items");

        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Image</th><th>Expiration</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['id']) .'</a></td>';
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['name']) .'</td>';
            echo "<td>" . htmlspecialchars($row['category']) .'</a></td>';
            echo "<td>" . htmlspecialchars($row['image_url']) .'</a></td>';
            echo "<td>" . htmlspecialchars(string: $row['expiration']) .'</a></td>';
            echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>