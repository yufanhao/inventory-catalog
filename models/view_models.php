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

         <a href="../add_new_category.php">
            <button>Add new category</button>
        </a>
        
        <h2>Model list:</h2>

        <h3>Filter Items:</h3>
        <form method = "GET" action = "">
            Name: <input type="text" name = "name" placeholder = "Search items..." value =
                "<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
            <?php 
                include '../db.php';
                echo "Category: <select name='category_name'>";
                
                $categories = $conn->query("SELECT DISTINCT name FROM categories ORDER BY name");
                while ($category = $categories->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($category['name']) . "'>" . htmlspecialchars($category['name']) . "</option>";
                }
                echo "</select><br>";
            ?> 
            Part Number: <input type="text" name = "part_number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['part_number']) ? htmlspecialchars($_GET['part_number']) : ''; ?>">
            <input type="hidden" name="searched" value="searched">
            <button type = "submit">Search</button>
            <!--<a href="search_model.php"><button type = "button">Advanced Search/Filter</button></a>-->
        </form>

        <?php
        include '../db.php';
        $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
        $name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
        $cat_name = isset($_GET['category_name']) ? $conn->real_escape_string($_GET['category_name']) : '';
        $part_number = isset($_GET['part_number']) ? $conn->real_escape_string($_GET['part_number']) : '';


        if ($searched !== "") {
            $cat_id = $conn->query("SELECT id FROM categories WHERE name LIKE '$cat_name'");
            $id = $cat_id->fetch_assoc();
            $id = $id['id'];
            //echo "debug: " . $id;
            $items = "SELECT * FROM models ";
            $srch = False;

            if($name !== "") {
                $items = $items . " WHERE name like '%$name%'";
                $srch = True;
            }
            
            if($id !== "") 
                if($id !== '9')
                   { // if category isn't blank
                   if($srch)
                     $items = $items . " AND";
                   else 
                    $items = $items . " WHERE";
                   $items = $items . " category_id like '$id'";
                   $srch = True;
                }

            if($part_number !== "") {
                if($srch)
                    $items = $items . " AND";
                else 
                    $items = $items . " WHERE";
                $items = $items . " part_number like '%$part_number%'";
                $srch = True;
            }

            $items = $items . " ORDER BY name";
            echo $items;

            $items = $conn->query($items);

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
            echo "<td><a href='../items/get_item_by_model_id.php?model_id=" . $row['id'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . $row["part_number"]."</td>";
            $category_id = $row["category_id"];
            $category = $conn->query("SELECT name FROM categories where id = '$category_id'")->fetch_assoc();
            echo "<td>" . $category['name'] ."</td>";
            echo "<td><img src='get_image.php?id=" . $row['id'] . "' width='75' height='75'></td>";
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