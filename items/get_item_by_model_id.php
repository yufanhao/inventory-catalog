<?php
session_start();
require_once('../db.php');
?>

<html>
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
            Number(i.e. box number, etc): <input type="number" name = "number" placeholder = "Search items..." value =
                "<?php echo isset($_GET['number']) ? htmlspecialchars($_GET['number']) : ''; ?>"><br>
            Loaner: <input type="text" name="username" placeholder = "Search items..." value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>"><br>
            <input type="hidden" name="searched" value="searched">
            <input type="hidden" name="model_id" value="<?php echo isset($_GET['model_id']) ? htmlspecialchars($_GET['model_id']) : ''; ?>">
            <br><button type="submit">Search</button>
        </form>

<?php
    include('../functions.php');
    
    $searched = isset($_GET['searched']) ? $conn->real_escape_string($_GET['searched']) : '';
    $serial_number = isset($_GET['serial_number']) ? $conn->real_escape_string($_GET['serial_number']) : '';
    $expiration = isset($_GET['expiration']) ? $conn->real_escape_string($_GET['expiration']) : '';
    $before_after = isset($_GET['before_after']) ? $conn->real_escape_string($_GET['before_after']) : '';
    $location_type = isset($_GET['location_type']) ? $conn->real_escape_string($_GET['location_type']) : '';
    $location_number = isset($_GET['number']) ? $conn->real_escape_string($_GET['number']) : '';
    $username = isset($_GET['username']) ? $conn->real_escape_string($_GET['username']) : '';

    $model_id = $_GET["model_id"];
    $user_id = $_GET['user_id'];

    $flag = FALSE;
    $model_sql = "SELECT * FROM models WHERE id = '$model_id'";
    $model = $conn->query($model_sql)->fetch_assoc();

    $selection = "SELECT * FROM items WHERE 1=1";
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
        if ($location_type !== "" && $location_number !== "") {
            $location = $conn->query("SELECT id FROM locations WHERE type = '$location_type' AND number = '$location_number'")->fetch_assoc();
            $location_id = $location['id'];
            $selection .= " AND location_id = '$location_id'";
        }
        if ($username !== "") {
            //TODO: use strpos() for like %available%, but also need to allow for users like 'A%"
            if ($username === 'Available') {
                $user_id = 0;
                $selection .= " AND user_id = 0";
            }
            else {
                $user_sql = "SELECT id FROM users WHERE username like '%$username%'";
                $user = $conn->query($user_sql)->fetch_assoc();

            //  TODO:
            // issue1: 'u' filters AHamiroune but not user2.
            // issue2: 'z' filters everything.
             //if ($user->num_rows > 0) {
               //     $user_id = $user['id'];
                 //   $selection .= " AND user_id like '%$user_id%'";
     //   }
        }  
            }
            
    }

    $items = $conn->query($selection); // this is the base query;
    // at this point, $items has the final sql to execute include $model_id from url, and other values from filter form.

    echo"<h2>".$model['name']."</h2>"; // model_name
    echo "<img src='../models/get_image.php?id=" . $model_id . "' width='150' height='150'>";

    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Serial Number</th><th>Expiration</th>          <th>Box</th><th>Cabinet</th><th>Shelf</th><th>Floor</th><th>Reserved</th><th>Actions</th></tr>";
    while ($row = $items->fetch_assoc()) {
        $location_id = $row['location_id'];
        $location_array = get_location($conn, $location_id);
        
        echo "<tr>";
        echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['serial_number'] ."</td>";
        echo "<td>" . $row['expiration'] ."</td>";
        echo "<td>" . $location_array['box'] . "</td>";
        echo "<td>" . $location_array['cabinet'] ."</td>";
        echo "<td>" . $location_array['shelf'] ."</td>";
        echo "<td>" . $location_array['floor'] ."</td>";

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
        
        
        echo "<td>
            <form method='POST' action='loan_item.php'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='hidden' name='user_action' value='" . $user_action . "'>
                <input type='hidden' name='model_id' value='" . $model_id . "'>
                <button type='submit' $disabled>". $user_action . "  Item</button>
            </form>

            <form method='POST' action='delete_item.php' onsubmit=\"return confirm('Are you sure you want to delete this item?');\">
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='hidden' name='model_id' value='" . $model_id . "'>
                <button type='submit'>Delete Item</button>
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