<html>
    <body>
    <h2>Filter Items:</h2>
    <form method = "GET" action = "">
            Serial Number: <input type="text" name = "serial_number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['serial_number']) ? htmlspecialchars($_GET['serial_number']) : ''; ?>">
            Expiration: <input type="date" name="expiration" disabled>
            Before/After: <select name="before_after" disabled>
                <option value="<=">Before</option>
                <option value=">">After</option>
            </select><br>
            Location: <select name="location_type" disabled>
                <option value="box">Box</option>
                <option value="cabinet">Cabinet</option>
                <option value="shelf">Shelf</option>
                <option value="floor">Floor</option>
                <option value="other">Other</option></select>
            Number(i.e. box number, etc): <input type="number" name = "number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['number']) ? htmlspecialchars($_GET['number']) : ''; ?>">
            <input type="hidden" name="searched" value="searched">
            <button type="submit">Search</button>
        </form>

<?php
    include('../db.php');

    //include 'item_utils.php';
    //$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
    $serial_number = isset($_GET['serial_number']) ? $conn->real_escape_string($_GET['serial_number']) : '';
    $expiration = isset($_GET['expiration']) ? $conn->real_escape_string($_GET['expiration']) : '';
    $before_after = isset($_GET['before_after']) ? $conn->real_escape_string($_GET['before_after']) : '';
    $location_type = isset($_GET['location_type']) ? $conn->real_escape_string($_GET['location_type']) : '';
    $location_number = isset($_GET['number']) ? $conn->real_escape_string($_GET['number']) : '';

    $model_id = $_GET["model_id"];
    
    $flag = FALSE;
    
    $model_sql = "SELECT * FROM models WHERE id = '$model_id'";
    $model = $conn->query($model_sql)->fetch_assoc();

    if ($searched !== "") 
        //if($_GET['before_after'] === "<=") {
            $items = $conn->query("SELECT * FROM items
            WHERE serial_number like '%$serial_number%'
            AND model_id = $model_id");
          //  }
        //else if ($_GET['before_after'] === ">") {
          //  $items = $conn->query("SELECT * FROM items
           // WHERE serial_number like '%$serial_number%'");
            //AND expiration >= '$expiration'");
     //   }
    else
        $items = $conn->query("SELECT * FROM items where model_id = $model_id" );

    // echo $items  . '<br>';

    echo"<h2>".$model['name']."</h2>"; // model_name
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Serial Number</th><th>Expiration</th>
          <th>Box</th><th>Cabinet</th><th>Shelf</th><th>Floor</th><th>Delete Item</th></tr>";
    while ($row = $items->fetch_assoc()) {
        $location_id = $row['location_id'];
        $location_sql = "SELECT * FROM locations WHERE id = $location_id";
        $location = $conn->query($location_sql)->fetch_assoc();
        $location_type = $location["type"];
        $flag = FALSE;

        $location_array = array(
            'box' => "",
            'cabinet' => "",
            'shelf' => "",
            'floor' => ""
        );

        // Traverse up the location hierarchy to get all location types and numbers
        // TODO: Check post merge - while ($location_type != 'ancestor' AND $flag == FALSE){
        while (($location_type !== 'ancestor') && ($flag === FALSE)) {
           if (!$location) {
                echo "Location not found for item: " . $row['serial_number'] . ". Please check the database.";
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
        
        // echo $location_array['box'];
        // echo "<br>";
        echo $location_array['cabinet'];
        echo "<br>";
        echo $location_array['floor'];
        echo "<br>";

        echo "<tr>";
        echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['serial_number'] ."</td>";
        echo "<td>" . $row['expiration'] ."</td>";
        echo "<td>" . $location_array['box'] . "</td>";
        echo "<td>". $location_array['cabinet'] ."</td>";
        echo "<td>". $location_array['shelf'] ."</td>";
        echo "<td>". $location_array['floor'] ."</td>";
        echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
        echo "</tr>";
    }
    echo '</table>';
    echo "<br><form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button><br><br>
                </form>";

    $conn->close();

    ?>
    </body>
</html>