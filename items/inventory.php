<head>
    <title>Item Catalog</title>
    <link rel="stylesheet" href = "styles.css">
</head>

<html>
    <body>
        <h1>Inventory</h1>
        
        <h2>Add new item:</h2>
        <form action="insert_item.php" method="POST">
            Name: <input type="text" name="name"><br>
            Category: <input type="text" name="category"><br>
            Image: <input type="file" id="fileInput" name="image_url"><br>
            Expiration: <input type="text" name="expiration"><br>
            Location: <input type="number" name="location"><br>
            Quantity: <input type="number" name="quantity"><br>
            <input type="submit">
        </form>
        <p></p>
        <form action="bulk_insert.php" method="POST">
            Add items in bulk from a file spreadsheet: 
            <input type="file" id="fileInput" name="table_file"><br>
            <input type="submit">
        </form>
        <p></p>
        <h2>Item list:</h2>
        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM items");

        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Image</th><th>Expiration</th><th>Location</th><th>Quantity</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $item_id = $row['id'];
            $box_id_sql = "SELECT box_id FROM item_box_join WHERE item_id = $item_id";
            $res = $conn->query($box_id_sql);
            $row2 = $res->fetch_assoc();
            $box_id = $row2["box_id"];
            $box_number_sql = "SELECT number FROM boxes WHERE id = $box_id";
            $res = $conn->query($box_number_sql);
            $row2 = $res->fetch_assoc();
            $quantity_sql = "SELECT COUNT('id') AS Quantity FROM items GROUP by name";
            
            echo "<tr>";
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['id'] ."</a></td>";
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . $row['category'] ."</td>";
            echo '<td> <img src="' . $row["image_url"] .'"width="75" height="75" > </td>';
            echo "<td>" . $row['expiration'] ."</td>";
            echo "<td>" . $row2['number'] ."</td>";
            echo "<td>" . $row['quantity'] ."</td>";
            echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>