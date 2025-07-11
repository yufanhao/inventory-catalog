<html>
    <head>
        <title>Model Catalog</title>
        <link rel="stylesheet" href = "../styles.css">
    </head>
    <body>
        <h1>Inventory</h1>
        
        <h2>Change page directory:</h2>

        <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="../items/add_new_item.php">
            <button>Add new item</button>
        </a>

        <a href="../locations/insert_location.php">
            <button>Add new storage location</button>
        </a>

        <a href="../locations/locations.php">
            <button>View locations</button>
        </a>

        <a href="../models/add_new_model.php">
            <button>Add new model</button>
        </a><br>
        
        
        <h2>Model list:</h2>

        <h3>Filter Items:</h3>
        <form method = "GET" action = "">
            Name: <input type="text" name = "name" placeholder = "Search items..." value =
                "<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
            Category: <input type="text" name = "category" placeholder = "Search items..." value =
                "<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?>">
            Part Number: <input type="text" name = "part_number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['part_number']) ? htmlspecialchars($_GET['part_number']) : ''; ?>">
            <input type="hidden" name="searched" value="searched">
            <button type = "submit">Search</button>
            <!--<a href="search_model.php"><button type = "button">Advanced Search/Filter</button></a>-->
        </form>

        <?php
        include '../db.php';
        //include 'item_utils.php';
        //$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
        $name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
        $category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
        $part_number = isset($_GET['part_number']) ? $conn->real_escape_string($_GET['part_number']) : '';

        if ($searched !== "") {
            $items = $conn->query("SELECT * FROM models
            WHERE name like '%$name%' AND category like '%$category%' 
            AND part_number like '%$part_number%'
            GROUP BY name");
        } else {
            $items = $conn->query("SELECT * FROM models ORDER BY name");
        }
        if (!$items) {
            die("Query Error: " . $conn->error);
        }
        
        echo "<table border='1' cellpadding='8' style = 'margin-top: 10px;'>";
        echo "<tr><th>Model Name</th><th>Part Number</th><th>Category</th><th>Image</th><th>Quantity</th></tr>";
        while ($row = $items->fetch_assoc()) {
            $count = $conn->query("SELECT COUNT(*) as quantity from items where model_id = '" . $row['id'] . "'")->fetch_assoc();

            echo "<tr>";
            echo "<td> <a href='../items/get_item_by_model_id.php?model_id=" . $row['id'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . $row["part_number"]."</td>";
            echo "<td>" . $row["category"] ."</td>";
            echo '<td title= ' . $row["image_url"].'> <img src="' . $row["image_url"].'"width="300" height="300" > </td>';            
            echo "<td>" . $count["quantity"]."</td>";
            echo "<td>
            <form method='POST' action='update_model.php'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <button type='submit'>Edit Model</button>
            </form></td>";   
            echo "</tr>";
        }
        
        $conn->close();
        ?>
    </body>
</html>