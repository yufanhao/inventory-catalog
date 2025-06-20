<html>
    <head>
        <title>Item Catalog</title>
        <link rel="stylesheet" href = "../styles.css">
    </head>
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

        <a href="../models/insert_model.php">
            <button>Add new model</button>
        </a><br>
        
        
        <h2>Item list:</h2>

        <form method = "GET" action = "">
            <input type="text" name = "search" placeholder = "Search items..." value =
                "<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type = "submit">Search</button>
            <a href="search.php"><button type = "button">Advanced Search/Filter</button></a>
        </form>

        <?php
        include '../db.php';
        include 'item_utils.php';
        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

        // Gets unique item names and their minimum ID for deletion
        if ($search !== "") {
            $items = $conn->query("SELECT name, category AS category, MIN(id) AS id, MIN(image_url) AS image_url, count(*) as quantity FROM items WHERE name like '%$search%' GROUP BY name");
        } else {
            $items = $conn->query("SELECT name, category AS category, MIN(id) AS id, MIN(image_url) AS image_url, count(*) as quantity FROM items GROUP BY name");
        }

        /*
        $items = $conn->query("SELECT name, MIN(id) AS id, FROM items WHERE name like '%$search%' GROUP BY name");
            $models = $conn->query("SELECT name, category AS category, MIN(id) AS id, MIN(image_url) AS image_url, count(*) as quantity FROM items WHERE name like '%$search%' GROUP BY name");
*/

        //$items = $conn->query("SELECT name, MIN(id) AS id, count(*) as quantity FROM items GROUP BY name");
        
        echo "<table border='1' cellpadding='8' style = 'margin-top: 10px;'>";
        echo "<tr><th>Name</th><th>Category</th><th>Image</th><th>Quantity</th></tr>";
        while ($row = $items->fetch_assoc()) {
    
            // go back and query image_url for the min ID.
            // Need to query again for img_url, based on min ID from latest query..
            // For now, use fetch_item_data() function, til we go back to model table.
            echo "<tr>";
            echo "<td> <a href='get_item_by_name.php?name=" . $row['name'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . fetch_item_data($conn, $row['id'], "category") ."</td>";
            echo '<td> <img src="' . fetch_item_data($conn, $row["id"], "image_url").'"width="75" height="75" > </td>';            
            echo "<td>" . $row['quantity'] ."</td>";
            echo "</tr>";
        }
        
        $conn->close();
        ?>
    </body>
</html>