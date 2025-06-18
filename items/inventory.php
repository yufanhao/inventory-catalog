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

        // Gets unique item names and their minimum ID for deletion
        $items = $conn->query("SELECT name, MIN(id) AS id FROM items GROUP BY name");

        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>Name</th><th>Image</th><th>Quantity</th></tr>";
        while ($row = $items->fetch_assoc()) {
            // Counts the quantity of each item by name
            $count = $conn->query("SELECT COUNT(*) as quantity FROM items WHERE name = '" . $row['name'] . "'")->fetch_assoc();

            echo "<tr>";
            echo "<td><a href='get_item_by_name.php?name=" . $row['name'] . "'>" . $row['name'] ."</td>";
            echo '<td> <img src="' . $row["image_url"] .'"width="75" height="75" > </td>';
            echo "<td>" . $count['quantity'] ."</td>";
            echo "</tr>";
        }
        
        $conn->close()
        ?>
    </body>
</html>