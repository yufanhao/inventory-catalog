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
            Serial Number: <input type="text" name = "serial_number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['serial_number']) ? htmlspecialchars($_GET['serial_number']) : ''; ?>">
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
        $serial_number = isset($_GET['serial_number']) ? $conn->real_escape_string($_GET['serial_number']) : '';

        if ($searched !== "") {
            $items = $conn->query("SELECT * FROM models
            WHERE name like '%$name%' AND category like '%$category%' 
            AND serial_number like '%$serial_number%'
            GROUP BY name");
        } else {
            $items = $conn->query("SELECT * FROM models");
        }
        
        echo "<table border='1' cellpadding='8' style = 'margin-top: 10px;'>";
        echo "<tr><th>Model Name</th><th>Serial Number</th><th>Category</th><th>Image</th><th>Quantity</th></tr>";
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
        
        $conn->close();
        ?>
    </body>
</html>