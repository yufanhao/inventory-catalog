<html>
    <head>
        <title>Search</title>
        <link rel="stylesheet" href = "../styles.css">
    </head>
    <body>
        <h1>Search Model</h1>

        <a href = "view_models.php">
            <button>Return to Inventory Page</button>
        </a>

        <form method = "GET" action = "" style = "margin-top: 20px;">
            <input type="text" name = "name" placeholder = "Search items by name..." value =
                "<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
            <input type="hidden" name="searched" value="searched">
            <button type = "submit">Search</button>
        </form>

        <h2>Advanced Search/Filter:</h2>

        <form action="" method="GET">
            Name: <input type="text" name="name"><br>
            Category: <input type="text" name="category"><br>
            <!--
            Expiration: <input type="date" name="expiration">
            Before/After: <select name="before_after">
                <option value="<=">Before</option>
                <option value=">">After</option>
            </select><br>
            Location: <select name="location_type">
                <option value="box">Box</option>
                <option value="cabinet">Cabinet</option>
                <option value="shelf">Shelf</option>
                <option value="floor">Floor</option>
                <option value="other">Other</option></select>
            Number(i.e. box number, etc): <input type="number" name="number"><br>-->
            <input type="hidden" name="searched" value="searched">
            <button type="submit">Search</button>
        </form>

        <a href = "search_model.php">
            <button type = "button">Clear Search</button>
        </a>
        
        <h2>Models:</h2>

        <?php
        include '../db.php';
        $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
        $name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
        $category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
        //$expiration = isset($_GET['expiration']) ? $conn->real_escape_string($_GET['expiration']) : '';
        $before_after = isset($_GET['before_after']) ? $conn->real_escape_string($_GET['before_after']) : '';
        //$location_type = isset($_GET['location_type']) ? $conn->real_escape_string($_GET['location_type']) : '';
        //$location_number = isset($_GET['number']) ? $conn->real_escape_string($_GET['number']) : '';

        // Gets items based on search criteria
        if ($searched !== "") {
            $items = $conn->query("SELECT * FROM models
            WHERE name like '%$name%' AND category like '%$category%'
            GROUP BY name");
        } else {
            $items = $conn->query("SELECT * FROM models");
        }

        echo "<table border='1' cellpadding='8' style = 'margin-top: 10px;'>";
        echo "<tr><th>Name</th><th>Image</th><th>Quantity</th></tr>";
        if ($items->num_rows > 0) {
            echo "<p>Found " . $items->num_rows . " items.</p>";
            while ($row = $items->fetch_assoc()) {
                
                $items_sql = 'SELECT count(*) from items where model_id = ' . $row['id'];
                $count = $conn->query($items_sql)->fetch_row();

            echo "<tr>";
            echo "<td> <a href='../items/get_item_by_model_id.php?model_id=" . $row['id'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . $row["serial_number"]."</td>";
            echo "<td>" . $row["category"] ."</td>";
            echo '<td> <img src="' . $row["image_url"].'"width="75" height="75" > </td>';            
            echo "<td>" . $count[0]."</td>";
            echo "</tr>";

    

            
        }
        } else {
            echo "<p>No items found.</p>";
        }
        
        
        $conn->close();
        ?>
    </body>
</html>