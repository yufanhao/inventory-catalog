<html>
<?php
include '../db.php';
include '../functions.php';

function renderForm($conn, $item_id, $location_id, $current_id) {
    $location_array = getImmediateChildLocationIds($conn, $current_id);
    // Get current location info
    $location = $conn->query("SELECT * FROM locations WHERE id = $location_id")->fetch_assoc();
    if (!$location) {
        echo "Location with ID $location_id does not exist.";
        exit();
    }
    echo "<h2>Move Item</h2>";
    echo "<h3>Current Location: " . htmlspecialchars($location['type']) . " " . htmlspecialchars($location['name']) . "</h3>";

    echo "<form method='POST' action='move_item.php'>";
    echo "<label>Move to Location:</label><br>";
    echo "<select name='current_id' id='current_id' onchange='updateSubmitted()'>";
    echo "<option value='$current_id'>Current Location</option>";
    // echo "<option value=''>Other locations inside current location: </option>";
    foreach ($location_array as $loc_id) {
        $loc = $conn->query("SELECT * FROM locations WHERE id = $loc_id")->fetch_assoc();
        echo "<option value='" . $loc['id'] . "'>" . htmlspecialchars($loc['type']) . " " . htmlspecialchars($loc['name']) . "</option>";
    }
    echo "</select><br><br>";
    echo "<input type='hidden' name='item_id' value='" . htmlspecialchars($item_id) . "'>";
    echo "<input type='hidden' name='location_id' value='" . htmlspecialchars($location_id) . "'>";
    echo "<input type='hidden' name='submitted' id='submitted' value=''>";
    echo "<input type='submit' value='Move Item'>";
    echo "</form>";
}

if (!isset($_POST['submitted']) || $_POST['submitted'] !== '1') {
    $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
    $location_id = isset($_POST['location_id']) ? $_POST['location_id'] : 0;
    $current_id = isset($_POST['current_id']) ? $_POST['current_id'] : 0;

    if (empty($item_id) || empty($location_id)) {
        echo "Item ID and Location ID are required.";
        exit();
    }
    renderForm($conn, $item_id, $location_id, $current_id);
} else {
    $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
    $new_location_id = isset($_POST['current_id']) ? $_POST['current_id'] : '';


    if (empty($item_id) || empty($new_location_id)) {
        echo "Item ID and new Location ID are required.";
        exit();
    }

    $sql = "UPDATE items SET location_id = '$new_location_id' WHERE id = '$item_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Item moved successfully.";
    } else {
        echo "Error moving item: " . $conn->error;
    }
}
?>
<script>
function updateSubmitted() {
    var dropdown = document.getElementById("current_id");
    var submittedInput = document.getElementById("submitted");
    var selectedValue = dropdown.value;

    // Replace with PHP echo if needed to dynamically set current location
    var currentLocationId = "<?php echo $current_id; ?>";

    if (selectedValue == currentLocationId) {
        submittedInput.value = "1";
    } else {
        submittedInput.value = ""; // Remove value, so it's not submitted
    }
}
</script>

</html>
