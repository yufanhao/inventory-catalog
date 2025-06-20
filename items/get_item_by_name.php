<html>
    <body>
    

    <?php
    require_once('../db.php');

    $name = $_GET["name"];
    echo"<h2>".$name."</h2>";
    $flag = FALSE;

    $items = $conn->query("SELECT * FROM items WHERE name = '$name'");
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Model Name</th><th>Category</th><th>Image</th><th>Expiration</th>
          <th>Box</th><th>Cabinet</th><th>Shelf</th><th>Floor</th><th>Delete Item</th></tr>";
    while ($row = $items->fetch_assoc()) {
        $location_id = $row['location_id'];
        $location_sql = "SELECT * FROM locations WHERE id = $location_id";
        $location = $conn->query($location_sql)->fetch_assoc();
        $location_type = $location["type"];
        $location_array = array(
            'box' => "",
            'cabinet' => "",
            'shelf' => "",
            'floor' => ""
        );

        // Traverse up the location hierarchy to get all location types and numbers
        while ($location_type != 'ancestor' AND $flag == FALSE) {
            if (!$location) {
                echo "Location not found for item: " . $row['name'] . ". Please check the database.";
                $flag = TRUE;
                break;
            }

            $location_number = $location['number'];
            $location_array[$location_type] = $location_number;

            $parent_id = $location['parent_id'];
            $parent_sql = "SELECT * FROM locations WHERE id = $parent_id";
            $parent = $conn->query($parent_sql)->fetch_assoc();
            $location = $parent;
            $location_type = $location["type"];
        }

        echo "<tr>";
        echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] ."</td>";
        echo "<td>" . $row['category'] ."</td>";
        echo '<td> <img src="' . $row["image_url"] .'"width="75" height="75" > </td>';
        echo "<td>" . $row['expiration'] ."</td>";
        echo "<td>" . $location_array['box'] . "</td>";
        echo "<td>". $location_array["cabinet"] ."</td>";
        echo "<td>". $location_array["shelf"] ."</td>";
        echo "<td>". $location_array["floor"] ."</td>";
        echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
        echo "</tr>";
    }
    echo "<br><form action ='inventory.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button><br><br>
                </form>";

    $conn->close();
    ?>
    </body>
</html>