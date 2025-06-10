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
            Box Number: <input type="number" name="box_number"><br>
            <input type="submit">
        </form>
            
        <h2>Item list:</h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM items");

        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Image</th><th>Expiration</th><th>Box Number</th><th>Cabinet Number</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $item_id = $row['id'];
            $box_id_sql = "SELECT box_id FROM item_box_join WHERE item_id = $item_id";
            $result = $conn->query($box_id_sql);
            $row = $result->fetch_assoc();
            $box_id = $row["box_id"];

            $box_number_sql = "SELECT number FROM boxes WHERE id = $box_id";
            $result = $conn->query($box_number_sql);
            $row = $result->fetch_assoc();
            $box_number = $row["number"];

            echo "<tr>";
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['id'] .'</a></td>';
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] .'</td>';
            echo "<td>" . $row['category'] .'</td>';
            echo "<td>" . $row['image_url'] .'</td>';
            echo "<td>" . $row['expiration'] .'</td>';
            echo "<td>" . $box_number .'</td>';
            echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>