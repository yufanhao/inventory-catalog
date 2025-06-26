<html>
    <body>
    <h2>Filter Items:</h2>
    <form method = "GET" action = "">
            Serial Number: <input type="text" name = "serial_number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['serial_number']) ? htmlspecialchars($_GET['serial_number']) : ''; ?>"></br>
            Before: <input type="date" name="before" value =
                "<?php echo isset($_GET['before']) ? htmlspecialchars($_GET['before']) : ''; ?>">
            After: <input type="date" name="after" value =
                "<?php echo isset($_GET['after']) ? htmlspecialchars($_GET['after']) : ''; ?>"></br>
            Location: <select name="location_type">
                <option value="box">Box</option>
                <option value="cabinet">Cabinet</option>
                <option value="shelf">Shelf</option>
                <option value="floor">Floor</option>
                <option value="other">Other</option></select>
            Number(i.e. box number, etc): <input type="number" name = "number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['number']) ? htmlspecialchars($_GET['number']) : ''; ?>"></br>
            <input type="hidden" name="searched" value="searched">
            <input type="hidden" name="model_id" value="<?php echo isset($_GET['model_id']) ? htmlspecialchars($_GET['model_id']) : ''; ?>">
            <button type="submit">Search</button>
        </form>

<?php
    include('../db.php');
    include('../functions.php');

    //include 'item_utils.php';
    //$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
    $serial_number = isset($_GET['serial_number']) ? $conn->real_escape_string($_GET['serial_number']) : '';
    //$expiration = isset($_GET['expiration']) ? $conn->real_escape_string($_GET['expiration']) : '';
    $before = isset($_GET['before']) ? $conn->real_escape_string($_GET['before']) : '';
    $after = isset($_GET['after']) ? $conn->real_escape_string($_GET['after']) : '';
    $location_type = isset($_GET['location_type']) ? $conn->real_escape_string($_GET['location_type']) : '';
    $location_number = isset($_GET['number']) ? $conn->real_escape_string($_GET['number']) : '';

    $model_id = $_GET["model_id"];
    $flag = FALSE;
    $model_sql = "SELECT * FROM models WHERE id = '$model_id'";
    $model = $conn->query($model_sql)->fetch_assoc();

    $selection = "SELECT * FROM items WHERE 1=1";
        if ($model_id != '' AND $model != null) { // this should never happen, bc $model_id is a url parameter.
        $selection = $selection . " AND model_id = $model_id";
    }
    
    if ($searched !== "") {
        if ($serial_number != '') { // this should never happen, bc $model_id is a url parameter.
            $selection = $selection . " AND serial_number LIKE '%$serial_number%'";
        }

        if ($before != '') { // this should never happen, bc $model_id is a url parameter.
            $selection = $selection . " AND expiration <= Date('$before')";
        }

        if ($after != '') { // this should never happen, bc $model_id is a url parameter.
            $selection = $selection . " AND expiration >= Date('$after')";
        }
    }  

    $items = $conn->query($selection); // this is the base query;
    // at this point, $items has the final sql to execute include $model_id from url, and other values from filter form.

    echo"<h2>".$model['name']."</h2>"; // model_name
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Serial Number</th><th>Expiration</th>
          <th>Box</th><th>Cabinet</th><th>Shelf</th><th>Floor</th><th>Delete Item</th></tr>";
    while ($row = $items->fetch_assoc()) {
        $location_id = $row['location_id'];
        $location_array = get_location($conn, $location_id);
        
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