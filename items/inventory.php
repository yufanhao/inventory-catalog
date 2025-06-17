<head>
    <title>Item Catalog</title>
    <link rel="stylesheet" href = "../styles.css">
</head>

<html>
    <body>
        <h1>Inventory</h1>
        
        <h2>Change page directory:</h2>

        <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="add_new_item.php">
            <button>Add new item</button>
        </a>

        <a href="../locations/insert_location.php">
            <button>Add new storage location</button>
        </a>

        <a href="../locations/locations.php">
            <button>View locations</button>
        </a>
            
        <h2>Item list:</h2>
        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM items order by name");

        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>Model Name</th><th>Category</th><th>Image</th><th>Expiration</th><th>Location</th><th>Quantity</th><th>Delete Item</th></tr>";
        $myArray = array();
        while ($row = $result->fetch_assoc()) {
            $item_id = $row['id'];
            $name = $row['name'];

            //NOTE: Hack to remove duplicate items with same model name.
            // real fix is to split the items table.
            if (array_search($name, $myArray) !== false) {
                continue;
            }
        
            array_push($myArray, $name);

            $box_id_sql = "SELECT box_id FROM item_box_join WHERE item_id = $item_id";
            
            $res = $conn->query($box_id_sql);
            $row2 = $res->fetch_assoc();
            $box_id = $row2['box_id'];

            
            $box_number_sql = "SELECT number FROM boxes WHERE id = $box_id";
            

            $res2 = $conn->query($box_number_sql);
            $row2 = $res2->fetch_assoc();

            $quantity_id = $row['name'];
            $quantity_sql = "SELECT distinct name, COUNT('id') AS quantity FROM items WHERE name = '$quantity_id' group by name" ;
            $res3 = $conn->query($quantity_sql);
            $row3 = $res3->fetch_assoc();
            $quantity_id = $row3[1];

            echo "<tr>";
            //echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['id'] ."</a></td>";
            echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . $row['category'] ."</td>";
            echo '<td> <img src="' . $row["image_url"] .'"width="75" height="75" > </td>';
            echo "<td>" . $row['expiration'] ."</td>";
            echo "<td>" . $row2['number'] ."</td>";
            echo "<td>" . $row3['quantity'] ."</td>";
            echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
            echo "</tr>";
        }
        
        $conn->close()
        ?>
    </body>
</html>