<?php
    session_start();
    require_once('../db.php');
    include('../ui_components/pagination.php');
?>
    <html>
        <style>
            .item_action_group {
                list-style-type: none;
                padding: 10px 0;
                display: inline-flex;
                justify-content: space-between;
            }
            .item_action_button {
                padding-right: 10px;
            }
        </style>

        <body>
        <h2>Filter Items:</h2>
 
    <form method = "GET" action = "">
        Serial Number: <input type="text" name = "serial_number" placeholder = "Search items..." value =
            "<?php echo isset($_GET['serial_number']) ? htmlspecialchars($_GET['serial_number']) : ''; ?>"></br>
        Expiration: <input type="date" name="expiration" value = 
            "<?php echo isset($_GET["expiration"]) ? $_GET["expiration"] : ''; ?>">
        Before/After: <select name="before_after">
            <option value="<=" <?php if (isset($_GET["before_after"]) && $_GET["before_after"] == "<=") echo "selected";?>>Before</option>
            <option value=">" <?php if (isset($_GET["before_after"]) && $_GET["before_after"] == ">") echo "selected";?>>After</option></select><br>
        Location: <select name="location_type">
            <option value="box">Box</option>
            <option value="cabinet">Cabinet</option>
            <option value="shelf">Shelf</option>
            <option value="floor">Floor</option>
            <option value="other">Other</option></select>
        Location Name(i.e. box number, customer name, etc): <input type="text" name = "location_name" placeholder = "Search items..." value =
            "<?php echo isset($_GET['location_name']) ? htmlspecialchars($_GET['location_name']) : ''; ?>"></br>

            Loaned By: <input type="text" name="user_name" value="<?php echo isset($_GET['user_name']) ? htmlspecialchars($_GET['user_name']) : ''; ?>"></br>
            <input type="hidden" name="searched" value="searched">
            <input type="hidden" name="model_id" value="<?php echo isset($_GET['model_id']) ? htmlspecialchars($_GET['model_id']) : ''; ?>">

            <button type="submit">Search</button>
    </form>

<?php
    include('../db.php');
    include('../functions.php');
    
    $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
    $serial_number = isset($_GET['serial_number']) ? $conn->real_escape_string($_GET['serial_number']) : '';
    $expiration = isset($_GET['expiration']) ? $conn->real_escape_string($_GET['expiration']) : '';
    $before_after = isset($_GET['before_after']) ? $conn->real_escape_string($_GET['before_after']) : '';
    $location_type = isset($_GET['location_type']) ? $conn->real_escape_string($_GET['location_type']) : '';
    $location_name = isset($_GET['location_name']) ? $conn->real_escape_string($_GET['location_name']) : '';
    $user_name = isset($_GET['user_name']) ? $conn->real_escape_string($_GET['user_name']) : '';

    $model_id = $_GET["model_id"];
    $flag = FALSE;
    $model_sql = "SELECT * FROM models WHERE id = '$model_id'";
    $model = $conn->query($model_sql)->fetch_assoc();

    $selection = "SELECT i.id, i.serial_number, i.expiration, i.location_id, i.model_id, i.user_id, u.username 
                 FROM items i
                 left join users u on u.id = i.user_id
                 WHERE 1=1";

    if ($model_id != '' AND $model != null) {  
        $selection = $selection . " AND model_id = $model_id"; 
    }
    
    if ($searched !== "") {
        if ($serial_number != '') { 
            $selection = $selection . " AND serial_number LIKE '%$serial_number%'";
        }
        if ($expiration !== "") {
            $selection .= " AND expiration $before_after '$expiration'";
        }
        if ($location_type !== "" && $location_name !== "") {
            $location = $conn->query("SELECT id FROM locations WHERE type = '$location_type' AND name = '$location_name'")->fetch_assoc();
            $location_id = $location['id'];
            $selection .= " AND location_id = '$location_id'";
        }
        if ($user_name !== "") {
            // Handle search for Available vs. usernames that start with 'A...'
            if (strpos('Available', $user_name) !== FALSE) {
                $selection = $selection . " AND ((username IS NULL) OR (username like '%$user_name%'))";
            }
            else {
            $selection = $selection . " AND username  LIKE '%$user_name%'";
            }
        }
    }
    
    $pagination_ctx = initialize_pagination($conn, $selection);

        // Add LIMIT construct for pagination.
        $items = $conn->query($selection . $pagination_ctx["pagination_limit"]); 

        echo"<h2>".$model['name']."</h2>"; // model_name
        echo "<img src='../models/get_image.php?id=" . $model_id . "' width='300' height='300'>";


    // Pagination: Display section, using styles defined at the top of the page.  
    // construct url parameters, preserve search items. filter out empty key,value pairs.
    $search_data = array( 
        "model_id" => $model_id,
        "serial_number" => $serial_number,
        "expiration" => $expiration,
        "before_after" => $before_after,
        "location_type" => $location_type,
        "location_name" => $location_name,
        "searched" => $searched,
        "loaner" => $user_name
    );
    display_pagination($pagination_ctx, "get_item_by_model_id.php", $search_data);

    // Display table
    echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>Serial Number</th><th>Expiration</th><th>Box</th><th>Cabinet</th>
        <th>Shelf</th><th>Cubicle</th><th>Floor</th><th>Customer</th><th>Building</th><th>Reserved</th>
        <th>Status</th><th>Actions</th></tr>";

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
        echo "<td>". $location_array['cubicle'] ."</td>";
        echo "<td>". $location_array['customer'] ."</td>";
        echo "<td>". $location_array['building'] ."</td>";

        $user_id = $row['user_id'];
        if ($user_id === '0') {
            $user_name = 'Available';
            $user_action = 'Loan';
            $disabled = '';   // enable loan button if item available.
        }
        else {
            $user = $conn->query("SELECT username, email from users where id = " . $row['user_id']);
            $user_row = $user->fetch_assoc(); // check for non-zero rows.
            $user_name = $user_row['username'];
            $user_email = $user_row['email'];  // TODO: Use as link to username.
            $user_action = 'Return';
            // only enable return loan if current user is the loaner user
            $disabled = ($user_id !== $_SESSION["user_id"]) ? 'disabled' : '';
        }


        echo "<td><a href='mailto:" . $user_email . "'>" . $user_name ."</td>";
        
        $today = date('Y-m-d');
        if ($row['expiration'] === '0000-00-00' || $today < $row['expiration'])
            echo "<td>Usable</td>";
        else
            echo "<td>Expired</td>";      


         echo "<td class='item_action_group'>
            <form method='POST' action='loan_item.php' class='item_action_button'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='hidden' name='user_action' value='" . $user_action . "'>
                <input type='hidden' name='model_id' value='" . $model_id . "'>
                <button type='submit' $disabled>". $user_action . "</button>
            </form>

            <form method='POST' action='move_item.php' class='item_action_button'>
                <input type='hidden' name='item_id' value='" . $row["id"] . "'>
                <input type='hidden' name='location_id' value='" . $row['location_id'] . "'>
                <button type='submit'>Move</button>
            </form>

             <form method='POST' action='insert_item.php' class='item_action_button'>
                <input type='hidden' name='model_id' value='" . $model_id . "'>
                <input type='hidden' name='expiration' value='" . $row['expiration'] . "'>
                <input type='hidden' name='serial_number' value='" . $row['serial_number'] . "'>
                <input type='hidden' name='location_id' value='" . $row['location_id'] . "'>
                <button type='submit'>Add</button>
            </form>
            
            <form method='POST' action='update_item.php' class='item_action_button'>
                <input type='hidden' name='id' value=" . $row['id'] . ">
                <input type='hidden' name='expiration' value=" . $row['expiration'] . ">
                <input type='hidden' name='serial_number' value=" . $row['serial_number'] . ">
                <input type='hidden' name='model_id' value=" . $model_id . ">
                <button type='submit'>Edit</button>
            </form>

             <form method='POST' action='delete_item.php' class='item_action_button' onsubmit=\"return confirm('Are you sure you want to delete this item?');class='item_action_button'\">
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='hidden' name='model_id' value='" . $model_id . "'>
                <button type='submit'>Delete</button>
            </form></td>";
        echo "</tr>";
    }
    echo '</table>';

    echo "<br><form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Full Inventory</button><br><br>
                </form>";
    $conn->close();

    ?>
    </body>
</html>