<html>
    <body>
        <h1>Locations</h1>
        
        <a href="../models/view_models.php">
            <button>Return to Inventory Page</button>
        </a>

        <a href="../locations/insert_location.php">
            <button>Add New Storage Location</button>
        </a>

        <?php
        include '../db.php';
        include '../functions.php';

        // Gets unique item names and their minimum ID for deletion
        $location_id = $_GET['id'];
        $parent = $conn->query("SELECT parent_id FROM locations WHERE id = $location_id")->fetch_assoc();
        $parent_id = $parent_id['parent_id'];
        if ($parent_id === null) {
            echo "<a href='../locations/locations.php'>";
            echo "<button>Back to Locations</button></a>";
        } 
        else {
            echo "<a href='../locations/get_location_by_id.php?id=" . $parent_id . "'>";
            echo "<button>Back to Previous Location</button></a>";
        }

        $location = $conn->query("SELECT * FROM locations WHERE id = $location_id")->fetch_assoc();
        $location_type = $location['type'];
        $child_locations = $conn->query("SELECT * FROM locations WHERE parent_id = $location_id");
        echo "<h2>Locations in this $location_type:</h2>";
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Type</th><th>Number/Name</th><th>Description</th><th>Parent ID</th></tr>";
        while ($child_location = $child_locations->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $child_location['id'] . "</td>";
            echo "<td>" . $child_location['type'] . "</td>";
            echo "<td><a href='get_location_by_id.php?id=" . $child_location['id'] . "'>" . $child_location['name'] . "</td>";
            echo "<td>" . $child_location['description'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
         
        // This includes all descendants of the current location
        $child_ids = getChildLocationIds($conn, $location_id);
        $items = $conn->query("SELECT model_id, MIN(id) AS id FROM items WHERE location_id IN (" . implode(',', $child_ids) . ") GROUP BY model_id");
        echo "<h2>Items in this $location_type:</h2>";
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>Name</th><th>Image</th><th>Quantity</th></tr>";
        while ($row = $items->fetch_assoc()) {
            // Counts the quantity of each item by name
            $count = $conn->query("SELECT COUNT(*) as quantity from items where model_id = '" . $row['model_id'] . "'")->fetch_assoc();
            $model_name = fetch_row_data($conn, 'models', $row['model_id'], 'name');
            echo "<tr>";
            echo "<td><a href='../items/get_item_by_model_id.php?model_id=" . $row['model_id'] . "'>" . htmlspecialchars($model_name) . "</a></td>";
            echo '<td title= ' . $row["image_url"].'> <img src="' . $row["image_url"].'"width="100" height="100" > </td>'; 
            echo "<td>" . $count['quantity'] ."</td>";
            echo "</tr>";
        }
        echo "</table>";

        $conn->close();
        function getChildLocationIds($conn, $parent_id) {
            $ids = array();
            $ids[] = $parent_id;

            $query = "SELECT id FROM locations WHERE parent_id = $parent_id";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                $child_id = $row['id'];
                $ids = array_merge($ids, getChildLocationIds($conn, $child_id));
            }
            return $ids;
        }
        
        ?>
    </body>
</html>