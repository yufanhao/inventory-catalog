<html>
    <head>
        <title>Search</title>
        <link rel="stylesheet" href = "../styles.css">
    </head>
    <body>
        <h1>Search</h1>

        <a href = "inventory.php">
            <button>Return to Inventory Page</button>
        </a>

        <form method = "GET" action = "" style = "margin-top: 20px;">
            <input type="text" name = "name" placeholder = "Search items by name..." value =
                "<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
            <input type="hidden" name="searched" value="searched">
            <button type = "submit">Search</button>
        </form>

        <h2>Advanced Search/Filter:</h2>
        <form action="" method="GET"> <!-- the value field lets the searched values stay in fields after searching -->
            Name: <input type="text" name="name" value = 
                "<?php echo isset($_GET["name"]) ? htmlspecialchars($_GET["name"]) : ''; ?>"><br>
            Category: <input type="text" name="category" value =
                "<?php echo isset($_GET["category"]) ? htmlspecialchars($_GET["category"]) : ''; ?>"><br>
            Part Number: <input type="text" name="part_number" value = 
                "<?php echo isset($_GET["part_number"]) ? htmlspecialchars($_GET["part_number"]) : ''; ?>"><br>
            Serial Number: <input type="text" name="serial_number" value = 
                "<?php echo isset($_GET["serial_number"]) ? htmlspecialchars($_GET["serial_number"]) : ''; ?>"><br>
            Expiration: <input type="date" name="expiration" value = 
                "<?php echo isset($_GET["expiration"]) ? $_GET["expiration"] : ''; ?>"><br>
            Before/After: <select name="before_after">
                <option value="<=" <?php if (isset($_GET["before_after"]) && $_GET["before_after"] == "<=") echo "selected";?>>Before</option>
                <option value=">" <?php if (isset($_GET["before_after"]) && $_GET["before_after"] == ">") echo "selected";?>>After</option>
            </select><br>
            Location: <select name="location_type" value = 
                "<?php echo isset($_GET["location_type"]) ? htmlspecialchars($_GET["location_type"]) : ''; ?>">
                <option value="box">Box</option>
                <option value="cabinet">Cabinet</option>
                <option value="shelf">Shelf</option>
                <option value="floor">Floor</option>
                <option value="other">Other</option></select>
            Number(i.e. box number, etc): <input type="number" name="number" value = 
                "<?php echo isset($_GET["number"]) ? htmlspecialchars($_GET["number"]) : ''; ?>"><br>
            <input type="hidden" name="searched" value="searched">
            <button type="submit">Search</button>
        </form>

        <a href = "search.php">
            <button type = "button">Clear Search</button>
        </a>
        
        <h2>Items:</h2>

        <?php
        include '../db.php';
        include '../functions.php';
        $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
        $name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
        $category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
        $part_number = isset($_GET['part_number']) ? $conn->real_escape_string($_GET['part_number']) : '';
        $serial_number = isset($_GET['serial_number']) ? $conn->real_escape_string($_GET['serial_number']) : '';
        $expiration = isset($_GET['expiration']) ? $conn->real_escape_string($_GET['expiration']) : '';
        $before_after = isset($_GET['before_after']) ? $conn->real_escape_string($_GET['before_after']) : '';
        $location_type = isset($_GET['location_type']) ? $conn->real_escape_string($_GET['location_type']) : '';
        $location_number = isset($_GET['number']) ? $conn->real_escape_string($_GET['number']) : '';

        // Gets items based on search criteria
        if ($searched !== "") {
            $query = "SELECT * FROM items WHERE 1=1";
            if ($name !== "") {
                $query .= " AND name LIKE '%$name%'";
            }
            if ($category !== "") {
                $query .= " AND category LIKE '%$category%'";
            }
            if ($part_number !== "") {
                $query .= " AND part_number LIKE '%$part_number%'";
            }
            if ($serial_number !== "") {
                $query .= " AND serial_number LIKE '%$serial_number%'";
            }
            if ($expiration !== "") {
                $query .= " AND expiration $before_after '$expiration'";
            }
            $query .= " GROUP BY name";
            $items = $conn->query($query);
        } else {
            $items = $conn->query("SELECT * FROM items GROUP BY name");
        }

        echo "<table border='1' cellpadding='8' style = 'margin-top: 10px;'>";
        echo "<tr><th>Name</th><th>Image</th><th>Box</th><th>Cabinet</th><th>Shelf</th><th>Floor</th><th>Expiration</th><th>Delete</th></tr>";
        if ($items->num_rows > 0) {
            echo "<p>Found " . $items->num_rows . " items.</p>";
            while ($row = $items->fetch_assoc()) {
                $location_id = $row['location_id'];
                $location_array = get_location($conn, $location_id);
                
                echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] ."</td>";
                echo '<td> <img src="' . $row["image_url"] .'"width="75" height="75" > </td>';
                echo "<td>" . $location_array['box'] . "</td>";
                echo "<td>". $location_array["cabinet"] ."</td>";
                echo "<td>". $location_array["shelf"] ."</td>";
                echo "<td>". $location_array["floor"] ."</td>";
                echo "<td>" . $row["expiration"] ."</td>";
                echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<p>No items found.</p>";
        }
        
        
        $conn->close();
        ?>
    </body>
</html>