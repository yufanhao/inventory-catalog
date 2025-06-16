<!DOCTYPE html>
<html>
    <body>
        <h1>
            Inventory
        </h1>
        
        <h2>Change page directory:</h2>

        <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="add_new_item.php">
            <button>Add new item</button>
        </a>
            
        <h2>Item list:</h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM items");

        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Image</th><th>Expiration</th><th>Box Number</th><th>Cabinet Number</th><th>Delete Items</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $item_id = $row['id'];
            $box_id_sql = "SELECT box_id FROM item_box_join WHERE item_id = $item_id";
            $res = $conn->query($box_id_sql);
            $row2 = $res->fetch_assoc();
            $box_id = $row2["box_id"];

            $box_number_sql = "SELECT * FROM boxes WHERE id = $box_id";
            $res = $conn->query($box_number_sql);
            $row2 = $res->fetch_assoc();
            $box_number = $row2["number"];
            $cabinet_id = $row2["cabinet_id"];

            $cabinet_number_sql = "SELECT * FROM cabinets WHERE id = $cabinet_id";
            $res = $conn->query($cabinet_number_sql);
            $row2 = $res->fetch_assoc();
            $cabinet_number = $row2["number"];
            
            echo "<tr>";
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['id'] .'</a></td>';
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] .'</td>';
            echo "<td>" . $row['category'] .'</td>';
            echo '<td> <img src="' . $row["image_url"] .'"width="75" height="75" > </td>';
            echo "<td>" . $row['expiration'] .'</td>';
            echo "<td>" . $box_number .'</td>';
            echo "<td>" . $cabinet_number .'</td>';
            echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>