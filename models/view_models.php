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
        </a>

         <a href="../categories/add_new_category.php">
            <button>Add new category</button>
        </a>
        
        <h2>Model list:</h2>

        <h3>Filter Items:</h3>
        <form method = "GET" action = "">
            Name: <input type="text" name = "name" placeholder = "Search items..." value =
                "<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
            <!-- Category: <input type="text" name = "category" placeholder = "Search items..." value =
                "<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category']) : ''; ?>"> -->
            <?php 
                include '../db.php';

                $selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
                echo "Category: <select name='category'>";
                $defaultSelected = ($selectedCategory === '') ? 'selected' : '';
                echo "<option value='' $defaultSelected>-- Select Category --</option>";

                $categories = $conn->query("SELECT DISTINCT name FROM categories ORDER BY name");
                while ($category = $categories->fetch_assoc()) {
                    $name = htmlspecialchars($category['name']);
                    $isSelected = ($name === $selectedCategory) ? 'selected' : '';
                    echo "<option value='$name' $isSelected>$name</option>";
                }
                echo "</select>";
            ?>
            Part Number: <input type="text" name = "part_number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['part_number']) ? htmlspecialchars($_GET['part_number']) : ''; ?>">
            <input type="hidden" name="searched" value="searched">
            <button type = "submit">Search</button>
        </form>

        <?php
        include '../db.php';
        include('../ui_components/pagination.php');
        $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
        $name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
        $category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
        $part_number = isset($_GET['part_number']) ? $conn->real_escape_string($_GET['part_number']) : '';
        $category_row = $conn->query("SELECT id FROM categories WHERE name = '$category'")->fetch_assoc();
        $category_id = isset($category_row['id']) ? $category_row['id'] : '';
        if ($searched !== "") {
            $sql = "SELECT * FROM models WHERE 1=1 ";
            if ($name != '') {
                $sql .= "AND name like '%$name%' ";
            }
            if ($part_number != '') {
                $sql .= "AND part_number like '%$part_number%' ";
            }
            if ($category != '') {
                $sql .= "AND category_id = '$category_id' ";
            }
        }
        else {
            $sql = "SELECT * from models ";
        }
        $sql .= "ORDER by name";

        $pagination_ctx = initialize_pagination($conn, $sql);

        // Add LIMIT construct for pagination.
        $items = $conn->query($sql . $pagination_ctx["pagination_limit"]); 

        // Pagination: Display section, using styles defined at the top of the page.  
        // construct url parameters, preserve search items. filter out empty key,value pairs.
        $search_data = array( 
            "name" => $name,
            "part_number" => $part_number,
            "category" => $category,
            "searched" => $searched
        );

        display_pagination($pagination_ctx, "view_models.php", $search_data);

        
        if (!$items) {
            die("Query Error: " . $conn->error);
        }
        
        echo "<table border='1' cellpadding='8' style = 'margin-top: 10px;'>";
        echo "<tr><th>Model Name</th><th>Part Number</th><th>Category</th><th>Image</th><th>Quantity</th><th>Action</th></tr>";
        while ($row = $items->fetch_assoc()) {
            $count = $conn->query("SELECT COUNT(*) as quantity from items where model_id = '" . $row['id'] . "'")->fetch_assoc();
            echo "<tr>";
            echo "<td><a href='../items/get_item_by_model_id.php?model_id=" . $row['id'] . "'>" . $row['name'] ."</td>";
            echo "<td>" . $row["part_number"]."</td>";
            $category_id = $row["category_id"];
            $category = $conn->query("SELECT name FROM categories where id = '$category_id'")->fetch_assoc();
            echo "<td>" . $category['name'] ."</td>";
            echo "<td><img src='get_image.php?id=" . $row['id'] . "' width='75' height='75'></td>";
            echo "<td>" . $count["quantity"]. "</td>";
            echo "<td>
            <form method='POST' action='update_model.php'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <button type='submit'>Edit Model</button>
            </form>
            <form method='POST' action='../items/add_new_item.php'>
                <input type='hidden' name='model_name' value='" . htmlspecialchars($row['name']) . "'>
                <button type='submit'>Add Item</button>
            </form>
            </td>";   
            echo "</tr>";
        }
        
        $conn->close();
        ?>
    </body>
</html>